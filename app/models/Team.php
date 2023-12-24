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


}
?>