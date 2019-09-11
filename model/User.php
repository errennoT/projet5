<?php

namespace Projet5\Model;

use Projet5\Model\DataManager;
use Projet5\Service\ViewManager;

class User extends DataManager
{
    private $_id;
    private $_login;
    private $_password;
    private $_email;
    private $_status;
    private $_admin;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->hydrate($data);
        } else { //si le lien "$id=" est incorrect, renvoie une erreur
            $this->renderview = new ViewManager();
            $this->renderview->generateView(array('name' => "Error"), "layout");
        }
    }

    //getters list
    public function id()
    {
        return $this->_id;
    }

    public function login()
    {
        return $this->_login;
    }

    public function password()
    {
        return $this->_password;
    }

    public function email()
    {
        return $this->_email;
    }

    public function status()
    {
        return $this->_status;
    }

    public function admin()
    {
        return $this->_admin;
    }

    //setters list
    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setLogin($login)
    {
        if (is_string($login)) {
            $this->_login = $login;
        }
    }

    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->_password = $password;
        }
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->_email = $email;
        }
    }

    public function setStatus($status)
    {
        $status = (int) $status;
        if ($status === 0 || $status === 1) {
            $this->_status = $status;
        }
    }

    public function setAdmin($admin)
    {
        $admin = (int) $admin;
        if ($admin === 0 || $admin === 1) {
            $this->_admin = $admin;
        }
    }
}
