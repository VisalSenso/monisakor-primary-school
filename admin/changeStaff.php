<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['add_committe'])) {
        $IDImage = 'file-upload-modified';
        $fileUploadName = $_FILES[$IDImage]['name'];
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];

        $targetDirectory = '../assects/images/pta/';
        $targetFilePath = "../assects/images/pta/" . basename($fileUploadName);
        $sqlfileurl = "";

        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "/assects/images/pta/" . basename($fileUploadName);
        }

        if ($connectionobj->connect_error) {
            die("Connection failed: " . $connectionobj->connect_error);
        }

        $committeName = $_POST['committeName'];
        $committePosition = $_POST['committePosition'];
        $committeName_en = $_POST['committeName_en'];
        $committePosition_en = $_POST['committePosition_en'];
        $committePhone = $_POST["staffContact"];

        $sql = "INSERT INTO management_committee (name,name_en, position,position_en, contact_no, image_src) VALUES (?, ?, ?, ?,?,?)";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("ssssss", $committeName,$committeName_en, $committePosition,$committePosition_en, $committePhone, $sqlfileurl);

        if ($stmt->execute()) {
            echo '
            <script>
            alert("សមាជិកគណៈកម្មាធិការថ្មីត្រូវបានបន្ថែមដោយជោគជ័យ")
            </script>';
        } else {
            echo "កំហុស: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }

    if (isset($_POST['add_staff'])) {
        $IDImage = 'file-upload-modified';
        $fileUploadName = $_FILES[$IDImage]['name'];
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];

        $targetDirectory = '../assects/images/staff/';
        $targetFilePath = "../assects/images/staff/" . basename($fileUploadName);
        $sqlfileurl = "";

        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "../assects/images/staff/" . basename($fileUploadName);
        }

        if ($connectionobj->connect_error) {
            die("Connection failed: " . $connectionobj->connect_error);
        }

        $staffName = $_POST['staffName'];
        $staffPost = $_POST['staffPost'];
        $staffName_en = $_POST['staffName_en'];
        $staffPost_en = $_POST['staffPost_en'];
        $staffQualification = $_POST['staffQualification'];
        $staffQualification_en = $_POST['staffQualification_en'];
        $staffPhone = $_POST["staffContact"];

        $sql = "INSERT INTO staffs (name,name_en, post,post_en, contact, qualification,qualification_en, image_src) VALUES (?, ?, ?, ?, ?,?,?,?)";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("ssssssss", $staffName,$staffName_en, $staffPost,$staffPost_en, $staffPhone, $staffQualification,$staffQualification_en, $sqlfileurl);

        if ($stmt->execute()) {
            echo '
            <script>
            alert("បុគ្គលិកថ្មីត្រូវបានបន្ថែមដោយជោគជ័យ")
            </script>';
        } else {
            echo "កំហុស: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }

    if (isset($_POST['committe_delete'])) {
        $committeId = $_POST['comitteDelete_id'];
        mysqli_query($connection, "DELETE FROM `management_committee` WHERE id = $committeId;");
        echo '
            <script>
            window.location.replace("changeStaff.php");            
            </script>';
        exit;
    }

    if (isset($_POST['staffDelete'])) {
        $staffId = $_POST['staffDelete_id'];
        mysqli_query($connection, "DELETE FROM `staffs` WHERE id = $staffId;");
        echo '
            <script>
            window.location.replace("changeStaff.php");            
            </script>';
        exit;
    }

    if (isset($_POST['update_committe'])) {
        $committeId = $_POST['committeId'];
        $IDImage = 'file-upload-modified' . $committeId;
        $fileUploadName = $_FILES[$IDImage]['name'];
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];

        $targetDirectory = '../assects/images/pta/';
        $targetFilePath = "../assects/images/pta/" . basename($fileUploadName);
        $sqlfileurl = $_POST['imageLocationcommitte'];

        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "/assects/images/pta/" . basename($fileUploadName);
        }

        if ($connectionobj->connect_error) {
            die("Connection failed: " . $connectionobj->connect_error);
        }

        $committeName = $_POST['comitteName'];
        $committePost = $_POST['comittepost'];
        $committeName_en = $_POST['comitteName_en'];
        $committePost_en = $_POST['comittepost_en'];
        $committePhone = $_POST["comittePhone"];

        $sql = "UPDATE management_committee SET name=?,name_en=?, position=?,position_en=?, contact_no=?, image_src=? WHERE id=?";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("sssssss", $committeName,$committeName_en, $committePost,$committePost_en, $committePhone, $sqlfileurl, $committeId);

        if ($stmt->execute()) {
            echo '
            <script>
            alert("សមាជិកគណៈកម្មាធិការត្រូវបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ")
            window.location.replace("changeStaff.php");
            </script>';
        } else {
            echo "កំហុស: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }

    if (isset($_POST['update_staffs'])) {
        $staffId = $_POST['staffId'];
        $IDImage = 'file-upload-modified' . $staffId;
        $fileUploadName = $_FILES[$IDImage]['name'];
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];

        $targetDirectory = '../assects/images/staff/';
        $targetFilePath = "../assects/images/staff/" . basename($fileUploadName);
        $sqlfileurl = $_POST['imageLocation'];

        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "../assects/images/staff/" . basename($fileUploadName);
        }

        if ($connectionobj->connect_error) {
            die("Connection failed: " . $connectionobj->connect_error);
        }

        $staffName = $_POST['staffName'];
        $staffPost = $_POST['staffPost'];
        $staffName_en = $_POST['staffName_en'];
        $staffPost_en = $_POST['staffPost_en'];
        $staffPhone = $_POST["staffPhone"];
        $staffqualification = $_POST["staffqualification"];
        $staffqualification_en = $_POST["staffqualification_en"];

        $sql = "UPDATE staffs SET name=?,name_en=?, post=?,post_en=?, qualification=?, qualification_en=?, contact=?, image_src=? WHERE id=?";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("sssssssss", $staffName,$staffName_en, $staffPost,$staffPost_en, $staffqualification,$staffqualification_en, $staffPhone, $sqlfileurl, $staffId);

        if ($stmt->execute()) {
            echo '
            <script>
            alert("បុគ្គលិកត្រូវបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ")
            </script>';
        } else {
            echo "កំហុស: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }

    if (isset($_POST['delete_committe_to_trash'])) {
        $committeId = $_POST['committeId'];

        if (!filter_var($committeId, FILTER_VALIDATE_INT)) {
            $_SESSION['message'] = "លេខសម្គាល់គណៈកម្មាធិការមិនត្រឹមត្រូវ។";
            $_SESSION['message_type'] = "error";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        $deleteToTrashQuery = "UPDATE `management_committee` SET `deleted_at` = NOW() WHERE `id` = ?";
        if ($stmt = mysqli_prepare($connection, $deleteToTrashQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $committeId);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "គណៈកម្មាធិការត្រូវបានផ្លាស់ទីទៅធុងសំរាម។";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "មិនអាចផ្លាស់ទីគណៈកម្មាធិការទៅធុងសំរាមបានទេ: " . mysqli_error($connection);
                $_SESSION['message_type'] = "error";
            }

            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['message'] = "កំហុសក្នុងការរៀបចំសេចក្តីថ្លែងការណ៍: " . mysqli_error($connection);
            $_SESSION['message_type'] = "error";
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['restore_committe_from_trash'])) {
        $committeId = $_POST['committeId'];

        if (!filter_var($committeId, FILTER_VALIDATE_INT)) {
            $_SESSION['message'] = "លេខសម្គាល់គណៈកម្មាធិការមិនត្រឹមត្រូវ។";
            $_SESSION['message_type'] = "error";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        $restoreQuery = "UPDATE `management_committee` SET `deleted_at` = NULL WHERE `id` = ?";
        if ($stmt = mysqli_prepare($connection, $restoreQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $committeId);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "គណៈកម្មាធិការត្រូវបានស្តារឡើងវិញដោយជោគជ័យ។";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "មិនអាចស្តារគណៈកម្មាធិការឡើងវិញបានទេ: " . mysqli_error($connection);
                $_SESSION['message_type'] = "error";
            }

            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['message'] = "កំហុសក្នុងការរៀបចំសេចក្តីថ្លែងការណ៍: " . mysqli_error($connection);
            $_SESSION['message_type'] = "error";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    //delete dat trash
    if (isset($_POST['delete_staffs'])) {
        $staffId = $_POST['id'];

        if (!filter_var($staffId, FILTER_VALIDATE_INT)) {
            $_SESSION['message'] = "លេខសម្គាល់បុគ្គលិកមិនត្រឹមត្រូវ។";
            $_SESSION['message_type'] = "error";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // Soft delete by setting the deleted_at timestamp
        $deleteQuery = "UPDATE `staffs` SET `deleted_at` = NOW() WHERE `id` = ?";
        if ($stmt = mysqli_prepare($connection, $deleteQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $staffId);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "បុគ្គលិកត្រូវបានបញ្ជូនទៅធុងសំរាមដោយជោគជ័យ។";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "មិនអាចបញ្ជូនបុគ្គលិកទៅធុងសំរាមបានទេ: " . mysqli_error($connection);
                $_SESSION['message_type'] = "error";
            }

            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['message'] = "កំហុសក្នុងការរៀបចំសេចក្តីថ្លែងការណ៍: " . mysqli_error($connection);
            $_SESSION['message_type'] = "error";
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }


    // Restore Staff from Trash
    if (isset($_POST['restore_staff_from_trash'])) {
        $staffId = $_POST['staffId'];

        if (!filter_var($staffId, FILTER_VALIDATE_INT)) {
            $_SESSION['message'] = "លេខសម្គាល់ស្តាប់ មិនត្រឹមត្រូវ។";
            $_SESSION['message_type'] = "error";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        $restoreQuery = "UPDATE `staffs` SET `deleted_at` = NULL WHERE `id` = ?";
        if ($stmt = mysqli_prepare($connection, $restoreQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $staffId);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "ស្តាប់ត្រូវបានស្តារឡើងវិញដោយជោគជ័យ។";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "មិនអាចស្តារស្តាប់ឡើងវិញបានទេ: " . mysqli_error($connection);
                $_SESSION['message_type'] = "error";
            }

            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['message'] = "កំហុសក្នុងការរៀបចំសេចក្តីថ្លែងការណ៍: " . mysqli_error($connection);
            $_SESSION['message_type'] = "error";
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$defaultavatar = "../assects/images/defaults/defaultaltimage.jpg";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Staff | Monisakor primary school</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>


</head>

<body class="bg-gray-50 dark:bg-[#0E0E0E]">
    <?php include('../includes/admin_header.php') ?>
    <a href="http://localhost/project/monisakor-primary-school/admin/">

        <button
            class="m-8 px-8 py-2 rounded-full bg-gradient-to-b from-blue-500 to-blue-600 text-white focus:ring-2 focus:ring-blue-400 hover:shadow-xl transition duration-200">
            ត្រឡប់
        </button>

    </a>
    <!-- Main modal -->




    <section class="text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-bold title-font mb-4 text-gray-900 dark:text-white">ធ្វើបច្ចុប្បន្នភាពគណៈកម្មាធិការ និងបុគ្គលិក
                </h1>
                <p class="md:text-base lg:w-2/3 mx-auto leading-relaxed text-base text-gray-900 dark:text-white">
                    🎉 សូមស្វាគមន៍មកកាន់ទំព័រនេះដែលឧទ្ទិសដល់ការគ្រប់គ្រង និងធ្វើបច្ចុប្បន្នភាពព័ត៌មានបុគ្គលិក និងគណៈកម្មាធិការ! 📝 វាបង្កើតផ្ទាំងប្រើប្រាស់ដែលងាយស្រួលសម្រាប់ការធ្វើបច្ចុប្បន្នភាពព័ត៌មានបុគ្គលិក និងរចនាសម្ព័ន្ធគណៈកម្មាធិការ។ ការបញ្ចូលព័ត៌មានរបស់អ្នកមានតម្លៃក្នុងការធានាថាកំណត់ត្រានៅតែមានភាពត្រឹមត្រូវ និងពាក់ព័ន្ធ។ សូមមេត្តាប្រើប្រាស់លក្ខណៈពិសេសដែលមានដើម្បីរក្សាទុកអ្វីៗទាំងអស់ឱ្យទាន់សម័យ។ 🚀
                </p>
            </div>


        </div>
    </section>


    <!-- Modal toggle -->


    <!-- Adding Staff -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#181818]">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        បញ្ចូលបុគ្គលិកសាលា
                    </h3>
                    <button type="button"
                        class="end-2.5 text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
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
                        <div><label for="new_file"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ជ្រើសរើសរូបថតទំហំល្មមសម្រាប់ការមើលល្អ</label></div>
                        <div class="flex items-center justify-center w-full">


                            <input name="file-upload-modified"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-[#181818] dark:text-white focus:outline-none dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input" type="file" accept="image/*">

                        </div>
                        <div>
                            <label for="staffName"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ឈ្មោះ</label>
                            <input type="text" name="staffName"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="គុណ​ កនិ្នកា" required>
                            
                            <label for="staffName_en"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="staffName_en"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Kun Kaknika" required>
                            
                            <label for="staffPost"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">មុខតំណែង</label>
                            <input type="text" name="staffPost"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="គ្រូបង្រៀន" required>
                            
                                <label for="staffPost_en"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
                            <input type="text" name="staffPost_en"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Teacher" required>
                            
                                <label for="staffContact"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">លេខទូរស័ព្ទ</label>
                            <input type="text" name="staffContact"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="9804545454" required>
                            
                                <label for="staffqualification"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">កម្រិតវប្បធម៌</label>
                            <input type="text" name="staffQualification"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="បរិញ្ញាបត្រ" required>

                                <label for="staffqualification_en"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Qualification</label>
                            <input type="text" name="staffQualification_en"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="បរិញ្ញាបត្រ" required>
                        </div>


                        <button type="submit" name="add_staff"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800  focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">បញ្ចូលបុគ្គលិក</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Adding Committe Menber -->

    <div id="authentication-modal2" tabindex="-1" aria-hidden="true"
        class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#181818]">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        បន្ថែមសមាជិកគណៈកម្មាធិការ
                    </h3>
                    <button type="button"
                        class="end-2.5 text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                    <form class="space-y-4" action="" method="POST" enctype="multipart/form-data">
                        <div><label for="new_file"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ជ្រើសរើសរូបថតទំហំល្មមសម្រាប់ការមើលល្អ</label></div>
                        <div class="flex items-center justify-center w-full">


                            <input name="file-upload-modified"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  dark:text-white focus:outline-none dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input" type="file" accept="image/*">

                        </div>
                        <div>
                            <label for="committeName"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ឈ្មោះ</label>
                            <input type="text" name="committeName"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ពៅ មាស" required>
                            <label for="committeName_en"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="committeName_en"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Pov Meas" required>
                            
                            <label for="committePosition"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">មុខតំណែង</label>
                            <input type="text" name="committePosition"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="នាយកសាលា" required>
                            
                            <label for="committePosition_en"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
                            <input type="text" name="committePosition_en"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Principle" required>

                            <label for="committeContact"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">លេខទូរស័ព្ទ</label>
                            <input type="text" name="staffContact"
                                class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="9804545454" required>

                        </div>


                        <button type="submit" name="add_committe"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800  focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">បន្ថែម
                            គណៈកម្មាធិការ</button>

                    </form>
                </div>
            </div>
        </div>
    </div>





    <main>
        <!-- Start block -->
        <section class="bg-gray-50  dark:bg-[#0E0E0E] p-3 mt-5 sm:p-5 antialiased">
            <div class="mx-auto max-w-screen-xl px-0 lg:px-12">
                <!-- Start coding here -->

                <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">

                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">ស្វែងរក</label>
                                <div class="relative w-full">
                                    <button data-modal-target="authentication-modal2" data-modal-toggle="authentication-modal2"
                                        class=" block text-white bg-blue-700 hover:bg-blue-800  focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        បន្ថែមសមាជិកគណៈកម្មាធិការ
                                    </button>

                                </div>
                            </form>
                        </div>

                    </div>
                    <?php
                    if (isset($_SESSION['message'])):
                        $message = $_SESSION['message'];
                        $message_type = $_SESSION['message_type'];
                    ?>
                        <div class="p-4 mb-4 text-sm text-<?= $message_type == 'success' ? 'green' : 'red' ?>-800 bg-<?= $message_type == 'success' ? 'green' : 'red' ?>-200 rounded-lg"
                            role="alert">
                            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
                    <?php endif; ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                            <thead
                                class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                                <tr>
                                    <th scope="col" class="px-4 py-3">ឈ្មោះ</th>
                                    <th scope="col" class="px-4 py-3">Name</th>
                                    <th scope="col" class="px-4 py-3">មុខតំណែង</th>
                                    <th scope="col" class="px-4 py-3">Position</th>
                                    <th scope="col" class="px-4 py-4">លេខទូរស័ព្ទ</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">សកម្មភាព</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                $fetchmanagementCommitte = "SELECT * FROM management_committee WHERE deleted_at IS NULL";
                                $managementCommitte = mysqli_query($connection, $fetchmanagementCommitte);
                                $totalmanagementCommitte = mysqli_num_rows($managementCommitte);


                                if ($totalmanagementCommitte > 0) {
                                    while ($row = mysqli_fetch_assoc($managementCommitte)) {
                                        $managementcommitteId = $row['id'];
                                ?>
                                        <tr class="border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center mr-3">
                                                    <img src="../<?= $row['image_src']; ?>" alt="" class="h-8 w-8 rounded-full object-cover mr-3"
                                                        onerror="this.src='<?= $defaultavatar; ?>'">
                                                    <?= $row['name']; ?>
                                                </div>
                                                
                                            </th>
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                
                                                    <?= $row['name_en']; ?>
                                               
                                                
                                            </th>
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                <?= $row['position']; ?>
                                            </th>
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                <?= $row['position_en']; ?>
                                            </th>
                                            <td class="px-4 py-3"><?= $row['contact_no']; ?></td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <button id="apple-imac-27-dropdown-button"
                                                    data-dropdown-toggle="apple-imac-27-dropdowncommitte<?= $row['id']; ?>"
                                                    class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100"
                                                    type="button">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div id="apple-imac-27-dropdowncommitte<?= $managementcommitteId; ?>"
                                                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                    <ul class="py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                                        <li>
                                                            <button type="button"
                                                                data-modal-target="updateProductModal<?= $managementcommitteId; ?>"
                                                                data-modal-toggle="updateProductModal<?= $managementcommitteId; ?>"
                                                                class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-green-400"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                                </svg>
                                                                កែសម្រួល
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                method="POST">
                                                                <input type="hidden" name="committeId"
                                                                    value="<?= $managementcommitteId; ?>">

                                                                <button type="submit" name="delete_committe_to_trash"
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
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                        aria-label="Table navigation">

                    </nav>
                </div>
            </div>

            <!-- Trash section -->
            <button data-modal-target="timeline-modal" data-modal-toggle="timeline-modal"
                class="ml-20 mt-4 block  font-medium rounded-full text-sm px-5 py-2.5 text-center relative"
                type="button">
                <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>

                <!-- Badge for deleted items count -->
                <?php
                $countTrashQuery = "SELECT COUNT(*) AS trash_count FROM `management_committee` WHERE `deleted_at` IS NOT NULL";
                $result = mysqli_query($connection, $countTrashQuery);
                $trashCount = mysqli_fetch_assoc($result)['trash_count'];
                if ($trashCount > 0) {
                    echo '<span class="absolute top-1 right-3 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">' . $trashCount . '</span>';
                }
                ?>
            </button>
            <!-- mimi -->
            <div id="timeline-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="mx-auto w-[90vw] max-w-screen-2xl px-0 lg:px-12 bg-gray-50 dark:bg-[#181818] dark:bg-[#1e1e1e]">
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">

                        <button type="button"
                            class="text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="timeline-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Start coding here -->
                    <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">
                        <div
                            class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="w-full md:w-1/2">
                                <form class="flex items-center">
                                    <label for="simple-search" class="sr-only">Search</label>
                                    <div class="relative w-full">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <h2 class="text-white"><b>សមាជិកគណៈកម្មាធិការ</b></h2>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                                <thead
                                    class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">ឈ្មោះ</th>
                                        <th scope="col" class="px-4 py-3">Name</th>
                                        <th scope="col" class="px-4 py-3">មុខតំណែង</th>
                                        <th scope="col" class="px-4 py-3">Position</th>
                                        <th scope="col" class="px-4 py-4">លេខទូរស័ព្ទ</th>
                                        <th scope="col" class="px-4 py-3">
                                            <span class="sr-only">សកម្មភាព</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fetchmanagementCommitte = "SELECT * FROM `management_committee` WHERE `deleted_at` IS NOT NULL";
                                    $managementCommitte = mysqli_query($connection, $fetchmanagementCommitte);
                                    $totalmanagementCommitte = mysqli_num_rows($managementCommitte);

                                    if ($totalmanagementCommitte > 0) {
                                        while ($row = mysqli_fetch_assoc($managementCommitte)) {
                                            $managementcommitteId = $row['id'];
                                    ?>
                                            <tr class="border-b dark:border-gray-700">
                                                <th scope="row"
                                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    <div class="flex items-center mr-3">
                                                        <img src="../<?php echo $row['image_src']; ?>" alt=""
                                                            class="h-8 w-8 rounded-full object-cover mr-3"
                                                            onerror="this.src='<?php echo $defaultavatar; ?>'">
                                                        <?php echo $row['name']; ?>
                                                    </div>
                                                </th>
                                                <th scope="row"
                                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                  
                                                        <?php echo $row['name_en']; ?>
                                                  
                                                </th>
                                                <th scope="row"
                                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                    <?php echo $row['position']; ?>
                                                </th>
                                                <th scope="row"
                                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                    <?php echo $row['position_en']; ?>
                                                </th>
                                                <td class="px-4 py-3"><?php echo $row['contact_no']; ?></td>
                                                <td class="px-4 py-3 flex items-center justify-end">
                                                    <button id="apple-imac-27-dropdown-button"
                                                        data-dropdown-toggle="apple-imac-27-dropdowncommitte<?php echo $row['id']; ?>"
                                                        class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100"
                                                        type="button">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                            viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        </svg>
                                                    </button>
                                                    <div id="apple-imac-27-dropdowncommitte<?php echo $managementcommitteId; ?>"
                                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                        <ul class="py-1 text-sm"
                                                            aria-labelledby="apple-imac-27-dropdown-button">
                                                            <li>
                                                                <form
                                                                    action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                    method="POST">
                                                                    <input type="hidden" name="committeId"
                                                                        value="<?= $managementcommitteId; ?>">
                                                                    <button type="submit" name="restore_committe_from_trash"
                                                                        class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                        <svg class="w-6 h-6 text-gray-800 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                                                                            </svg>
                                                                        ស្តារវិញ
                                                                    </button>
                                                                </form>
                                                            </li>


                                                            <li>
                                                                <button type="button"
                                                                    data-modal-target="deleteModal<?php echo $row['id']; ?>"
                                                                    data-modal-toggle="deleteModal<?php echo $row['id']; ?>"
                                                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
                                                                    <svg class="w-4 h-4 mr-2" viewbox="0 0 14 15" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            fill="currentColor"
                                                                            d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078C12.6379 3.90078 12.8668 3.80596 13.0356 3.63718C13.2044 3.46839 13.2992 3.23948 13.2992 3.00078C13.2992 2.76209 13.2044 2.53317 13.0356 2.36439C12.8668 2.1956 12.6379 2.10078 12.3992 2.10078H9.35542L8.70382 0.798481C8.62913 0.649009 8.5143 0.523281 8.37219 0.435378C8.23009 0.347476 8.06631 0.30087 7.89922 0.300781H6.09922ZM4.29922 5.70078C4.29922 5.46209 4.39404 5.23317 4.56282 5.06439C4.73161 4.8956 4.96052 4.80078 5.19922 4.80078C5.43791 4.80078 5.66683 4.8956 5.83561 5.06439C6.0044 5.23317 6.09922 5.46209 6.09922 5.70078V11.1008C6.09922 11.3395 6.0044 11.5684 5.83561 11.7372C5.66683 11.906 5.43791 12.0008 5.19922 12.0008C4.96052 12.0008 4.73161 11.906 4.56282 11.7372C4.39404 11.5684 4.29922 11.3395 4.29922 11.1008V5.70078ZM8.79922 4.80078C8.56052 4.80078 8.33161 4.8956 8.16282 5.06439C7.99404 5.23317 7.89922 5.46209 7.89922 5.70078V11.1008C7.89922 11.3395 7.99404 11.5684 8.16282 11.7372C8.33161 11.906 8.56052 12.0008 8.79922 12.0008C9.03791 12.0008 9.26683 11.906 9.43561 11.7372C9.6044 11.5684 9.69922 11.3395 9.69922 11.1008V5.70078C9.69922 5.46209 9.6044 5.23317 9.43561 5.06439C9.26683 4.8956 9.03791 4.80078 8.79922 4.80078Z" />
                                                                    </svg>
                                                                    លុប
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                        <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                            aria-label="Table navigation">

                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Update modal -->
        <?php
        $fetchmanagementCommitte = "SELECT * FROM `management_committee`;";
        $managementCommitte = mysqli_query($connection, $fetchmanagementCommitte);
        $totalmanagementCommitte = mysqli_num_rows($managementCommitte);

        if ($totalmanagementCommitte > 0) {
            while ($row = mysqli_fetch_assoc($managementCommitte)) {
                $managementcommitteId = $row['id'];
        ?>
                <div id="updateProductModal<?= $managementcommitteId ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">ធ្វើបច្ចុប្បន្នភាពគណៈកម្មាធិការ</h3>
                                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal<?= $managementcommitteId ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">បិទម៉ូដាល់</span>
                                </button>
                            </div>
                            <form method="post" id="UpdateNotice<?= $managementcommitteId ?>" enctype="multipart/form-data">
                                <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                    <div><label for="new_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ឯកសារ (ប្រសិនបើមិនជ្រើសរើស នឹងប្រើឯកសារចាស់)</label></div><br>
                                    <div class="flex items-center justify-center w-full">
                                        <input name="file-upload-modified<?= $managementcommitteId ?>" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-[#181818] dark:text-white focus:outline-none  dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" accept="image/*">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ឈ្មោះ</label>
                                        <input type="text" name="comitteName" id="name" class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['name'] ?>" placeholder="ឈ្មោះ">
                                        
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                        <input type="text" name="comitteName_en" id="name" class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['name_en'] ?>" placeholder="Name">
                                        
                                        <label for="post" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">មុខតំណែង</label>
                                        <input type="text" name="comittepost" id="name" class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['position'] ?>" placeholder="មុខតំណែង">
                                        
                                        <label for="post" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
                                        <input type="text" name="comittepost_en" id="name" class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['position_en'] ?>" placeholder="Position">
                                        
                                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">លេខទូរស័ព្ទ</label>
                                        <input type="text" name="comittePhone" id="name" class="bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['contact_no'] ?>" placeholder="លេខទូរស័ព្ទ">
                                    </div>
                                    <input type="text" name="imageLocationcommitte" id="name" class="hidden bg-gray-50 dark:bg-[#181818] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['image_src'] ?>" placeholder="9812000000">
                                    <input type="hidden" name="committeId" value="<?= $managementcommitteId ?>" />
                                </div>
                                <div class="flex items-center space-x-4">
                                    <button name="update_committe" type="submit" class="text-white bg-blue-700 hover:bg-blue-800  focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ធ្វើបច្ចុប្បន្នភាពគណៈកម្មាធិការ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="deleteModal<?= $managementcommitteId ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <form method="post" id="deleteModal<?= $managementcommitteId ?>">
                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                                <button type="button" class="text-white absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal<?= $managementcommitteId ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">បិទម៉ូដាល់</span>
                                </button>
                                <svg class="text-white dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <p class="mb-4 text-gray-500 dark:text-gray-300">តើអ្នកប្រាកដថាចង់លុបធាតុនេះមែនទេ?</p>
                                <div class="flex justify-center items-center space-x-4">
                                    <button data-modal-toggle="deleteModal<?= $managementcommitteId ?>" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100  focus:ring-blue-300 hover:text-gray-900 focus:z-10 dark:bg-[#181818] dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">ទេ, បោះបង់</button>
                                    <input type="hidden" name="comitteDelete_id" value="<?= $managementcommitteId ?>" />
                                    <button name="committe_delete" type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700  focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">បាទ/ចាស, ខ្ញុំប្រាកដ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        <?php
            }
        }
        ?>


    </main>

    <main>
        <!-- Start block -->
        <section class="bg-gray-50 dark:bg-[#0E0E0E]   p-3 mt-5 sm:p-5 antialiased">
            <div class="mx-auto max-w-screen-xl px-0 lg:px-12">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">ស្វែងរក</label>
                                <div class="relative w-full">
                                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                                        class=" block text-white bg-blue-700 hover:bg-blue-800  focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        បញ្ចូលបុគ្គលិកសាលា
                                    </button>

                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                            <thead
                                class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                                <tr>
                                    <th scope="col" class="px-4 py-3">ឈ្មោះ</th>
                                    <th scope="col" class="px-4 py-3">Name</th>
                                    <th scope="col" class="px-4 py-3">មុខតំណែង</th>
                                    <th scope="col" class="px-4 py-3">Position</th>
                                    <th scope="col" class="px-4 py-4">លេខទូរស័ព្ទ</th>
                                    <th scope="col" class="px-4 py-4">វប្បធម៌</th>
                                    <th scope="col" class="px-4 py-4">Qualification</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">សកម្មភាព</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $fetchmanagementCommitte = "SELECT * FROM `staffs` WHERE `deleted_at` IS NULL"; //go
                                $managementCommitte = mysqli_query($connection, $fetchmanagementCommitte);
                                $totalmanagementCommitte = mysqli_num_rows($managementCommitte);

                                if ($totalmanagementCommitte > 0) {
                                    while ($row = mysqli_fetch_assoc($managementCommitte)) {
                                        $staffsId = $row['id'];
                                ?>
                                        <tr class="border-b dark:border-gray-700">
                                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center mr-3">
                                                    <img src="<?= $row['image_src']; ?>" alt="" class="h-8 w-8 rounded-full object-cover mr-3" onerror="this.src='<?= $defaultavatar; ?>'">
                                                    <?= $row['name']; ?>
                                                </div>
                                            </th>
                                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                              
                                                    <?= $row['name_en']; ?>
                                               
                                            </th>
                                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate"><?= $row['post']; ?></th>
                                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate"><?= $row['post_en']; ?></th>
                                            <td class="px-4 py-3"><?= $row['contact']; ?></td>
                                            <td class="px-4 py-3"><?= $row['qualification']; ?></td>
                                            <td class="px-4 py-3"><?= $row['qualification_en']; ?></td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <button id="apple-imac-27-dropdown-button" data-dropdown-toggle="apple-imac-27-dropdown<?= $row['id']; ?>" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100" type="button">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div id="apple-imac-27-dropdown<?= $staffsId; ?>" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                    <ul class="py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                                        <li>
                                                            <button type="button" data-modal-target="updatestaffsModel<?= $staffsId; ?>" data-modal-toggle="updatestaffsModel<?= $staffsId; ?>" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-green-400"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                                </svg>
                                                                កែសម្រួល
                                                            </button>
                                                        <li>
                                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                                                                <input type="hidden" name="id" value="<?= $staffsId; ?>">
                                                                <button type="submit" name="delete_staffs" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
                                                                    <svg class="w-6 h-6 text-gray-800 dark:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                                    </svg>
                                                                    លុបទៅធុងសំរាម
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                        aria-label="Table navigation">
                    </nav>
                </div>
            </div>
            <!-- ko -->
            <button data-modal-target="timeline-modal2" data-modal-toggle="timeline-modal2"
                class="ml-20 mt-4 block  font-medium rounded-full text-sm px-5 py-2.5 text-center relative"
                type="button">
                <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>

                <!-- Badge for deleted items count -->
                <?php
                $countTrashQuery = "SELECT COUNT(*) AS trash_count FROM `staffs` WHERE `deleted_at` IS NOT NULL";
                $result = mysqli_query($connection, $countTrashQuery);
                $trashCount = mysqli_fetch_assoc($result)['trash_count'];
                if ($trashCount > 0) {
                    echo '<span class="absolute top-1 right-3 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">' . $trashCount . '</span>';
                }
                ?>
            </button>
            <div id="timeline-modal2" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="mx-auto w-[90vw] max-w-screen-2xl px-0 lg:px-12 bg-gray-50 dark:bg-[#181818] dark:bg-[#1e1e1e]">
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">

                        <button type="button"
                            class="text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="timeline-modal2">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Start coding here -->
                    <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">
                        <div
                            class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="w-full md:w-1/2">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">បញ្ចូលបុគ្គលិកសាលា</h1>

                            </div>

                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                                <thead
                                    class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                                    <tr>
                                    <th scope="col" class="px-4 py-3">ឈ្មោះ</th>
                                    <th scope="col" class="px-4 py-3">Name</th>
                                    <th scope="col" class="px-4 py-3">មុខតំណែង</th>
                                    <th scope="col" class="px-4 py-3">Position</th>
                                    <th scope="col" class="px-4 py-4">លេខទូរស័ព្ទ</th>
                                    <th scope="col" class="px-4 py-4">វប្បធម៌</th>
                                    <th scope="col" class="px-4 py-4">Qualification</th>
                                        <th scope="col" class="px-4 py-3">
                                            <span class="sr-only">សកម្មភាព</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fetchmanagementCommitte = "SELECT * FROM `staffs` WHERE `deleted_at` is not NULL"; //go
                                    $managementCommitte = mysqli_query($connection, $fetchmanagementCommitte);
                                    $totalmanagementCommitte = mysqli_num_rows($managementCommitte);

                                    if ($totalmanagementCommitte > 0) {
                                        while ($row = mysqli_fetch_assoc($managementCommitte)) {
                                            $staffsId = $row['id'];
                                    ?>
                                            <tr class="border-b dark:border-gray-700">
                                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    <div class="flex items-center mr-3">
                                                        <img src="<?= $row['image_src']; ?>" alt="" class="h-8 w-8 rounded-full object-cover mr-3" onerror="this.src='<?= $defaultavatar; ?>'">
                                                        <?= $row['name']; ?>
                                                    </div>
                                                </th>
                                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    
                                                        <?= $row['name_en']; ?>
                                                    
                                                </th>
                                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate"><?= $row['post']; ?></th>
                                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate"><?= $row['post_en']; ?></th>
                                                
                                                <td class="px-4 py-3"><?= $row['contact']; ?></td>
                                                <td class="px-4 py-3"><?= $row['qualification']; ?></td>
                                                <td class="px-4 py-3"><?= $row['qualification_en']; ?></td>
                                                <td class="px-4 py-3 flex items-center justify-end">
                                                    <button id="apple-imac-27-dropdown-button" data-dropdown-toggle="apple-imac-27-dropdown<?= $row['id']; ?>" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100" type="button">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        </svg>
                                                    </button>
                                                    <div id="apple-imac-27-dropdown<?= $staffsId; ?>" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                        <ul class="py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                                            <li>
                                                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                                                                    <input type="hidden" name="staffId" value="<?= $staffsId; ?>">
                                                                    <button type="submit" name="restore_staff_from_trash" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-green-500 dark:text-green-400">
                                                                        <svg class="w-6 h-6 text-gray-800 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                                                                        </svg>
                                                                        ស្តារឡើងវិញ
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <button type="button" data-modal-target="deleteStaffModel<?= $row['id']; ?>" data-modal-toggle="deleteStaffModel<?= $row['id']; ?>" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
                                                                    <svg class="w-4 h-4 mr-2" viewbox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078C12.6379 3.90078 12.8668 3.80596 13.0356 3.63718C13.2044 3.46839 13.2992 3.23948 13.2992 3.00078C13.2992 2.76209 13.2044 2.53317 13.0356 2.36439C12.8668 2.1956 12.6379 2.10078 12.3992 2.10078H9.35542L8.70382 0.798481C8.62913 0.649009 8.5143 0.523281 8.37219 0.435378C8.23009 0.347476 8.06631 0.30087 7.89922 0.300781H6.09922ZM4.29922 5.70078C4.29922 5.46209 4.39404 5.23317 4.56282 5.06439C4.73161 4.8956 4.96052 4.80078 5.19922 4.80078C5.43791 4.80078 5.66683 4.8956 5.83561 5.06439C6.0044 5.23317 6.09922 5.46209 6.09922 5.70078V11.1008C6.09922 11.3395 6.0044 11.5684 5.83561 11.7372C5.66683 11.906 5.43791 12.0008 5.19922 12.0008C4.96052 12.0008 4.73161 11.906 4.56282 11.7372C4.39404 11.5684 4.29922 11.3395 4.29922 11.1008V5.70078ZM8.79922 4.80078C8.56052 4.80078 8.33161 4.8956 8.16282 5.06439C7.99404 5.23317 7.89922 5.46209 7.89922 5.70078V11.1008C7.89922 11.3395 7.99404 11.5684 8.16282 11.7372C8.33161 11.906 8.56052 12.0008 8.79922 12.0008C9.03791 12.0008 9.26683 11.906 9.43561 11.7372C9.6044 11.5684 9.69922 11.3395 9.69922 11.1008V5.70078C9.69922 5.46209 9.6044 5.23317 9.43561 5.06439C9.26683 4.8956 9.03791 4.80078 8.79922 4.80078Z" />
                                                                    </svg>
                                                                    លុប
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                            aria-label="Table navigation">
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- Update modal -->
        <?php
        $fetchmanagementCommitte = "SELECT * FROM `staffs`;";
        $managementCommitte = mysqli_query($connection, $fetchmanagementCommitte);
        $totalmanagementCommitte = mysqli_num_rows($managementCommitte);

        if ($totalmanagementCommitte > 0) {
            while ($row = mysqli_fetch_assoc($managementCommitte)) {
                $staffsId = $row['id'];
        ?>
                <div id="updatestaffsModel<?= $staffsId ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">ធ្វើបច្ចុប្បន្នភាពបុគ្គលិក</h3>
                                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updatestaffsModel<?= $staffsId ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">បិទម៉ូដាល់</span>
                                </button>
                            </div>
                            <form method="post" id="UpdateNotice<?= $staffsId ?>" enctype="multipart/form-data">
                                <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                    <div>
                                        <label for="new_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ឯកសារ (ប្រសិនបើមិនជ្រើសរើស នឹងប្រើឯកសារចាស់)</label>
                                    </div>
                                    <br>
                                    <div class="flex items-center justify-center w-full">
                                        <input name="file-upload-modified<?= $staffsId ?>" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-[#181818] dark:text-white focus:outline-none  dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" accept="image/*">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ឈ្មោះ</label>
                                        <input type="text" name="staffName" id="name" class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['name'] ?>" placeholder="ឈ្មោះបុគ្គលិក">
                                        
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                        <input type="text" name="staffName_en" id="name" class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['name_en'] ?>" placeholder="Staff Name">
                                        
                                        <label for="post" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">មុខតំណែង</label>
                                        <input type="text" name="staffPost" id="name" class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['post'] ?>" placeholder="មុខតំណែង">
                                        
                                        <label for="post" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
                                        <input type="text" name="staffPost_en" id="name" class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['post_en'] ?>" placeholder="Position">
                                        
                                        <label for="post" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">វប្បធម៌</label>
                                        <input type="text" name="staffqualification" id="name" class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['qualification'] ?>" placeholder="វប្បធម៌">
                                        
                                        <label for="post" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Qualification</label>
                                        <input type="text" name="staffqualification_en" id="name" class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['qualification_en'] ?>" placeholder="Qualification">
                                        

                                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">លេខទូរស័ព្ទ</label>
                                        <input type="text" name="staffPhone" id="name" class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['contact'] ?>" placeholder="លេខទូរស័ព្ទ">
                                        <input type="text" name="imageLocation" id="name" class="hidden bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?= $row['image_src'] ?>" placeholder="9812000000">
                                    </div>
                                    <input type="hidden" name="staffId" value="<?= $staffsId ?>" />
                                </div>
                                <div class="flex items-center space-x-4">
                                    <button name="update_staffs" type="submit" class="text-white bg-blue-700 hover:bg-blue-800  focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ធ្វើបច្ចុប្បន្នភាពបុគ្គលិក</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="deleteStaffModel<?= $staffsId ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <form method="post" id="deleteStaffModel<?= $staffsId ?>">
                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                                <button type="button" class="text-white absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteStaffModel<?= $staffsId ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">បិទម៉ូដាល់</span>
                                </button>
                                <svg class="text-white dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <p class="mb-4 text-gray-500 dark:text-gray-300">តើអ្នកប្រាកដថាចង់លុបធាតុនេះមែនទេ?</p>
                                <div class="flex justify-center items-center space-x-4">
                                    <button data-modal-toggle="deleteStaffModel<?= $staffsId ?>" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100  focus:ring-blue-300 hover:text-gray-900 focus:z-10 dark:bg-[#181818] dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">ទេ, បោះបង់</button>
                                    <input type="hidden" name="staffDelete_id" value="<?= $staffsId ?>" />
                                    <button name="staffDelete" type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700  focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">បាទ/ចាស, ខ្ញុំប្រាកដ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        <?php
            }
        }
        ?>


    </main>



    <?php include('../includes/admin_footer.php') ?>

    <script>
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

        console.clear();
    </script>



</body>


</html>