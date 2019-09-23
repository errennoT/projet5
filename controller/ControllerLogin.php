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
        if (!empty($this->superGlobal->undirectUseSP($_POST))) {
            $authenticate = $this->_userManager->authenticate(filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            switch ($authenticate) {
                case "user":
                    $this->superGlobal->undirectUseSP($_SESSION['user'] = filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    header('Location: index.php');
                    break;
                case "admin":
                    $this->superGlobal->undirectUseSP($_SESSION['admin'] = filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    header('Location: index.php');
                    break;
                default:
                    $error = $this->_userManager->getErrorStatus($authenticate);
                    $this->renderview->generateView(array('name' => "Login", 'error' => $error), 'layout');
                    break;
            }
        }

        $this->renderview->generateView(array('name' => "Login"), 'layout');
    }

    //Se déconnecter
    public function logout()
    {
        $this->_userManager->logout();
        $this->renderview->generateView(array('name' => "Logout"), 'layout');
    }
}
