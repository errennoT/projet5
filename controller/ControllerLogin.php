<?php

namespace Projet5\Controller;

use Projet5\Model\UserManager;

use Projet5\Service\ViewManager;

session_start();
class ControllerLogin
{
    private $_userManager;
    public function __construct()
    {
        $this->_userManager = new UserManager();
        $this->renderview = new ViewManager();
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
                    $this->renderview->generateView(array('name' => "Login", 'error' => $error), 'layout');
                    break;
            }
        }

        $this->renderview->generateView(array('name' => "Login"), 'layout');
    }

    public function logout()
    {
        $this->renderview->generateView(array('name' => "Logout"), 'layout');
    }
}
