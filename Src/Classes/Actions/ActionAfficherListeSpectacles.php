<?php

namespace nrv\Actions;

class ActionAfficherListeSpectacles extends Action {
    public function execute() : string{

        $html = "";

        $bd = \nrv\Repository\NRVRepository::getInstance();
        $arr = $bd->findListSpec();
        if(sizeof($arr) < 1){
            return "<a>Aucun spectacle n'a été trouvé</a>";
        }
        for ($i=0; $i<sizeof($arr); $i++) {
            $html .= "<a>Le spectacle {$arr[$i]['Titre']} de {$arr[$i]['NomArtistes']} de style {$arr[$i]['Style']} aura lieu le {$arr[$i]['Date']} à {$arr[$i]['nomLieu']}.</a></br>";
            $html .= "<a>Il commencera à {$arr[$i]['Horaire']} durera {$arr[$i]['Durée']}min</a></br>";
            $html .= "<a>Description du spectacle : {$arr[$i]['DescriptionSpec']}</a></br></br>";
        }

        $html .= "<a href='?action=default'> Retourner au menu </a></br></br></br>";
        return $html;

    }
}