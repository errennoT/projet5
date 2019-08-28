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

use Projet5\View\View;
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
	}

	public function routerRequest()
	{ //Actions concernant les utilisateurs
		try {
			if (isset($_GET['u'])) {
				switch ($_GET['u']) {
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
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminUser->ban($id);
						break;
					case "unban":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminUser->unBan($id);
						break;
					case "delete":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminUser->delete($id);
						break;
					case "newadmin":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminUser->setAdmin($id);
						break;
					case "deleteadmin":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminUser->unSetAdmin($id);
						break;
					case "edituser":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminUser->editUser($id);
						break;
					default:
						throw new Exception("Action non valide");
						break;
				}
			}


			//Actions concernant les posts
			if (isset($_GET['p'])) {
				switch ($_GET['p']) {
					case "listpost":
						$this->ctrlPost->listPost();
						break;
					case "post":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlPost->post($id);
						break;
					case "adminpost":
						$this->ctrlAdminPost->listPost();
						break;
					case "delete":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminPost->delete($id);
						break;
					case "addpost":
						$this->ctrlAdminPost->addPost();
						break;
					case "unpublish":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminPost->draft($id);
						break;
					case "publish":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminPost->published($id);
						break;
					case 'editpost':
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminPost->editPost($id);
						break;
					default:
						throw new Exception("Action non valide");
						break;
				}
			}
			//Actions concernant les commentaires
			if (isset($_GET['c'])) {
				switch ($_GET['c']) {
					case "addcomment":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlComment->addComment($id);
						break;
					case "admincomment":
						$this->ctrlAdminComment->listCommentValidate();
						break;
					case "admincommentfilter":
						$this->ctrlAdminComment->listCommentUnvalidate();
						break;
					case "delete":
						$id = intval($this->getParam($_GET, 'id'));
						$status = intval($this->getParam($_GET, 'status'));
						$this->ctrlAdminComment->delete($id, $status);
						break;
					case "unvalidate":
						$id = intval($this->getParam($_GET, 'id'));
						$status = intval($this->getParam($_GET, 'status'));
						$this->ctrlAdminComment->unvalidate($id, $status);
						break;
					case "validate":
						$id = intval($this->getParam($_GET, 'id'));
						$status = intval($this->getParam($_GET, 'status'));
						$this->ctrlAdminComment->validate($id, $status);
						break;
					case "comment":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminComment->comment($id);
						break;
					default:
						throw new Exception("Action non valide");
						break;
				}
			}

			//Actions concernant les messages
			if (isset($_GET['m'])) {
				switch ($_GET['m']) {
					case "listmessage":
						$this->ctrlAdminMessage->listMessage();
						break;
					case "message":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminMessage->message($id);
						break;
					case "answermessage":
						$id = intval($this->getParam($_GET, 'id'));
						$this->ctrlAdminMessage->answerMessage($id);
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
			if (empty($_GET)) {
				$this->home();
			}
		} catch (Exception $e) {
			$this->error($e->getMessage());
		}
	}

	// Affiche page d'accueil
	private function home()
	{
		$this->renderview->generateView('Home');
	}

	// Affiche une erreur (à voir plus tard)
	private function error($msgError)
	{
		$this->renderview->generateView('Error', null, 'msgError', $msgError);
	}

	public function getParam($array, $name)
	{
		if (isset($array[$name])) {
			return $array[$name];
		} else {
			throw new Exception("Paramètre '$name' absent.");
		}
	}
}
