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
-- Table structure for table `guest_sessions`
--

CREATE TABLE `guest_sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_sessions`
--

INSERT INTO `guest_sessions` (`id`, `session_id`, `ip_address`, `user_agent`, `created_at`, `last_activity`, `status`) VALUES
(1, 'mjqq72oklpa7bs48ge5vt3h8s5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 13:29:20', '2025-05-26 13:29:20', 'active'),
(2, 'mjqq72oklpa7bs48ge5vt3h8s5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 13:29:30', '2025-05-26 13:29:30', 'active'),
(3, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 15:38:23', '2025-05-26 15:38:23', 'active'),
(4, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 15:41:33', '2025-05-26 15:41:33', 'active'),
(5, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 15:50:23', '2025-05-26 15:50:23', 'active'),
(6, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:08:13', '2025-05-26 16:08:13', 'active'),
(7, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:15:30', '2025-05-26 16:15:30', 'active'),
(8, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:16:51', '2025-05-26 16:16:51', 'active'),
(9, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:17:27', '2025-05-26 16:17:27', 'active'),
(10, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:19:55', '2025-05-26 16:19:55', 'active'),
(11, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:25:13', '2025-05-26 16:25:13', 'active'),
(12, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:26:10', '2025-05-26 16:26:10', 'active'),
(13, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:26:51', '2025-05-26 16:26:51', 'active'),
(14, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:34:14', '2025-05-26 16:34:14', 'active'),
(15, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 16:39:42', '2025-05-26 16:39:42', 'active'),
(16, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:04:54', '2025-05-26 17:04:54', 'active'),
(17, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:07:30', '2025-05-26 17:07:30', 'active'),
(18, '0rl9boashvj0ffc3hb4bv6q5ik', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:08:49', '2025-05-26 17:08:49', 'active'),
(19, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:09:56', '2025-05-26 17:09:56', 'active'),
(20, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:10:27', '2025-05-26 17:10:27', 'active'),
(21, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:27:01', '2025-05-26 17:27:01', 'active'),
(22, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:33:53', '2025-05-26 17:33:53', 'active'),
(23, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:34:49', '2025-05-26 17:34:49', 'active'),
(24, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:37:49', '2025-05-26 17:37:49', 'active'),
(25, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:39:47', '2025-05-26 17:39:47', 'active'),
(26, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:40:18', '2025-05-26 17:40:18', 'active'),
(27, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:42:41', '2025-05-26 17:42:41', 'active'),
(28, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:43:24', '2025-05-26 17:43:24', 'active'),
(29, 'i7unq22nlp5e9v2oni6b9fglht', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 17:44:33', '2025-05-26 17:44:33', 'active'),
(30, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 02:22:43', '2025-05-28 02:22:43', 'active'),
(31, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 06:10:05', '2025-05-28 06:10:05', 'active'),
(32, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 06:20:19', '2025-05-28 06:20:19', 'active'),
(33, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 06:23:13', '2025-05-28 06:23:13', 'active'),
(34, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 07:00:02', '2025-05-28 07:00:02', 'active'),
(35, 'b01j2cput8csoda9jc65bmtmag', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 08:39:59', '2025-05-28 08:39:59', 'active'),
(36, 'b01j2cput8csoda9jc65bmtmag', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 08:40:23', '2025-05-28 08:40:23', 'active'),
(37, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 08:43:06', '2025-05-28 08:43:06', 'active'),
(38, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 08:43:27', '2025-05-28 08:43:27', 'active'),
(39, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 08:50:09', '2025-05-28 08:50:09', 'active'),
(40, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 08:56:24', '2025-05-28 08:56:24', 'active'),
(41, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:00:20', '2025-05-28 09:00:20', 'active'),
(42, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:02:30', '2025-05-28 09:02:30', 'active'),
(43, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:03:45', '2025-05-28 09:03:45', 'active'),
(44, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:04:12', '2025-05-28 09:04:12', 'active'),
(45, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:05:00', '2025-05-28 09:05:00', 'active'),
(46, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:06:13', '2025-05-28 09:06:13', 'active'),
(47, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:10:30', '2025-05-28 09:10:30', 'active'),
(48, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:14:41', '2025-05-28 09:14:41', 'active'),
(49, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:24:24', '2025-05-28 09:24:24', 'active'),
(50, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:24:45', '2025-05-28 09:24:45', 'active'),
(51, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:26:35', '2025-05-28 09:26:35', 'active'),
(52, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:27:31', '2025-05-28 09:27:31', 'active'),
(53, 'lkvql8mmgvdprumer9ejg8e49o', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:40:49', '2025-05-28 09:40:49', 'active'),
(54, 'vdi5kqkpg3ac2fh6tf7m749i15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:43:59', '2025-05-28 09:43:59', 'active'),
(55, 'di5pendke4olq4qp1p57aiunhj', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:46:33', '2025-05-28 09:46:33', 'active'),
(56, 'di5pendke4olq4qp1p57aiunhj', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:50:46', '2025-05-28 09:50:46', 'active'),
(57, 'di5pendke4olq4qp1p57aiunhj', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 09:59:02', '2025-05-28 09:59:02', 'active'),
(58, 'tpob98khdciekh1d6c8jeruh27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 10:02:35', '2025-05-28 10:02:35', 'active'),
(59, '1l5bm1rsibo61r0gv7ulssjnjd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 10:05:44', '2025-05-28 10:05:44', 'active'),
(60, '1l5bm1rsibo61r0gv7ulssjnjd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 10:07:52', '2025-05-28 10:07:52', 'active'),
(61, 'di5pendke4olq4qp1p57aiunhj', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 10:11:22', '2025-05-28 10:11:22', 'active'),
(62, 'di5pendke4olq4qp1p57aiunhj', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 10:11:31', '2025-05-28 10:11:31', 'active'),
(63, 'di5pendke4olq4qp1p57aiunhj', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 10:11:49', '2025-05-28 10:11:49', 'active'),
(64, '1l5bm1rsibo61r0gv7ulssjnjd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 10:11:58', '2025-05-28 10:11:58', 'active'),
(65, '3nnk9t7qgpj34pr404mp9rpfjs', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 16:21:01', '2025-05-28 16:21:01', 'active'),
(66, '3nnk9t7qgpj34pr404mp9rpfjs', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 16:22:04', '2025-05-28 16:22:04', 'active'),
(67, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 18:51:32', '2025-06-03 18:51:32', 'active'),
(68, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 19:06:48', '2025-06-03 19:06:48', 'active'),
(69, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 19:08:00', '2025-06-03 19:08:00', 'active'),
(70, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 19:09:57', '2025-06-03 19:09:57', 'active'),
(71, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 19:12:02', '2025-06-03 19:12:02', 'active'),
(72, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 19:21:21', '2025-06-03 19:21:21', 'active'),
(73, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 19:21:40', '2025-06-03 19:21:40', 'active'),
(74, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 19:47:24', '2025-06-03 19:47:24', 'active'),
(75, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 20:06:34', '2025-06-03 20:06:34', 'active'),
(76, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 20:11:54', '2025-06-03 20:11:54', 'active'),
(77, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 20:15:19', '2025-06-03 20:15:19', 'active'),
(78, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 20:20:12', '2025-06-03 20:20:12', 'active'),
(79, '5amu7c5vh09bo8g4u86fg9ip9t', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 20:29:57', '2025-06-03 20:29:57', 'active'),
(80, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 20:57:15', '2025-06-03 20:57:15', 'active'),
(81, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 21:00:33', '2025-06-03 21:00:33', 'active'),
(82, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 21:08:32', '2025-06-03 21:08:32', 'active'),
(83, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 21:15:18', '2025-06-03 21:15:18', 'active'),
(84, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 21:15:51', '2025-06-03 21:15:51', 'active'),
(85, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 21:18:07', '2025-06-03 21:18:07', 'active'),
(86, 'n9lm65obdlb5ci2nthelesncj8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 21:18:10', '2025-06-03 21:18:10', 'active');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
