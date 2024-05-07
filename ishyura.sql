-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 04:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ishyura`
--

-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE `pay` (
  `payid` int(20) NOT NULL,
  `regno` varchar(50) DEFAULT NULL,
  `receiverccount` varchar(50) DEFAULT NULL,
  `amount` float(29,19) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pay`
--

INSERT INTO `pay` (`payid`, `regno`, `receiverccount`, `amount`) VALUES
(1, '21RP01262', NULL, 5000.0000000000000000000),
(2, '21RP01262', NULL, 5000.0000000000000000000),
(3, '21RP01262', NULL, 5000.0000000000000000000),
(4, '21RP01262', '40000000', 5000.0000000000000000000),
(5, '21RP01262', '400000', 5800.0000000000000000000),
(6, '21RP04900', '400000', 700000.0000000000000000000),
(7, '21RP01262', '400000', 20000.0000000000000000000),
(8, '21RP02800', '400000', 1000000.0000000000000000000),
(9, '21RP02800', '400000', 1000000.0000000000000000000),
(10, '21RP01262', '999', 70000.0000000000000000000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(20) NOT NULL,
  `names` varchar(50) DEFAULT NULL,
  `regno` varchar(50) DEFAULT NULL,
  `phoneNumber` varchar(10) DEFAULT NULL,
  `pin` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `names`, `regno`, `phoneNumber`, `pin`) VALUES
(1, 'Thabita', '2\n1RP04676', NULL, 6446),
(2, 'Clrarisse', '21RP04787', NULL, 4334),
(3, 'Clrarisse\n', '21RP04787', NULL, 4334),
(4, 'cclara', '215888', '0790989884', 8888),
(5, 'Clrarisse', '21RP04787', NULL, 78362716),
(6, 'Clrarisse', '\n21RP04787', '+250794356', 78362716);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`payid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pay`
--
ALTER TABLE `pay`
  MODIFY `payid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
