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
        $html = "";
        $html .= '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>NRV</title>
            <link rel="stylesheet" href="nrvStyle.css">
            <link rel="icon" href="Media/site/icon.ico" type="image/ico">
        </head>
        <body><div id="menuBar">';
        $html.= "<h1 id = 'title'>NRV</h1>";

        $user = $_SESSION['user']['email'];
        if ($user == "") {
            $html .= "<a id = 'connid' >Connecté en tant qu'invité</a>";
        } else {
            $html .= "<a id = 'connid' >Connecté en tant que {$user}</a>";
        }
        
        if ($user == "") {
            $html .= "<a id='signin' href='?action=sign-in'> Se connecter </a>";
        } else {
            $html .= "<a id='signin' href='?action=log-out'> Se déconnecter </a>";
        }

        $html .= "<select id='specSoireeList' onchange ='location = this.value'>";
        $html .= '<option value="" selected disabled hidden>Découvrez le festival</option>';
        $html .= " <option value='?action=display-all-soiree'> Afficher toutes les soirées </option>";
        $html .= " <option value='?action=display-all-spec'> Afficher tous les spectacles </option>";
        $html .= "</select>";

        $role = \nrv\auth\Authz::checkRole();
        if ($role>0) {
            $html.= "<select id = adminList> onchange ='location = this.value' ";
            $html .= "<option href='?action=link-spectacle-soiree'> Lier un spectacle à une soirée </option>";
            $html .= "<option href='?action=create-spectacle'> Créer un spectacle </option>";
            $html .= "<option href='?action=create-soiree'> Créer une soirée </option>";
            if ($role == 2){
                $html .= "<option href='?action=register-user'> Enregistrer un nouvel utilisateur </option>";
            }
            $html.= "</select>";
        }

        $html .= "</div><div id='content'";
        
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
        $html .= '</div></body>
        </html>';
        $this->renderHTML($html);
    }



















}