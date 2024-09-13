-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2024 at 08:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kgbdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `category_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_id`) VALUES
(1, 'fighter_jets', NULL),
(2, 'nuclear_bombs', NULL),
(3, 'balastic_missiles', NULL),
(4, 'battle_tanks', NULL),
(5, 'submarines', NULL),
(6, 'aircraft_carriers', NULL),
(7, 'helicopters', NULL),
(8, 'air_defence_systems', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `buy_price`, `sale_price`, `category_id`, `date`) VALUES
(2, 'MIG-31', '150', 90.00, 450.00, 1, '2024-09-04 18:44:52'),
(3, 'TSAR-1', '15', 1500.00, 3500.00, 2, '2024-09-04 18:48:53'),
(4, 'TSAR-2', '6', 5000.00, 10000.00, 2, '2024-09-04 19:03:23'),
(5, 'Hypersonic', '750', 1.00, 1.50, 3, '2024-09-04 19:11:30'),
(6, 'Cruise', '1400', 1.50, 3.00, 3, '2024-09-04 19:13:35'),
(7, 'T-90', '1200', 30.00, 70.00, 4, '2024-09-04 19:15:38'),
(8, 'T-50', '650', 18.00, 36.00, 4, '2024-09-04 19:17:11'),
(9, 'TypHoon', '12', 1400.00, 4000.00, 5, '2024-09-04 19:19:20'),
(10, 'Nerpa', '3', 1500.00, 4500.00, 5, '2024-09-04 19:20:28'),
(11, 'Krylov', '2', 1020.00, 2050.00, 6, '2024-09-04 19:25:22'),
(12, 'Shtorm', '3', 1000.00, 1900.00, 6, '2024-09-04 19:48:01'),
(13, 'MI-26', '480', 2.00, 5.00, 7, '2024-09-04 19:49:00'),
(14, 'MI-24', '660', 1.00, 4.00, 7, '2024-09-04 19:50:00'),
(15, 'S-400', '960', 1.00, 1.50, 8, '2024-09-04 19:50:00'),
(16, 'S-200', '850', 1.00, 1.30, 8, '2024-09-04 19:50:00'),
(18, 'SU-57', '15', 150.00, 250.00, 1, '2024-09-13 01:02:00'),
(19, 'SU-35', '20', 40.00, 90.00, 1, '2024-09-13 05:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `user_level`) VALUES
(1, 'admin', '$2y$10$Q7.HH.h3Aed1RBaAJN1KBu/YGdCx8gNh4pb4uC/oDbwvpVEP8zOFu', 'Admin', 1),
(2, 'hasith', '$2y$10$WHSREWj4Ty7ja4LuytgIXeYzv/D7TuIBUNVDkeVYCGzrTjnEdytuu', 'Hasith', 3),
(6, 'uoc', '$2y$10$vRCxKvWUCYFWSPNS7.7d6.5BWihn4EOsCB6q0C4d3K3nlxd25QJdy', 'University of Colombo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'special', 2, 1),
(3, 'User', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `FK_products` (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
