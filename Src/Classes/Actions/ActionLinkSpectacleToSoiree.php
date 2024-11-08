<?php

namespace nrv\Actions;

use nrv\Repository\NRVRepository;

use PDO;

class ActionLinkSpectacleToSoiree extends Action {

    public function execute() : string {
        
        if( \nrv\Auth\Authz::checkRole() == 0){
            return new \nrv\Exceptions\AuthzException("Vous n'êtes pas autorisé à effectuer cette action");
        } else {
            $html = "";
            
            $html .= "<form method='POST' action='?action=link-spectacle-soiree'>";
            $html .="<label >Nom de la soirée</label></br>";
            $html .= "<input type='text' name='soiree_name'></br></br>";
            $html .="<label >Nom du spectacle</label></br>";
            $html .= "<input type='text' name='spectacle_name'></br></br>";
            $html .= "<input type='submit' value = 'Rechercher' name='seek'>";

            if($this->http_method == "POST"){

                if(isset($_POST['seek'])){
                    if(! isset($_POST['spectacle_name'])){
                        $html.= "<a>veuillez entrer un spectacle</a></br>";
                    } elseif (!isset($_POST['soiree_name'])){
                        $html.= "<a>veuillez entrer une soirée</a></br>";
                    } else {
                        $bd = \nrv\Repository\NRVRepository::getInstance()->getDb();
                        $soireeQuery = $bd->prepare("select * from soiree where nomSoiree like ? ;");
                        $likeName = "%".$_POST['soiree_name']."%";
                        $soireeQuery->bindParam(1, $likeName);
                        $soireeQuery->execute();
                        $arr = $soireeQuery->fetchAll(PDO::FETCH_ASSOC);
    
                        $html .= "<form method='POST' action='?action=link-spectacle-soiree'>";
                        $html .= "<a>Soirées trouvées</a></br>";
                        foreach($arr as $so){
                            $html .= "<input type='radio' name='soir' value='{$so['idSoiree']}'><a>{$so['nomSoiree']} - {$so['date']}</a></br>";
                        }
    
                        $html .= "</br><a>Spectacles trouvés</a></br>";
    
                        $spectacleQuery = $bd->prepare("select * from spectacle where titre like ? ;");
                        $likeName = "%".$_POST['spectacle_name']."%";
                        $spectacleQuery->bindParam(1, $likeName);
                        $spectacleQuery->execute();
                        $arr2 = $spectacleQuery->fetchAll(PDO::FETCH_ASSOC);
    
                        foreach($arr2 as $sp){
                            $html .= "<input type='radio' name='spec' value='{$sp['idSpectacle']}'><a>{$sp['titre']} - {$sp['date']} par {$sp['nomsArtistes']}</a></br>";
                        }
    
                        $html .= "<input type='submit' value='enregistrer le lien' name = 'bind' ></form></br>";

                    } 
                    
                } else if(isset($_POST['bind'])){
                    $bd = \nrv\Repository\NRVRepository::getInstance()->getDb();

                    $checkQuery = $bd->prepare("select count(*) from spectacle2Soiree where idSpectacle = ? and idSoiree = ? ;");
                    $checkQuery->bindParam(1, $_POST['spec']);
                    $checkQuery->bindParam(2, $_POST['soir']);
                    $checkQuery->execute();
                    $res = $checkQuery->fetch(PDO::FETCH_ASSOC)['count(*)'];

                    if($res > 0){
                        $html .= "<a>Le spectacle est déjà relié à la soirée</a>";
                    } else {
                        $query = $bd->prepare("insert into spectacle2soiree(idSpectacle,idSoiree) values (?,?) ;");
                        $query->bindParam(1, $_POST['spec']);
                        $query->bindParam(2, $_POST['soir']);
                        try{
                            $query->execute();
                            $html .= "<a>Spectacle relié à la soirée avec succès</a>";
                        } catch(\Exception $e) {
                            $html .= "<a>Erreur</a>";
                            $html .= $e->getMessage();
                        }
                    }

                }
            }
        }
        return $html;
    }


}