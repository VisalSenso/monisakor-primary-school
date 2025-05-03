<?php
include '../connection/database.php';
session_start();
// Check if the user is logged in (you can customize this based on your session variables)
if (!isset($_SESSION['isadmin'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}



// Check if the user is not an admin
if ($_SESSION["isadmin"] != 1) {
    header("Location: scribe.php");
    exit();
}

try {

    $query = "SELECT * FROM notification WHERE id = 1";
    $query2 = "SELECT * FROM notification WHERE id = 2";

    $result = mysqli_query($connection, $query);
    $feedback_result = mysqli_query($connection, $query2);



    if ($result) {

        $row = mysqli_fetch_assoc($result);
        $feedback = mysqli_fetch_assoc($feedback_result);

    } else {
        echo "Error executing the query: " . mysqli_error($connection);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {

    mysqli_close($connection);
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
   
   
</head>

<body class="bg-gray-50 dark:bg-[#0E0E0E]">
    <?php include('../includes/admin_header.php') ?>

    <main>
        <section class="text-gray-600 body-font">

            <div class="container px-5 py-10 mx-auto">
                <div class="flex flex-col text-center w-full mb-20">
                    <h1 class="sm:text-3xl text-2xl font-bold title-font mb-4 text-white">សូមស្វាគមន៍មកកាន់ Admin
                        Pannel</h1>
                    <p class="md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                        ...
                    </p>
                </div>
                <div class="flex flex-wrap -m-2">

                    <!-- <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="flash_notice()">
                        <div
                            class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)] p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727]  cursor-pointer">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/flash_notice.png">
                            <div class="flex-grow">
                                <h2 class="text-white title-font font-medium">កាតពន្លឺ សូមស្វាគមន៍</h2>
                                <p class="text-sm md:text-base text-gray-500">បង្កើតកាតពន្លឺស្វាគមន៍ថ្មី។</p>
                            </div>
                        </div>
                    </div> -->



                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="add_notice()">
                        <div
                            class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)]  p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727] cursor-pointer">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/notice.jpg">
                            <div class="flex-grow">
                                <h2 class="text-white title-font font-medium">បន្ថែមព័ត៌មាន</h2>
                                <p class="text-sm md:text-base text-gray-500">បន្ថែម ឬលុបព័ត៌មាន</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="registered_students()">
                        <span class="relative">
                            <div
                                class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)]  p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727] cursor-pointer">
                                <img alt="team"
                                    class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                    src="../assects/images/adminavatars/registered.png">
                                <div class="flex-grow">
                                    <h2 class="text-white title-font font-medium">មើលសិស្សដែលបានចុះឈ្មោះ </h2>
                                    <p class="text-sm md:text-base text-gray-500">សិស្សដែលបានចុះឈ្មោះតាមអ៊ីនធឺណិត</p>
                                </div>
                            </div>
                            <?php if ($row['total_notification'] != 0) {
                                echo '
                            <div
                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                ' . $row['total_notification'] . '</div>';

                            }
                            ?>

                        </span>
                    </div>

                    <!-- <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="changeRoutine()">
                        <div
                            class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)]  p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727] cursor-pointer">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/routine.png">
                            <div class="flex-grow">
                                <h2 class="text-white title-font font-medium">ផ្លាស់ប្តូរទម្លាប់</h2>
                                <p class="text-sm md:text-base text-gray-500">ផ្លាស់ប្តូរទម្លាប់ថ្នាក់</p>
                            </div>
                        </div>
                    </div> -->

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="changeStaff()">
                        <div
                            class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)]  p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727] cursor-pointer">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/staffs.png">
                            <div class="flex-grow">
                                <h2 class="text-white title-font font-medium">ផ្លាស់ប្តូរព័ត៌មានលម្អិតបុគ្គលិក</h2>
                                <p class="text-sm md:text-base text-gray-500"> បន្ថែមការដកចេញ
                                    និងកែប្រែព័ត៌មានលម្អិតរបស់បុគ្គលិក</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="site_content()">
                        <div
                            class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)]  p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727] cursor-pointer">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/site content.jpg">
                            <div class="flex-grow">
                                <h2 class="text-white title-font font-medium">ផ្លាស់ប្តូរមាតិកាគេហទំព័រ</h2>
                                <p class="text-sm md:text-base text-gray-500"> ផ្លាស់ប្តូរមាតិកាគេហទំព័រពេញលេញ</p>
                            </div>
                        </div>
                    </div>



                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="add_gallery()">
                        <div
                            class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)] p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727] cursor-pointer">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/add gallery.png">
                            <div class="flex-grow">
                                <h2 class="text-white title-font font-medium">បន្ថែមវិចិត្រសាល</h2>
                                <p class="text-sm md:text-base text-gray-500">
                                    បន្ថែម​ពេល​វេលា​ដូច​ជា​ការ​ដើរ​លេង​កម្សាន្ត ព្រឹត្តិការណ៍</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="feedback_page()">
                        <span class="relative">
                            <div
                                class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)]  p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727] cursor-pointer">
                                <img alt="team"
                                    class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                    src="../assects/images/adminavatars/feedback.png">
                                <div class="flex-grow">
                                    <h2 class="text-white title-font font-medium">មើលមតិកែលម្អ </h2>
                                    <p class="text-sm md:text-base text-gray-500">មតិ​ផ្តល់​ជូន​នៅ​លើ​គេហទំព័រ</p>
                                </div>
                            </div>
                            <?php if ($feedback['total_notification'] != 0) {
                                echo '
                            <div
                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                ' . $feedback['total_notification'] . '</div>';
                            }
                            ?>
                        </span>
                    </div>

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="adminAndScribe()">
                        <div
                            class="h-full flex items-center shadow-[0_8px_30px_rgb(0,0,0,0.12)]  p-4 rounded-lg dark:bg-[#1e1e1e] bg-gray-50 hover:bg-[#272727] cursor-pointer">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/adminadd.png">
                            <div class="flex-grow">
                                <h2 class="text-white title-font font-medium">បន្ថែម
                                    ឬលុបអ្នកសរសេរចេញសម្រាប់ការជូនដំណឹង</h2>
                                <p class="text-sm md:text-base text-gray-500"> Scribe អាចបន្ថែម ឬលុបការជូនដំណឹង</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <?php include('../includes/admin_footer.php') ?>
</body>
<script>
    function add_notice() {
        window.location.href = "add_notice.php";
    }

    function site_content() {
        window.location.href = "site_content.php";
    }

    function feedback_page() {
        window.location.href = "feedback.php";
    }

    function flash_notice() {
        window.location.href = "flash_notice.php";
    }

    function add_gallery() {
        window.location.href = "add_gallery.php";
    }

    function registered_students() {
        window.location.href = "registered_students.php";
    }

    function changeRoutine() {
        window.location.href = "changeRoutine.php";

    }

    function changeStaff() {
        window.location.href = "changeStaff.php";

    }
    function adminAndScribe() {
        window.location.href = "adminandscribe.php";

    }


    console.clear();

</script>

</html>