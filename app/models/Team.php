<?php
require_once 'app/Database.php';

class Team
{
    private $conn;
    private $idTeam;
    private $TeamName;
    private $createdAt;
    private $idUser;
    private $idProject;



    public function setTeamId($idTeam)
    {
        $this->idTeam = $idTeam;
    }

    public function setTeamName($TeamName)
    {
        $this->TeamName = $TeamName;
    }

    public function setCreatedAt($created_at)
    {
        $this->createdAt = $created_at;
    }
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function setProjectId($projectId)
    {
        $this->idProject = $projectId;
    }



    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
        if (!$this->conn) {
            die("La connexion à la base de données a échoué.");
        }
    }

    public function getTeamMembers($teamId)
    {
        $members = array();

        $membersQuery = "SELECT users.id_user AS user_id, users.username, users.image_url 
                        FROM users
                        INNER JOIN in_team ON users.id_user = in_team.id_user
                        WHERE in_team.Id_Team =  :teamId";

        $stmt = $this->conn->prepare($membersQuery);
        $stmt->bindParam(':teamId', $teamId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $members;
    }
    public function getTeamsForUser($userId)
    {
        $teams = array();

        $teamsQuery = "SELECT team.*, users.username AS scrum_master_name 
                       FROM team 
                       JOIN users ON team.id_user = users.id_user 
                       WHERE team.id_user = :userId";

        $stmt = $this->conn->prepare($teamsQuery);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
        }

        return $teams;
    }















    // public function CreateProject(){
    //     try{

    //         $query="INSERT INTO `project`(`project_name`, `project_description`, `project_status`, `created_at`, `deadline`, `id_user`) VALUES (?, ?, ?, ?, ?, ?);";
    //         $stmt=$this->conn->prepare($query);

    //         $stmt->bindParam(1, $this->projectName);
    //         $stmt->bindParam(2, $this->projectDescription);
    //         $stmt->bindParam(3, $this->projectStatus);
    //         $stmt->bindParam(4, $this->createdAt);
    //         $stmt->bindParam(5, $this->deadline);
    //         $stmt->bindParam(6, $this->idUser);

    //         $stmt->execute();
    //         $stmt->closeCursor();

    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }
    // public function GetProject(){
    //     try{

    //         $query="SELECT * FROM project  WHERE Id_Project=? ;";
    //         $stmt=$this->conn->prepare($query);

    //         $stmt->bindParam(1, $this->idProject);

    //         $stmt->execute();
    //         $project = $stmt->fetch(PDO::FETCH_ASSOC);

    //         $stmt->closeCursor();
    //         return $project;

    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }

    // public function UpdateProject(){


    //     try {
    //         // Utilisez une requête préparée pour mettre à jour le projet
    //         $sql = "UPDATE project SET project_name = ?, project_description = ?, project_status = ?, created_at = ?, deadline = ?, id_user = ? WHERE id_project = ?";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->bindParam(1, $this->projectName);
    //         $stmt->bindParam(2, $this->projectDescription);
    //         $stmt->bindParam(3, $this->projectStatus);
    //         $stmt->bindParam(4, $this->createdAt);
    //         $stmt->bindParam(5, $this->deadline);
    //         $stmt->bindParam(6, $this->idUser);
    //         $stmt->bindParam(7, $this->idProject);

    //         $stmt->execute();
    //         $stmt->closeCursor();
    //     } catch (PDOException $e) {
    //         // Gérez les erreurs PDO ici (log, affichage, etc.)
    //         throw new Exception("Erreur lors de la mise à jour du projet : " . $e->getMessage());
    //     }
    // }

    // public function DeleteProject(){
    //     try {
    //         $sql = "DELETE FROM project WHERE Id_Project = :id_projet";
    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->bindParam(':id_projet', $this->idProject, PDO::PARAM_INT);
    //         $stmt->execute();

    //         $stmt->closeCursor();
    //     } catch (PDOException $e) {
    //         throw new Exception("Erreur lors de la suppression du projet : " . $e->getMessage());
    //     }
    // }
}
?>