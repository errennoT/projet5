<?php

namespace Projet5\Controller;

use Projet5\Model\User;
use Projet5\Model\UserManager;
use Projet5\Model\AreaAdmin;

use Projet5\Service\ViewManager;
use Projet5\Service\SecurityCsrf;
use Projet5\Service\SecuritySuperGlobal;
use Volnix\CSRF\CSRF;

class ControllerAdminUser
{
    private $_userManager;
    private $renderview;
    private $areaAdmin;
    private $csrf;
    private $superGlobal;

    public function __construct()
    {
        $this->_userManager = new UserManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin();
        $this->csrf = new SecurityCsrf();
        $this->superGlobal = new SecuritySuperGlobal();
    }

    //Liste des utilisateurs
    public function listUser()
    {
        $this->areaAdmin->verifyAdmin();

        $users = $this->_userManager->getList();

        $this->renderview->generateView(array('name' => "AdminUser", 'function' => $users, 'nameFunction' => 'users'), 'layoutPageAdmin');
    }

    //Supprimer un utilisateur
    public function delete($userId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->_userManager->delete($userId);
        header('Location: index.php?u=adminuser#list');
    }

    //Bannir un utilisateur
    public function ban($userId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->_userManager->ban($userId);
        header('Location: index.php?u=adminuser#list');
    }

    //Débannir un utilisateur
    public function unBan($userId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->_userManager->unBan($userId);
        header('Location: index.php?u=adminuser#list');
    }

    //Définir un nouvel admin
    public function setAdmin($userId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->_userManager->setAdmin($userId);
        header('Location: index.php?u=adminuser#list');
    }

    //Supprimer un administrateur
    public function unsetAdmin($userId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->_userManager->unsetAdmin($userId);
        header('Location: index.php?u=adminuser#list');
    }

    //Modifier un utilisateur
    public function editUser($userId)
    {
        $this->areaAdmin->verifyAdmin();

        $user = $this->_userManager->get($userId);

        if (!empty($this->superGlobal->undirectUsePost()) && CSRF::validate($this->superGlobal->undirectUsePost())) {
            $error = $this->_userManager->getError($this->superGlobal->undirectUsePost('login'), $this->superGlobal->undirectUsePost('password'), $this->superGlobal->undirectUsePost('email'));
            if (empty($error)) {
                $data = $this->_userManager->validateData($this->superGlobal->undirectUsePost('password'), $this->superGlobal->undirectUsePost('login'), $this->superGlobal->undirectUsePost('email'), $this->superGlobal->undirectUsePost('id'));
                $user = new User($data);
                $this->_userManager->update($user);
                header('Location: index.php?u=adminuser');
            }
            $user = $this->_userManager->get($userId);

            $this->renderview->generateView(array(
                'name' => "EditUser",
                'error' => $error,
                'function' => $user,
                'nameFunction' => 'user'
            ), 'layoutPageAdmin');
        }
        $this->renderview->generateView(array('name' => "EditUser", 'function' => $user, 'nameFunction' => 'user'), 'layoutPageAdmin');
    }
}
