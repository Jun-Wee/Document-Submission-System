-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2022 at 07:49 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS DocumentSubmissionSystem;
USE DocumentSubmissionSystem;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `documentsubmissionsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `Code` varchar(8) NOT NULL,
  `Description` char(100) DEFAULT NULL,
  `ConvenorID` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`Code`, `Description`, `ConvenorID`) VALUES
('ICT10001', 'Problem Solving with ICT', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Gender` char(6) DEFAULT NULL
) ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Name`, `Email`, `Password`, `Role`, `Gender`) VALUES
('101225244', 'Adrian Sim', '101225244@student.swin.edu.au', 'swin', 'Student', 'Male'),
('101231636', 'Jun Wee', '101231636@student.swin.edu.au', 'swin', 'Student', 'Male'),
('102426323', 'Yovinma Konara', '102426323@student.swin.edu.au', 'swin', 'Student', 'Female'),
('102849357', 'Sandali Jayasinghe', '102849357@student.swin.edu.au', 'swin', 'Student', 'Female'),
('103340644', 'Richard Ly', '103340644@student.swin.edu.au', 'swin', 'Student', 'Male'),
('103698851', 'Xin Zhe', '103698851@student.swin.edu.au', 'swin', 'Student', 'Male'),
('A101', 'Admin', 'admin101@admin.swin.edu.au', 'swin', 'Admin', 'Male'),
('C101', 'Jun Han', 'jhan@swin.edu.au', 'swin', 'Convenor', 'Male'),
('C102', 'Bao Quoc Vo', 'bvo@swin.edu.au', 'swin', 'Convenor', 'Male'),
('C103', 'Karola von Baggo', 'kvonbaggo@swin.edu.au', 'swin', 'Convenor', 'Female'),
('C104', 'Jason Sargent', 'jpsargent@swin.edu.au', 'swin', 'Convenor', 'Male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`Code`),
  ADD UNIQUE KEY `ConvenorID` (`ConvenorID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
