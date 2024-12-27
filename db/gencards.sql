-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2024 at 02:06 AM
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
-- Database: `gencards`
--

-- --------------------------------------------------------

--
-- Table structure for table `card_info`
--

CREATE TABLE `card_info` (
  `card_id` int(20) NOT NULL,
  `card_name` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `card_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `card_info`
--

INSERT INTO `card_info` (`card_id`, `card_name`, `image`, `card_value`) VALUES
(30, 'YouFoodz Gift Card', 'img/youfood.png', '[10, 20, 25, 50, 100]'),
(31, 'Disney Gift Card', 'img/diz.png', '[10, 20, 25, 50, 100]'),
(32, 'Deliveroo Gift Card', 'img/deliv.png', '[10, 20, 25, 50, 100]'),
(33, 'Valorant Gift Card', 'img/val.jpg', '[10, 20, 25, 50, 100]'),
(34, 'Amazon Gift Card', 'img/amazon.png', '[10, 20, 25, 50, 100]'),
(35, 'Minecraft Gift Card', 'img/mine.jpg', '[10, 20, 25, 50, 100]'),
(36, 'Roblox Gift Card', 'img/robux.png', '[10, 20, 25, 50, 100]'),
(37, 'Liquorland Gift Card', 'img/liq.png', '[10, 20, 25, 50, 100]'),
(38, 'WaffleHouse Gift Card', 'img/waff.png', '[10, 20, 25, 50, 100]'),
(39, 'Fortnite Gift Card', 'img/fortnite.png', '[10, 20, 25, 50, 100]'),
(40, 'AirBnB Gift Card', 'img/airb.png', '[10, 20, 25, 50, 100]'),
(41, 'Hotel Gift Card', 'img/hotel.png', '[10, 20, 25, 50, 100]'),
(42, 'Pokemon Gift Card', 'img/poke.png', '[10, 20, 25, 50, 100]'),
(43, 'Uber Gift Card', 'img/ubr.jpeg', '[10, 20, 25, 50, 100]'),
(44, 'League Gift Card', 'img/lol.png', '[10, 20, 25, 50, 100]'),
(45, 'Accor Hotel Gift Card', 'img/acor.jpg', '[10, 20, 25, 50, 100]'),
(46, 'Ngurl Gift Card', 'img/ngurl.jpg', '[10, 20, 25, 50, 100]'),
(47, 'Netflix Gift Card', 'img/netf.png', '[10, 20, 25, 50, 100]'),
(48, 'Dominos Gift Card', 'img/dom.png', '[10, 20, 25, 50, 100]'),
(49, 'Nike Gift Card', 'img/nik.png', '[10, 20, 25, 50, 100]'),
(50, 'Playstation Gift Card', 'img/psp.png', '[10, 20, 25, 50, 100]'),
(51, 'Ikea Gift Card', 'img/ikea.jpg', '[10, 20, 25, 50, 100]'),
(52, 'Spotify Gift Card', 'img/spotify.jpg', '[10, 20, 25, 50, 100]'),
(53, 'Nando Gift Card', 'img/nando.png', '[10, 20, 25, 50, 100]'),
(54, 'Ebg Gift Card', 'img/ebg.png', '[10, 20, 25, 50, 100]'),
(55, 'Discord Gift Card', 'img/disc.png', '[10, 20, 25, 50, 100]'),
(56, 'Ubeats Gift Card', 'img/ubeat.png', '[10, 20, 25, 50, 100]'),
(57, 'Shien Gift Card', 'img/shien.png', '[10, 20, 25, 50, 100]'),
(59, 'Adidas Gift Card', 'img/adidas.png', '[20,25,50,100,150]');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `email`, `full_name`, `address`, `created_at`, `updated_at`) VALUES
(1, 'sav@gmail.com', 'raj', 'pok', '2024-12-25 01:00:34', '2024-12-25 06:50:33'),


-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `status`, `payment_method`, `payment_date`) VALUES
(1, 1, '2024-12-25 01:00:34', 'pending', NULL, NULL),
(2, 2, '2024-12-25 02:00:36', 'pending', NULL, NULL),
(3, 2, '2024-12-25 02:03:47', 'pending', NULL, NULL),
(4, 1, '2024-12-25 06:50:33', 'pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 31, 4, 20.00),
(2, 1, 41, 2, 25.00),
(3, 2, 31, 1, 20.00),
(4, 3, 37, 2, 20.00),
(5, 3, 36, 4, 50.00),
(6, 4, 34, 2, 25.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_info`
--
ALTER TABLE `card_info`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card_info`
--
ALTER TABLE `card_info`
  MODIFY `card_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `card_info` (`card_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
