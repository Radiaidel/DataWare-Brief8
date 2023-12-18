<?php
require_once "app/controllers/UserController.php";
require_once "app/controllers/ProjectController.php";


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