<?php

namespace Projet5\Service;

use Projet5\Service\ViewManager;


class SecurityCsrf
{

    public function __construct()
    {
        $this->renderview = new ViewManager();
    }

    public function testCsrf($token)
    {
        if ($token) {
            return true;
        } else {
            $this->renderview->generateView(array('name' => "Error"), 'layout');
            die;
        }
    }
}