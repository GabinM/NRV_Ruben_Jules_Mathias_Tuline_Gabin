<?php

namespace nrv\Actions;

class ActionSeConnecter extends Action{
    public function execute() :string {
        $bool = \nrv\auth\Authz::checkRole();
        $html = "";

        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $html .= "<form method = 'POST' action ='?action=sign-in'></br>";
            $html .= "<label for='email'>Email :</label></br>";
            $html .= "<input type='text' id='email' name='email'></br></br>";
            $html .="<label for='mdp'>Mot de passe :</label></br>";
            $html .= "<input type='text' id='mdp' name='mdp'></br></br>";
            $html .= "<button type = 'submit'>se connecter</button></form></br>";
            $html .= "<a href='?action=add-user'>Pas encore de compte ? Créez en un maintenant !</a></br>";
            $html .= "</br></br><a href='?action=default'> Retourner au menu </a>";
        } else {
            try{
                \nrv\Auth\AuthProvider::signin($_POST['email'], $_POST['mdp']);
                $_SESSION['user'] = serialize(array($_POST['email'], $_POST['mdp']));
                unset($_SESSION['playlist']);
                $html .= "<a>Connexion réussie, bonjour {$_POST['email']} !</a></br>";
            } catch (Exception $e){
                $html .= "<a>email ou mot de passe incorrect</a>";
                $html .= "</br></br><a class='adminc{$bool}' id='choice' href='?action=sign-in'>Réessayer</a>";
            } catch (AuthzException $e2) {
                $html .= "<a>email ou mot de passe incorrect</a>";
                $html .= "</br></br><a class='adminc{$bool}' id='choice' href='?action=sign-in'>Réessayer</a>";
            }
            $html .= "</br></br><a class='adminc{$bool}' id='choice' href='?action=default'> Retourner au menu </a>";

        }

        return $html;
    }
}


