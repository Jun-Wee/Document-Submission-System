-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2022 at 08:59 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `documentsubmissionsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `UserId` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Gender` char(6) DEFAULT NULL,
  `isSubscribe` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`UserId`, `Name`, `Email`, `Password`, `Role`, `Gender`, `isSubscribe`) VALUES
('A101', 'Admin', 'admin101@swin.edu.au', 'swin', 'Admin', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `analysis`
--

CREATE TABLE `analysis` (
  `analysisId` int(10) NOT NULL,
  `subId` int(10) NOT NULL,
  `summary` varchar(200) DEFAULT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `matchedTitles` varchar(200) DEFAULT NULL,
  `sentimentScore` float DEFAULT NULL,
  `sentimentMagnitude` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `convenors`
--

CREATE TABLE `convenors` (
  `UserId` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Gender` char(6) DEFAULT NULL,
  `isSubscribe` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `convenors`
--

INSERT INTO `convenors` (`UserId`, `Name`, `Email`, `Password`, `Role`, `Gender`, `isSubscribe`) VALUES
('C101', 'Jun Han', 'jhan@swin.edu.au', 'swin', 'Convenor', 'Male', 1),
('C102', 'Bao Quoc Vo', 'bvo@swin.edu.au', 'swin', 'Convenor', 'Male', 1),
('C103', 'Karola von Baggo', 'kvonbaggo@swin.edu.au', 'swin', 'Convenor', 'Female', 0),
('C104', 'Jason Sargent', 'jpsargent@swin.edu.au', 'swin', 'Convenor', 'Male', 0);

-- --------------------------------------------------------

--
-- Table structure for table `enrolment`
--

CREATE TABLE `enrolment` (
  `studentId` varchar(10) NOT NULL,
  `code` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrolment`
--

INSERT INTO `enrolment` (`studentId`, `code`) VALUES
('101225244', 'ACC10007'),
('101225244', 'ACC20014'),
('101225244', 'COS10005'),
('101225244', 'COS10009'),
('101231636', 'COS20001'),
('101231636', 'COS20016'),
('101231636', 'ICT10001'),
('101231636', 'INF10002'),
('102426323', 'INF20003'),
('102426323', 'INF20012'),
('102426323', 'INF30001'),
('102426323', 'TNE10005'),
('102849357', 'ACC10007'),
('102849357', 'ACC20014'),
('102849357', 'COS10005'),
('102849357', 'COS10009'),
('103340644', 'COS20001'),
('103340644', 'COS20016'),
('103340644', 'ICT10001'),
('103340644', 'INF10002'),
('103698851', 'INF20003'),
('103698851', 'INF20012'),
('103698851', 'INF30001'),
('103698851', 'TNE10005');

-- --------------------------------------------------------

--
-- Table structure for table `entity`
--

CREATE TABLE `entity` (
  `entityId` int(10) NOT NULL,
  `subId` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `salience` double DEFAULT NULL,
  `link` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `UserId` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Gender` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`UserId`, `Name`, `Email`, `Password`, `Role`, `Gender`) VALUES
('101224321', 'eded', 'eded@swinburne.edu.au', 'swin', 'Student', 'male'),
('101225244', 'Adrian Sim', '101225244@student.swin.edu.au', 'swin', 'Student', 'Male'),
('101228765', 'vovo', 'vovo@swinburne.edu.au', 'swin', 'Student', 'male'),
('101231636', 'Jun Wee', '101231636@student.swin.edu.au', 'swin', 'Student', 'Male'),
('102426323', 'Yovinma Konara', '102426323@student.swin.edu.au', 'swin', 'Student', 'Female'),
('102849357', 'Sandali Jayasinghe', '102849357@student.swin.edu.au', 'swin', 'Student', 'Female'),
('103340644', 'Richard Ly', '103340644@student.swin.edu.au', 'swin', 'Student', 'Male'),
('103698851', 'Xin Zhe', '103698851@student.swin.edu.au', 'swin', 'Student', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `Id` int(11) NOT NULL,
  `stuId` varchar(10) NOT NULL,
  `datetime` datetime NOT NULL,
  `score` int(11) NOT NULL,
  `unitCode` varchar(50) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `isSendMail` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submission`
--

INSERT INTO `submission` (`Id`, `stuId`, `datetime`, `score`, `unitCode`, `filepath`, `isSendMail`) VALUES
(100040, '102849357', '2022-07-13 20:33:44', 0, 'COS10005', 'StuSubmission/COS10005/Sandali Jayasinghe/Sandali Jayasinghe.1088.(Feedback) SQAP_v1.1.pdf', 0),
(100041, '102849357', '2022-07-13 20:33:47', 4, 'ICT10001', 'StuSubmission/ICT10001/Sandali Jayasinghe/Sandali Jayasinghe.1723.(Feedback)SEP-Project Plan S1 2022_v 1.2.pdf', 0),
(100043, '102849357', '2022-07-13 20:33:52', 0, 'ACC10007', 'StuSubmission/ACC10007/Sandali Jayasinghe/Sandali Jayasinghe.1579.(Feedback) SQAP_v1.1.pdf', 0),
(100044, '102849357', '2022-07-13 20:33:56', 0, 'ACC20014', 'StuSubmission/ACC20014/Sandali Jayasinghe/Sandali Jayasinghe.1503.(Feedback) SQAP_v1.1.pdf', 0),
(100045, '102849357', '2022-07-13 20:33:59', 0, 'COS10005', 'StuSubmission/COS10005/Sandali Jayasinghe/Sandali Jayasinghe.1476.(Feedback) SQAP_v1.1.pdf', 0),
(100046, '102849357', '2022-07-13 20:34:02', 0, 'COS10009', 'StuSubmission/COS10009/Sandali Jayasinghe/Sandali Jayasinghe.1990.(Feedback) SQAP_v1.1.pdf', 0),
(100047, '101225244', '2022-07-13 20:35:24', 0, 'ACC10007', 'StuSubmission/ACC10007/Adrian Sim/Adrian Sim.1261.(Feedback) Software Design and Research Report.pdf', 0),
(100049, '101225244', '2022-07-13 20:35:32', 0, 'COS10005', 'StuSubmission/COS10005/Adrian Sim/Adrian Sim.1519.(Feedback) Software Design and Research Report.pdf', 0),
(100052, '101225244', '2022-07-13 20:35:41', 0, 'ACC20014', 'StuSubmission/ACC20014/Adrian Sim/Adrian Sim.1415.(Feedback) Software Design and Research Report.pdf', 0),
(100053, '101225244', '2022-07-13 20:35:45', 0, 'COS10005', 'StuSubmission/COS10005/Adrian Sim/Adrian Sim.1263.(Feedback) Software Design and Research Report.pdf', 0),
(100055, '101231636', '2022-07-13 21:34:49', 0, 'ICT10001', 'StuSubmission/ICT10001/Jun Wee/Jun Wee.1100.(Feedback)SEP-Software Requirement Specification S1 2022.pdf', 0),
(100056, '101231636', '2022-07-13 21:34:54', 0, 'COS20001', 'StuSubmission/COS20001/Jun Wee/Jun Wee.1230.(Feedback)SEP-Software Requirement Specification S1 2022.pdf', 0),
(100057, '101231636', '2022-07-13 21:34:58', 0, 'COS20016', 'StuSubmission/COS20016/Jun Wee/Jun Wee.1148.(Feedback)SEP-Software Requirement Specification S1 2022.pdf', 0),
(100058, '101231636', '2022-07-13 21:35:02', 0, 'ICT10001', 'StuSubmission/ICT10001/Jun Wee/Jun Wee.1418.(Feedback)SEP-Software Requirement Specification S1 2022.pdf', 0),
(100059, '101231636', '2022-07-13 21:35:05', 0, 'INF10002', 'StuSubmission/INF10002/Jun Wee/Jun Wee.1150.(Feedback)SEP-Software Requirement Specification S1 2022.pdf', 0),
(100060, '101231636', '2022-07-13 21:35:15', 0, 'INF10002', 'StuSubmission/INF10002/Jun Wee/Jun Wee.1122.(Feedback) Software Design and Research Report.pdf', 0),
(100061, '101231636', '2022-07-16 01:39:23', 3, 'COS20001', 'StuSubmission/COS20001/Jun Wee/Jun Wee.1169.[SEPA28]-Test Plan.pdf', 0),
(100062, '102426323', '2022-07-13 21:35:40', 0, 'INF20003', 'StuSubmission/INF20003/Yovinma Konara/Yovinma Konara.1863.(Feedback)SEP-Project Plan S1 2022_v 1.2.pdf', 0),
(100063, '102426323', '2022-07-13 21:35:48', 0, 'INF20003', 'StuSubmission/INF20003/Yovinma Konara/Yovinma Konara.1529.(Feedback) SQAP_v1.1.pdf', 0),
(100064, '102426323', '2022-07-13 21:35:52', 0, 'INF20012', 'StuSubmission/INF20012/Yovinma Konara/Yovinma Konara.1504.(Feedback) SQAP_v1.1.pdf', 0),
(100065, '102426323', '2022-07-13 21:35:57', 0, 'INF30001', 'StuSubmission/INF30001/Yovinma Konara/Yovinma Konara.1935.(Feedback) SQAP_v1.1.pdf', 0),
(100066, '102426323', '2022-07-13 21:36:01', 0, 'TNE10005', 'StuSubmission/TNE10005/Yovinma Konara/Yovinma Konara.1387.(Feedback) SQAP_v1.1.pdf', 0),
(100067, '101225244', '2022-07-14 22:32:43', 0, 'ACC20014', 'StuSubmission/ACC20014/Adrian Sim/Adrian Sim.1042.(DUE WK5) SEP-Project Plan S1 2022.pdf', 0),
(100068, '101225244', '2022-07-18 15:10:23', 0, 'ACC20014', 'StuSubmission/ACC20014/Adrian Sim/Adrian Sim.1125.(DUE WK5) SEP-Project Plan S1 2022.pdf', 0),
(100069, '101225244', '2022-07-23 13:17:14', 0, 'COS10005', 'StuSubmission/COS10005/Adrian Sim/Adrian Sim.1001.(Feedback) SQAP_v1.1.pdf', 0),
(100070, '101225244', '2022-07-23 13:44:46', 0, 'COS10005', 'StuSubmission/COS10005/Adrian Sim/Adrian Sim.1463.(Feedback) SQAP_v1.1.pdf', 0),
(100071, '101225244', '2022-07-23 15:22:07', 0, 'COS10005', 'StuSubmission/COS10005/Adrian Sim/Adrian Sim.1805.(Feedback) SQAP_v1.1.pdf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `code` varchar(8) NOT NULL,
  `description` char(100) DEFAULT NULL,
  `cp` decimal(10,2) NOT NULL,
  `type` varchar(50) NOT NULL,
  `convenorID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`code`, `description`, `cp`, `type`, `convenorID`) VALUES
('ACC10007', 'Financial Information for Decision Making', '12.50', 'Systems Analysis', 'C103'),
('ACC20014', 'Management Decision Making', '12.50', 'Systems Analysis', 'C104'),
('COS10005', 'Web Development', '12.50', 'Core', 'C101'),
('COS10009', 'Introduction to Programming', '12.50', 'Core', 'C101'),
('COS20001', 'User-Centred Design', '12.50', 'Software Development', 'C102'),
('COS20016', 'Operating System Configuration', '12.50', 'Software Development', 'C102'),
('ICT10001', 'Problem Solving with ICT', '12.50', 'Core', 'C101'),
('INF10002', 'Database Analysis and Design', '12.50', 'Core', 'C101'),
('INF20003', 'Requirements Analysis and Modelling', '12.50', 'Systems Analysis', 'C103'),
('INF20012', 'Enterprise Systems', '12.50', 'Systems Analysis', 'C102'),
('INF30001', 'Systems Acquisition & Implementation Management', '12.50', 'Systems Analysis', 'C104'),
('TNE10005', 'Network Administration', '12.50', 'Software Development', 'C102');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `analysis`
--
ALTER TABLE `analysis`
  ADD PRIMARY KEY (`analysisId`),
  ADD KEY `subId` (`subId`);

--
-- Indexes for table `convenors`
--
ALTER TABLE `convenors`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD PRIMARY KEY (`studentId`,`code`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `entity`
--
ALTER TABLE `entity`
  ADD PRIMARY KEY (`entityId`),
  ADD KEY `subId` (`subId`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `stuId` (`stuId`),
  ADD KEY `unitCode` (`unitCode`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`code`),
  ADD KEY `convenorID` (`convenorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analysis`
--
ALTER TABLE `analysis`
  MODIFY `analysisId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity`
--
ALTER TABLE `entity`
  MODIFY `entityId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100072;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD CONSTRAINT `enrolment_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `students` (`UserId`),
  ADD CONSTRAINT `enrolment_ibfk_2` FOREIGN KEY (`code`) REFERENCES `unit` (`code`);

--
-- Constraints for table `submission`
--
ALTER TABLE `submission`
  ADD CONSTRAINT `submission_ibfk_1` FOREIGN KEY (`stuId`) REFERENCES `students` (`UserId`),
  ADD CONSTRAINT `submission_ibfk_2` FOREIGN KEY (`unitCode`) REFERENCES `unit` (`code`);

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`convenorID`) REFERENCES `convenors` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
