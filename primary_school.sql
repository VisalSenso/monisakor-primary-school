-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 10:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primary_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `admission_form`
--

CREATE TABLE `admission_form` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `address` varchar(80) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `father_name` varchar(50) NOT NULL,
  `mother_name` varchar(50) NOT NULL,
  `admit_to` varchar(100) NOT NULL,
  `previous_school` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(30) NOT NULL,
  `intro` varchar(500) NOT NULL,
  `registered_on` varchar(30) NOT NULL,
  `image_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admission_form`
--

INSERT INTO `admission_form` (`id`, `full_name`, `address`, `gender`, `dob`, `father_name`, `mother_name`, `admit_to`, `previous_school`, `email`, `phone`, `intro`, `registered_on`, `image_url`) VALUES
(53, ' lyza lyza', 'pp', 'Female', '2005-06-18', 'jack jack', 'mey mey', '1 ( English Medium )', 'df', 'fdsdfhk@gmail.com', '21322123', 'sdsfffffffff', '18/02/2025 11:11 AM', '../assects/images/Registered_Students/2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactfeedback`
--

CREATE TABLE `contactfeedback` (
  `id` int(11) NOT NULL,
  `date` varchar(10) NOT NULL,
  `time` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactfeedback`
--

INSERT INTO `contactfeedback` (`id`, `date`, `time`, `name`, `phone`, `message`) VALUES
(51, '2025-04-19', '09:25:19', 'ego', '213221233', 'Like a fun.'),
(52, '2025-04-21', '14:39:42', 'Nak', '213221234', 'Good game.');

-- --------------------------------------------------------

--
-- Table structure for table `contactfeedback1`
--

CREATE TABLE `contactfeedback1` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactfeedback1`
--

INSERT INTO `contactfeedback1` (`id`, `date`, `time`, `name`, `phone`, `message`) VALUES
(1, '2025-02-26', '15:17:21', 'John Doe', '123456789', 'This is a test message.'),
(2, '2025-02-26', '15:20:51', 'John Doe', '123456789', 'This is a test message.'),
(3, '2025-02-26', '15:33:15', 'test', '123456789', 'dgdd');

-- --------------------------------------------------------

--
-- Table structure for table `flash_notice`
--

CREATE TABLE `flash_notice` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `message` varchar(500) NOT NULL,
  `trun_flash` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `flash_notice`
--

INSERT INTO `flash_notice` (`id`, `title`, `image_url`, `message`, `trun_flash`) VALUES
(1, 'Admission is open!!!', 'assects/images/flashNotice/9.jpg', 'test teste teste teste', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_album`
--

CREATE TABLE `gallery_album` (
  `id` int(11) NOT NULL,
  `album_name` varchar(30) NOT NULL,
  `album_name_en` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_album`
--

INSERT INTO `gallery_album` (`id`, `album_name`, `album_name_en`) VALUES
(7, 'បុគ្គលិក', 'Staffs'),
(8, 'សួន', 'Gardens'),
(20, 'តេស្ត', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `album` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `album_en` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `album`, `image_url`, `album_en`) VALUES
(12, 'Group', 'assects/images/gallery/IMG-6397e763196d17.43031190.jpg', 'Groups'),
(13, 'Group', 'assects/images/gallery/joinus.png', 'Groups'),
(29, 'Staff', 'assects/images/gallery/2.jpg', NULL),
(31, 'Garden', 'assects/images/gallery/3.jpg', NULL),
(32, 'Staff', 'assects/images/gallery/8.jpg', NULL),
(33, '???', 'assects/images/gallery/img1.jpg', NULL),
(34, 'សួន', 'assects/images/gallery/img1.jpg', 'Gardens'),
(35, 'បុគ្គលិក', 'assects/images/gallery/img2.jpg', 'Staffs'),
(38, 'តេស្ត', 'assects/images/gallery/28.png', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `management_committee`
--

CREATE TABLE `management_committee` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `name_en` varchar(30) NOT NULL,
  `position` varchar(50) NOT NULL,
  `position_en` varchar(50) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `image_src` varchar(200) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `management_committee`
--

INSERT INTO `management_committee` (`id`, `name`, `name_en`, `position`, `position_en`, `contact_no`, `image_src`, `deleted_at`) VALUES
(1, 'Name', '', 'Chairman', '', '980000000', 'assects/images/pta/3.jpg', NULL),
(2, 'Name1', '', 'Member Secretary', '', '984464031', 'assects/images/pta/1.jpg', '2025-04-26 09:23:13'),
(11, 'ណា ណា', 'Na Na', 'សមាជិក', 'Members', '098847444', '/assects/images/pta/img2.jpg', '2025-04-26 09:40:01'),
(14, 'gg', '', 'Member', '', '222222222222', 'assects/images/pta/img4.jpg', '2025-01-28 07:55:43'),
(17, 'គុណ កនិ្នកា', 'Kun kaknika', 'គណៈកម្មាធិការ', 'Committee', '222222222222', '/assects/images/pta/16.jpg', NULL),
(18, 'គា យ៉ា', 'Ka Ya', 'គណៈកម្មាធិការ', 'Committee', '222222222222', '/assects/images/pta/img1.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manipulators`
--

CREATE TABLE `manipulators` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT 'Unknown',
  `identity_code` varchar(255) DEFAULT 'Unknown',
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default-image.jpg',
  `last_update` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manipulators`
--

INSERT INTO `manipulators` (`id`, `name`, `identity_code`, `password`, `image`, `last_update`, `deleted_at`) VALUES
(1, 'admin', '1234', '$2y$10$3vEv6SqeDPQSFdQWyG6fs.g0WUf8.wp.9NHWE2w0vt0GGCu6wAdoa', '../assects/images/admin_and_scribe/3.jpg', '2025-01-22 08:34:57', NULL),
(8, 'teacher', '123456', '$2y$10$uqroKmyOJDD6R42CgNsQbO4QajK4CyPMu0bBace1XXPZ2LgiJgYW6', 'assects/images/admin_and_scribe/img2.jpg', '2025-01-22 11:19:06', NULL),
(109, 'ddd', '1212', '$2y$10$utnRidr4.R08HN1y5fA8oeh0toqQd1vGrsNGTR6VvXADDMoctkvm6', 'assects/images/admin_and_scribe/16.jpg', '2025-04-26 11:21:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `page` varchar(30) NOT NULL,
  `site` varchar(20) NOT NULL,
  `total_notification` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `page`, `site`, `total_notification`) VALUES
(1, 'join_us', 'new_students', 0),
(2, 'contact_us', 'new_feedback', 0);

-- --------------------------------------------------------

--
-- Table structure for table `schoolroutine`
--

CREATE TABLE `schoolroutine` (
  `id` int(11) NOT NULL,
  `class` varchar(1000) DEFAULT NULL,
  `routine_url` varchar(1000) DEFAULT NULL,
  `last_modified` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schoolroutine`
--

INSERT INTO `schoolroutine` (`id`, `class`, `routine_url`, `last_modified`) VALUES
(1, 'Nursery', NULL, NULL),
(2, '1 ( English Medium )', NULL, NULL),
(3, '2 ( English Medium )', NULL, NULL),
(4, '3 ( English Medium )', NULL, NULL),
(5, '4 ( English Medium )', 'assects/images/Routines/Screenshot (7).png', '10:42 AM 29/03/2024'),
(6, '5 ( English Medium )', NULL, NULL),
(7, '6 ( English Medium )', NULL, NULL),
(8, '6 ( Nepali Medium )', NULL, NULL),
(9, '7 ( English Medium )', NULL, NULL),
(10, '7 ( Nepali Medium )', NULL, NULL),
(11, '8 ( English Medium )', NULL, NULL),
(12, '8 ( Nepali Medium )', NULL, NULL),
(13, '9 ( Nepali Medium )', NULL, NULL),
(14, '10 ( Nepali Medium )', NULL, NULL),
(15, '9 ( Computer Engineering )', NULL, NULL),
(16, '10 ( Computer Engineering )', NULL, NULL),
(17, '11 ( Computer Engineering )', NULL, NULL),
(18, '12 ( Computer Engineering )', NULL, NULL),
(19, '+2 ( Commerce )', 'assects/images/Routines/2023_12_23_14_02_IMG_6275.JPG', '11:40 AM 29/03/2024'),
(20, '+2 ( Computer Science )', 'assects/images/gallery/IMG-639805fff17712.83820280.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_notice`
--

CREATE TABLE `school_notice` (
  `id` int(11) NOT NULL,
  `logo` varchar(999) NOT NULL,
  `posted_by` varchar(50) NOT NULL,
  `image_url` varchar(999) NOT NULL,
  `about` varchar(500) NOT NULL,
  `about_en` varchar(500) DEFAULT NULL,
  `notice_description` varchar(9999) NOT NULL,
  `notice_description_en` varchar(3000) DEFAULT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT 0,
  `total_downloads` int(11) NOT NULL DEFAULT 0,
  `last_modified` varchar(50) NOT NULL,
  `likes` int(11) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_notice`
--

INSERT INTO `school_notice` (`id`, `logo`, `posted_by`, `image_url`, `about`, `about_en`, `notice_description`, `notice_description_en`, `date`, `time`, `total_views`, `total_downloads`, `last_modified`, `likes`, `views`, `deleted_at`) VALUES
(132, '../assects/images/admin_and_scribe/3.jpg', 'admin', 'assects/images/notices_files/img1.jpg', 'សាលាបឋមសិក្សាមុនីសាគរ ', 'Monisakor Primary School', '&lt;p&gt;សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។&lt;/p&gt;', '&lt;p&gt;Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.&lt;/p&gt;', '08/04/2025', '12:05 PM', 0, 0, '12:55 PM 27/04/2025', 0, 0, NULL),
(133, '../assects/images/admin_and_scribe/3.jpg', 'admin', '', 'សាលាបឋមសិក្សាមុនីសាគរ ', 'Monisakor Primary School', '&lt;p&gt;សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។&lt;/p&gt;', '&lt;p&gt;Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.&lt;/p&gt;', '08/04/2025', '12:07 PM', 0, 0, '01:51 PM 27/04/2025', 0, 0, NULL),
(134, '../assects/images/admin_and_scribe/3.jpg', 'admin', 'assects/images/notices_files/img2.jpg', 'សាលាបឋមសិក្សាមុនីសាគរ ', 'Monisakor Primary School ', '&lt;p&gt;សាលាបឋមសិក្សាមុនីសាគរពង្រឹងការងារគ្រប់គ្រងដឹកនាំកែទម្រង់លើគ្រប់ផ្នែក ពិសេស ការងារបង្រៀន និងរៀន បរិស្ថានទីធ្លា ក្រៅថ្នាក់ ក្នុងថ្នាក់ សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហិដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋាបាល វិន័យបុគ្គលិក ការទំនាក់ទំនងសហគមន៍ សប្បុរសជន អាជ្ញាធម៌ និងអង្គការដៃគូនានា ។&lt;/p&gt;', '&lt;p&gt;Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.&lt;/p&gt;', '08/04/2025', '12:11 PM', 0, 0, '11:08 AM 26/04/2025', 0, 0, NULL),
(135, '../assects/images/admin_and_scribe/3.jpg', 'admin', 'assects/images/notices_files/img3.jpg', 'ផ្នែកបន្ថែមគឺជាផ្នែកដែលផ្ដល់ព័ត៌មានបន្ថែមផ្សេងៗទៀតពីសាលា ដូចជា៖', 'The Extras section provides additional content related to the school, including:', '&lt;p&gt;&lt;strong&gt;អាល់ប៊ុមវិចិត្រសាល:&lt;/strong&gt; បង្ហាញរូបថតនិងអនុស្សាវរីយ៍នានា។ ទម្លាប់ថ្នាក់: បង្ហាញពីរបៀបរៀបចំថ្នាក់រៀន ការបង្កើតទម្លាប់ល្អៗរបស់សិស្ស។ ប្រតិទិន: បង្ហាញព័ត៌មានអំពីថ្ងៃឈប់សម្រាក ព្រឹត្តិការណ៍ពិសេស និងកាលបរិច្ឆេទសំខាន់ៗ។ បុគ្គលិក: បង្ហាញអំពីគ្រូបង្រៀន និងបុគ្គលិកនានារបស់សាលា។ សញ្ញាសម្គាល់នៃក្រសួងអប់រំ (MOEYS Logo): បង្ហាញនិងភ្ជាប់ទៅកាន់គេហទំព័រដើមរបស់ក្រសួងអប់រំ។&lt;/p&gt;', '&lt;p&gt;&lt;strong&gt;School Album: &lt;/strong&gt;A photo gallery of school events and memories. Classroom Habits: Displays classroom routines and good habits practiced by students. Calendar: Shows school holidays, events, and important dates. Staff: Presents information about the school&amp;rsquo;s teachers and staff. MOEYS Logo: Displays the Ministry of Education, Youth and Sport logo and links to the official site.&lt;/p&gt;', '22/04/2025', '02:36 PM', 0, 0, '11:07 AM 26/04/2025', 0, 0, NULL),
(148, 'assects/images/admin_and_scribe/img2.jpg', 'teacher', 'assects/images/notices_files/img2.jpg', 'សាលាបឋមសិក្សាមុនីសាគរ ', 'Monisakor Primary School ', '&lt;p&gt;សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ &lt;strong&gt;ចំណេះដឹង &lt;/strong&gt;និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ពង្រឹងការគ្រប់គ្រង និងការកែទម្រង់ភាពជាអ្នកដឹកនាំលើគ្រប់វិស័យ ជាពិសេសការបង្រៀន និងការរៀន បរិស្ថានខាងក្រៅ និងខាងក្នុង សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហេដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋបាល វិន័យបុគ្គលិក និងការប្រាស្រ័យទាក់ទងជាមួយសហគមន៍ សប្បុរសជន អាជ្ញាធរ និងអង្គការដៃគូ។&lt;/p&gt;', '&lt;p&gt;Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality,&lt;strong&gt; knowledge&lt;/strong&gt;, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.&lt;/p&gt;', '24/04/2025', '11:45 AM', 0, 0, 'មិនបានកែប្រែ', 0, 0, NULL),
(149, '../assects/images/admin_and_scribe/3.jpg', 'admin', 'assects/images/notices_files/img4.jpg', 'សាលាបឋមសិក្សាមុនីសាគរបានទទួលការបណ្តុះបណ្តាលស្តីពី ស្តង់ដារសាលារៀនគម្រោង(ជីប)ពីក្រុមការងាររបស់មន្ទីរអប់រំ យុវជននិងកីឡាខេត្តស្វាយរៀន។', 'Monisakor Primary School Training Course with (Chip) from the team of Department of Education, Youth and Sports of Svay Province.', '&lt;div dir=&quot;auto&quot;&gt;ថ្ងៃទី២៥.០៤.២០២៥.សាលាបឋមសិក្សាមុនីសាគរបានទទួលការបណ្តុះបណ្តាលស្តីពី ស្តង់ដារសាលារៀនគម្រោង(ជីប)ពីក្រុមការងាររបស់មន្ទីរអប់រំ យុវជននិងកីឡាខេត្តស្វាយរៀន។&lt;/div&gt;\r\n&lt;div dir=&quot;auto&quot;&gt;សមាសភាពចូលរួម មាន&lt;/div&gt;\r\n&lt;div dir=&quot;auto&quot;&gt;១.លោកគ្រូ អ្នកគ្រូគ្រប់ថ្នាក់&lt;/div&gt;\r\n&lt;div dir=&quot;auto&quot;&gt;២.គណកម្មការគ្រប់គ្រងសាលារៀនគ.គ.ស.&lt;/div&gt;\r\n&lt;div dir=&quot;auto&quot;&gt;៣.គណកម្មកាគ្រប់គ្រងថ្នាក់រៀនគ្រប់ថ្នាក់&lt;/div&gt;', '&lt;div dir=&quot;auto&quot;&gt;On April 25, 2025, Monisakor Primary School received training on Project School Standards (GPS) from the working group of the Department of Education, Youth and Sports of Svay Rien Province.&lt;br&gt;The participating members are:&lt;br&gt;1. Teachers of all grades&lt;br&gt;2. School Management Committee of the K.K.S.&lt;br&gt;3. Classroom Management Committee of all grades.&lt;/div&gt;', '26/04/2025', '10:04 AM', 0, 0, '11:13 AM 26/04/2025', 0, 0, NULL),
(154, '../assects/images/admin_and_scribe/3.jpg', 'admin', 'assects/images/notices_files/img3.jpg', 'ចក្ខុវិស័យ', 'Vision', '&lt;p&gt;សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។&lt;/p&gt;', '&lt;p&gt;Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.&lt;/p&gt;', '27/04/2025', '12:00 PM', 0, 0, 'មិនបានកែប្រែ', 0, 0, NULL),
(155, '../assects/images/admin_and_scribe/3.jpg', 'admin', 'assects/images/notices_files/img1.jpg', 'បេសកកម្ម', 'Mission', '&lt;p&gt;សាលាបឋមសិក្សាមុនីសាគរ ពង្រឹងការគ្រប់គ្រង និងការកែទម្រង់ភាពជាអ្នកដឹកនាំលើគ្រប់វិស័យ ជាពិសេសការបង្រៀន និងការរៀន បរិស្ថានខាងក្រៅ និងខាងក្នុង សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហេដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋបាល វិន័យបុគ្គលិក និងការប្រាស្រ័យទាក់ទងជាមួយសហគមន៍ សប្បុរសជន អាជ្ញាធរ និងអង្គការដៃគូ។សាលាបឋមសិក្សាមុនីសាគរ ពង្រឹងការគ្រប់គ្រង និងការកែទម្រង់ភាពជាអ្នកដឹកនាំលើគ្រប់វិស័យ ជាពិសេសការបង្រៀន និងការរៀន បរិស្ថានខាងក្រៅ និងខាងក្នុង សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហេដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋបាល វិន័យបុគ្គលិក និងការប្រាស្រ័យទាក់ទងជាមួយសហគមន៍ សប្បុរសជន អាជ្ញាធរ និងអង្គការដៃគូ។សាលាបឋមសិក្សាមុនីសាគរ ពង្រឹងការគ្រប់គ្រង និងការកែទម្រង់ភាពជាអ្នកដឹកនាំលើគ្រប់វិស័យ ជាពិសេសការបង្រៀន និងការរៀន បរិស្ថានខាងក្រៅ និងខាងក្នុង សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហេដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋបាល វិន័យបុគ្គលិក និងការប្រាស្រ័យទាក់ទងជាមួយសហគមន៍ សប្បុរសជន អាជ្ញាធរ និងអង្គការដៃគូ។សាលាបឋមសិក្សាមុនីសាគរ ពង្រឹងការគ្រប់គ្រង និងការកែទម្រង់ភាពជាអ្នកដឹកនាំលើគ្រប់វិស័យ ជាពិសេសការបង្រៀន និងការរៀន បរិស្ថានខាងក្រៅ និងខាងក្នុង សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហេដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋបាល វិន័យបុគ្គលិក និងការប្រាស្រ័យទាក់ទងជាមួយសហគមន៍ សប្បុរសជន អាជ្ញាធរ និងអង្គការដៃគូ។សាលាបឋមសិក្សាមុនីសាគរ ពង្រឹងការគ្រប់គ្រង និងការកែទម្រង់ភាពជាអ្នកដឹកនាំលើគ្រប់វិស័យ ជាពិសេសការបង្រៀន និងការរៀន បរិស្ថានខាងក្រៅ និងខាងក្នុង សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហេដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋបាល វិន័យបុគ្គលិក និងការប្រាស្រ័យទាក់ទងជាមួយសហគមន៍ សប្បុរសជន អាជ្ញាធរ និងអង្គការដៃគូ។&lt;/p&gt;', '&lt;p&gt;Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations.&lt;/p&gt;', '27/04/2025', '12:29 PM', 0, 0, '12:32 PM 27/04/2025', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `post` varchar(100) NOT NULL,
  `post_en` varchar(100) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `qualification_en` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `image_src` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `name`, `name_en`, `post`, `post_en`, `qualification`, `qualification_en`, `contact`, `image_src`, `deleted_at`) VALUES
(36, 'Name3', '', 'Accountant', '', '+2', '', '9842074346', 'assects/images/staff/28.png', NULL),
(38, 'Name5', '', 'Teacher', '', 'KH', '', '098877474', 'assects/images/staff/16.jpg', NULL),
(39, 'Name1', '', 'Teacher', '', '234', '', '222222222222', 'assects/images/staff/img6.jpg', '2025-04-24 07:17:33'),
(41, 'coffee', '', 'Teacher', '', 'KH', '', '222222222222', 'assects/images/staff/img6.jpg', '2025-04-24 07:17:33'),
(42, 'coffee', '', 'Teacher', '', 'KH', '', '222222222222', 'assects/images/staff/img6.jpg', NULL),
(47, 'មាស​ មាស', '', 'Accountant', '', 'KH', '', '222222222222', '../assects/images/staff/img1.jpg', NULL),
(51, 'គុណ កន្និកា', 'Kun Kanika', 'គ្រូបង្រៀន', 'Teacher', 'បរិញ្ញាបត្រ', 'Bachelor Degree ', '222222222222', '../assects/images/staff/16.jpg', NULL),
(52, 'ស សារ៉ា', 'Sor Sara', 'គ្រូបង្រៀន', 'Teacher', 'អនុបណ្ឌិត', 'Master', '222222222222', '../assects/images/staff/28.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students_register`
--

CREATE TABLE `students_register` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` enum('ប្រុស','ស្រី','ផ្សេងៗ') NOT NULL,
  `dob` date NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `father_job` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `mother_job` varchar(255) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `current_place` varchar(255) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_register`
--

INSERT INTO `students_register` (`id`, `full_name`, `gender`, `dob`, `father_name`, `father_job`, `mother_name`, `mother_job`, `place_of_birth`, `current_place`, `phone`, `image_url`, `created_at`) VALUES
(19, 'អា ចក់', 'ប្រុស', '2025-04-16', 'គា កា', 'កាកី', 'កា កា', 'កខ', 'កំពុងរោទ៏', 'កំពុងរោទ៏', '21322123', '/project/monisakor-primary-school/assects/images/joinus/1.jpg', '2025-04-17 04:54:59'),
(20, 'អា រ៉ា', 'ប្រុស', '2025-04-19', 'គា កា', 'កាកី', 'កា កា', 'កខ', 'កំពុងរោទ៏', 'កំពុងរោទ៏', '21322123', '/project/monisakor-primary-school/assects/images/joinus/car3.jpg', '2025-04-19 02:45:13'),
(54, 'អា កា', 'ប្រុស', '2025-04-30', 'គា កា', 'កាកី', 'កា កា', 'កខ', 'ភូមិ ពោធិ៍ថ្មី, ឃុំ ស្វាយតាយាន,​ ស្រុក កំពុងរោទ៍,​ ខេត្ត ស្វាយរៀង', 'ភូមិ ពោធិ៍ថ្មី, ឃុំ ស្វាយតាយាន,​ ស្រុក កំពុងរោទ៍, ខេត្ត ស្វាយរៀង', '09828289', '/project/monisakor-primary-school/assets/images/joinus/33.jpg', '2025-04-30 06:47:43'),
(56, 'ចាន់ សោភា', 'ស្រី', '2025-04-16', 'គា កា', 'កសិក', 'កា កា', 'កសិក', 'ភូមិ ពោធិ៍ថ្មី, ឃុំ ស្វាយតាយាន,​ ស្រុក កំពុងរោទ៍,​ ខេត្ត ស្វាយរៀង', 'ភូមិ ពោធិ៍ថ្មី, ឃុំ ស្វាយតាយាន,​ ស្រុក កំពុងរោទ៍, ខេត្ត ស្វាយរៀង', '09828289', '/project/monisakor-primary-school/assets/images/joinus/28.png', '2025-04-30 07:00:40'),
(58, 'គុណ​ កនិ្នកា', 'ស្រី', '2025-04-30', 'គា កា', 'កសិក', 'អ៊ឹង ស្រីនាង', 'កសិក', 'ភូមិ ពោធិ៍ថ្មី, ឃុំ ស្វាយតាយាន,​ ស្រុក កំពុងរោទ៍,​ ខេត្ត ស្វាយរៀង', 'ភូមិ ពោធិ៍ថ្មី, ឃុំ ស្វាយតាយាន,​ ស្រុក កំពុងរោទ៍, ខេត្ត ស្វាយរៀង', '09828289', '/project/monisakor-primary-school/assets/images/joinus/16.jpg', '2025-04-30 07:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `web_content`
--

CREATE TABLE `web_content` (
  `id` int(11) NOT NULL,
  `content_about` varchar(500) NOT NULL,
  `one` varchar(1000) NOT NULL,
  `two` varchar(1000) NOT NULL,
  `three` varchar(1000) NOT NULL,
  `four` varchar(1000) NOT NULL,
  `five` varchar(1000) NOT NULL,
  `six` varchar(1000) NOT NULL,
  `seven` varchar(1000) NOT NULL,
  `eight` varchar(1000) NOT NULL,
  `nine` varchar(500) NOT NULL,
  `ten` varchar(500) NOT NULL,
  `eleven` varchar(500) NOT NULL,
  `twelve` varchar(500) NOT NULL,
  `thirteen` varchar(500) NOT NULL,
  `fourteen` varchar(500) NOT NULL,
  `fifteen` varchar(1000) NOT NULL,
  `sixteen` varchar(1000) NOT NULL,
  `seventeen` varchar(500) NOT NULL,
  `eighteen` varchar(500) NOT NULL,
  `ninteen` varchar(500) NOT NULL,
  `twenty` varchar(500) NOT NULL,
  `twentyone` varchar(500) NOT NULL,
  `content_about_en` text DEFAULT NULL,
  `one_en` text DEFAULT NULL,
  `two_en` text DEFAULT NULL,
  `three_en` text DEFAULT NULL,
  `four_en` text DEFAULT NULL,
  `five_en` text DEFAULT NULL,
  `six_en` text DEFAULT NULL,
  `seven_en` text DEFAULT NULL,
  `eight_en` text DEFAULT NULL,
  `nine_en` text DEFAULT NULL,
  `ten_en` text DEFAULT NULL,
  `eleven_en` text DEFAULT NULL,
  `twelve_en` text DEFAULT NULL,
  `thirteen_en` text DEFAULT NULL,
  `fourteen_en` text DEFAULT NULL,
  `fifteen_en` text DEFAULT NULL,
  `sixteen_en` text DEFAULT NULL,
  `seventeen_en` text DEFAULT NULL,
  `eighteen_en` text DEFAULT NULL,
  `ninteen_en` text DEFAULT NULL,
  `twenty_en` text DEFAULT NULL,
  `twentyone_en` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_content`
--

INSERT INTO `web_content` (`id`, `content_about`, `one`, `two`, `three`, `four`, `five`, `six`, `seven`, `eight`, `nine`, `ten`, `eleven`, `twelve`, `thirteen`, `fourteen`, `fifteen`, `sixteen`, `seventeen`, `eighteen`, `ninteen`, `twenty`, `twentyone`, `content_about_en`, `one_en`, `two_en`, `three_en`, `four_en`, `five_en`, `six_en`, `seven_en`, `eight_en`, `nine_en`, `ten_en`, `eleven_en`, `twelve_en`, `thirteen_en`, `fourteen_en`, `fifteen_en`, `sixteen_en`, `seventeen_en`, `eighteen_en`, `ninteen_en`, `twenty_en`, `twentyone_en`) VALUES
(0, '', 'សេក្តីផ្ដើម', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'index', 'សាលាបឋមសិក្សាមុនីសាគរ ធានា និងអភិវឌ្ឍធនធានមនុស្សក្នុងសហគមន៍ប្រកបដោយគុណភាព ប្រសិទ្ធភាព គុណធម៌ សីលធម៌ ចំណេះដឹង និងចំណេះដឹងប្រកបដោយសមធម៌ និងអាកប្បកិរិយា ដើម្បីអភិវឌ្ឍគ្រួសារ និងសង្គមជាតិឱ្យរីកចម្រើន។ ', 'សាលាបឋមសិក្សាមុនីសាគរ ពង្រឹងការគ្រប់គ្រង និងការកែទម្រង់ភាពជាអ្នកដឹកនាំលើគ្រប់វិស័យ ជាពិសេសការបង្រៀន និងការរៀន បរិស្ថានខាងក្រៅ និងខាងក្នុង សុវត្ថិភាព សុខភាព អនាម័យ ទឹកស្អាត ហេដ្ឋារចនាសម្ព័ន្ធ ការងាររដ្ឋបាល វិន័យបុគ្គលិក និងការប្រាស្រ័យទាក់ទងជាមួយសហគមន៍ សប្បុរសជន អាជ្ញាធរ និងអង្គការដៃគូ។', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'ទំពទ័ដើម', 'Monisakor Primary School ensures and develops human resources in the community with quality, efficiency, virtue, morality, knowledge, and know-how, with equity and behavior, to develop families and the national society for progress.  ', 'Monisakor Primary School strengthens management and leadership reform in all areas, especially teaching and learning, outdoor and indoor environments, safety, health, hygiene, clean water, infrastructure, administrative work, staff discipline, and communication with the community, philanthropists, authorities, and partner organizations. ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'about', 'សេក្តីផ្ដើម', '', 'នៅសាលារបស់យើង យើងជឿថាបរិយាកាសវិជ្ជមាន ការគោរព និងសុវត្ថិភាពគឺចាំបាច់សម្រាប់ការរៀនសូត្រ។ ដើម្បីគាំទ្រដល់ចំណុចនេះ សិស្ស គ្រូបង្រៀន និងបុគ្គលិកទាំង៖', '1. គ្រូបង្រៀនត្រូវគោរពម៉ោងធ្វើការ។', '2. គ្រូត្រូវស្លៀកសម្លៀកបំពាក់សមរម្យ (គ្មានខោខូវប៊យ ឬដៃអាវរមូរ)។', '3. គ្រូបង្រៀនត្រូវចុះហត្ថលេខាលើបញ្ជីវត្តមានប្រចាំថ្ងៃ។', '4. នៅពេលមានបញ្ហា អ្នកត្រូវតែជូនដំណឹង ឬសុំយោបល់ផ្នែកច្បាប់។', '5. ការបង្ហាត់បង្រៀនត្រូវមានកិច្ចការងារ បង្រៀន និងបង្រៀនសាលា', '6. ការបង្ហាត់បង្រៀនត្រូវមានកិច្ចការងារ បង្រៀន និងបង្រៀនសាលា', '7. ត្រូវអនុវត្តវិន័យជាវិជ្ជមានជាមួយសិស្សក្នុងពេលបង្រៀន', '8. គ្រូបង្រៀនត្រូវឱ្យសិស្សបំពេញកិច្ចការផ្សេងៗ ដោយផ្អែកលើសិទ្ធិកុមារ 4 យ៉ាង', '9. ត្រូវគោរពបទបញ្ជារបស់រដ្ឋបាលសាលា', '10. ចូលរួមថែរក្សា និងការពារទ្រព្យសម្បត្តិរដ្ឋក្នុងអង្គភាព (បិទទ្វារ បង្អួច ភ្លើង...)', '11. ចូលរួមការពារសុវត្ថិភាពការងារ (ទទួលខុសត្រូវលើខ្លួនឯង)', '12. ពេលវេលាបង្រៀនរបស់រដ្ឋ លេងទូរស័ព្ទ ឬធ្វើការងារផ្ទាល់ខ្លួន', '13.មិនប្រើពេលវេលាបង្រៀនរបស់រដ្ឋ ដើម្បីលេងទូរស័ព្ទ ឬធ្វើការងារផ្ទាល់ខ្លួន', '14.មិនប្រើប្រាស់សម្ភារៈសិក្សាដើម្បីប្រយោជន៍ផ្ទាល់ខ្លួន', '15.មិនលេងល្បែងស៊ីសងគ្រប់ប្រភេទ ផឹកស៊ី ឬជប់លៀងនៅសាលា។', '', '', '', NULL, 'MY school history...', '', 'At our school, we believe that a positive, respectful, and safe environment is essential for learning. To support this, all students, teachers, and staff must follow these rules and regulations', '1. Teachers must respect working hours.', '2. Teachers must wear appropriate clothing (no jeans or rolled-up sleeves).', '3. Teachers must sign the attendance list daily.', '4. When there is a problem, you must notify or ask for legal advice.', '5.Teaching must include teaching materials and teaching aids.', '6. Never use violence against students during teaching.', '7. Always apply positive discipline with students during teaching', '8. Teachers must have students perform various tasks based on the four rights of children', '9. Must obey the school administration\'s orders', '10. Participate in the care and protection of state property in the organization (close doors, windows, lights...)', '11. Participate in the protection of work safety (take responsibility for yourself)', '12. Be polite and courteous, but be strict', '13. Do not use state teaching time to play on the phone or do personal work', '14. Do not use school supplies for personal gain', '15. Do not play all kinds of gambling, drink, or party on school grounds', '', '', ''),
(3, 'notice', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'contactus', 'យើងអាចរកបាន 24 ម៉ោងក្នុងមួយថ្ងៃ។ ប្រសិនបើអ្នកមានសំណួរ ឬត្រូវការជំនួយ សូមកុំស្ទាក់ស្ទើរក្នុងការទាក់ទងក្រុមរបស់យើង។ យើងរីករាយក្នុងការជួយ និងផ្តល់ព័ត៌មានដល់អ្នក។ 📞 លោកអ្នកអាចទំនាក់ទំនងតាមរយៈលេខទូរស័ព្ទ ឬទម្រង់ទំនាក់ទំនងនៅលើគេហទំព័រ។ 📬 យើងសន្យាថានឹងឆ្លើយតបយ៉ាងរហ័ស និងមានប្រសិទ្ធភាព។', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 'We are available 24 hours a day. If you have any questions or need assistance, please do not hesitate to contact our team. We are happy to assist and provide you with information. 📞 You can contact us via phone number or contact form on the website. 📬 We promise to respond quickly and efficiently.fuck', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'join', 'សុំចុះឈ្មោះកូនចូលរៀនថ្នាក់ទី១សម្រាប់ឆ្នាំសិក្សា២០២៤-២០២៥', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 'Please register your child for first grade for the 2024-2025 school year.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'extras', 'ផ្នែកបន្ថែមផ្តល់នូវព័ត៌មានបន្ថែមអំពីសាលា ដែលមានអាល់ប៊ុមរូបថតនៃព្រឹត្តិការណ៍ដែលគួរឱ្យចងចាំ ទិដ្ឋភាពទូទៅនៃទម្លាប់ក្នុងថ្នាក់ និងទម្លាប់របស់សិស្ស ប្រតិទិនដែលរំលេចថ្ងៃឈប់សម្រាក និងព្រឹត្តិការណ៍សំខាន់ៗ ព័ត៌មានលម្អិតអំពីបុគ្គលិកសាលា និងស្លាកសញ្ញាក្រសួងអប់រំ យុវជន និងកីឡា ជាមួយនឹងតំណភ្ជាប់ទៅកាន់គេហទំព័រផ្លូវការ។\r\n', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 'The Extras section offers supplementary information about the school, featuring a photo album of memorable events, an overview of classroom routines and student habits, a calendar highlighting holidays and key events, details about school staff, and the Ministry of Education, Youth and Sport logo with a link to the official website.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission_form`
--
ALTER TABLE `admission_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `contactfeedback`
--
ALTER TABLE `contactfeedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactfeedback1`
--
ALTER TABLE `contactfeedback1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_notice`
--
ALTER TABLE `flash_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_album`
--
ALTER TABLE `gallery_album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `management_committee`
--
ALTER TABLE `management_committee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manipulators`
--
ALTER TABLE `manipulators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schoolroutine`
--
ALTER TABLE `schoolroutine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_notice`
--
ALTER TABLE `school_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_register`
--
ALTER TABLE `students_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_content`
--
ALTER TABLE `web_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admission_form`
--
ALTER TABLE `admission_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contactfeedback`
--
ALTER TABLE `contactfeedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `contactfeedback1`
--
ALTER TABLE `contactfeedback1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `flash_notice`
--
ALTER TABLE `flash_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery_album`
--
ALTER TABLE `gallery_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `management_committee`
--
ALTER TABLE `management_committee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `manipulators`
--
ALTER TABLE `manipulators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schoolroutine`
--
ALTER TABLE `schoolroutine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `school_notice`
--
ALTER TABLE `school_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `students_register`
--
ALTER TABLE `students_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `school_notice` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
