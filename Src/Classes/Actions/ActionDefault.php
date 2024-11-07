<?php

namespace nrv\Actions;

class ActionDefault extends Action {
    public function execute() : string {
        $html = "<a href='?action=display-soiree'> Afficher une soirée </a></br></br></br>";
        $html .= "<a href='?action=display-all-soiree'> Afficher toutes les soirées </a></br></br></br>";
        $html .= "<a href='?action=create-soiree'> Créer une soirée </a></br></br></br>";

        return $html;
    }
}