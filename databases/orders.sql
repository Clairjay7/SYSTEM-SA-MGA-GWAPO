-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 11:54 PM
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
-- Database: `galorpot`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` enum('Pending','Processing','Completed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `quantity`, `price`, `payment_method`, `status`, `created_at`, `updated_at`, `customer_name`) VALUES
(8, 15, 2, 901.98, 'Gcash', 'Cancelled', '2025-05-28 06:10:17', '2025-05-28 06:11:41', NULL),
(9, 11, 5, 503.75, 'Gcash', 'Completed', '2025-05-28 08:40:40', '2025-05-28 08:41:13', NULL),
(10, 11, 1, 100.75, 'Gcash', 'Completed', '2025-05-28 08:43:19', '2025-05-28 08:44:25', NULL),
(11, 11, 2, 100.75, 'Gcash', 'Pending', '2025-05-28 08:50:26', '2025-05-28 08:50:26', NULL),
(12, 12, 2, 2001.50, 'Gcash', 'Pending', '2025-05-28 08:56:45', '2025-05-28 08:56:45', NULL),
(13, 12, 2, 1000.75, 'Gcash', 'Cancelled', '2025-05-28 09:03:00', '2025-05-28 09:08:33', NULL),
(16, 12, 2, 1000.75, 'Gcash', 'Completed', '2025-05-28 09:25:24', '2025-05-28 09:25:49', NULL),
(17, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:26:42', '2025-05-28 09:26:42', NULL),
(18, 12, 1, 1000.75, 'Paypal', 'Pending', '2025-05-28 09:28:31', '2025-05-28 09:28:31', NULL),
(19, 12, 1, 1000.75, 'Paypal', 'Pending', '2025-05-28 09:32:04', '2025-05-28 09:32:04', NULL),
(20, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:34:32', '2025-05-28 09:34:32', NULL),
(21, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:35:10', '2025-05-28 09:35:10', NULL),
(22, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:36:43', '2025-05-28 09:36:43', NULL),
(23, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:38:21', '2025-05-28 09:38:21', NULL),
(24, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:39:32', '2025-05-28 09:39:32', NULL),
(25, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:40:57', '2025-05-28 09:40:57', NULL),
(26, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:44:08', '2025-05-28 09:44:08', NULL),
(27, 12, 1, 1000.75, 'Cash', 'Pending', '2025-05-28 09:46:40', '2025-05-28 09:46:40', NULL),
(28, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:50:39', '2025-05-28 09:50:39', NULL),
(29, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:51:02', '2025-05-28 09:51:02', NULL),
(30, 13, 1, 555.75, 'Gcash', 'Pending', '2025-05-28 09:51:39', '2025-05-28 09:51:39', NULL),
(31, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:52:55', '2025-05-28 09:52:55', NULL),
(32, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:55:01', '2025-05-28 09:55:01', NULL),
(33, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:55:37', '2025-05-28 09:55:37', NULL),
(34, 12, 1, 1000.75, 'Cash', 'Pending', '2025-05-28 09:57:43', '2025-05-28 09:57:43', NULL),
(35, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-05-28 09:59:12', '2025-05-28 09:59:12', NULL),
(36, 12, 1, 1000.75, 'Cash', 'Completed', '2025-05-28 10:08:05', '2025-05-28 10:13:12', NULL),
(37, 12, 1, 1000.75, 'Cash', 'Pending', '2025-05-28 16:21:08', '2025-05-28 16:21:08', NULL),
(38, 35, 1, 2.00, 'Cash', 'Completed', '2025-06-03 19:12:23', '2025-06-03 20:07:53', NULL),
(39, 28, 3, 585.25, 'Cash', 'Pending', '2025-06-03 20:13:47', '2025-06-03 20:13:47', 'Bird'),
(40, 28, 3, 585.25, 'Cash', 'Cancelled', '2025-06-03 20:15:41', '2025-06-03 20:19:41', 'bird'),
(41, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-06-03 20:31:51', '2025-06-03 20:31:51', 'Henry Batong Bakal'),
(42, 12, 1, 1000.75, 'Gcash', 'Pending', '2025-06-03 20:33:35', '2025-06-03 20:33:35', 'Henry Batong Bakal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `inventory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
