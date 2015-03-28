<?php

$loader = require_once __DIR__.'/../vendor/autoload.php';
$loader->add('App', '..');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Question;

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
	$questionValue = $request->get('question');
	$options = $request->get('options');
	// Remove the last element of the options array as it will always be blank.
	array_pop($options);

	$question = new Question($app['db']);
	$question->create($questionValue);
	// @todo, need to add the options into the database.

	return $app->redirect('/');
});

$app->run();