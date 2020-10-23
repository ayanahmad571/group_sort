-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2018 at 10:37 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `science_groups`
--
CREATE DATABASE IF NOT EXISTS `science_groups` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `science_groups`;

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_unique_subject`
-- (See below for the actual view)
--
CREATE TABLE `student_unique_subject` (
`ssm_id` int(255)
,`ssm_rel_stu_id` int(255)
,`ssm_rel_sub_id` int(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `students_list`
--

CREATE TABLE `students_list` (
  `stu_id` int(255) NOT NULL,
  `stu_name` varchar(698) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_list`
--

INSERT INTO `students_list` (`stu_id`, `stu_name`) VALUES
(1, 'Ayan Ahmad'),
(2, 'Dummy Student 1'),
(3, 'Dummy Student 2'),
(4, 'Dummy Student 3'),
(5, 'Dummy Student 4'),
(6, 'Dummy Student 5'),
(7, 'Dummy Student 6'),
(8, 'Dummy Student 7'),
(9, 'Dummy Student 8'),
(10, 'Dummy Student 9');

-- --------------------------------------------------------

--
-- Table structure for table `sub_stu_mapping`
--

CREATE TABLE `sub_stu_mapping` (
  `ssm_id` int(255) NOT NULL,
  `ssm_rel_stu_id` int(255) NOT NULL,
  `ssm_rel_sub_id` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_stu_mapping`
--

INSERT INTO `sub_stu_mapping` (`ssm_id`, `ssm_rel_stu_id`, `ssm_rel_sub_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 2, 1),
(5, 3, 2),
(6, 3, 4),
(7, 4, 1),
(8, 4, 4),
(9, 5, 1),
(10, 5, 2),
(11, 5, 3),
(12, 5, 4),
(13, 6, 3),
(14, 7, 4),
(15, 8, 2),
(16, 9, 1),
(17, 10, 1),
(18, 10, 2),
(19, 10, 3),
(20, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `subjects_master`
--

CREATE TABLE `subjects_master` (
  `sub_id` int(255) NOT NULL,
  `sub_name` varchar(698) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects_master`
--

INSERT INTO `subjects_master` (`sub_id`, `sub_name`) VALUES
(1, 'Chem'),
(2, 'Physics'),
(3, 'Bio'),
(4, 'CS');

-- --------------------------------------------------------

--
-- Structure for view `student_unique_subject`
--
DROP TABLE IF EXISTS `student_unique_subject`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_unique_subject`  AS  select `sub_stu_mapping`.`ssm_id` AS `ssm_id`,`sub_stu_mapping`.`ssm_rel_stu_id` AS `ssm_rel_stu_id`,`sub_stu_mapping`.`ssm_rel_sub_id` AS `ssm_rel_sub_id` from `sub_stu_mapping` group by `sub_stu_mapping`.`ssm_rel_stu_id` order by `sub_stu_mapping`.`ssm_rel_sub_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students_list`
--
ALTER TABLE `students_list`
  ADD PRIMARY KEY (`stu_id`);

--
-- Indexes for table `sub_stu_mapping`
--
ALTER TABLE `sub_stu_mapping`
  ADD PRIMARY KEY (`ssm_id`);

--
-- Indexes for table `subjects_master`
--
ALTER TABLE `subjects_master`
  ADD PRIMARY KEY (`sub_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students_list`
--
ALTER TABLE `students_list`
  MODIFY `stu_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sub_stu_mapping`
--
ALTER TABLE `sub_stu_mapping`
  MODIFY `ssm_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `subjects_master`
--
ALTER TABLE `subjects_master`
  MODIFY `sub_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
