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
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                $bd = NRVRepository::getInstance();
                $bd -> ajouterMedia($id_spectacle,$chemin);
                echo 'Upload effectué avec succès !';
            }
            else //Sinon (la fonction renvoie FALSE).
            {
                echo 'Echec de l\'upload !';
            }
            unset($_FILES['fichier']);
        }

        $html = "<form method='post' action='?action=ajouter-fichier&idSpec={$id_spectacle}' enctype='multipart/form-data'>
                         <input type='file' name='fichier' /></br>
                         <input type='submit' value='Envoyer' />
                 </form>";

        $html .= "</br><a href='?action=default'>Retourner au menu</a>";
        return $html;
    }
}