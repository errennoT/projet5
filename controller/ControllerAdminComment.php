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
    public function delete($id, $status = null)
    {
        $this->areaAdmin->verifyAdmin();

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
        $this->areaAdmin->verifyAdmin();

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
        $this->areaAdmin->verifyAdmin();

        $this->commentManager->unvalidate($id);

        if ($status === 1) {
            header('Location: index.php?c=admincomment#list');
        } elseif ($status === 0) {
            header('Location: index.php?c=admincommentfilter#list');
        }
    }

    //Afficher un commentaire
    public function comment($id)
    {
        $this->areaAdmin->verifyAdmin();

        $comment = $this->commentManager->get($id);

        $this->renderview->generateView(array('name' => "Comment", 'function' => $comment, 'nameFunction' => 'comment'), 'layoutPageAdmin');
    }
}
