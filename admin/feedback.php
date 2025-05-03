<?php
include '../connection/database.php';
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["identity_code"])) {
    header("Location: login.php");
    exit();
}

// Check if the user is not an admin else throw them to scribe
if ($_SESSION["isadmin"] != 1) {
    header("Location: scribe.php");
    exit();
}
// works this way
mysqli_query($connectionobj, "UPDATE `notification` SET total_notification = 0 WHERE id = 2");

if (isset($_POST['feedbackDelete'])) {
    $feedback__Id = $_POST["feedback_id"];
    mysqli_query($connection, "DELETE FROM `contactfeedback` WHERE id = $feedback__Id;");
    echo '
        <script>
        window.location.replace("feedback.php");
        
        </script>';
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Monisakor primary school</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>

    </style>
</head>

<body class="bg-gray-50 dark:bg-[#0E0E0E]">
    <?php include('../includes/admin_header.php') ?>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-bold title-font mb-4 text-gray-900 dark:text-white">មតិយោបល់របស់សាលា</h1>
                <p class=" md:text-base lg:w-2/3 mx-auto leading-relaxed text-base text-gray-900 dark:text-white">ទំព័រនេះត្រូវបានរចនាឡើងសម្រាប់អ្នកគ្រប់គ្រង (Admin) ដើម្បីមើល គ្រប់គ្រង និងលុបមតិយោបល់ដែលបានផ្ញើមកពីអ្នកប្រើប្រាស់ (ឧ. ឪពុកម្ដាយ ឬសិស្ស)។ ទំព័រនេះមានតែ Admin ប៉ុណ្ណោះដែលអាចចូលបាន។</p>
            </div>
        </div>
    </section>

    <!-- Start block -->
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- ចាប់ផ្តើមការសរសេរកូដទីនេះ -->
            <div class="bg-white dark:bg-[#1e1e1e] relative shadow-md sm:rounded-lg overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-white">
                        <thead class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-[#181818] dark:text-white">
                            <tr>
                                <th scope="col" class="px-4 py-4">កាលបរិច្ឆេទ</th>
                                <th scope="col" class="px-4 py-3">ដោយ</th>
                                <th scope="col" class="px-4 py-3">សារ</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">អំពើ</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $fetch_feedback_data = "SELECT * FROM `contactfeedback` ORDER BY id DESC;";
                            $feedbacks = mysqli_query($connection, $fetch_feedback_data);
                            $totalNotice = mysqli_num_rows($feedbacks);

                            if ($totalNotice > 0) {
                                while ($row = mysqli_fetch_assoc($feedbacks)) {
                                    $feedbackId = $row['id'];
                            ?>
                                    <tr class="border-b dark:border-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <?php echo $row['date'] . ' ' . $row['time']; ?>
                                        </th>
                                        <td class="px-4 py-3"><?php echo $row['name']; ?></td>
                                        <td class="px-4 py-3 max-w-[5rem] truncate"><?php echo $row['message']; ?></td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button id="showOption<?php echo $feedbackId; ?>" data-dropdown-toggle="option<?php echo $feedbackId; ?>" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-white dark:hover:text-gray-100" type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="option<?php echo $feedbackId; ?>" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-[#181818] dark:divide-gray-600">
                                                <ul class="py-1 text-sm" aria-labelledby="showOption<?php echo $feedbackId; ?>">
                                                    <li>
                                                        <button type="button" data-modal-target="readProductModal<?php echo $feedbackId; ?>" data-modal-toggle="readProductModal<?php echo $feedbackId; ?>" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                            មើល
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button" data-modal-target="deleteModal<?php echo $feedbackId; ?>" data-modal-toggle="deleteModal<?php echo $feedbackId; ?>" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
                                                            <svg class="w-4 h-4 mr-2" viewbox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078H12.3992V2.10078H9.35542L8.70382 0.798481H7.89922H6.09922ZM4.29922 5.70078V11.1008H6.09922V5.70078H4.29922ZM8.79922 5.70078V11.1008H9.69922V5.70078H8.79922Z" />
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
            </div>
        </div>
    </section>
    <!-- delete -->
    <!-- Delete Modal -->
    <div id="deleteModal<?php echo $feedbackId; ?>" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1e1e1e]">
                <div class="p-6 text-center">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal<?= $feedbackId ?>">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">បិទ</span>
                    </button>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-white">តើអ្នកប្រាកដថាចង់លុបមតិនេះមែនទេ?</h3>
                    <form method="post">
                        <input type="hidden" name="feedback_id" value="<?php echo $feedbackId; ?>">
                        <button data-modal-hide="deleteModal<?php echo $feedbackId; ?>" type="button" class="ml-2 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 dark:bg-[#1e1e1e] dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            បោះបង់
                        </button>
                        <button name="feedbackDelete" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            បាទ/ចាស, លុប
                        </button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete  -->
    <!-- End block -->
    <?php
    $fetch_feedback_data = "SELECT * FROM `contactfeedback` ORDER BY id DESC;";
    $feedbacks = mysqli_query($connection, $fetch_feedback_data);
    $totalNotice = mysqli_num_rows($feedbacks);

    if ($totalNotice > 0) {
        while ($row = mysqli_fetch_assoc($feedbacks)) {
            $feedbackId = $row['id'];
    ?>
            <!-- ប្រអប់អាន -->
            <div id="readProductModal<?php echo $feedbackId; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-xl max-h-full">
                    <!-- ខ្លឹមសារប្រអប់ -->
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-[#1e1e1e] sm:p-5">
                        <!-- ខ្លឹមសារប្រអប់ -->
                        <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                            <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                                <h3 class="font-semibold ">ដោយ <?php echo $row['name']; ?></h3>
                                <p><?php echo $row['date'] . ' ' . $row['time']; ?></p>
                            </div>
                            <div>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="readProductModal<?php echo $feedbackId; ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">បិទប្រអប់</span>
                                </button>
                            </div>
                        </div>
                        <dl>
                            <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">លេខទូរស័ព្ទ</dt>
                            <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-white"><?php echo $row['phone']; ?></dd>
                            <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">សារជូន</dt>
                            <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-white"><?php echo $row['message']; ?></dd>
                        </dl>
                        <div class="flex justify-between items-center">
                            <!-- <button onclick="mailtoUser<?php echo $feedbackId; ?>()" type="button" class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.098 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L8.8 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L4.114 8.254a.502.502 0 0 0-.042-.028.147.147 0 0 1 0-.252.497.497 0 0 0 .042-.028l3.984-2.933z" fill="white"></path> 
                                </svg>
                                ឆ្លើយតប
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function mailtoUser<?php echo $feedbackId; ?>() {
                    window.location.href = "mailto:<?php echo $row['phone']; ?>";
                }
            </script>
    <?php
        }
    }
    ?>
    <?php include('../includes/admin_footer.php') ?>
</body>
<script>
    console.clear();
</script>

</html>