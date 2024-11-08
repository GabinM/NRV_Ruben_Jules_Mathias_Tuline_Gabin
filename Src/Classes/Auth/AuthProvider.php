<?php

namespace nrv\Auth;

use nrv\Exceptions\AuthzException;
use nrv\repository\NRVRepository;
use PDO;

class AuthProvider{

    /**
     * @throws AuthzException
     */
    public static function signin($addr, $mdp){
        $conn = NRVRepository::getInstance()->getDb();

        $query = $conn->prepare("select hashmdp from utilisateur where email = ? ;");
        $query->bindParam(1,$addr);
        $query->execute();

        $query2 = $conn->prepare("select count(*) from utilisateur where email = ? ;");
        $query2->bindParam(1,$addr);
        $query2->execute();
        $query3 = ($query2->fetch(PDO::FETCH_ASSOC)["count(*)"]);

        if ($query3 === 0){
            throw new AuthzException("identifiant ou mot de passe invalide");
        }

        $pwd = $query->fetch(PDO::FETCH_ASSOC)["hashmdp"];


        if (!password_verify($mdp,$pwd)){
            throw new AuthzException("identifiant ou mot de passe invalide");
        }
    }

    /**
     * @throws AuthzException
     */
    public static function register($addr, $mdp){
        if (strlen($mdp) < 10 ){
            throw new AuthzException("mot de passe trop faible");
        }
        $conn = NRVRepository::getInstance()->getDb();

        $query = $conn->prepare("select * from utilisateur where email = ? ;");
        $query->bindParam(1,$addr);
        $query->execute();

        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($res) != 0) {
            throw new AuthzException("un utilisateur utilise déjà cette adresse");
        }


        $query2 = $conn->prepare("insert into utilisateur (email,hashmdp,role) values (?,?,1)");
        $query2->bindParam(1,$addr);
        $mdp2 = password_hash($mdp,PASSWORD_DEFAULT);
        $query2->bindParam(2,$mdp2);
        $query2->execute();
    }

}