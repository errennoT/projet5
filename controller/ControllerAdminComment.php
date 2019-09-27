<?php

namespace Projet5\Controller;

use \Projet5\Model\CommentManager;
use \Projet5\Model\AreaAdmin;

use Projet5\Service\ViewManager;

use Projet5\Service\SecurityCsrf;
use Projet5\Service\SecuritySuperGlobal;
use Volnix\CSRF\CSRF;

class ControllerAdminComment
{
    private $commentManager;
    private $areaAdmin;
    private $renderview;
    private $csrf;
    private $superGlobal;

    public function __construct()
    {
        $this->commentManager = new CommentManager();
        $this->renderview = new ViewManager();

        $this->areaAdmin = new AreaAdmin();
        $this->csrf = new SecurityCsrf();
        $this->superGlobal = new SecuritySuperGlobal();
    }

    //Liste des commentaires en attentes de validations
    public function listCommentValidate()
    {
        $this->areaAdmin->verifyAdmin();

        $comments = $this->commentManager->getList("admin");
        $this->renderview->generateView(array('name' => "AdminComment", 'function' => $comments, 'nameFunction' => 'comments'), 'layoutPageAdmin');
    }

    //Liste des commentaires validés
    public function listCommentUnvalidate()
    {
        $this->areaAdmin->verifyAdmin();

        $comments = $this->commentManager->getList("adminmanager");
        $this->renderview->generateView(array('name' => "AdminCommentManager", 'function' => $comments, 'nameFunction' => 'comments'), 'layoutPageAdmin');
    }

    //Supprimer un commentaire
    public function delete($commentId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->commentManager->delete($commentId);

        header('Location: ' . $this->superGlobal->undirectUseServer('HTTP_REFERER') . '#list');
        die;
    }

    //Status validé
    public function validate($commentId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));


        $this->commentManager->validate($commentId);

        header('Location: ' . $this->superGlobal->undirectUseServer('HTTP_REFERER') . '#list');
        die;
    }

    //Status en attente
    public function unvalidate($commentId)
    {
        $this->areaAdmin->verifyAdmin();
        $this->csrf->testCsrf(CSRF::validate($this->superGlobal->undirectUsePost()));

        $this->commentManager->unvalidate($commentId);

        header('Location: ' . $this->superGlobal->undirectUseServer('HTTP_REFERER') . '#list');
        die;
    }

    //Afficher un commentaire
    public function comment($commentId)
    {
        $this->areaAdmin->verifyAdmin();

        $comment = $this->commentManager->get($commentId);

        $this->renderview->generateView(array('name' => "Comment", 'function' => $comment, 'nameFunction' => 'comment'), 'layoutPageAdmin');
    }
}
