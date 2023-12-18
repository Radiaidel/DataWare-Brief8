<?php
require_once 'app/Database.php';

class Project
{
    private $conn;
    private $idProject;
    private $projectName;
    private $projectDescription;
    private $projectStatus;
    private $createdAt;
    private $deadline;
    private $idUser;


    public function setProjectId($projectId)
    {
        $this->idProject = $projectId;
    }
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }

    public function setProjectDescription($projectDescription)
    {
        $this->projectDescription = $projectDescription;
    }

    public function setProjectStatus($projectStatus)
    {
        $this->projectStatus = $projectStatus;
    }
    public function setCreatedAt($created_at){
        $this->createdAt = $created_at;
    }
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

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
      
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            die("Erreur d'exécution de la requête.");
        }
        
        // die("Erreur d'exécution de la requête.");
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();
        return $projects;
    }
    public function CreateProject(){
        try{

            $query="INSERT INTO `project`(`project_name`, `project_description`, `project_status`, `created_at`, `deadline`, `id_user`) VALUES (?, ?, ?, ?, ?, ?);";
            $stmt=$this->conn->prepare($query);

            $stmt->bindParam(1, $this->projectName);
            $stmt->bindParam(2, $this->projectDescription);
            $stmt->bindParam(3, $this->projectStatus);
            $stmt->bindParam(4, $this->createdAt);
            $stmt->bindParam(5, $this->deadline);
            $stmt->bindParam(6, $this->idUser);

            $stmt->execute();
            $stmt->closeCursor();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function GetProject(){
        try{

            $query="SELECT * FROM project  WHERE Id_Project=? ;";
            $stmt=$this->conn->prepare($query);

            $stmt->bindParam(1, $this->idProject);

            $stmt->execute();
            $project = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt->closeCursor();
            return $project;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function UpdateProject(){

        
        try {
            // Utilisez une requête préparée pour mettre à jour le projet
            $sql = "UPDATE project SET project_name = ?, project_description = ?, project_status = ?, created_at = ?, deadline = ?, id_user = ? WHERE id_project = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $this->projectName);
            $stmt->bindParam(2, $this->projectDescription);
            $stmt->bindParam(3, $this->projectStatus);
            $stmt->bindParam(4, $this->createdAt);
            $stmt->bindParam(5, $this->deadline);
            $stmt->bindParam(6, $this->idUser);
            $stmt->bindParam(7, $this->idProject);
            
            $stmt->execute();
            $stmt->closeCursor();
        } catch (PDOException $e) {
            // Gérez les erreurs PDO ici (log, affichage, etc.)
            throw new Exception("Erreur lors de la mise à jour du projet : " . $e->getMessage());
        }
    }

    public function DeleteProject(){
        try {
            $sql = "DELETE FROM project WHERE Id_Project = :id_projet";
            $stmt = $this->conn->prepare($sql);
    
            $stmt->bindParam(':id_projet', $this->idProject, PDO::PARAM_INT);
            $stmt->execute();
                        
            $stmt->closeCursor();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du projet : " . $e->getMessage());
        }
    }
}
?>