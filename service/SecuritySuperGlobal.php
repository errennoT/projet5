<?php

namespace Projet5\Service;

class SecuritySuperGlobal
{

    private $superGlobal;

    public function undirectUseSP($data)
    {
        $this->superGlobal = $data;
        return $this->superGlobal;
    }
}