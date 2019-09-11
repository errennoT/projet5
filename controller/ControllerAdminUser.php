<?php

namespace Projet5\Controller;

use Projet5\Model\User;
use Projet5\Model\UserManager;
use Projet5\Model\AreaAdmin;

use Projet5\Service\ViewManager;

use Volnix\CSRF\CSRF;

class ControllerAdminUser
{
    private $_userManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->_userManager = new UserManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin;
    }

    //Liste des utilisateurs
    public function listUser()
    {
        $this->areaAdmin->verifyAdmin();

        $users = $this->_userManager->getList();

        $this->renderview->generateView(array('name' => "AdminUser",'function' => $users,'nameFunction' => 'users'), 'layoutPageAdmin');
    }

    //Supprimer un utilisateur
    public function delete($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->_userManager->delete($id);
        header('Location: index.php?u=adminuser#list');
    }

    //Bannir un utilisateur
    public function ban($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->_userManager->ban($id);
        header('Location: index.php?u=adminuser#list');
    }

    //Débannir un utilisateur
    public function unBan($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->_userManager->unBan($id);
        header('Location: index.php?u=adminuser#list');
    }

    //Définir un nouvel admin
    public function setAdmin($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->_userManager->setAdmin($id);
        header('Location: index.php?u=adminuser#list');
    }

    //Supprimer un administrateur
    public function unsetAdmin($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->_userManager->unsetAdmin($id);
        header('Location: index.php?u=adminuser#list');
    }

    //Modifier un utilisateur
    public function editUser($id)
    {
        $this->areaAdmin->verifyAdmin();

        $user = $this->_userManager->get($id);

        if (!empty($_POST) && CSRF::validate($_POST) ) {
            $error = $this->_userManager->getError(htmlentities($_POST['login']), htmlentities($_POST['password']), htmlentities($_POST['email']));
            if (empty($error)) {
                $data = $this->_userManager->validateData(htmlentities($_POST['password']), htmlentities($_POST['login']), htmlentities($_POST['email']), htmlentities($_POST['id']));
                $user = new User($data);
                $this->_userManager->update($user);
                header('Location: index.php?u=adminuser');
            } else {
                $user = $this->_userManager->get($id);

                $this->renderview->generateView(array(
                    'name' => "EditUser",
                    'error' => $error,
                    'function' => $user,
                    'nameFunction' => 'user'
                ), 'layoutPageAdmin');
            }
        }
        $this->renderview->generateView(array('name' => "EditUser",'function' => $user,'nameFunction' => 'user'), 'layoutPageAdmin');
    }
}
