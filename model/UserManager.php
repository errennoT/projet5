<?php

namespace Projet5\Model;

use \Projet5\Model\Manager;
use \PDO;
use Projet5\Service\SecuritySuperGlobal;

class UserManager extends Manager
{
    private $superGlobal;

    public function __construct()
    {
        $this->superGlobal = new SecuritySuperGlobal();
    }

    public function add(User $user)
    {
        $sql = $this->dbConnect()->prepare('INSERT INTO user(login, password, email, status, admin) VALUES (:login, :password, :email, :status, :admin)');

        $sql->bindValue(':login', htmlentities($user->login()), PDO::PARAM_STR);
        $sql->bindValue(':password', htmlentities($user->password()), PDO::PARAM_STR);
        $sql->bindValue(':email', htmlentities($user->email()), PDO::PARAM_STR);
        $sql->bindValue(':status', htmlentities($user->status()), PDO::PARAM_BOOL);
        $sql->bindValue(':admin', htmlentities($user->admin()), PDO::PARAM_BOOL);

        $this->executeSql($sql);
    }

    public function delete(int $userId)
    {
        $sql = $this->dbConnect()->prepare('DELETE FROM user WHERE id = ' . $userId);

        $this->executeSql($sql);
    }

    public function ban(int $userId)
    {
        $sql = $this->dbConnect()->prepare('UPDATE user SET status = 0 WHERE id = ' . $userId);

        $this->executeSql($sql);
    }

    public function unBan(int $userId)
    {
        $sql = $this->dbConnect()->prepare('UPDATE user SET status = 1 WHERE id = ' . $userId);

        $this->executeSql($sql);
    }

    public function setAdmin(int $userId)
    {
        $sql = $this->dbConnect()->prepare('UPDATE user SET admin = 1 WHERE id = ' . $userId);

        $this->executeSql($sql);
    }

    public function unsetAdmin(int $userId)
    {
        $sql = $this->dbConnect()->prepare('UPDATE user SET admin = 0 WHERE id =' . $userId);

        $this->executeSql($sql);
    }

    public function get($userId)
    {
        $userId = (int) $userId;

        $sql = $this->dbConnect()->prepare('SELECT id, login, password, email, status, admin FROM user WHERE id = ' . $userId);
        $sql->execute(array($userId));
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        return new User($data);
    }

    public function getList()
    {
        $user = [];

        $sql = $this->dbConnect()->prepare('SELECT id, login, password, email, status, admin FROM user ORDER BY login');
        $sql->execute(array());
        while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
            $user[] = new User($data);
        }

        return $user;
    }

    public function update(User $user)
    {
        $sql = $this->dbConnect()->prepare('UPDATE user SET login = :login, password = :password, email = :email WHERE id = :id');

        $sql->bindValue(':login', $user->login(), PDO::PARAM_STR);
        $sql->bindValue(':password', $user->password(), PDO::PARAM_STR);
        $sql->bindValue(':email', $user->email(), PDO::PARAM_STR);
        $sql->bindValue(':id', $user->id(), PDO::PARAM_INT);

        $this->executeSql($sql);
    }

    //Teste si le password est assez long
    public function validateData($password, $login, $email, $userId = null, $status = null, $admin = null)
    {
        $data['password'] = $password;
        if (strlen($data['password']) < 10) {
            $data['password'] = $password;
        } else {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT, ['cost =>12']);
        }
        $data['login'] = $login;
        $data['email'] = $email;
        $data['status'] = $status;
        $data['admin'] = $admin;
        $data['id'] = $userId;

        return $data;
    }

    public function authenticate($login, $password)
    {
        $sql = $this->dbConnect()->prepare("SELECT login, password, status, admin FROM user WHERE login='$login'");
        $sql->execute();
        $data = $sql->fetch();
        $passwordDecrypt = password_verify($password, $data['password']);
        if ($login === $data['login'] && $passwordDecrypt === true && $data['status'] === "1" && $data['admin'] === "0") {
            return "user";
        } elseif ($login === $data['login'] && $passwordDecrypt === true && $data['status'] === "1" && $data['admin'] === "1") {
            return "admin";
        }
        if ($data['status'] === "0") {
            return "ban";
        } else {
            return "incorrect";
        }
    }

    //Renvoie l'erreur adéquate
    public function getError($login, $password, $email)
    {
        $error = [];
        if (strlen($login) < 3) {
            $error['login'] = 'Votre pseudo est trop court';
        }
        if (strlen($login) > 20) {
            $error['login'] = 'Votre pseudo est trop long';
        }
        if (strlen($email) < 10) {
            $error['email'] = 'Votre adresse email est trop courte';
        }
        if (strlen($email) > 100) {
            $error['email'] = 'Votre email est trop long';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error['email'] = 'Votre adresse email est incorrecte ';
        }
        if (strlen($password) < 10) {
            $error['password'] = 'Votre mot de passe est trop court';
        }
        if ($this->isUnique($login, $email) === 'doubleLogin') {
            $error['doubleLogin'] = 'Le pseudo est déjà utilisé';
        }
        if ($this->isUnique($login, $email) === 'doubleEmail') {
            $error['doubleEmail'] = 'L\'email est déjà utilisé';
        }
        if ($this->isUnique($login, $email) === 'doubleLoginEmail') {
            $error['doubleEmail'] = 'Le pseudo et l\'email sont déjà utilisés';
        }
        return $error;
    }

    //Envoie une erreur si l'utilisateur est banni ou s'il s'est trompé en s'identifiant
    public function getErrorStatus($status)
    {
        $error = [];
        switch ($status) {
            case "ban":
                $error['ban'] = 'Vous avez été banni';
                break;
            case "incorrect":
                $error['incorrect'] = 'Erreur entre le pseudo et le mot de passe';
                break;
        }

        return $error;
    }

    //Se déconnecter
    public function logout()
    {
        if ($this->superGlobal->undirectUseSession('user') || $this->superGlobal->undirectUseSession('admin')) {
            unset($_SESSION['user']);
            unset($_SESSION['admin']);
        }
    }

    //Vérifie s'il n'y a pas de doublon dans la bdd
    public function isUnique($login, $email)
    {
        $sql = $this->dbConnect()->prepare("SELECT login, email FROM user WHERE login='$login'");
        $sql2 = $this->dbConnect()->prepare("SELECT login, email FROM user WHERE email='$email'");
        $sql->execute();
        $data = $sql->fetch();
        if ($data['login'] === $login) {
            $sql2->execute();
            $data = $sql2->fetch();
            if ($data['email'] === $email) {
                return "doubleLoginEmail";
            } else {
                return "doubleLogin";
            }
        }
        $sql2->execute();
        $data = $sql2->fetch();
        if ($data['email'] === $email) {
            return "doubleEmail";
        }
        return true;
    }
}
