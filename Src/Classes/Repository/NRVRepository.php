<?php

namespace NRV\Repository;

use PDO;

class NRVRepository
{

    private $pdo;

    public function __construct()
    {
        $config = parse_ini_file('db.config.ini');

        if (!$config || !isset($config['host'], $config['dbname'], $config['user'], $config['password'])) {
            die("Fichier de configuration manquant ou incomplet.");
        }
    }


}