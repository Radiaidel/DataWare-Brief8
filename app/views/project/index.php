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
            document.getElementById('addProjectButton').addEventListener('click', function () {
                document.getElementById('createForm').classList.toggle('hidden');
                document.getElementById('ListProjects').classList.toggle('hidden');
                document.getElementById('ud_project').classList.toggle('hidden');
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
            var result = confirm("Êtes-vous sûr de vouloir supprimer ce projet?");

            if (result) {
                document.getElementById("deleteProjectForm").submit();
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
                <a href="" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
                <a href="./src/action/community.php"
                    class="text-white hover:text-gray-300 transition duration-300">Projects</a>
                <a href="./src/action/static.php"
                    class="text-white hover:text-gray-300 transition duration-300">Tasks</a>
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
            <a href="" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
            <a href="./src/action/community.php"
                class="text-white hover:text-gray-300 transition duration-300">Projects</a>
            <a href="./src/action/static.php" class="text-white hover:text-gray-300 transition duration-300">Tasks</a>
            <a href="../logout.php" class="text-white hover:text-gray-300 transition duration-300">Log out</a>
        </nav>
    </div>




    <?php
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
    <div id="ud_project" class="m-6">
        <?php

        if ($_SESSION['role'] == 'po') {
            ?>
            <button type="button" class="bg-ce0033 text-white font-semibold py-2 px-4 rounded-full"
                id="addProjectButton">Add
                Project</button>

            <?php
        }
        echo "<div  class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 px-12 mt-10 mx-auto\">";
        if (!empty($projects)):
            ?>
            <?php foreach ($projects as $project): ?>

                <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between w-full">
                    <form id='ListProjects' action="question_project.php" method="post">
                        <input hidden type="text" name="id_project" value="<?php echo $project['Id_Project']; ?>">
                        <button type="submit" name="submitproject">
                            <h2 class="text-xl font-semibold text-center mb-2">
                                <?php echo $project['project_name']; ?>
                            </h2>
                            <p class="text-gray-700 text-center mb-2"><span class="font-semibold">Scrum Master:</span>
                                <?php echo $project['scrum_master']; ?>
                            </p>
                            <p class="text-gray-600 mb-4">
                                <?php echo $project['project_description']; ?>
                            </p>
                            <div class="flex justify-between">
                                <span class="bg-blue-100 border border-blue-500 text-blue-500 px-5 py-2 rounded-full">
                                    <?php echo $project['project_status']; ?>
                                </span>
                                <span class="bg-red-100 border border-red-500 text-red-500 px-3 py-2 rounded-full">
                                    <?php echo $project['days_remaining']; ?> restants
                                </span>
                            </div>

                        </button>
                    </form>
                    <?php
                    if ($_SESSION['role'] == 'po') {
                        ?>
                        <div class="flex justify-center mt-4 space-x-5">

                            <form action="index.php?action=project&showUpdateForm=1" method="POST">
                                <input hidden type="text" name="id_project" value="<?php echo $project['Id_Project']; ?>">
                                <button type="submit" id="showUpdateFormButton"
                                    class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3 17V21H7L17.59 10.41L13.17 6L3 16.17V17ZM21.41 5.59L18.83 3L20.41 1.41C20.59 1.23 20.8 1.09 21 1.03C21.2 0.97 21.41 0.99 21.59 1.07L23.59 3.07C23.77 3.15 23.91 3.36 23.97 3.57C24.03 3.78 24.01 3.99 23.93 4.17L22.34 6.76L21.41 5.59Z"
                                            fill="currentColor" />
                                    </svg>
                                </button>
                            </form>
                            <form id="deleteProjectForm" action="index.php?action=deleteproject" method="POST">
                                <input hidden type="text" name="idproject" value="<?php echo $project['Id_Project']; ?>">

                                <button type="button" id="deleteProjectButton" onclick="confirmDelete()"
                                    class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 6L5 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M5 6L19 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </form>


                        </div>

                        <?php
                    }
                    ?>
                </div>



            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    </div>




    <!-- create project  -->
    <div id="createForm" class="hidden mx-auto mt-3 bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Create Project</h2>

        <form action="index.php?action=create_project" method="POST" class="space-y-4">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Project Name:</label>
                <input type="text" id="name" name="projectname"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                <textarea id="description" name="projectdescription"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500"
                    required></textarea>
            </div>
            <div>
                <label for="date_creation" class="block text-sm font-medium text-gray-700">Created at:</label>
                <input type="date" id="date_creation" name="date_creation"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Deadline:</label>
                <input type="date" id="end_date" name="end_date"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                <select id="status" name="status"
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
                        <option value="<?= $scrumMaster["id_user"] ?>">
                            <?= $scrumMaster["email"] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit"
                class="w-full text-white bg-red-700 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900">Create
                Project</button>

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
            <p>Aucun projet trouvé.</p>
        <?php endif; ?>
    </div>


</body>

</html>