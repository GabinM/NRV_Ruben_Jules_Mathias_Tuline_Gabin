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


        $html .= "<div id = 'soiree' ><h1>Bienvenue sur le site officiel du Nancy Rock Vibration!</h1></br></br>
            Retrouvez tous les spectacles et toutes les soirées en un clic, et découvrez tout le potentiel du rock
            dans cette <b>première édition du festival NRV !</b>
        
        </div>";
        


        

        return $html;
    }
}