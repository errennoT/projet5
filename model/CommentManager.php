<?php

namespace Projet5\Model;

use \Projet5\Model\Comment;
use \Projet5\Model\Manager;
use \PDO;

class CommentManager extends Manager
{

    public function add(Comment $comment)
    {
        $sql = $this->dbConnect()->prepare('INSERT INTO comment(postid, author, content, date, status) VALUES (:postid, :author, :content, NOW(), :status)');

        $sql->bindValue(':postid', $comment->postId(), PDO::PARAM_INT);
        $sql->bindValue(':author', $comment->author(), PDO::PARAM_STR);
        $sql->bindValue(':content', $comment->content(), PDO::PARAM_STR);
        $sql->bindValue(':status', $comment->status(), PDO::PARAM_BOOL);

        $this->executeSql($sql);
    }

    public function delete(int $commentId)
    {
        $sql = $this->dbConnect()->prepare('DELETE FROM comment WHERE id = ' . $commentId);

        $this->executeSql($sql);
    }

    public function deleteCommentInPost($postId)
    {
        $sql = $this->dbConnect()->prepare('DELETE FROM comment WHERE postid = :postid');
        $sql->bindValue(':postid', $postId, PDO::PARAM_INT);

        $this->executeSql($sql);
    }

    public function validate(int $commentId)
    {
        $sql = $this->dbConnect()->prepare('UPDATE comment SET status = 0 WHERE id = ' . $commentId);

        $this->executeSql($sql);
    }

    public function unvalidate(int $commentId)
    {
        $sql = $this->dbConnect()->prepare('UPDATE comment SET status = 1 WHERE id = ' . $commentId);

        $this->executeSql($sql);
    }

    public function get($commentId)
    {
        $commentId = (int) $commentId;

        $sql = $this->dbConnect()->prepare('SELECT id, postid, author, content, DATE_FORMAT(date, "%d/%m/%Y à %Hh%i") AS date, status FROM comment WHERE id = ' . $commentId);
        $sql->execute(array($commentId));
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        return new Comment($data);
    }

    public function getList($status, $postId = null)
    {
        $comment = [];

        switch ($status) {
            case "admin":
                $sql = $this->dbConnect()->prepare('SELECT id, postid, author, content, DATE_FORMAT(date, "%d/%m/%Y à %Hh%i") AS date, status FROM comment ORDER BY id desc');
                break;
            case "adminmanager":
                $sql = $this->dbConnect()->prepare('SELECT id, postid, author, content, DATE_FORMAT(date, "%d/%m/%Y à %Hh%i") AS date, status FROM comment WHERE status = 0 ORDER BY id desc');
                break;
            case "user":
                $sql = $this->dbConnect()->prepare("SELECT id, postid, author, content, DATE_FORMAT(date, '%d/%m/%Y à %Hh%i') AS date, status FROM comment WHERE postid = $postId && status = 1 ORDER BY id desc");
                break;
        }

        $sql->execute(array());
        while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
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
    public function validateData($content, $status, $postId, $author, $commentId = null)
    {
        $data['content'] = $content;
        $data['status'] = $status;
        $data['postId'] = $postId;
        $data['author'] = $author;
        $data['id'] = $commentId;

        return $data;
    }
}
