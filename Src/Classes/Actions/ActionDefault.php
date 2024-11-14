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



        


        

        return $html;
    }
}