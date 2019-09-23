<?php

namespace Projet5\Controller;

use Projet5\Model\CommentManager;
use Projet5\Model\Comment;

use Projet5\Model\PostManager;
use Projet5\Service\SecuritySuperGlobal;
use Projet5\Service\ViewManager;
use Projet5\View\View;


class ControllerComment
{
    private $commentManager;
    private $renderview;
    private $superGlobal;

    public function __construct()
    {
        $this->commentManager = new CommentManager();
        $this->renderview = new ViewManager();
        $this->superGlobal = new SecuritySuperGlobal();
    }

    //Ajouter un commentaire en tant qu'administrateur
    public function addComment($postId)
    {
        if (!empty($this->superGlobal->undirectUseSP($_POST))) {
            $error = $this->commentManager->errorComment(filter_var($_POST['contentComment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            if (empty($error)) {
                if (isset($_SESSION['user'])) {
                    $data = $this->commentManager->validateData(filter_var($_POST['contentComment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), 0, $postId, $this->superGlobal->undirectUseSP($_SESSION['user']));

                    $comment = new Comment($data);
                    $this->commentManager->add($comment);

                    $this->renderview->generateView(array('name' => "MessageComment"), 'layout');
                } elseif (isset($_SESSION['admin'])) {
                    $data = $this->commentManager->validateData(filter_var($_POST['contentComment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), 1, $postId, $this->superGlobal->undirectUseSP($_SESSION['admin']));

                    $comment = new Comment($data);
                    $this->commentManager->add($comment);

                    header("location: index.php?p=post&id=$postId");
                }
            }
            $postManager = $this->postManager = new PostManager();
            $post = $postManager->get($postId);

            $comments = $this->commentManager->getList("user", $postId);

            $view = new View("Post", $error);
            $view->generate(array('post' => $post, 'comments' => $comments), "layout");
        }
    }
}
