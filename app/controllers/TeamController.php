<?php

require_once "app/models/Team.php";

class TeamController
{
    private $teamModel;

    public function __construct(Team $teamModel)
    {
        $this->teamModel = $teamModel;
    }

    public function displayTeams()
    {
        $teams = $this->teamModel->getAllTeams();
        include("app/views/team/index.php"); // Include the view file and pass the teams variable
    }

}
?>
