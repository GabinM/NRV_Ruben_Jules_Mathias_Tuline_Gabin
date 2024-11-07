<?php

namespace nrv\Auth;

class AuthProvider{
    
    public static function signin($addr, $mdp){
        $conn = \nrv\Repository\NRVRepository::getInstance()->getDb();

        $query = $conn->prepare("select hashmdp from utilisateur where email = ? ;");
        $query->bindParam(1,$addr);
        $query->execute();

        $pwd = $query->fetch(PDO::FETCH_ASSOC)["hashmdp"];

        if (! password_verify($mdp,$pwd)){
            throw new \nrv\Exception\AuthzException("identifiant ou mot de passe invalide");
        }
    }

    /**
     * @throws AuthnException
     */
    public static function register($addr, $mdp){
        if (strlen($mdp) < 10 ){
            throw new \spautify\exception\AuthnException("mot de passe trop faible");
        }
        $conn = \spautify\repository\SpautifyRepository::getInstance()->getDb();

        $query = $conn->prepare("select * from utilisateur where email = ? ;");
        $query->bindParam(1,$addr);
        $query->execute();

        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($res) != 0) {
            throw new \spautify\exception\AuthnException("un utilisateur utilise déjà cette adresse");
        }


        $query2 = $conn->prepare("insert into utilisateur (email,hashmdp,role) values (?,?,1)");
        $query2->bindParam(1,$addr);
        $mdp2 = password_hash($mdp,PASSWORD_DEFAULT);
        $query2->bindParam(2,$mdp2);
        $query2->execute();
    }

}