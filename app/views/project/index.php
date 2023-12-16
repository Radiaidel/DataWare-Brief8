<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head content here -->
</head>

<body class="bg-gray-200 ">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 px-12 mt-10 mx-auto">
        <?php if (!empty($projects)) : ?>
            <?php foreach ($projects as $project) : ?>
                <form action="question_project.php" method="post">
                    <input hidden type="text" name="id_project" value="<?php echo $project['Id_Project']; ?>">
                    <button type="submit" name="submitproject" class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between w-full">
                        <h2 class="text-xl font-semibold text-center mb-2">
                            <?php echo $project['project_name']; ?>
                        </h2>
                        <p class="text-gray-700 text-center mb-2"><span class="font-semibold">Scrum Master:</span> <?php echo $project['scrum_master']; ?></p>
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
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun projet trouvé.</p>
        <?php endif;         ?>
    </div>
</body>

</html>
