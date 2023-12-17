<?php

require_once 'app/Database.php';

class Team
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
        if (!$this->conn) {
            die("La connexion à la base de données a échoué.");
        }
    }

    public function getAllTeams()
    {
        $query = "SELECT team.*, users.username AS scrum_master_name FROM team JOIN users ON team.id_user = users.id_user";
        $stmt = $this->conn->prepare($query);
$stmt->execute();
        $teams = [];
        while ($row =$stmt->fetchAll(PDO::FETCH_ASSOC)) {
            $teams[] = $row;
        }

        return $teams;
    }

    // Add other methods as needed
}
?>
