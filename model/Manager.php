<?php

namespace Projet5\Model;

use Projet5\Service\ViewManager;

class Manager
{

    public function __construct()
    {
        $this->renderview = new ViewManager();
    }

    protected function dbConnect()
    {
        try {
            $db = new \PDO('mysql:host=localhost;dbname=project5', 'root', '');
        } catch (\PDOException $e) {
            $this->renderview->generateView(array('name' => "Error", 'function' => "La connexion à la base de données a échoué", 'nameFunction' => 'msgError'), 'layout');
            die;
        }
        return $db;
    }

    protected function executeSql($q)
    {
        try {
            $q->execute();
            $q->closeCursor();
        } catch (\PDOException $e) {
            $this->renderview->generateView(array('name' => "Error", 'function' => "L'intéraction avec la base de données n'a pas abouti", 'nameFunction' => 'msgError'), 'layout');
            die;
        }
    }
}
