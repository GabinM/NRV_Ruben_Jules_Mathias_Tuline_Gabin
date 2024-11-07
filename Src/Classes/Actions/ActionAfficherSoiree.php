<?php

namespace nrv\Actions;

class ActionAfficherSoiree extends Action {
    public function execute() : string{

        if(isset($_REQUEST['soiree_id'])){
            $arr = \nrv\Repository\NRVRepository::getInstance()->getSoiree($_REQUEST['soiree_id']);
        }

    }
}