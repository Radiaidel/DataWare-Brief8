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

        include_once("app/views/team/index.php"); // Include the view file and pass the projects variable

    }
}
?>