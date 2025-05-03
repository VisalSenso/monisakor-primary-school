<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../connection/database.php';

// ប្តូរទិសដៅប្រសិនបើមិនបានចូលឬមិនមែនជាអ្នកគ្រប់គ្រង
if (!isset($_SESSION["identity_code"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["isadmin"] != 1) {
    header("Location: scribe.php");
    exit();
}

// ដោះស្រាយសំណើ POST ដើម្បីធ្វើបច្ចុប្បន្នភាពទិន្នន័យ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // ទំព័រដើម
    $homeOne = $_POST['homeOne'] ?? '';
    $homeTwo = $_POST['homeTwo'] ?? '';
    $homeThree = $_POST['homeThree'] ?? '';
    $homeFour = $_POST['homeFour'] ?? '';
    $homeFive = $_POST['homeFive'] ?? '';
    $homeSix = $_POST['homeSix'] ?? '';
    $homeSeven = $_POST['homeSeven'] ?? '';
    $homeEight = $_POST['homeEight'] ?? '';
    $homeOne_en = $_POST['homeOne_en'] ?? '';
    $homeTwo_en = $_POST['homeTwo_en'] ?? '';

    // ទំព័រអំពី
    $aboutKeys = [
        'One',
        'Two',
        'Three',
        'Four',
        'Five',
        'Six',
        'Seven',
        'Eight',
        'Nine',
        'Ten',
        'Eleven',
        'Twelve',
        'Thirteen',
        'Fourteen',
        'Fifteen',
        'Sixteen',
        'Seventeen',
        'Eighteen',
        'Ninteen',
        'Twenty',
        'Twentyone',
        'One_en',
        'Two_en',
        'Three_en',
        'Four_en',
        'Five_en',
        'Six_en',
        'Seven_en',
        'Eight_en',
        'Nine_en',
        'Ten_en',
        'Eleven_en',
        'Twelve_en',
        'Thirteen_en',
        'Fourteen_en',
        'Fifteen_en',
        'Sixteen_en',
        'Seventeen_en',
        'Eighteen_en',
        'Ninteen_en',
        'Twenty_en',
        'Twentyone_en'
    ];
    $aboutData = [];
    foreach ($aboutKeys as $key) {
        $aboutData[] = $_POST['about' . $key] ?? '';
    }

    // បន្ថែម
    $extraOne = $_POST['extraOne'] ?? '';
    $extraOne_en = $_POST['extraOne_en'] ?? '';
    // ទំនាក់ទំនង
    $contactOne = $_POST['contactOne'] ?? '';
    $contactOne_en = $_POST['contactOne_en'] ?? '';
    // ចុះឈ្មោះ
    $joinOne = $_POST['joinOne'] ?? '';
    $joinOne_en = $_POST['joinOne_en'] ?? '';

    try {
        // ទំព័រដើម
        $homeStmt = $connection->prepare("UPDATE web_content SET one = ?, two = ?, three = ?, four = ?, five = ?, six = ?, seven = ?, eight = ?, one_en = ?, two_en = ? WHERE id = 1");
        $homeStmt->bind_param("ssssssssss", $homeOne, $homeTwo, $homeThree, $homeFour, $homeFive, $homeSix, $homeSeven, $homeEight, $homeOne_en, $homeTwo_en);

        // ទំព័រអំពី
        $aboutQuery = "UPDATE web_content SET one = ?, two = ?, three = ?, four = ?, five = ?, six = ?, seven = ?, eight = ?, nine = ?, ten = ?, eleven = ?, twelve = ?, thirteen = ?, fourteen = ?, fifteen = ?, sixteen = ?, seventeen = ?, eighteen = ?, ninteen = ?, twenty = ?, twentyone = ?,  
                                               one_en = ?, two_en = ?, three_en = ?, four_en = ?, five_en = ?, six_en = ?, seven_en = ?, eight_en = ?, nine_en = ?, ten_en = ?, eleven_en = ?, twelve_en = ?, thirteen_en = ?, fourteen_en = ?, fifteen_en = ?, sixteen_en =?, seventeen_en = ?, eighteen_en = ?, ninteen_en = ?, twenty_en = ?, twentyone_en = ?    WHERE id = 2";
        $aboutStmt = $connection->prepare($aboutQuery);
        $aboutStmt->bind_param(str_repeat("s", 42), ...$aboutData);

        // បន្ថែម, ទំនាក់ទំនង, ចុះឈ្មោះ
        $extraStmt = $connection->prepare("UPDATE web_content SET one = ?, one_en = ? WHERE id = 6");
        $extraStmt->bind_param("ss", $extraOne, $extraOne_en);

        $contactStmt = $connection->prepare("UPDATE web_content SET one = ?, one_en = ? WHERE id = 4");
        $contactStmt->bind_param("ss", $contactOne, $contactOne_en);

        $joinStmt = $connection->prepare("UPDATE web_content SET one = ?, one_en = ? WHERE id = 5");
        $joinStmt->bind_param("ss", $joinOne, $joinOne_en);

        // ប្រតិបត្តិការទាំងអស់
        $executeSuccess = true;

        if (!$homeStmt->execute()) {
            echo "កំហុសក្នុងការធ្វើបច្ចុប្បន្នភាពផ្នែកទំព័រដើម: " . $homeStmt->error . "<br>";
            $executeSuccess = false;
        }

        if (!$aboutStmt->execute()) {
            echo "កំហុសក្នុងការធ្វើបច្ចុប្បន្នភាពផ្នែកអំពី: " . $aboutStmt->error . "<br>";
            $executeSuccess = false;
        }

        if (!$extraStmt->execute()) {
            echo "កំហុសក្នុងការធ្វើបច្ចុប្បន្នភាពផ្នែកបន្ថែម: " . $extraStmt->error . "<br>";
            $executeSuccess = false;
        }

        if (!$contactStmt->execute()) {
            echo "កំហុសក្នុងការធ្វើបច្ចុប្បន្នភាពផ្នែកទំនាក់ទំនង: " . $contactStmt->error . "<br>";
            $executeSuccess = false;
        }

        if (!$joinStmt->execute()) {
            echo "កំហុសក្នុងការធ្វើបច្ចុប្បន្នភាពផ្នែកចុះឈ្មោះ: " . $joinStmt->error . "<br>";
            $executeSuccess = false;
        }

        if ($executeSuccess) {
            echo "<script>alert('មាតិកាត្រូវបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ!'); window.location.replace('site_content.php');</script>";
        }

        // បិទទាំងអស់
        $homeStmt->close();
        $aboutStmt->close();
        $extraStmt->close();
        $contactStmt->close();
        $joinStmt->close();
    } catch (Exception $e) {
        echo "កំហុស: " . $e->getMessage();
    }

    $connection->close();
    exit();
}

// ទាញយកទិន្នន័យដែលមានស្រាប់
$queries = [
    "home" => "SELECT * FROM web_content WHERE id = 1",
    "about" => "SELECT * FROM web_content WHERE id = 2",
    "contactus" => "SELECT * FROM web_content WHERE id = 4",
    "joinus" => "SELECT * FROM web_content WHERE id = 5",
    "extras" => "SELECT * FROM web_content WHERE id = 6"
];

$data = [];

foreach ($queries as $key => $query) {
    $result = mysqli_query($connection, $query);
    if ($result) {
        $data[$key] = mysqli_fetch_assoc($result);
    } else {
        echo "កំហុសក្នុងការទាញយក $key: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
<!-- <?php
        echo "<pre>";
        print_r($data['home']);
        echo "</pre>";
        ?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>មាតិកាគេហទំព័រ | Monisakor primary school</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>


</head>

<body class="bg-gray-50 dark:bg-[#0E0E0E]">
    <?php include('../includes/admin_header.php') ?>
    <section class="text-gray-400 body-font ">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-bold title-font mb-4 text-gray-900 dark:text-white">ផ្លាស់ប្តូរមាតិកាគេហទំព័រ
                </h1>
                <p class=" md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                    សូមជំរាបជូនថា ខ្លឹមសារនៅលើទំព័រនីមួយៗអាចមានការកែប្រែ ឬផ្លាស់ប្តូរពីចំណុចនេះទៅមុខ។
                    មុននឹងរក្សាទុកមាតិកាណាមួយ វាត្រូវបានណែនាំយ៉ាងខ្លាំងឱ្យបញ្ជាក់
                    និងធ្វើឱ្យមានសុពលភាពនៃការផ្លាស់ប្តូរដែលបានធ្វើ។
                    ការយកចិត្តទុកដាក់របស់អ្នកចំពោះបញ្ហានេះត្រូវបានកោតសរសើរ ដោយធានានូវភាពត្រឹមត្រូវ
                    និងសុចរិតភាពនៃព័ត៌មានដែលបានបង្ហាញ។</p>
            </div>
        </div>
    </section>

    <form action="" method="POST">
        <div class="m-5" id="accordion-collapse" data-accordion="collapse">
            <h2 id="accordion-collapse-heading-1">
                <button type="button"
                    class="flex items-center justify-between w-full p-5 font-bold rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-[#1e1e1e] dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:bg-[#1e1e1e] focus:dark:bg-[#181818] dark:hover:bg-[#1e1e1e] gap-3"
                    data-accordion-target="#accordion-collapse-body-1" aria-expanded="false"
                    aria-controls="accordion-collapse-body-1">
                    <span>ទំព័រដើម</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-[#0E0E0E]">
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">ចក្ខុវិស័យ</p>
                    <textarea name="homeOne" rows="5" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['home']['one']); ?></textarea>

                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Vision</p>
                    <textarea name="homeOne_en" rows="5" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['home']['one_en']); ?></textarea>

                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">បេសកម្ម</p>
                    <textarea name="homeTwo" rows="5" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['home']['two']); ?></textarea>

                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Mission</p>
                    <textarea name="homeTwo_en" rows="5" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['home']['two_en']); ?></textarea>

                    <!-- <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Why Pashupati ? - Highly Qualified Teachers</p>
            <textarea name="homeThree" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['three']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Why Pashupati ? - Peaceful Environment</p>
            <textarea name="homeFour" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['four']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Why Pashupati ? - Digital Learning</p>
            <textarea name="homeFive" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['five']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Why Pashupati ? - Facilited Development Enviroment</p>
            <textarea name="homeSix" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['six']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">What student says about us ?</p>
            <textarea name="homeSeven" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['seven']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Computer Engineering</p>
            <textarea name="homeEight" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['eight']; ?></textarea> -->

                </div>
            </div>

            <!-- About Section Started from here -->

            <h2 id="accordion-collapse-heading-2">
                <button type="button"
                    class="flex items-center justify-between w-full p-5 font-bold rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-[#1e1e1e] dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:bg-[#1e1e1e] focus:dark:bg-[#181818] dark:hover:bg-[#1e1e1e] gap-3"
                    data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                    aria-controls="accordion-collapse-body-2">
                    <span>អំពី</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                <!-- kh -->
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-[#0E0E0E]">
                    <!-- Section: About 1 -->
                     <div class="flex justify-center items-center">
                        <h1 class="text-xl font-bold text-gray-500 dark:text-gray-300">បញ្ចូលទិន្និយ័ជាភារសារខ្មែរ</h1>
                     </div>
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">សេក្តីផ្ដើម</p>
                    <textarea name="aboutOne" rows="5" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['one'] ?? ''; ?></textarea>

                    <!-- Section: About 2 -->
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">សារសំខាន់</p>
                    <textarea name="aboutTwo" rows="5" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['two'] ?? ''; ?></textarea>

                    <!-- Section: About 3 -->
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">វិធាននិងបទបញ្ជា</p>
                    <textarea name="aboutThree" rows="5" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['three'] ?? ''; ?></textarea>

                    <!-- Section: About 4 -->
                    <textarea name="aboutFour" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['four'] ?? ''; ?></textarea>

                    <!-- Section: About 5 -->
                    <textarea name="aboutFive" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['five'] ?? ''; ?></textarea>

                    <!-- Section: About 6 -->
                    <textarea name="aboutSix" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['six'] ?? ''; ?></textarea>

                    <!-- Section: About 7 -->
                    <textarea name="aboutSeven" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['seven'] ?? ''; ?></textarea>

                    <!-- Section: About 8 -->
                    <textarea name="aboutEight" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['eight'] ?? ''; ?></textarea>

                    <!-- Section: About 9 -->
                    <textarea name="aboutNine" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['nine'] ?? ''; ?></textarea>

                    <!-- Section: About 10 -->
                    <textarea name="aboutTen" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['ten'] ?? ''; ?></textarea>

                    <!-- Section: About 11 -->
                    <textarea name="aboutEleven" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['eleven'] ?? ''; ?></textarea>

                    <!-- Section: About 12 -->
                    <textarea name="aboutTwelve" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['twelve'] ?? ''; ?></textarea>

                    <!-- Section: About 13 -->
                    <textarea name="aboutThirteen" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['thirteen'] ?? ''; ?></textarea>

                    <!-- Section: About 14 -->
                    <textarea name="aboutFourteen" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['fourteen'] ?? ''; ?></textarea>

                    <!-- Section: About 15 -->
                    <textarea name="aboutFifteen" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['fifteen'] ?? ''; ?></textarea>

                    <!-- Section: About 16 -->
                    <textarea name="aboutSixteen" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['sixteen'] ?? ''; ?></textarea>

                    <!-- Section: About 17 -->
                    <textarea name="aboutSeventeen" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['seventeen'] ?? ''; ?></textarea>

                    <!-- Section: About 18 -->
                    <textarea name="aboutEighteen" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['eighteen'] ?? ''; ?></textarea>
                </div>
                <!-- english -->
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-[#0E0E0E]">
                    <!-- Section: About 1 -->
                    <div class="flex justify-center items-center">
                        <h1 class="text-xl font-bold text-gray-500 dark:text-gray-300">Enter data in English</h1>
                     </div>

                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Introdution</p>
                    <textarea name="aboutOne_en" rows="5" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['one_en'] ?? ''; ?></textarea>

                    <!-- Section: About 2 -->
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Messageges</p>
                    <textarea name="aboutTwo_en" rows="5" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['two_en'] ?? ''; ?></textarea>

                    <!-- Section: About 3 -->
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Rules And Regulations</p>
                    <textarea name="aboutThree_en" rows="5" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['three_en'] ?? ''; ?></textarea>

                    <!-- Section: About 4 -->
                    <textarea name="aboutFour_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['four_en'] ?? ''; ?></textarea>

                    <!-- Section: About 5 -->
                    <textarea name="aboutFive_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['five_en'] ?? ''; ?></textarea>

                    <!-- Section: About 6 -->
                    <textarea name="aboutSix_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['six_en'] ?? ''; ?></textarea>

                    <!-- Section: About 7 -->
                    <textarea name="aboutSeven_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['seven_en'] ?? ''; ?></textarea>

                    <!-- Section: About 8 -->
                    <textarea name="aboutEight_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['eight_en'] ?? ''; ?></textarea>

                    <!-- Section: About 9 -->
                    <textarea name="aboutNine_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['nine_en'] ?? ''; ?></textarea>

                    <!-- Section: About 10 -->
                    <textarea name="aboutTen_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['ten_en'] ?? ''; ?></textarea>

                    <!-- Section: About 11 -->
                    <textarea name="aboutEleven_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['eleven_en'] ?? ''; ?></textarea>

                    <!-- Section: About 12 -->
                    <textarea name="aboutTwelve_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-2"><?php echo $data['about']['twelve_en'] ?? ''; ?></textarea>

                    <!-- Section: About 13 -->
                    <textarea name="aboutThirteen_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['thirteen_en'] ?? ''; ?></textarea>

                    <!-- Section: About 14 -->
                    <textarea name="aboutFourteen_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['fourteen_en'] ?? ''; ?></textarea>

                    <!-- Section: About 15 -->
                    <textarea name="aboutFifteen_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['fifteen_en'] ?? ''; ?></textarea>

                    <!-- Section: About 16 -->
                    <textarea name="aboutSixteen_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['sixteen_en'] ?? ''; ?></textarea>

                    <!-- Section: About 17 -->
                    <textarea name="aboutSeventeen_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['seventeen_en'] ?? ''; ?></textarea>

                    <!-- Section: About 18 -->
                    <textarea name="aboutEighteen_en" rows="1" class="w-full text-gray-500 dark:text-gray-700 mb-5"><?php echo $data['about']['eighteen_en'] ?? ''; ?></textarea>
                </div>
            </div>

            <h2 id="accordion-collapse-heading-5">
                <button type="button"
                    class="flex items-center justify-between w-full p-5 font-bold rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-[#1e1e1e] dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:bg-[#1e1e1e] focus:dark:bg-[#181818] dark:hover:bg-[#1e1e1e] gap-3"
                    data-accordion-target="#accordion-collapse-body-5" aria-expanded="false"
                    aria-controls="accordion-collapse-body-5">
                    <span>បន្ថែម</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-5" class="hidden" aria-labelledby="accordion-collapse-heading-5">
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">ការពិពណ៌នាបន្ថែម</p>
                    <textarea name="extraOne" rows="5" type="text"
                        class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['extras']['one']); ?></textarea>
                </div>
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Description extras</p>
                    <textarea name="extraOne_en" rows="5" type="text"
                        class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['extras']['one_en']); ?></textarea>
                </div>
            </div>
            <h2 id="accordion-collapse-heading-6">
                <button type="button"
                    class="flex items-center justify-between w-full p-5 font-bold rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-[#1e1e1e] dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:bg-[#1e1e1e] focus:dark:bg-[#181818] dark:hover:bg-[#1e1e1e] gap-3"
                    data-accordion-target="#accordion-collapse-body-6" aria-expanded="false"
                    aria-controls="accordion-collapse-body-6">
                    <span>ទំនាក់ទំនង</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-6" class="hidden" aria-labelledby="accordion-collapse-heading-6">
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">
                        ការពិពណ៌នាទំនាក់ទំនងសាលារៀន</p>
                    <textarea name="contactOne" rows="5" type="text"
                        class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['contactus']['one']); ?></textarea>

                </div>
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">
                    Description contact</p>
                    <textarea name="contactOne_en" rows="5" type="text"
                        class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['contactus']['one_en']); ?></textarea>

                </div>
            </div>

            <h2 id="accordion-collapse-heading-3">
                <button type="button"
                    class="flex items-center justify-between w-full p-5 font-bold rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-[#1e1e1e] dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:bg-[#1e1e1e] focus:dark:bg-[#181818] dark:hover:bg-[#1e1e1e] gap-3"
                    data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                    aria-controls="accordion-collapse-body-3">
                    <span>ចុះឈ្មោះ</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">ការពិពណ៌នាបន្ថែម</p>
                    <textarea name="joinOne" rows="5" type="text"
                        class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['joinus']['one']); ?></textarea>
                </div>
                <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
                    <p class="mb-2 font-bold text-gray-500 dark:text-gray-400">Description student register</p>
                    <textarea name="joinOne_en" rows="5" type="text"
                        class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo htmlspecialchars($data['joinus']['one_en']); ?></textarea>
                </div>
            </div>

        </div>


        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a class="flex items-center space-x-3 rtl:space-x-reverse">

            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-700 font-bold rounded-lg text-sm px-4 py-2 text-center dark:bg-green-500 dark:hover:bg-green-700 dark:focus:ring-green-800">រក្សាទុក</button>

                </button>
            </div>

        </div>
    </form>



    <?php include('../includes/admin_footer.php') ?>

    <script>
        console.clear();
    </script>

</body>


</html>