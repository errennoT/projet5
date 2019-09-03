<?php

namespace Projet5\Service;

use \Projet5\View\View;


class ViewManager
{
    public function generateView($data, $layout)
    {
        if (isset($data["error"])) {
            $view = new View($data["name"], $data["error"]);
        } else {
            $view = new View($data["name"]);
        }

        if (isset($data["function"])) {
            $view->generate(array($data["nameFunction"] => $data["function"]), $layout);
        } else {
            $view->generate(array(), $layout);
        }
    }
}
