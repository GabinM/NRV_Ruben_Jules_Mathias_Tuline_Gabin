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

//lier le fichier de configuration à notre DeefyRepository
\nrv\Repository\NRVRepository::setConfig('conf.ini');

$d->run();