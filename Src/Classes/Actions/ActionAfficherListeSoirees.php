<?php

namespace nrv\Actions;

class ActionAfficherListeSoirees extends Action {
    public function execute() : string{

        $html = "";

        if(isset($_REQUEST['soiree_id'])){
            $bd = \nrv\Repository\NRVRepository::getInstance();
            $arr = $bd->findListSoiree();
            if(sizeof($arr) < 1){
                return "<a>Aucune soirée n'a été trouvée</a>";
            }
            for ($i=0; $i<sizeof($arr); $i++) {
                $html .= "<a>La soirée {$arr['NomSoiree']} a pour thème {$arr['Theme']} et aura lieu le {$arr['Date']}.</a></br>";
                $html .= "<a>Le prix d'une place est de {$arr['Tarif']}€ par personne.</a></br>";
                $html .= "<a>Description de la soirée : {$arr['DescriptionSoiree']}</a></br>";
            }
        }

        return $html;

    }
}