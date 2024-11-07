<?php

require_once 'vendor\autoload.php';

if(! isset($_SESSION)){
    session_start();
}

//user -> {hash, {soirees}}
//hash: hash du mot de passe pour vérifier les droits d'accès
//{soirees} : liste des soirées/spectacles que l'utilisateur a ajouté en favoris

if(isset($_REQUEST['action'])){
    $d = new \nrv\Dispatcher\Dispatcher($_REQUEST['action']);
} else {
    $d = new \nrv\Dispatcher\Dispatcher("default");
}

$d->run();