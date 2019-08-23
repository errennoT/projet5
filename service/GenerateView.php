<?php

namespace Projet5\Service;

use \Projet5\View\View;


class GenerateView
{
    protected function generateView($name, $error = null, $nameFunction = null, $function = null)
    {
        $view = new View($name, $error);
        if ($function === null) {
            $view->generate(array());
        } else {
            $view->generate(array($nameFunction => $function));
        }
    }
}
