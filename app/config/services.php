<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\View\Simple as SimpleView;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * Shared configuration service
 */
$di->setShared('config', function ()
{
    return require APP_PATH.'/config/config.php';
});

/**
 * Load the
 */
$di->setShared('router', function() {
    return require  APP_PATH.'/config/router.php';
});

/**
 * Create a "default" event manager
 */
$di->setShared('eventsManager', function ()
{
    return new EventsManager();
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function ()
{
    $config = $this->getConfig();

    $url = new UrlResolver();

    $url->setBaseUri($config->application->basePath);

    return $url;
});

/**
 * Setting up the dispatcher
 */
$di->set('dispatcher', function()
{
    $eventsManager = $this->getEventsManager();
    
    // Redirect to 404 page if the controller or action does not exist
    $eventsManager->attach('dispatch:beforeException',
        function($event, $dispatcher, $exception)
        {
            switch($exception->getCode())
            {
                default:
                    return true;
                case Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward([
                        'controller' => 'index',
                        'action'     => 'notFound'
                    ]);
                    return false;
            }
        }
    );
    
    $eventsManager->attach('dispatch:beforeExecuteRoute', new \Forms\FormBase());

    // Create dispatcher
    $dispatcher = new MvcDispatcher();

    // Add the dispatcher to the default events manager
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
}, true);

/**
 * Setting up the view component
 */
$di->setShared('view', function ()
{
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt'  => function ($view)
        {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath'      => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);

            return $volt;
        }
    ]);

    // Add the view to the default events manager
    $view->setEventsManager($this->getEventsManager());

    return $view;
});

/**
 * Setting up the view component
 */
$di->setShared('simpleView', function ()
{
    $config = $this->getConfig();

    $view = new SimpleView();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt'  => function ($view)
        {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath'      => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);

            return $volt;
        }
    ]);

    // DO NOT add the view to the default events manager
    // We do not want simpleviews to trigger Prophiler events
    // $view->setEventsManager($this->getEventsManager());

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function ()
{
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\'.$config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if($config->database->adapter == 'Postgresql')
    {
        unset($params['charset']);
    }

    $connection = new $class($params);

    $connection->setEventsManager($this->getEventsManager());

    return $connection;
});

/**
 * If the configuration specifies the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function ()
{
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function ()
{
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component requests the session service
 */
$di->setShared('session', function ()
{
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Set up the Prophiler profiler
 */
$di->setShared('profiler', function ()
{
    return new \Fabfuel\Prophiler\Profiler();
});
/**
 * ...and the Prophiler logger
 * (Implements psr/log)
 */
$di->setShared('logger', function ()
{
    return new \Fabfuel\Prophiler\Adapter\Psr\Log\Logger($this->getProfiler());
});

/**
 * Set up Swiftmailer
 */
$di->setShared('mail', function () use ($di) 
{
    return new \Library\Mail($di->get('config')->mail);
});

/**
 * Set up faker service
 */
$di->setShared('faker', function ()
{
    return Faker\Factory::create();
});

/**
 * Extend the Phalcon response class
 */
$di->setShared('response', function () use ($di)
{
    return new \Library\Response($di);
});