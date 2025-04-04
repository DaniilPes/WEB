<?php

namespace kivweb;

use kivweb\Controllers\IController;
use kivweb\Views\IView;

/**
 * Vstupni bod webove aplikace.
 */
class ApplicationStart {

    /**
     * Inicializace webove aplikace.
     */
    public function __construct()
    {

    }

    /**
     * Spusteni webove aplikace.
     */
    public function appStart(){
        //// test, zda je v URL pozadavku uvedena dostupna stranka, jinak volba defaultni stranky
        // mam spravnou hodnotu na vstupu nebo nastavim defaultni
        if(isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)){
            $pageKey = $_GET["page"]; // nastavim pozadovane
        } else {
            $pageKey = DEFAULT_WEB_PAGE_KEY; // defaulti klic
        }
        // pripravim si data ovladace
        $pageInfo = WEB_PAGES[$pageKey];



        // nactu ovladac a bez ohledu na prislusnou tridu ho typuju na dane rozhrani
        /** @var IController $controller  Ovladac prislusne stranky. */
        $controller = new $pageInfo["controller_class_name"];
        // zavolam prislusny ovladac a ziskam jeho obsah
        $tplData = $controller->show($pageInfo["title"]);

        // nactu sablonu a bez ohledu na prislusnou tridu ji typuju na dane rozhrani
        /** @var IView $view  Sablona prislusne stranky. */
        $view = new $pageInfo["view_class_name"];
//        $view = new $pageInfo["template_type"];
        // zavolam sablonu, ktera primo vypise svuj vystup
        // druhy parametr je pro TemplateBased sablony
        $view->printOutput($tplData, $pageInfo["template_type"]);



    }
}

?>
