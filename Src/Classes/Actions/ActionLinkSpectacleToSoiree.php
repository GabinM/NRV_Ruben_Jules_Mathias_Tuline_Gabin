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
    
                        $html .= "<form method='POST' action='?action=link-spectacle-soiree'>";
                        $html .= "<a>Soirées trouvées</a></br>";
                        foreach($soireeQuery->fetch(PDO::FETCH_ASSOC) as $so){
                            $html .= "<input type='radio' name='soir' value='{$so['id']}'><a>{$so['nomSoiree']} - {$so['date']}</a></br>";
                        }
    
                        $html .= "</br><a>Spectacles trouvés</a></br>";
    
                        $spectacleQuery = $bd->prepare("select * from spectacle where nomSoiree like ? ;");
                        $likeName = "%".$_POST['spectacle_name']."%";
                        $spectacleQuery->bindParam(1, $likeName);
                        $spectacleQuery->execute();
    
                        foreach($spectacleQuery->fetch(PDO::FETCH_ASSOC) as $sp){
                            $html .= "<input type='radio' name='spec' value='{$sp['id']}'><a>{$sp['nomSpectacle']} - {$sp['date']} par {$sp['nomArtistes']}</a></br>";
                        }
    
                        $html .= "<input type='submit' value='enregistrer le lien' name = 'bind' ></form>";

                    } 
                    
                } else if(isset($_POST['bind'])){
                    $bd = \nrv\Repository\NRVRepository::getInstance()->getDb();

                    $query = $bd->prepare("insert into spectacle2soiree(idSpectacle,idSoiree) values (?,?) ;");
                    $query->bindParam(1, $_POST['spec']);
                    $query->bindParam(2, $_POST['soir']);
                    try{
                        $query->execute();
                    } catch(\Exception $e) {
                        $html .= "<a>Erreur</a>";
                    }

                }
            }
        }
        return $html;
    }


}