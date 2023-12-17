<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CDN du Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--CDN du JS -->
    <script src="./js/main.js" defer></script>
    <title>Sign In</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">
    <?php
    if(isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
        <h2 class="text-2xl text-center mb-6">Sign In</h2>

        <form name="signInForm" action="index.php?action=signin" method="POST">
            <!--Email input-->
            <div class="mb-4">
                <input type="email" id="email" name="email" placeholder="Email"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500 drop-shadow-lg"
                    required>
            </div>
            <!--Password input-->
            <div class="mb-6">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" placeholder="Password"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500 drop-shadow-lg"
                    required>
            </div>

            <button type="submit"
                class="w-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full px-5 py-2.5 text-center ">
                Get
                started</button>
            <p class="mt-4 text-gray-600 text-xs text-center">Don't have an account? <a href="./index.php?action=signup"
                    class="text-blue-500 hover:underline">Sign up here</a>.</p>
        </form>

    </div>

</body>

</html>