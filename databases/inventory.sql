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
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `barcode` varchar(13) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `image_url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `category` enum('Regular','Premium','Limited Edition') DEFAULT 'Regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `barcode`, `description`, `price`, `quantity`, `image_url`, `created_at`, `updated_at`, `deleted_at`, `category`) VALUES
(1, 'Hot Wheels 1997 FE Lamborghini Countach Y', '7723466016815', 'A rare Lamborghini Countach model from 1997.', 100.75, 15, 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp', '2025-05-26 13:17:04', '2025-06-03 20:51:22', NULL, 'Regular'),
(3, 'Hot Wheels 2000 Lamborghini Diablo Blue', '7072516613746', 'A collectible Lamborghini Diablo model from 2000.', 555.75, 8, 'https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp', '2025-05-26 13:17:04', '2025-06-03 20:51:16', NULL, 'Regular'),
(4, 'Hot Wheels 1995 Nissan Skyline GT-R', '9044602996255', 'A stunning Nissan Skyline GT-R model from 1995.', 250.50, 15, 'https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp', '2025-05-26 13:17:04', '2025-06-03 20:50:50', NULL, 'Regular'),
(5, 'Hot Wheels 2020 Ford Mustang GT', '1218419060808', 'A sleek Ford Mustang GT model from 2020.', 450.99, 12, 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp', '2025-05-26 13:17:04', '2025-06-03 19:11:25', NULL, 'Regular'),
(6, 'Hot Wheels Batmobile', '7955600343476', 'The iconic Batmobile model.', 300.00, 20, 'https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp', '2025-05-26 13:17:04', '2025-06-03 19:11:19', NULL, 'Regular'),
(7, 'Hot Wheels McLaren P1', '4785949640899', 'A limited edition McLaren P1 model.', 650.00, 7, 'https://i.ebayimg.com/images/g/2RUAAOSwEdtndLbG/s-l1600.webp', '2025-05-26 13:17:04', '2025-06-03 19:11:13', NULL, 'Regular'),
(8, 'Hot Wheels Porsche 911 Turbo', '6453868386135', 'A detailed Porsche 911 Turbo model.', 380.75, 9, 'https://i.ebayimg.com/images/g/Zh8AAeSwYWxn8Mgg/s-l1600.webp', '2025-05-26 13:17:04', '2025-06-03 20:50:36', NULL, 'Premium'),
(9, 'Hot Wheels Toyota Supra A80', '6112868752776', 'A collectible Toyota Supra A80 model.', 420.25, 11, 'https://i.ebayimg.com/images/g/p9oAAOSw1LpnxSfv/s-l1600.webp', '2025-05-26 13:17:04', '2025-06-03 20:50:33', NULL, 'Premium'),
(10, 'Hot Wheels 1994 Mazda RX-7', '5068523358170', 'A rare Mazda RX-7 model from 1994.', 550.00, 6, 'https://i.ebayimg.com/images/g/pOkAAOSwNQNl-4Ng/s-l1600.webp', '2025-05-26 13:17:04', '2025-06-03 20:50:30', NULL, 'Premium'),
(11, 'Hot Wheels 1997 FE Lamborghini Countach ', '9585150823374', 'A rare Lamborghini Countach model from 1997.', 100.75, 2, 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp', '2025-05-26 13:20:47', '2025-06-03 20:49:48', NULL, 'Premium'),
(12, 'Hot Wheels 1999 Ferrari F355 Berlinetta Red', '2097449771872', 'A highly detailed Ferrari model from 1999.', 1000.75, 7, 'https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp', '2025-05-26 13:20:47', '2025-06-03 20:49:53', NULL, 'Premium'),
(13, 'Hot Wheels 2000 Lamborghini Diablo Blue', '1919466705780', 'A collectible Lamborghini Diablo model from 2000.', 555.75, 8, 'https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp', '2025-05-26 13:20:47', '2025-06-03 20:49:56', NULL, 'Premium'),
(14, 'Hot Wheels 1995 Nissan Skyline GT-R', '5902944434349', 'A stunning Nissan Skyline GT-R model from 1995.', 250.50, 15, 'https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp', '2025-05-26 13:20:47', '2025-06-03 20:49:58', NULL, 'Premium'),
(15, 'Hot Wheels 2020 Ford Mustang GT', '8425124245089', 'A sleek Ford Mustang GT model from 2020.', 450.99, 12, 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp', '2025-05-26 13:20:47', '2025-06-03 20:50:01', NULL, 'Premium'),
(16, 'Hot Wheels Batmobile', '9110012659701', 'The iconic Batmobile model.', 300.00, 20, 'https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp', '2025-05-26 13:20:47', '2025-06-03 20:50:06', NULL, 'Premium'),
(17, 'Hot Wheels McLaren P1', '6850836234585', 'A limited edition McLaren P1 model.', 650.00, 7, 'https://i.ebayimg.com/images/g/2RUAAOSwEdtndLbG/s-l1600.webp', '2025-05-26 13:20:47', '2025-06-03 20:50:09', NULL, 'Premium'),
(18, 'Hot Wheels Porsche 911 Turbo', '4400585493479', 'A detailed Porsche 911 Turbo model.', 380.75, 9, 'https://i.ebayimg.com/images/g/Zh8AAeSwYWxn8Mgg/s-l1600.webp', '2025-05-26 13:20:47', '2025-06-03 20:50:16', NULL, 'Premium'),
(19, 'Hot Wheels Toyota Supra A80', '2014834705308', 'A collectible Toyota Supra A80 model.', 420.25, 11, 'https://i.ebayimg.com/images/g/p9oAAOSw1LpnxSfv/s-l1600.webp', '2025-05-26 13:20:47', '2025-06-03 20:50:18', NULL, 'Premium'),
(20, 'Hot Wheels 1994 Mazda RX-7', '8775351983678', 'A rare Mazda RX-7 model from 1994.', 550.00, 6, 'https://i.ebayimg.com/images/g/pOkAAOSwNQNl-4Ng/s-l1600.webp', '2025-05-26 13:20:47', '2025-06-03 20:50:21', NULL, 'Premium'),
(21, 'Hot Wheels 2021 Corvette C8.R', '8065976746561', 'Latest Corvette racing model with authentic details.', 275.50, 8, 'https://down-ph.img.susercontent.com/file/dc04298c6979435b312f78dbf70f4b34', '2025-05-26 13:20:47', '2025-06-03 20:50:24', NULL, 'Premium'),
(22, 'Hot Wheels Tesla Model S Plaid', '7189217255426', 'Electric supercar with premium finish.', 425.00, 5, 'https://m.media-amazon.com/images/I/51+6a+qoGrL._AC_UF1000,1000_QL80_.jpg', '2025-05-26 13:20:47', '2025-06-03 20:51:04', NULL, 'Premium'),
(23, 'Hot Wheels 1967 Camaro SS', '8629867775683', 'Classic muscle car with metallic paint.', 599.99, 4, 'https://i.ebayimg.com/images/g/RiYAAOSwwYlh-0ei/s-l1200.jpg', '2025-05-26 13:20:47', '2025-06-03 20:50:57', NULL, 'Regular'),
(24, 'Hot Wheels Honda Civic Type R', '5298926163607', 'JDM legend with racing livery.', 325.75, 10, 'https://m.media-amazon.com/images/I/81zaizwlafL._AC_SL1500_.jpg', '2025-05-26 13:20:47', '2025-06-03 20:51:10', NULL, 'Regular'),
(25, 'Hot Wheels Bugatti Chiron', '3621388773699', 'Hypercar with premium details.', 750.00, 3, 'https://img.lazcdn.com/g/ff/kf/Sb9915ca5ed0a4ab09a20254c9f687f90l.jpg_720x720q80.jpg', '2025-05-26 13:20:47', '2025-06-03 20:51:29', NULL, 'Regular'),
(26, 'Hot Wheels Aston Martin DB5', '5913911439400', 'Classic British luxury sports car.', 475.50, 7, 'https://i.ebayimg.com/images/g/d48AAOSwd9BmIXL1/s-l1200.jpg', '2025-05-26 13:20:47', '2025-06-03 20:51:35', NULL, 'Regular'),
(27, 'Hot Wheels Pagani Huayra', '1906692092282', 'Italian masterpiece with gull-wing doors.', 625.00, 4, 'https://i.ebayimg.com/images/g/x3wAAOSwGyhjjrZy/s-l1200.jpg', '2025-05-26 13:20:47', '2025-06-03 20:51:40', NULL, 'Regular'),
(28, 'Hot Wheels 1970 Plymouth Superbird', '9280299121202', 'NASCAR legend with iconic wing.', 585.25, 6, 'https://www.ubuy.com.ph/productimg/?image=aHR0cHM6Ly9pbWFnZXMtY2RuLnVidXkuY29tLnBoLzYzNTQzZmQ3MmM4YjQxMzhkMjMzYTM4OS1ob3Qtd2hlZWxzLTAzOS03MC1wbHltb3V0aC5qcGc.jpg', '2025-05-26 13:20:47', '2025-06-03 20:51:44', NULL, 'Regular'),
(29, 'Hot Wheels Koenigsegg Agera R', '7230189232500', 'Swedish hypercar with record-breaking speed.', 699.99, 3, 'https://down-ph.img.susercontent.com/file/sg-11134201-22100-gxmene25qjiv82', '2025-05-26 13:20:47', '2025-06-03 20:51:50', NULL, 'Regular'),
(30, 'Hot Wheels Mercedes-AMG GT', '5242700381207', 'German engineering at its finest.', 450.00, 8, 'https://m.media-amazon.com/images/I/71DYQIfvtoL.jpg', '2025-05-26 13:20:47', '2025-06-03 20:51:55', NULL, 'Regular'),
(31, 'Hot Wheels Dodge Challenger Demon', '6588556509916', 'Modern muscle car with drag racing setup.', 525.75, 5, 'https://filebroker-cdn.lazada.com.ph/kf/Sb6743092087e4eb1bc30ab77d3c27fb9b.jpg', '2025-05-26 13:20:47', '2025-06-03 20:52:10', NULL, 'Regular'),
(32, 'Hot Wheels Porsche 918 Spyder', '7994397225627', 'Hybrid hypercar with racing heritage.', 675.00, 4, 'https://m.media-amazon.com/images/I/61iSYKd8qZS._AC_SL1200_.jpg', '2025-05-26 13:20:47', '2025-06-03 20:52:15', NULL, 'Regular'),
(33, 'Hot Wheels McLaren Senna', '9636973717337', 'Track-focused hypercar with active aero.', 725.50, 3, 'https://m.media-amazon.com/images/I/61xI844RZrL._AC_SL1000_.jpg', '2025-05-26 13:20:47', '2025-06-03 20:52:21', NULL, 'Regular'),
(34, 'Hot Wheels Ford GT40', '9538266974218', 'Le Mans winning legend.', 599.99, 6, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTx1BW3E7f_BA9zrWjIRPyZf3iKw48MisDLEw&s', '2025-05-26 13:20:47', '2025-06-03 20:52:27', NULL, 'Regular'),
(35, 'Jul Bolando', NULL, 'dsadsadsa', 2.00, 3, '/SYSTEM-SA-MGA-GWAPO/images/products/683f487f5bb12_escobar.jpg', '2025-06-03 19:09:51', '2025-06-03 20:07:53', '2025-06-03 19:30:14', 'Regular'),
(36, 'Lynnies', NULL, 'dasdsa', 1000.75, 232, '/SYSTEM-SA-MGA-GWAPO/images/products/683f494220262_491034412_1017483053667080_4253557146667369093_n.jpg', '2025-06-03 19:13:06', '2025-06-03 19:30:11', '2025-06-03 19:30:11', 'Regular'),
(37, 'dasdsa', '3314280988873', 'dsadsa', 2.00, 2, '/SYSTEM-SA-MGA-GWAPO/images/products/683f49cb22cac_11.jpg', '2025-06-03 19:15:23', '2025-06-03 19:29:02', '2025-06-03 19:29:02', 'Regular'),
(38, 'dsadsa', '4205510079485', 'dsadsad', 2.00, 5, '/SYSTEM-SA-MGA-GWAPO/images/products/683f4d88b39eb_child.png', '2025-06-03 19:31:20', '2025-06-03 19:31:37', '2025-06-03 19:31:37', 'Regular'),
(39, 'Jul Bolando', '2778146561257', 'sddaasd', 2.00, 5, 'uploads/683f542046600.jpg', '2025-06-03 19:59:28', '2025-06-03 20:03:43', '2025-06-03 20:03:43', 'Limited Edition'),
(40, 'dasdas', '7207742934535', '421', 5.00, 232, 'https://www.planetware.com/wpimages/2020/02/france-in-pictures-beautiful-places-to-photograph-eiffel-tower.jpg', '2025-06-03 20:02:52', '2025-06-03 20:03:40', '2025-06-03 20:03:40', 'Regular'),
(41, 'das', '2243513779520', 'dsad', 55.00, 244, 'https://www.planetware.com/wpimages/2020/02/france-in-pictures-beautiful-places-to-photograph-eiffel-tower.jpg', '2025-06-03 20:03:20', '2025-06-03 20:03:38', '2025-06-03 20:03:38', 'Limited Edition'),
(42, 'Hot Wheels Limited Edition Roses', '3003513009603', 'Rose-themed, stylish, and collectible.', 1999.00, 1, 'https://i.ebayimg.com/images/g/bxoAAOSwI8thy3p9/s-l1600.webp', '2025-06-03 20:38:44', '2025-06-03 20:38:44', NULL, 'Limited Edition'),
(43, 'Hot Wheels 2025 Mainline', '1829307106125', 'New 2025 designs for collectors and racers.', 1999.00, 1, 'https://i.ebayimg.com/images/g/eZIAAOSwZB5oDEp5/s-l960.webp', '2025-06-03 20:39:28', '2025-06-03 20:39:28', NULL, 'Limited Edition'),
(44, 'HOT WHEELS HW ART CARS 1010 YELLOW', '6237673667191', 'Bold yellow car with artistic flair.', 1999.00, 1, 'https://m.media-amazon.com/images/I/91LW1LGTiiL._AC_SL1500_.jpg', '2025-06-03 20:40:54', '2025-06-03 20:40:54', NULL, 'Limited Edition'),
(45, 'Hot Wheels 8 Crate, Red Lines 35 Faster Than Ever #98', '4407305259236', 'Sleek red design with Faster Than Ever wheels.', 1999.00, 1, 'https://m.media-amazon.com/images/I/81xgDbrNeKL._AC_SL1500_.jpg', '2025-06-03 20:41:49', '2025-06-03 20:41:49', NULL, 'Limited Edition'),
(46, 'Hot Wheels Lamborghini Limited Edition Cars', '6773834601992', 'Exclusive Lamborghinis for premium collectors.', 1999.00, 1, 'https://m.media-amazon.com/images/I/51W2dbotigL.jpg', '2025-06-03 20:42:58', '2025-06-03 20:42:58', NULL, 'Limited Edition'),
(47, 'Hot Wheels Volkswagen Fastback Limited Edition', '7933137130385', 'Rare Fastback with exclusive design.', 1999.00, 1, 'https://www.toysrus.com.my/dw/image/v2/BDGJ_PRD/on/demandware.static/-/Sites-master-catalog-toysrus/default/dw9cde8bc7/d/b/a/9/dba9a749a1045a18d1bffc43369ee5a05cfcbf0d_61511_i1.JPG?sw=900&sh=900&q=75', '2025-06-03 20:44:14', '2025-06-03 20:44:14', NULL, 'Limited Edition'),
(48, 'NEW 2022 Hot Wheels Exclusive Limited Edition', '7679435794821', 'Exclusive release from 2022.', 1999.00, 1, 'https://images-cdn.ubuy.com.ph/6476869c48afc7475568e372-new-2022-hot-wheels-exclusive-limited.jpg', '2025-06-03 20:45:06', '2025-06-03 20:45:06', NULL, 'Limited Edition'),
(49, 'Hot Wheels Limited Edition Ruby Red Passion with protector', '8053038700397', 'Limited edition with protector case.', 1999.00, 1, 'https://carolinasdiecast.com/cdn/shop/files/6DB3362C-1261-49A3-BD56-8977130F1634.jpg?v=1718311031&width=823', '2025-06-03 20:47:16', '2025-06-03 20:47:16', NULL, 'Limited Edition'),
(50, '34 Ford Coupe Malt', '3877217574029', 'Classic vintage style model.', 1999.00, 1, 'https://coloradodiecast.com/cdn/shop/files/mom3_1343ecb5-d0e4-4a93-8b1d-685d54db0e83_365x547_crop_top.webp?v=1729777171', '2025-06-03 20:49:05', '2025-06-03 20:49:18', NULL, 'Limited Edition');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `idx_inventory_quantity` (`quantity`),
  ADD KEY `idx_inventory_deleted_at` (`deleted_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
