<?php

namespace nrv\Actions;

class ActionAfficherSoiree extends Action {
    public function execute() : string{

        $html = "";

        if(isset($_REQUEST['soiree_id'])){
            $arr = \nrv\Repository\NRVRepository::getInstance()->findSoiree($_REQUEST['soiree_id']);
            $html .= "<a>{$arr['titre']}</a>";
            $html .= "<a>{$arr['theme']}</a>";
            $html .= "<a>le {$arr['date']}</a>";
            $html .= "<a>{$arr['tarif']}€ par personne</a>";
            $html .= "<a>{$arr['description']}</a>";
        }

    }
}