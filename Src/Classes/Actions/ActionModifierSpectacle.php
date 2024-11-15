<?php

namespace nrv\Actions;

use nrv\Repository\NRVRepository;

class ActionModifierSpectacle extends Action
{
    public function execute(): string
    {
        $bd = NRVRepository::getInstance();
        $idSpectacle = $this->getIdSpectacle();

        if (!$idSpectacle) {
            return "<a>Erreur: idSpectacle manquant</a>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $spectacle = $bd->findSpectacle($idSpectacle);
            if (!$spectacle) {
                return "<a>Erreur: Spectacle introuvable</a>";
            }

            $lieux = $bd->getAllLieux();
            $styles = $bd->getAllStyles();

            $optionsL = '';
            foreach ($lieux as $lieu) {
                $idLieu = isset($lieu['idLieu']) ? htmlspecialchars($lieu['idLieu']) : '';
                $nomLieu = isset($lieu['nomLieu']) ? htmlspecialchars($lieu['nomLieu']) : '';
                $selected = $spectacle['idLieu'] == $idLieu ? 'selected' : '';
                $optionsL .= "<option value='$idLieu' $selected>$nomLieu</option>";
            }

            $optionsS = '';
            foreach ($styles as $style) {
                $idStyle = htmlspecialchars($style['idStyle']);
                $libelle = htmlspecialchars($style['libelle']);
                $selected = $spectacle['idStyle'] == $idStyle ? 'selected' : '';
                $optionsS .= "<option value='$idStyle' $selected>$libelle</option>";
            }

            $titre = htmlspecialchars($spectacle['titre']);
            $artiste = htmlspecialchars($spectacle['nomsArtistes']);
            $date = htmlspecialchars($spectacle['date']);
            $horaire = htmlspecialchars($spectacle['horaire']);
            $duree = htmlspecialchars($spectacle['duree']);
            $description = htmlspecialchars($spectacle['descriptionSpec']);

            $html = <<<HTML
            <div id='filter'>
                <h2>Modification du spectacle</h2>
                <form method="post" action="?action=modify-spectacle">
                    <input type="hidden" name="id_spectacle" value="$idSpectacle">
                    <label>Nom du lieu où se produit le spectacle :
                        <select name="idLieu" required>
                            $optionsL
                        </select>
                    </label><br><br>

                    <label>Titre du spectacle :
                        <input type="text" name="titre" value="$titre" required>
                    </label><br><br>

                    <label>Style du spectacle :
                        <select name="idStyle" required>
                            $optionsS
                        </select>
                    </label><br><br>

                    <label>Date du spectacle :
                        <input type="date" name="date" value="$date" required>
                    </label><br><br>

                    <label>Durée du spectacle :
                        <input type="number" name="duree" value="$duree" required>
                    </label><br><br>

                    <label>Description :
                        <textarea name="description" rows="4" cols="50" required>$description</textarea>
                    </label><br><br>
                    
                    <label>Horaire du spectacle :
                        <input type="time" name="horaire" value="$horaire" required>
                    </label><br><br>

                    <label>Nom de l'artiste :
                        <input type="text" name="artiste" value="$artiste" required>
                    </label><br><br>

                    <button type="submit">Modifier le spectacle</button>
                </form>
            </div>
        HTML;

        } else {
            $idLieu = filter_var($_POST['idLieu'], FILTER_SANITIZE_NUMBER_INT);
            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_SPECIAL_CHARS);
            $artiste = filter_var($_POST['artiste'], FILTER_SANITIZE_SPECIAL_CHARS);
            $idStyle = filter_var($_POST['idStyle'], FILTER_SANITIZE_NUMBER_INT);
            $date = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);
            $horaire = filter_var($_POST['horaire'], FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = filter_var($_POST['duree'], FILTER_SANITIZE_NUMBER_INT);

            $duree = is_numeric($duree) ? (int)$duree : 0;

            $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            $html = "<div id='filter'>";
            if ($idLieu && $titre && $artiste && $idStyle && $date && $horaire && $duree !== false && $description !== false) {
                $result = $bd->updateSpectacle($idSpectacle, $idLieu, $titre, $idStyle, $date, $duree, $description, $horaire, $artiste, 0);
                if ($result) {
                    $html .= "Le Spectacle <b>$titre</b> a été modifié.";
                } else {
                    $html .= "<p>Erreur lors de la modification du spectacle</p>";
                }
            } else {
                $html .= "<p>Erreur : un ou plusieurs champs sont invalides.</p>";
            }
        }

        $html .= "</br><a href='?action=default'>Retourner au menu</a></div>";
        return $html;
    }

    private function getIdSpectacle(): ?int
    {
        return isset($_GET['id_spectacle']) ? (int)$_GET['id_spectacle'] :
            (isset($_POST['id_spectacle']) ? (int)$_POST['id_spectacle'] : null);
    }
}
