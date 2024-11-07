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
            if($this->request_method == "GET"){
                $html .= "<form method='POST' action='?action=register-user'>";
                $html .="<label >Adresse mail :</label></br>";
                $html .= "<input type='text' name='mail'></br></br>";
                $html .="<label >Mot de passe :</label></br>";
                $html .= "<input type='text' name='mdp'></br></br>";
                $html .="<label >Veuillez entre le mot de passe à nouveau</label></br>";
                $html .= "<input type='text' name='mdp2'></br></br>";
                $html .= "<input type='submit' value = 'Enregistrer cet utilisateur'>";
            } else {
                
            }
        }
    }

}