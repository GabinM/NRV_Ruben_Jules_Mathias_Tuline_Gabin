<?php

namespace nrv\Actions;


use nrv\Repository\NRVRepository;

class ActionCreerSoiree extends Action {
    public function execute(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = <<<HTML
            <div id='filter'>
<h2>Création d'une nouvelle soirée</h2>
<form method="post" action="?action=create-soiree">
    <label>Nom de la soirée :
        <input type="text" name="nom" placeholder="Nom de la soirée" required>
    </label><br><br>

    <label>Thème de la soirée :
        <input type="text" name="theme" placeholder="Thème de la soirée" required>
    </label><br><br>

    <label>Date :
        <input type="date" name="date" required>
    </label><br><br>

    <label>Description :
        <textarea name="description" placeholder="Description de la soirée" rows="4" cols="50" required></textarea>
    </label><br><br>

    <label>Tarif (en €) :
        <input type="number" name="tarif" step="0.01" min="0" required>
    </label><br><br>

    <button type="submit">Créer la soirée</button>
</form></div>
HTML;

        } else {
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
            $theme = filter_var($_POST['theme'], FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            $tarif = filter_var($_POST['tarif'], FILTER_VALIDATE_FLOAT);

            $html = "<div id='filter'>";

            if ($nom && $theme && $date && $description && $tarif !== false) {
                $bd = NRVRepository::getInstance();
                $result = $bd->createSoiree($nom, $theme, $date, $description, $tarif);

                if ($result) {
                    $html .= "La soirée <b>$nom</b> a été créée";
                } else {
                    $html .= "<p>Erreur</p>";
                }
            } else {
                $html .= "<p>Erreur</p>";
            }
        }
        $html .= "</br></div>";

        return $html;
    }
}
