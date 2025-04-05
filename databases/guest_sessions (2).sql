-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 12:02 PM
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
(33, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 10:56:32'),
(34, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 12:13:04'),
(35, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 13:38:14'),
(36, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 13:51:45'),
(37, 'c7jot6lot39783s9df2cbssvft', '2025-04-04 15:41:31'),
(38, 'r3j95d3p11ldemfkvhhi3h2shd', '2025-04-04 15:42:57'),
(39, 's6s5p75vnsftakis9cmefark39', '2025-04-04 16:00:21'),
(40, 's6s5p75vnsftakis9cmefark39', '2025-04-04 16:00:47'),
(41, 'sle8stmh19gbodnc03reqpminb', '2025-04-04 16:13:22'),
(42, 'sle8stmh19gbodnc03reqpminb', '2025-04-04 16:19:50'),
(43, 'sle8stmh19gbodnc03reqpminb', '2025-04-04 16:20:22'),
(44, 'r4vf6qhqgernv0e5ic061f8oej', '2025-04-04 16:22:48'),
(45, 'r4vf6qhqgernv0e5ic061f8oej', '2025-04-04 16:25:44'),
(46, 'o0m26lkepjskm57vuho6hj6fh3', '2025-04-04 16:29:44'),
(47, 'o0m26lkepjskm57vuho6hj6fh3', '2025-04-04 16:32:14'),
(48, 'nrjkrclp8ii2ttkukasfrde4bc', '2025-04-04 16:56:37'),
(49, 'nrjkrclp8ii2ttkukasfrde4bc', '2025-04-04 16:57:36'),
(50, 'r4vf6qhqgernv0e5ic061f8oej', '2025-04-04 17:22:48'),
(51, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-04 23:46:37'),
(52, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-04 23:58:07'),
(53, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 00:03:15'),
(54, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 01:48:09'),
(55, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 01:48:19'),
(56, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 02:01:38'),
(57, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 02:07:27'),
(58, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 02:25:18'),
(59, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 02:41:59'),
(60, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 02:42:08'),
(61, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 03:59:10'),
(62, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 04:08:59'),
(63, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 04:14:29'),
(64, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 06:46:01'),
(65, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 06:47:41'),
(66, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 07:02:44'),
(67, 'jcakjbe51cbclbdd3k0cr2kpnf', '2025-04-05 07:05:31'),
(68, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 07:32:03'),
(69, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 07:34:01'),
(70, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 08:04:47'),
(71, 'v38901crgjdglf9irobbs7j40l', '2025-04-05 08:19:49'),
(72, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 08:23:05'),
(73, '4sn288lmvflrm9d7gsolr4dknb', '2025-04-05 08:29:22');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
