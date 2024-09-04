<?php
class Billet
{
    private $conn;
    public $user_id;
    public $spectacle_id;
    public $salle_id;
    public $seats;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO billets (user_id, spectacle_id, salle_id, seats) VALUES (:user_id, :spectacle_id, :salle_id, :seats)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':spectacle_id', $this->spectacle_id);
        $stmt->bindParam(':salle_id', $this->salle_id);
        $stmt->bindParam(':seats', $this->seats);

        return $stmt->execute();
    }

    public function getUserReservations($user_id)
    {
        $query = "SELECT billets.*, spectacles.date AS spectacle_date, spectacles.title AS spectacle_title
                  FROM billets
                  JOIN spectacles ON billets.spectacle_id = spectacles.id
                  WHERE billets.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt;
    }
}
