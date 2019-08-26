<?php

namespace Projet5\Controller;

use Projet5\Model\UserManager;

use Projet5\Service\RenderView;

session_start();
class ControllerLogin
{
    private $_userManager;
    public function __construct()
    {
        $this->_userManager = new UserManager();
        $this->renderview = new RenderView();
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
                    $this->renderview->generateView("Login", $error);
                    break;
            }
        }

        $this->renderview->generateView("Login");
    }

    public function logout()
    {
        $this->renderview->generateView("Logout");
    }
}
