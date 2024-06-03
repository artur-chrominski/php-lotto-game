<?php
class Draw
{
    private $conn;
    private $table_name = "draws";

    public $id;
    public $user_id;
    public $numbers;
    public $draw_date;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, numbers=:numbers, draw_date=:draw_date";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->numbers = htmlspecialchars(strip_tags($this->numbers));
        $this->draw_date = htmlspecialchars(strip_tags($this->draw_date));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":numbers", $this->numbers);
        $stmt->bindParam(":draw_date", $this->draw_date);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    function getDrawsByUserId($user_id)
    {
        $query = "SELECT d.id, u.username, d.numbers, d.draw_date FROM " . $this->table_name . " d 
                  JOIN users u ON d.user_id = u.id WHERE d.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt;
    }
}

