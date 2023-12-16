<?php
require_once "app/models/Project.php";

class ProjectController
{
    private $projectModel;

    public function __construct(Project $projectModel)
    {
        $this->projectModel = $projectModel;
    }

    public function handleProjectsForUser($userId)
    {
        $projects = $this->projectModel->getProjectsForUser($userId);
        include("app/views/project/index.php"); // Include the view file
    }
}
?>
