-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 01:39 PM
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
-- Table structure for table `guest_sessions`
--

CREATE TABLE `guest_sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guest_sessions`
--

INSERT INTO `guest_sessions` (`id`, `session_id`, `created_at`) VALUES
(1, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 14:15:59'),
(2, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 14:21:59'),
(3, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 14:23:36'),
(4, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 14:24:54'),
(5, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 14:28:13'),
(6, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 14:36:11'),
(7, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 16:16:51'),
(8, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 16:17:02'),
(9, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 16:19:55'),
(10, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 16:19:57'),
(11, '8llnm91u211ol5b8rlgc8ud1id', '2025-04-03 01:37:43'),
(12, 'at9sr0v32hrbqd0br6e55r0j2s', '2025-04-03 08:27:23'),
(13, 'at9sr0v32hrbqd0br6e55r0j2s', '2025-04-03 08:27:59'),
(14, 'at9sr0v32hrbqd0br6e55r0j2s', '2025-04-03 08:34:25'),
(15, 'at9sr0v32hrbqd0br6e55r0j2s', '2025-04-03 08:38:39'),
(16, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 09:18:05'),
(17, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 09:22:57'),
(18, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 09:39:54'),
(19, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 09:48:25'),
(20, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 09:53:39'),
(21, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 09:56:01'),
(22, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 10:05:18'),
(23, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 10:28:23'),
(24, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 10:31:59'),
(25, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 10:33:47'),
(26, 'o730lpeq706ea1s6fghvosklkp', '2025-04-03 14:47:27'),
(27, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 10:39:20'),
(28, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 10:41:05'),
(29, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 10:42:02'),
(30, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 10:42:19'),
(31, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 10:52:54'),
(32, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 10:53:17'),
(33, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 10:56:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guest_sessions`
--
ALTER TABLE `guest_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guest_sessions`
--
ALTER TABLE `guest_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
