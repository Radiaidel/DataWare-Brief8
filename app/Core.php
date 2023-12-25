<?php
require_once "app/controllers/UserController.php";
require_once "app/controllers/ProjectController.php";
require_once "app/controllers/TeamController.php";


class Core
{
    public function handleRequest()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'default';

        switch ($action) {
            case 'signup':
                $userModel = new User();
                $userController = new UserController($userModel);
                $userController->handleSignup();
                break;
            case 'signin':
                $userModel = new User();
                $userController = new UserController($userModel);
                $userController->handleSignIn();
                break;
            case 'project':
                session_start();
                $userId = $_SESSION['user_id'];
                $projectController = new ProjectController(new Project());

                if (isset($_GET["showUpdateForm"]) && $_GET["showUpdateForm"] == 1) {
                    $projectController->RequestUpdate();

                } else {

                    $projectController->handleProjectsForUser($userId);
                }
                break;
            case 'create_project':
                $projectController = new ProjectController(new Project());
                $projectController->CreateProject();
                break;
            case 'UpdateProject':
                $projectController = new ProjectController(new Project());
                $projectController->UpdateProject();
                break;

            case 'deleteproject':
                $projectController = new ProjectController(new Project());
                $projectController->DeleteProject();
                break;
            case 'teams':
                session_start();
                $userId = $_SESSION['user_id'];
                $teamController = new TeamController(new Team());

                if (isset($_GET["showUpdateForm"]) && $_GET["showUpdateForm"] == 1) {
                    $teamId = isset($_POST["team_id"]) ? $_POST["team_id"] : null;
                    $teamController->showUpdateForm($teamId, $userId);
                } else {
                    $teamController->handleTeamsForUser($userId);
                }
                break;
            case 'create_team':
                $teamController = new TeamController(new Team());
                $teamController->CreateTeam();
                break;
            case 'UpdateTeam':
                $teamController = new TeamController(new Team());
                // Assurez-vous que vous avez l'ID de l'équipe à mettre à jour
                $teamId = isset($_POST['team_id']) ? $_POST['team_id'] : null;
                $teamController->updateTeam($teamId);
                break;
            case 'deleteteam':
                $teamController = new TeamController(new Team());
                $teamController->DeleteTeam();
                break;
                case 'logout':
                    $userController = new UserController(new User());
                    $userController->logout();
                    break;
            // Add other cases as needed
            default:
                $userModel = new User();
                $userController = new UserController($userModel);
                $userController->handleSignIn();
                break;
        }
    }
}
?>