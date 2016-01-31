<?php

require('../vendor/autoload.php');
require('models/models.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));


// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  $persona = new persona();
 
  return $app['twig']->render('index.twig', array("saludo"=>$persona->getEndPoint(), "titulo"=>"Persona"));
});

$app->get('/login', function() use($app){
	$app['monolog']->addDebug("login");

	return $app['twig']->render("login.twig", array("titulo"=>"login"));
});

$app->post("/login", function() use($app) {
	
	return $app['twig']->render("login_data.twig", array("titulo"=>"login data", "datos"=>$_POST));
});
$app->run();
