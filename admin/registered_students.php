<?php
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

mysqli_query($connectionobj, "UPDATE `notification` SET total_notification = 0 WHERE id = 1");

if (isset($_POST['student_delete'])) {
    echo '<script>console.log("Form is submitting");</script>';
    $studentId = $_POST["student_id"];

    mysqli_query($connection, "DELETE FROM `students_register` WHERE id = $studentId;");
    echo '
        <script>
        window.location.replace("registered_students.php");
        
        </script>';
    exit;
}
$genderFilter = $_GET['gender'] ?? '';
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : '';

$conditions = [];
if (!empty($genderFilter)) {
    $genderFilterEscaped = mysqli_real_escape_string($connection, $genderFilter);
    $conditions[] = "gender = '$genderFilterEscaped'";
}

if (!empty($searchQuery)) {
    $searchQueryEscaped = mysqli_real_escape_string($connection, $searchQuery);
    $conditions[] = "(full_name LIKE '%$searchQueryEscaped%' 
                    OR gender LIKE '%$searchQueryEscaped%' 
                    OR dob LIKE '%$searchQueryEscaped%' 
                    OR place_of_birth LIKE '%$searchQueryEscaped%')";
}

$whereClause = "";
if (!empty($conditions)) {
    $whereClause = "WHERE " . implode(" AND ", $conditions);
}

$query = "SELECT * FROM students_register $whereClause ORDER BY id DESC";
$students = mysqli_query($connection, $query);
$totalStudents = mysqli_num_rows($students);

$orderClause = "ORDER BY id DESC";
$limitClause = $limit ? "LIMIT $limit" : "";

$query = "SELECT * FROM students_register $whereClause $orderClause $limitClause";
$students = mysqli_query($connection, $query);
$totalStudents = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM students_register $whereClause"));



$defaultavatar = "../assects/images/defaults/defaultaltimage.jpg";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students | Monisakor primary school</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />


</head>
<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<script>
    function printTable() {
        const printContents = document.getElementById("print-area").innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload the page to restore JS behaviors
    }
</script>

<body class="bg-gray-50 dark:bg-[#0E0E0E]">
    <?php include('../includes/admin_header.php') ?>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-700 dark:text-white">សិស្សដែលបានចុះឈ្មោះ</h1>
                <p class="md:text-base lg:w-2/3 mx-auto leading-relaxed text-base text-gray-700 dark:text-white">
                    សូមស្វាគមន៍មកកាន់សាលាបឋមសិក្សាមុនីសាគរ នៅទីនេះអ្នកអាចគ្រប់គ្រងសិស្សដែលបានចុះឈ្មោះទាំងអស់។
                </p>
            </div>
        </div>
    </section>

    <!-- Start block -->
    <section class="bg-gray-50 dark:bg-[#0E0E0E] p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
            <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex justify-between items-center">
                    <div class="flex py-4 px-4 justify-between">
                        <form method="POST" action="export.php" class="">
                            <input type="hidden" name="gender" value="<?= htmlspecialchars($genderFilter) ?>">
                            <input type="hidden" name="search" value="<?= htmlspecialchars($searchQuery) ?>">
                            <button type="submit"
                                class=" mr-4 text-white rounded-md duration-300 transition hover:scale-105">
                                <svg class="w-8 h-8 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v9.293l-2-2a1 1 0 0 0-1.414 1.414l.293.293h-6.586a1 1 0 1 0 0 2h6.586l-.293.293A1 1 0 0 0 18 16.707l2-2V20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd" />
                                </svg>

                            </button>
                        </form>

                        <div class="">
                            <button type="button" onclick="printTable()"
                                class=" text-white rounded-md">
                                <svg class="w-8 h-8 text-gray-800 dark:text-white  duration-300 transition hover:scale-105" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd" />
                                </svg>

                            </button>
                        </div>
                    </div>

                    <!-- Filter form -->
                    <form method="GET" class="p-4">
                        <label for="gender" class="mr-2 font-medium text-gray-700 dark:text-white">ជ្រើសរើសភេទ:</label>
                        <select name="gender" id="gender" class="p-2 border rounded-md bg-gray-50 dark:bg-[#181818] text-gray-700 dark:text-white" onchange="this.form.submit()">
                            <option value="" <?= $genderFilter == '' ? 'selected' : '' ?>>ទាំងអស់</option>
                            <option value="ប្រុស" <?= $genderFilter == 'ប្រុស' ? 'selected' : '' ?>>ប្រុស</option>
                            <option value="ស្រី" <?= $genderFilter == 'ស្រី' ? 'selected' : '' ?>>ស្រី</option>
                        </select>
                    </form>

                    <form method="GET" class="flex items-center gap-2 mb-0">
                        <input type="hidden" name="gender" value="<?= htmlspecialchars($genderFilter) ?>">
                        <input type="hidden" name="search" value="<?= htmlspecialchars($searchQuery) ?>">

                        <label for="limit" class="font-medium text-gray-700 dark:text-white">បង្ហាញចំនួន:</label>
                        <select name="limit" id="limit" onchange="this.form.submit()"
                            class="p-2 border rounded-md bg-gray-50 dark:bg-[#181818] text-gray-700 dark:text-white">
                            <option value="" <?= $limit === '' ? 'selected' : '' ?>>ទាំងអស់</option>
                            <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                            <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
                            <option value="30" <?= $limit == 30 ? 'selected' : '' ?>>30</option>
                        </select>

                        <span class="text-sm text-gray-500 dark:text-gray-400">(សរុប <?= $totalStudents ?> នាក់)</span>
                    </form>


                    <form method="GET" class="p-4 flex items-center gap-2 relative">
                        <label for="search" class="font-medium text-gray-700 dark:text-white">ស្វែងរក:</label>
                        <input type="text" name="search" id="search" placeholder="ឈ្មោះ, ភេទ, ថ្ងៃកំណើត, កន្លែងកំណើត"
                            value="<?= htmlspecialchars($searchQuery) ?>"
                            class="p-2  border rounded-md w-80 bg-gray-50 dark:bg-[#181818] text-white" />
                        <button type="submit" class="absolute right-2 px-4 py-2 text-white rounded-md hover:bg-blue-700">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>

                        </button>
                    </form>




                </div>


                <div id="print-area" class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                        <thead class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                            <tr>
                                <th class="p-4">ឈ្មោះសិស្ស</th>
                                <th class="p-4">ចុះឈ្មោះនៅ</th>
                                <th class="p-4">ភេទ</th>
                                <th class="p-4">ថ្ងៃខែឆ្នាំកំណើត</th>
                                <th class="p-4">ទីកន្លែងកំណើត</th>
                                <th class="p-4 text-center">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($totalStudents > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($students)): ?>
                                    <tr class="border-b dark:border-gray-600 hover:bg-[#272727] dark:hover:bg-[#272727]">
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <?= htmlspecialchars($row['full_name']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                                            <?= htmlspecialchars($row['created_at']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                                            <?= htmlspecialchars($row['gender']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                                            <?= htmlspecialchars($row['dob']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                                            <?= htmlspecialchars($row['place_of_birth']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-center no-print">
                                            <div class="flex justify-center gap-2">
                                                <!-- View Button -->
                                                <button type="button"
                                                    data-drawer-target="drawer-read-product-advanced<?= $row['id'] ?>"
                                                    data-drawer-show="drawer-read-product-advanced<?= $row['id'] ?>"
                                                    aria-controls="drawer-read-product-advanced<?= $row['id'] ?>"
                                                    class="py-2 px-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-[#272727] hover:text-blue-700 dark:bg-[#1e1e1e] dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        class="w-4 h-4 mr-1 inline-block" viewBox="0 0 24 24">
                                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                                                    </svg>
                                                    មើល
                                                </button>

                                                <!-- Delete Button -->
                                                <button type="button"
                                                    data-modal-target="delete-modal<?= $row['id'] ?>"
                                                    data-modal-toggle="delete-modal<?= $row['id'] ?>"
                                                    class="py-2 px-3 text-sm font-medium text-red-700 border border-red-700 rounded-lg hover:bg-red-800 hover:text-white dark:border-red-500 dark:text-red-500 dark:hover:bg-red-600 dark:hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        class="h-4 w-4 mr-1 inline-block" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    លុប
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center p-4 text-red-500">មិនមានទិន្នន័យ</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </section>


    <?php
    $fetch_all_students = "SELECT * FROM `students_register` ORDER BY id DESC;";
    $students = mysqli_query($connection, $fetch_all_students);
    $totalStudents = mysqli_num_rows($students);

    if ($totalStudents > 0) {
        while ($row = mysqli_fetch_assoc($students)) {
            $student_Id = $row['id'];
    ?>
            <!-- Preview Drawer -->
            <div id="drawer-read-product-advanced<?php echo $student_Id; ?>"
                class="overflow-y-auto fixed top-0 left-0 z-50 p-4 w-full max-w-lg h-screen bg-white transition-transform -translate-x-full dark:bg-[#1e1e1e]"
                tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
                <div>
                    <h4 id="read-drawer-label" class="mb-1.5 leading-none text-xl font-semibold text-gray-900 dark:text-white">
                        ចុះឈ្មោះនៅ</h4>
                    <h5 class="mb-5 text-xl font-bold text-gray-900 dark:text-white"><?php echo $row['created_at']; ?></h5>
                </div>
                <button type="button" data-drawer-dismiss="drawer-read-product-advanced<?php echo $student_Id; ?>"
                    aria-controls="drawer-read-product-advanced<?php echo $student_Id; ?>"
                    class="text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">បិទម៉ឺនុយ</span>
                </button>

                <div class="grid grid-cols-3 gap-4 mb-4 sm:mb-5">
                    <div class="p-2 w-auto bg-gray-100 rounded-lg dark:bg-[#181818]">
                        <img src="<?php echo $row['image_url']; ?>" onerror="this.src='<?php echo $defaultavatar; ?>'">
                    </div>
                </div>

                <dl class="grid grid-cols-2 gap-4 mb-4">
                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">ឈ្មោះពេញ</dt>
                        <dd class="text-gray-500 dark:text-white"><?php echo $row['full_name']; ?></dd>
                    </div>

                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">ភេទ</dt>
                        <dd class="text-gray-500 dark:text-white"><?php echo $row['gender']; ?></dd>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">ថ្ងៃខែឆ្នាំកំណើត</dt>
                        <dd class="text-gray-500 dark:text-white"><?php echo $row['dob']; ?></dd>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">ឈ្មោះឪពុក</dt>
                        <dd class="text-gray-500 dark:text-white"><?php echo $row['father_name']; ?></dd>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">មុខរបររបស់ឪពុក</dt>
                        <dd class="text-gray-500 dark:text-white"><?php echo $row['father_job']; ?></dd>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">ឈ្មោះម្តាយ</dt>
                        <dd class="text-gray-500 dark:text-white"><?php echo $row['mother_name']; ?></dd>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">មុខរបររបស់ម្តាយ</dt>
                        <dd class="text-gray-500 dark:text-white"><?php echo $row['mother_job']; ?></dd>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">ទីកន្លែងកំណើត</dt>
                        <dd class="text-gray-500 dark:text-white overflow-hidden text-ellipsis break-words"
                            style="word-wrap: break-word; white-space: normal;">
                            <?php echo $row['place_of_birth']; ?>
                        </dd>
                    </div>

                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">ទីតាំងបច្ចុប្បន្ន</dt>
                        <dd class="text-gray-500 dark:text-white overflow-hidden text-ellipsis break-words"
                            style="word-wrap: break-word; white-space: normal;">
                            <?php echo $row['current_place']; ?></dd>
                    </div>

                    <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 dark:bg-[#181818] dark:border-gray-600">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">លេខទូរស័ព្ទ</dt>
                        <dd class="text-gray-500 dark:text-white"><?php echo $row['phone']; ?></dd>
                    </div>
                </dl>
                <div class="flex bottom-0 left-0 justify-center pb-4 space-x-4 w-full">
                    <button data-drawer-dismiss="drawer-read-product-advanced<?php echo $student_Id; ?>"
                        aria-controls="drawer-read-product-advanced<?php echo $student_Id; ?>" type="button"
                        class="text-white w-full inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        ត្រឡប់ក្រោយ
                    </button>
                    <button onclick="window.location.href='export-students.php?id=<?php echo $student_Id; ?>'" class="inline-flex w-full items-center text-white justify-center bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                        <svg aria-hidden="true" class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.098 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L8.8 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L4.114 8.254a.502.502 0 0 0-.042-.028.147.147 0 0 1 0-.252.497.497 0 0 0 .042-.028l3.984-2.933zM9.3 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"
                                fill="white"></path>
                            <path
                                d="M5.232 4.293a.5.5 0 0 0-.7-.106L.54 7.127a1.147 1.147 0 0 0 0 1.946l3.994 2.94a.5.5 0 1 0 .593-.805L1.114 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.5.5 0 0 0 .042-.028l4.012-2.954a.5.5 0 0 0 .106-.699z"
                                fill="white"></path>
                        </svg>
                        នាំចេញទៅ Excel
                    </button>

                </div>
            </div>

            <!-- Delete Modal -->
            <div id="delete-modal<?php echo $student_Id; ?>" tabindex="-1"
                class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full h-auto max-w-md max-h-full">
                    <form method="post" id="delete_student<?php echo $student_Id; ?>">
                        <div class="relative bg-white rounded-lg shadow dark:bg-[#181818]">
                            <button type="button"
                                class="absolute top-3 right-2.5 text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                data-modal-toggle="delete-modal<?php echo $student_Id; ?>">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">បិទម៉ូដុល</span>
                            </button>

                            <div class="p-6 text-center">
                                <svg aria-hidden="true" class="mx-auto mb-4 text-white w-14 h-14 dark:text-gray-200"
                                    fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <input type="hidden" name="student_id" value="<?php echo $student_Id; ?>" />
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-white">តើអ្នកប្រាកដថាចង់លុប
                                    <?php echo $row['full_name']; ?>?</h3>
                                <button name="student_delete" data-modal-toggle="delete-modal<?php echo $student_Id; ?>"
                                    type="submit"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">បាទ/ចាស,
                                    ខ្ញុំប្រាកដ</button>
                                <button data-modal-toggle="delete-modal<?php echo $student_Id; ?>" type="button"
                                    class="text-gray-500 bg-white hover:bg-[#272727] focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-[#181818] dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">ទេ,
                                    បោះបង់</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function mailto<?php echo $student_Id; ?>() {
                    window.location.href = "mailto:<?php echo $row['email']; ?>";
                }
            </script>
    <?php
        }
    }
    ?>

    <?php include('../includes/admin_footer.php') ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>

<script>
    console.clear();
</script>

</html>