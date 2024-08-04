-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 07:04 AM
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
-- Database: `s2`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `passengers` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `order_status` enum('pending','complete','failed') NOT NULL,
  `departure_date` date DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `hours` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `location`, `passengers`, `start_date`, `order_status`, `departure_date`, `user_email`, `hours`, `created_at`, `updated_at`) VALUES
(1, 2, 'Los Angeles', 4, '2024-06-27', 'complete', '2024-06-28', 'rohit@gmail.com', '00:00:00', '2024-06-26 12:20:50', '2024-07-02 11:26:12'),
(2, 2, 'Chennai', 4, '2024-06-29', 'complete', '2024-06-30', 'rohit@gmail.com', '00:50:00', '2024-06-26 15:49:18', '2024-07-02 11:26:56'),
(21, 2, 'gujarat', 4, '2024-06-27', 'complete', '2024-06-28', 'rohit@gmail.com', '10:00:00', '2024-06-27 05:47:21', '2024-07-02 11:50:31'),
(22, 2, 'warangal', 4, '2024-06-27', 'complete', '2024-06-29', 'rohit@gmail.com', '10:00:00', '2024-06-27 05:48:57', '2024-07-02 11:50:37'),
(23, 2, 'hyderabad', 4, '2024-06-29', 'complete', '2024-06-30', 'rohit@gmail.com', '10:00:00', '2024-06-27 05:50:30', '2024-07-02 11:52:40'),
(24, 2, 'ladakh', 4, '2024-06-27', 'complete', '2024-06-28', 'rohit@gmail.com', '10:00:00', '2024-06-27 08:20:03', '2024-07-02 11:54:10'),
(25, 2, 'gujarat', 4, '2024-06-28', 'complete', '2024-06-29', 'rohit@gmail.com', '10:00:00', '2024-06-27 08:21:01', '2024-07-02 11:59:06'),
(26, 2, 'Chennai', 4, '2024-06-29', 'complete', '2024-06-30', 'rohit@gmail.com', '10:00:00', '2024-06-27 08:21:39', '2024-07-02 13:41:29'),
(27, 2, 'ladakh', 4, '2024-06-28', 'complete', '2024-06-29', 'rohit@gmail.com', '10:00:00', '2024-06-27 08:29:31', '2024-07-02 13:41:38'),
(28, 2, 'gujarat', 4, '2024-06-27', 'complete', '2024-06-29', 'rohit@gmail.com', '10:00:00', '2024-06-27 10:24:18', '2024-07-06 04:58:04'),
(29, 2, 'warangal', 4, '2024-06-28', 'complete', '2024-06-29', 'rohit@gmail.com', '10:00:00', '2024-06-27 10:44:10', '2024-07-06 04:57:48'),
(30, 3, 'gujarat', 4, '2024-06-28', 'complete', '2024-06-29', 'dheeraj@gmail.com', '10:00:00', '2024-06-28 05:34:07', '2024-07-02 11:52:49'),
(31, 2, 'hyderabad', 3, '2024-07-03', 'complete', '2024-07-05', 'rohit@gmail.com', '10:00:00', '2024-07-02 08:50:10', '2024-07-06 05:44:45'),
(32, 2, 'warangal', 4, '2024-07-03', 'complete', '2024-07-10', 'rohit@gmail.com', '10:00:00', '2024-07-02 09:10:07', '2024-07-04 04:33:01'),
(33, 2, 'warangal', 3, '2024-07-04', 'pending', '2024-07-05', 'rohit@gmail.com', '01:00:00', '2024-07-04 04:33:49', '2024-07-04 04:33:49'),
(34, 2, 'Chennai', 4, '2024-07-04', 'pending', '2024-07-05', 'rohit@gmail.com', '04:00:00', '2024-07-04 12:05:36', '2024-07-04 12:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `bookings_transaction`
--

CREATE TABLE `bookings_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL,
  `order_status` enum('pending','complete','failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `car_name` varchar(100) NOT NULL,
  `seating_capacity` int(11) NOT NULL,
  `car_category` varchar(50) NOT NULL,
  `ac_option` decimal(10,2) NOT NULL,
  `non_ac_option` decimal(10,2) NOT NULL,
  `cancellation_policy` varchar(255) NOT NULL,
  `image_path` blob NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `location` varchar(255) DEFAULT NULL,
  `likes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `car_name`, `seating_capacity`, `car_category`, `ac_option`, `non_ac_option`, `cancellation_policy`, `image_path`, `uploaded_by`, `created_at`, `location`, `likes`) VALUES
(5, 'Hyundai', 4, 'Sedan', 1500.00, 500.00, 'NO', 0x75706c6f6164732f63617231332e6a7067, 8, '2024-06-30 05:24:24', 'Warangal', 0),
(6, 'mahindra xuv 600', 5, 'SUV', 2500.00, 2000.00, 'YES', 0x75706c6f6164732f63617232382e6a7067, 8, '2024-06-30 05:59:20', 'Warangal', 0),
(7, 'Nissan', 2, 'Sedan', 1500.00, 1998.00, 'NO', 0x75706c6f6164732f636172312e6a7067, 8, '2024-07-01 05:30:49', 'Warangal', 0),
(8, 'Etios', 4, 'Sedan', 2000.00, 1500.00, 'NO', 0x75706c6f6164732f636172332e6a7067, 8, '2024-07-02 13:21:04', 'Mumbai', 0),
(9, 'Maruti Shift Dzire', 4, 'Compact', 2000.00, 1500.00, 'NO', 0x75706c6f6164732f636172342e6a7067, 8, '2024-07-02 13:23:37', 'Ladakh', 0),
(10, 'BMW', 4, 'Sedan', 3000.00, 2000.00, 'NO', 0x75706c6f6164732f636172352e6a7067, 8, '2024-07-02 13:26:58', 'Kolkata', 0),
(12, 'Mahindra Scorpio', 2, 'SUV', 2500.00, 2000.00, 'NO', 0x75706c6f6164732f63617231312e6a7067, 8, '2024-07-02 14:33:17', 'Goa', 0),
(14, 'Hyndai creta', 3, 'SUV', 3000.00, 2000.00, 'NO', 0x75706c6f6164732f63617231332e6a7067, 8, '2024-07-02 14:53:35', 'Hanmakonda', 0),
(15, 'Mahendra Scorpio', 4, 'SUV', 3000.00, 2000.00, 'YES', 0x75706c6f6164732f63617231342e6a7067, 8, '2024-07-02 15:39:33', 'Hanmakonda', 0);

-- --------------------------------------------------------

--
-- Table structure for table `car_images`
--

CREATE TABLE `car_images` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_primary` tinyint(1) DEFAULT 0,
  `caption` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_users`
--

CREATE TABLE `temp_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_users`
--

INSERT INTO `temp_users` (`id`, `username`, `email`, `phone_number`, `role`, `created_at`) VALUES
(1, 'rohitrohit', 'rohit@gmail.com', '7896584563', 'user', '2024-06-28 11:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `user1`
--

CREATE TABLE `user1` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'customer',
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user1`
--

INSERT INTO `user1` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `role`, `last_login`) VALUES
(1, 'kailash', 'satkuri', 'satkurikailash', 'A@gmail.com', '$2y$10$DyQYmPtKKWmfNpUCDe/an.wOmFoGQgvPBT94S7PR73SYL9/9PP1U.', 'admin', '2024-06-25 17:12:29'),
(2, 'bunny', 'star', 'bunny123', 's@gmail.com', '$2y$10$6iNGZIvLiv52oQ3cOKkOS.uJOjmJ601XEk6uZTNbbvZPeYAfFM6lW', 'customer', NULL),
(3, 'sofia', 'm', 'sofia', 'sofi@gmail.com', '$2y$10$NskAuuVrzbyvLXCQvCp5iuDXvIXdu.Pl/ymrRiCLHY0YsNPWWEMeq', 'admin', '2024-06-25 07:54:34'),
(4, 'upender', 'satkuri', 'satkuriupender', 'satkuriupender@gmail.com', '$2y$10$ov/OPm2F2qAlWU.ueczM5ua3.x3oD0YkxYstk0RSm9gOGLO0BSBv.', 'admin', '2024-06-25 17:12:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(12) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `profile_pic` blob DEFAULT 'uploads/default.png',
  `otp` varchar(6) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `phone_number`, `email`, `password`, `role`, `profile_pic`, `otp`, `verified`) VALUES
(2, 'rohitrohit', 'rohi', 'macherla', '7896584563', 'rohit@gmail.com', 'df96220fa161767c5cbb95567855c86b', 'user', 0x75706c6f6164732f70726f66696c655f36363835316663313565376237372e33363030313634392e6a7067, NULL, 0),
(3, 'dheeraj1234', 'dheeraj', 'dheeraj', '7537987897', 'dheeraj@gmail.com', 'df96220fa161767c5cbb95567855c86b', 'user', 0x75706c6f6164732f64656661756c742e706e67, NULL, 0),
(8, 'kailash1234', 'satkuri', 'kailash', '8309740722', 'kailash@gmail.com', 'df96220fa161767c5cbb95567855c86b', 'admin', 0x75706c6f6164732f70726f66696c655f36363861613834343937343365362e36343635323434372e6a7067, NULL, 0),
(9, 'useruser123', 'user', 'user', '8309740722', 'user@gmail.com', 'df96220fa161767c5cbb95567855c86b', 'user', 0x75706c6f6164732f64656661756c742e706e67, NULL, 0),
(14, 'kailash12345', 'kailash12345', 'kailash12345', '2231321321', 'ksatkuri@gmail.com', 'df96220fa161767c5cbb95567855c86b', 'user', 0x75706c6f6164732f64656661756c742e706e67, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `fk_user_email` (`user_email`);

--
-- Indexes for table `bookings_transaction`
--
ALTER TABLE `bookings_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_car` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_uploaded_by` (`uploaded_by`);

--
-- Indexes for table `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_car_id` (`car_id`);

--
-- Indexes for table `temp_users`
--
ALTER TABLE `temp_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user1`
--
ALTER TABLE `user1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `bookings_transaction`
--
ALTER TABLE `bookings_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `car_images`
--
ALTER TABLE `car_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_users`
--
ALTER TABLE `temp_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user1`
--
ALTER TABLE `user1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_user_email` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`);

--
-- Constraints for table `bookings_transaction`
--
ALTER TABLE `bookings_transaction`
  ADD CONSTRAINT `fk_car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `fk_uploaded_by` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `fk_car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
