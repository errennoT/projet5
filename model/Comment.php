<?php

namespace Projet5\Model;

use Projet5\Service\Hydrate;
use Projet5\Service\ViewManager;

class Comment extends Hydrate
{
    private $_id;
    private $_date;
    private $_status;
    private $_postId;
    private $_author;

public function __construct($data)
{
    if (is_array($data)) {
        $this->hydrate($data);
    } else {
        $this->renderview = new ViewManager();
        $this->renderview->generateView("Error");
    }
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

public function status()
{
    return $this->_status;
}

public function postId()
{
    return $this->_postId;
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

public function setContent($content)
{
    if (is_string($content)){
        $this->_content = $content;
    }
}

public function setDate($date)
{
        $this->_date = $date;
}

public function setStatus($status)
{
    $status = (int) $status;
    if ($status === 0 || $status === 1){
        $this->_status = $status;
    }
}

public function setPostId($postId)
{
    $postId = (int) $postId;

    if ($postId > 0) {
        $this->_postId = $postId;
    }
}

public function setAuthor($author)
{
    if (is_string($author)){
        $this->_author = $author;
    }
}

}

