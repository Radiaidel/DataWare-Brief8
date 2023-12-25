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

    public function getTeamsData($userId)
    {
        $teamsData = array();
        $teamsQuery = "";
        if ($_SESSION['role'] == 'po') {
            // If the user is a Product Owner, show all teams with their members
            $teamsQuery = "
                SELECT team.*, users.username AS scrum_master_name 
                FROM team 
                JOIN users ON team.id_user = users.id_user
            ";

        } elseif ($_SESSION['role'] == 'sm') {
            // If the user is a Scrum Master, show teams where they are the Scrum Master
            $teamsQuery = "
                SELECT team.*, users.username AS scrum_master_name 
                FROM team 
                JOIN users ON team.id_user = users.id_user 
                WHERE team.id_user = :userId
            ";
            $stmt = $this->conn->prepare($teamsQuery);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        } else {
            // If the user is a regular member, show teams where they are a member
            $teamsQuery = "
                SELECT team.*, users.username AS scrum_master_name 
                FROM team 
                JOIN users ON team.id_user = users.id_user 
                JOIN in_team it ON team.Id_Team = it.Id_Team
                WHERE it.id_user = :userId
            ";
            $stmt = $this->conn->prepare($teamsQuery);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        }



        if ($stmt->execute()) {
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($teams as $row) {
                $teamId = $row['Id_Team'];

                // Fetch team members for the current team
                $membersQuery = "SELECT users.id_user AS user_id, users.username, users.image_url FROM users
                                    INNER JOIN in_team ON users.id_user = in_team.id_user
                                    WHERE in_team.Id_Team = :teamId";

                $membersStmt = $this->conn->prepare($membersQuery);
                $membersStmt->bindParam(':teamId', $teamId, PDO::PARAM_INT);

                if ($membersStmt->execute()) {
                    $teamMembers = array();
                    $members = $membersStmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($members as $member) {
                        $profileImage = $member['image_url'] ? $member['image_url'] : 'default_image.jpg';
                        $teamMembers[] = array(
                            'user_id' => $member['user_id'],
                            'username' => $member['username'],
                            'profile_image' => $profileImage
                        );
                    }
                }

                // Fetch projects for the current team
                $projectsQuery = "SELECT * FROM project join team on team.id_project= project.id_project where id_team = :teamId";

                $projectsStmt = $this->conn->prepare($projectsQuery);
                $projectsStmt->bindParam(':teamId', $teamId, PDO::PARAM_INT);

                if ($projectsStmt->execute()) {
                    $teamProjects = array();
                    $projects = $projectsStmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($projects as $project) {
                        $teamProjects[] = array(
                            'project_name' => $project['project_name'],
                            'project_description' => $project['project_description']
                        );
                    }
                }

                // Assemble team data
                $teamsData[] = array(
                    'Id_Team' => $row['Id_Team'],
                    'team_name' => $row['team_name'],
                    'scrum_master_name' => $row['scrum_master_name'],
                    'team_members' => $teamMembers,
                    'team_projects' => $teamProjects,
                    'created_at' => date('d M Y', strtotime($row['created_at']))
                );
            }
        }

        return $teamsData;
    }

    public function getProjects($userId)
    {
        $query = "SELECT Id_Project, project_name FROM project where id_user = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);

        $projects = array();

        if ($stmt->execute()) {
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $projects;
    }

    public function getTeamMembers()
    {
        $query = "SELECT id_user, email FROM users WHERE role='user'";
        $stmt = $this->conn->prepare($query);

        $members = array();

        if ($stmt->execute()) {
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $members;
    }


    public function createTeam($teamName, $userId, $projectId, $teamMembers)
    {
        // Insérer l'équipe dans la table team
        $insertTeamQuery = "INSERT INTO team (team_name, created_at, id_user, id_project) VALUES (?, NOW(), ?, ?)";
        $stmt = $this->conn->prepare($insertTeamQuery);
        $stmt->bindParam(1, $teamName, PDO::PARAM_STR);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->bindParam(3, $projectId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            // Gérer l'erreur si nécessaire
            return false;
        }

        $teamId = $this->conn->lastInsertId();

        // Insérer les membres dans la table in_team
        $insertMembersQuery = "INSERT INTO in_team (id_user, id_team) VALUES (?, ?)";
        $stmtMembers = $this->conn->prepare($insertMembersQuery);

        foreach ($teamMembers as $memberId) {
            $stmtMembers->bindParam(1, $memberId, PDO::PARAM_INT);
            $stmtMembers->bindParam(2, $teamId, PDO::PARAM_INT);

            if (!$stmtMembers->execute()) {
                // Gérer l'erreur si nécessaire
                return false;
            }
        }

        // L'équipe a été créée avec succès
        return true;
    }


    // Dans votre modèle Team
    public function getTeamInfo($teamId)
    {
        $query = "SELECT team.*, project.project_name, GROUP_CONCAT(users.email) AS team_members
                  FROM team
                  JOIN project ON team.Id_Project = project.Id_Project
                  LEFT JOIN in_team ON team.Id_Team = in_team.Id_Team
                  LEFT JOIN users ON in_team.id_user = users.id_user
                  WHERE team.Id_Team = :teamId
                  GROUP BY team.Id_Team";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':teamId', $teamId);

        $teamInfo = array();

        if ($stmt->execute()) {
            $teamInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $teamInfo;
    }
    // Dans votre modèle TeamModel
    public function getMembersOfTeam($teamId)
    {
        // Utilisez votre logique pour récupérer les membres de l'équipe en fonction de $teamId
        // C'est un exemple générique de requête SQL, veuillez l'adapter en fonction de votre schéma
        $query = "SELECT users.id_user, users.email FROM users
        INNER JOIN in_team ON users.id_user = in_team.id_user
        WHERE in_team.Id_Team = :teamId";
        // Assurez-vous d'utiliser des requêtes préparées pour éviter les attaques par injection SQL
        $statement = $this->conn->prepare($query);
        $statement->bindParam(':teamId', $teamId);
        $statement->execute();

        // Récupérer les résultats de la requête
        $members = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $members;
    }


    public function updateTeam($teamId, $newTeamName, $newProjectId, $selectedMembers)
    {
        try {
            // Commencez une transaction

            // Mettez à jour le nom de l'équipe et le projet dans la table Team
            $updateTeamQuery = "UPDATE team SET team_name = :newTeamName, Id_Project = :newProjectId WHERE Id_Team = :teamId";
            $stmtUpdateTeam = $this->conn->prepare($updateTeamQuery);
            $stmtUpdateTeam->bindParam(':newTeamName', $newTeamName);
            $stmtUpdateTeam->bindParam(':newProjectId', $newProjectId);
            $stmtUpdateTeam->bindParam(':teamId', $teamId);
            $stmtUpdateTeam->execute();

            // Supprimez d'abord tous les membres de l'équipe de la table in_team
            $deleteMembersQuery = "DELETE FROM in_team WHERE Id_Team = :teamId";
            $stmtDeleteMembers = $this->conn->prepare($deleteMembersQuery);
            $stmtDeleteMembers->bindParam(':teamId', $teamId);
            $stmtDeleteMembers->execute();

            // Ensuite, insérez les membres sélectionnés dans la table in_team
            $insertMembersQuery = "INSERT INTO in_team (id_user, Id_Team) VALUES (:idMember, :teamId)";
            $stmtInsertMembers = $this->conn->prepare($insertMembersQuery);

            foreach ($selectedMembers as $idMember) {
                $stmtInsertMembers->bindParam(':idMember', $idMember);
                $stmtInsertMembers->bindParam(':teamId', $teamId);
                $stmtInsertMembers->execute();
            }

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function DeleteTeam(){
        try {
            $sql = "DELETE FROM team WHERE Id_Team= :id_team";
            $stmt = $this->conn->prepare($sql);
            
            // die($this->idProject);
            $stmt->bindParam(':id_team', $this->idTeam, PDO::PARAM_INT);
            $stmt->execute();
                        
            $stmt->closeCursor();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de l'equipe : " . $e->getMessage());
        }
    }

}
?>