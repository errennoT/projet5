<?php

namespace Projet5\Controller;

use Projet5\Model\MessageManager;
use Projet5\Model\AreaAdmin;

use Projet5\Service\ViewManager;

class ControllerAdminMessage
{
    private $messageManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->messageManager = new MessageManager();
        $this->renderview = new ViewManager();
        $this->areaAdmin = new AreaAdmin;
        
    }

    // Afficher tous les messages
    public function listMessage()
    {
        $this->areaAdmin->verifyAdmin();

        $messages = $this->messageManager->getList();
        $this->renderview->generateView(array('name' => "AdminListMessage", 'function' => $messages, 'nameFunction' => 'messages'), 'layoutPageAdmin');
    }

    //Afficher un message
    public function message($id)
    {
        $this->areaAdmin->verifyAdmin();

        $message = $this->messageManager->get($id);

        $this->renderview->generateView(array('name' => "Message", 'function' => $message, 'nameFunction' => 'message'), 'layoutPageAdmin');
    }
    
    //Répondre à un message
    public function answerMessage($id)
    {
        $this->areaAdmin->verifyAdmin();

        $message = $this->messageManager->get($id);

        if (!empty($_POST)) {
            $error = $this->messageManager->errorMessage(htmlentities($_POST['content']), "", "", "", "", "answer");

            if (empty($error)) {
                $data = $this->messageManager->validateData(htmlentities($_POST['content']), "", "", htmlentities($_POST['email']));
                mail($data['email'], $data['subject'], $data['content']);
                $this->messageManager->delete($message);

                header('location: index.php?m=listmessage#list');
            } else {
                header('location: index.php?m=errormessage');
            }
        }
    }
}
