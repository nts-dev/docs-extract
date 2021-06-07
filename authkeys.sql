-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2021 at 09:45 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nts_projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `authkeys`
--

CREATE TABLE `authkeys` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authkeys`
--

INSERT INTO `authkeys` (`id`, `name`, `path`) VALUES
(4, 'credentials.json', 'C:/xampp/htdocs/CourseFiles/Keys/credentials.json'),
(5, 'spartan-figure-314809-19ee466b1152.json', 'C:/xampp/htdocs/CourseFiles/Keys/spartan-figure-314809-19ee466b1152.json');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authkeys`
--
ALTER TABLE `authkeys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authkeys`
--
ALTER TABLE `authkeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
