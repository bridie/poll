<?php

$loader = require_once __DIR__.'/../vendor/autoload.php';
$loader->add('App', '..');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Poll;

$app = new Silex\Application();
$app['debug'] = true;

// Register service providers.
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbname' => 'poll',
        'user' => 'root',
        'host' => '127.0.0.1',
        'password' => ''
    ),
));
$GLOBALS['database'] = $app['db'];

$app->get('/', function () use ($app) {
    return $app['twig']->render('create.twig', array(
    ));
});

$app->post('/create', function (Request $request) use ($app) {
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
    ));
});

$app->run();
