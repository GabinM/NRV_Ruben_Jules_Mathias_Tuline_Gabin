<?php


namespace nrv\Dispatcher;

class Dispatcher{
    private ?string $action;

    public function __construct(?string $action){
        $this->action = $action;
    }

    public function renderHTML($s){
        echo $s; //à changer après si on veut un meilleur affichage
    }

    public function run(){
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Spautify</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>';
        switch($this->action){
            case "display-soiree":
                $act = new \nrv\Actions\ActionAfficherSoiree();
                $html .= $act->execute();
                break;
//            case "display-spectacle":
//                $act = new \nrv\Actions\ActionAfficherSpectacle();
//                $html .= $act->execute();
//                break;
            default:
                $html .= '<a>Erreur sur la requête</a>';
                break;
        }
        $html .= '</body>
        </html>';
        $this->renderHTML($html);
    }



















}