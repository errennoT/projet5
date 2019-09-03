<?php

namespace Projet5\Model;


class Manager
{
    protected function dbConnect()
    {
        try {
            $db = new \PDO('mysql:host=localhost;dbname=project5', 'root', '');
        }catch (\PDOException $e)
        {
          echo 'La connexion a échoué.<br />';
          die;
        }
        return $db;
    }

    protected function executeSql($q)
    {
        try {
        $q->execute();
        $q->closeCursor();
        } catch (\PDOException $e)
        {
            echo "L'action a échoué.";
            die;
        }
    }
}
