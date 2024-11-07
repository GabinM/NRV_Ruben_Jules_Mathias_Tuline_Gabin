<?php

require 'vendor\autoload.php';

if(! isset($_SESSION)){
    session_start();
}

if(isset($_REQUEST['action'])){
    $d = new \spautify\Dispatcher($_REQUEST['action']);
} else {
    $d = new \spautify\Dispatcher("default");
}

$d->run();

echo "<p>NRV</p>";