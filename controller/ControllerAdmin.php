<?php

namespace Projet5\Controller;

use \Projet5\Model\UserManager;
use \Projet5\Model\AreaAdmin;
use Projet5\Service\GenerateView;

class ControllerAdmin extends GenerateView
{

    private $_userManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->_userManager = new UserManager();
    }

    public function adminArea()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();
        $this->generateView("Admin");
    }

    public function accesDenied()
    {
        $this->generateView("AccesDenied");
    }
}
