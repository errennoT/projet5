<?php

namespace Projet5\Model;


class DataBase
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=project5', 'root', '');
        return $db;
    }

    protected function executeSql($q)
    {
        $q->execute();
        $q->closeCursor();
    }
}
