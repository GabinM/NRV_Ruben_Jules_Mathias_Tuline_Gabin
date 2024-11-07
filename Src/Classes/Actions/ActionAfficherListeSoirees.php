<?php

namespace nrv\Actions;

use PDO;

class ActionAfficherListeSoirees extends Action {
    public function execute() :string {
        $html = "";if($_SERVER['REQUEST_METHOD'] == "GET" || ! isset($_POST['plid'])){
            $html .= "<form method = 'POST' action ='?action=select-playlist'></br>";
            $nb = 0;

            $bd = \nrv\repository\NRVRepository::getInstance();
            foreach($bd->getAllSoirees() as $sr){
                $html .= "<input type='radio' id='plList' name='plid' value='{$sr['id']}'>{$sr['titre']} par {$sr['artistes']}</a></br></br>";
                $nb ++;
            }

            if ($nb == 0) {
                $html .= '<b>Aucune soirée existante</b>';
            } else {
                $html .= "<input type='submit' value = 'choisir cette playlist'>";
            }

            $html .= "</form>";
            $html .= "</br></br><a href='?action=default'> Retourner au menu </a>";

        } else {
            $bd = \nrv\repository\NRVRepository::getInstance()->getDb();
            $plQuery = $bd->prepare("select nom from playlist where id = ? ;");
            $plQuery->bindParam(1,$_POST['plid']);
            $plQuery->execute();

            $plName = $plQuery->fetch(PDO::FETCH_ASSOC)['nom'];

            $trQuery = $bd->prepare("SELECT track.*,playlist2track.no_piste_dans_liste FROM `track` inner join playlist2track on playlist2track.id_track = track.id inner join playlist on playlist.id = playlist2track.id_pl where playlist.id = ?;");
            $trQuery->bindParam(1,$_POST['plid']);
            $trQuery->execute();

            $tracks = [];

            foreach($trQuery->fetchAll(PDO::FETCH_ASSOC) as $t){
                if($t['type'] == "A"){
                    array_push($tracks, new \spautify\audio\AlbumTrack($t['titre'], $t['artiste_album'], $t['annee_album'], $t['genre'], (int)($t['duree']), $t['filename'], $t['no_piste_dans_liste'], $t['titre_album']));
                } else {
                    array_push($tracks, new \spautify\audio\PodcastTrack($t['titre'], $t['auteur_podcast'], $t['date_posdcast'], $t['genre'], (int)($t['duree']), $t['filename']));
                }
            }

            $sr = new \spautify\audio\PlayList($plName, $tracks);
            $_SESSION['playlist'] = serialize($sr);
            $html .= "<a>Playlist sélectionnée</a></br>";
            $html .= "</br></br><a href='?action=default'> Retourner au menu </a>";

        }
        return $html;

    }

}