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

}
