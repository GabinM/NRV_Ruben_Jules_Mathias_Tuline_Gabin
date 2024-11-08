<?php

namespace nrv\Actions;

use nrv\Repository\NRVRepository;

class ActionCreerSpectacle extends Action {

    function execute() : String {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = <<<HTML
                <h2>Création d'un nouveau spectacle</h2>

                    <form method="post" action="?action=create-spectacle">

                        <label>Nom du lieu où se produit du spectacle :
                        <input type="text" name="nom" placeholder="Nom du lieu où se produit du spectacle" required>
                        </label><br><br>

                        <label>Titre du spectacle :
                        <input type="text" name="titre" placeholder="titre du spectacle" required>
                        </label><br><br>

                        <label>Nom de l'artiste :
                        <input type="text" name="artiste" placeholder="Artiste du spectacle" required>
                        </label><br><br>

                        <label>Style du spectacle :
                        <input type="text" name="style" placeholder="Style du spectacle" required>
                        </label><br><br>

                        <label>Date du spectacle :
                        <input type="date" name="date" required>
                        </label><br><br>

                        <label>Horraire du spectacle :
                        <input type="time" name="horraie" required>
                        </label><br><br>

                        <label>Durée du spectacle :
                        <input type="number" name="duree" placeholder="Durée du spectacle" required>
                        </label><br><br>

                        <label>Description :
                        <textarea name="description" placeholder="Description du spectacle" rows="4" cols="50" required></textarea>
                        </label><br><br>
                    <button type="submit">Créer le spectacle</button>
                    </form>
            HTML;
        }else {
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_SPECIAL_CHARS);
            $artiste = filter_var($_POST['artiste'], FILTER_SANITIZE_SPECIAL_CHARS);
            $style = filter_var($_POST['style'], FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);
            $horraie = filter_var($_POST['horraie'], FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = filter_var($_POST['duree'], FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);

            if ($nom && $titre && $artiste && $style && $date && $horraie && $duree && $description !== false) {
                $bd = NRVRepository::getInstance();
                $result = $bd->createSpectacle($nom, $titre, $artiste, $style, $date, $horraie, $duree, $description);

                if ($result) {
                    $html = "Le Spectacle <b>$nom</b> a été créée";
                } else {
                    $html = "<p>Erreur</p>";
                }
            } else {
                $html = "<p>Erreur</p>";
            }
        }

        return $html;
    
    }

}

?>