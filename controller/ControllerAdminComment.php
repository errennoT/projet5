<?php

namespace Projet5\Controller;

use \Projet5\Model\CommentManager;
use \Projet5\Model\AreaAdmin;

use Projet5\Service\ViewManager;

class ControllerAdminComment
{
    private $commentManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->commentManager = new CommentManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin;
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
    public function delete($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->commentManager->delete($id);

        header('Location: ' . $_SERVER['HTTP_REFERER'] . '#list');
        exit;
    }

    //Status validé
    public function validate($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->commentManager->validate($id);

        header('Location: ' . $_SERVER['HTTP_REFERER']. '#list');
        exit;
    }

    //Status en attente
    public function unvalidate($id)
    {
        $this->areaAdmin->verifyAdmin();

        $this->commentManager->unvalidate($id);

        header('Location: ' . $_SERVER['HTTP_REFERER']. '#list');
        exit;
    }

    //Afficher un commentaire
    public function comment($id)
    {
        $this->areaAdmin->verifyAdmin();

        $comment = $this->commentManager->get($id);

        $this->renderview->generateView(array('name' => "Comment", 'function' => $comment, 'nameFunction' => 'comment'), 'layoutPageAdmin');
    }
}
