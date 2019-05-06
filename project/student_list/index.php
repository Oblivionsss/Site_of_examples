<?php

    // FRONT PAGE//


    ini_set('display_errors', 1);       
    error_reporting(E_ALL);
    define('ROOT', dirname(__FILE__));

    
    // Include Database and router URI// 
    require_once(ROOT.'/config/Autoload.php');
    spl_autoload_register('my_autoload');
    // require_once(ROOT.'/components/Db.php');
    // require_once(ROOT.'/components/Router.php');
    
    $obj1    = new Router;
    $obj1->run();

