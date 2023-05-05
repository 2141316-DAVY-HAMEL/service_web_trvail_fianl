<?php

use App\Action\CleApiAction;
use App\Action\Docs\SwaggerUiAction;
use App\Action\HomeAction;
use App\Action\Poutine\PoutineCreateAction;
use App\Action\Poutine\PoutineDeleteAction;
use App\Action\Poutine\PoutineUpdateAction;
use App\Action\Poutine\PoutineViewAction;
use App\Middleware\CleApiMiddleware;
use Slim\App;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

return function (App $app) {

	$app->get('/', HomeAction::class)->setName('home');

	// Documentation de l'api
	$app->get('/docs', SwaggerUiAction::class);

	// Cle API
	$app->get('/cle', CleApiAction::class);

	// Poutine
	$app->get('/poutine', PoutineViewAction::class)->add( CleApiMiddleware::class);
	$app->post('/poutine', PoutineCreateAction::class)->add( CleApiMiddleware::class);
	$app->put('/poutine/{id}', PoutineUpdateAction::class)->add( CleApiMiddleware::class);
	$app->delete('/poutine/{id}', PoutineDeleteAction::class)->add( CleApiMiddleware::class);

};

