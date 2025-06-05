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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `barcode` varchar(13) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','discontinued') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `barcode`, `description`, `price`, `category`, `brand`, `sku`, `stock_quantity`, `image_url`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(24, 'Hot Wheels Toyota Supra HW The 90S Ages 3 and Up by Small CLAP (Green)', NULL, 'The Toyota Supra is a sports car produced by Toyota since 1978.', 555.75, 'Fast & Furious sets', 'toyota', NULL, 10, 'images/products/68377b39d984f_513yGy11ljL.jpg', 'active', '2025-05-28 21:08:09', '2025-05-28 22:16:20', NULL),
(26, 'Hot Wheels Jeep Scrambler (Baja Blazers) 1:64 scale model', NULL, 'Jeep has been part of Chrysler since 1987, when Chrysler acquired the Jeep brand, along with other assets, from their previous owner American Motors Corporation (AMC).', 199.00, 'jeep', 'toyota', NULL, 10, 'https://filebroker-cdn.lazada.com.ph/kf/Se178c192078e4b0bb460ecf17cf01c06f.jpg', 'active', '2025-05-28 22:03:50', '2025-05-28 22:03:50', NULL),
(27, 'Jul Bolando', NULL, 'dsadsadsa', 2.00, NULL, NULL, NULL, 4, '/SYSTEM-SA-MGA-GWAPO/images/products/683f487f5bb12_escobar.jpg', 'active', '2025-06-03 19:09:51', '2025-06-03 19:09:51', NULL),
(28, 'Lynnies', NULL, 'dasdsa', 1000.75, NULL, NULL, NULL, 232, '/SYSTEM-SA-MGA-GWAPO/images/products/683f494220262_491034412_1017483053667080_4253557146667369093_n.jpg', 'active', '2025-06-03 19:13:06', '2025-06-03 19:13:06', NULL),
(29, 'dasdsa', '3314280988873', 'dsadsa', 2.00, NULL, NULL, NULL, 2, '/SYSTEM-SA-MGA-GWAPO/images/products/683f49cb22cac_11.jpg', 'active', '2025-06-03 19:15:23', '2025-06-03 19:15:23', NULL),
(30, 'dsadsa', '4205510079485', 'dsadsad', 2.00, NULL, NULL, NULL, 5, '/SYSTEM-SA-MGA-GWAPO/images/products/683f4d88b39eb_child.png', 'active', '2025-06-03 19:31:20', '2025-06-03 19:31:20', NULL);

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `after_product_stock_update` AFTER UPDATE ON `products` FOR EACH ROW BEGIN
    IF OLD.stock_quantity != NEW.stock_quantity THEN
        INSERT INTO product_inventory_history 
        (product_id, action, quantity, previous_quantity, new_quantity, notes)
        VALUES 
        (NEW.id, 
         CASE 
            WHEN NEW.stock_quantity > OLD.stock_quantity THEN 'add'
            WHEN NEW.stock_quantity < OLD.stock_quantity THEN 'remove'
            ELSE 'adjust'
         END,
         ABS(NEW.stock_quantity - OLD.stock_quantity),
         OLD.stock_quantity,
         NEW.stock_quantity,
         CONCAT('Stock updated from ', OLD.stock_quantity, ' to ', NEW.stock_quantity)
        );
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `idx_products_name` (`name`),
  ADD KEY `idx_products_category` (`category`),
  ADD KEY `idx_products_brand` (`brand`),
  ADD KEY `idx_products_sku` (`sku`),
  ADD KEY `idx_products_status` (`status`),
  ADD KEY `idx_products_price` (`price`),
  ADD KEY `idx_products_stock` (`stock_quantity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
