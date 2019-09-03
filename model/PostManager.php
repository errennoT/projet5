<?php

namespace Projet5\Model;

use \Projet5\Model\Post;
use \Projet5\Model\Manager;
use \PDO;

class PostManager extends Manager
{

    public function add(Post $post)
    {
        $q = $this->dbConnect()->prepare('INSERT INTO post(title, content, date, status, chapo, author) VALUES (:title, :content, NOW(), :status, :chapo, :author)');

        $q->bindValue(':title', $post->title(), PDO::PARAM_STR);
        $q->bindValue(':content', $post->content(), PDO::PARAM_STR);
        $q->bindValue(':status', $post->status(), PDO::PARAM_BOOL);
        $q->bindValue(':chapo', $post->chapo(), PDO::PARAM_STR);
        $q->bindValue(':author', $post->author(), PDO::PARAM_STR);

        $this->executeSql($q);
    }

    public function delete(int $id)
    {
        $q = $this->dbConnect()->prepare('DELETE FROM post WHERE id = ' . $id);

        $this->executeSql($q);
    }

    public function published(int $id)
    {
        $q = $this->dbConnect()->prepare('UPDATE post SET status = 0 WHERE id = ' . $id);

        $this->executeSql($q);
    }

    public function draft(int $id)
    {
        $q = $this->dbConnect()->prepare('UPDATE post SET status = 1 WHERE id = ' . $id);

        $this->executeSql($q);
    }

    public function get($id)
    {
        $id = (int) $id;
        $q = $this->dbConnect()->prepare('SELECT id, title, content, DATE_FORMAT(date, "%d/%m/%Y à %Hh%i") AS date, DATE_FORMAT(updated, "%d/%m/%Y à %Hh%i") AS updated, status, chapo, author FROM post WHERE id = ' . $id);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        return new Post($data);
    }

    //Vérifie si le status de l'article est en brouillon ou en publié + récupération de tous les articles
    public function getList($status)
    {
        $post = [];

        switch ($status) {
            case "admin":
                $q = $this->dbConnect()->prepare('SELECT id, title, content, DATE_FORMAT(date, "%d/%m/%Y à %Hh%i") AS date, DATE_FORMAT(updated, "%d/%m/%Y à %Hh%i") AS updated, status, chapo, author FROM post ORDER BY id desc');
                break;
            case "user":
                $q = $this->dbConnect()->prepare('SELECT id, title, content, DATE_FORMAT(date, "%d/%m/%Y à %Hh%i") AS date, DATE_FORMAT(updated, "%d/%m/%Y à %Hh%i") AS updated,status, chapo, author FROM post WHERE status = "1" ORDER BY id desc');
                break;
        }

        $q->execute(array());
        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $post[] = new Post($data);
        }

        return $post;
    }

    public function update(Post $post)
    {
        $q = $this->dbConnect()->prepare('UPDATE post SET title = :title, content = :content, updated = NOW(), status = :status, chapo = :chapo, author = :author WHERE id = :id');


        $q->bindValue(':title', $post->title(), PDO::PARAM_STR);
        $q->bindValue(':content', $post->content(), PDO::PARAM_STR);
        $q->bindValue(':status', $post->status(), PDO::PARAM_BOOL);
        $q->bindValue(':id', $post->id(), PDO::PARAM_INT);
        $q->bindValue(':chapo', $post->chapo(), PDO::PARAM_STR);
        $q->bindValue(':author', $post->author(), PDO::PARAM_STR);

        $this->executeSql($q);
    }

    //Vérifie les données
    public function validateData($title, $content, $status, $chapo, $author, $id = null)
    {
        $data['title'] = $title;
        $data['content'] = $content;
        $data['chapo'] = $chapo;
        $data['author'] = $author;
        $data['id'] = $id;

        switch ($status) {
            case true:
                $data['status'] = 1;
                break;
            case false:
                $data['status'] = 0;
                break;
        }

        return $data;
    }

    //Envoie une erreur si le formulaire est mal rempli
    public function errorPost($title, $content, $chapo, $function, $author = null)
    {
        $error = [];

        switch ($function) {
            case "add":
                if (strlen($title) < 3) {
                    $error['title'] = 'Votre titre est trop court';
                }
                if (strlen($content) < 10) {
                    $error['content'] = 'Votre article est trop court';
                }
                if (strlen($chapo) < 5) {
                    $error['chapo'] = 'Votre introduction est trop courte';
                }
                return $error;
                break;

            case "update":
                if (strlen($title) < 3) {
                    $error['title'] = 'Votre titre est trop court';
                }
                if (strlen($content) < 10) {
                    $error['content'] = 'Votre article est trop court';
                }
                if (strlen($chapo) < 5) {
                    $error['chapo'] = 'Votre introduction est trop courte';
                }
                if (strlen($author) < 2) {
                    $error['author'] = 'Votre pseudo est trop court';
                }
                return $error;
                break;
        }
        return $error;
    }
}
