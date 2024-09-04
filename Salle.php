<?php
class Salle
{
    private $conn;
    private $table_name = "salles";

    public $id;
    public $name;
    public $capacity;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllSalles()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
