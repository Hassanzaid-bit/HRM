-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2023 at 06:30 PM
-- Server version: 8.0.32
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `hod` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `hod`) VALUES
(1, 'Finance2', 1),
(2, 'IT', 2);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idNumber` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` int NOT NULL DEFAULT '1',
  `department` int DEFAULT NULL,
  `managerId` int DEFAULT NULL,
  `supervisorId` int DEFAULT NULL,
  `status` enum('Active','Retired') NOT NULL DEFAULT 'Active',
  `createdAt` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `firstName`, `lastName`, `email`, `mobile`, `idNumber`, `password`, `role`, `department`, `managerId`, `supervisorId`, `status`, `createdAt`) VALUES
(1, 'HOD', 'AADIL', 'staff@gmail.com', NULL, '12345', '$2y$10$Rt9BI4vKs3VLaHdjVNQhW.zgK6bsFcm5TSFe35zqBF1I88cFDhO9.', 2, 1, 0, 0, 'Active', '2023-05-21 10:10:12.295065'),
(2, 'HOD', 'ZAID', 'hod@gmail.com', NULL, '12345', '$2y$10$jMLW1D2225w07BTA9B02WeTdGc8FhLj2bUg4zchYv/2ErwIlUg8ya', 2, 2, 0, 0, 'Active', '2023-05-21 10:10:53.546093'),
(3, 'Super Admin', 'AADIL', 'admin@gmail.com', NULL, '12345', '$2y$10$jMLW1D2225w07BTA9B02WeTdGc8FhLj2bUg4zchYv/2ErwIlUg8ya', 3, 2, 0, 0, 'Active', '2023-05-21 10:10:53.546093'),
(4, 'John', 'Cena', 'John@gmail.com', NULL, '3434343434', '$2y$10$2EjV2WGV.XGeYPUe.18HNOCbL1Z4QVx5GvlGpolE3gxdBFY8YQ6jO', 1, 1, 0, 0, 'Active', '2023-05-21 12:52:45.832613'),
(5, 'John', 'Doe', 'doe@gmail.com', NULL, '5677889', '$2y$10$3csOHvSx8agkc2UFraAhpurTtEyqXkCQcc6jlSj5DOVftM5nNP7rq', 1, 2, 0, 0, 'Active', '2023-05-21 15:21:56.368630');

-- --------------------------------------------------------

--
-- Table structure for table `employee_tasks`
--

CREATE TABLE `employee_tasks` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `createdBy` int NOT NULL,
  `assignedTo` int NOT NULL,
  `supervisor` int NOT NULL,
  `manager` int DEFAULT NULL,
  `status` enum('Completed','Not Completed','Pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Completed',
  `startDate` varchar(255) NOT NULL,
  `endDate` varchar(255) NOT NULL,
  `createdAt` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee_tasks`
--

INSERT INTO `employee_tasks` (`id`, `name`, `details`, `createdBy`, `assignedTo`, `supervisor`, `manager`, `status`, `startDate`, `endDate`, `createdAt`) VALUES
(1, 'Debug Code', NULL, 1, 2, 1, 0, 'Completed', '2023-05-21 13:22:00', '2023-05-24 13:22:00', '2023-05-21 10:22:22.801092'),
(2, 'Ginger Woods', NULL, 2, 1, 2, 0, 'Completed', '2023-05-21 13:47:00', '2023-05-23 13:47:00', '2023-05-21 10:47:09.327203'),
(3, 'Finish Porject documentattion', NULL, 2, 1, 2, 0, 'Completed', '2023-05-22 15:45:00', '2023-05-23 15:45:00', '2023-05-21 12:45:52.282416'),
(4, 'Add Data in IS', NULL, 2, 3, 2, 0, 'Completed', '2023-05-22 17:15:00', '2023-05-24 17:15:00', '2023-05-21 14:12:53.249149'),
(5, 'Add Data in IS', NULL, 2, 4, 2, 0, 'Not Completed', '2023-05-22 17:22:00', '2023-05-24 17:22:00', '2023-05-21 14:18:00.241345'),
(6, 'Ginger Woods', NULL, 2, 4, 2, 0, 'Not Completed', '2023-05-21 17:46:00', '2023-05-24 17:47:00', '2023-05-21 14:47:04.375885'),
(7, 'Check Tables', NULL, 1, 4, 1, 0, 'Not Completed', '2023-05-22 06:23:00', '2023-05-23 08:24:00', '2023-05-21 15:24:21.781693'),
(8, 'Check Tables', NULL, 1, 4, 1, 0, 'Not Completed', '2023-05-22 06:23:00', '2023-05-23 08:24:00', '2023-05-21 15:24:21.915767'),
(9, 'Check Tables', NULL, 1, 4, 1, 0, 'Not Completed', '2023-05-22 06:23:00', '2023-05-23 08:24:00', '2023-05-21 15:24:26.979093'),
(10, 'Check Tables', NULL, 1, 4, 1, 0, 'Not Completed', '2023-05-22 06:23:00', '2023-05-23 08:24:00', '2023-05-21 15:24:27.052933'),
(11, 'Check Tables', NULL, 1, 4, 1, 0, 'Not Completed', '2023-05-22 06:23:00', '2023-05-23 08:24:00', '2023-05-21 15:24:45.586792'),
(12, 'Check Tables', NULL, 1, 4, 1, 0, 'Not Completed', '2023-05-22 06:23:00', '2023-05-23 08:24:00', '2023-05-21 15:24:45.657964'),
(13, 'check tables', 'confirm that they balance', 1, 4, 1, 0, 'Not Completed', '2023-05-22 07:30:00', '2023-05-22 08:30:00', '2023-05-21 15:26:44.337470');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` int NOT NULL,
  `leaveType` int NOT NULL,
  `employeeId` int NOT NULL,
  `startDate` varchar(255) NOT NULL,
  `endDate` varchar(255) NOT NULL,
  `days` int NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `createdAt` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updatedAt` timestamp(6) NULL DEFAULT NULL,
  `updatedBy` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `leaveType`, `employeeId`, `startDate`, `endDate`, `days`, `comment`, `status`, `createdAt`, `updatedAt`, `updatedBy`) VALUES
(1, 1, 1, '2023-05-21', '2023-05-24', 3, 'Brother\'s wedding', 'Approved', '2023-05-21 10:40:22.815961', '2023-05-21 10:49:57.000000', 2),
(2, 1, 1, '2023-05-21', '2023-05-25', 4, 'Brother\'s wedding', 'Rejected', '2023-05-21 12:38:21.138480', '2023-05-21 15:18:32.000000', 1),
(3, 1, 1, '2023-05-21', '2023-05-24', 3, 'school meeting', 'Approved', '2023-05-21 12:43:35.358504', '2023-05-21 12:44:58.000000', 2),
(4, 1, 1, '2023-05-21', '2023-05-25', 4, 'school', 'Rejected', '2023-05-21 15:18:17.490191', '2023-05-21 15:18:35.000000', 1),
(5, 1, 1, '2023-05-21', '2023-05-25', 4, 'school', 'Rejected', '2023-05-21 15:18:17.560860', '2023-05-21 15:18:37.000000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `duration`) VALUES
(1, 'Paternity Leave2', 21),
(2, 'Maternity Leave', 30);

-- --------------------------------------------------------

--
-- Table structure for table `reporting`
--

CREATE TABLE `reporting` (
  `id` int NOT NULL,
  `employee` int NOT NULL,
  `reportsTo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `isDeleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `isDeleted`) VALUES
(1, 'Employee', 0),
(2, 'Head of Department', 0),
(3, 'Super Admin', 1),
(4, 'Manager', 1),
(5, 'Test Role', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task_updates`
--

CREATE TABLE `task_updates` (
  `id` int NOT NULL,
  `taskId` int NOT NULL,
  `message` varchar(255) NOT NULL,
  `createdAt` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_updates`
--

INSERT INTO `task_updates` (`id`, `taskId`, `message`, `createdAt`) VALUES
(1, 2, 'Started project', '2023-05-21 11:50:24.924578'),
(2, 2, 'Almost there', '2023-05-21 11:53:09.694868'),
(3, 3, 'halfway done, to be completed by tomorrow', '2023-05-21 12:47:55.088905'),
(4, 5, 'managed to add file no. 457 ', '2023-05-21 14:32:59.497281'),
(5, 5, 'Testing', '2023-05-21 14:47:58.321866'),
(6, 5, 'A project status report is a document that regularly ', '2023-05-21 14:48:52.415091'),
(7, 6, 'Almost finishing', '2023-05-21 15:28:47.017697');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_tasks`
--
ALTER TABLE `employee_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reporting`
--
ALTER TABLE `reporting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_updates`
--
ALTER TABLE `task_updates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_tasks`
--
ALTER TABLE `employee_tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reporting`
--
ALTER TABLE `reporting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_updates`
--
ALTER TABLE `task_updates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
