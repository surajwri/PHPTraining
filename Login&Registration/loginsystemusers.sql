-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2019 at 11:08 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phptraining`
--

-- --------------------------------------------------------

--
-- Table structure for table `loginsystemusers`
--

CREATE TABLE IF NOT EXISTS `loginsystemusers` (
  `id` int(11) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loginsystemusers`
--

INSERT INTO `loginsystemusers` (`id`, `fname`, `lname`, `email`, `password`, `hash`, `active`) VALUES
(18, 'Suraj', 'Kumar', 'suraj6472@gmail.com', '$2y$10$JYvLuc1tEEph9jBF3A38JuEwUAf7297Tr6Ws24gkhhW.e/qj1.yJy', 'eb6fdc36b281b7d5eabf33396c2683a2', '0'),
(19, 'Suraj', 'Kumar', 'suraj.wri232@webreinvent.com', '$2y$10$/VFzbAnu40nfZ5AzQcDCtOtKEZIiiER0gwoXwwxpr/WdGCvjiz1d6', '96b9bff013acedfb1d140579e2fbeb63', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loginsystemusers`
--
ALTER TABLE `loginsystemusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loginsystemusers`
--
ALTER TABLE `loginsystemusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
