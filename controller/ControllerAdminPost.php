<?php

namespace Projet5\Controller;

use Projet5\Model\PostManager;
use Projet5\Model\Post;
use Projet5\Model\AreaAdmin;
use Projet5\Model\CommentManager;

use Projet5\Service\ViewManager;

class ControllerAdminPost
{
    private $postManager;
    private $areaAdmin;
    private $commentManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin;
    }

    // Afficher tous les articles
    public function listPost()
    {
        $this->areaAdmin->verifyAdmin();

        $posts = $this->postManager->getList("admin");

        $this->renderview->generateView(array('name' => "AdminPost", 'function' => $posts, 'nameFunction' => 'posts'), 'layoutPageAdmin');
    }

    //Afficher un article
    public function post($id)
    {
        $this->areaAdmin->verifyAdmin();

        $post = $this->postManager->get($id);
        $this->renderview->generateView(array('name' => "Post", 'function' => $post, 'nameFunction' => 'post'), 'layoutPageAdmin');
    }

    //Ajouter un article
    public function addPost()
    {
        $this->areaAdmin->verifyAdmin();

        if (!empty($_POST)) {
            $error = $this->postManager->errorPost(htmlentities($_POST['title']), htmlentities($_POST['content']), htmlentities($_POST['chapo']), "add");
            if (empty($error)) {
                $data = $this->postManager->validateData(htmlentities($_POST['title']), htmlentities($_POST['content']), isset($_POST['publish']) ? true : false, htmlentities($_POST['chapo']), htmlentities($_SESSION['admin']));
                $post = new Post($data);
                $this->postManager->add($post);
                header('Location: index.php?p=adminpost#list');
            } else {
                $this->renderview->generateView(array('name' => "AddPost", 'error' => $error), 'layoutPageAdmin');
            }
        }

        $this->renderview->generateView(array('name' => "AddPost"), 'layoutPageAdmin');
    }

    //Supprimer un article
    public function delete($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->postManager->delete($id);

        $comment = $this->commentManager = new CommentManager();
        $comment->deleteCommentInPost($id);

        header('Location: index.php?p=adminpost#list');
    }

    //Modifier un article
    public function editPost($id)
    {
        $this->areaAdmin->verifyAdmin();

        $post = $this->postManager->get($id);

        if (!empty($_POST)) {
            $error = $this->postManager->errorPost(htmlentities($_POST['title']), htmlentities($_POST['content']), htmlentities($_POST['chapo']), "update", htmlentities($_POST['author']));
            if (empty($error)) {
                $data = $this->postManager->validateData(htmlentities($_POST['title']), htmlentities($_POST['content']), isset($_POST['publish']) ? true : false, $_POST['chapo'], htmlentities($_POST['author']), htmlentities($_POST['id']));
                $post = new Post($data);
                $this->postManager->update($post);
                header('Location: index.php?p=adminpost#list');
            } else {
                $this->renderview->generateView(array('name' => "EditPost", 'error' => $error, 'function' => $post, 'nameFunction' => 'post'), 'layoutPageAdmin');
            }
        }
        $this->renderview->generateView(array('name' => "EditPost", 'function' => $post, 'nameFunction' => 'post'), 'layoutPageAdmin');
    }

    //Status publié
    public function published($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->postManager->published($id);
        header('Location: index.php?p=adminpost#list');
    }

    //Status brouillon
    public function draft($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->postManager->draft($id);
        header('Location: index.php?p=adminpost#list');
    }
}
