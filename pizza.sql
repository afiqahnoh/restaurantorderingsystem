-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2023 at 10:19 AM
-- Server version: 8.0.33-0ubuntu0.20.04.2
-- PHP Version: 8.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(11, 'Signature Pizza'),
(12, 'Special pizza'),
(13, 'Favorite pizza'),
(16, 'cheese pizza');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` int NOT NULL DEFAULT '1',
  `ic` varchar(255) DEFAULT NULL,
  `address` text,
  `staff_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `password`, `type`, `ic`, `address`, `staff_id`) VALUES
(2, 'Main Admin', 'superadmin@gmail.com', 'admin1234', 1, NULL, NULL, ''),
(3, 'Zacky Abraham Lincoln', 'faizalayub29@gmail.com', 'admin1234', 2, '670908109988', 'No 19 Jalan Kencana Dua 14/KN18\r\nTaman Coves', 'B0019281'),
(18, 'Afiqah Noh', 'afiqahnoh03@gmail.com', 'staff123', 2, '010703080699', 'Lot 696\r\nKampung Gunung Tungg', 'A002'),
(19, 'Kitchen', 'noorafiqahnoh03@gmail.com', 'staff123', 2, '980807-08-6656', 'Lot 696\r\nKampung Gunung Tunggal', ''),
(26, 'NOOR AFIQAH', 'afiqahnoh03@gmail.com', 'staff123', 2, '010723-01-0788', 'hulu langat', '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` varchar(100) NOT NULL,
  `in_stock` int NOT NULL DEFAULT '1',
  `is_active` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `category`, `image`, `price`, `in_stock`, `is_active`) VALUES
(35, 'The Mediterranean Delight', 11, 'Meat pizza.jpg', '20', 99, 1),
(36, 'Meat Lover', 11, 'Meat pizza.jpg', '20', 99, 1),
(37, 'Garden Harvest', 11, 'Meat pizza.jpg', '20', 99, 1),
(38, 'Hawaiian Luau', 11, 'Meat pizza.jpg', '20', 99, 1),
(39, 'Smoky Maple Bacon BBQ', 12, 'Meat pizza.jpg', '30', 99, 1),
(40, 'Seafood Sensation', 12, 'Meat pizza.jpg', '30', 99, 1),
(41, 'Dessert Delight', 12, 'Meat pizza.jpg', '30', 99, 1),
(42, 'Aloha Chicken', 13, 'Meat pizza.jpg', '20', 99, 1),
(43, 'Bbq Chicken', 13, 'Meat pizza.jpg', '20', 99, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_cart`
--

CREATE TABLE `user_cart` (
  `id` int NOT NULL,
  `menu` int NOT NULL,
  `user` int NOT NULL,
  `size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `menu_id` text NOT NULL,
  `status` int NOT NULL,
  `unique_number` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address` text NOT NULL,
  `payment_method` int DEFAULT NULL,
  `delivery_method` int NOT NULL,
  `payment_receipt` varchar(100) DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `size` text,
  `payer_phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_order`
--

INSERT INTO `user_order` (`id`, `user_id`, `menu_id`, `status`, `unique_number`, `created_date`, `address`, `payment_method`, `delivery_method`, `payment_receipt`, `payer_name`, `size`, `payer_phone`) VALUES
(103, 18, '[36]', 3, '2197', '2023-08-07 01:54:56', 'E10A, Fasa 1C1, Jln Semarak Api, 32040 Seri Manjung, Perak', 2, 1, NULL, 'aina', '[\"Small\"]', ' 60175055680'),
(104, 18, '[42,42]', 3, '2755', '2023-08-07 02:41:56', 'E10A, Fasa 1C1, Jln Semarak Api, 32040 Seri Manjung, Perak', 2, 1, NULL, 'seff', '[\"Small\",\"Small\"]', ' 60134578799'),
(105, 18, '[37]', 3, '1937', '2023-08-07 03:39:34', 'E10A, Fasa 1C1, Jln Semarak Api, 32040 Seri Manjung, Perak', 2, 1, NULL, 'seff', '[\"Small\"]', ' 60134578799'),
(106, 18, '[37,37,36,36]', 3, '1917', '2023-08-08 17:27:15', 'E10A, Fasa 1C1, Jln Semarak Api, 32040 Seri Manjung, Perak', 2, 1, NULL, 'aina', '[\"Small\",\"Small\",\"Small\",\"Small\"]', ' 60175055680');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `user_2` (`user`),
  ADD KEY `menu` (`menu`);

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_cart`
--
ALTER TABLE `user_cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`);

--
-- Constraints for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD CONSTRAINT `user_cart_ibfk_1` FOREIGN KEY (`menu`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `user_cart_ibfk_2` FOREIGN KEY (`user`) REFERENCES `login` (`id`);

--
-- Constraints for table `user_order`
--
ALTER TABLE `user_order`
  ADD CONSTRAINT `user_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
