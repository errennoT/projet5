<?php

namespace Projet5\Controller;

use Projet5\Model\MessageManager;
use Projet5\Model\Message;
use Projet5\Service\GenerateView;

class ControllerMessage extends GenerateView
{
    private $messageManager;

    public function __construct()
    {
        $this->messageManager = new MessageManager();
    }

    //Ajouter un message
    public function addMessage()
    {
        if (!empty($_POST)) {
            $error = $this->messageManager->errorMessage(htmlentities($_POST['content']), htmlentities($_POST['surname']), htmlentities($_POST['name']), htmlentities($_POST['email']), "add");

            if (empty($error)) {
                $data = $this->messageManager->sendMessage(htmlentities($_POST['content']), htmlentities($_POST['surname']), htmlentities($_POST['name']), htmlentities($_POST['email']));
                $message = new Message($data);
                $this->messageManager->add($message);

                $this->generateView("MessageSend");
            } else { //ajout d'un try catch
                header('location: index.php?m=errormessage');
            }
        }
    }
}
