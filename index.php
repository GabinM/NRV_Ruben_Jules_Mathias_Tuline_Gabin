<?php

require_once 'vendor\autoload.php';

if(! isset($_SESSION)){
    session_start();
    $_SESSION['user']['email'] = serialize("emilie.riviere@mail.com"); //truc temporaire pour avoir les droits admin
}


//user -> {hash, {soirees}}
//hash: hash du mot de passe pour vérifier les droits d'accès
//{soirees} : liste des soirées/spectacles que l'utilisateur a ajouté en favoris

if(isset($_REQUEST['action'])){
    $d = new \nrv\Dispatcher\Dispatcher($_REQUEST['action']);
} else {
    $d = new \nrv\Dispatcher\Dispatcher("default");
}

//lier le fichier de configuration à notre DeefyRepository
\nrv\Repository\NRVRepository::setConfig('conf.ini');

$d->run();