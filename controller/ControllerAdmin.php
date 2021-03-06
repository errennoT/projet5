<?php

namespace Projet5\Controller;

use \Projet5\Model\UserManager;
use \Projet5\Model\AreaAdmin;

use Projet5\Service\ViewManager;

class ControllerAdmin
{

    private $_userManager;
    private $areaAdmin;

    public function __construct()
    {

        $this->_userManager = new UserManager();
        $this->renderview = new ViewManager();
    }

    //Affiche l'espace administrateur
    public function adminArea()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();
        $this->renderview->generateView(array('name' => "Admin"), 'layoutPageAdmin');
    }

    //Affiche une page d'erreur si la personne n'est pas administrateur
    public function accesDenied()
    {
        $this->renderview->generateView(array('name' => "AccesDenied"), 'layout');
    }
}
