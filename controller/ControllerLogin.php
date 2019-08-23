<?php

namespace Projet5\Controller;

use Projet5\Model\UserManager;
use Projet5\Service\GenerateView;

session_start();
class ControllerLogin extends GenerateView
{
    private $_userManager;
    public function __construct()
    {
        $this->_userManager = new UserManager();
    }

    public function login()
    {
        if (!empty($_POST)) {
            $authenticate = $this->_userManager->authenticate(htmlentities($_POST['login']), htmlentities($_POST['password']));
            switch ($authenticate) {
                case "user":
                    $_SESSION['user'] = htmlentities($_POST['login']);
                    header('Location: index.php');
                    break;
                case "admin":
                    $_SESSION['admin'] = htmlentities($_POST['login']);
                    header('Location: index.php');
                    break;
                default:
                    $error = $this->_userManager->getErrorStatus($authenticate);
                    $this->generateView("Login", $error);
                    break;
            }
        }

        $this->generateView("Login");
    }

    public function logout()
    {
        $this->generateView("Logout");
    }
}
