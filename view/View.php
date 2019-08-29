<?php

namespace Projet5\View;

use \Exception;

class View
{

    private $file;
    private $title;
    private $logo;
    private $header;
    private $subheader;
    private $nav;
    private $error;

    public function __construct($u, $error = null)
    {
        // Selectionne le fichier vu + initialisation des erreurs pour le formulaires
        $this->file = "view/view" . $u . ".php";
        $this->error = $error;
    }

    // Rempli le layout et affiche le contenu de la page
    public function generate($datas, $layout)
    {
        $content = $this->generateFile($this->file, $datas);
        $view = $this->generateFile(
            "view/$layout.php",
            array(
                'title' => $this->title,
                'logo' => $this->logo,
                'header' => $this->header,
                'subheader' => $this->subheader,
                'nav' => $this->nav,
                'content' => $content,
            )
        );
        echo $view;
    }

    // Génère un fichier vue et renvoie le résultat produit
    private function generateFile($file, $datas)
    {
        if (file_exists($file)) {
            extract($datas);
            ob_start();
            require $file;
            return ob_get_clean();
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }

    // Sécurise les données entrées par l'utilisateur
    private function clean($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);
    }

    //Remplace le booléan par une information
    private function replaceBoolByName($data, $function)
    {
        $arrayForSwitch = array($data, $function);
        switch ($arrayForSwitch) {
            case array(0, "user"):
                return str_replace("0", "banni", $data);
                break;
            case array(0, "admin"):
                return str_replace("0", "utilisateur", $data);
                break;
            case array(0, "post"):
                return str_replace("0", "brouillon", $data);
                break;
            case array(0, "comment"):
                return str_replace("0", "en attente de validation", $data);
                break;
            case array(1, "user"):
                return str_replace("1", "valide", $data);
                break;
            case array(1, "admin"):
                return str_replace("1", "administrateur", $data);
                break;
            case array(1, "post"):
                return str_replace("1", "publié", $data);
                break;
            case array(1, "comment"):
                return str_replace("1", "validé", $data);
                break;
        }
    }

}
