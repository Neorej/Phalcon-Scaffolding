<?php
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ? : realpath(dirname(__FILE__).'/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH.'/app');

date_default_timezone_set('Europe/Amsterdam');
setlocale(LC_TIME, 'nl_NL.utf8');

$config = [
    'database' => [
        'adapter'  => 'Mysql',
        'host'     => '',
        'username' => '',
        'password' => '',
        'dbname'   => '',
        'charset'  => 'utf8',
    ],
    'application' => [
        'basePath'       => '',
        'appDir'         => APP_PATH.'/',
        'controllersDir' => APP_PATH.'/controllers/',
        'modelsDir'      => APP_PATH.'/models/',
        'libraryDir'     => APP_PATH.'/library/',
        'formsDir'       => APP_PATH.'/forms/',
        'migrationsDir'  => APP_PATH.'/migrations/',
        'viewsDir'       => APP_PATH.'/views/',
        'pluginsDir'     => APP_PATH.'/plugins/',
        'cacheDir'       => BASE_PATH.'/cache/',
        
        // This allows the baseUri to understand project paths that are not in the root directory
        // of the webspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ],
    'namespaces' =>[
        'Forms'     => APP_PATH.'/forms/',
        'Library'   => APP_PATH.'/library/',
    ],
    'settings' => [
        'developer' => false
    ],
    'website'  => [
        'name' => '',
    ],
    'mail' => [
        'Host'      => '',
        'Port'      => '',
        'Username'  => '',
        'Password'  => '',
        'Sender'    => '',
        'From'      => '',
        'FromName'  => '',
    ]
];


if(file_exists(__DIR__.'/config.env.php'))
{
    include(__DIR__.'/config.env.php');
}

return new \Phalcon\Config($config);