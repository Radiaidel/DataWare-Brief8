<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Add Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title> Registration Form</title>
</head>

<body class="bg-cover bg-center h-screen flex items-center justify-center"
    style="background-image: url('/dataware-Brief9/Images/geometric-background-with-copy-space.jpg');">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Sign Up</h2>
        <?php
        if (isset($message)) {
            echo "<p>$message</p>";
        }
        ?>
        <form action="index.php?action=signup" method="POST" enctype="multipart/form-data">
            <div class="mt-4">

                <input type="text" id="username" name="username" placeholder="Enter your username"
                    class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">

                <input type="email" id="email" name="email" placeholder="Enter your email"
                    class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">

                <input type="password" id="password" name="password" placeholder="Enter your password"
                    class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mt-4">

                <input type="file" id="profilePicture" name="profilePicture" accept="image/*"
                    class="mt-1 p-2 w-full border rounded-md">
            </div>


            <div class="mt-6">

                <!-- <label for="acceptTerms" class="ml-2 text-sm text-gray-600">I accept the <a href="#" class="text-purple-500 font-semibold">Terms of Use</a> & <a href="#" class="text-purple-500 font-semibold">Privacy Policy</a> -->
                <p class="mt-4 text-gray-600 text-xs text-center">Already have an account ?<a
                        href="./index.php?action=signin" class="text-blue-500 hover:underline"> Sign in here </a>.</p>
            </div>
            <div class="mt-6">
                <button type="submit"
                    class="w-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full px-5 py-2.5 text-center ">
                    Register Now</button>
            </div>
        </form>
    </div>
</body>

</html>