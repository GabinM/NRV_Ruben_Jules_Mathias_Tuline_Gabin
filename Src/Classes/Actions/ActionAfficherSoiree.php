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
            $html .= "<a>{$arr['NomSoiree']}</a></br>";
            $html .= "<a>{$arr['Theme']}</a></br>";
            $html .= "<a>le {$arr['Date']}</a></br>";
            $html .= "<a>{$arr['Tarif']}€ par personne</a></br>";
            $html .= "<a>{$arr['DescriptionSoiree']}</a></br>";

            $html .= "<a>Spectacles inclus dans cette soirée</a></br>";

            $soirray = $bd->findSpectacleBySoiree($_REQUEST['soiree_id']);
            foreach($soirray as $s){
                $html .= "<a href='?action=display-spectacle&id_spectacle={$s['idSpectacle']}'>{$s['Titre']} par {$s['NomArtistes']}</a></br>";
            }
        }

        return $html;

    }
}