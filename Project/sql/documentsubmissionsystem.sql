-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2022 at 09:05 AM
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
  `Role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`UserId`, `Name`, `Email`, `Password`, `Role`) VALUES
('A101', 'Admin', 'admin101@swin.edu.au', 'swin', 'Admin');

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
  `Gender` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `convenors`
--

INSERT INTO `convenors` (`UserId`, `Name`, `Email`, `Password`, `Role`, `Gender`) VALUES
('C101', 'Jun Han', 'jhan@swin.edu.au', 'swin', 'Convenor', 'Male'),
('C102', 'Bao Quoc Vo', 'bvo@swin.edu.au', 'swin', 'Convenor', 'Male'),
('C103', 'Karola von Baggo', 'kvonbaggo@swin.edu.au', 'swin', 'Convenor', 'Female'),
('C104', 'Jason Sargent', 'jpsargent@swin.edu.au', 'swin', 'Convenor', 'Male');

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
('101225244', 'Adrian Sim', '101225244@student.swin.edu.au', 'swin', 'Student', 'Male'),
('101231636', 'Jun Wee', '101231636@student.swin.edu.au', 'swin', 'Student', 'Male'),
('102426323', 'Yovinma Konara', '102426323@student.swin.edu.au', 'swin', 'Student', 'Female'),
('102849357', 'Sandali Jayasinghe', '102849357@student.swin.edu.au', 'swin', 'Student', 'Female'),
('103340644', 'Richard Ly', '103340644@student.swin.edu.au', 'swin', 'Student', 'Male'),
('103698851', 'Xin Zhe', '103698851@student.swin.edu.au', 'swin', 'Student', 'Male');

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
-- Indexes for table `convenors`
--
ALTER TABLE `convenors`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`code`),
  ADD KEY `convenorID` (`convenorID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`convenorID`) REFERENCES `convenors` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
