<?php

namespace nrv\Actions;

class ActionSeDeconnecter extends Action {
    public function execute() : string {
        $html = "<a>Vous avez été déconnecté avec succès</a></br></br>";
        $html .= "<a href ='?action=default'>Retour au menu principal</a>";

        $_SESSION['user']['email'] = "";

        return $html;
    }
}