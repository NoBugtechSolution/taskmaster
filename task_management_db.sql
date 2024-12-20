-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 01:23 PM
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
-- Database: `task_management_db`
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

--
-- Dumping data for table `bug_reports`
--

INSERT INTO `bug_reports` (`bug_id`, `tester_name`, `ProjectID`, `bug_title`, `bug_description`, `bug_url`, `bug_status`, `reported_date`, `remarks_by_tester`, `Priority`) VALUES
(3, 'vishalvnair124', 1, 'Test Error', 'newfdu', 'asdg', 'New', '2024-12-20 11:23:57', 'adatsdy', 0);

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
(1, '\'Customer Feedback Survey Analysis\' has been assigned to you. Please review and start working on it.', 7, 'New Task Assigned', '2024-09-05', 1),
(2, '\'test task\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '0000-00-00', 1),
(3, '\'Example task 2\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2006-09-24', 1),
(4, '\'test\' has been assigned to you. Please review and start working on it', 8, 'New Task Assigned', '2009-06-24', 0),
(5, '\'test task 3\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 1),
(6, '\'Prepare monthly sales report\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 1),
(7, '\'Update client database\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 1),
(8, '\'Fix server downtime issue\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(9, '\'Plan annual marketing strategy\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(10, '\'Onboard new employees\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 0),
(11, '\'Design new company website\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(12, '\'Conduct software testing\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 0),
(13, '\'Schedule team meeting\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(14, '\'Prepare budget for Q4\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 0),
(15, '\'Write blog post on industry trend\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 0),
(16, '\'Renew software license\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0);

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
(1, 'Examido', 1),
(2, 'Blog', 1);

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
(3, 29, 'testing', 'Ready to test this feature', '', '2024-12-20 11:59:38', 1);

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
  `status` enum('pending','bugs_founded','in_progress','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `ProjectID`, `title`, `description`, `assigned_to`, `due_date`, `status`, `created_at`, `Priority`) VALUES
(28, 1, 'Prepare End-of-Year Financial Report', 'Compile financial data for the entire year and prepare the annual report.', 7, '2024-12-05', 'in_progress', '2024-12-01 02:45:30', 1),
(29, 2, 'Organize Team Holiday Party', 'Plan and schedule the team holiday celebration, including venue and catering.', 2, '2024-12-10', 'completed', '2024-12-01 02:50:10', 2),
(30, 1, 'Launch Winter Marketing Campaign', 'Coordinate the launch of the new seasonal marketing strategy.', 7, '2024-12-07', 'completed', '2024-12-02 03:40:50', 3),
(31, 1, 'Client Meeting for Project Review', 'Discuss progress and next steps with the client.', 2, '2024-12-12', 'pending', '2024-12-02 04:15:10', 4),
(33, 1, 'Prepare Q1 Strategy Presentation', 'Draft a presentation outlining objectives and strategies for Q1 2025.', 2, '2024-12-08', 'pending', '2024-12-03 05:00:45', 5),
(34, 1, 'Software Upgrade Testing', 'Test the new features of the updated software.', 7, '2024-12-10', 'pending', '2024-12-04 05:30:30', 6),
(35, 2, 'Backup All Company Data', 'Ensure all digital assets and data are backed up before the holiday break.', 7, '2024-12-13', 'pending', '2024-12-04 06:00:00', 7),
(36, 1, 'Submit Tax Documents', 'Prepare and submit all necessary tax-related documents.', 2, '2024-12-14', 'in_progress', '2024-12-05 03:20:20', 8),
(38, 2, 'Server Maintenance', 'Perform maintenance on all servers to ensure smooth operations.', 2, '2024-12-09', 'in_progress', '2024-12-06 04:10:20', 9),
(39, 1, 'Review Supplier Contracts', 'Analyze supplier agreements and suggest updates for the upcoming year.', 7, '2024-12-11', 'pending', '2024-12-06 04:50:50', 10),
(40, 1, 'Design New Brochure', 'Create a design draft for the new product brochure.', 2, '2024-12-14', 'pending', '2024-12-06 05:35:30', 11),
(41, 1, 'Train New Interns', 'Conduct orientation sessions for the newly joined interns.', 7, '2024-12-12', 'in_progress', '2024-12-07 03:55:45', 12),
(42, 1, 'Update Project Timeline', 'Revise the timelines for ongoing projects for better tracking.', 2, '2024-12-08', 'completed', '2024-12-07 04:20:10', 13);

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
(1, 'Oliver', 'admin', '$2y$10$TnyR1Y43m1EIWpb0MiwE8Ocm6rj0F2KojE3PobVfQDo9HYlAHY/7O', 'admin', '2024-08-28 07:10:04'),
(2, 'VISHAL V NAIR', 'vishalvnair124', '$2y$10$5WmXq5qhWgtO19k.IQ/YaeEPb832S.KtQ/NXVTHgp07MCa6HbHkga', 'employee', '2024-08-28 07:10:40'),
(7, 'ABHIN M', 'abhinm', '$2y$10$VESl/SiZac90BEQlwzvtYeCNGb20OvvYoit7ebpv6EzIWHzvqGoi6', 'employee', '2024-08-29 17:11:21'),
(8, 'SETHU S NAIR', 'sethusnair', '$2y$10$i93zwnmRg88dHX3fmOuIaOvV9VkfsJKtLyit5.5r61xse9RIzDbfK', 'employee', '2024-08-29 17:11:34'),
(9, 'ROBIN P', 'robinp', '$2y$10$63FJ2WoQuNUFZBt76LelXuj9nmoqAyM9NXF2OjUesglae/H3pgRn6', 'employee', '2024-12-13 15:03:34'),
(10, 'ABHI B', 'abhi', '$2y$10$mOHtPVYYsAGSdob8VTsvm.sH2KpirDoaV9Ispgp3TCB7g8e6KAYSK', 'employee', '2024-12-13 15:04:58'),
(11, 'ANANDHU V NAIR', 'anandhuvnair', '$2y$10$tsL3vNwVupguanTNiMpEC.CZDV4CpoAQxuntBa/MzCV5RBHsvmB06', 'employee', '2024-12-13 15:06:26');

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
  MODIFY `bug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ready_for_testing`
--
ALTER TABLE `ready_for_testing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
