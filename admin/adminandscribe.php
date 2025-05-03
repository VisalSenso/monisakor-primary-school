<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../connection/database.php';

session_start();

if (!isset($_SESSION["identity_code"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["isadmin"] != 1) {
    header("Location: scribe.php");
    exit();
}
// វិធីសាស្រ្ត POST វាដំណើរការឥឡូវនេះ

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // បន្ថែមអ្នកសរសេរព័ត៌មាន
    if (isset($_POST['add_scribe'])) {
        $name = $_POST['name'];
        $identity_code = $_POST['identity_code'];

        // ពិនិត្យមើលថាពាក្យសម្ងាត់ត្រូវបានកំណត់ និងមិនទទេ
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash ពាក្យសម្ងាត់
        } else {
            echo "កំហុស៖ ត្រូវការពាក្យសម្ងាត់។";
            exit; // បញ្ឈប់ការប្រតិបត្តិបន្ថែមប្រសិនបើពាក្យសម្ងាត់មិនត្រូវបានផ្តល់
        }

        $image = '';

        // ដំណើរការបញ្ចូលឯកសាររូបភាពសម្រាប់រូបថតប្រវត្តិរូប
        $targetDirectory = '../assects/images/admin_and_scribe/';
        $fileUploadName = $_FILES['profile_pic']['name']; // បញ្ជាក់ឈ្មោះធាតុក្នុងទម្រង់ HTML របស់អ្នក
        $fileUploadTmp = $_FILES['profile_pic']['tmp_name'];

        if (!empty($fileUploadName)) {
            // បង្កើតឈ្មោះឯកសារឯកតាដើម្បីការពារការប្ដូរប្រហែល
            $uniqueFileName = uniqid() . "_" . basename($fileUploadName);
            $targetFilePath = $targetDirectory . $uniqueFileName;

            if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
                $image = "assects/images/admin_and_scribe/" . $uniqueFileName; // រក្សាទុកផ្លូវប្រើប្រាស់សម្រាប់មូលដ្ឋានទិន្នន័យ
            } else {
                echo "កំហុស៖ មិនអាចបញ្ចូលឯកសារបានទេ។";
                exit; // បញ្ឈប់ការប្រើប្រាស់បើការបញ្ចូលឯកសារបរាជ័យ
            }
        }

        // បញ្ចូលទិន្នន័យ manipulator ទៅក្នុងមូលដ្ឋានទិន្នន័យ
        $stmt = $connection->prepare("INSERT INTO manipulators (identity_code, name, password, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $identity_code, $name, $password, $image);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'អ្នកសរសេរព័ត៌មានបានបន្ថែមដោយជោគជ័យ!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'កំហុស៖ ' . $stmt->error;
            $_SESSION['message_type'] = 'error';
        }
    }

    // កែសម្រួលអ្នកសរសេរព័ត៌មាន
    if (isset($_POST['update_scribe'])) {
        $scribeId = $_POST['scribeId'];
        $scribeName = htmlspecialchars($_POST['scribeName']);
        $scribeIdentity = htmlspecialchars($_POST['scribeIdentity']);
        $password = $_POST['password'];

        if (empty($scribeId) || empty($scribeName) || empty($scribeIdentity) || empty($password)) {
            echo 'កំហុស៖ តម្លៃទិន្នន័យត្រូវបានបញ្ចូល។';
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $IDImage = 'file-upload-modified' . $scribeId;
        $fileUploadName = $_FILES[$IDImage]['name'] ?? null;
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'] ?? null;

        $targetDirectory = '../assects/images/admin_and_scribe/';
        $sqlfileurl = $_POST['imageLocationscribe'] ?? null;

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        if (!empty($fileUploadName)) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($fileUploadName, PATHINFO_EXTENSION));
            if (in_array($fileExtension, $allowedExtensions)) {
                $targetFile = $targetDirectory . basename($fileUploadName);
                if (file_exists($targetFile)) {
                    echo "កំហុស៖ ឯកសារនេះមានរួចហើយ។";
                    exit;
                }
                if (move_uploaded_file($fileUploadTmp, $targetFile)) {
                    $sqlfileurl = "assects/images/admin_and_scribe/" . basename($fileUploadName);
                } else {
                    echo "កំហុស៖ មិនអាចផ្ទុករូបភាពបាន។";
                    exit;
                }
            } else {
                echo "កំហុស៖ ប្រភេទឯកសារក្នុងការចូលត្រូវតែជា រូបភាព (.jpg, .jpeg, .png, .gif)។";
                exit;
            }
        }

        date_default_timezone_set('Asia/Phnom_Penh');

        $timeNow = date("Y-m-d H:i:s");

        $sql = "UPDATE manipulators SET name=?, identity_code=?, password=?, image=?, last_update=? WHERE id=?";
        $stmt = $connectionobj->prepare($sql);

        if (!$stmt) {
            error_log("SQL Prepare Error: " . $connectionobj->error);
            echo "កំហុស៖ មិនអាចចាប់ផ្ដើមការផ្លាស់ប្តូរបាន។";
            exit;
        }

        $stmt->bind_param("sssssi", $scribeName, $scribeIdentity, $hashedPassword, $sqlfileurl, $timeNow, $scribeId);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'អ្នកសរសេរព័ត៌មានបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'កំហុស៖ ' . $stmt->error;
            $_SESSION['message_type'] = 'error';
        }
    }

    // ការផ្លាស់ប្តូរព័ត៌មានអ្នកគ្រប់គ្រង
    if (isset($_POST['update_admin'])) {
        $previousPassword = $_POST['previousPassword'];
        $password = $_POST['password'];
        $newIdentity = $_POST["newIdentity"];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $IDImage = 'file-upload-modified';
        $fileUploadName = $_FILES[$IDImage]['name'];
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];

        $targetDirectory = '../assects/images/admin_and_scribe/';
        $sqlfileurl = isset($_SESSION["profile_pic"]) ? $_SESSION["profile_pic"] : null;

        if (!empty($fileUploadName)) {
            $targetPath = $targetDirectory . basename($fileUploadName);
            if (move_uploaded_file($fileUploadTmp, $targetPath)) {
                $sqlfileurl = $targetPath;
            } else {
                die("ការបញ្ចូលឯកសាររូបភាពបានបរាជ័យ។");
            }
        }

        if (!isset($_SESSION["adminPassAttempt"])) {
            $_SESSION["adminPassAttempt"] = 3;
        }

        if (password_verify($previousPassword, $_SESSION["adminPass"])) {
            $sql = "UPDATE manipulators SET identity_code=?, password=?, image=?, last_update=? WHERE id=1";
            $timeNow = date("Y-m-d H:i:s");
            $stmt = $connectionobj->prepare($sql);
            $stmt->bind_param("ssss", $newIdentity, $hashedPassword, $sqlfileurl, $timeNow);

            if ($stmt->execute()) {
                $_SESSION["adminPassAttempt"] = 3;
                $_SESSION['message'] = 'ព័ត៌មានរបស់អ្នកគ្រប់គ្រងបានអាប់ដេតដោយជោគជ័យ។';
                $_SESSION['message_type'] = 'success';
                header('Location: adminandscribe.php');
                exit;
            } else {
                die("កំហុសទិន្នន័យ៖ " . $stmt->error);
            }
        } else {
            $_SESSION["adminPassAttempt"]--;
            if ($_SESSION["adminPassAttempt"] < 1) {
                $_SESSION['message'] = 'អ្នកប្រើប្រាស់មិនទំនុកចិត្តបានរកឃើញ! ត្រូវការការចូលប្រើថ្មី។';
                $_SESSION['message_type'] = 'error';
                header('Location: logoutpashupatisession.php');
                exit;
            } else {
                $_SESSION['message'] = 'ព័ត៌មានមិនត្រឹមត្រូវ។ អ្នកនឹងត្រូវបានចាកចេញបន្ទាប់ពី ' . $_SESSION["adminPassAttempt"] . ' ការព្យាយាម។';
                $_SESSION['message_type'] = 'warning';
            }
        }
    }

    // ការផ្លាស់ប្តូរទៅធុងសំរាម
    if (isset($_POST['delete_to_trash'])) {
        $scribe_id = $_POST['scribe_id'];
        $deleteQuery = "UPDATE manipulators SET deleted_at = NOW() WHERE id = ?";
        $stmt = $connection->prepare($deleteQuery);
        $stmt->bind_param("i", $scribe_id);
        $stmt->execute();

        $_SESSION['message'] = 'អ្នកសរសេរព័ត៌មានត្រូវបានផ្លាស់ប្តូរទៅធុងសំរាមដោយជោគជ័យ!';
        $_SESSION['message_type'] = 'success';
    }

    // ការស្តារវិញពីធុងសំរាម
    if (isset($_POST['restore'])) {
        $scribe_id = $_POST['scribe_id'];
        $restoreQuery = "UPDATE manipulators SET deleted_at = NULL WHERE id = ?";
        $stmt = $connection->prepare($restoreQuery);
        $stmt->bind_param("i", $scribe_id);
        $stmt->execute();

        $_SESSION['message'] = 'អ្នកសរសេរព័ត៌មានត្រូវបានស្តារវិញដោយជោគជ័យ!';
        $_SESSION['message_type'] = 'success';
    }

    // ការលុបជាអចិន្ត្រៃយ៍
    if (isset($_POST['delete_forever'])) {
        $ScribeId = $_POST['scribeId'];

        if (mysqli_query($connection, "DELETE FROM `manipulators` WHERE id = $ScribeId;")) {
            $_SESSION['message'] = 'អ្នករៀបចំបានលុបដោយជោគជ័យ។';
            $_SESSION['message_type'] = 'error'; // Change message type to 'error' for red color
        } else {
            $_SESSION['message'] = 'កំហុស៖ មិនអាចលុបបានទេ។';
            $_SESSION['message_type'] = 'error';
        }

        header('Location: adminandscribe.php');
        exit;
    }
}

$defaultavatar = "../assects/images/defaults/defaultaltimage.jpg";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Staff | Monisakor primary school </title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>


</head>

<body class="bg-gray-50 dark:bg-[#0E0E0E]">
    <?php include('../includes/admin_header.php') ?>


    <section class="text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-bold title-font mb-4 text-gray-900 dark:text-white">
                    ធ្វើបច្ចុប្បន្នភាពអ្នកគ្រប់គ្រង និងអ្នកសរសេរព័ត៌មាន
                </h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-gray-900 dark:text-white">
                    វាដូចជាផ្ទាំងគ្រប់គ្រងសម្រាប់តម្រូវការអ្នកគ្រប់គ្រងសាលាទាំងអស់របស់អ្នក។ នៅទីនេះ
                    អ្នកមានឧបករណ៍សម្រាប់ប្ដូរអ្វីៗគ្រប់យ៉ាងពីពាក្យសម្ងាត់ និងឈ្មោះទៅជាឡូហ្គោ និងលេខកូដអត្តសញ្ញាណ។
                    វាដូចជាការធ្វើជាស្ថាបត្យករនៃអាណាចក្រឌីជីថលរបស់សាលារបស់អ្នក
                    ដោយឆ្លាក់វាឱ្យល្អឥតខ្ចោះដោយគ្រាន់តែចុចពីរបីដងប៉ុណ្ណោះ។ ដូច្នេះ សូមចូលទៅ កែសម្រួលការកំណត់ទាំងនោះ
                    ហើយអនុញ្ញាតឱ្យដែនឌីជីថលនេះក្លាយជារបស់អ្នកពិតប្រាកដ! 💻🔧
                </p>
            </div>

            <button data-modal-target="authentication-modal2" data-modal-toggle="authentication-modal2"
                class="mt-10 block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                🛡️ ផ្លាស់ប្តូរព័ត៌មានលម្អិតអ្នកគ្រប់គ្រង
            </button>


        </div>
    </section>


    <!-- Modal toggle -->



    <!-- Adding Committe Menber -->

    <div id="authentication-modal2" tabindex="-1" aria-hidden="true"
        class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#181818]">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        ប្ដូរព័ត៌មានអ្នកគ្រប់គ្រង
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal2">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">បិទម៉ូដាល់</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="" method="POST" onsubmit="return validatePassword()"
                        enctype="multipart/form-data">
                        <div><label for="new_file"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🖼️
                                ជ្រើសរើសរូបតំណាង
                                ឬរូបភាពពាក់ពន្ធបុគ្គលបណ្ដោះអាសន្ន</label></div>
                        <div class="flex items-center justify-center w-full">


                            <input name="file-upload-modified"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-white focus:outline-none dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input" type="file" accept="image/*">

                        </div>
                        <div>
                            <label for="adminName"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🧑🏻 ឈ្មោះ</label>
                            <input type="text" name="adminName" value="<?php echo $_SESSION['usr_nam']; ?>"
                                class="font-black bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Pashupati Admininstator" disabled>

                            <label for="previousPassword"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🔓
                                ពាក្យសម្ងាត់មុន</label>


                            <input type="text" name="previousPassword"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Current Password" required>

                            <label for="newIdentity"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🎫
                                អត្តសញ្ញាណថ្មី</label>


                            <input type="text" name="newIdentity" value="<?php echo $_SESSION["identity_code"]; ?>"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="716763872" required>

                            <label for="Password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🔐
                                ពាក្យសម្ងាត់</label>
                            <input title="Password must be at least 8 character" minlength="8" type="password"
                                name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="New Password" required>
                            <label for="Confrim Password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🔑
                                កញ្ចប់ពាក្យសម្ងាត់</label>
                            <input minlength="8" type="password" name="confrimPassword" id="confirm_password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Confrim Password" required>

                        </div>


                        <button type="submit" name="update_admin"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">បន្ទាន់ស្ដារអ្នកគ្រប់គ្រង</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- add scribe -->
    <div id="addscribe" tabindex="-1" aria-hidden="true"
        class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#181818]">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        បន្ថែមអ្នកសរសេរព័ត៌មាន
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="addscribe">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">បិទម៉ូដាល់</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="" method="POST" enctype="multipart/form-data">
                        <div>
                            <label for="profile_pic"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🖼️
                                រូបភាពសំរាប់ប្រវត្តិរូប</label>
                            <input type="file" name="profile_pic" id="profile_pic" accept="image/*"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-white focus:outline-none dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400">
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🧑🏻
                                ឈ្មោះ</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="John Doe" required>
                        </div>
                        <div>
                            <label for="identity_code"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🎫
                                លេខអត្តសញ្ញាណ</label>
                            <input type="text" name="identity_code" id="identity_code"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="123456789" required>
                        </div>
                        <!-- Add password field here -->
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🔑
                                ពាក្យសម្ងាត់</label>
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Enter password" required>
                        </div>
                        <button type="submit" name="add_scribe"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">បន្ថែម</button>
                    </form>
                </div>

            </div>
        </div>
    </div>




    <main>


        <section class="bg-gray-50 dark:bg-[#0E0E0E] p-3 mt-5 sm:p-5 antialiased">
            <div class="mx-auto max-w-screen-xl px-0 lg:px-12">
                <!-- Active Records Section -->
                <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">
                    <button data-modal-target="addscribe" data-modal-toggle="addscribe"
                        class="block my-2 mx-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        🛡️ បន្ថែមអ្នកសរសេរព័ត៌មាន
                    </button>
                    <div class="overflow-x-auto">
                        <?php if (isset($_SESSION['message'])): ?>
                            <?php $message = $_SESSION['message']; ?>
                            <?php $message_type = $_SESSION['message_type']; ?>
                            <div class="p-4 mb-4 text-sm text-<?= $message_type == 'success' ? 'green' : 'red' ?>-800 bg-<?= $message_type == 'success' ? 'green' : 'red' ?>-200 rounded-lg"
                                role="alert">
                                <?= $message ?>
                            </div>
                            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
                        <?php endif; ?>

                        <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                            <thead
                                class="text-lg text-gray-700 uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                                <tr>
                                    <th scope="col" class="px-4 py-3">🧑🏻 ឈ្មោះ</th>
                                    <th scope="col" class="px-4 py-3">🎫 កូដអត្តសញ្ញាណ</th>
                                    <th scope="col" class="px-4 py-4">🗓️ កាលបរិច្ឆេទចុងក្រោយបានបញ្ជូល</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">សកម្មភាព</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $fetchScribe = "SELECT * FROM manipulators WHERE id != 1 AND deleted_at IS NULL;";
                                $Scribes = mysqli_query($connection, $fetchScribe);
                                ?>
                                <?php if (mysqli_num_rows($Scribes) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($Scribes)): ?>
                                        <tr class="border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center mr-3">
                                                    <img src="../<?= htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') ?>"
                                                        alt="" class="h-8 w-auto mr-3"
                                                        onerror="this.src='<?= $defaultavatar ?>'">
                                                    <?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </th>
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                <?= htmlspecialchars($row['identity_code'], ENT_QUOTES, 'UTF-8') ?>
                                            </th>
                                            <td class="px-4 py-3">
                                                <?= htmlspecialchars($row['last_update'], ENT_QUOTES, 'UTF-8') ?>
                                            </td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <button id="dropdown-button-<?= $row['id'] ?>"
                                                    data-dropdown-toggle="dropdown-menu-<?= $row['id'] ?>"
                                                    class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div id="dropdown-menu-<?= $row['id'] ?>"
                                                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                    <ul class="py-1 text-sm"
                                                        aria-labelledby="dropdown-button-<?= $row['id'] ?>">
                                                        <li>
                                                            <button type="button"
                                                                data-modal-target="updateProductModal<?= $row['id'] ?>"
                                                                data-modal-toggle="updateProductModal<?= $row['id'] ?>"
                                                                class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-green-400"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                                </svg>
                                                                កែប្រែ
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>"
                                                                method="POST">
                                                                <input type="hidden" name="scribe_id" value="<?= $row['id'] ?>">
                                                                <button type="submit" name="delete_to_trash"
                                                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
                                                                    <svg class="w-6 h-6 text-gray-800 dark:text-red-400"
                                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                                    </svg>
                                                                    លុបទៅធុងសំរាម
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <button data-modal-target="timeline-modal" data-modal-toggle="timeline-modal"
                    class="ml-20 mt-4 block font-medium rounded-full text-sm px-5 py-2.5 text-center relative"
                    type="button">
                    <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                    </svg>

                    <!-- Badge for deleted items count -->
                    <?php
                    $countTrashQuery = "SELECT COUNT(*) AS trash_count FROM `manipulators` WHERE `deleted_at` IS NOT NULL";
                    $result = mysqli_query($connection, $countTrashQuery);
                    $trashCount = mysqli_fetch_assoc($result)['trash_count'];
                    if ($trashCount > 0) {
                        echo '<span class="absolute top-1 right-3 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">' . $trashCount . '</span>';
                    }
                    ?>
                </button>
                <div id="timeline-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="mx-auto w-[90vw] max-w-screen-2xl px-0 lg:px-12 bg-gray-50 dark:bg-[#1e1e1e]">
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">

                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="timeline-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">បិទម៉ូដាល់</span>
                            </button>
                        </div>
                        <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden mt-5">
                    <h2 class="text-xl font-bold m-4 text-white ">ធុងសំរាម</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                            <thead
                                class="text-lg text-gray-700 uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                                <tr>
                                    <th scope="col" class="px-4 py-3">🧑🏻 ឈ្មោះ</th>
                                    <th scope="col" class="px-4 py-3">🎫 កូដអត្តសញ្ញាណ</th>
                                    <th scope="col" class="px-4 py-4">🗓️ កាលបរិច្ឆេទចុងក្រោយបានបញ្ជូល</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">សកម្មភាព</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // ទាញយកអ្នកសរសេរព័ត៌មានដែលបានលុប
                                $fetchScribe = "SELECT * FROM manipulators WHERE id != 1 AND deleted_at IS NOT NULL;";
                                $DeletedScribes = mysqli_query($connection, $fetchScribe);

                                if (mysqli_num_rows($DeletedScribes) > 0):
                                    while ($row = mysqli_fetch_assoc($DeletedScribes)):
                                        $ScribesId = $row['id'];
                                ?>
                                        <tr class="border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center mr-3">
                                                    <img src="../<?= $row['image']; ?>" alt="" class="h-8 w-auto mr-3"
                                                        onerror="this.src='<?= $defaultavatar; ?>'">
                                                    <?= $row['name']; ?>
                                                </div>
                                            </th>
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                <?= $row['identity_code']; ?>
                                            </th>
                                            <td class="px-4 py-3"><?= $row['last_update']; ?></td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <button id="dropdown-button-<?= $ScribesId; ?>"
                                                    data-dropdown-toggle="dropdown-menu-<?= $ScribesId; ?>"
                                                    class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div id="dropdown-menu-<?= $ScribesId; ?>"
                                                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                    <ul class="py-1 text-sm"
                                                        aria-labelledby="dropdown-button-<?= $ScribesId; ?>">
                                                        <li>
                                                            <form
                                                                action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>"
                                                                method="POST">
                                                                <input type="hidden" name="scribe_id"
                                                                    value="<?= $ScribesId; ?>">
                                                                <button type="submit" name="restore"
                                                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600  text-gray-600 dark:text-gray-200 font-medium">
                                                                    <svg class="w-6 h-6 text-gray-800 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                                                                            </svg>
                                                                    ស្តារវិញ
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <button type="button"
                                                                data-modal-target="deleteModal<?= $row['id']; ?>"
                                                                data-modal-toggle="deleteModal<?= $row['id']; ?>"
                                                                class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-200">
                                                                <svg class="w-6 h-6 text-red-500 dark:text-red-400 mr-2"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                                </svg>
                                                                លុប
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </td>
                                        </tr>
                                <?php
                                    endwhile;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                    </div>
                </div>
                <!-- Trash Section -->
                




            </div>
        </section>

        <!-- Update modal and delete modal-->
        <?php
        $fetchScribe = "SELECT * FROM manipulators WHERE id != 1;";
        $Scribes = mysqli_query($connection, $fetchScribe);
        $totalScribes = mysqli_num_rows($Scribes);

        if ($totalScribes > 0) {
            while ($row = mysqli_fetch_assoc($Scribes)) {
                $ScribesId = $row['id'];
        ?>
            <div id="updateProductModal<?= $ScribesId ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">ធ្វើបច្ចុប្បន្នភាពអ្នកសរសេរព័ត៌មាន</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal<?= $ScribesId ?>">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">បិទម៉ូដាល់</span>
                    </button>
                    </div>
                    <form method="post" onsubmit="return validatePassword<?= $row['id'] ?>()" id="UpdateUsers<?= $ScribesId ?>" enctype="multipart/form-data">
                    <div class="grid gap-4 mb-4 sm:grid-cols-1">
                        <div>
                        <label for="new_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">📁 ឯកសារ (ប្រសិនបើមិនជ្រើសរើស នឹងប្រើឯកសារចាស់)</label>
                        </div>
                        <div class="flex items-center justify-center w-full">
                        <input name="file-upload-modified<?= $ScribesId ?>" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-white focus:outline-none dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" accept="image/*">
                        </div>
                        <div class="sm:col-span-2">
                        <label for="scribeName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🧑🏻 ឈ្មោះ</label>
                        <input type="text" name="scribeName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['name'] ?>" placeholder="បញ្ចូលឈ្មោះ">
                        <label for="identity code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🎫 លេខកូដអត្តសញ្ញាណ</label>
                        <input type="text" name="scribeIdentity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['identity_code'] ?>" placeholder="បញ្ចូលលេខកូដអត្តសញ្ញាណ">
                        <label for="Password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🔐 ពាក្យសម្ងាត់</label>
                        <input title="ពាក្យសម្ងាត់ត្រូវមានយ៉ាងតិច 8 តួអក្សរ" minlength="8" type="password" name="password" id="password<?= $row['id'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="បញ្ចូលពាក្យសម្ងាត់ថ្មី" required>
                        <label for="Confrim Password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">🔑 បញ្ជាក់ពាក្យសម្ងាត់</label>
                        <input minlength="8" type="password" name="confrimPassword" id="confirm_password<?= $row['id'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="បញ្ជាក់ពាក្យសម្ងាត់" required>
                        </div>
                        <input type="text" name="imageLocationscribe" id="name" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['image'] ?>" placeholder="9812000000">
                        <input type="hidden" name="scribeId" value="<?= $ScribesId ?>" />
                    </div>
                    <div class="flex items-center space-x-4">
                        <button name="update_scribe" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ធ្វើបច្ចុប្បន្នភាពអ្នកសរសេរព័ត៌មាន</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
            <div id="deleteModal<?= $ScribesId ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                <form method="post" id="deleteModal<?= $ScribesId ?>">
                    <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal<?= $ScribesId ?>">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">បិទម៉ូដាល់</span>
                    </button>
                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <p class="mb-4 text-gray-500 dark:text-gray-300">តើអ្នកប្រាកដថាចង់លុបធាតុនេះទេ?</p>
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal<?= $ScribesId ?>" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:text-gray-900 focus:z-10 dark:bg-[#181818] dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"> ទេ បោះបង់</button>
                        <input type="hidden" name="scribeId" value="<?= $ScribesId ?>" />
                        <button name="delete_forever" type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">បាទ ខ្ញុំប្រាកដ</button>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            <script>
                function validatePassword<?= $row['id'] ?>() {
                var password = document.getElementById("password<?= $row['id'] ?>").value;
                var confirm_password = document.getElementById("confirm_password<?= $row['id'] ?>").value;

                if (password != confirm_password) {
                    alert("ពាក្យសម្ងាត់មិនត្រូវគ្នាទេ!");
                    return false;
                }
                return true;
                }
            </script>
        <?php
            }
        }
        ?>

    </main>









    <?php include('../includes/admin_footer.php') ?>

    <script>
        document.getElementById('deleteModal<?php echo $ScribesId; ?>').addEventListener('submit', function(event) {
            const scribeId = document.querySelector('[name="scribe_id"]').value;
            console.log(scribeId); // Log the scribe_id value
        });

        function confirmDelete(event, scribeId) {
            // Create the confirmation message in Khmer
            var confirmMessage = "តើអ្នកប្រាកដជា​ចង់លុប​បុគ្គលនេះចេញពីរំលាយឬ?";

            // Show the confirmation dialog
            var userConfirmed = confirm(confirmMessage);

            // If the user confirms, submit the form
            if (userConfirmed) {
                var form = event.target.closest('form');
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_forever';
                input.value = '1';
                form.appendChild(input);

                // Submit the form
                form.submit();
            }
            // If user cancels, prevent form submission
            else {
                event.preventDefault();
            }
        }



        function displayFileName() {
            var fileInput = document.getElementById('file-upload');
            var fileInfoContainer = document.getElementById('file-info');


            if (fileInput.files.length > 0) {
                fileInfoContainer.innerHTML = '         File: ' + fileInput.files[0].name;
                fileInfoContainer.classList.remove('hidden');

            }
        }

        function displayFileNameShow() {
            var fileInput = document.getElementById('dropzone-file');
            var fileInfoContainer = document.getElementById('file-info-modified');

            if (fileInput.files.length > 0) {
                fileInfoContainer.innerHTML = 'File: ' + fileInput.files[0].name;
                fileInfoContainer.classList.remove('hidden');
            }
        }

        //Password Validation
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (password != confirm_password) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }

        console.clear();
    </script>



</body>


</html>