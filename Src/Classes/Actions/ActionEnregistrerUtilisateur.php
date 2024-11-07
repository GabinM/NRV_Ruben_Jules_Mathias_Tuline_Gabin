<?php

namespace nrv\Actions;


use nrv\Repository\NRVRepository;

class ActionEnregistrerUtilisateur extends Action {
//d'abord faire les fonctions pour s'authentifier et vérifier le rôle

    public function execute() : string {
        
        if(! \nrv\Auth\Authz::checkRole() == 2){
            return new \nrv\Exceptions\AuthzException("Vous n'êtes pas autorisé à enregistrer un nouvel utilisateur");
        } else {
            $html = "";
            
            $html .= "<form method='POST' action='?action=register-user'>";
            $html .="<label >Adresse mail :</label></br>";
            $html .= "<input type='text' name='mail'></br></br>";
            $html .="<label >Mot de passe :</label></br>";
            $html .= "<input type='text' name='mdp'></br></br>";
            $html .="<label >Veuillez entre le mot de passe à nouveau</label></br>";
            $html .= "<input type='text' name='mdp2'></br></br>";
            $html .= "<input type='submit' value = 'Enregistrer cet utilisateur'>";

            if($this->request_method == "POST"){

                if(! isset($_POST['mdp']) || ! isset($_POST['mdp2'])){
                    $html.= "<a>veuillez entrer un mot de passe</a></br>";
                } elseif (!isset($_POST['mail'])){
                    $html.= "<a>veuillez entrer une adresse mail</a></br>";
                } elseif ($_POST['mdp'] != $_POST['mdp2']){
                    $html.= "<a>veuillez entrer une adresse mail</a></br>";
                } elseif (strlen($_POsT['mdp']) < 10){
                    $html.= "<a>mot de passe trop faible</a></br>";
                } else {
                    $bd = \nrv\Repository\NRVRepository()::getInstance()->getDb();
                    $mailQuery = $bd->prepare("select count(*) from utilisateur where email = ? ;");
                    $mailQuery->bindParam(1, $_POST['mail']);
                    $mailQuery->execute();
                    if ($mailQuery->fetch(PDO::FETCH_ASSOC)['count(*)'] > 0){
                        $html.= "<a>Un utilisateur existe déjà à cette adresse mail</a></br>";
                    } else {
                        $query = $bd->prepare("insert into utilisateur (email, hashmdp) values (?, ?) ;");
                        $query->bindParam(1,$_POST['email']);
                        $query->bindParam(2,password_hash($_POST['mdp'], PASSWORD_DEFAULT));
                        $query->execute();

                        $html .= "<a>Utilisateur enregistré avec succès</a>";
                    }
                    
                }
            }
        }
    }

}