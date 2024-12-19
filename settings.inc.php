<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

//// Pripojeni k databazi ////

/** Adresa serveru. */
define("DB_SERVER","localhost");
define("DB_NAME","mydb");
define("DB_USER","root");
define("DB_PASS","root");


// definice konkretnich nazvu tabulek
define("TABLE_UZIVATEL","uzivatel");
define("TABLE_PRAVO","pravo");
define("TABLE_KURZY","kurz");
define("TABLE_COMMENTS","comments");



/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "start";

/** Dostupne webove stranky. */
const WEB_PAGES = array(//// Uvodni stranka ////
    "start" => array(
        "title" => "start",
        "controller_class_name" => \kivweb\Controllers\IntroductionController::class, // poskytne nazev tridy vcetne namespace
        "view_class_name" => \kivweb\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBased\TemplateBasics::PAGE_START,
    ),
    "courses" => array(
        "title" => "courses",
        "controller_class_name" => \kivweb\Controllers\IntroductionController::class, // poskytne nazev tridy vcetne namespace
        "view_class_name" => \kivweb\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBased\TemplateBasics::PAGE_COURSE_TEMPLATE,
    ),
    "about" => array(
        "title" => "main",

        //// kontroler
        //"file_name" => "IntroductionController.class.php",
        "controller_class_name" => \kivweb\Controllers\IntroductionController::class, // poskytne nazev tridy vcetne namespace

        // TemplateBased sablona
        "view_class_name" => \kivweb\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBased\TemplateBasics::PAGE_INTRODUCTION,
    ),
    "login" => array(
        "title" => "login",
        "controller_class_name" => \kivweb\Controllers\LoginController::class,
        "view_class_name" => \kivweb\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBased\TemplateBasics::PAGE_LOGIN
    ),


    //// Sprava uzivatelu ////
    "management" => array(
        "title" => "About",

        //// kontroler
        "controller_class_name" => \kivweb\Controllers\UserManagementController::class,

        // TemplateBased sablona
        "view_class_name" => \kivweb\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBased\TemplateBasics::PAGE_USER_MANAGEMENT,
    ),
    //// KONEC: Sprava uzivatelu ////
    ///
    "registration" => array(
        "title" => "Registration",
        "controller_class_name" => \kivweb\Controllers\RegistrationController::class,
        "view_class_name" => \kivweb\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBased\TemplateBasics::PAGE_REGISTRATION
    ),
    "comments" => array(
        "title" => "Comments",
        "controller_class_name" => \kivweb\Controllers\CommentController::class,
        "view_class_name" => \kivweb\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBased\TemplateBasics::PAGE_COMMENTS
    ),
    "user_update" => array(
        "title" => "Úprava osobních údajů",
        "controller_class_name" => \kivweb\Controllers\UserUpdateController::class,
        "view_class_name" => \kivweb\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBased\TemplateBasics::PAGE_USER_UPDATE,
    ),


);

?>
