<?php

namespace Projet5\Controller;

use Projet5\Model\PostManager;
use Projet5\View\View;
use Projet5\Model\CommentManager;
use Projet5\Service\ViewManager;
use Projet5\Model\AreaAdmin;

class ControllerPost
{
    private $postManager;
    private $commentManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin;
    }

    // Afficher tous les articles
    public function listPost()
    {
        $posts = $this->postManager->getList("user");
        $this->renderview->generateView(array(
            'name' => "ListPosts",
            'function' => $posts,
            'nameFunction' => 'posts',
        ), 'layout');
    }

    //Afficher un article
    public function post($id, $error = null)
    {
        $post = $this->postManager->get($id);

        //Filtre la view si le post est en "brouillon"
        if ($post->status() === 0) {
            $this->areaAdmin->verifyAdmin();
        }

        $this->commentManager = new CommentManager();
        $comments = $this->commentManager->getList("user", $id);

        $view = new View("Post", $error);
        $view->generate(array('post' => $post, 'comments' => $comments), 'layout');
    }
}
