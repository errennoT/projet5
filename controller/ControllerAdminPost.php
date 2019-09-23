<?php

namespace Projet5\Controller;

use Projet5\Model\PostManager;
use Projet5\Model\Post;
use Projet5\Model\AreaAdmin;
use Projet5\Model\CommentManager;

use Projet5\Service\ViewManager;
use Projet5\Service\SecurityCsrf;
use Projet5\Service\SecuritySuperGlobal;
use Volnix\CSRF\CSRF;

class ControllerAdminPost
{
    private $postManager;
    private $areaAdmin;
    private $commentManager;
    private $csrf;
    private $post;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin();
        $this->csrf = new SecurityCsrf();
        $this->post = new SecuritySuperGlobal();
    }

    // Afficher tous les articles
    public function listPost()
    {
        $this->areaAdmin->verifyAdmin();

        $posts = $this->postManager->getList("admin");

        $this->renderview->generateView(array('name' => "AdminPost", 'function' => $posts, 'nameFunction' => 'posts'), 'layoutPageAdmin');
    }

    //Afficher un article
    public function post($postId)
    {
        $this->areaAdmin->verifyAdmin();

        $post = $this->postManager->get($postId);
        $this->renderview->generateView(array('name' => "Post", 'function' => $post, 'nameFunction' => 'post'), 'layoutPageAdmin');
    }

    //Ajouter un article
    public function addPost()
    {
        $this->areaAdmin->verifyAdmin();

        if (!empty($this->post->undirectUseSP($_POST)) && CSRF::validate($this->post->undirectUseSP($_POST))) {
            $error = $this->postManager->errorPost(filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['chapo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), "add");
            if (empty($error)) {
                $data = $this->postManager->validateData(filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), isset($_POST['publish']) ? true : false, filter_var($_POST['chapo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_SESSION['admin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
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
    public function delete($postId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->post->undirectUseSP($_POST)));

        $this->postManager->delete($postId);

        $comment = $this->commentManager = new CommentManager();
        $comment->deleteCommentInPost($postId);

        header('Location: index.php?p=adminpost#list');
    }

    //Modifier un article
    public function editPost($postId)
    {
        $this->areaAdmin->verifyAdmin();

        $post = $this->postManager->get($postId);

        if (!empty($this->post->undirectUseSP($_POST)) && CSRF::validate($this->post->undirectUseSP($_POST))) {
            $error = $this->postManager->errorPost(filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['chapo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), "update", filter_var($_POST['author'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            if (empty($error)) {
                $data = $this->postManager->validateData(filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), isset($_POST['publish']) ? true : false, filter_var($_POST['chapo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['author'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_var($_POST['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $post = new Post($data);
                $this->postManager->update($post);
                header('Location: index.php?p=adminpost#list');
            }
            $this->renderview->generateView(array('name' => "EditPost", 'error' => $error, 'function' => $post, 'nameFunction' => 'post'), 'layoutPageAdmin');
        }
        $this->renderview->generateView(array('name' => "EditPost", 'function' => $post, 'nameFunction' => 'post'), 'layoutPageAdmin');
    }

    //Status publié
    public function published($postId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->post->undirectUseSP($_POST)));

        $this->postManager->published($postId);
        header('Location: index.php?p=adminpost#list');
    }

    //Status brouillon
    public function draft($postId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->post->undirectUseSP($_POST)));

        $this->postManager->draft($postId);
        header('Location: index.php?p=adminpost#list');
    }
}
