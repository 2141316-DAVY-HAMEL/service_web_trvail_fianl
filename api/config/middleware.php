<?php

use App\Factory\LoggerFactory;
use App\Middleware\CorsMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    // Log enpoint access

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(TwigMiddleware::class);

    // Permettre les CORS
    $app->add( CorsMiddleware::class);
    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Add app base path
    $app->add(BasePathMiddleware::class);

    // Catch exceptions and errors
    $loggerFactory = $app->getContainer()->get( LoggerFactory::class);
    $logger = $loggerFactory->addFileHandler('error.log')->createLogger();
    $app->addErrorMiddleware(true, true, true, $logger);
};
