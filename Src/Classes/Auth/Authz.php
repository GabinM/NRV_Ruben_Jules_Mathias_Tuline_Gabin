<?php

namespace nrv\Auth;

use PDO;

class Authz {

    public static function checkRole() {//retourne 0, 1 ou 2 en fonction des droits
        $hash = unserialize($_SESSION['user']['email']);
        if($hash == ""){
            return 0; //droits basiques
        } else {
            $bd = \nrv\Repository\NRVRepository::getInstance()->getDb();

            $rlQuery = $bd->prepare("select role from utilisateur where email = ? ;");
            $rlQuery->bindparam(1,$hash);
            $rlQuery->execute();

            try{
                $bdRl = $rlQuery->fetch(PDO::FETCH_ASSOC)['role'];
            } catch (Exception $e){
                throw new \nrv\Exceptions\AuthzException("Erreur d'authentification");
            }


            return $bdRl; // 1 : organisateur, 2 : admin

        }
        
    }

}