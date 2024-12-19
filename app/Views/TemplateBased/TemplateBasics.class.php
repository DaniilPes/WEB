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
    public function printOutput(array $templateData, string $pageType = self::PAGE_INTRODUCTION)
    {

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
        <div class="divNav">
            <div class="con" onclick="myFunction(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <nav class="nav">
                <a style="text-decoration:none" href="index.php?page=start" class="NI">Home</a>
                <a style="text-decoration:none" href="index.php?page=about" class="NI" accive-color="green">About</a>
                <a style="text-decoration:none" href="index.php?page=courses" class="NI">Courses</a>
                <a style="text-decoration:none" href="index.php?page=comments" class="NI">Comments</a>
            </nav>
            <nav class="nav">
                <?php
                // Check if the user is logged in and output the appropriate link
                if ($this->db->isUserLogged()) {
                    $user = $this->db->getLoggedUserData();
                    $login = $this->db->getLogin($user['id_uzivatel']);

                    if (isset($login['login'])) {
                        echo '<a style="text-decoration:none" href="index.php?page=login" class="NI" id="test">' . htmlspecialchars($login['login']) . '</a>';
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
