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
        if (!empty($this->superGlobal->undirectUsePost())) {
            $error = $this->_userManager->getError($this->superGlobal->undirectUsePost('login'), $this->superGlobal->undirectUsePost('password'), $this->superGlobal->undirectUsePost('email'));
            if (empty($error)) {
                $data = $this->_userManager->validateData($this->superGlobal->undirectUsePost('password'), $this->superGlobal->undirectUsePost('login'), $this->superGlobal->undirectUsePost('email'), null, 1, 0);
                $user = new User($data);
                $error = 'succes';
                $this->_userManager->add($user);
                $this->superGlobal->undirectUsePost('login');
                $this->superGlobal->undirectUsePost('email');

                $this->renderview->generateView(array('name' => "Add", 'error' => $error), 'layout');
            }
            $this->renderview->generateView(array('name' => "Add", 'error' => $error), 'layout');
        } else {

            $this->renderview->generateView(array('name' => "Add"), 'layout');
        }
    }
}
