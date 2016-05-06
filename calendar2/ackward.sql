-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2016 at 09:45 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ackward`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `ID` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `start` datetime NOT NULL,
  `url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`ID`, `title`, `start`, `url`) VALUES
(1, 'CS145 Docu', '2016-05-06 23:59:59', 'http://localhost/ackward/calendar2/index.php?edit=1'),
(2, 'CS145 Dragons'' Den', '2016-05-07 10:40:00', 'http://localhost/ackward/calendar2/index.php?edit=2'),
(3, 'AUB Interview', '2016-05-11 15:00:00', 'http://localhost/ackward/calendar2/index.php?edit=3'),
(4, 'Philo LE', '2016-05-11 16:00:00', 'http://localhost/ackward/calendar2/index.php?edit=3'),
(5, 'CS130 LE3 (Yap)', '2016-05-12 16:00:00', 'http://localhost/ackward/calendar2/index.php?edit=4'),
(6, 'CS130 Finals (Nestine)', '2016-05-13 16:00:00', 'http://localhost/ackward/calendar2/index.php?edit=5'),
(7, 'CS145 LE', '2016-05-14 16:00:00', 'http://localhost/ackward/calendar2/index.php?edit=6'),
(8, 'Physics LE3', '2016-05-16 12:00:00', 'http://localhost/ackward/calendar2/index.php?edit=7');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `password` varbinary(255) NOT NULL,
	UNIQUE (name)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
