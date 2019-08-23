<?php

namespace Projet5\Controller;

use Projet5\Model\PostManager;
use Projet5\View\View;
use Projet5\Model\CommentManager;
use Projet5\Service\GenerateView;

class ControllerPost extends GenerateView
{
    private $postManager;
    private $commentManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
    }
    
    // Afficher tous les articles
    public function listPost()
    {
        $posts = $this->postManager->getList("user");
        $this->generateView("ListPosts", null, 'posts', $posts);
    }

    //Afficher un article
    public function post($id, $error = null)
    {
        $post = $this->postManager->get($id);

        $this->commentManager = new CommentManager();
        $comments = $this->commentManager->getList("user", $id);

        $view = new View("Post", $error);
        $view->generate(array('post' => $post, 'comments' => $comments));
    }
}