<?php

namespace Projet5\Service;

use Projet5\Controller\ControllerAdmin;
use Projet5\Controller\ControllerRegister;
use Projet5\Controller\ControllerLogin;
use Projet5\Controller\ControllerAdminUser;

use Projet5\Controller\ControllerPost;
use Projet5\Controller\ControllerAdminPost;

use Projet5\Controller\ControllerComment;
use Projet5\Controller\ControllerAdminComment;

use Projet5\Controller\ControllerMessage;
use Projet5\Controller\ControllerAdminMessage;

use Projet5\Service\ViewManager;
use \Exception;

class Router
{
	private $ctrlRegister;
	private $ctrlLogin;
	private $ctrlAdmin;
	private $ctrlAdminUser;

	private $ctrlPost;
	private $ctrlAdminPost;

	private $ctrlComment;
	private $ctrlAdminComment;

	private $ctrlMessage;
	private $ctrlAdminMessage;

	private $renderview;
	private $superGlobal;

	public function __construct()
	{
		$this->ctrlRegister = new ControllerRegister();
		$this->ctrlLogin = new ControllerLogin();
		$this->ctrlAdminUser = new ControllerAdminUser();
		$this->ctrlAdmin = new ControllerAdmin();

		$this->ctrlPost = new ControllerPost();
		$this->ctrlAdminPost = new ControllerAdminPost();

		$this->ctrlComment = new ControllerComment();
		$this->ctrlAdminComment = new ControllerAdminComment();

		$this->ctrlMessage = new ControllerMessage();
		$this->ctrlAdminMessage = new ControllerAdminMessage();

		$this->renderview = new ViewManager();
		$this->superGlobal = new SecuritySuperGlobal();
	}

	public function routerRequest()
	{ //Actions concernant les utilisateurs
		try {
			if (filter_input(INPUT_GET, 'u')) {
				switch (filter_input(INPUT_GET, 'u')) {
					case "add":
						$this->ctrlRegister->add();
						break;
					case "login":
						$this->ctrlLogin->login();
						break;
					case "logout":
						$this->ctrlLogin->logout();
						break;
					case "admin":
						$this->ctrlAdmin->adminArea();
						break;
					case "accesdenied":
						$this->ctrlAdmin->accesDenied();
						break;
					case "adminuser":
						$this->ctrlAdminUser->listUser();
						break;
					case "ban":
						$userId = $this->getParam($_POST, 'id');
						$this->ctrlAdminUser->ban((int) $userId);
						break;
					case "unban":
						$userId = $this->getParam($_POST, 'id');
						$this->ctrlAdminUser->unBan((int) $userId);
						break;
					case "delete":
						$userId = $this->getParam($_POST, 'id');
						$this->ctrlAdminUser->delete((int) $userId);
						break;
					case "newadmin":
						$userId = $this->getParam($_POST, 'id');
						$this->ctrlAdminUser->setAdmin((int) $userId);
						break;
					case "deleteadmin":
						$userId = $this->getParam($_POST, 'id');
						$this->ctrlAdminUser->unSetAdmin((int) $userId);
						break;
					case "edituser":
						$userId = $this->getParam($_POST, 'id');
						$this->ctrlAdminUser->editUser((int) $userId);
						break;
					default:
						throw new Exception("Action non valide");
						break;
				}
			}


			//Actions concernant les posts
			if (filter_input(INPUT_GET, 'p')) {
				switch (filter_input(INPUT_GET, 'p')) {
					case "listpost":
						$this->ctrlPost->listPost();
						break;
					case "post":
						$postId = $this->getParam($this->superGlobal->undirectUseGet(), 'id');
						$this->ctrlPost->post((int) $postId);
						break;
					case "adminpost":
						$this->ctrlAdminPost->listPost();
						break;
					case "delete":
						$postId = $this->getParam($this->superGlobal->undirectUsePost(), 'id');
						$this->ctrlAdminPost->delete((int) $postId);
						break;
					case "addpost":
						$this->ctrlAdminPost->addPost();
						break;
					case "unpublish":
						$postId = $this->getParam($this->superGlobal->undirectUsePost(), 'id');
						$this->ctrlAdminPost->draft((int) $postId);
						break;
					case "publish":
						$postId = $this->getParam($this->superGlobal->undirectUsePost(), 'id');
						$this->ctrlAdminPost->published((int) $postId);
						break;
					case 'editpost':
						$postId = $this->getParam($this->superGlobal->undirectUsePost(), 'id');
						$this->ctrlAdminPost->editPost((int) $postId);
						break;
					default:
						throw new Exception("Action non valide");
						break;
				}
			}
			//Actions concernant les commentaires
			if (filter_input(INPUT_GET, 'c')) {
				switch (filter_input(INPUT_GET, 'c')) {
					case "addcomment":
						$commentId = $this->getParam($this->superGlobal->undirectUseGet(), 'id');
						$this->ctrlComment->addComment((int) $commentId);
						break;
					case "admincomment":
						$this->ctrlAdminComment->listCommentValidate();
						break;
					case "admincommentfilter":
						$this->ctrlAdminComment->listCommentUnvalidate();
						break;
					case "delete":
						$commentId = $this->getParam($this->superGlobal->undirectUsePost(), 'id');
						$this->ctrlAdminComment->delete((int) $commentId);
						break;
					case "unvalidate":
						$commentId = $this->getParam($this->superGlobal->undirectUsePost(), 'id');
						$this->ctrlAdminComment->unvalidate((int) $commentId);
						break;
					case "validate":
						$commentId = $this->getParam($this->superGlobal->undirectUsePost(), 'id');
						$this->ctrlAdminComment->validate((int) $commentId);
						break;
					case "comment":
						$commentId = $this->getParam($this->superGlobal->undirectUseGet(), 'id');
						$this->ctrlAdminComment->comment((int) $commentId);
						break;
					default:
						throw new Exception("Action non valide");
						break;
				}
			}

			//Actions concernant les messages
			if (filter_input(INPUT_GET, 'm')) {
				switch (filter_input(INPUT_GET, 'm')) {
					case "listmessage":
						$this->ctrlAdminMessage->listMessage();
						break;
					case "message":
						$messageId = $this->getParam($this->superGlobal->undirectUseGet(), 'id');
						$this->ctrlAdminMessage->message((int) $messageId);
						break;
					case "answermessage":
						$messageId = $this->getParam($this->superGlobal->undirectUseGet(), 'id');
						$this->ctrlAdminMessage->answerMessage((int) $messageId);
						break;
					case "addmessage":
						$this->ctrlMessage->addMessage();
						break;
					case "errormessage":
						$this->ctrlMessage->errorMessage();
						break;
					default:
						throw new Exception("Action non valide");
						break;
				}
			}
			//Action par défaut
			if (empty($this->superGlobal->undirectUseGet())) {
				$this->home();
			}
		} catch (Exception $e) {
			$this->error($e->getMessage());
		}
	}

	//Affiche page d'accueil
	private function home()
	{
		$this->renderview->generateView(array('name' => "Home"), 'layout');
	}

	//Affiche une erreur
	private function error($msgError)
	{
		$this->renderview->generateView(array('name' => "Error", 'function' => $msgError, 'nameFunction' => 'msgError'), 'layout');
	}

	//Permet de rassembler get['id'] ou post['id'] + mettre une erreur si c'est invalide
	public function getParam($array, $name)
	{
		if (isset($array[$name])) {
			return $array[$name];
		}
			throw new Exception("Paramètre de lien invalide");
	}
}
