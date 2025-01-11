<?php

namespace kivweb\Views\TemplateBased;

use kivweb\Models\DatabaseModel;
use kivweb\Views\IView;

/**
 * Trida vypisujici HTML hlavicku a paticku stranky.
 * @package kivweb\Views\TemplateBased
 */
class TemplateBasics implements IView {

    private $db;

    const EMAIL = "pesotskyi@gapps.zcu.cz";
    /** @var string PAGE_INTRODUCTION  Sablona s uvodni strankou. */
    const PAGE_INTRODUCTION = "IntroductionTemplate.tpl.php";
    /** @var string PAGE_USER_MANAGEMENT  Sablona se spravou uzivatelu. */
    const PAGE_USER_MANAGEMENT = "UserManagementTemplate.tpl.php";
    const PAGE_START = "StartTemplate.tpl.php";
    const PAGE_COURSE_TEMPLATE = "CoursesTemplate.tpl.php";
    const PAGE_REGISTRATION = "RegistrationTemplate.tpl.php";
    const PAGE_LOGIN = "LoginTemplate.tpl.php";
    const PAGE_COMMENTS = "CommentsTemplate.tpl.php";
    const PAGE_USER_UPDATE = "UserUpdateTemplate.tpl.php";



    /**
     * Zajisti vypsani HTML sablony prislusne stranky.
     * @param array $templateData       Data stranky.
     * @param string $pageType          Typ vypisovane stranky.
     */
    public function printOutput(array $templateData, string $pageType = self::PAGE_INTRODUCTION){

        //// vypis hlavicky
        if($pageType == self::PAGE_COURSE_TEMPLATE || $pageType == self::PAGE_INTRODUCTION
            || $pageType == self::PAGE_COMMENTS || $pageType == self::PAGE_START){
            $this->getHTMLHeader($templateData['title']);
        }


        //// vypis sablony obsahu
        // data pro sablonu nastavim globalni
        global $tplData;
        $tplData = $templateData;
        // nactu sablonu

        require_once($pageType);

        //// vypis pacicky
        if ($pageType == self::PAGE_START || $pageType == self::PAGE_LOGIN || $pageType == self::PAGE_COMMENTS ||
        $pageType == self::PAGE_REGISTRATION || $pageType == self::PAGE_USER_UPDATE || $pageType == self::PAGE_USER_MANAGEMENT) {
           exit();
        }

        $this->getHTMLFooter();
    }


    /**
     *  Vrati vrsek stranky az po oblast, ve ktere se vypisuje obsah stranky.
     *  @param string $pageTitle    Nazev stranky.
     */
    public function getHTMLHeader(string $pageTitle) {
    $this->db = DatabaseModel::getDatabaseModel();
    ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/MyCss/header_style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="header">
        <div class="dropdown" id="my_header">

<!--                <span class="navbar-toggler-icon btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"">-->
                <span class="navbar-toggler btn btn-primary " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"">
<!--                    <div></div>-->
<!--                    <div></div>-->
<!--                    <div></div>-->
                    <div class="burger-line line1" style="background-color: #e1d0d0"></div>
                    <div class="burger-line line2" style="background-color: #e1d0d0"></div>
                    <div class="burger-line line3" style="background-color: #e1d0d0"></div>
                </span>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="index.php?page=start">Home</a></li>
                <li><a class="dropdown-item" href="index.php?page=about">About</a></li>
                <li><a class="dropdown-item" href="index.php?page=courses">Courses</a></li>
                <li><a class="dropdown-item" href="index.php?page=comments">Comments</a></li>

            </ul>
            <nav class="nav">
                <?php
                // Check if the user is logged in and output the appropriate link
                if ($this->db->isUserLogged()) {
                    $user = $this->db->getLoggedUserData();
                    $login = $this->db->getLogin($user['id_uzivatel']);

                    if (isset($login['login'])) {
//                        echo '<a style="text-decoration:none" href="index.php?page=login" class="NI" id="test">' . htmlspecialchars($login['login']) . '</a>';
                        echo '<a style="text-decoration:none" href="index.php?page=login" class="NI" id="test">' . 'Me' . '</a>';
                    }
                } else {
                    echo '<a style="text-decoration:none" href="index.php?page=login" class="NI" id="test">Login</a>';
                }
                ?>
                <a href="index.php?page=main">
                    <img id="logoMain" src="public/images/codeChar.png" alt="Logo">
                </a>
            </nav>


        </div>
    </div>

    <!-- Подключение Bootstrap JS -->

    <style>
        /* Дополнительные стили для кнопки */
        .btn-primary .navbar-toggler-icon {
            display: inline-block;
            width: 1.5em;
            height: 1.5em;
            background: no-repeat center center;
            background-size: contain;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28155, 155, 155, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        /* Стили для бургер-меню */
        .navbar-toggler {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            width: 2rem;
            height: 2rem;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .burger-line {
            width: 2rem;
            height: 0.25rem;
            background-color: #000;
            border-radius: 5px;
            transition: all 0.3s linear;
            position: relative;
        }

        /* Анимация при открытии */
        .navbar-toggler.open .line1 {
            transform: rotate(45deg) translate(5px, 13px);
        }

        .navbar-toggler.open .line2 {
            opacity: 0;
        }

        .navbar-toggler.open .line3 {
            transform: rotate(-45deg) translate(5px, -14px);
        }

    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const burgerButton = document.getElementById('dropdownMenuButton');
            burgerButton.addEventListener('click', function () {
                this.classList.toggle('open');
            });
        });
    </script>


        <?php
    }



    /**
     *  Vrati paticku stranky.
     */
    public function getHTMLFooter(){
        $tel = "+420 123 456 789";
        ?>
        <div id="footer">
            <div class="footer-container">
                <div class="footer-section company-info">
                    <h2>Code Academy</h2>
                    <p>Designed and built with<br>
                        all the love in the world with help of<br>
                        Bootstrap and others frameworks<br>
                        Code licensed BFK 00-SKV.</p>
                </div>
                <div class="footer-section links">
                    <h2>Links</h2>
                    <ul>
                        <li><a href="index.php?page=start">Home</a></li>
                        <li><a href="index.php?page=about">About us</a></li>
                        <li><a href="index.php?page=courses">Courses</a></li>
                        <li><a href="index.php?page=comments">Comments</a></li>
                    </ul>
                </div>
                <div class="footer-section team">
                    <h2>Team</h2>
                    <ul>
                        <li><a href="index.php?page=about">Our teachers</a></li>
                        <li><a href="mailto:<?= htmlspecialchars(self::EMAIL) ?>">become part of a team</a></li>
                    </ul>
                </div>
                <div class="footer-section contacts">
                    <h2>Contacts</h2>
                    <ul>
                        <li>Address: NaN</li>
                        <li><a href="mailto:<?= htmlspecialchars(self::EMAIL) ?>">e-mail</a></li>
                        <li><a href="tel:' . htmlspecialchars($tel) . '">+420 123 456 789</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }
        
}

?>
