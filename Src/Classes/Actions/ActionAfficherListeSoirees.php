<?php

namespace nrv\Actions;

class ActionAfficherListeSoirees extends Action
{
    public function execute(): string
    {
        $html = "";


        $dateFilter = isset($_GET['date']) ? $_GET['date'] : '';


        $html .= "
<form method='GET' action='index.php'> 
    <input type='hidden' name='action' value='display-all-soiree' /> 
    <label for='date'>Sélectionnez une date:</label>
    <input type='date' id='date' name='date' value='$dateFilter'>
    <input type='submit' value='Filtrer'>
</form><br><br>
";


        $bd = \nrv\Repository\NRVRepository::getInstance();


        if ($dateFilter) {

            $arr = $bd->findListSoireeByDate($dateFilter);

            if (sizeof($arr) < 1) {
                $html .= "<a>Aucune soirée n'a été trouvée pour cette date.</a>";
            } else {
                foreach ($arr as $soiree) {
                    $html .= "<a>La soirée {$soiree['nomSoiree']} a pour thème {$soiree['theme']} et aura lieu le {$soiree['date']}.</a><br>";
                    $html .= "<a>Le prix d'une place est de {$soiree['tarif']}€ par personne.</a><br>";
                    $html .= "<a>Description de la soirée : {$soiree['descriptionSoiree']}</a><br><br>";
                }
            }
        } else {

            $arr = $bd->findListSoiree();

            if (sizeof($arr) < 1) {
                $html .= "<a>Aucune soirée n'a été trouvée.</a>";
            } else {
                foreach ($arr as $soiree) {
                    $html .= "<a>La soirée {$soiree['nomSoiree']} a pour thème {$soiree['theme']} et aura lieu le {$soiree['date']}.</a><br>";
                    $html .= "<a>Le prix d'une place est de {$soiree['tarif']}€ par personne.</a><br>";
                    $html .= "<a>Description de la soirée : {$soiree['descriptionSoiree']}</a><br><br>";
                }
            }
        }


        $html .= "<a href='?action=default'>Retourner au menu</a><br><br><br>";

        return $html;
    }
}
