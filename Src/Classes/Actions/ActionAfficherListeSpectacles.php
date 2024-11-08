<?php

namespace nrv\Actions;

class ActionAfficherListeSpectacles extends Action
{
    public function execute(): string
    {
        $html = "";

        // Vérification si un filtre de date est appliqué
        $dateFilter = isset($_GET['date']) ? $_GET['date'] : '';
        $styleFilter = isset($_GET['style']) ? $_GET['style'] : '';
        $lieuFilter = isset($_GET['lieu']) ? $_GET['lieu'] : '';

        $bd = \nrv\Repository\NRVRepository::getInstance();
        $styles = $bd->getAllStyles();


        $html .= "
<form method='GET' action='index.php'>
    <input type='hidden' name='action' value='display-all-spec' />
    <label for='date'>Sélectionnez une date:</label>
    <input type='date' id='date' name='date' value='$dateFilter'>
    <input type='submit' value='Filtrer'>
</form><br><br>";

        $html .= "
<form method='GET' action='index.php'>
    <input type='hidden' name='action' value='display-all-spec' />
    <label for='style'>Sélectionnez un style:</label>
    <select id='style' name='style'>
        <option value=''>Tous les styles</option>";

        foreach ($styles as $style) {
            $idStyle = htmlspecialchars($style['idStyle']);
            $libelle = htmlspecialchars($style['libelle']);
            $selected = ($idStyle == $styleFilter) ? "selected" : "";
            $html .= "<option value='$idStyle' $selected>$libelle</option>";
        }

        $html .= "</select>
    <input type='submit' value='Filtrer'>
</form><br><br>";

        $html .= "
        <form method='GET' action='index.php'>
            <input type='hidden' name='action' value='display-all-spec' />
            <label for='date'>Sélectionnez un Lieu:</label>
            <select id='lieu' name='lieu'>
                <option value=''>Tous les lieux</option>";


        if ($dateFilter && $styleFilter && $lieuFilter) {
            $arr = $bd->findListSpecByDateAndStyle($dateFilter, $styleFilter, $lieuFilter);
        } elseif ($dateFilter) {
            $arr = $bd->findListSpecByDate($dateFilter);
        } elseif ($styleFilter) {
            $arr = $bd->findListSpecByStyle($styleFilter);
        } elseif ($lieuFilter) {
            $arr = $bd->findListSpecByLieu($lieuFilter);
        } else {
            $arr = $bd->findListSpec();
        }


        if (sizeof($arr) < 1) {
            $html .= "<a>Aucun spectacle n'a été trouvé</a>";
        } else {
            foreach ($arr as $spectacle) {
                $html .= "<a>Le spectacle {$spectacle['titre']} de {$spectacle['nomsArtistes']} de style {$spectacle['style']}.</a><br>";
                $html .= "<a>Il durera {$spectacle['duree']} min</a><br>";
                $html .= "<a>Description du spectacle : {$spectacle['descriptionSpec']}</a><br><br>";
            }
        }

        $html .= "<a href='?action=default'> Retourner au menu </a><br><br><br>";

        return $html;
    }
}
