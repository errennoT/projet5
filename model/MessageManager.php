<?php

namespace Projet5\Model;

use \Projet5\Model\Message;
use \Projet5\Model\Manager;
use \PDO;

class MessageManager extends Manager
{

    public function add(Message $message)
    {
        $q = $this->dbConnect()->prepare('INSERT INTO message(date, surname, name, content, email) VALUES (NOW(), :surname, :name, :content, :email)');

        $q->bindValue(':surname', $message->surname(), PDO::PARAM_STR);
        $q->bindValue(':name', $message->name(), PDO::PARAM_STR);
        $q->bindValue(':content', $message->content(), PDO::PARAM_STR);
        $q->bindValue(':email', $message->email(), PDO::PARAM_STR);

        $this->executeSql($q);
    }

    public function delete(Message $message)
    {
        $q = $this->dbConnect()->prepare('DELETE FROM message WHERE id = :id');
        $q->bindValue(':id', $message->id(), PDO::PARAM_INT);

        $this->executeSql($q);
    }

    public function get($id)
    {
        $id = (int) $id;

        $q = $this->dbConnect()->prepare('SELECT id, DATE_FORMAT(date, "%d/%m/%Y à %Hh%i") AS date, surname, name, content, email FROM message WHERE id = ' . $id);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        return new Message($data);
    }

    //Récupération de tous les messages
    public function getList()
    {
        $message = [];

        $q = $this->dbConnect()->prepare('SELECT id, DATE_FORMAT(date, "%d/%m/%Y à %Hh%i") AS date, surname, name, content, email FROM message ORDER BY id desc');
        $q->execute(array());
        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $message[] = new Message($data);
        }

        return $message;
    }

    //Envoie une erreur si le formulaire est mal rempli
    public function errorMessage($content, $surname, $name, $email, $function)
    {
        $error = [];

        switch ($function) {
            case "add":
                if (strlen($surname) < 2) {
                    $error['surname'] = 'Votre nom est trop court';
                }
                if (strlen($name) < 2) {
                    $error['name'] = 'Votre prénom est trop court';
                }
                if (strlen($email) < 10) {
                    $error['email'] = 'Votre adresse email est incorrecte';
                }
                if (strlen($content) < 5) {
                    $error['content'] = 'Votre message est trop court';
                }
                return $error;
                break;
            case "answer":
                if (strlen($content) < 5) {
                    $error['content'] = 'Votre message est trop court';
                }
                return $error;
                break;
        }

        return $error;
    }

    //Vérifie les données
    public function validateData($content, $surname = null, $name = null, $email = null)
    {
        $data['surname'] = $surname;
        $data['name'] = $name;
        $data['email'] = $email;
        $data['content'] = $content;
        $data['subject'] = "Réponse au message";

        return $data;
    }
}
