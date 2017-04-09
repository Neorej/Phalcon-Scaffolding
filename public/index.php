<?php
use Phalcon\Di\FactoryDefault;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH.'/app');

try
{
    // Include Composer autoloader
    require(BASE_PATH.'/vendor/autoload.php');

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    // Handle routes
    include APP_PATH.'/config/router.php';

    // Read services
    include APP_PATH.'/config/services.php';

    //Get config service for use in inline setup below
    $config = $di->getConfig();

    if($config->settings->developer)
    {
        $pluginManager = new \Fabfuel\Prophiler\Plugin\Manager\Phalcon($di->getProfiler());
        $pluginManager->register();
    }

    //Include Phalcon autoloader
    require(APP_PATH.'/config/loader.php');

    // Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

    if($config->settings->developer)
    {
        // Initialize and register the profiler toolbar
        $toolbar = new \Fabfuel\Prophiler\Toolbar($di->getProfiler());
        $toolbar->addDataCollector(new \Fabfuel\Prophiler\DataCollector\Request());
        echo $toolbar->render();
        // Set toolbar links to javascript: to prevent basehref shenanigans
        echo '<script>for(let e of $("#prophiler a"))$(e).attr("href","javascript:")</script>';
    }
}
catch(\Exception $e)
{
    echo $e->getMessage().'<br>';
    echo '<pre>'.$e->getTraceAsString().'</pre>';
}
