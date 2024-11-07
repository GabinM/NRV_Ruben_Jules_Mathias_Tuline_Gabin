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
        switch($this->action){
            case "display-soiree":
                $act = new \nrv\Action\ActionAfficherSoiree();
                break;
            case "display-spectacle":
                $act = new \nrv\Action\ActionAfficherSpectacle();
                break;
        }
        $this->renderHTML($act->execute());
    }



















}