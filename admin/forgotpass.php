<?php
session_start();
include '../connection/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identity_code = $_POST['identity_code'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($new_password) < 8) { // Check password length
        $error = "ពាក្យសម្ងាត់ត្រូវតែមានយ៉ាងហោចណាស់ 8 តួអក្សរ។";
    } else {
        // Check if user exists
        $query = $connection->prepare("SELECT * FROM manipulators WHERE identity_code = ?");
        $query->bind_param("s", $identity_code);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            // Hash the password for security
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update = $connection->prepare("UPDATE manipulators SET password = ? WHERE identity_code = ?");
            $update->bind_param("ss", $hashed_password, $identity_code);

            if ($update->execute()) {
                $success = "ពាក្យសម្ងាត់ត្រូវបានកំណត់ឡើងវិញដោយជោគជ័យ។";
            } else {
                $error = "កំហុសបានកើតឡើងខណៈពេលកំណត់ពាក្យសម្ងាត់ឡើងវិញ៖ " . $update->error;
            }
        } else {
            $error = "លេខកូដអត្តសញ្ញាណមិនត្រឹមត្រូវ។";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <main>
        <section>
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900"></a>
                <div class="bg-white p-4 rounded-lg shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-md">
                    <div class="p-4 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-blue-600 md:text-xl text-center">
                            កំណត់ពាក្យសម្ងាត់ថ្មី
                        </h1>

                        <!-- Alert Message -->
                        <?php if (isset($error)): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative alertbox"
                                role="alert">
                                <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
                                <span class="absolute -top-1 -right-1">
                                    <svg onclick="closealert()" class="fill-current h-6 w-6 text-red-500 cursor-pointer"
                                        role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <title>Close</title>
                                        <path
                                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        <?php elseif (isset($success)): ?>
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative alertbox"
                                role="alert">
                                <span class="block sm:inline"><?php echo htmlspecialchars($success); ?></span>
                                <span class="absolute -top-1 -right-1">
                                    <svg onclick="closealert()" class="fill-current h-6 w-6 text-green-500 cursor-pointer"
                                        role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
                                <label for="identity_code" class="block mb-2 text-sm font-medium text-gray-700">
                                    លេខកូដអត្តសញ្ញាណ
                                </label>
                                <input type="text" id="identity_code" name="identity_code"
                                    placeholder="ឧទាហរណ៍: 75•••••4"
                                    class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                                    required>
                            </div>
                            <div>
                                <label for="new_password" class="block mb-2 text-sm font-medium text-gray-700">
                                    ពាក្យសម្ងាត់ថ្មី
                                </label>
                                <div class="relative">
                                    <input type="password" id="new_password" name="new_password" placeholder="••••••••"
                                        class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                                        required>
                                    <button type="button" onclick="togglePassword('new_password')"
                                        class="absolute inset-y-0 right-3 flex items-center">
                                        <svg id="eye-icon-new_password" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-700">
                                    ផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់
                                </label>
                                <div class="relative">
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        placeholder="••••••••"
                                        class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                                        required>
                                    <button type="button" onclick="togglePassword('confirm_password')"
                                        class="absolute inset-y-0 right-3 flex items-center">
                                        <svg id="eye-icon-confirm_password" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                កំណត់ពាក្យសម្ងាត់
                            </button>
                            <a href="login.php" class="block text-md font-light text-gray-800 text-center underline">
                                ចូល
                            </a>
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
        function togglePassword(inputId) {
            const inputField = document.getElementById(inputId);
            const eyeIcon = document.getElementById(`eye-icon-${inputId}`);
            if (inputField.type === 'password') {
                inputField.type = 'text';
                eyeIcon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                 <circle cx="12" cy="12" r="3"></circle>`;
            } else {
                inputField.type = 'password';
                eyeIcon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                 <line x1="1" y1="1" x2="23" y2="23"></line>`;
            }
        }

    </script>


</body>

</html>