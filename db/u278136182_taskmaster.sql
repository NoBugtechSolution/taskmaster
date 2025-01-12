-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 12, 2025 at 04:33 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u278136182_taskmaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `bug_reports`
--

CREATE TABLE `bug_reports` (
  `bug_id` int(11) NOT NULL,
  `tester_name` varchar(255) DEFAULT NULL,
  `ProjectID` int(11) NOT NULL,
  `bug_title` varchar(255) NOT NULL,
  `bug_description` text NOT NULL,
  `bug_url` varchar(255) DEFAULT NULL,
  `bug_status` enum('New','In Progress','Resolved','Closed') DEFAULT 'New',
  `reported_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks_by_tester` text DEFAULT NULL,
  `Priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `recipient` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `recipient`, `type`, `date`, `is_read`) VALUES
(17, '\'Class room management\' has been assigned to you. Please review and start working on it', 6, 'New Task Assigned', '2024-12-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ProjectID` int(11) NOT NULL,
  `ProjectName` varchar(2500) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ProjectID`, `ProjectName`, `Status`) VALUES
(1, 'eduxamido', 1),
(2, 'taskmaster', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ready_for_testing`
--

CREATE TABLE `ready_for_testing` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `test_status` enum('Developed','testing','Bug','Passed') NOT NULL,
  `DeveloperComments` text NOT NULL,
  `TesterComments` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ready_for_testing`
--

INSERT INTO `ready_for_testing` (`id`, `task_id`, `test_status`, `DeveloperComments`, `TesterComments`, `created_at`, `status`) VALUES
(4, 45, 'testing', 'test for name wise , dept wise and roll no wise sorting', '', '2024-12-23 12:55:00', 1),
(5, 45, 'testing', '\r\n1. url \r\nhttp://localhost/eduxamido/student_details/\r\n\r\nThen click student_data_list \r\nThen click on view to reach the file for testing \r\n\r\n2. Added searching and filtering options \r\n\r\n', '', '2024-12-23 13:55:29', 1),
(6, 49, 'testing', 'New page to edit individual student data added.\r\nCheck if it\'s working properly.\r\n\r\nUrl:\r\nhttp://localhost/Exam_softwareleduxamido/student_details/\r\n\r\nFirst open student_data_list.php > view > edit ', '', '2025-01-01 08:50:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('Pending','Bugs Founded','In Progress','Completed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `ProjectID`, `title`, `description`, `assigned_to`, `due_date`, `status`, `created_at`, `Priority`) VALUES
(43, 1, 'Fix Button&#039;s', 'check for All the button are working properly,', 4, '2024-12-30', 'Pending', '2024-12-21 11:01:12', 2),
(44, 1, 'Fix Seating Arrangements Functionality', 'Debug and resolve errors in seating arrangement functionality.', 3, '2024-12-31', 'In Progress', '2024-12-21 11:01:12', 2),
(45, 1, 'Implement Data Filtering and Search in  students data', 'Add options to filter and search students data.', 5, '2024-12-27', 'Completed', '2024-12-21 11:01:12', 2),
(47, 1, 'Implement Direct Home Navigation', 'Add functionality for direct navigation to the homepage.', 4, '2025-01-03', 'Pending', '2024-12-21 11:01:12', 2),
(48, 1, 'Resolve File Upload Errors', 'Debug and fix errors occurring during file uploads.', 3, '2025-01-03', 'Pending', '2024-12-21 11:01:12', 2),
(49, 1, 'Enable Student Data Editing', 'Add functionality to edit individual student data.', 5, '2025-01-03', 'Completed', '2024-12-21 11:01:12', 2),
(52, 1, 'Finalize Invigilator Management Output', 'Link seating arrangement functionality to invigilator management.', 4, '2025-01-10', 'Pending', '2024-12-21 11:01:12', 2),
(53, 1, 'Fix View Button in Student management', 'Ensure the View button working from home screen .', 5, '2025-01-10', 'Completed', '2024-12-21 11:01:12', 2),
(54, 1, 'System-Wide Bug Fixes (Part 1)', 'Identify and resolve initial bugs across all modules.', 13, '2025-01-10', 'Pending', '2024-12-21 11:01:12', 2),
(58, 1, 'System-Wide Bug Fixes (Part 2)', 'Perform detailed system-wide testing for errors.', 12, '2025-01-17', 'Pending', '2024-12-21 11:01:12', 2),
(59, 1, 'View Seating of created Exams', 'Polish UI and fix minor design issues.\r\nView Seating of created Exams', 3, '2025-02-05', 'Pending', '2024-12-21 11:01:12', 2),
(62, 1, 'Finalize System Testing', 'Conclude system-wide bug fixes.', 7, '2025-01-24', 'Pending', '2024-12-21 11:01:12', 2),
(63, 0, 'Class room management', 'create a Class room management  page edite and add', 6, '2025-01-07', NULL, '2024-12-23 14:10:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'VISHAL', 'admin', '$2y$10$TnyR1Y43m1EIWpb0MiwE8Ocm6rj0F2KojE3PobVfQDo9HYlAHY/7O', 'admin', '2024-08-28 07:10:04'),
(2, 'VISHAL V NAIR', 'vishalvnair124', '$2y$10$5WmXq5qhWgtO19k.IQ/YaeEPb832S.KtQ/NXVTHgp07MCa6HbHkga', 'employee', '2024-08-28 07:10:40'),
(3, 'ABHIN M', 'abhinm', '$2y$10$VESl/SiZac90BEQlwzvtYeCNGb20OvvYoit7ebpv6EzIWHzvqGoi6', 'employee', '2024-08-29 17:11:21'),
(4, 'SETHU S NAIR', 'sethusnair', '$2y$10$TnyR1Y43m1EIWpb0MiwE8Ocm6rj0F2KojE3PobVfQDo9HYlAHY/7O', 'employee', '2024-08-29 17:11:34'),
(5, 'ABI B', 'abi', '$2y$10$mOHtPVYYsAGSdob8VTsvm.sH2KpirDoaV9Ispgp3TCB7g8e6KAYSK', 'employee', '2024-12-13 15:04:58'),
(6, 'ANANDHU V NAIR', 'anandhuvnair', '$2y$10$tsL3vNwVupguanTNiMpEC.CZDV4CpoAQxuntBa/MzCV5RBHsvmB06', 'employee', '2024-12-13 15:06:26'),
(7, 'ROBIN P', 'robinp', '$2y$10$63FJ2WoQuNUFZBt76LelXuj9nmoqAyM9NXF2OjUesglae/H3pgRn6', 'employee', '2024-12-13 15:03:34'),
(12, 'Harijith', 'harijith', '$2y$10$urY5dS4wtDE81XqkhoVQDeJ/0KpZuJTNzMGsI4nQB.eVtvtKHHZ.C', 'employee', '2024-12-22 05:07:27'),
(13, 'Adarsh', 'adarsh', '$2y$10$in6SuWBlQJxL1nBylqKOR.FXSUuyKH.ZgxJ7VWAKCZ4i5wgQGqH3e', 'employee', '2024-12-22 05:08:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bug_reports`
--
ALTER TABLE `bug_reports`
  ADD PRIMARY KEY (`bug_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ProjectID`);

--
-- Indexes for table `ready_for_testing`
--
ALTER TABLE `ready_for_testing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bug_reports`
--
ALTER TABLE `bug_reports`
  MODIFY `bug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ready_for_testing`
--
ALTER TABLE `ready_for_testing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
