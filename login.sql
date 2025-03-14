-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2025 at 01:38 PM
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
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `phone` int(225) NOT NULL,
  `venue` varchar(225) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `status` enum('pending','approved','declined','') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `name`, `email`, `phone`, `venue`, `booking_date`, `booking_time`, `status`, `created_at`) VALUES
(1, 13, 'Aarya Baniya', 'aaryabaniya12@gmail.com', 2147483647, 'Majestic Hall', '2025-03-12', '18:16:00', 'approved', '2025-03-07 12:28:51'),
(2, 13, 'Aarya Baniya', 'aaryabaniya12@gmail.com', 2147483647, 'Royal Chamber', '2025-03-28', '18:15:00', 'declined', '2025-03-07 12:28:55'),
(3, 14, 'Prasamsha parajuli', 'prasamshaparajuli@gmail.com', 2147483647, 'Crown Hall', '2025-03-22', '18:16:00', 'approved', '2025-03-07 12:28:58'),
(4, 14, 'Prasamsha parajuli', 'prasamshaparajuli@gmail.com', 2147483647, 'Golden Terrace', '2025-03-28', '18:12:00', 'declined', '2025-03-07 12:29:03'),
(5, 15, 'Ashesh Poudel', 'asheshp86@gmail.com', 2147483647, 'Majestic Hall', '2025-03-19', '06:16:00', 'approved', '2025-03-07 12:29:05'),
(6, 16, 'salina lama', 'salina@gmail.com', 2147483647, 'Crown Hall', '2025-03-28', '18:21:00', 'approved', '2025-03-07 12:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(225) NOT NULL,
  `fullname` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` enum('admin','user','','') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `fullname`, `email`, `password`, `role`) VALUES
(7, 'Admin User', 'admin@example.com', '$2y$10$a1ZEMt8qDgvtlE.GQMfUC.gW0tlxp0sH9VNSOL03q6n8wcLmKb5gG', 'admin'),
(13, 'Aarya Baniya', 'aaryabaniya12@gmail.com', '$2y$10$cIrLmWX7SlAwCHrc7a/1zeEI5vrJnHiMT37LRtwbuqYvRfOAwf3/q', 'user'),
(14, 'Prasamsha parajuli', 'prasamshaparajuli@gmail.com', '$2y$10$3CVXo.Y7dtEXPitaPVXu8OeQRlU2b6tjB4YgLzmJB1sc93EOQxpfa', 'user'),
(15, 'Ashesh Poudel', 'asheshp86@gmail.com', '$2y$10$p1.lqsUZFFiajRDoNtOTPuyfovUXXoQ1INyc23GAIB82q3nntJSqe', 'user'),
(16, 'salina lama', 'salina@gmail.com', '$2y$10$E1/R2BPAsBynGxRTGO5hcuXDB1okMomTbYeqJFpfZxDDIfC8WVvQq', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `id` int(100) NOT NULL,
  `name` varchar(225) NOT NULL,
  `capacity` int(225) NOT NULL,
  `description` varchar(225) NOT NULL,
  `image_path` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`id`, `name`, `capacity`, `description`, `image_path`) VALUES
(1, 'Royal Chamber', 100, 'A luxurious, elegant venue designed to make your special day feel fit for royalty. Its majestic décor and refined ambiance make it the perfect choice for weddings or milestone birthday celebrations.', 'uploads/venue_67cae4e30ad730.87486259.jpg'),
(2, 'Golden Terrace', 200, 'With a touch of glamour and sophistication, Golden Terrace features a stunning golden theme that adds warmth and grandeur to any wedding or birthday event. Perfect for those looking for a golden celebration.', 'uploads/venue_67cae5021702c6.64841595.jpg'),
(3, 'Majestic Hall', 150, 'A grand venue with a royal feel, Majestic Hall is perfect for couples and individuals looking to celebrate a wedding or birthday in an atmosphere of magnificence and luxury.', 'uploads/venue_67cae528744524.02625373.jpg'),
(4, 'Crown Hall', 200, 'With its regal charm and refined interiors, Crown Hall offers a truly royal experience for weddings and birthday events. This venue is fit for those who want to celebrate in style and grandeur.', 'uploads/venue_67cae5a56035e2.03955708.jpg'),
(5, 'Garden hall', 200, 'With regal charm and refined interiors, Crown Hall offers a truly royal experience for weddings and birthday events. This venue is fit for those who want to celebrate in style and grandeur.', 'uploads/venue_67cae79bf1f2f7.47575861.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
