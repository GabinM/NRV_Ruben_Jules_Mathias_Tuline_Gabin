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
            $html .= "<a><strong>Nom de la soirée :</strong> {$arr['nomSoiree']}</a></br>";
            $html .= "<a><strong>Thème :</strong> {$arr['theme']}</a></br>";
            $html .= "<a><strong>Date :</strong> {$arr['date']}</a></br>";
            $html .= "<a><strong>Tarif :</strong> {$arr['tarif']}</a></br>";
            $html .= "<a><strong>Description :</strong> {$arr['descriptionSoiree']}</a></br>";

            $html .= "<a><strong>Les spectacles inclus dans cette soirée :</strong></a></br></br>";

            $soirray = $bd->findSpectacleBySoiree($_REQUEST['soiree_id']);
            foreach($soirray as $s){
                $html .= "<a href='?action=display-spectacle&id_spectacle={$s['idSpectacle']}'>{$s['titre']} par {$s['nomsArtistes']}</a></br></br>";
                $medias = $bd->findMediaBySpec($s['idSpectacle']);
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
                    $html .= "</br>";
                }
            }
        }

        $html .= "</br><a href='?action=default'>Retourner au menu</a><br><br><br>";

        return $html;

    }
}