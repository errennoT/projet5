<?php

namespace Projet5\Service;

use \Projet5\View\View;


class ViewManager
{
    public function generateView($argument, $layout)
    {
        if (isset($argument["error"])) {
            $view = new View($argument["name"], $argument["error"]);
        } else {
            $view = new View($argument["name"]);
        }

        if (isset($argument["function"])) {
            $view->generate(array($argument["nameFunction"] => $argument["function"]), $layout);
        } else {
            $view->generate(array(), $layout);
        }
    }
}
