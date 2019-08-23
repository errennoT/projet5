<?php

namespace Projet5\Controller;

use \Projet5\Model\CommentManager;
use \Projet5\Model\AreaAdmin;
use Projet5\Service\GenerateView;

class ControllerAdminComment extends GenerateView
{
    private $commentManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->commentManager = new CommentManager();
    }

    //Liste des commentaires en attentes de validations
    public function listCommentValidate()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $comments = $this->commentManager->getList("admin");
        $this->generateView("AdminComment", null, 'comments', $comments);
    }

    public function listCommentUnvalidate()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $comments = $this->commentManager->getList("adminmanager");
        $this->generateView("AdminCommentManager", null, 'comments', $comments);
    }

    //Supprimer un commentaire
    public function delete($id, $status = null)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $commentId = $this->commentManager->get($id);
        $this->commentManager->delete($commentId);

        if ($status === 1) {
            header('Location: index.php?c=admincomment#list');
        } elseif ($status === 0) {
            header('Location: index.php?c=admincommentfilter#list');
        }
    }

    //Status validé
    public function validate($id, $status = null)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $commentId = $this->commentManager->get($id);
        $this->commentManager->validate($commentId);

        if ($status === 1) {
            header('Location: index.php?c=admincomment#list');
        } elseif ($status === 0) {
            header('Location: index.php?c=admincommentfilter#list');
        }
    }

    //Status en attente
    public function unvalidate($id, $status = null)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $commentId = $this->commentManager->get($id);
        $this->commentManager->unvalidate($commentId);

        if ($status === 1) {
            header('Location: index.php?c=admincomment#list');
        } elseif ($status === 0) {
            header('Location: index.php?c=admincommentfilter#list');
        }
    }
}
