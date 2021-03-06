<?php

namespace Projet5\Model;

use Projet5\Model\DataManager;
use Projet5\Service\ViewManager;

class Post extends DataManager
{
    private $_id;
    private $_title;
    private $_content;
    private $_date;
    private $_updated;
    private $_status;
    private $_chapo;
    private $_author;

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

    public function title()
    {
        return $this->_title;
    }

    public function content()
    {
        return $this->_content;
    }

    public function date()
    {
        return $this->_date;
    }

    public function updated()
    {
        return $this->_updated;
    }

    public function status()
    {
        return $this->_status;
    }

    public function chapo()
    {
        return $this->_chapo;
    }

    public function author()
    {
        return $this->_author;
    }

    //setters list
    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->_title = $title;
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

    public function setUpdated($updated)
    {
        $this->_updated = $updated;
    }

    public function setStatus($status)
    {
        $status = (int) $status;
        if ($status === 0 || $status === 1) {
            $this->_status = $status;
        }
    }

    public function setChapo($chapo)
    {
        if (is_string($chapo)) {
            $this->_chapo = $chapo;
        }
    }

    public function setAuthor($author)
    {
        if (is_string($author)) {
            $this->_author = $author;
        }
    }
}
