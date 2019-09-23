<?php

namespace Projet5\Controller;

use Projet5\Model\User;
use Projet5\Model\UserManager;
use Projet5\Service\SecuritySuperGlobal;
use Projet5\Service\ViewManager;

class ControllerRegister
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

    //Créer un compte utilisateur
    public function add()
    {
        if (!empty($this->superGlobal->undirectUseSP($_POST))) {
            $error = $this->_userManager->getError(filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            if (empty($error)) {
                $data = $this->_userManager->validateData(filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), null, 1, 0);
                $user = new User($data);
                $error = 'succes';
                $this->_userManager->add($user);
                $this->superGlobal->undirectUseSP($_POST['login'] = "");
                $this->superGlobal->undirectUseSP($_POST['email'] = "");

                $this->renderview->generateView(array('name' => "Add", 'error' => $error), 'layout');
            }
            $this->renderview->generateView(array('name' => "Add", 'error' => $error), 'layout');
        }

        $this->renderview->generateView(array('name' => "Add"), 'layout');
    }
}
