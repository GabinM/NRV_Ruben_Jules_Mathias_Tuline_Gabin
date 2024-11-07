<?php

namespace nrv\Actions;
use nrv\Exceptions\AuthzException;

class ActionSeConnecter extends Action{
    /**
     * @throws AuthzException
     * @throws \Exception
     */
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
            $html .= "</br></br><a href='?action=default'> Retourner au menu </a>";
        } else {
            try{
                echo $_POST['email'];
                echo '</br>';
                \nrv\Auth\AuthProvider::signin($_POST['email'], $_POST['mdp']);
                $_SESSION['user']['email'] = $_POST['email'];
                $html .= "<a>Connexion réussie, bonjour {$_POST['email']} !</a></br>";
            } catch (AuthzException $e){
                echo $e->getMessage();
                $html .= "<a>email ou mot de passe incorrect</a>";
                $html .= "</br></br><a class='adminc{$bool}' id='choice' href='?action=sign-in'>Réessayer</a>";
            } catch (\Exception $e2) {
                $html .= "<a>email ou mot de passe incorrect</a>";
                $html .= "</br></br><a class='adminc{$bool}' id='choice' href='?action=sign-in'>Réessayer</a>";
            }
            $html .= "</br></br><a href='?action=default'> Retourner au menu </a>";

        }

        return $html;
    }
}


