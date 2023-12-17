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
                $projectController->handleProjectsForUser($userId);
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