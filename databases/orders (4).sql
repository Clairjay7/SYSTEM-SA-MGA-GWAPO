-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 12:03 PM
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
-- Database: `codes`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_method` enum('Cash','Paypal','Gcash') NOT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `product_name`, `quantity`, `price`, `payment_method`, `status`, `created_at`) VALUES
(1, 'User #Admin', 'Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.', 1, 100.75, 'Paypal', 'Pending', '2025-04-05 09:20:40'),
(2, 'User #Admin', 'Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP', 1, 1.00, '', 'Pending', '2025-04-05 09:21:27'),
(3, 'User #Admin', 'Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP', 1, 1.00, 'Cash', 'Pending', '2025-04-05 09:23:00'),
(4, 'User #Admin', 'Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars', 1, 555.75, 'Cash', 'Completed', '2025-04-05 09:24:00'),
(5, 'User #Admin', 'Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP', 1, 1.00, 'Paypal', 'Pending', '2025-04-05 09:24:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
