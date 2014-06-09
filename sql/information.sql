-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 09, 2014 at 12:48 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `information`
--
CREATE DATABASE IF NOT EXISTS `information` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `information`;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course` varchar(275) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`) VALUES
(9, 'Bachelor of Science in Information Technology'),
(10, 'Bachelor of Science in Information System'),
(11, 'Bachelor of Science in Caregiving Management'),
(12, 'Bachelor of Science in Industrial Technology'),
(13, 'Bachelor in Hotel and Restaurant Management'),
(14, 'Bachelor of Science in Elementary Education'),
(15, 'Bachelor of Science in Secondary Education');

-- --------------------------------------------------------

--
-- Table structure for table `course_subjects`
--

CREATE TABLE IF NOT EXISTS `course_subjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_subjects_ibfk_1` (`subject_id`),
  KEY `course_subjects_ibfk_2` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `course_subjects`
--

INSERT INTO `course_subjects` (`id`, `subject_id`, `course_id`) VALUES
(1, 19, 9),
(2, 20, 9),
(3, 19, 11),
(4, 21, 15),
(5, 21, 14),
(14, 23, 14),
(15, 23, 13),
(16, 24, 15),
(17, 24, 14);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school` varchar(275) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `school`) VALUES
(4, 'School of Information and Communications Technology'),
(8, 'School of Caregiving Management'),
(9, 'School of Industrial Technology'),
(10, 'School of Hotel and Restaurant Services Management '),
(11, 'School of Education');

-- --------------------------------------------------------

--
-- Table structure for table `school_courses`
--

CREATE TABLE IF NOT EXISTS `school_courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `school_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `school_courses_ibfk_1` (`course_id`),
  KEY `school_courses_ibfk_2` (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `school_courses`
--

INSERT INTO `school_courses` (`id`, `course_id`, `school_id`) VALUES
(30, 9, 4),
(32, 11, 8),
(33, 12, 9),
(34, 13, 10),
(35, 14, 11),
(36, 15, 11),
(37, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_no` varchar(70) NOT NULL,
  `descriptive_title` varchar(275) NOT NULL,
  `credit` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `course_no`, `descriptive_title`, `credit`) VALUES
(19, 'IT 201A', 'Word Processing w/ Keyboarding', 3),
(20, 'IT 208', 'Logic Design', 3),
(21, 'IT 231A', 'Network Administration', 3),
(23, 'IT 201D', 'Basic Computer Sys. Main. & Trouble Shooting', 3),
(24, 'IT 201-B ', 'Spreadsheet', 3),
(26, 'IT 210', 'Object-Oriented Programming in Java', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subject_teachers`
--

CREATE TABLE IF NOT EXISTS `subject_teachers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` int(10) unsigned NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_teachers_ibfk_2` (`teacher_id`),
  KEY `subject_teachers_ibfk_1` (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `subject_teachers`
--

INSERT INTO `subject_teachers` (`id`, `teacher_id`, `subject_id`) VALUES
(2, 11, 19),
(3, 12, 19),
(4, 13, 20),
(5, 11, 20);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(175) NOT NULL,
  `last_name` varchar(175) NOT NULL,
  `middle_name` varchar(175) NOT NULL,
  `address` varchar(275) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `first_name`, `last_name`, `middle_name`, `address`) VALUES
(11, 'Ariel ', 'Judilla', 'Reyes', 'Brgy. Jibolo Janiuay, Iloilo'),
(12, 'Sela', 'Leraog', 'Catinan', 'Lambunao, Iloilo'),
(13, 'azelle', 'campanan', 'grijaldo', 'Brgy.  Tamuan Janiuay, Iloilo'),
(14, 'Alma Jean', 'Subong', 'Diefe', 'Lapaz, Iloilo City');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(175) NOT NULL,
  `semester` varchar(175) NOT NULL,
  `school_year` varchar(175) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `term`, `semester`, `school_year`) VALUES
(1, '1st year', 'second', '2010-2011'),
(2, '1st year', 'first', '2010-2011');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_subjects`
--
ALTER TABLE `course_subjects`
  ADD CONSTRAINT `course_subjects_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_subjects_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `school_courses`
--
ALTER TABLE `school_courses`
  ADD CONSTRAINT `school_courses_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `school_courses_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_teachers`
--
ALTER TABLE `subject_teachers`
  ADD CONSTRAINT `subject_teachers_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
