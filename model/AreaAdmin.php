<?php

namespace Projet5\Model;

class AreaAdmin
{

    //Vérifie si c'est un administrateur
    public function verifyAdmin()
    {
        if (!isset($_SESSION['admin']))
        {
            header('Location: index.php?u=accesdenied');
            die;
        }
    }

}