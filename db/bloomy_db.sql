-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2025 at 04:11 PM
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
-- Database: `bloomy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `page` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `page`, `title`, `description`) VALUES
(1, 'about', 'About Bloomy Beauty Shop', 'Welcome to Bloomy Beauty Shop, your premier destination for high-quality beauty products in Kosovo. Founded by three passionate beauty enthusiasts - Vesa Dema, Vesa Delibeqa, and Elsa Rexhepi - our shop brings together a carefully curated collection of premium beauty products.\r\n\r\nLocated in the heart of Pristina, Bloomy Beauty Shop offers a wide range of makeup, skincare, and beauty accessories from renowned international brands. Our mission is to help every customer discover their perfect beauty products while providing exceptional service and expert advice.\r\n\r\nWhat sets us apart is our commitment to authenticity and quality. We ensure that all our products are sourced directly from authorized distributors, offering our customers peace of mind with every purchase. Our knowledgeable team is always ready to provide personalized recommendations and beauty tips.\r\n\r\nVisit us to explore our extensive collection and let us help you enhance your natural beauty. At Bloomy Beauty Shop, we believe that everyone deserves to feel confident and beautiful.');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `regular_price` decimal(10,0) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `image_url` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `regular_price`, `sale_price`, `image_url`) VALUES
(1, 'Huda Beauty Baking Powder test', 50, 42, 'product2.jpg'),
(3, 'Charlotte Tilbury ', 19, 9, 'product1.jpg'),
(4, 'Rare Beauty Blush', 30, 24, 'product3.jpg'),
(5, 'Carolina Herrera ', 59, 50, 'product4.jpg'),
(6, 'Glow Recipe', 81, 40, 'product5.jpg'),
(7, 'Summer Fridays', 10, 22, 'product6.jpg'),
(8, 'Patrick Ta Peachy Blush', 60, 30, 'product7.jpg'),
(9, 'Nars Blush', 39, 20, 'product8.jpg'),
(10, 'Makeup By Mario Blush', 25, 13, 'product9.jpg'),
(11, 'Spray Anti-Frizz', 20, 9, 'product10.jpg'),
(12, 'Color Wow Styling Cream', 21, 12, 'product11.jpg'),
(13, 'Saie Set Blush', 60, 40, 'product12.jpg'),
(14, 'Coco Channel Parfume', 200, 130, 'product13.jpg'),
(15, 'Chanel parfume', 120, 60, 'product14.jpg'),
(16, 'YSL Parfume Set', 121, 90, 'product15.jpg'),
(17, 'Burrberry Parfume Set', 101, 50, 'product16.jpg'),
(18, 'Gisou Hair Parfume', 100, 90, 'product17.jpg'),
(19, 'Bloomy Favourites', 101, 51, 'product18.jpg'),
(20, 'Amika Set', 47, 40, 'product19.jpg'),
(21, 'Hair Mask & Oil', 35, 31, 'product20.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`id`, `product_id`, `product_name`, `price`, `quantity`, `image_url`, `created_at`) VALUES
(12, 4, 'Rare Beauty Blush', 24.00, 1, 'product3.jpg', '2025-02-02 15:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `postcode` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `firstName`, `lastName`, `email`, `password`, `birthday`, `address`, `postcode`) VALUES
(1, 'Vesa', 'Delibeqa', 'vdelibeqa@gmail.com', 'vesa1234', '0000-00-00', 'Lakrishte', 10020),
(2, 'Vesa', 'Delibeqa', 'vdelibeqa@gmail.com', 'vesa1234', '0000-00-00', 'Lakrishte', 10020),
(3, 'Vesa', 'Delibeqa', 'vdelibeqa@gmail.com', 'vesa1234', '0000-00-00', 'Lakrishte', 10020),
(4, 'Vesa', 'Delibeqa', 'vdelibeqa@gmail.com', 'vesa1234', '0000-00-00', 'Lakrishte', 10020),
(5, 'Vesa', 'Delibeqa', 'vdelibeqa@gmail.com', 'vesa1234', '0000-00-00', 'Lakrishte', 10020),
(6, 'Vesa', 'Delibeqa', 'vdelibeqa@gmail.com', 'vesa1234', '0000-00-00', 'Lakrishte', 10020),
(7, 'Vesa', 'Delibeqa', 'vdelibeqa@gmail.com', 'vesa1234', '2025-01-20', 'Lakrishte', 10020),
(8, 'Elsa', 'Rexhepi', 'elsarexhepii@hotmail.com', 'elsa1234', '2025-01-15', 'Ulpiane', 10000),
(9, 'Vesa', 'Dema', 'vesadema21@gmail.com', 'vesa1234', '2005-07-05', 'Bregu I Diellit', 10000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
