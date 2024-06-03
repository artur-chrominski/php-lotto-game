<?php
class User {
    private $conn;
    private $table_name = "users";
    public $id;
    public $username;
    public $password;
    public $created;

    public function __construct($db){
        $this->conn = $db;
    }

    function signup() {
        if($this->isAlreadyExist()) {
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . "
                  SET username=:username, password=:password, created=:created";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username ?? ''));
        $this->password = md5(htmlspecialchars(strip_tags($this->password ?? ''))); 
        $this->created = htmlspecialchars(strip_tags($this->created ?? date('Y-m-d H:i:s')));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created", $this->created);

        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function login() {
        $query = "SELECT id, username FROM " . $this->table_name . " 
                  WHERE username = :username AND password = :password";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);

        $stmt->execute();

        return $stmt;
    }

    function isAlreadyExist(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>
