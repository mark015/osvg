-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 03:09 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osvg`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `type_act` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL,
  `crop_id` varchar(255) NOT NULL,
  `particulars` varchar(255) NOT NULL,
  `pictures` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `type_act`, `date_time`, `crop_id`, `particulars`, `pictures`) VALUES
(9, 'dsa', '2024-12-15 13:30:00', '1', 'eqwewq', 'icon-person.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `crop_info`
--

CREATE TABLE `crop_info` (
  `id` int(11) NOT NULL,
  `crop_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `growing_season` varchar(255) NOT NULL,
  `watering_needs` varchar(255) NOT NULL,
  `planting_technique` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_info`
--

INSERT INTO `crop_info` (`id`, `crop_name`, `type`, `growing_season`, `watering_needs`, `planting_technique`, `duration`) VALUES
(1, 'Cabbagews', '3', '1', '1', '1', '250'),
(2, 'Manggo', '3', '1', '1', '1', '30');

-- --------------------------------------------------------

--
-- Table structure for table `crop_type`
--

CREATE TABLE `crop_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_type`
--

INSERT INTO `crop_type` (`id`, `type`) VALUES
(1, 'Vegetable'),
(3, 'Fruits');

-- --------------------------------------------------------

--
-- Table structure for table `growing_season`
--

CREATE TABLE `growing_season` (
  `id` int(11) NOT NULL,
  `season` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `growing_season`
--

INSERT INTO `growing_season` (`id`, `season`) VALUES
(1, 'Warm Season');

-- --------------------------------------------------------

--
-- Table structure for table `planting_technique`
--

CREATE TABLE `planting_technique` (
  `id` int(11) NOT NULL,
  `technique` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `planting_technique`
--

INSERT INTO `planting_technique` (`id`, `technique`) VALUES
(1, 'Direct Seeding');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`) VALUES
(1, 'Mark Balinario', 'admin', '8d4db54daf7d67db5f3c96e43f61c609', 'Admin'),
(2, 'mark', 'mbdev', '464da487a0286c0b7c1f00e5ed3de7d1', 'User'),
(3, 'user2', 'user2', '464da487a0286c0b7c1f00e5ed3de7d1', 'User2');

-- --------------------------------------------------------

--
-- Table structure for table `watering_needs`
--

CREATE TABLE `watering_needs` (
  `id` int(11) NOT NULL,
  `needs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watering_needs`
--

INSERT INTO `watering_needs` (`id`, `needs`) VALUES
(1, 'Drought-tolerant');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_info`
--
ALTER TABLE `crop_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_type`
--
ALTER TABLE `crop_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `growing_season`
--
ALTER TABLE `growing_season`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `planting_technique`
--
ALTER TABLE `planting_technique`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watering_needs`
--
ALTER TABLE `watering_needs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `crop_info`
--
ALTER TABLE `crop_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `crop_type`
--
ALTER TABLE `crop_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `growing_season`
--
ALTER TABLE `growing_season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `planting_technique`
--
ALTER TABLE `planting_technique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `watering_needs`
--
ALTER TABLE `watering_needs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
