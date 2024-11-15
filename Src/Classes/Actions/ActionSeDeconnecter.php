<?php

namespace nrv\Actions;

class ActionSeDeconnecter extends Action {
    public function execute() : string {
        $html .= "<div id='filter'>";
        $html = "<a>Vous avez été déconnecté avec succès</a></br></br>";
        $html .= "<a href ='?action=default'>Retour au menu principal</a></div>";

        $_SESSION['user']['email'] = "";

        return $html;
    }
}