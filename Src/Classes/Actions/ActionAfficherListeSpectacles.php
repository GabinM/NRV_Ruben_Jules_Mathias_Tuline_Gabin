<?php

namespace nrv\Actions;

class ActionAfficherListeSpectacles extends Action {
    public function execute() : string {
        $html = "";

        $dateFilter = isset($_GET['date']) ? $_GET['date'] : '';

        $html .= "
<form method='GET' action='index.php'>
    <input type='hidden' name='action' value='display-all-spectacle' />
    <label for='date'>Sélectionnez une date:</label>
    <input type='date' id='date' name='date' value='$dateFilter'>
    <input type='submit' value='Filtrer'>
</form><br><br>
";

        $bd = \nrv\Repository\NRVRepository::getInstance();

        if ($dateFilter) {
            $arr = $bd->findListSpecByDate($dateFilter);
        } else {
            $arr = $bd->findListSpec();
        }

        if (sizeof($arr) < 1) {
            return "<a>Aucun spectacle n'a été trouvé</a>";
        }

        foreach ($arr as $spectacle) {
            $html .= "<a>Le spectacle {$spectacle['titre']} de {$spectacle['nomsArtistes']} de style {$spectacle['style']}.</a><br>";
            $html .= "<a>Il durera {$spectacle['duree']} min</a><br>";
            $html .= "<a>Description du spectacle : {$spectacle['descriptionSpec']}</a><br><br>";
        }

        $html .= "<a href='?action=default'> Retourner au menu </a><br><br><br>";
        return $html;
    }
}
