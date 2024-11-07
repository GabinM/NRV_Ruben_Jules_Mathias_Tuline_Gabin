<?php

require_once 'vendor\autoload.php';

if(! isset($_SESSION)){
    session_start();
}

if(isset($_REQUEST['action'])){
    $d = new \nrv\Dispatcher\Dispatcher($_REQUEST['action']);
} else {
    $d = new \nrv\Dispatcher\Dispatcher("default");
}

$d->run();