<?php

namespace kivweb\Models;

use kivweb\Models\MySession;
/**
 * Trida spravujici databazi.
 * @package kivweb\Models
 */
class DatabaseModel {
    private const KEY_USER = "current_user_id";
//    /** @var MySession $mySession  Vlastni objekt pro spravu session. */
    private $mySession;

    /** @var DatabaseModel $database  Singleton databazoveho modelu. */
    private static $database;

    /** @var \PDO $pdo  Objekt pracujici s databazi prostrednictvim PDO. */
    private $pdo;

    /**
     * Inicializace pripojeni k databazi.
     */
    private function __construct() {
        // inicializace DB
        $this->pdo = new \PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        // vynuceni kodovani UTF-8
        $this->pdo->exec("set names utf8");
        $this->mySession = new MySession();
    }

    public function getLogin(string $id){
        $uzivatele = $this->selectFromTable(TABLE_UZIVATEL, "id_uzivatel=$id");
        if(empty($uzivatele)){
            echo "bbbbbbb";
            return null;
        } else {

            return $uzivatele[0];
        }
    }

    public function getLoggedUserData(){
        if($this->isUserLogged()){
            // ziskam data uzivatele ze session
            $userId = $this->mySession->readSession(self::KEY_USER);
            // pokud nemam data uzivatele, tak vypisu chybu a vynutim odhlaseni uzivatele
            if($userId == null) {
                // nemam data uzivatele ze session - vypisu jen chybu, uzivatele odhlasim a vratim null
                echo "SEVER ERROR: Data přihlášeného uživatele nebyla nalezena, a proto byl uživatel odhlášen.";
                $this->userLogout();
                // vracim null
                return null;
            }
            // nactu data uzivatele z databaze
            $userData = $this->selectFromTable(TABLE_UZIVATEL, "id_uzivatel=$userId");
            // mam data uzivatele?
            if(empty($userData)){
                // nemam - vypisu jen chybu, uzivatele odhlasim a vratim null
                echo "ERROR: Data přihlášeného uživatele se nenachází v databázi (mohl být smazán), a proto byl uživatel odhlášen.";
                $this->userLogout();
                return null;
            }
            // protoze DB vraci pole uzivatelu, tak vyjmu jeho prvni polozku a vratim ziskana data uzivatele
            return $userData[0];
        }
        // uzivatel neni prihlasen - vracim null
        return null;
    }

    public function userLogout(){
        $this->mySession->removeSession(self::KEY_USER);
    }

    /**
     * Tovarni metoda pro poskytnuti singletonu databazoveho modelu.
     * @return DatabaseModel    Databazovy model.
     */
    public static function getDatabaseModel(){
        if(empty(self::$database)){
            self::$database = new DatabaseModel();
        }
        return self::$database;
    }


    //////////////////////////////////////////////////////////
    ///////////  Prace s databazi  /////////////////////////
    //////////////////////////////////////////////////////////

    /**
     *  Vrati seznam vsech pohadek pro uvodni stranku.
     *  @return array Obsah uvodu.
     */
//    public function getAllIntroductions():array {
//        // pripravim dotaz
//        $q = "SELECT * FROM ".TABLE_INTRODUCTION;
//        // provedu a vysledek vratim jako pole
//        // protoze je o uzkazku, tak netestuju, ze bylo neco vraceno
//        return $this->pdo->query($q)->fetchAll();
//    }
    
    
    /**
     *  Vrati seznam vsech uzivatelu pro spravu uzivatelu.
     *  @return array Obsah spravy uzivatelu.
     */
    public function getAllUsers(){
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je
        $users = $this->selectFromTable(TABLE_UZIVATEL, "", "id_uzivatel");
        return $users;
    }
    
    /**
     *  Smaze daneho uzivatele z DB.
     *  @param int $userId  ID uzivatele.
     */
    public function deleteUser(int $userId):bool {
        // pripravim dotaz
        $q = "DELETE FROM ".TABLE_UZIVATEL." WHERE id_user = $userId";
        // provedu dotaz
        $res = $this->pdo->query($q);
        // pokud neni false, tak vratim vysledek, jinak null
        if ($res) {
            // neni false
            return true;
        } else {
            // je false
            return false;
        }
    }

    //////////////////////////////////////////////////////////
    ///////////  KONEC: Prace s databazi  /////////////////////////
    //////////////////////////////////////////////////////////
    public function getAllRights(){
        // ziskam vsechna prava z DB razena dle ID a vratim je
        $rights = $this->selectFromTable(TABLE_PRAVO, "", "vaha ASC, jemno ASC");
        return $rights;
    }

    public function getAllCourses(){
        $courses = $this->selectFromTable(TABLE_KURZY, "", "kurz_id ASC, cena ASC");
        return $courses;
    }

    public function getUserById(int $id){
        $users = $this->selectFromTable(TABLE_UZIVATEL, "id_uzivatel=$id");
        if(empty($users)){
            return null;
        } else {

            return $users[0];
        }
    }



    public function addNewUser(string $login, string $heslo, string $jmeno, string $email, int $idPravo, int $kurz){
        // hlavicka pro vlozeni do tabulky uzivatelu
        $insertStatement = "login, heslo, jmeno, email, id_pravo, id_kurz";
        // hodnoty pro vlozeni do tabulky uzivatelu
        $insertValues = "'$login', '$heslo', '$jmeno', '$email', $idPravo, '$kurz'";
        // provedu dotaz a vratim jeho vysledek
        return $this->insertIntoTable(TABLE_UZIVATEL, $insertStatement, $insertValues);
    }

    public function deleteCommentById(int $commentId): bool {
        $query = "DELETE FROM " . TABLE_COMMENTS . " WHERE id_comment = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $commentId]);
    }


    public function getRightById(int $id){
        // ziskam pravo dle ID
        $rights = $this->selectFromTable(TABLE_PRAVO, "id_pravo=$id");
        if(empty($rights)){
            return null;
        } else {
            // vracim prvni nalezene pravo
            return $rights[0];
        }
    }

    public function addComment($autor_id, $text, $imagePath) {
        $insertStatement = "autor_id, text, image_path";
        $insertValues = "'$autor_id', '$text', '$imagePath'";
        return $this->insertIntoTable(TABLE_COMMENTS, $insertStatement, $insertValues);
    }

    public function getAllComments(){
        // ziskam vsechna prava z DB razena dle ID a vratim je
        $comments = $this->selectFromTable(TABLE_COMMENTS, "", "id_comment ASC");
        return $comments;
    }

    public function insertIntoTable(string $tableName, string $insertStatement, string $insertValues):bool {
        // slozim dotaz
        $q = "INSERT INTO $tableName($insertStatement) VALUES ($insertValues)";
        // provedu ho a vratim uspesnost vlozeni
        $obj = $this->executeQuery($q);
        // pokud ($obj == null), tak vratim false
        return ($obj != null);
    }

    public function deleteFromTable(string $tableName, string $whereStatement):bool {
        // slozim dotaz
        $q = "DELETE FROM $tableName WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        // pokud ($obj == null), tak vratim false
        return ($obj != null);
    }

    public function getCourseById(int $id){
        $courses = $this->selectFromTable(TABLE_KURZY, "kurz_id=$id");
        if(empty($courses)){
//            echo "aaaaaaaaa";
            return null;
        } else {

            return $courses[0];
        }
    }

    public function getCourse(int $user_id){

    }



    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""):array {
        // slozim dotaz
        $q = "SELECT * FROM ".$tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        // pokud je null, tak vratim prazdne pole
        if($obj == null){
            return [];
        }

        return $obj->fetchAll();
    }

    public function userLogin(string $login, string $heslo):bool {
        // ziskam uzivatele z DB - primo overuju login i heslo
        $where = "login='$login' AND heslo='$heslo'";
        $user = $this->selectFromTable(TABLE_UZIVATEL, $where);
        // ziskal jsem uzivatele
        if(count($user)){
            // ziskal - ulozim ID prvniho nalezeneho uzivatele do session
            $this->mySession->addSession(self::KEY_USER, $user[0]['id_uzivatel']);
            return true;
        }
        // neziskal jsem uzivatele
        return false;
    }

    public function updateUser(int $idUzivatel, string $login, string $heslo, string $jmeno, string $email, int $idPravo, int $id_kurz){
        // slozim cast s hodnotami
        $updateStatementWithValues = "login='$login', heslo='$heslo', jmeno='$jmeno', email='$email', id_pravo='$idPravo', id_kurz='$id_kurz'";
        // podminka
        $whereStatement = "id_uzivatel=$idUzivatel";
        // provedu update
        return $this->updateInTable(TABLE_UZIVATEL, $updateStatementWithValues, $whereStatement);
    }

    public function isUserLogged():bool {
        return $this->mySession->isSessionSet(self::KEY_USER);
//        return isset($_SESSION['user']);
    }

    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement):bool {
        // slozim dotaz
        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        // pokud ($obj == null), tak vratim false
        return ($obj != null);
    }

    private function executeQuery(string $dotaz){
        // vykonam dotaz
        try {
            $res = $this->pdo->query($dotaz);
            return $res;
        } catch (\PDOException $ex){
            echo "Nastala výjimka: ". $ex->getCode() ."<br>"
                ."Text: ". $ex->getMessage();
            return null;
        }
    }

}

?>
