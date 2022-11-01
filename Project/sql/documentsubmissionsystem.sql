-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: documentsubmissionsystem.c2tnrfke8bpv.us-east-1.rds.amazonaws.com    Database: documentsubmissionsystem
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `UserId` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Gender` char(6) DEFAULT NULL,
  `isSubscribe` tinyint(1) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('A101','Admin','admin101@swin.edu.au','swin','Admin',NULL,0);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analysis`
--

DROP TABLE IF EXISTS `analysis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analysis` (
  `analysisId` int NOT NULL AUTO_INCREMENT,
  `subId` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `summary` varchar(200) DEFAULT NULL,
  `sentimentScore` float DEFAULT NULL,
  `sentimentMagnitude` float DEFAULT NULL,
  PRIMARY KEY (`analysisId`),
  KEY `subId` (`subId`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `convenors`
--

DROP TABLE IF EXISTS `convenors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `convenors` (
  `UserId` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Gender` char(6) DEFAULT NULL,
  `isSubscribe` tinyint(1) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `convenors`
--

LOCK TABLES `convenors` WRITE;
/*!40000 ALTER TABLE `convenors` DISABLE KEYS */;
INSERT INTO `convenors` VALUES ('C101','Jun Han','101225244@student.swin.edu.au','swin','Convenor','Male',1),('C102','Bao Quoc Vo','101231636@student.swin.edu.au','swin','Convenor','Male',1),('C103','Karola von Baggo','kvonbaggo@swin.edu.au','swin','Convenor','Female',0),('C104','Jason Sargent','jpsargent@swin.edu.au','swin','Convenor','Male',0);
/*!40000 ALTER TABLE `convenors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrolment`
--

DROP TABLE IF EXISTS `enrolment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enrolment` (
  `studentId` varchar(10) NOT NULL,
  `code` varchar(8) NOT NULL,
  PRIMARY KEY (`studentId`,`code`),
  KEY `code` (`code`),
  CONSTRAINT `enrolment_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `students` (`UserId`),
  CONSTRAINT `enrolment_ibfk_2` FOREIGN KEY (`code`) REFERENCES `unit` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrolment`
--

LOCK TABLES `enrolment` WRITE;
/*!40000 ALTER TABLE `enrolment` DISABLE KEYS */;
INSERT INTO `enrolment` VALUES ('101225244','ACC10007'),('102849357','ACC10007'),('101225244','ACC20014'),('102849357','ACC20014'),('101225244','COS10005'),('102849357','COS10005'),('101225244','COS10009'),('102849357','COS10009'),('101231636','COS20001'),('103340644','COS20001'),('101231636','COS20016'),('103340644','COS20016'),('101231636','ICT10001'),('103340644','ICT10001'),('101231636','INF10002'),('103340644','INF10002'),('102426323','INF20003'),('103698851','INF20003'),('102426323','INF20012'),('103698851','INF20012'),('102426323','INF30001'),('103698851','INF30001'),('102426323','TNE10005'),('103698851','TNE10005');
/*!40000 ALTER TABLE `enrolment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity`
--

DROP TABLE IF EXISTS `entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entity` (
  `entityId` int NOT NULL AUTO_INCREMENT,
  `subId` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `salience` double DEFAULT NULL,
  `link` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`entityId`),
  KEY `subId` (`subId`)
) ENGINE=InnoDB AUTO_INCREMENT=582 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question` (
  `submissionId` int NOT NULL,
  `questionNum` int NOT NULL,
  `stuAnswer` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `context` varchar(255) NOT NULL,
  `options` varchar(255) NOT NULL,
  `statement` varchar(255) NOT NULL,
  PRIMARY KEY (`submissionId`,`questionNum`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`submissionId`) REFERENCES `submission` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reference`
--

DROP TABLE IF EXISTS `reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reference` (
  `referenceId` int NOT NULL,
  `subId` int NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `UserId` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Gender` char(6) DEFAULT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES ('101225244','Adrian Sim','101225244@student.swin.edu.au','swin','Student','Male'),('101228765','vovo','vovo@swinburne.edu.au','swin','Student','male'),('101231636','Jun Wee','101231636@student.swin.edu.au','swin','Student','Male'),('102426323','Yovinma Konara','102426323@student.swin.edu.au','swin','Student','Female'),('102849357','Sandali Jayasinghe','102849357@student.swin.edu.au','swin','Student','Female'),('103340644','Richard Ly','103340644@student.swin.edu.au','swin','Student','Male'),('103698851','Xin Zhe','103698851@student.swin.edu.au','swin','Student','Male');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission`
--

DROP TABLE IF EXISTS `submission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `stuId` varchar(10) NOT NULL,
  `datetime` datetime NOT NULL,
  `score` int NOT NULL,
  `unitCode` varchar(50) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `isSendMail` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `stuId` (`stuId`),
  KEY `unitCode` (`unitCode`),
  CONSTRAINT `submission_ibfk_1` FOREIGN KEY (`stuId`) REFERENCES `students` (`UserId`),
  CONSTRAINT `submission_ibfk_2` FOREIGN KEY (`unitCode`) REFERENCES `unit` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=100256 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unit` (
  `code` varchar(8) NOT NULL,
  `description` char(100) DEFAULT NULL,
  `cp` decimal(10,2) NOT NULL,
  `type` varchar(50) NOT NULL,
  `convenorID` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`code`),
  KEY `convenorID` (`convenorID`),
  CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`convenorID`) REFERENCES `convenors` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES ('ACC10007','Financial Information for Decision Making',12.50,'Systems Analysis','C103'),('ACC20014','Management Decision Making',12.50,'Systems Analysis','C104'),('COS10005','Web Development',12.50,'Core','C101'),('COS10009','Introduction to Programming',12.50,'Core','C101'),('COS20001','User-Centred Design',12.50,'Software Development','C102'),('COS20016','Operating System Configuration',12.50,'Software Development','C102'),('ICT10001','Problem Solving with ICT',12.50,'Core','C101'),('INF10002','Database Analysis and Design',12.50,'Core','C101'),('INF20003','Requirements Analysis and Modelling',12.50,'Systems Analysis','C103'),('INF20012','Enterprise Systems',12.50,'Systems Analysis','C102'),('INF30001','Systems Acquisition & Implementation Management',12.50,'Systems Analysis','C104'),('TNE10005','Network Administration',12.50,'Software Development','C102');
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `websearch`
--

DROP TABLE IF EXISTS `websearch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `websearch` (
  `websearchNum` int NOT NULL,
  `submissionId` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `authors` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`websearchNum`,`submissionId`),
  KEY `submissionId` (`submissionId`),
  CONSTRAINT `websearch_ibfk_1` FOREIGN KEY (`submissionId`) REFERENCES `submission` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-01 11:43:56
