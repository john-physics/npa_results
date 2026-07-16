-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 16, 2026 at 03:19 PM
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
  `action_type` varchar(200) DEFAULT NULL,
  `action_reason` text DEFAULT NULL,
  `records_affected` int(11) DEFAULT 0,
  `session` varchar(50) DEFAULT NULL,
  `term` varchar(50) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `backup_file` varchar(1024) DEFAULT NULL,
  `timestamp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `grading_system`
--

CREATE TABLE `grading_system` (
  `id` int(11) NOT NULL,
  `score_range` varchar(100) DEFAULT NULL,
  `grade_suffix` varchar(100) DEFAULT NULL,
  `grade_nonsuffix` varchar(100) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `lower_limit` int(11) DEFAULT NULL,
  `upper_limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mailing_list`
--

CREATE TABLE `mailing_list` (
  `id` int(11) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `mailing` varchar(100) DEFAULT NULL,
  `reasons` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `results_2024_2025`
--

CREATE TABLE `results_2024_2025` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `std_id` int(11) DEFAULT NULL,
  `std_cat` varchar(100) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `total_score` int(11) DEFAULT NULL,
  `total_scorable` int(11) DEFAULT NULL,
  `subject_num` varchar(100) DEFAULT NULL,
  `overall_average` decimal(10,2) DEFAULT 0.00,
  `overall_grade` varchar(100) DEFAULT NULL,
  `general_remark` varchar(100) DEFAULT NULL,
  `position_inclass` varchar(100) DEFAULT NULL,
  `teacher_comment` text DEFAULT NULL,
  `principal_comment` text DEFAULT NULL,
  `activeness` int(11) DEFAULT NULL,
  `attendance` int(11) DEFAULT NULL,
  `punctuality` int(11) DEFAULT NULL,
  `self_control` int(11) DEFAULT NULL,
  `honesty` int(11) DEFAULT NULL,
  `humility` int(11) DEFAULT NULL,
  `leadership` int(11) DEFAULT NULL,
  `hand_writing` int(11) DEFAULT NULL,
  `fluency` int(11) DEFAULT NULL,
  `musical_skills` int(11) DEFAULT NULL,
  `sports` int(11) DEFAULT NULL,
  `result_status` varchar(100) DEFAULT NULL,
  `date_created` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results_2025_2026`
--

CREATE TABLE `results_2025_2026` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `std_id` int(11) DEFAULT NULL,
  `std_cat` varchar(100) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `total_score` int(11) DEFAULT NULL,
  `total_scorable` int(11) DEFAULT NULL,
  `subject_num` varchar(100) DEFAULT NULL,
  `overall_average` decimal(10,2) DEFAULT 0.00,
  `overall_grade` varchar(100) DEFAULT NULL,
  `general_remark` varchar(100) DEFAULT NULL,
  `position_inclass` varchar(100) DEFAULT NULL,
  `teacher_comment` text DEFAULT NULL,
  `principal_comment` text DEFAULT NULL,
  `activeness` int(11) DEFAULT NULL,
  `attendance` int(11) DEFAULT NULL,
  `punctuality` int(11) DEFAULT NULL,
  `self_control` int(11) DEFAULT NULL,
  `honesty` int(11) DEFAULT NULL,
  `humility` int(11) DEFAULT NULL,
  `leadership` int(11) DEFAULT NULL,
  `hand_writing` int(11) DEFAULT NULL,
  `fluency` int(11) DEFAULT NULL,
  `musical_skills` int(11) DEFAULT NULL,
  `sports` int(11) DEFAULT NULL,
  `result_status` varchar(100) DEFAULT NULL,
  `date_created` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results_2026_2027`
--

CREATE TABLE `results_2026_2027` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `std_id` int(11) DEFAULT NULL,
  `std_cat` varchar(100) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `total_score` int(11) DEFAULT NULL,
  `total_scorable` int(11) DEFAULT NULL,
  `subject_num` varchar(100) DEFAULT NULL,
  `overall_average` decimal(10,2) DEFAULT 0.00,
  `overall_grade` varchar(100) DEFAULT NULL,
  `position_inclass` varchar(100) DEFAULT NULL,
  `teacher_comment` text DEFAULT NULL,
  `principal_comment` text DEFAULT NULL,
  `activeness` int(11) DEFAULT NULL,
  `attendance` int(11) DEFAULT NULL,
  `punctuality` int(11) DEFAULT NULL,
  `self_control` int(11) DEFAULT NULL,
  `honesty` int(11) DEFAULT NULL,
  `humility` int(11) DEFAULT NULL,
  `leadership` int(11) DEFAULT NULL,
  `hand_writing` int(11) DEFAULT NULL,
  `fluency` int(11) DEFAULT NULL,
  `musical_skills` int(11) DEFAULT NULL,
  `sports` int(11) DEFAULT NULL,
  `result_status` varchar(100) DEFAULT NULL,
  `date_created` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

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
  `subjects_handling` varchar(1024) DEFAULT NULL,
  `qualifications` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `subject_records_2024_2025`
--

CREATE TABLE `subject_records_2024_2025` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `std_id` int(11) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `class_cat` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `ca1` int(11) DEFAULT NULL,
  `ca2` int(11) DEFAULT NULL,
  `ca3` int(11) DEFAULT NULL,
  `ca4` int(11) DEFAULT NULL,
  `exam` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `grade` varchar(100) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `result_status` varchar(100) DEFAULT NULL,
  `date_created` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_records_2025_2026`
--

CREATE TABLE `subject_records_2025_2026` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `std_id` int(11) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `class_cat` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `ca1` int(11) DEFAULT NULL,
  `ca2` int(11) DEFAULT NULL,
  `ca3` int(11) DEFAULT NULL,
  `ca4` int(11) DEFAULT NULL,
  `exam` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `grade` varchar(100) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `result_status` varchar(100) DEFAULT NULL,
  `date_created` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_records_2026_2027`
--

CREATE TABLE `subject_records_2026_2027` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `std_id` int(11) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `class_cat` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `ca1` int(11) DEFAULT NULL,
  `ca2` int(11) DEFAULT NULL,
  `ca3` int(11) DEFAULT NULL,
  `ca4` int(11) DEFAULT NULL,
  `exam` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `grade` varchar(100) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `result_status` varchar(100) DEFAULT NULL,
  `date_created` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_results`
--

CREATE TABLE `subject_results` (
  `id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `serial` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `session` varchar(100) DEFAULT NULL,
  `cas` varchar(200) DEFAULT NULL,
  `exam` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `grade` varchar(100) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `date_created` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

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
-- Indexes for table `grading_system`
--
ALTER TABLE `grading_system`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `results_2024_2025`
--
ALTER TABLE `results_2024_2025`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `term` (`term`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `results_2025_2026`
--
ALTER TABLE `results_2025_2026`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `term` (`term`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `results_2026_2027`
--
ALTER TABLE `results_2026_2027`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `term` (`term`),
  ADD KEY `class` (`class`);

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
-- Indexes for table `subject_records_2024_2025`
--
ALTER TABLE `subject_records_2024_2025`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `term` (`term`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `subject_records_2025_2026`
--
ALTER TABLE `subject_records_2025_2026`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `term` (`term`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `subject_records_2026_2027`
--
ALTER TABLE `subject_records_2026_2027`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `term` (`term`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `subject_results`
--
ALTER TABLE `subject_results`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_set`
--
ALTER TABLE `class_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grading_system`
--
ALTER TABLE `grading_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mailing_list`
--
ALTER TABLE `mailing_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_queue`
--
ALTER TABLE `mail_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results_2024_2025`
--
ALTER TABLE `results_2024_2025`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results_2025_2026`
--
ALTER TABLE `results_2025_2026`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results_2026_2027`
--
ALTER TABLE `results_2026_2027`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_records_2024_2025`
--
ALTER TABLE `subject_records_2024_2025`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_records_2025_2026`
--
ALTER TABLE `subject_records_2025_2026`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_records_2026_2027`
--
ALTER TABLE `subject_records_2026_2027`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_results`
--
ALTER TABLE `subject_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variables`
--
ALTER TABLE `variables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
