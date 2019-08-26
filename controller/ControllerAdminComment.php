<?php

namespace Projet5\Controller;

use \Projet5\Model\CommentManager;
use \Projet5\Model\AreaAdmin;

use Projet5\Service\RenderView;

class ControllerAdminComment
{
    private $commentManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->commentManager = new CommentManager();
        $this->renderview = new RenderView();
    }

    //Liste des commentaires en attentes de validations
    public function listCommentValidate()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $comments = $this->commentManager->getList("admin");
        $this->renderview->generateView("AdminComment", null, 'comments', $comments);
    }

    public function listCommentUnvalidate()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $comments = $this->commentManager->getList("adminmanager");
        $this->renderview->generateView("AdminCommentManager", null, 'comments', $comments);
    }

    //Supprimer un commentaire
    public function delete($id, $status = null)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $this->commentManager->delete($id);

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

        $this->commentManager->validate($id);

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

        $this->commentManager->unvalidate($id);

        if ($status === 1) {
            header('Location: index.php?c=admincomment#list');
        } elseif ($status === 0) {
            header('Location: index.php?c=admincommentfilter#list');
        }
    }
}
