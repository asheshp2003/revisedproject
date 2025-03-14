-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 11:22 AM
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
  `status` enum('pending','approved','declined','') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `name`, `email`, `phone`, `venue`, `booking_date`, `status`, `created_at`, `start_time`, `end_time`) VALUES
(11, 13, 'Aarya Baniya', 'aaryabaniya12@gmail.com', 2147483647, 'Royal Chamber', '2025-03-20', 'approved', '2025-03-09 04:41:42', '09:43:00', '10:45:00'),
(12, 22, 'Prasamsha parajuli', 'prasamshaparajuli@gmail.com', 2147483647, 'Royal Chamber', '2025-03-10', 'approved', '2025-03-09 04:33:23', '17:12:00', '22:32:00'),
(13, 23, 'Tenzin Palki', 'tenzin@gmail.com', 2147483647, 'Terrace hall', '2025-03-28', 'approved', '2025-03-09 04:40:48', '10:25:00', '22:25:00'),
(14, 24, 'Ashesh Poudel', 'asheshp22@gmail.com', 2147483647, 'Terrace hall', '2025-03-11', 'pending', '2025-03-09 06:23:35', '00:11:00', '12:11:00'),
(15, 25, 'Sudip Aryal', 'sudip123@gmail.com', 2147483647, 'Crown Hall', '2025-03-10', 'approved', '2025-03-09 06:52:40', '16:36:00', '16:37:00');

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
(22, 'Prasamsha parajuli', 'prasamshaparajuli@gmail.com', '$2y$10$qfKFJ2ADtUGsMY3Pp6kcDufLNKe5v73HsG/eTwXDheO6j/HQPpCpG', 'user'),
(23, 'Tenzin Palki', 'tenzin@gmail.com', '$2y$10$jDfWpe.ZHtBoszByGFQAs.LrLfyNJI0Zn.gtwNcwskRgXFi4Jv1vC', 'user'),
(24, 'Ashesh Poudel', 'asheshp22@gmail.com', '$2y$10$3Olsr5/591MicWQCKCHycuPipwjYnCcZq2Q46dBzBeodKy/A5PZ72', 'user'),
(25, 'Sudip Aryal', 'sudip123@gmail.com', '$2y$10$MNkotlsgMbIFs4N1TNTTlemq7.xmuzOkykQPx0pDce/FuAwce6tVq', 'user');

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
(5, 'Garden hall', 300, 'With regal charm and refined interiors, Crown Hall offers a truly royal experience for weddings and birthday events. This venue is fit for those who want to celebrate in style and grandeur.', 'uploads/venue_67cae79bf1f2f7.47575861.jpg'),
(6, 'Terrace hall', 102, 'With breathtaking views and modern interiors, Horizon Hall  offers a fresh, contemporary setting for weddings and birthdays. Perfect for those who want a wide-open space to create unforgettable memories.', 'uploads/venue_67caebafaba932.64087553.jpg'),
(7, 'Golden Bliss', 100, 'Celebrate your love in a space that radiates warmth and elegance. Golden Bliss Wedding Hall offers a luxurious atmosphere with a golden touch. Featuring spacious interiors, modern amenities, and exceptional service, your wedd', 'uploads/venue_67cd158f1c1454.08863683.jpg'),
(9, 'Crown Hall', 100, 'With breathtaking views and modern interiors, Horizon Hall offers a fresh, contemporary setting for weddings and birthdays. Perfect for those who want a wide-open space to create unforgettable memories.', 'uploads/venue_67cd6aa6a5f807.24457130.jpg');

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
