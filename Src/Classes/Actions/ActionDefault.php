<?php

namespace nrv\Actions;

use nrv\Exceptions\AuthzException;
use DOMDocument;

class ActionDefault extends Action {
    /**
     * @throws AuthzException
     */
    public function execute() : string {

        $html = "";
        $user = $_SESSION['user']['email'];
        $role = \nrv\auth\Authz::checkRole();
        $html .= "<a href='?action=display-all-soiree'> Afficher toutes les soirées </a></br></br></br>";
        $html .= "<a href='?action=display-all-spec'> Afficher tous les spectacles </a></br></br></br>";

        if (($role == 1) || ($role == 2)) {
            $html .= "<a href='?action=link-spectacle-soiree'> Lier un spectacle à une soirée </a></br></br></br>";
            $html .= "<a href='?action=create-spectacle'> Créer un spectacle </a></br></br></br>";
            $html .= "<a href='?action=create-soiree'> Créer une soirée </a></br></br></br>";
            $html .= "<a href='?action=register-user'> Enregistrer un nouvel utilisateur </a></br></br></br>";
        }


        

        return $html;
    }
}