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
    private $superGlobal;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin();
        $this->csrf = new SecurityCsrf();
        $this->superGlobal = new SecuritySuperGlobal();
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

        if (!empty($this->superGlobal->undirectUsePost()) && CSRF::validate($this->superGlobal->undirectUsePost())) {
            $error = $this->postManager->errorPost($this->superGlobal->undirectUsePost('title'), $this->superGlobal->undirectUsePost('content'), $this->superGlobal->undirectUsePost('chapo'), "add");
            if (empty($error)) {
                $data = $this->postManager->validateData($this->superGlobal->undirectUsePost('title'), $this->superGlobal->undirectUsePost('content'), isset($_POST['publish']) ? true : false, $this->superGlobal->undirectUsePost('chapo'), $this->superGlobal->undirectUseSession('admin'));
                $post = new Post($data);
                $this->postManager->add($post);
                header('Location: index.php?p=adminpost#list');
            } else {
                $this->renderview->generateView(array('name' => "AddPost", 'error' => $error), 'layoutPageAdmin');
            }
        } else {

            $this->renderview->generateView(array('name' => "AddPost"), 'layoutPageAdmin');
        }
    }

    //Supprimer un article
    public function delete($postId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

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

        if (!empty($this->superGlobal->undirectUsePost()) && CSRF::validate($this->superGlobal->undirectUsePost())) {
            $error = $this->postManager->errorPost($this->superGlobal->undirectUsePost('title'), $this->superGlobal->undirectUsePost('content'), $this->superGlobal->undirectUsePost('chapo'), "update", $this->superGlobal->undirectUsePost('author'));
            if (empty($error)) {
                $data = $this->postManager->validateData($this->superGlobal->undirectUsePost('title'), $this->superGlobal->undirectUsePost('content'), isset($_POST['publish']) ? true : false, $this->superGlobal->undirectUsePost('chapo'), $this->superGlobal->undirectUsePost('author'), $this->superGlobal->undirectUsePost('id'));
                $post = new Post($data);
                $this->postManager->update($post);
                header('Location: index.php?p=adminpost#list');
            }
            $this->renderview->generateView(array('name' => "EditPost", 'error' => $error, 'function' => $post, 'nameFunction' => 'post'), 'layoutPageAdmin');
        } else {
            $this->renderview->generateView(array('name' => "EditPost", 'function' => $post, 'nameFunction' => 'post'), 'layoutPageAdmin');
        }
    }

    //Status publié
    public function published($postId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->postManager->published($postId);
        header('Location: index.php?p=adminpost#list');
    }

    //Status brouillon
    public function draft($postId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->postManager->draft($postId);
        header('Location: index.php?p=adminpost#list');
    }
}
