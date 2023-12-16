<?php
require_once 'app/Database.php';

class Project
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

    public function getProjectsForUser($userId)
    {
        $sql = "
            SELECT DISTINCT p.*, DATEDIFF(p.deadline, CURDATE()) AS days_remaining, u.username as scrum_master
            FROM project p
            JOIN users u ON u.id_user = p.id_user
            JOIN team t ON p.Id_Project = t.Id_Project
            JOIN in_team it ON t.Id_Team = it.Id_Team
            WHERE it.id_user = :userId
        ";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Erreur de préparation de la requête.");
        }

        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            die("Erreur d'exécution de la requête.");
        }

        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $projects;
    }
}
?>
