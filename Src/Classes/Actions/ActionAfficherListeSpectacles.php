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
            $html .= "<a>Le spectacle {$arr[$i]['titre']} de {$arr[$i]['nomsArtistes']} de style {$arr[$i]['style']}.</a></br>";
            $html .= "<a>Il durera {$arr[$i]['duree']}min</a></br>";
            $html .= "<a>Description du spectacle : {$arr[$i]['descriptionSpec']}</a></br></br>";
        }

        $html .= "<a href='?action=default'> Retourner au menu </a></br></br></br>";
        return $html;

    }
}