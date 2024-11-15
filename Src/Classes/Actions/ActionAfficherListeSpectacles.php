<?php

namespace nrv\Actions;

class ActionAfficherListeSpectacles extends Action
{
    public function execute(): string
    {
        $html = "";

        $dateFilter = $_GET['date'] ?? '';
        $styleFilter = $_GET['style'] ?? '';
        $lieuFilter = $_GET['lieu'] ?? '';

        $bd = \nrv\Repository\NRVRepository::getInstance();
        $styles = $bd->getAllStyles();

        $html .= "
<div style='display: flex;'>
    <div style='flex: 1; max-width: 300px;'>
        <div id='filter'>
        <form method='GET' action='index.php'>
            <input type='hidden' name='action' value='display-all-spec' />
            <label for='date'>Sélectionnez une date:</label>
            <input type='date' id='date' name='date' value='" . htmlspecialchars($dateFilter) . "'>
            <input type='submit' value='Filtrer'>
        </form><br><br>

        <form method='GET' action='index.php'>
            <input type='hidden' name='action' value='display-all-spec' />
            <label for='style'>Sélectionnez un style:</label>
            <select id='style' name='style'>
                <option value=''>Tous les styles</option>";
        foreach ($styles as $style) {
            $idStyle = htmlspecialchars($style['idStyle']);
            $libelle = htmlspecialchars($style['libelle']);
            $selected = ($idStyle === $styleFilter) ? "selected" : "";
            $html .= "<option value='$idStyle' $selected>$libelle</option>";
        }
        $html .= "    </select>
            <input type='submit' value='Filtrer'>
        </form><br><br>

        <form method='GET' action='index.php'>
            <input type='hidden' name='action' value='display-all-spec' />
            <label for='lieu'>Sélectionnez un Lieu:</label>
            <select id='lieu' name='lieu'>
                <option value=''>Tous les lieux</option>";
        foreach ($bd->getAllLieux() as $lieu) {
            $idLieu = htmlspecialchars($lieu['idLieu']);
            $nomLieu = htmlspecialchars($lieu['nomLieu']);
            $selected = ($idLieu === $lieuFilter) ? "selected" : "";
            $html .= "<option value='$idLieu' $selected>$nomLieu</option>";
        }
        $html .= "    </select>
            <input type='submit' value='Filtrer'>
        </form><br><br>
    </div></div>
    <div style='flex: 3;'>
";
        $html .= "</div></div></br><a href='?action=default'> Retourner au menu </a><br><br><br>";


        if ($dateFilter && $styleFilter && $lieuFilter) {
            $arr = $bd->findListSpecByDateAndStyle($dateFilter, $styleFilter);
        } elseif ($dateFilter) {
            $arr = $bd->findListSpecByDate($dateFilter);
        } elseif ($styleFilter) {
            $arr = $bd->findListSpecByStyle($styleFilter);
        } elseif ($lieuFilter) {
            $arr = $bd->findListSpecByLieu($lieuFilter);
        } else {
            $arr = $bd->findListSpec();
        }

        if (empty($arr)) {
            $html .= "<a>Aucun spectacle n'a été trouvé</a>";
        } else {
            foreach ($arr as $spectacle) {
                //$idStyle = $spectacle['idStyle'] ?? 'Inconnu';
                //$libelle = $bd->findStyleById($idStyle)['libelle'] ?? 'Inconnu';
                $html .= "<div id='soiree'><div class='yellowBar'><a id='soiree-title'>{$spectacle['titre']}</a></div><div class='soiree-content'>";
                $html .= "<a>Le spectacle nommé {$spectacle['titre']} se déroulera le {$spectacle['date']} à {$spectacle['horaire']}.</a></br>";

                $medias = $bd->findMediaBySpec($spectacle['idSpectacle']);
                foreach ($medias as $media) {
                    $Ext = new \SplFileInfo($media['fichier']);

                    if (!empty($medias)) {
                        if ($Ext == 'jpg') {
                            foreach ($medias as $media) {
                                $html .= "<img src='" . htmlspecialchars($media['fichier']) . "' alt='Media Image'></br>";
                            }
                        } else {
                            foreach ($medias as $media) {
                                $Ext = new \SplFileInfo($media['fichier']);
                                if ($Ext->getExtension() == 'jpg') {
                                    $html .= "<img src='" . htmlspecialchars($media['fichier']) . "' alt='Media Image'></br></br>";
                                } else {
                                    $html .= "<video height=350px autoplay muted loop>
                    <source src='" . htmlspecialchars($media['fichier']) . "' type='video/mp4'>
                  </video></br></br>";
                                }
                            }

                        }
                    }
                }
                $html .= "<a href='?action=display-spectacle&id_spectacle={$spectacle['idSpectacle']}'>Voir le détail du spectacle.</a></br></br></div></div>";
            }

        }
        $html .= "</br><a href='?action=default'> Retourner au menu </a><br><br><br>";
        return $html;
    }
}
