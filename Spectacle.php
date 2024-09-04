<?php
class Spectacle
{
    private $conn;
    public $id;
    public $title;
    public $description;
    public $date;
    public $salle_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO spectacles (title, description, date, salle_id) VALUES (:title, :description, :date, :salle_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':salle_id', $this->salle_id);

        return $stmt->execute();
    }

    public function read()
    {
        $query = "SELECT * FROM spectacles";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ajoute d'autres méthodes selon tes besoins
}
