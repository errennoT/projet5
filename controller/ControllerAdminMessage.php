<?php

namespace Projet5\Controller;

use Projet5\Model\MessageManager;
use Projet5\Model\AreaAdmin;
use Projet5\Service\SecuritySuperGlobal;
use Projet5\Service\ViewManager;

use Volnix\CSRF\CSRF;

class ControllerAdminMessage
{
    private $messageManager;
    private $renderview;
    private $areaAdmin;
    private $superGlobal;

    public function __construct()
    {
        $this->messageManager = new MessageManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin();
        $this->superGlobal = new SecuritySuperGlobal();
    }

    //Afficher tous les messages
    public function listMessage()
    {
        $this->areaAdmin->verifyAdmin();

        $messages = $this->messageManager->getList();
        $this->renderview->generateView(array('name' => "AdminListMessage", 'function' => $messages, 'nameFunction' => 'messages'), 'layoutPageAdmin');
    }

    //Afficher un message
    public function message($messageId)
    {
        $this->areaAdmin->verifyAdmin();

        $message = $this->messageManager->get($messageId);

        $this->renderview->generateView(array('name' => "Message", 'function' => $message, 'nameFunction' => 'message'), 'layoutPageAdmin');
    }

    //Répondre à un message
    public function answerMessage($messageId)
    {
        $this->areaAdmin->verifyAdmin();

        $message = $this->messageManager->get($messageId);

        if (!empty($this->superGlobal->undirectUsePost()) && CSRF::validate($this->superGlobal->undirectUsePost())) {
            $error = $this->messageManager->errorMessage($this->superGlobal->undirectUsePost('content'), null, null, null, null, "answer");

            if (empty($error)) {
                $data = $this->messageManager->validateData($this->superGlobal->undirectUsePost('content'), null, null, $this->superGlobal->undirectUsePost('email'));
                mail($data['email'], $data['subject'], $data['content']);
                $this->messageManager->delete($message);

                header('location: index.php?m=listmessage#list');
            } else
                header('location: index.php?m=errormessage');
        }
    }
}
