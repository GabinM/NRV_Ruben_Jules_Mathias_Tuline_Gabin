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
            $html .= "<a>{$arr['nomSoiree']}</a></br>";
            $html .= "<a>{$arr['theme']}</a></br>";
            $html .= "<a>le {$arr['date']}</a></br>";
            $html .= "<a>{$arr['tarif']}€ par personne</a></br>";
            $html .= "<a>{$arr['descriptionSoiree']}</a></br>";

            $html .= "<a>Spectacles inclus dans cette soirée</a></br>";

            $soirray = $bd->findSpectacleBySoiree($_REQUEST['soiree_id']);
            foreach($soirray as $s){
                $html .= "<a href='?action=display-spectacle&id_spectacle={$s['idSpectacle']}'>{$s['titre']} par {$s['nomsArtistes']}</a></br>";
            }
        }

        return $html;

    }
}