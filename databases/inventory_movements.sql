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
-- Table structure for table `inventory_movements`
--

CREATE TABLE `inventory_movements` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `type` enum('in','out') NOT NULL,
  `reference_id` int(11) NOT NULL,
  `reference_type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_movements`
--

INSERT INTO `inventory_movements` (`id`, `product_id`, `quantity`, `type`, `reference_id`, `reference_type`, `created_at`) VALUES
(9, 12, -2, 'out', 16, 'completed_order', '2025-05-28 09:25:49'),
(10, 12, -1, 'out', 36, 'completed_order', '2025-05-28 10:13:12'),
(11, 35, -1, 'out', 38, 'completed_order', '2025-06-03 19:12:42'),
(12, 35, 1, 'in', 38, 'refund', '2025-06-03 19:13:48'),
(13, 35, -1, 'out', 38, 'completed_order', '2025-06-03 19:15:49'),
(14, 35, 1, 'in', 38, 'refund', '2025-06-03 19:35:52'),
(15, 35, -1, 'out', 38, 'completed_order', '2025-06-03 20:07:53'),
(16, 28, -3, 'out', 40, 'completed_order', '2025-06-03 20:19:10'),
(17, 28, 3, 'in', 40, 'refund', '2025-06-03 20:19:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `idx_movements_product` (`product_id`),
  ADD KEY `idx_movements_reference` (`reference_type`,`reference_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
