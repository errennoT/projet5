<?php

namespace Projet5\Controller;

use Projet5\Model\PostManager;
use Projet5\Model\Post;
use Projet5\Model\AreaAdmin;
use Projet5\Model\CommentManager;
use Projet5\Service\GenerateView;

class ControllerAdminPost extends GenerateView
{
    private $postManager;
    private $areaAdmin;
    private $commentManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    // Afficher tous les articles
    public function listPost()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $posts = $this->postManager->getList("admin");

        $this->generateView("AdminPost", null, 'posts', $posts);
    }

    //Afficher un article
    public function post($id)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $post = $this->postManager->get($id);
        $this->generateView("Post", null, 'post', $post);
    }

    //Ajouter un article
    public function addPost()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        if (!empty($_POST)) {
            $error = $this->postManager->errorPost(htmlentities($_POST['title']), htmlentities($_POST['content']), htmlentities($_POST['chapo']), "add");
            if (empty($error)) {
                $data = $this->postManager->sendPost(htmlentities($_POST['title']), htmlentities($_POST['content']), isset($_POST['publish']) ? true : false, htmlentities($_POST['chapo']), htmlentities($_SESSION['admin']));
                $post = new Post($data);
                $this->postManager->add($post);
                header('Location: index.php?p=adminpost#list');
            } else {
                $this->generateView("AddPost", $error);
            }
        }

        $this->generateView("AddPost");
    }

    //Supprimer un article
    public function delete($id)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $postId = $this->postManager->get($id);
        $this->postManager->delete($postId);

        $comment = $this->commentManager = new CommentManager();
        $comment->deleteCommentInPost($id);

        header('Location: index.php?p=adminpost#list');
    }
}
