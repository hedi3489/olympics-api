<?php

declare(strict_types=1);

use App\Core\CustomErrorHandler;
use App\Middleware\HelloMiddleware;
use App\Middleware\ContentNegotiationMiddleware;
use Slim\App;

return function (App $app) {
    // Add your middleware here.
    $app->addMiddleware(new HelloMiddleware);
    $app->addMiddleware(new ContentNegotiationMiddleware);
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();

    //!NOTE: the error handling middleware MUST be added last.
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->getDefaultErrorHandler()->forceContentType(APP_MEDIA_TYPE_JSON);

    // Create the custom error handler to be used for handling runtime errors.
    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $errorHandler = new CustomErrorHandler($callableResolver, $responseFactory);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
};
