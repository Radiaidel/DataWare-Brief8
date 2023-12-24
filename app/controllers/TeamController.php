<?php
require_once "app/models/Team.php";
require_once "app/models/User.php";

class TeamController
{
    private $TeamModel;

    public function __construct(Team $TeamModel)
    {
        $this->TeamModel = $TeamModel;
    }

    public function handleTeamsForUser($userId)
    {
        $userController = new User();
        $teamsData = $this->TeamModel->getTeamsData($userId);
        $projects = $this->TeamModel->getProjects($userId);
        $members = $this->TeamModel->getTeamMembers();
        include_once("app/views/team/index.php"); // Include the view file and pass the projects variable

    }
    public function CreateTeam()
    {
        session_start();
        $userId = $_SESSION['user_id'];
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_team'])) {
            // Récupérer les données du formulaire
            $teamName = htmlspecialchars($_POST['team_name']);
            $projectId = intval($_POST['projet']);
            $teamMembers = isset($_POST['membresEquipe']) ? $_POST['membresEquipe'] : [];

            // Appeler la méthode pour créer une équipe
            $teamCreated = $this->TeamModel->createTeam($teamName,$userId, $projectId, $teamMembers);
            if ($teamCreated) {
                $message = "l'equipe est ajoutée avec succès";
                header("Location: index.php?action=teams");
            }
        }
    }
}
?>