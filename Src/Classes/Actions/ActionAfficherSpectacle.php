<?php

namespace nrv\Actions;

class ActionAfficherSpectacle extends Action {
    public function execute() : string {
        $html = "";

        if (isset($_REQUEST['id_spectacle'])) {

            $bd = \nrv\Repository\NRVRepository::getInstance();
            $arr = $bd->findSpectacle($_REQUEST['id_spectacle']);
            if(sizeof($arr) < 1){
                return "<a>Aucun spectacle trouvé</a>";
            }
            $html .= "<div id='soiree'><div class='yellowBar'><a id='soiree-title'>{$arr['titre']}</a></div><div class='soiree-content'>";
            if($arr['annule'] == 1){
                $html .= "</br><a id='red'><b>Ce spectacle a été annulé</b></a></br></br>";
            }
            $html .= "<a><strong>Titre :</strong> {$arr['titre']}</a><br>";
            //$html .= "<a><strong>Lieu :</strong> {$arr['nomLieu']}</a><br>";
            $html .= "<a><strong>Artistes :</strong> {$arr['nomsArtistes']}</a><br>";
            $html .= "<a><strong>Style :</strong> {$arr['libelle']}</a><br>";
            //$html .= "<a><strong>Date :</strong> {$arr['date']}</a><br>";
            $html .= "<a><strong>Duree :</strong> {$arr['duree']} minutes</a><br>";
            $html .= "<a><strong>Description :</strong> {$arr['descriptionSpec']}</a><br>";
            //$html .= "<a><strong>Horaire :</strong> {$arr['horaire']}</a><br>";

            // Vérifier si le spectacle est associé à une soirée
            $soirnee = $bd->findSoireeBySpectacle($_REQUEST['id_spectacle']);
            if ($soirnee) {
                // Afficher les informations de la soirée si associée
                $html .= "<a><strong>Ce spectacle fait partie de la soirée : </strong><a href='?action=display-soiree&soiree_id={$soirnee['idSoiree']}'> {$soirnee['nomSoiree']}</a></a><br>";

                $html .= "<a><strong>Thème :</strong> {$soirnee['theme']}</a></br>";
                $html .= "<a><strong>Date de la soirée :</strong> {$soirnee['date']}</a></br>";
                $html .= "<a><strong>Tarif :</strong> {$soirnee['tarif']}€</a></br></br>";
                //$html .= "<a><strong>Description de la soirée :</strong> {$soirnee['descriptionSoiree']}</a><br></br>";


                $medias = $bd->findMediaBySpec($_REQUEST['id_spectacle']);
                foreach ($medias as $media) {
                    $Ext = new \SplFileInfo($media['fichier']);

                    if (!empty($medias)) {
                        if ($Ext == 'jpg') {
                            foreach ($medias as $media) {
                                $html .= "<img src='" . htmlspecialchars($media['fichier']) . "' alt='Media Image'><br>";
                            }
                        } else {
                            foreach ($medias as $media) {
                                $Ext = new \SplFileInfo($media['fichier']);
                                if ($Ext->getExtension() == 'jpg') {
                                    $html .= "<img src='" . htmlspecialchars($media['fichier']) . "' alt='Media Image'><br></br>";
                                } else {
                                    $html .= "<video height=350px autoplay muted loop>
                    <source src='" . htmlspecialchars($media['fichier']) . "' type='video/mp4'>
                  </video><br></br>";
                                }
                            }

                        }
                    }
                }

                if(\nrv\Auth\Authz::checkRole() >= 1){
                    $idS = $_REQUEST['id_spectacle'];
                    $html .= "</br><a href='?action=modify-spectacle&id_spectacle=$idS'>Modifier</a><br><br>";

                    if ($arr['annule'] == 0){
                        $html .= "</br><a href='?action=cancel-spectacle&id_spectacle=$idS'>Annuler Le spectacle</a><br><br><br>";
                    } else {
                        $html .= "</br><a href='?action=cancel-spectacle&id_spectacle=$idS'>Rétablir Le spectacle</a><br><br><br>";
                    }

                }


                //fonctionnalités 8,9 et 10 ==> affichage détaillé
                //accès aux spectacles du même lieu (8)
                $arrLieu = $bd->findListSpecByLieu($arr['idLieu']);
                $html .= "<a><strong>Spectacles du même lieu :</strong></a></br>";
                foreach ($arrLieu as $specLieu) {
                    $html .= "<a href='?action=display-spectacle&id_spectacle={$specLieu['idSpectacle']}'>{$specLieu['titre']}</a></br>";
                }

                //accès aux spectacles du même style (9)
                $arrStyle = $bd->findListSpecByStyle($arr['idStyle']);
                $html .= "</br><a><strong>Spectacles du même style :</strong></a></br>";
                foreach ($arrStyle as $specStyle) {
                    $html .= "<a href='?action=display-spectacle&id_spectacle={$specStyle['idSpectacle']}'>{$specStyle['titre']}</a></br>";
                }
                //accès aux spectacles à la même date (10)
                $arrDate = $bd->findListSpecByDate($arr['date']);
                $html .= "</br><a><strong>Spectacles à la même date :</strong></a></br>";
                foreach ($arrDate as $specDate) {
                    $html .= "<a href='?action=display-spectacle&id_spectacle={$specDate['idSpectacle']}'>{$specDate['titre']}</a></br>";
                }


            } else {
                // Si le spectacle n'est pas associé à une soirée
                $html .= "<a>Ce spectacle n'est associé à aucune soirée.</a><br>";
            }
        } else {
            $html = "<a>Aucun ID de spectacle spécifié.</a>";
        }
        
        $html .= "</div></br><a href='?action=default'>Retourner au menu</a><br><br><br>";


        return $html;
    }
}
