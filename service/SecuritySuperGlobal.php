<?php

namespace Projet5\Service;

class SecuritySuperGlobal
{

    public function undirectUsePost($data = null, $result = null)
    {
        if ($data === null) {
            return $_POST;
        } elseif (isset($result)) {
            return filter_var($_POST[$data] = $result, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        return filter_var($_POST[$data], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function undirectUseGet($data = null)
    {
        if ($data === null) {
            return $_GET;
        }

        return filter_var($_GET[$data], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function undirectUseSession($data = null, $result = null)
    {
        if ($data === null) {
            return $_SESSION;
        } elseif (isset($result)) {
            return filter_var($_SESSION[$data] = $result, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        } elseif (isset($_SESSION[$data])) {
            return filter_var($_SESSION[$data], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    }

    public function undirectUseServer($data = null)
    {
        if ($data === null) {
            return $_SERVER;
        }

        return filter_var($_SERVER[$data], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}
