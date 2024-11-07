<?php

namespace nrv\Auth;

class Authz {

    public static function checkRole() {//retourne 0, 1 ou 2 en fonction des droits
        $hash = unserialize($_SESSION['user'])['hash'];
        if( $hash == ""){
            
            return 0; //droits basiques
        } else {
            $bd = \spautify\repository\SpautifyRepository::getInstance()->getDb();

            $rlQuery = $bd->prepare("select role from utilisateur where hashmdp = ? ;");
            $rlQuery->bindparam(1,$hash);
            $rlQuery->execute();

            try{
                $bdRl = $rlQuery->fetch(PDO::FETCH_ASSOC)['role'];
            } catch (Exception $e){
                throw new AuthzException("Erreur d'authentification");
            }


            return $bdRl; // 1 : organisateur, 2 : admin

        }
        
    }

}