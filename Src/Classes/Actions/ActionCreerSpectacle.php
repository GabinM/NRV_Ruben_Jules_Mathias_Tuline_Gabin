<?php

namespace nrv\Actions;

use nrv\Repository\NRVRepository;

class ActionCreerSpectacle extends Action {

    public function execute(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $bd = NRVRepository::getInstance();
            $lieux = $bd->getAllLieux();
            $style = $bd->getAllStyles();
            $optionsL = '';
            $optionsS = '';


            $options = '';
            foreach ($lieux as $lieu) {
                $idLieu = htmlspecialchars($lieu['idLieu']);
                $nomLieu = htmlspecialchars($lieu['nomLieu']);
                $optionsL .= "<option value='$idLieu'>$nomLieu</option>";
            }
            foreach ($style as $s) {
                $idStyle = htmlspecialchars($s['idStyle']);
                $libelle = htmlspecialchars($s['libelle']);
                $optionsS .= "<option value='$idStyle'>$libelle</option>";
            }

            $html = <<<HTML
                <h2>Création d'un nouveau spectacle</h2>
                <form method="post" action="?action=create-spectacle">
                    <label>Nom du lieu où se produit le spectacle :
                        <select name="idLieu" required>
                            $optionsL
                        </select>
                    </label><br><br>

                    <label>Titre du spectacle :
                        <input type="text" name="titre" placeholder="Titre du spectacle" required>
                    </label><br><br>

                    <label>Style du spectacle :
                        <select name="style" required>
                            $optionsS
                        </select>
                    </label><br><br>

                    <label>Date du spectacle :
                        <input type="date" name="date" required>
                    </label><br><br>

                    <label>Durée du spectacle :
                        <input type="number" name="duree" placeholder="Durée du spectacle" required>
                    </label><br><br>

                    <label>Description :
                        <textarea name="description" placeholder="Description du spectacle" rows="4" cols="50" required></textarea>
                    </label><br><br>
                    
                    <label>Horraire du spectacle :
                        <input type="time" name="horraire" required>
                    </label><br><br>

                    <label>Nom de l'artiste :
                        <input type="text" name="artiste" placeholder="Artiste du spectacle" required>
                    </label><br><br>

                    <button type="submit">Créer le spectacle</button>
                </form>
            HTML;

        } else {

            $idLieu = filter_var($_POST['idLieu'], FILTER_SANITIZE_NUMBER_INT);
            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_SPECIAL_CHARS);
            $artiste = filter_var($_POST['artiste'], FILTER_SANITIZE_SPECIAL_CHARS);
            $style = filter_var($_POST['style'], FILTER_SANITIZE_NUMBER_INT);
            $date = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);
            $horaire = filter_var($_POST['horraire'], FILTER_SANITIZE_NUMBER_INT);
            $duree = filter_var($_POST['duree'], FILTER_SANITIZE_NUMBER_INT);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);

            if ($idLieu && $titre && $artiste && $style && $date && $horaire && $duree && $description !== false) {
                $bd = NRVRepository::getInstance();
                $result = $bd->createSpectacle($idLieu, $titre, $style, $date, $horaire, $duree, $description, $artiste);

                if ($result) {
                    $html = "Le Spectacle <b>$titre</b> a été créé avec succès au lieu $idLieu";
                } else {
                    $html = "<p>Erreur lors de la création du spectacle</p>";
                }
            } else {
                $html = "<p>Erreur : un ou plusieurs champs sont invalides.</p>";
            }
        }
        $html .= "</br><a href='?action=default'>Retourner au menu</a>";
        return $html;
    }
}

?>
