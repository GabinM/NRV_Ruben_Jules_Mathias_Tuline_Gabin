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
            $html .= "<a><strong>Titre :</strong> {$arr['titre']}</a><br>";
            $html .= "<a><strong>Lieu :</strong> {$arr['nomLieu']}</a><br>";
            $html .= "<a><strong>Artistes :</strong> {$arr['nomsArtistes']}</a><br>";
            $html .= "<a><strong>Style :</strong> {$arr['style']}</a><br>";
            $html .= "<a><strong>Date :</strong> {$arr['date']}</a><br>";
            $html .= "<a><strong>Duree :</strong> {$arr['duree']} minutes</a><br>";
            $html .= "<a><strong>Description :</strong> {$arr['descriptionSpec']}</a><br>";
            $html .= "<a><strong>Horaire :</strong> {$arr['horaire']}</a><br>";

            // Vérifier si le spectacle est associé à une soirée
            $soirnee = $bd->findSoireeBySpectacle($_REQUEST['id_spectacle']);
            if ($soirnee) {
                // Afficher les informations de la soirée si associée
                $html .= "<a><strong>Ce spectacle fait partie de la soirée : </strong><a href='?action=display-soiree&id_soiree={$soirnee['idSoiree']}'> {$soirnee['nomSoiree']}</a></a><br>";

                $html .= "<a><strong>Thème :</strong> {$soirnee['theme']}</a><br>";
                $html .= "<a><strong>Date de la soirée :</strong> {$soirnee['date']}</a><br>";
                $html .= "<a><strong>Tarif :</strong> {$soirnee['tarif']}€</a><br>";
                $html .= "<a><strong>Description de la soirée :</strong> {$soirnee['descriptionSoiree']}</a><br>";
            } else {
                // Si le spectacle n'est pas associé à une soirée
                $html .= "<a>Ce spectacle n'est associé à aucune soirée.</a><br>";
            }
        } else {
            $html = "<a>Aucun ID de spectacle spécifié.</a>";
        }

        return $html;
    }
}
