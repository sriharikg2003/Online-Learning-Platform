-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2022 at 09:22 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classroom`
--

-- --------------------------------------------------------


CREATE Database `classroom`;
use `classroom`;
--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `coursecode` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `announce` longtext NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `assignment_subm`
--

CREATE TABLE `assignment_subm` (
  `student_email` varchar(255) DEFAULT NULL,
  `coursecode` varchar(255) DEFAULT NULL,
  `assignment_id` varchar(255) DEFAULT NULL,
  `id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `data` mediumblob DEFAULT NULL,
  `submittedtime` varchar(255) DEFAULT NULL,
  `gotgrade` varchar(10) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `submstatus` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `classtime`
--

CREATE TABLE `classtime` (
  `courseName` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `profemail` varchar(255) DEFAULT NULL,
  `gmeetLink` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment` mediumtext NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `sender_date` datetime NOT NULL,
  `msg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `profemail` varchar(255) DEFAULT NULL,
  `coursename` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `coursecode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `marksheet`
--

CREATE TABLE `marksheet` (
  `stu_email` varchar(255) NOT NULL,
  `marks_obtained` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------------------------------------------

--
-- Table structure for table `postassignment`
--

CREATE TABLE `postassignment` (
  `profemail` varchar(255) NOT NULL,
  `coursecode` varchar(255) NOT NULL,
  `assignment_id` varchar(255) NOT NULL,
  `task` longtext NOT NULL,
  `postedtime` datetime NOT NULL,
  `deadline` datetime NOT NULL,
  `maxgrade` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `studentcourses`
--

CREATE TABLE `studentcourses` (
  `coursecode` varchar(255) NOT NULL,
  `student_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------------------------------------------

--
-- Table structure for table `submittedtest`
--

CREATE TABLE `submittedtest` (
  `student_email` varchar(255) NOT NULL,
  `test_id` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `student_answer` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `testName` varchar(255) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `profEmail` varchar(255) NOT NULL,
  `coursecode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `test_question`
--

CREATE TABLE `test_question` (
  `test_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `questionid` int(11) NOT NULL,
  `answers` varchar(255) NOT NULL,
  `qno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_question`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`coursecode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
