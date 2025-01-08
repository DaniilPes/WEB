<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel;

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 * @package kivweb\Controllers
 */
class IntroductionController implements IController {

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        $this->db = DatabaseModel::getDatabaseModel();
    }

    /**
     * Vrati obsah uvodni stranky.
     * @param string $pageTitle     Nazev stranky.
     * @return array                Vytvorena data pro sablonu.
     */
    public function show(string $pageTitle):array {
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;
//        $tplData['db'] = $this->db;

        // vratim sablonu naplnenou daty
        return $tplData;
    }
    
}

?>
