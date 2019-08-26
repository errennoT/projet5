<?php

namespace Projet5\Controller;

use Projet5\Model\User;
use Projet5\Model\UserManager;

use Projet5\Service\RenderView;

class ControllerRegister
{
    private $_userManager;

    public function __construct()
    {
        $this->_userManager = new UserManager();
        $this->renderview = new RenderView();
    }

    //Créer un compte utilisateur
    public function add()
    {
        if (!empty($_POST)) {
            $error = $this->_userManager->getError($_POST['login'], $_POST['password'], $_POST['email']);
            if (empty($error)) {
                $data = $this->_userManager->register(htmlentities($_POST['password']), htmlentities($_POST['login']), htmlentities($_POST['email']), null , 1, 0);
                $user = new User($data);
                $error = 'succes';
                $this->_userManager->add($user);
                $_POST['login'] = "";
                $_POST['email'] = "";
            } else {
                $this->renderview->generateView("Add", $error);
            }
        }

        $this->renderview->generateView("Add");
    }
}
