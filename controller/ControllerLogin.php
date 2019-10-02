<?php

namespace Projet5\Controller;

use Projet5\Model\UserManager;
use Projet5\Service\SecuritySuperGlobal;
use Projet5\Service\ViewManager;

session_start();
class ControllerLogin
{
    private $_userManager;
    private $renderview;
    private $superGlobal;

    public function __construct()
    {
        $this->_userManager = new UserManager();
        $this->renderview = new ViewManager();
        $this->superGlobal = new SecuritySuperGlobal();
    }

    //Se connecter
    public function login()
    {
        if (!empty($this->superGlobal->undirectUsePost())) {
            $authenticate = $this->_userManager->authenticate($this->superGlobal->undirectUsePost('login'), $this->superGlobal->undirectUsePost('password'));
            switch ($authenticate) {
                case "user":
                    $_SESSION['user'] = $this->superGlobal->undirectUsePost('login');
                    header('Location: index.php');
                    break;
                case "admin":
                    $_SESSION['admin'] = $this->superGlobal->undirectUsePost('login');
                    header('Location: index.php');
                    break;
                default:
                    $error = $this->_userManager->getErrorStatus($authenticate);
                    $this->renderview->generateView(array('name' => "Login", 'error' => $error), 'layout');
                    break;
            }
        } else {

            $this->renderview->generateView(array('name' => "Login"), 'layout');
        }
    }

    //Se déconnecter
    public function logout()
    {
        $this->_userManager->logout();
        $this->renderview->generateView(array('name' => "Logout"), 'layout');
    }
}
