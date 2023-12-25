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


    public function showUpdateForm($teamId,$userId)
    {
        // Récupérer les informations de l'équipe à mettre à jour
        $teamInfo = $this->TeamModel->getTeamInfo($teamId);
        $members = $this->TeamModel->getTeamMembers();
        $projects = $this->TeamModel->getProjects($userId);
        // die(var_dump($teamInfo));

        // Afficher le formulaire de mise à jour avec les informations de l'équipe
        include_once("app/views/team/index.php");
    }

    public function updateTeam($teamId) {
        // Vérifiez si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les informations du formulaire POST
            $newTeamName = htmlspecialchars($_POST['team_name']);
            $newProjectId = htmlspecialchars($_POST['projet']);
            $selectedMembers = isset($_POST['membresEquipe']) ? $_POST['membresEquipe'] : [];
            // Mettre à jour les informations de l'équipe dans le modèle
            $updateResult = $this->TeamModel->updateTeam($teamId, $newTeamName, $newProjectId, $selectedMembers);

            if ($updateResult) {
                echo "Team details updated successfully!";
                header("Location: index.php?action=teams"); // Rediriger vers la page d'accueil ou une autre page après la mise à jour
                exit();
            } else {
                echo "Error updating team details.";
            }
        } else {
            // Le formulaire n'a pas été soumis, vous pouvez afficher le formulaire de mise à jour ici si nécessaire
        }
    }

    public function DeleteTeam(){
        if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST["deletebtnteam"])) {
            $teamId = $_POST["team_id"];
            // die($teamId);
            try {
                $this->TeamModel->setTeamId($teamId);
                $this->TeamModel->DeleteTeam();
                $message = "Equipe a été supprime avec succès";
                header("Location: index.php?action=teams");
                exit;
            } catch (Exception $e) {
                $message = "Erreur lors de la suppression de l'equipe. Veuillez réessayer.";
            }
        }
    }
}
?>