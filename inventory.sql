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
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_name`, `description`, `price`, `image_url`, `quantity`, `created_at`) VALUES
(2, 'Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP', 'Classic Ferrari F355 Berlinetta in red with 5-spoke wheels.', 1000.75, 'https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp', 5, '2025-04-02 15:38:07'),
(3, 'Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars', 'Exclusive blue Lamborghini Diablo from Virtual Cars series.', 555.75, 'https://i.ebayimg.com/images/g/6DoAAeSwQ71npOES/s-l960.webp', 8, '2025-04-02 15:38:07'),
(4, '2023 Hot Wheels DC Batmobile 103/250 1:64 Diecast Car White Batman Series 3/5', 'White Batmobile from the 2023 Batman series.', 111.75, 'https://i.ebayimg.com/images/g/9w8AAeSwIIZnyFvK/s-l960.webp', 12, '2025-04-02 15:38:07'),
(5, '2025 Hot Wheels Premium Car Culture 2 Pack Lamborghini Countach & Lancia Stratos', 'Special 2-pack featuring Lamborghini Countach & Lancia Stratos.', 15.75, 'https://i.ebayimg.com/images/g/AcIAAeSwg8lnyG9o/s-l960.webp', 20, '2025-04-02 15:38:07'),
(6, 'Hot Wheels City Playset Downtown Aquarium Bash Set Track Connect FMY99', 'Downtown Aquarium Bash Playset from Hot Wheels City.', 15.75, 'https://i.ebayimg.com/images/g/LBwAAeSwUzNnyFr9/s-l500.webp', 15, '2025-04-02 15:38:07'),
(7, 'New Monster Jam SPARKLE SMASH vs SPARKLE SMASH Rainbow Unicorn Truck 2 PACK', 'Monster Jam Sparkle Smash vs Rainbow Unicorn truck set.', 15.75, 'https://i.ebayimg.com/images/g/mzAAAOSw-rBnyG2f/s-l1600.webp', 25, '2025-04-02 15:38:07'),
(8, '2025 Hot Wheels Premium Car Culture Spoon Honda Civic Type R 2 Pack', 'Spoon Honda Civic Type R special edition pack.', 15.75, 'https://i.ebayimg.com/images/g/UoYAAeSw~5lnyG4T/s-l960.webp', 30, '2025-04-02 15:38:07'),
(9, 'HOT WHEELS CAD BANE Star Wars Character Cars - Book of Boba Fett - NEW On-Card', 'Hot Wheels Star Wars character car featuring Cad Bane.', 15.75, 'https://i.ebayimg.com/images/g/ScoAAeSwPfRnyHBi/s-l960.webp', 18, '2025-04-02 15:38:07'),
(10, 'HOT WHEELS 2024 ULTRA HOTS SERIES 3 #1 1970 FORD ESCORT RS1600', 'Limited edition 1970 Ford Escort RS1600 from the Ultra Hots series.', 15.75, 'https://i.ebayimg.com/images/g/mo0AAeSwU3Znx~NH/s-l960.webp', 22, '2025-04-02 15:38:07'),
(11, 'Hot Wheels 2025 HW Race Day Porsche 904 Carrera GTS Yellow #100 100/250', 'Yellow Porsche 904 Carrera GTS from HW Race Day series.', 15.75, 'https://i.ebayimg.com/images/g/f64AAeSwLtNnx-dA/s-l960.webp', 16, '2025-04-02 15:38:07'),
(12, '1983 DETOMASO PANTERA BLUE 1:18 HOT WHEELS 2000 VERY RARE', 'Rare 1:18 scale DeTomaso Pantera from 2000.', 15.75, 'https://i.ebayimg.com/images/g/5LoAAOSwVFVnAJbi/s-l1600.webp', 7, '2025-04-02 15:38:07'),
(13, '2022 Hot Wheels DG Exclus #98 HW J-Imports 2/10 CUSTOM 01 ACURA INTEGRA GSR Blue', 'Custom Acura Integra GSR from HW J-Imports.', 15.75, 'https://i.ebayimg.com/images/g/KpYAAOSw~YBnjW81/s-l1600.webp', 11, '2025-04-02 15:38:07'),
(14, 'HOT WHEELS SUBARU WRX STI 2025 JDM 100% CUSTOM GARAGE', 'Exclusive custom Subaru WRX STI JDM edition.', 15.75, 'https://i.ebayimg.com/images/g/gd0AAOSw8fZnxWyJ/s-l960.webp', 14, '2025-04-02 15:38:07'),
(15, 'Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.', 'Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.', 100.75, 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp', 3, '2025-04-02 15:43:58');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
