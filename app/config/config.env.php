<?php
    $config['database']['host']         = 'localhost';
    $config['database']['username']     = 'root';
    $config['database']['password']     = 'dev01dev';
    $config['database']['dbname']       = 'phalcon_database';

    $config['application']['basePath']  = 'http://localhost/';

    $config['settings']['developer']    = true;
    
    $config['mail']['Host']     = 'smtp.mailtrap.io';
    $config['mail']['Port']     = 2525;
    $config['mail']['Username'] = '6d31303f7084f8';
    $config['mail']['Password'] = '64d521c7f02082';
    $config['mail']['Sender']   = 'test@example.com';
    $config['mail']['From']     = 'test@example.com';
    $config['mail']['FromName'] = 'Test';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
