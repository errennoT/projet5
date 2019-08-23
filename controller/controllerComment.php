<?php

namespace Projet5\Controller;

use Projet5\Model\CommentManager;
use Projet5\Model\Comment;
use Projet5\Service\GenerateView;


class ControllerComment extends GenerateView
{
    private $commentManager;

    public function __construct()
    {
        $this->commentManager = new CommentManager();
    }

    public function addComment($postId)
    {
        if (!empty($_POST)) {
            $error = $this->commentManager->errorComment($_POST['contentComment'], $postId);

            if (empty($error)) {
                if (isset($_SESSION['user'])) {
                    $data = $this->commentManager->sendComment($_POST['contentComment'], 0, $postId, $_SESSION['user']);

                    $comment = new Comment($data);
                    $this->commentManager->add($comment);

                    $this->generateView("MessageComment", null);
                    
                } elseif (isset($_SESSION['admin'])) {
                    $data = $this->commentManager->sendComment($_POST['contentComment'], 1, $postId, $_SESSION['admin']);

                    $comment = new Comment($data);
                    $this->commentManager->add($comment);

                    header('location: index.php?p=listpost');
                }
            }
        }
    }
}
