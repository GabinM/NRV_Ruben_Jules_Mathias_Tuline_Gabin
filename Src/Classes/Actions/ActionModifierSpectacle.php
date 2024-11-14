<?php

namespace nrv\Actions;

class ActionModifierSpectacle extends Action
{
    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $bd = \nrv\Repository\NRVRepository::getInstance();
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
                <h2>Modification d'un spectacle</h2>
                <form method="post" action="?action=update-spectacle">
                    <label>Nom du lieu où se produit le spectacle :
                        <select name="idLieu" required>
                            $optionsL
                        </select>
                    </label><br><br>

                    <label>Titre du spectacle :
                        <input type="text" name="titre" placeholder="Titre du spectacle" required>
                    </label><br><br>

                    <label>Style du spectacle :
                        <select name="idstyle" required>
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
                    
                    <input type="submit" value="Modifier le spectacle">
HTML;

        } else {
            $bd = \nrv\Repository\NRVRepository::getInstance();
            $bd->updateSpectacle($_POST['idSpectacle'], $_POST['idLieu'], $_POST['titre'], $_POST['idstyle'], $_POST['date'], $_POST['duree'], $_POST['description'], $_POST['annule']);
            $html = "<a>Le spectacle a bien été modifié</a>";
        }


        return $html;

    }
}