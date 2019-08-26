<?php

namespace Projet5\Model;

use \Projet5\Model\DataBase;
use \PDO;

class UserManager extends DataBase
{

    public function add(User $user)
    {
        $q = $this->dbConnect()->prepare('INSERT INTO user(login, password, email, status, admin) VALUES (:login, :password, :email, :status, :admin)');

        $q->bindValue(':login', htmlentities($user->login()), PDO::PARAM_STR);
        $q->bindValue(':password', htmlentities($user->password()), PDO::PARAM_STR);
        $q->bindValue(':email', htmlentities($user->email()), PDO::PARAM_STR);
        $q->bindValue(':status', htmlentities($user->status()), PDO::PARAM_BOOL);
        $q->bindValue(':admin', htmlentities($user->admin()), PDO::PARAM_BOOL);

        $this->executeSql($q);
    }

    public function delete(int $id)
    {
        $q = $this->dbConnect()->prepare('DELETE FROM user WHERE id = '. $id);

        $this->executeSql($q);
    }

    public function ban(int $id)
    {
        $q = $this->dbConnect()->prepare('UPDATE user SET status = 0 WHERE id = '. $id);

        $this->executeSql($q);
    }

    public function unBan(int $id)
    {
        $q = $this->dbConnect()->prepare('UPDATE user SET status = 1 WHERE id = '. $id);

        $this->executeSql($q);
    }

    public function setAdmin(int $id)
    {
        $q = $this->dbConnect()->prepare('UPDATE user SET admin = 1 WHERE id = '. $id);

        $this->executeSql($q);
    }

    public function unsetAdmin(int $id)
    {
        $q = $this->dbConnect()->prepare('UPDATE user SET admin = 0 WHERE id =' . $id);

        $this->executeSql($q);
    }

    public function get($id)
    {
        $id = (int) $id;

        $q = $this->dbConnect()->prepare('SELECT id, login, password, email, status, admin FROM user WHERE id = ' . $id);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        return new User($data);
    }

    public function getList()
    {
        $user = [];

        $q = $this->dbConnect()->prepare('SELECT id, login, password, email, status, admin FROM user ORDER BY login');
        $q->execute(array());
        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $user[] = new User($data);
        }

        return $user;
    }

    public function update(User $user)
    {
        $q = $this->dbConnect()->prepare('UPDATE user SET login = :login, password = :password, email = :email WHERE id = :id');

        $q->bindValue(':login', $user->login(), PDO::PARAM_STR);
        $q->bindValue(':password', $user->password(), PDO::PARAM_STR);
        $q->bindValue(':email', $user->email(), PDO::PARAM_STR);
        $q->bindValue(':id', $user->id(), PDO::PARAM_INT);

        $this->executeSql($q);
    }

    //Teste si le password est assez long
    public function register($password, $login, $email, $id = null, $status = null, $admin = null)
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
        $data['id'] = $id;

        return $data;
    }

    public function authenticate($login, $password)
    {
        $q = $this->dbConnect()->prepare("SELECT login, password, status, admin FROM user WHERE login='$login'");
        $q->execute();
        $data = $q->fetch();
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
            $error['email'] = 'Votre adresse email est incorrecte';
        }
        if (strlen($email) > 100) {
            $error['email'] = 'Votre email est trop long';
        }
        if (strlen($password) < 10) {
            $error['password'] = 'Votre mot de passe est trop court';
        }
        if ($this->noDouble($login, $email) === 'doubleLogin') {
            $error['doubleLogin'] = 'Le pseudo est déjà utilisé';
        }
        if ($this->noDouble($login, $email) === 'doubleEmail') {
            $error['doubleEmail'] = 'L\'email est déjà utilisé';
        }
        if ($this->noDouble($login, $email) === 'doubleLoginEmail') {
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
        if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
            unset($_SESSION['user']);
            unset($_SESSION['admin']);
            header('Location: index.php');
        }
    }

    //Vérifie s'il n'y a pas de doublon dans la bdd
    public function noDouble($login, $email)
    {
        $q = $this->dbConnect()->prepare("SELECT login, email FROM user WHERE login='$login'");
        $q2 = $this->dbConnect()->prepare("SELECT login, email FROM user WHERE email='$email'");
        $q->execute();
        $data = $q->fetch();
        if ($data['login'] === $login) {
            $q2->execute();
            $data = $q2->fetch();
            if ($data['email'] === $email) {
                return "doubleLoginEmail";
            } else {
                return "doubleLogin";
            }
        }
        $q2->execute();
        $data = $q2->fetch();
        if ($data['email'] === $email) {
            return "doubleEmail";
        }
        return true;
    }
}
