<?php

namespace Projet5\Model;

use \Projet5\Model\Comment;
use \Projet5\Model\PostManager;
use \Projet5\View\View;
use \Projet5\Model\DataBase;
use \PDO;

class CommentManager extends DataBase
{

    private $postManager;

    public function add(Comment $comment)
    {
        $q = $this->dbConnect()->prepare('INSERT INTO comment(postid, author, content, date, status) VALUES (:postid, :author, :content, NOW(), :status)');

        $q->bindValue(':postid', $comment->postId(), PDO::PARAM_INT);
        $q->bindValue(':author', $comment->author(), PDO::PARAM_STR);
        $q->bindValue(':content', $comment->content(), PDO::PARAM_STR);
        $q->bindValue(':status', $comment->status(), PDO::PARAM_BOOL);

        $this->executeSql($q);
    }

    public function delete(int $id)
    {
        $q = $this->dbConnect()->prepare('DELETE FROM comment WHERE id = ' . $id);

        $this->executeSql($q);
    }

    public function deleteCommentInPost($postId)
    {
        $q = $this->dbConnect()->prepare('DELETE FROM comment WHERE postid = :postid');
        $q->bindValue(':postid', $postId, PDO::PARAM_INT);

        $this->executeSql($q);
    }

    public function validate(int $id)
    {
        $q = $this->dbConnect()->prepare('UPDATE comment SET status = 0 WHERE id = ' . $id);

        $this->executeSql($q);
    }

    public function unvalidate(int $id)
    {
        $q = $this->dbConnect()->prepare('UPDATE comment SET status = 1 WHERE id = ' . $id);

        $this->executeSql($q);
    }

    public function get($id)
    {
        $id = (int) $id;

        $q = $this->dbConnect()->prepare('SELECT id, postid, author, content, date, status FROM comment WHERE id = ' . $id);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        return new Comment($data);
    }

    public function getList($status, $postId = null)
    {
        $comment = [];

        switch ($status) {
            case "admin":
                $q = $this->dbConnect()->prepare('SELECT id, postid, author, content, date, status FROM comment ORDER BY id desc');
                break;
            case "adminmanager":
                $q = $this->dbConnect()->prepare('SELECT id, postid, author, content, date, status FROM comment WHERE status = 0 ORDER BY id desc');
                break;
            case "user":
                $q = $this->dbConnect()->prepare("SELECT id, postid, author, content, date, status FROM comment WHERE postid = $postId && status = 1 ORDER BY id desc");
                break;
        }

        $q->execute(array());
        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $comment[] = new Comment($data);
        }

        return $comment;
    }

    //Envoie une erreur si le formulaire est mal rempli
    public function errorComment($content)
    {
        $error = [];
        if (strlen($content) < 5) {
            $error['content'] = 'Votre commentaire est trop court';
        }

        return $error;
    }

    //Vérifie les données
    public function sendComment($content, $status, $postId, $author, $id = null)
    {
        $data['content'] = $content;
        $data['postId'] = $postId;
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
}
