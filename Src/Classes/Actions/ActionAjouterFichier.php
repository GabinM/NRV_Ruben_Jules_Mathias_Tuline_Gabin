<?php

namespace nrv\Actions;

use nrv\Repository\NRVRepository;

class ActionAjouterFichier extends Action {

    public function execute(): string {
        $id_spectacle = $_REQUEST['idSpec'];
        if(isset($_FILES['fichier'])) {
            $dossier = 'Media/';
            $fichier = basename($_FILES['fichier']['name']);
            $chemin = $dossier.$fichier;
            $html = "<div id='filter'>";
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                $bd = NRVRepository::getInstance();
                $bd -> ajouterMedia($id_spectacle,$chemin);
                $html .= 'Upload effectué avec succès !';
            }
            else //Sinon (la fonction renvoie FALSE).
            {
                $html .= 'Echec de l\'upload !';
            }
            unset($_FILES['fichier']);
            $html .= "</div>";
        }

        $html .= "<div id='filter'><form method='post' action='?action=ajouter-fichier&idSpec={$id_spectacle}' enctype='multipart/form-data'>
                         <input type='file' name='fichier' /></br>
                         <input type='submit' value='Envoyer' />
                 </form>";

        $html .= "</br><a href='?action=default'>Retourner au menu</a></div>";
        return $html;
    }
}