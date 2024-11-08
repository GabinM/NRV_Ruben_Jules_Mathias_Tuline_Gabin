<?php

namespace nrv\Actions;

class ActionAfficherListeSpectacles extends Action
{
    public function execute() : string {
        $html = "";

        // Vérification si un filtre de date est appliqué
        $dateFilter = isset($_GET['date']) ? $_GET['date'] : '';

        // Formulaire pour sélectionner une date
        $html .= "
<form method='GET' action='index.php'>
    <input type='hidden' name='action' value='display-all-spec' />
    <label for='date'>Sélectionnez une date:</label>
    <input type='date' id='date' name='date' value='$dateFilter'>
    <input type='submit' value='Filtrer'>
</form><br><br>
";

        // Récupération de l'instance du repository
        $bd = \nrv\Repository\NRVRepository::getInstance();

        // Si un filtre de date est appliqué
        if ($dateFilter) {
            $arr = $bd->findListSpecByDate($dateFilter);
        } else {
            // Sinon, afficher tous les spectacles
            $arr = $bd->findListSpec();
        }

        // Si aucun spectacle trouvé
        if (sizeof($arr) < 1) {
            $html .= "<a>Aucun spectacle n'a été trouvé</a>";
        } else {
            // Si des spectacles sont trouvés, les afficher
            foreach ($arr as $spectacle) {
                $html .= "<a>Le spectacle {$spectacle['titre']} de {$spectacle['nomsArtistes']} de style {$spectacle['idStyle']}.</a><br>";
                $html .= "<a>Il durera {$spectacle['duree']} min</a><br>";
                $html .= "<a>Description du spectacle : {$spectacle['descriptionSpec']}</a><br><br>";
            }
        }

        // Lien pour retourner au menu
        $html .= "<a href='?action=default'> Retourner au menu </a><br><br><br>";

        return $html;
    }
}
