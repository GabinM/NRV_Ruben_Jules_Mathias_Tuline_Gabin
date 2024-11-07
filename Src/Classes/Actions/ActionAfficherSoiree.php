<?php

namespace nrv\Actions;

class ActionAfficherSoiree extends Action {
    public function execute() : string{

        $html = "";

        if(isset($_REQUEST['soiree_id'])){
            $bd = \nrv\Repository\NRVRepository::getInstance();
            $arr = $bd->findSoiree($_REQUEST['soiree_id']);
            if(sizeof($arr) < 1){
                return "<a>Aucune soirée n'a été trouvée</a>";
            }
            $html .= "<a>{$arr['titre']}</a>";
            $html .= "<a>{$arr['theme']}</a>";
            $html .= "<a>le {$arr['date']}</a>";
            $html .= "<a>{$arr['tarif']}€ par personne</a>";
            $html .= "<a>{$arr['description']}</a>";

            $html .= "<a>Spectacles inclus dans cette soirée</a>";

            $soirray = $bd->findSpectacleBySoiree($_REQUEST['soiree_id']);
            foreach($soirray as $s){
                $html .= "<a href='?action=display-spectacle&id_spectacle={$s['id']}'>{$s['titre']} par {$s['artistes']}</a>";
            }
        }

        return $html;

    }
}