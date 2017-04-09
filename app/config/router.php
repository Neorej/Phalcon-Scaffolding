<?php
use Phalcon\Mvc\Router;

$router = new Router();

// Strip trailing slashes
$router->removeExtraSlashes(true);

// Use $_SERVER["REQUEST_URI"] to determine the route
$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

$router->notFound(
    [
        'controller' => 'index',
        'action'     => 'notFound',
    ]
);


return $router;
