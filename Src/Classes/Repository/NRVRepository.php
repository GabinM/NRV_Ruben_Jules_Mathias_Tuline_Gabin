<?php

namespace NRV\Repository;

use PDO;

class NRVRepository
{

    private static SpautifyRepository $sp;
    private static string $CONF;
    private static array $PARAMS;
    private PDO $bd;

    private function __construct(){
        if(!isset($_PARAMS)){
            $this->setConfig("conf.ini");
        }
        $this->bd =  new PDO(self::$PARAMS['driver'].":host=".self::$PARAMS['host']."; dbname=".self::$PARAMS['database']."; charset=utf8", self::$PARAMS['username'],self::$PARAMS['password']);
    }

    public static function setConfig($file){
        self::$CONF = $file;
        self::$PARAMS = parse_ini_file($file);
    }

    public static function getInstance(){
        if(! isset($sp)){
            $sp = new SpautifyRepository();
        }
        return $sp;
    }

    public function getDb(){
        return $this->bd;
    }

}