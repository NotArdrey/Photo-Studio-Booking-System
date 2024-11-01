-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 04:11 AM
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
-- Database: `photostudio`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `username`, `password`) VALUES
(1, 'adad', 'adad', 'adad', '$2y$10$RxyXMtrfc/yPTyAe/LeKYugoftAgKkwKiMERdYuKwJdP12jQg8hYO'),
(2, 'Neil Ardrey', 'Laza', 'admin', '$2y$10$RktUHD6GE5u97E1p00WZf.ZCPSkmD2p0grQv6XjO5oU4HPW0o.0lu'),
(3, 'Sample Admin', 'Sample', 'admin', '$2y$10$Bwj2AeznPY2cALprqqwJIuUJc44qrqwR1Gzaj0h0JNgqk1AdWULUW');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `backdrop` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `package_type` varchar(255) NOT NULL,
  `pax` tinyint(15) NOT NULL,
  `price` int(255) NOT NULL,
  `archive` varchar(255) NOT NULL,
  `complete` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `backdrop`, `time`, `date`, `package_type`, `pax`, `price`, `archive`, `complete`) VALUES
(88, 'Sample', 'Record', 'neilardrey14@gmail.com', 'red', '10:30 AM', '2024-10-23', 'pair_package', 2, 700, 'no', 'yes'),
(89, 'Neil Ardrey', 'dadada', 'neilardrey14@gmail.com', 'red', '9:00 AM', '2024-10-24', 'pair_package', 2, 700, 'no', 'no'),
(90, 'Neil Ardrey', 'Laza', 'neilardrey14@gmail.com', 'black', '10:00 AM', '2024-10-23', 'solo_package', 1, 500, 'no', 'yes'),
(91, 'Ardrey', 'solo', 'lazanp@students.nu-baliwag.edu.ph', 'red', '10:30 AM', '2024-10-24', 'solo_package', 1, 500, 'no', 'no'),
(92, 'sample', '23', 'neilardrey14@gmail.com', 'red', '10:30 AM', '2024-10-23', 'pair_package', 2, 700, 'no', 'yes'),
(93, 'adad', 'ADAD', 'neilardrey14@gmail.com', 'black', '10:30 AM', '2024-10-23', 'solo_package', 1, 500, 'no', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
