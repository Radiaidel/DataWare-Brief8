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

    public function showTeamMembers($teamId)
    {
        // Assuming $conn is your database connection
        $members = $this->TeamModel->getTeamMembers($teamId);

        // You can pass $members to your view or do further processing here
        return $members;
    }
    public function handleTeamsForUser($userId)
    {
        $userController = new User();
        $teams = $this->TeamModel->getTeamsForUser($userId);
        $members = $this->TeamModel->getTeamMembers($userId);

        include_once("app/views/team/index.php"); // Include the view file and pass the projects variable

    }
    // public function CreateProject()
    // {
    //     $message = '';
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $projectName = $_POST["projectname"];
    //         $projectDescription = $_POST["projectdescription"];
    //         $projectStatus = $_POST["status"];
    //         $created_at = $_POST["date_creation"];
    //         $deadline = $_POST["end_date"];
    //         $idUser = $_POST["scrum_master"];


    //         $this->projectModel->setProjectName($projectName);
    //         $this->projectModel->setProjectDescription($projectDescription);
    //         $this->projectModel->setProjectStatus($projectStatus);
    //         $this->projectModel->setCreatedAt($created_at);
    //         $this->projectModel->setDeadline($deadline);
    //         $this->projectModel->setIdUser($idUser);


    //         try {
    //             $userController = new User();
    //             $userController->New_scrum_master($idUser);
    //             $this->projectModel->CreateProject();
    //             $message = "Projet a été ajouter avec succès";

    //             header("Location: index.php?action=project");
    //             exit;
    //         } catch (Exception $e) {
    //             $message = "Erreur lors de la creation du projet. Veuillez réessayer.";
    //         }
    //     } else {
    //         include_once "app/views/Project/index.php";
    //     }
    // }
    // public function RequestUpdate()
    // {
    //     if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //         $this->projectModel->setProjectId($_POST["id_project"]);
    //         $projectForUpdate = $this->projectModel->GetProject();

    //         $userController = new User();
    //         $scrumMasters = $userController->getScrumMasters();

    //         include_once("app/views/project/index.php"); // Include the view file and pass the projects variable
    //     } else {
    //         include_once("index.php?action=project");
    //     }
    // }

    // public function UpdateProject()
    // {
    //     $message = '';

    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $projectId = $_POST["projectId"];
    //         $projectName = $_POST["projectname"];
    //         $projectDescription = $_POST["projectdescription"];
    //         $projectStatus = $_POST["status"];
    //         $created_at = $_POST["date_creation"];
    //         $deadline = $_POST["end_date"];
    //         $idUser = $_POST["scrum_master"];

    //         $this->projectModel->setProjectId($projectId);
    //         $this->projectModel->setProjectName($projectName);
    //         $this->projectModel->setProjectDescription($projectDescription);
    //         $this->projectModel->setProjectStatus($projectStatus);
    //         $this->projectModel->setCreatedAt($created_at);
    //         $this->projectModel->setDeadline($deadline);
    //         $this->projectModel->setIdUser($idUser);
    //         try {
    //             $this->projectModel->UpdateProject();
    //             $message = "Projet a été modifie avec succès";
    //             header("Location: index.php?action=project");
    //             exit;
    //         } catch (Exception $e) {
    //             $message = "Erreur lors de la creation du projet. Veuillez réessayer.";
    //         }
    //     }
    // }

    // public function DeleteProject(){
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $projectId = $_POST["id_project"];
    //         try {
    //             $this->projectModel->setProjectId($projectId);
    //             $this->projectModel->DeleteProject();
    //             $message = "Projet a été supprime avec succès";
    //             header("Location: index.php?action=project");
    //             exit;
    //         } catch (Exception $e) {
    //             $message = "Erreur lors de la creation du projet. Veuillez réessayer.";
    //         }
    //     }
    // }

}

?>