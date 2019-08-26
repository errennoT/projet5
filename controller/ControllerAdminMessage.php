<?php

namespace Projet5\Controller;

use Projet5\Model\MessageManager;
use Projet5\Model\AreaAdmin;

use Projet5\Service\RenderView;

class ControllerAdminMessage
{
    private $messageManager;
    private $areaAdmin;

    public function __construct()
    {
        $this->messageManager = new MessageManager();
        $this->renderview = new RenderView();
        
    }

    // Afficher tous les messages
    public function listMessage()
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $messages = $this->messageManager->getList();
        $this->renderview->generateView("AdminListMessage", null, 'messages', $messages);
    }

    //Afficher un message
    public function message($id)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $message = $this->messageManager->get($id);

        $this->renderview->generateView("Message", null, 'message', $message);
    }
    
    //Répondre à un message
    public function answerMessage($id)
    {
        $areaAdmin = $this->areaAdmin = new AreaAdmin;
        $areaAdmin->verifyAdmin();

        $message = $this->messageManager->get($id);

        if (!empty($_POST)) { //voir
            $error = $this->messageManager->errorMessage(htmlentities($_POST['content']), "", "", "", "", "answer");

            if (empty($error)) {
                $data = $this->messageManager->sendMessage(htmlentities($_POST['content']), "", "", htmlentities($_POST['email']));
                mail($data['email'], $data['subject'], $data['content']);
                $this->messageManager->delete($message);

                header('location: index.php?m=listmessage#list');
            } else { //ajout d'un try catch
                header('location: index.php?m=errormessage');
            }
        }
    }
}
