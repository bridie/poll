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

$app->get('/', function () use ($app) {
    return $app['twig']->render('create.twig', array(
    ));
});

$app->post('/create', function (Request $request) use ($app) {
	$question = $request->get('question');
	$options = $request->get('options');
	// Remove the last element of the options array as it will always be blank.
	array_pop($options);

	$poll = new Poll($question, $options, $app['db']);
    $poll->create();

	return $app->redirect('/');
});

$app->run();