<?php

namespace Projet5\Controller;

use Projet5\Model\MessageManager;
use Projet5\Model\AreaAdmin;
use Projet5\Service\GenerateView;

class ControllerAdminMessage extends GenerateView
{
    private $messageManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->messageManager = new MessageManager();
    }

    // Afficher tous les messages
    public function listMessage()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $messages = $this->messageManager->getList();
        $this->generateView("AdminListMessage", null, 'messages', $messages);
    }

    //Afficher un message
    public function message($id)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $message = $this->messageManager->get($id);

        $this->generateView("Message", null, 'message', $message);
    }
}
