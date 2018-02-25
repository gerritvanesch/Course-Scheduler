-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2018 at 04:50 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scheduler`
--
CREATE DATABASE IF NOT EXISTS `scheduler` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `scheduler`;

-- --------------------------------------------------------

--
-- Table structure for table `course_info`
--

CREATE TABLE `course_info` (
  `id` int(11) NOT NULL,
  `term` int(6) NOT NULL,
  `crn` int(5) NOT NULL,
  `subj` varchar(4) NOT NULL,
  `crse` int(4) NOT NULL,
  `sec` varchar(12) NOT NULL,
  `title` varchar(50) NOT NULL,
  `cred` float NOT NULL,
  `days` varchar(7) NOT NULL,
  `time` varchar(17) NOT NULL,
  `instructor` varchar(25) NOT NULL,
  `date` varchar(11) NOT NULL,
  `location` varchar(10) NOT NULL,
  `attribute` varchar(150) NOT NULL,
  `requirements` text,
  `visible` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_info`
--
ALTER TABLE `course_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_info`
--
ALTER TABLE `course_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22380;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
