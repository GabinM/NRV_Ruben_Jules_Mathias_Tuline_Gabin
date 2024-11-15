<?php

namespace nrv\Actions;

use PDO;

class ActionAnnulerSpectacle extends Action {
    public function execute() : string {
        $html = "";
        $html .= "<div id='filter'>";
        if( ! isset($_REQUEST['id_spectacle'])){
            $html .= "<a>Aucun spectacle n'a été indiqué</a>";
        } else {
            $bd = \nrv\Repository\NRVRepository::getInstance();


            $arr = $bd->findSpectacle($_REQUEST['id_spectacle']);
            if($arr['annule'] == 0){
                $query = $bd->getDb()->prepare("update spectacle set annule = 1 where idSpectacle = ? ;");
                $html .= "<a>Le spectacle a bien été annulé</a>"; 
                
            } else {
                $query = $bd->getDb()->prepare("update spectacle set annule = 0 where idSpectacle = ? ;");
                $html .= "<a>Le spectacle a bien été rétabli</a>"; 
            }
            $query->bindParam(1,$_REQUEST['id_spectacle']);
            $query->execute();
        }
        $html .= "</br><a href='?action=default'>Retourner au menu</a></div>";
        return $html;
    }
    
}