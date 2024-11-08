<?php

namespace nrv\Auth;

use nrv\Exceptions\AuthzException;
use PDO;

class Authz {

    /**
     * @throws AuthzException
     */
    public static function checkRole() {//retourne 0, 1 ou 2 en fonction des droits
        $hash = $_SESSION['user']['email'];
        if($hash == ""){
            return 0; //droits basiques
        } else {
            $bd = \nrv\Repository\NRVRepository::getInstance()->getDb();

            $rlQuery = $bd->prepare("select role from utilisateur where email = ? ;");
            $rlQuery->bindparam(1,$hash);
            $rlQuery->execute();

            $query2 = $bd->prepare("select count(*) from utilisateur where email = ? ;");
            $query2->bindParam(1,$_SESSION['user']['email']);
            $query2->execute();
            $query3 = ($query2->fetch(PDO::FETCH_ASSOC)["count(*)"]);

            if ($query3 === 0){
                throw new AuthzException("identifiant ou mot de passe invalide");
            }

            try{
                $bdRl = $rlQuery->fetch(PDO::FETCH_ASSOC)['role'];
            } catch (\Exception $e){
                throw new \nrv\Exceptions\AuthzException("Erreur d'authentification");
            }


            return $bdRl; // 1 : organisateur, 2 : admin

        }
        
    }

}