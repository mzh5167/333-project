-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 23, 2022 at 08:05 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `pid` int(11) NOT NULL,
  `date` date NOT NULL,
  `timeslot` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`pid`, `date`, `timeslot`) VALUES
(1, '2022-12-11', 1),
(1, '2022-12-14', 27),
(1, '2022-12-15', 60431),
(1, '2022-12-16', 49151),
(1, '2022-12-20', 7),
(1, '2022-12-22', 1),
(2, '2022-12-14', 2023),
(2, '2022-12-15', 12596),
(2, '2022-12-22', 6);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `pid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` text NOT NULL,
  `category` enum('vr','gaming','billiard','room') NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`pid`, `name`, `address`, `image`, `description`, `location`, `category`, `price`) VALUES
(1, 'Gaming Place 1', '??', 'img.png', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s', '??', 'gaming', 12),
(2, 'Billiard Abo Ali', '??', 'brazil.png', 'Prepares an SQL statement to be executed by the PDOStatement::execute() method. The statement template can contain zero or more named (:name) or question mark (?) parameter markers for which real values will be substituted when the statement is executed. Both named and question mark parameter markers cannot be used within the same statement template; only one or the other parameter style. Use these parameters to bind any user-input, do not include the user-input directly in the query.', '??', 'billiard', 8);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `rid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` enum('8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23') NOT NULL,
  `hours` enum('1','2','3','') NOT NULL,
  `rating` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`rid`, `uid`, `pid`, `date`, `time`, `hours`, `rating`) VALUES
(1, 1, 1, '2022-12-15', '21', '3', NULL),
(2, 1, 1, '2022-12-11', '8', '1', NULL),
(3, 1, 1, '2022-12-16', '8', '3', 4),
(4, 1, 1, '2022-12-16', '19', '1', NULL),
(5, 1, 1, '2022-12-16', '11', '3', NULL),
(6, 1, 1, '2022-12-16', '23', '1', NULL),
(7, 1, 1, '2022-12-16', '16', '3', NULL),
(8, 1, 1, '2022-12-16', '14', '2', NULL),
(9, 1, 1, '2022-12-16', '20', '2', NULL),
(10, 1, 1, '2022-12-20', '8', '3', NULL),
(11, 2, 1, '2022-12-22', '8', '1', 3),
(12, 2, 2, '2022-12-22', '9', '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `fname` varchar(15) NOT NULL,
  `lname` varchar(15) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `fname`, `lname`, `phone`, `email`, `password`) VALUES
(1, 'john', 'cena', '33445566', 'johncena@gmail.com', ''),
(2, 'the', 'wok', '33333333', 'wok@gmail.com', '$2y$10$IiKzpbVuQrK2j4xOVfsroOntrvIWqscubNbFRCvLH/v2sSwWfZi.S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`pid`,`date`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`pid`,`uid`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `pidr` (`pid`),
  ADD KEY `uidr` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `pida` FOREIGN KEY (`pid`) REFERENCES `places` (`pid`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `pidc` FOREIGN KEY (`pid`) REFERENCES `places` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uidc` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `pidr` FOREIGN KEY (`pid`) REFERENCES `places` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uidr` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
