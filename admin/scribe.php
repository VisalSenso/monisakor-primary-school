<?php
include '../connection/database.php';
session_start();

// Set the character set to UTF-8
mysqli_set_charset($connection, "utf8");

if (!isset($_SESSION["identity_code"])) {
    header("Location: login.php");
    exit();
}


// វិធីសាស្រ្ត POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['publish_notice'])) {
        $fileUploadName = $_FILES['file-upload']['name'];

        if (empty($fileUploadName)) {
            echo '<script>
            alert("សូមជ្រើសរើសរូបភាពមុននឹងបញ្ចូលព័ត៌មាន។");
            window.location.href = "add_notice.php";
            </script>';
            exit;
        }
        $fileUploadName = $_FILES['file-upload']['name'];
        $fileUploadTmp = $_FILES['file-upload']['tmp_name'];
        $targetDirectory = '../assects/images/notices_files/';
        $targetFilePath = $targetDirectory . basename($fileUploadName);
        $sqlfileurl = "";

        // ពិនិត្យប្រភេទឯកសារ
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($fileUploadTmp);

        if (!in_array($fileType, $allowedTypes)) {
            echo '<script>alert("ប្រភេទឯកសារមិនត្រឹមត្រូវ។ អាចប្រើបានតែ JPG, PNG, GIF, និង WEBP ប៉ុណ្ណោះ។");</script>';
            exit;
        }

        // ទំហំរូបភាព
        list($width, $height) = getimagesize($fileUploadTmp);
        $minWidth = 200;
        $maxWidth = 2000;
        $minHeight = 200;
        $maxHeight = 2000;

        if ($width < $minWidth || $width > $maxWidth || $height < $minHeight || $height > $maxHeight) {
            echo '<script>alert("ទំហំរូបភាពត្រូវមានចន្លោះ ' . $minWidth . 'x' . $minHeight . ' និង ' . $maxWidth . 'x' . $maxHeight . ' ភីកសែល។");</script>';
            exit;
        }

        // ផ្លាស់ទីឯកសារដែលបានផ្ទុកឡើង
        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "assects/images/notices_files/" . basename($fileUploadName);
        }

        date_default_timezone_set('Asia/Phnom_Penh');
        $currentDate = date("d/m/Y");
        $currentTime = date("h:i A");

        if ($connectionobj->connect_error) {
            die("Connection failed: " . $connectionobj->connect_error);
        }

        // ទទួលតម្លៃបញ្ចូល
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $about_notice = htmlspecialchars($_POST['about_notice'], ENT_QUOTES, 'UTF-8');
        $description_en = htmlspecialchars($_POST['description_en'], ENT_QUOTES, 'UTF-8');
        $about_notice_en = htmlspecialchars($_POST['about_notice_en'], ENT_QUOTES, 'UTF-8');
        $posted_by = $_SESSION["usr_nam"];
        $logo = $_SESSION["profile_pic"];
        $last_modified_default = "មិនបានកែប្រែ";

        // បញ្ចូលទៅក្នុងមូលដ្ឋានទិន្នន័យ
        $sql = "INSERT INTO school_notice (logo, notice_description,notice_description_en, posted_by, date, time, image_url, about, about_en, last_modified) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("ssssssssss", $logo, $description, $description_en, $posted_by, $currentDate, $currentTime, $sqlfileurl, $about_notice, $about_notice_en, $last_modified_default);

        if ($stmt->execute()) {
            echo '<script>alert("ព័ត៌មានត្រូវបានផ្សព្វផ្សាយដោយជោគជ័យ។");</script>';
        } else {
            echo "កំហុស: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }

    if (isset($_POST['update_notice'])) {
        $noticeId = $_POST["notice_id"];
        $imageFieldName = 'file-upload-modified' . $noticeId;

        $sqlfileurl = $_POST["image_name"]; // Default to existing image

        if (isset($_FILES[$imageFieldName]) && $_FILES[$imageFieldName]['error'] === UPLOAD_ERR_OK) {
            $fileUploadName = $_FILES[$imageFieldName]['name'];
            $fileUploadTmp = $_FILES[$imageFieldName]['tmp_name'];

            $targetDirectory = '../assects/images/notices_files/';
            $targetFilePath = $targetDirectory . basename($fileUploadName);

            list($width, $height) = getimagesize($fileUploadTmp);

            $minWidth = 200;
            $maxWidth = 2000;
            $minHeight = 200;
            $maxHeight = 2000;

            if ($width < $minWidth || $width > $maxWidth || $height < $minHeight || $height > $maxHeight) {
                echo '<script>alert("ទំហំរូបភាពត្រូវមានចន្លោះ ' . $minWidth . 'x' . $minHeight . ' និង ' . $maxWidth . 'x' . $maxHeight . ' ភីកសែល។");</script>';
                exit;
            }

            if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
                $sqlfileurl = "assects/images/notices_files/" . basename($fileUploadName);
            }
        }

        date_default_timezone_set('Asia/Phnom_Penh');
        $currentDate = date("d/m/Y");
        $currentTime = date("h:i A");

        if ($connectionobj->connect_error) {
            die("Connection failed: " . $connectionobj->connect_error);
        }

        $description = htmlspecialchars($_POST['notice_description'], ENT_QUOTES, 'UTF-8');
        $about_notice = htmlspecialchars($_POST['about_notice'], ENT_QUOTES, 'UTF-8');
        $description_en = htmlspecialchars($_POST['notice_description_en'], ENT_QUOTES, 'UTF-8');
        $about_notice_en = htmlspecialchars($_POST['about_notice_en'], ENT_QUOTES, 'UTF-8');
        $last_modified_default = $currentTime . " " . $currentDate;

        $sql = "UPDATE school_notice SET notice_description=?, notice_description_en=?, about=?, about_en=?, image_url=?, last_modified=? WHERE id=?";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("sssssss", $description, $description_en, $about_notice, $about_notice_en, $sqlfileurl, $last_modified_default, $noticeId);

        if ($stmt->execute()) {
            echo '<script>
            alert("ព័ត៌មានត្រូវបានកែប្រែដោយជោគជ័យ។");
            window.location.replace("add_notice.php");
        </script>';
        } else {
            echo "កំហុស: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }


    if (isset($_POST['delete_to_trash'])) {
        $noticeId = $_POST['not_id'];
        $deleteToTrashQuery = "UPDATE `school_notice` SET `deleted_at` = NOW() WHERE `id` = $noticeId";
        if (mysqli_query($connection, $deleteToTrashQuery)) {
            $_SESSION['message'] = "ព័ត៌មានត្រូវបានផ្លាស់ទីទៅធុងសំរាម។";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "មិនអាចផ្លាស់ទីព័ត៌មានទៅធុងសំរាមបានទេ។";
            $_SESSION['message_type'] = "error";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['restore_notice'])) {
        $noticeId = $_POST['not_id'];
        $restoreQuery = "UPDATE `school_notice` SET `deleted_at` = NULL WHERE `id` = $noticeId";
        if (mysqli_query($connection, $restoreQuery)) {
            $_SESSION['message'] = "ព័ត៌មានត្រូវបានស្ដារឡើងវិញដោយជោគជ័យ។";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "មិនអាចស្ដារឡើងវិញបានទេ។";
            $_SESSION['message_type'] = "error";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['notice_delete'])) {
        $noticeId = $_POST["notice_id"];

        // Run the DELETE query and save the result
        $query_delete_perminantly = mysqli_query($connection, "DELETE FROM `school_notice` WHERE id = $noticeId");

        if ($query_delete_perminantly) { // Check the result
            $_SESSION['message'] = "ព័ត៌មានត្រូវបានលុបជាអចិន្ត្រៃ!";
            $_SESSION['message_type'] = "error";
        } else {
            $_SESSION['message'] = "មិនអាចលុបជាអចិន្ត្រៃបានទេ!";
            $_SESSION['message_type'] = "error";
        }

        echo '
            <script>
            window.location.replace("add_notice.php");
            </script>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ព័ត៌មាន | Monisakor primary school</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/ovmq9i41cecalfkbsr3hssd82cctkmvv3uk3tc55nzdia11f/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.rich-editor',
            height: 900,
            menubar: false,
            plugins: 'advlist autolink lists link image charmap preview anchor code searchreplace visualblocks fullscreen insertdatetime media table code help wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline | link image blockquote code | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
</head>

<body>
    <?php include('../includes/admin_header.php') ?>

    <main class="bg-gray-50 dark:bg-[#0E0E0E]">
        <!-- <a href="http://localhost/project/monisakor-primary-school/admin/index.php">

            <button
                class="m-8 px-8 py-2 rounded-full bg-gradient-to-b from-blue-500 to-blue-600 text-white focus:ring-2 focus:ring-blue-400 hover:shadow-xl transition duration-200">
                ត្រឡប់
            </button>

        </a> -->
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-10 mx-auto">
                <div class="flex flex-col text-center w-full mb-5">
                    <h1 class="sm:text-3xl text-2xl font-bold title-font mb-4 text-gray-900 dark:text-white">ព័ត៏មាន</h1>
                    <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-gray-900 dark:text-white">
                        ទំព័រនេះត្រូវបានរចនាឡើងសម្រាប់អ្នកគ្រប់គ្រងដើម្បីបង្កើតការជូនដំណឹងថ្មីដែលនឹងត្រូវបានបង្ហាញនៅលើគេហទំព័ររបស់សាលា ទាំងជាឯកសារដែលអាចទាញយកបាន ឬសេចក្តីប្រកាសផ្អែកលើអត្ថបទជាច្រើនភាសា (ឧ. ខ្មែរ និងអង់គ្លេស)។
                    </p>
                </div>

            </div>
        </section>

        <!-- បើកម៉ូដាល់ -->


        <!-- ម៉ូដាល់ចម្បង -->
        <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full"> <!-- ប្តូរ max-w-md ទៅ max-w-2xl សម្រាប់ទទឹងធំ -->
                <!-- មាតិកាម៉ូដាល់ -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-[#1e1e1e]">
                    <!-- ក្បាលម៉ូដាល់ -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-white">
                        <h1 class="text-xl font-bold text-white capitalize dark:text-white">ផ្សព្វផ្សាយព័ត៌មាន</h1>
                        <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-white hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">បិទម៉ូដាល់</span>
                        </button>
                    </div>
                    <!-- រាងកាយម៉ូដាល់ -->

                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1 p-4">



                            <div id="file-upload-container"
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-900 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <div id="upload-container">
                                        <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="file-upload"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span class="">បង្ហោះឯកសារ</span>
                                                <input type="file" name="file-upload" id="file-upload" type="file"
                                                    class="sr-only dark:border-[#181818]" onchange="displayFileName()">
                                            </label>
                                            <p id="file-info" class="pl-1 text-white">ឬអូសនិងទម្លាក់</p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="text-white dark:text-white">អំពី <span style="color: red;">*</span></label>
                                <input name="about_notice" required id="about_notice" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-white bg-white border border-gray-900 rounded-md dark:bg-[#181818] dark:text-white dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            </div>
                            <div>
                                <label class="text-white dark:text-white">About <span style="color: red;">*</span></label>
                                <input name="about_notice_en" required id="about_notice" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-white bg-white border border-gray-900 rounded-md dark:bg-[#181818] dark:text-white dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            </div>

                            <!-- Rich Editors -->
                            <div>
                                <label class="text-white">ការពិពណ៌នាជាភាសាខ្មែរ</label>
                                <textarea name="description" class="rich-editor"></textarea>
                            </div>

                            <div>
                                <label class="text-white">English Description</label>
                                <textarea name="description_en" class="rich-editor"></textarea>
                            </div>

                        </div>

                        <div class="flex justify-end mt-6 p-4">
                            <button type="submit" name="publish_notice"
                                class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">បោះពុម្ព</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Start block -->
        <section class="bg-gray-50 dark:bg-[#0E0E0E] p-3 sm:p-5 antialiased">
            <div class="mx-auto max-w-screen-xl px-0 lg:px-12">
                <!-- display news -->

                <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            បន្ថែមព័ត៌មាន
                        </button>
                        <div class="w-full fle  md:w-1/2">

                            <form class="flex w-full items-center" action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>" method="GET">
                                <div class="relative w-full">
                                    <input type="search" id="search-input" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-900 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ស្វែងរកអំពី..." />
                                    <button type="submit" class="text-white absolute end-2.5 bottom-2 font-medium rounded-full text-sm p-2">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
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
                        <?php
                        // Results per page 
                        $limit = 5;
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $page = max(1, $page);
                        $offset = ($page - 1) * $limit;

                        // Search term
                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                        // ✅ First, count total records
                        if (!empty($search)) {
                            $count_sql = "SELECT COUNT(*) as total FROM school_notice 
                                          WHERE LOWER(about) LIKE ? 
                                             OR LOWER(about_en) LIKE ? 
                                             OR LOWER(notice_description) LIKE ? 
                                             OR LOWER(notice_description_en) LIKE ?";
                            $count_stmt = $connectionobj->prepare($count_sql);
                            $searchTerm = "%" . strtolower($search) . "%";
                            $count_stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                            $count_stmt->execute();
                            $count_result = $count_stmt->get_result();
                        } else {
                            $count_sql = "SELECT COUNT(*) as total FROM school_notice WHERE deleted_at IS NULL";
                            $count_stmt = $connectionobj->prepare($count_sql);
                            $count_stmt->execute();
                            $count_result = $count_stmt->get_result();
                        }

                        $count_row = $count_result->fetch_assoc();
                        $total_records = $count_row['total'];

                        // ✅ Now calculate total pages
                        $total_pages = ceil($total_records / $limit);

                        // ✅ Now fetch the actual records for the current page
                        if (!empty($search)) {
                            $sql = "SELECT * FROM school_notice 
                                    WHERE LOWER(about) LIKE ? 
                                       OR LOWER(about_en) LIKE ? 
                                       OR LOWER(notice_description) LIKE ? 
                                       OR LOWER(notice_description_en) LIKE ?
                                    LIMIT $limit OFFSET $offset";
                            $stmt = $connectionobj->prepare($sql);
                            $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                        } else {
                            $sql = "SELECT * FROM school_notice WHERE deleted_at IS NULL LIMIT $limit OFFSET $offset";
                            $stmt = $connectionobj->prepare($sql);
                        }

                        $stmt->execute();
                        $result = $stmt->get_result();
                        ?>


                        <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                            <thead
                                class="text-xs text-white uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-xl">អំពី</th>
                                    <th scope="col" class="px-4 py-3 text-xl">About</th>
                                    <th scope="col" class="px-4 py-4 text-xl">អ្នកសរសេរ</th>
                                    <th scope="col" class="px-4 py-4 text-xl">បោះពុម្ពនៅ</th>
                                    <th scope="col" class="px-4 py-3 text-xl">កែប្រែចុងក្រោយ</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only text-xl">សកម្មភាព</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $noticeId = $row['id'];
                                ?>
                                        <tr class="border-b dark:border-gray-600">
                                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                <?= html_entity_decode($row['about'], ENT_QUOTES, 'UTF-8') ?>
                                            </th>
                                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                <?= html_entity_decode($row['about_en'], ENT_QUOTES, 'UTF-8') ?>
                                            </th>

                                            <td class="px-4 py-3">
                                                <?= htmlspecialchars($row['posted_by'], ENT_QUOTES, 'UTF-8') ?></td>

                                            <td class="px-4 py-3"><?= htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8') ?>
                                                <?= htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') ?></td>

                                            <td class="px-4 py-3">
                                                <?= htmlspecialchars($row['last_modified'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <!-- Action buttons (Edit, Delete, etc.) -->
                                            </td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <button id="apple-imac-27-dropdown-button"
                                                    data-dropdown-toggle="apple-imac-27-dropdown<?= $noticeId ?>"
                                                    class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-600 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100"
                                                    type="button">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div id="apple-imac-27-dropdown<?= $noticeId ?>"
                                                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                    <ul class="py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                                        <li>
                                                            <button type="button" data-modal-target="updateProductModal<?= $noticeId ?>"
                                                                data-modal-toggle="updateProductModal<?= $noticeId ?>"
                                                                class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-white dark:text-white">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-green-400"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                                </svg>
                                                                កែ
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>" method="POST">
                                                                <input type="hidden" name="not_id" value="<?= $row['id'] ?>">
                                                                <button type="submit" name="delete_to_trash"
                                                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-white dark:text-white">
                                                                    <svg class="w-6 h-6 text-gray-800 dark:text-red-400" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                                } else {
                                    echo "<tr><td colspan='4' class='text-center py-4'>No notices found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="pagination flex space-x-1 items-center justify-center mt-4">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"
                                    class="rounded-full border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                                    Prev
                                </a>
                            <?php endif; ?>

                            <!-- Page numbers -->
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"
                                    class="min-w-9 rounded-full py-2 px-3.5 text-center text-sm transition-all shadow-sm hover:shadow-lg ml-2
            <?php echo $i == $page
                                    ? 'bg-slate-800 text-white'
                                    : 'border border-slate-300 text-slate-600 hover:bg-slate-800 hover:text-white hover:border-slate-800'; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"
                                    class="rounded-full border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                                    Next
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <!-- Trash section -->
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
                    $countTrashQuery = "SELECT COUNT(*) AS trash_count FROM `school_notice` WHERE `deleted_at` IS NOT NULL";
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
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-white">

                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-white hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="timeline-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">
                            <div
                                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                                <div class="w-full md:w-1/2">
                                    <form class="flex items-center">
                                        <div class="relative w-full">
                                            <input disabled type="text" readonly
                                                value="🗑️ ព័ត៌មានដែលបានលុប (Trash Table)"
                                                class="font-black bg-gray-50 border border-gray-900 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Deleted notices are shown here." required="">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                                    <thead
                                        class="text-xs text-white uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-xl">អំពី</th>
                                            <th scope="col" class="px-4 py-4 text-xl">បោះពុម្ពនៅ</th>
                                            <th scope="col" class="px-4 py-3 text-xl">កាលបរិច្ឆេទលុប</th>
                                            <th scope="col" class="px-4 py-3">
                                                <span class="sr-only text-xl">សកម្មភាព</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch notices that are in the trash (those with a non-null 'deleted_at' timestamp)
                                        $fetch_trash_data = "SELECT * FROM `school_notice` WHERE `deleted_at` IS NOT NULL ORDER BY `deleted_at` DESC";

                                        $trashNotices = mysqli_query($connection, $fetch_trash_data);
                                        $totalTrash = mysqli_num_rows($trashNotices);

                                        if ($totalTrash > 0) {
                                            while ($row = mysqli_fetch_assoc($trashNotices)) {
                                                $noticeId = $row['id']; // Assign the ID to $noticeId for use in dynamic elements
                                        ?>
                                                <tr class="border-b dark:border-gray-600">
                                                    <th scope="row"
                                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-[10rem] truncate">
                                                        <?= htmlspecialchars($row['about'], ENT_QUOTES, 'UTF-8') ?>
                                                    </th>
                                                    <td class="px-4 py-3">
                                                        <?= htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8') ?>
                                                        <?= htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') ?>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <?= htmlspecialchars($row['deleted_at'], ENT_QUOTES, 'UTF-8') ?>
                                                    </td>
                                                    <td class="px-4 py-3 flex items-center justify-end">
                                                        <button id="dropdown-button-<?= $noticeId ?>"
                                                            data-dropdown-toggle="dropdown-<?= $noticeId ?>"
                                                            class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-600 p-1.5 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100"
                                                            type="button">
                                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </button>
                                                        <div id="dropdown-<?= $noticeId ?>"
                                                            class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                            <ul class="py-1 text-sm" aria-labelledby="dropdown-button-<?= $noticeId ?>">

                                                                <!-- Restore Button -->
                                                                <li>
                                                                    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>">
                                                                        <input type="hidden" name="not_id" value="<?= $noticeId; ?>">
                                                                        <button type="submit" name="restore_notice"
                                                                            class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-white dark:text-white dark:hover:text-white">
                                                                            <svg class="w-6 h-6 text-gray-800 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                                                                            </svg>

                                                                            ស្ដារវិញ
                                                                        </button>
                                                                    </form>
                                                                </li>

                                                                <!-- Delete Button -->
                                                                <li>
                                                                    <button type="button" data-modal-target="deleteModal<?= $noticeId ?>" data-modal-toggle="deleteModal<?= $noticeId ?>"
                                                                        class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-white dark:text-white dark:hover:text-white">
                                                                        <svg class="w-6 h-6 text-gray-800 dark:text-red-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M5 7h14M10 11v6m4-6v6M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
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
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                                                    រកមិនឃើញព័ត៏មាននៅធុងសំរាមទេ។
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>


        <!-- Update modal -->
        <?php
        $fetch_notice_data = "SELECT * FROM `school_notice` ORDER BY id DESC;";
        $notices = mysqli_query($connection, $fetch_notice_data);
        $totalNotice = mysqli_num_rows($notices);

        if ($totalNotice > 0) {
            while ($row = mysqli_fetch_assoc($notices)) {
                $noticeId = $row['id'];
        ?>
                <div id="updateProductModal<?= $noticeId ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">ធ្វើបច្ចុប្បន្នភាពសេចក្ដីជូនដំណឹង</h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-white hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal<?= $noticeId ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">បិទម៉ូដាល់</span>
                                </button>
                            </div>
                            <form method="post" id="UpdateNotice<?= $noticeId ?>" enctype="multipart/form-data">
                                <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                    <div><label for="new_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ឯកសារ (ប្រសិនបើមិនជ្រើសរើស នឹងប្រើឯកសារចាស់)</label></div><br>
                                    <div class="flex items-center justify-center w-full">
                                        <input name="file-upload-modified<?= $noticeId ?>" class="block w-full text-sm text-gray-900 border border-gray-900 rounded-lg cursor-pointer bg-gray-50 dark:text-white focus:outline-none dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ប្រធានបទ</label>
                                        <input type="text" name="about_notice" id="name" value="<?= htmlspecialchars($row['about'], ENT_QUOTES, 'UTF-8') ?>" class="bg-gray-50 border border-gray-900 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="សាលារៀនយើងនឹងបិទថ្ងៃស្អែក">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">About</label>
                                        <input type="text" name="about_notice_en" id="name" value="<?= htmlspecialchars($row['about_en'], ENT_QUOTES, 'UTF-8') ?>" class="bg-gray-50 border border-gray-900 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-[#181818] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="សាលារៀនយើងនឹងបិទថ្ងៃស្អែក">
                                    </div>
                                    <input type="hidden" name="notice_id" value="<?= $noticeId ?>" />
                                    <div class="sm:col-span-2"><label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">សេចក្ដីពិពណ៌នា</label>
                                        <textarea name="notice_description" class="rich-editor"><?= $row['notice_description'] ?></textarea>
                                    </div>
                                    <div class="sm:col-span-2"><label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                        <textarea name="notice_description_en" class="rich-editor"><?= $row['notice_description_en'] ?></textarea>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <button name="update_notice" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ធ្វើបច្ចុប្បន្នភាពសេចក្ដីជូនដំណឹង</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="deleteModal<?= $noticeId ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <form method="post" id="deleteModal<?= $noticeId ?>">
                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                                <button type="button" class="text-gray-400 dark:text-white absolute top-2.5 right-2.5 bg-transparent hover:bg-white hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal<?= $noticeId ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">បិទម៉ូដាល់</span>
                                </button>
                                <p class="mb-4 text-gray-500 dark:text-white">តើអ្នកប្រាកដថាចង់លុបធាតុនេះឬ?</p>
                                <div class="flex justify-center items-center space-x-4">
                                    <button data-modal-toggle="deleteModal<?= $noticeId ?>" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 dark:white bg-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-900 hover:text-gray-900 focus:z-10 dark:bg-[#181818] dark:text-white dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">ទេ, បោះបង់</button>
                                    <input type="hidden" name="notice_id" value="<?= $noticeId ?>" />
                                    <button name="notice_delete" type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-[#E50914] rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-900 dark:bg-[#E50914] dark:hover:bg-red-600 dark:focus:ring-red-900">បាទ/ចាស, ខ្ញុំប្រាកដ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

        <?php
            } // <-- this is where the `while` loop should end
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