<?php

namespace nrv\Actions;

class ActionAfficherListeSoirees extends Action {
    public function execute() : string{

        $html = "";

        $bd = \nrv\Repository\NRVRepository::getInstance();
        $arr = $bd->findListSoiree();
        if(sizeof($arr) < 1){
            return "<a>Aucune soirée n'a été trouvée</a>";
        }
        for ($i=0; $i<sizeof($arr); $i++) {
            $html .= "<a>La soirée {$arr[$i]['NomSoiree']} a pour thème {$arr[$i]['Theme']} et aura lieu le {$arr[$i]['Date']}.</a></br>";
            $html .= "<a>Le prix d'une place est de {$arr[$i]['Tarif']}€ par personne.</a></br>";
            $html .= "<a>Description de la soirée : {$arr[$i]['DescriptionSoiree']}</a></br></br>";
        }

        $html .= "<a href='?action=default'> Retourner au menu </a></br></br></br>";
        return $html;

    }
}