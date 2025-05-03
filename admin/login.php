<?php
session_start();
include '../connection/database.php';

$showAlert = false; // Flag to determine if the alert should be shown
$alertMessage = ''; // Initialize alert message

if (isset($_POST['submit'])) {
    $identity_code = $_POST['identity_code'];
    $password = $_POST['password'];

    // Retrieve user data from the database
    $validate_query = mysqli_query($connection, "SELECT * FROM manipulators WHERE identity_code = '$identity_code';");
    $row = mysqli_fetch_array($validate_query);

    if (is_array($row)) {
        // Check if the password entered matches the hashed password in the database
        if (password_verify($password, $row["password"])) {
            // Password is correct, set session variables
            $_SESSION["isadmin"] = $row["id"];
            $_SESSION["identity_code"] = $row["identity_code"];
            $_SESSION["usr_nam"] = $row["name"];
            $_SESSION["profile_pic"] = $row["image"];
            $_SESSION["adminPass"] = $row["password"];
            $_SESSION["adminPassAttempt"] = 3;

            // Redirect to the index page
            header("Location:index.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            // Invalid password
            $showAlert = true; // Show alert box
            $alertMessage = 'ពាក្យសម្ងាត់មិនត្រឹមត្រូវ។ សូមព្យាយាមម្តងទៀត។'; // Set alert message
        }
    } else {
        // User not found
        $showAlert = true; // Show alert box
        $alertMessage = 'អ្នកប្រើប្រាស់មិនត្រូវបានរកឃើញ។ សូមពិនិត្យលេខកូដអត្តសញ្ញាណ។'; // Set alert message
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Monisakor Primary School</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nokora:wght@100;300;400;700;900&display=swap" rel="stylesheet">
</head>
<style>
  body{
    font-family: "Nokora", sans-serif;
  }
</style>
<body>

    <main>
        <section>
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"></a>
                <div class="bg-white p-4 rounded-lg shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-md">
                    <div class="p-4 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-blue-600 md:text-xl text-center">
                            ចូលជាមួយ Admin ឬ អ្នកសរសេព័ត៏មាន
                        </h1>
                        <!-- Alert Message -->
                        <?php if ($showAlert): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative alertbox"
                                role="alert">
                                <span class="block sm:inline"><?php echo htmlspecialchars($alertMessage); ?></span>
                                <span class="absolute -top-1 -right-1">
                                    <svg onclick="closealert()" class="fill-current h-6 w-6 text-red-500" role="button"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <title>Close</title>
                                        <path
                                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form class="space-y-4 md:space-y-4" action="" method="POST">
                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-700">លេខកូដអត្តសញ្ញាណ-Identity
                                    Code</label>
                                <input type="text" name="identity_code" id="text"
                                    class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                                    placeholder="ឧទាហរណ៍: 75•••••4" required="">
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-700">ពាក្យសម្ងាត់-Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" placeholder="••••••••"
                                        class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                                        required="">
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute inset-y-0 right-3 flex items-center">
                                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                 <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <a href="forgotpass.php"
                                class="text-sm font-light text-gray-500 dark:text-gray-500 hover:underline">
                                ភ្លេចពាក្យសម្ងាត់របស់អ្នក?
                            </a>
                            <input type="submit"
                                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                value="ចូលប្រើ" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>



    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var alertBox = document.querySelector('.alertbox');

            function closealert() {
                alertBox.style.display = 'none';
            }

            // Add event listener for the close button
            var closeButton = document.querySelector('.alertbox svg');
            if (closeButton) {
                closeButton.addEventListener('click', closealert);
            }
        });
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                 <circle cx="12" cy="12" r="3"></circle>`;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                 <line x1="1" y1="1" x2="23" y2="23"></line>`;
            }
        }
    </script>
</body>

</html>