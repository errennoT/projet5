<?php

namespace Projet5\Model;

use \Projet5\Service\Hydrate;

class Message extends Hydrate
{
    private $_id;
    private $_date;
    private $_surname;
    private $_name;
    private $_content;
    private $_email;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    //getters list
    public function id()
    {
        return $this->_id;
    }

    public function content()
    {
        return $this->_content;
    }

    public function date()
    {
        return $this->_date;
    }

    public function surname()
    {
        return $this->_surname;
    }

    public function name()
    {
        return $this->_name;
    }

    public function email()
    {
        return $this->_email;
    }

    //setters list

    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }

    public function setSurname($surname)
    {
        if (is_string($surname)) {
            $this->_surname = $surname;
        }
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->_name = $name;
        }
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->_email = $email;
        }
    }
}
