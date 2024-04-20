-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2024 at 05:03 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timetable_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int NOT NULL,
  `admin_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$aE2IW3.jVrZN8bWKp1i9g.KwkdG913El2GPmu3TmKN5MpEbH5/AXW');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int NOT NULL,
  `department_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Computer Science'),
(2, 'Electrical Engineering'),
(3, 'Psychology');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `lecturer_id` int NOT NULL,
  `lecturer_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`lecturer_id`, `lecturer_name`, `email`, `password`) VALUES
(1, 'Lec 111', 'abc1@xyz.com', '$2y$10$aE2IW3.jVrZN8bWKp1i9g.KwkdG913El2GPmu3TmKN5MpEbH5/AXW'),
(3, 'Lecturer 1', 'ggq@example.com', '$2y$10$5v4Qqh8oiw1pNGpa5geGn.Ai1ea8lQz6yuTEMbsN/E0zBu2MVjfre'),
(4, 'Lecturer 2', 'yoj@example.com', '$2y$10$OdIsmD9NMv.0sjgybgB9Qem43aGRxV1IwPsOO5qWJgajJKaRM1OKq'),
(5, 'Lecturer 3', 'idz@example.com', '$2y$10$CVXJCPpZZh5l0jExROv/bO3bPuHKeiciFKUiCzh5apvlQSlUZ7tGi'),
(6, 'Lecturer 4', 'umk@example.com', '$2y$10$rFNWcro.a7fYL3uxVMOTruNtAvhxUbn3ZZPe9DPh8P5Jne9HUotq2'),
(7, 'Lecturer 5', 'gcx@example.com', '$2y$10$lYPsJoqiEraYqXa/KwhsJ..VozRpBdkisJ3ym5bVf.eIMjjesigxi'),
(8, 'Lecturer 6', 'ywd@example.com', '$2y$10$Qb4mAUAh3vQD7C33R1pdT.OaCW9vmVh.kxV1G403OFt9K/KwrhxmK'),
(9, 'Lecturer 7', 'hqd@example.com', '$2y$10$nnn.RsZ1l5NY9csc0H/SAuze2bS/p01CtxGwK.zLb2/6FqDv/Ccn.'),
(10, 'Lecturer 8', 'wjm@example.com', '$2y$10$kYxU/JeG3Y/EgAFt7Ns2SOhyoDzs/bKPb3E2G0y1M0j02o8829fpa'),
(11, 'Lecturer 9', 'eyw@example.com', '$2y$10$tRN1xos1WMDyVZEieKeAWuATcQTUnSbhzLRlUtJeFcacIh7MRZgnW'),
(12, 'Lecturer 10', 'xvh@example.com', '$2y$10$A1eADmsSKKVzrGqylF8BeuoNlH0gozbiGVOBuLCtDvNBQ.a27m0o6');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int NOT NULL,
  `module_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `program_id` int DEFAULT NULL,
  `semester` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `program_id`, `semester`) VALUES
(1, 'Introduction to Programming', 1, 1),
(2, 'Database Management Systems', 1, 2),
(3, 'Software Engineering Principles', 2, 1),
(4, 'Web Development', 2, 2),
(5, 'Network Security', 3, 1),
(6, 'Ethical Hacking', 3, 2),
(7, 'Circuit Analysis', 4, 1),
(8, 'Electrical Machines', 4, 2),
(9, 'Microelectronics', 5, 1),
(10, 'Digital Signal Processing', 5, 2),
(11, 'Power Systems Analysis', 6, 1),
(12, 'Renewable Energy Systems', 6, 2),
(13, 'Introduction to Psychology', 7, 1),
(14, 'Developmental Psychology', 7, 2),
(15, 'Cognitive Psychology', 8, 1),
(16, 'Abnormal Psychology', 8, 2),
(17, 'Clinical Psychology', 9, 1),
(18, 'Counseling Psychology', 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `modules_lecturers`
--

CREATE TABLE `modules_lecturers` (
  `module_id` int NOT NULL,
  `lecturer_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules_lecturers`
--

INSERT INTO `modules_lecturers` (`module_id`, `lecturer_id`) VALUES
(1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `modules_students`
--

CREATE TABLE `modules_students` (
  `module_id` int NOT NULL,
  `student_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules_students`
--

INSERT INTO `modules_students` (`module_id`, `student_id`) VALUES
(1, 6),
(1, 8),
(1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int NOT NULL,
  `program_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `program_name`, `department_id`) VALUES
(1, 'Bachelor of Science in Computer Science', 1),
(2, 'Bachelor of Engineering in Software Engineering', 1),
(3, 'Bachelor of Science in Cybersecurity', 1),
(4, 'Bachelor of Science in Electrical Engineering', 2),
(5, 'Bachelor of Engineering in Electronics and Communication Engineering', 2),
(6, 'Bachelor of Science in Power Systems Engineering', 2),
(7, 'Bachelor of Arts in Psychology', 3),
(8, 'Bachelor of Science in Cognitive Psychology', 3),
(9, 'Bachelor of Science in Clinical Psychology', 3);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int NOT NULL,
  `room_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `capacity` int DEFAULT NULL,
  `room_type` enum('Lecture Theatre','Lab') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `capacity`, `room_type`) VALUES
(1, 'CS-Room 1', 200, 'Lecture Theatre');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int NOT NULL,
  `student_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `email`, `password`) VALUES
(1, 'Student 1', 'abc1@xyz.com', '$2y$10$mrts5g7iM9MRLoCZqY4m8O.TjowaTRml8f8Wa8YSV4LjcrpX3EEW2'),
(2, 'Student 1', 'vos@example.com', '$2y$10$kihaiV1FGq/mDnvfbOkY/eLVltVqcdi7NXdv1B4X36SxADZMcl7We'),
(3, 'Student 2', 'qhy@example.com', '$2y$10$UPTsVDcUeohz9KBOThXKaexzmpYH93oQRMiMyDTfVKEKEHc.vUvMC'),
(4, 'Student 3', 'anm@example.com', '$2y$10$xQwcIZ6nQBMuFAEADUKJIuxiFg1gS.uMW3MjxDVfPlI15nYD1S2IO'),
(5, 'Student 4', 'ayz@example.com', '$2y$10$rFrgAa6lnM3.BWA4XTgUeuZRYDR2oigK2qEqb8sNZmsPS8EZBXlIq'),
(6, 'Student 5', 'foa@example.com', '$2y$10$M0r1u39j7OhGzARMznQHke4GyAqN3FEIJtoewWZrYvedA3N6pqlwq'),
(8, 'Student 7', 'jgj@example.com', '$2y$10$dfaevpQr.WJc3S2lX9GGw.F5JVTUJsYH8gaqSRbIEwWwFWydTupNe'),
(9, 'Student 8', 'nfe@example.com', '$2y$10$J0B0D4BHA7pOvomjdgw1Ee7/1q9v0Aec9zmj.o60lh9ixAKkX1lfG'),
(10, 'Student 9', 'tdj@example.com', '$2y$10$ibHCCczLwy3lc19lNS1St.2lFb.wTg6W4S5CQ/q4jUR/Dl0IdZoQq'),
(11, 'Student 10', 'zwg@example.com', '$2y$10$sgNIXxGjYaFWpY7LjCYdieP.U3PqDnmaDLZ7JzeZdIDUKuD06GBCu');

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `timetable_id` int NOT NULL,
  `module_id` int DEFAULT NULL,
  `room_id` int DEFAULT NULL,
  `day` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`timetable_id`, `module_id`, `room_id`, `day`, `start_time`, `end_time`, `createdAt`) VALUES
(1, 2, 1, 'Tuesday', '09:00:00', '12:00:00', '2024-04-20 10:19:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `modules_lecturers`
--
ALTER TABLE `modules_lecturers`
  ADD PRIMARY KEY (`module_id`,`lecturer_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `modules_students`
--
ALTER TABLE `modules_students`
  ADD PRIMARY KEY (`module_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`timetable_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `lecturer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `timetable_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`);

--
-- Constraints for table `modules_lecturers`
--
ALTER TABLE `modules_lecturers`
  ADD CONSTRAINT `modules_lecturers_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`),
  ADD CONSTRAINT `modules_lecturers_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`lecturer_id`);

--
-- Constraints for table `modules_students`
--
ALTER TABLE `modules_students`
  ADD CONSTRAINT `modules_students_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`),
  ADD CONSTRAINT `modules_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`),
  ADD CONSTRAINT `timetables_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
