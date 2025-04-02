-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 06:26 PM
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
(10, 'p15bbd6u6ah2ufejdk9e1gn4j4', '2025-04-02 16:19:57');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
