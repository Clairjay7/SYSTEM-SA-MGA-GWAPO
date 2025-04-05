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
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_name`, `price`, `image_url`, `quantity`) VALUES
(1, 'Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.', 100.75, 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp', 4),
(2, 'Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP', 1000.75, 'https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp', 1),
(3, 'Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars', 555.75, 'https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp', 0),
(4, 'Hot Wheels 1995 Nissan Skyline GT-R', 250.50, 'https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp', 12),
(5, 'Hot Wheels 2020 Ford Mustang GT', 450.99, 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp', 15),
(6, 'Hot Wheels Batmobile', 300.00, 'https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp', 3),
(7, 'Hot Wheels McLaren P1', 650.00, 'https://via.placeholder.com/150', 7),
(8, 'Hot Wheels Porsche 911 Turbo', 380.75, 'https://via.placeholder.com/150', 8),
(9, 'Hot Wheels Toyota Supra A80', 420.25, 'https://via.placeholder.com/150', 10),
(10, 'Hot Wheels 1994 Mazda RX-7', 550.00, 'https://via.placeholder.com/150', 5),
(11, 'Hot Wheels Dodge Viper GTS', 700.50, 'https://via.placeholder.com/150', 6),
(12, 'Hot Wheels 1969 Camaro Z28', 320.00, 'https://via.placeholder.com/150', 10),
(13, 'Hot Wheels Ferrari 512 TR', 850.75, 'https://via.placeholder.com/150', 7),
(14, 'Hot Wheels Pagani Huayra', 950.99, 'https://via.placeholder.com/150', 9),
(15, 'Hot Wheels Chevrolet Corvette ZR1', 760.00, 'https://via.placeholder.com/150', 6),
(16, 'Hot Wheels Aston Martin DB11', 600.25, 'https://via.placeholder.com/150', 5),
(17, 'Hot Wheels Shelby GT500 Mustang', 670.00, 'https://via.placeholder.com/150', 12),
(18, 'Hot Wheels Dodge Charger RT', 440.99, 'https://via.placeholder.com/150', 8),
(19, 'Hot Wheels BMW M3 E30', 500.00, 'https://via.placeholder.com/150', 10),
(20, 'Hot Wheels Subaru Impreza WRX STI', 580.00, 'https://via.placeholder.com/150', 7),
(21, 'Hot Wheels Ferrari 488 GTB', 700.99, 'https://via.placeholder.com/150', 6),
(22, 'Hot Wheels Bugatti Chiron', 1200.00, 'https://via.placeholder.com/150', 4),
(23, 'Hot Wheels Audi R8 V10', 800.00, 'https://via.placeholder.com/150', 5),
(24, 'Hot Wheels Lamborghini Huracan', 900.00, 'https://via.placeholder.com/150', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
