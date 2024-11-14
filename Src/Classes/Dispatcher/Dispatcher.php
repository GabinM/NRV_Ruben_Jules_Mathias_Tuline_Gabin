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
            <title>NRV</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>';
        $html.= "<h1 id = 'title'>NRV</h1>";

        switch($this->action){
            case "default":
                $act = new \nrv\Actions\ActionDefault();
                $html .= $act->execute();
                break;
            case "display-soiree":
                $act = new \nrv\Actions\ActionAfficherSoiree();
                $html .= $act->execute();
                break;
            case "display-all-soiree":
                $act = new \nrv\Actions\ActionAfficherListeSoirees();
                $html .= $act->execute();
                break;
            case "create-soiree":
                $act = new \nrv\Actions\ActionCreerSoiree();
                $html .= $act->execute();
                break;
            case "create-spectacle":
                $act = new \nrv\Actions\ActionCreerSpectacle();
                $html .= $act->execute();
                break;
            case "display-spectacle":
                $act = new \nrv\Actions\ActionAfficherSpectacle();
                $html .= $act->execute();
                break;
            case "display-all-spec":
                $act = new \nrv\Actions\ActionAfficherListeSpectacles();
                $html .= $act->execute();
                break;
            case "sign-in":
                $act = new \nrv\Actions\ActionSeConnecter();
                $html .= $act->execute();
                break;
            case "log-out":
                $act = new \nrv\Actions\ActionSeDeconnecter();
                $html .= $act->execute();
                break;
            case "register-user":
                $act = new \nrv\Actions\ActionEnregistrerUtilisateur();
                $html .= $act->execute();
                break;
            case "link-spectacle-soiree":
                $act = new \nrv\Actions\ActionLinkSpectacleToSoiree();
                $html .= $act->execute();
                break;
            case "modify-spectacle":
                $act = new \nrv\Actions\ActionModifierSpectacle();
                $html .= $act->execute();
                break;
            case "cancel-spectacle":
                $act = new \nrv\Actions\ActionAnnulerSpectacle();
                $html .= $act->execute();
                break;
            default:
                $html .= '<a>Erreur sur la requête</a>';
                break;
        }
        $html .= '</body>
        </html>';
        $this->renderHTML($html);
    }



















}