-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 21, 2026 at 10:04 AM
-- Server version: 12.3.2-MariaDB
-- PHP Version: 8.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `npa_results`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_logs`
--

CREATE TABLE `admin_activity_logs` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(200) DEFAULT NULL,
  `action_type` varchar(100) DEFAULT NULL,
  `action_reason` text DEFAULT NULL,
  `records_affected` int(11) DEFAULT 0,
  `session` varchar(50) DEFAULT NULL,
  `term` varchar(50) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `backup_file` varchar(1024) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Table structure for table `class_set`
--

CREATE TABLE `class_set` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `session` varchar(100) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `students` text DEFAULT NULL,
  `subjects` text DEFAULT NULL,
  `date_created` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


--
-- Table structure for table `mailing_list`
--

CREATE TABLE `mailing_list` (
  `id` int(11) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `mailing` varchar(100) DEFAULT NULL,
  `reasons` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


--
-- Table structure for table `mail_queue`
--

CREATE TABLE `mail_queue` (
  `id` int(11) NOT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `recipient_email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment` varchar(300) DEFAULT NULL,
  `status` enum('pending','sent','failed') DEFAULT 'pending',
  `created_at` varchar(100) DEFAULT NULL,
  `sent_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_email` varchar(120) DEFAULT NULL,
  `user_cat` varchar(50) DEFAULT NULL,
  `token_hash` varchar(300) DEFAULT NULL,
  `expiration` varchar(100) DEFAULT NULL,
  `timestamp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `staff_cat` varchar(100) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `surname` varchar(200) DEFAULT NULL,
  `othernames` varchar(300) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `status_reason` text NOT NULL DEFAULT 'Waiting for verification',
  `profile` varchar(300) DEFAULT NULL,
  `signature` varchar(200) DEFAULT NULL,
  `login_psw` varchar(1024) DEFAULT NULL,
  `token_key` varchar(1024) DEFAULT NULL,
  `token_value` varchar(1024) DEFAULT NULL,
  `timestamp` varchar(200) DEFAULT NULL,
  `lastlogin` varchar(200) DEFAULT NULL,
  `class_handling` varchar(100) DEFAULT NULL,
  `subjects_handling` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `std_id` int(11) DEFAULT NULL,
  `std_cat` varchar(100) DEFAULT NULL,
  `surname` varchar(200) DEFAULT NULL,
  `othernames` varchar(300) DEFAULT NULL,
  `current_class` varchar(100) DEFAULT NULL,
  `year_admitted` varchar(100) DEFAULT NULL,
  `profile` varchar(200) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `std_state` varchar(100) DEFAULT NULL,
  `std_lga` varchar(200) DEFAULT NULL,
  `birth_date` varchar(200) DEFAULT NULL,
  `resident` text DEFAULT NULL,
  `parent_name` varchar(500) DEFAULT NULL,
  `parent_email` varchar(200) DEFAULT NULL,
  `parent_number` varchar(100) DEFAULT NULL,
  `std_pin` varchar(50) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Pending',
  `status_reason` text NOT NULL DEFAULT '\'Awaiting verifications\'',
  `timestamp` varchar(200) DEFAULT NULL,
  `lastlogin` varchar(200) DEFAULT NULL,
  `added_subjects` varchar(1024) DEFAULT NULL,
  `removed_subjects` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Table structure for table `variables`
--

CREATE TABLE `variables` (
  `id` int(11) NOT NULL,
  `type` varchar(200) DEFAULT NULL,
  `value` varchar(1024) DEFAULT NULL,
  `classification` varchar(1024) DEFAULT NULL,
  `assessment_pattern` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `variables`
--

INSERT INTO `variables` (`id`, `type`, `value`, `classification`, `assessment_pattern`) VALUES
(2, 'Subject', 'Mathematics', 'General', NULL),
(21, 'Current Session', '2024/2025', 'General', NULL),
(22, 'Current Term', 'First Term', 'General', NULL),
(26, 'Class', 'SS 3A', 'Science', '10:10:10'),
(28, 'Subject', 'Chemistry', 'Science', '3:30'),
(29, 'Subject', 'Economics', 'General', '3:30'),
(36, 'Subject', 'English Language', 'General', NULL),
(39, 'Class', 'SS 2A', 'Science', '10:10:10'),
(42, 'Class', 'PRE-NURSERY 2A', 'Science', '3:30'),
(43, 'Class', 'SS 1B', 'Art', '3:30'),
(45, 'Class', 'JSS 1A', 'General', '3:30'),
(46, 'Class', 'JSS 2A', 'General', '10:10:10:10'),
(47, 'Class', 'SS 3B', 'Art', '3:30'),
(50, 'Class', 'JSS 2', 'Science', '3:30'),
(51, 'Class', 'PRE-SCHOOL 1', 'Science', '3:30'),
(52, 'Class', 'PRE-SCHOOL 2', 'Science', '3:30'),
(53, 'Class', 'PRE-SCHOOL 2A', 'Science', '3:30'),
(54, 'Class', 'PRE-SCHOOL 2B', 'Science', '3:30'),
(55, 'Class', 'JSS 3A', 'General', '10:10:10:10'),
(58, 'Next Term Begins', '07/09/2026', 'General', NULL),
(59, 'Subject', 'Agricultural Science', 'Science', NULL),
(60, 'Subject', 'Biology', 'Science', NULL),
(61, 'Subject', 'Business Studies', 'General', NULL),
(62, 'Subject', 'Geography', 'Science', NULL),
(63, 'Subject', 'Digital Technologies', 'General', NULL),
(64, 'Subject', 'Marketing', 'Art', NULL),
(66, 'Subject', 'Citizenship &amp; Cultural Heritage', 'General', NULL),
(67, 'Result Luck', 'On', 'General', NULL),
(68, 'Site Luck', 'Off', 'General', NULL),
(69, 'Allow Result Deletion', 'Off', 'General', NULL),
(70, 'site_lock', 'Off', 'General', NULL),
(71, 'result_lock', 'On', 'General', NULL),
(72, 'result_deletion', 'Off', 'General', NULL),
(73, 'red_ink', 'On', 'General', NULL),
(74, 'minimum_score', '20', 'General', NULL),
(75, 'Class', 'SS 1A', 'Science', '10:10:10'),
(76, 'Subject', 'Further Mathematics', 'Science', NULL),
(77, 'Subject', 'Accounting', 'Art', NULL),
(78, 'Subject', 'Literature In English', 'Art', NULL),
(79, 'Subject', 'Civic Education', 'General', NULL),
(80, 'show_position_inclass', 'On', 'General', NULL),
(81, 'Subject', 'C.R.S', 'General', NULL),
(82, 'Subject', 'Physical Health Education', 'General', NULL),
(83, 'Subject', 'Government', 'Art', NULL),
(84, 'Subject', 'Commerce', 'Art', NULL),
(85, 'Subject', 'Crop Production & Horticulture', 'General', NULL),
(86, 'Subject', 'Financial Accounting', 'Commercial', NULL),
(87, 'Subject', 'P.H.E', 'General', NULL),
(88, 'Subject', 'Physics', 'Science', NULL),
(89, 'Subject', 'Right Speech', 'General', NULL),
(90, 'Subject', 'C.C.A', 'General', NULL),
(91, 'Subject', 'P.V.S', 'General', NULL),
(92, 'Subject', 'Home Economics', 'General', NULL),
(93, 'Subject', 'National Value', 'General', NULL),
(94, 'Subject', 'Garment & Sewing', 'General', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`,`session`,`term`);

--
-- Indexes for table `class_set`
--
ALTER TABLE `class_set`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `session` (`session`),
  ADD KEY `term` (`term`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `mailing_list`
--
ALTER TABLE `mailing_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_queue`
--
ALTER TABLE `mail_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`user_email`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`,`staff_cat`,`surname`,`email`,`number`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variables`
--
ALTER TABLE `variables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class_set`
--
ALTER TABLE `class_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mailing_list`
--
ALTER TABLE `mailing_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `mail_queue`
--
ALTER TABLE `mail_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `variables`
--
ALTER TABLE `variables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
