<?php

namespace Projet5\Controller;

use Projet5\Model\MessageManager;
use Projet5\Model\Message;
use Projet5\Service\SecuritySuperGlobal;
use Projet5\Service\ViewManager;

class ControllerMessage
{
    private $messageManager;
    private $renderview;
    private $superGlobal;

    public function __construct()
    {
        $this->messageManager = new MessageManager();
        $this->renderview = new ViewManager();
        $this->superGlobal = new SecuritySuperGlobal();
    }

    //Ajouter un message
    public function addMessage()
    {
        if (!empty($this->superGlobal->undirectUsePost())) {
            $error = $this->messageManager->errorMessage($this->superGlobal->undirectUsePost('content'), $this->superGlobal->undirectUsePost('surname'), $this->superGlobal->undirectUsePost('name'), $this->superGlobal->undirectUsePost('email'), "add");

            if (empty($error)) {
                $data = $this->messageManager->validateData($this->superGlobal->undirectUsePost('content'), $this->superGlobal->undirectUsePost('surname'), $this->superGlobal->undirectUsePost('name'), $this->superGlobal->undirectUsePost('email'));
                $message = new Message($data);
                $this->messageManager->add($message);

                $this->renderview->generateView(array('name' => "MessageSend"), 'layout');
            } else {
                $this->renderview->generateView(array('name' => "Error", 'function' => "Le message est vide. Veuillez remplir correctement le formulaire", 'nameFunction' => 'msgError'), 'layout');
            }
        }
    }

    //Affiche un message d'erreur si le formulaire est incorrect
    public function errorMessage()
    {
        $this->renderview->generateView(array('name' => "Error", 'function' => "Le formulaire doit être rempli entièrement", 'nameFunction' => 'msgError'), 'layout');
    }
}
