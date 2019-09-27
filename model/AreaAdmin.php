<?php

namespace Projet5\Model;

use Projet5\Service\SecuritySuperGlobal;

class AreaAdmin
{
    private $superGlobal;

    public function __construct()
    {
        $this->superGlobal = new SecuritySuperGlobal;
    }

    //Vérifie si c'est un administrateur
    public function verifyAdmin()
    {
        if (empty($this->superGlobal->undirectUseSession('admin'))) {
            header('Location: index.php?u=accesdenied');
            die;
        }
    }
}
