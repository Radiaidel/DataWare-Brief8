</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Page</title>
    <script src="../Javascript/script.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-GLhlTQ8iN17SJLlFfZVfP5z01K4JPTNqDQ5a6jgl5Up3H+9TP5IotK2+Obr4u" crossorigin="anonymous" />
    <script defer>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('addTeamButton').addEventListener('click', function () {
                document.getElementById('createForm').classList.toggle('hidden');
                // document.getElementById('ListProjects').classList.toggle('hidden');
                document.getElementById('ud_team').classList.toggle('hidden');
            });

            var showUpdateFormParam = getParameterByName("showUpdateForm");

            if (showUpdateFormParam === "1" && updateForm) {
                document.getElementById('updateForm').classList.toggle('hidden');
                document.getElementById('addProjectButton').classList.toggle('hidden');


                document.getElementById('ListProjects').classList.toggle('hidden');
                document.getElementById('ud_project').classList.toggle('hidden');
            }

            function getParameterByName(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(window.location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }
        });
        function confirmDelete() {
            var result = confirm("Êtes-vous sûr de vouloir supprimer cet equipe?");

            if (result) {
                document.getElementById("deleteteamForm").submit();
            }
        }

    </script>

    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
</head>

<body class="bg-gray-200 ">


    <header class="bg-ce0033 z-50 sticky top-0 w-full p-4 flex justify-between items-center">
        <div class="text-xl font-bold w-32 mt-1">
            <img src="http://localhost/DataWare-Brief7/Membre/image/logov.PNG" class="w-full h-auto" alt="Logo">
        </div>

        <div class="flex items-center">
            <button id="burgerBtn" class="sm:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>

            <nav class="space-x-4 hidden sm:flex items-center">
                <a href="index.php?action=project"
                    class="text-white hover:text-gray-300 transition duration-300">Projects</a>
                <a href="index.php?action=team" class="text-white hover:text-gray-300 transition duration-300">Teams</a>
                <button id="logoutBtn" class="text-white px-7 py-2 rounded-full border border-white">
                    <a href="../logout.php" class="text-white">Log Out</a>
                </button>
            </nav>
        </div>
    </header>

    <!-- Navbar Responsive -->
    <div id="burgerOverlay"
        class="fixed py-5 top-18 right-0 w-1/2 h-screen bg-gray-800 bg-opacity-50 z-50 hidden items-center justify-center sm:hidden">
        <nav class="flex flex-col items-center space-y-5">
            <a href="index.php?action=project"
                class="text-white hover:text-gray-300 transition duration-300">Projects</a>
            <a href="index.php?action=team" class="text-white hover:text-gray-300 transition duration-300">Teams</a>
            <a href="../logout.php" class="text-white hover:text-gray-300 transition duration-300">Log out</a>
        </nav>
    </div>




    <?php
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
    <div id="ud_team" class="m-6">
        <?php

        if ($_SESSION['role'] == 'sm') {
            ?>
            <button type="button" class="bg-ce0033 text-white font-semibold py-2 px-4 rounded-full" id="addTeamButton">Add
                Team</button>

            <?php
        } ?>
        <div class="container mx-auto mt-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 px-4 md:px-8">
                <?php foreach ($teamsData as $team): ?>
                    <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between w-full">
                        <!-- Team -->
                        <div>
                            <h2 class="text-xl font-semibold text-center mb-2">
                                <?php echo $team['team_name']; ?>
                            </h2>
                            <p class="text-gray-700 text-center mb-2">
                                <span class="font-semibold">Scrum Master:</span>
                                <?php echo $team['scrum_master_name']; ?>
                            </p>
                        </div>

                        <!-- Display Team Members -->
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Team Members:</h3>
                            <ul class="flex space-x-4">
                                <?php foreach ($team['team_members'] as $member): ?>
                                    <li>
                                        <img src='/dataware-brief7/<?php echo $member['profile_image']; ?>'
                                            alt='<?php echo $member['username']; ?>'
                                            class='w-10 h-10 rounded-full object-cover'>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <br>

                        <!-- Display Team Projects -->
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Team Projects:</h3>
                            <ul class="mb-5">
                                <?php foreach ($team['team_projects'] as $project): ?>
                                    <li>
                                        <?php echo "{$project['project_name']} "; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                            <span
                                class="bg-green-100 border border-green-500 text-green-500 px-3 py-1 rounded-full text-xs">
                                <?php echo $team['created_at']; ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>




    <!-- create project  -->
    <div id="createForm" class="hidden mx-auto mt-3 bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">
        <h2 class="text-2xl text-center mb-6">Create Team</h2>
        <form action="index.php?action=create_team" method="POST" class="space-y-4">
            <div>
                <label for="team_name" class="block text-sm font-medium text-gray-700">Team Name:</label>
                <input type="text" id="team_name" name="team_name"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="projet" class="block text-gray-700 text-sm font-bold mb-2">Project for the Team:</label>
                <select id="projet" name="projet"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                    <?php
                foreach ($projects as $project) {
                    echo "<option value=\"{$project['Id_Project']}\">{$project['project_name']}</option>";
                }
                ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="membresEquipe" class="block text-gray-700 text-sm font-bold mb-2">Team Members:</label>
                <select id="membresEquipe" name="membresEquipe[]" multiple class="w-full px-1 py-2 border rounded">
                <?php
                foreach ($members as $member) {
                    echo "<option value=\"{$member['id_user']}\">{$member['email']}</option>";
                }
                ?>
                </select>
            </div>
            <button type="submit" name="create_team"
                class="w-full text-white bg-red-700 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900">Create
                Team</button>
        </form>
    </div>

    <div id="updateForm" class="hidden mx-auto mt-3 bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Update Project</h2>

        <form method="POST" action="index.php?action=UpdateProject" class="space-y-4">
            <?php if (!empty($projectForUpdate)):
                ?>

                <input type="hidden" id="name" name="projectId" value="<?php echo $projectForUpdate["Id_Project"]; ?>">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Project Name:</label>
                    <input type="text" id="name" name="projectname" value="<?php echo $projectForUpdate["project_name"]; ?>"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                    <textarea id="description" name="projectdescription"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500"
                        required><?php echo $projectForUpdate["project_description"]; ?></textarea>
                </div>
                <div>
                    <label for="date_creation" class="block text-sm font-medium text-gray-700">Created at:</label>
                    <?php
                    // Convertir la date au format DateTime
                    $createdAt = new DateTime($projectForUpdate["created_at"]);
                    // Formater la date pour l'afficher dans le champ de formulaire
                    $formattedDate = $createdAt->format('Y-m-d');
                    ?>
                    <input type="date" id="date_creation" name="date_creation" value="<?php echo $formattedDate; ?>"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>

                <!-- <div>
                    <label for="date_creation" class="block text-sm font-medium text-gray-700">Created at:</label>
                    <input type="date" id="date_creation" name="date_creation"
                        value="<?php echo $projectForUpdate["created_at"]; ?>"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                </div> -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Deadline:</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo $projectForUpdate["deadline"]; ?>"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                    <select id="status" name="status" value="<?php echo $projectForUpdate["project_status"]; ?>"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                        <option value='In Progress'>In Progress</option>
                        <option value='Completed'>Completed</option>
                        <option value='On Hold'>On Hold</option>
                        <option value='Cancelled'>Cancelled</option>
                        <option value='Pending'>Pending</option>
                    </select>
                </div>

                <div>
                    <label for="scrum_master" class="block text-sm font-medium text-gray-700">Scrum Master:</label>
                    <select id="scrum_master" name="scrum_master"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                        <?php foreach ($scrumMasters as $scrumMaster): ?>
                            <option value="<?= $scrumMaster["id_user"] ?>" <?php echo ($projectForUpdate["id_user"] == $scrumMaster["id_user"]) ? 'selected' : ''; ?>>
                                <?= $scrumMaster["email"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit"
                    class="w-full text-white bg-red-700 hover:bg-red-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900">Update
                    Project</button>

            </form>
        <?php else: ?>
            <p>Aucune equipe trouvé.</p>
        <?php endif; ?>
    </div>


</body>

</html>