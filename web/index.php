<?php

$loader = require_once __DIR__.'/../vendor/autoload.php';
$loader->add('App', '..');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Poll;
use App\Vote;

$app = new Silex\Application();
$app['debug'] = true;

// Register service providers.
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$database = parse_ini_file('../app/config/database.ini');
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbname' => $database['dbname'],
        'user' => $database['user'],
        'host' => $database['host'],
        'password' => $database['password']
    ),
));
$GLOBALS['database'] = $app['db'];

$app->get('/', function() use ($app) {
    return $app['twig']->render('create.twig', array(
    ));
});

$app->post('/create', function(Request $request) use ($app) {
	$question = $request->get('question');
	$options = $request->get('options');
	// Remove the last element of the options array as it will always be blank.
	array_pop($options);

	$poll = new Poll($question, $options);
    $poll->create();

	return $app->redirect('/' . $poll->getQuestion()->geturlComponent());
});

$app->get('{urlComponent}', function($urlComponent) use ($app) {
    $poll = Poll::getPollFromUrlComponent($urlComponent);
    $question = $poll->getQuestion()->getQuestion();
    foreach ($poll->getOptions() as $option) {
        $options[$option->getId()] = $option->getOption();
    }

    return $app['twig']->render('poll.twig', array(
        'question' => $question,
        'options' => $options,
        'urlComponent' => $urlComponent,
    ));
});

$app->get('{urlComponent}/results', function($urlComponent) use ($app) {
    $poll = Poll::getPollFromUrlComponent($urlComponent);
    $question = $poll->getQuestion()->getQuestion();
    foreach ($poll->getOptions() as $option) {
        $options[$option->getId()] = array(
            'option_value' => $option->getOption(),
            'option_count' => Vote::countVotes($option->getId())['total'],
        );
    }

    return $app['twig']->render('results.twig', array(
        'question' => $question,
        'options' => $options,
    ));
});

$app->post('/votes', function(Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $optionId = $data['optionId'];
    $vote = new Vote($optionId);
    $vote = $vote->create();

    if ($vote) {
        die(json_encode(array(
            'id' => $vote->getId(),
            'optionId' => $vote->getOptionId()
        )));
    } else {
        die(json_encode(array()));
    }
});

$app->get('/votes/{id}', function($id) use ($app) {
    $vote = Vote::getVoteFromId($id);

    if ($vote) {
        die(json_encode(array(
            'id' => $vote->getId(),
            'optionId' => $vote->getOptionId()
        )));
    } else {
        die(json_encode(array()));
    }
});

$app->delete('/votes/{id}', function($id) use ($app) {
    $vote = Vote::getVoteFromId($id);
    $vote->delete();
    die(json_encode(array()));
});

$app->run();
