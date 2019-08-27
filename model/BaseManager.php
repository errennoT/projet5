<?php

namespace Projet5\Model;


class DataBase
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
        $q->execute();
        $q->closeCursor();
    }
}
