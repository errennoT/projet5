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

    public function adminArea()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();
        $this->renderview->generateView("Admin");
    }

    public function accesDenied()
    {
        $this->renderview->generateView("AccesDenied");
    }
}
