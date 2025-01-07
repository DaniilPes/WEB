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

    /**
     *  Vrati seznam vsech uzivatelu pro spravu uzivatelu.
     *  @return array Obsah spravy uzivatelu.
     */
    public function getAllUsers(){
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je
        $users = $this->selectFromTable(TABLE_UZIVATEL, "", "id_uzivatel");
        return $users;
    }

    public function deleteUser(int $userId): bool {
        $query = "DELETE FROM " . TABLE_UZIVATEL . " WHERE id_uzivatel = :userId";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':userId' => $userId]);
    }

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

    public function addNewUser(string $login, string $heslo, string $jmeno, string $email, int $idPravo, int $kurz): bool {
//        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            throw new \InvalidArgumentException("Invalid email format.");
//        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
            throw new \InvalidArgumentException("Invalid login format.");
        }

        $query = "INSERT INTO " . TABLE_UZIVATEL . " (login, heslo, jmeno, email, id_pravo, id_kurz)
              VALUES (:login, :heslo, :jmeno, :email, :idPravo, :kurz)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':login' => $login,
            ':heslo' => $heslo,
            ':jmeno' => $jmeno,
            ':email' => $email,
            ':idPravo' => $idPravo,
            ':kurz' => $kurz,
        ]);
    }

    public function deleteCommentById(int $commentId): bool {
        $query = "DELETE FROM comments WHERE id_comment = :id_comment";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':id_comment' => $commentId]);
    }

    public function getUserByLogin(string $login): ?array {
        // Убедимся, что логин валиден (например, содержит только допустимые символы)
        $login = trim($login); // Удаляем лишние пробелы
        if (empty($login) || !preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
            throw new \InvalidArgumentException("Invalid login format.");
        }

        $query = "SELECT * FROM " . TABLE_UZIVATEL . " WHERE login = :login";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':login', $login, \PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result ?: null; // Возвращает null, если пользователь не найден
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

    public function addComment(int $userId, string $text, ?string $imagePath): bool {
        $query = "INSERT INTO comments (autor_id, text, image_path) VALUES (:autor_id, :text, :image_path)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':autor_id' => $userId,
            ':text' => $text,
            ':image_path' => $imagePath,
        ]);
    }

    public function getAllComments() {
        $stmt = $this->pdo->query("
        SELECT 
            c.id_comment, 
            c.text, 
            c.image_path, 
            u.jmeno AS autor_name, 
            p.jemno AS `right`, 
            k.nazev AS course
        FROM comments c
        JOIN uzivatel u ON c.autor_id = u.id_uzivatel
        JOIN pravo p ON u.id_pravo = p.id_pravo
        JOIN kurz k ON u.id_kurz = k.kurz_id
        ORDER BY c.id_comment DESC
    ");
        return $stmt->fetchAll();
    }

    public function getCourseById(int $id) {
        $query = "SELECT * FROM " . TABLE_KURZY . " WHERE kurz_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""): array {
        $query = "SELECT * FROM " . $tableName;
        if (!empty($whereStatement)) {
            $query .= " WHERE " . $whereStatement;
        }
        if (!empty($orderByStatement)) {
            $query .= " ORDER BY " . $orderByStatement;
        }
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            echo "Nastala výjimka: " . $ex->getMessage();
            return [];
        }
    }

    public function userLogin(string $login, string $heslo): bool {
        $query = "SELECT id_uzivatel FROM " . TABLE_UZIVATEL . " WHERE login = :login AND heslo = :heslo";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':login' => $login, ':heslo' => $heslo]);
        $user = $stmt->fetch();
        if ($user) {
            $this->mySession->addSession(self::KEY_USER, $user['id_uzivatel']);
            return true;
        }
        return false;
    }

    public function updateUser(int $idUzivatel, string $login, string $heslo, string $jmeno, string $email, int $idPravo, int $idKurz): bool {
        $query = "UPDATE " . TABLE_UZIVATEL . " 
              SET login = :login, heslo = :heslo, jmeno = :jmeno, email = :email, id_pravo = :idPravo, id_kurz = :idKurz 
              WHERE id_uzivatel = :idUzivatel";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':login' => $login,
            ':heslo' => $heslo,
            ':jmeno' => $jmeno,
            ':email' => $email,
            ':idPravo' => $idPravo,
            ':idKurz' => $idKurz,
            ':idUzivatel' => $idUzivatel,
        ]);
    }


    public function isUserLogged():bool {
        return $this->mySession->isSessionSet(self::KEY_USER);
    }

}

?>