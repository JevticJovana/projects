-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2021 at 10:22 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Obuca', '2021-07-28 18:57:49', '2021-07-28 18:57:49'),
(2, 'Odeca', '2021-07-28 18:57:49', '2021-07-28 18:57:49'),
(3, 'Elektronika', '2021-07-28 18:57:49', '2021-07-28 18:57:49'),
(4, 'Racunarska oprema', '2021-07-28 18:57:49', '2021-07-28 18:57:49'),
(5, 'Racunarske komponente', '2021-07-28 18:57:49', '2021-07-28 18:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `ref_no` varchar(50) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `payment` int(11) DEFAULT 0,
  `processed` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id`, `ref_no`, `profile_id`, `product_id`, `quantity`, `payment`, `processed`, `created_at`, `updated_at`) VALUES
(3, '610c3681d1c69', 1, 6, 1, 0, 1, '2021-08-05 21:05:37', '2021-08-05 21:05:37'),
(6, '610c36f85d9d4', 2, 7, 1, 1, 1, '2021-08-05 21:07:36', '2021-08-05 21:07:36'),
(7, '610c3dd865691', 1, 1, 1, 1, 1, '2021-08-05 21:36:56', '2021-08-05 21:36:56'),
(8, '610c3dd865691', 1, 2, 1, 1, 1, '2021-08-05 21:36:56', '2021-08-05 21:36:56'),
(9, '610c3dd865691', 1, 3, 1, 1, 1, '2021-08-05 21:36:56', '2021-08-05 21:36:56'),
(13, '610c3e4373a77', 5, 4, 1, 0, 1, '2021-08-05 21:38:43', '2021-08-05 21:38:43'),
(14, '610c3e4373a77', 5, 5, 1, 0, 1, '2021-08-05 21:38:43', '2021-08-05 21:38:43'),
(15, '610c3e4373a77', 5, 6, 1, 0, 1, '2021-08-05 21:38:43', '2021-08-05 21:38:43'),
(16, '610c42ca17abf', 2, 2, 1, 0, 1, '2021-08-05 21:58:02', '2021-08-05 21:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(500) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `category_id`, `price`, `stock`, `created_at`, `updated_at`, `owner_id`) VALUES
(1, 'Trendyol Farmerke', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur gravida nulla nec erat laoreet placerat. Maecenas quis dictum arcu, et volutpat nulla. Phasellus imperdiet consequat mi quis mattis. Vestibulum pulvinar lectus turpis, et placerat magna condimentum sit amet. In ipsum nisi, egestas a porttitor at, pharetra id dui. Vivamus quis.', 2, 4500, 0, '2021-08-05 20:40:38', '2021-08-05 21:36:56', 8),
(2, 'Trendyol Duks', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut quam tortor. Ut in blandit leo. Etiam et tincidunt neque. Fusce placerat pellentesque turpis in maximus. Donec molestie sit amet ligula id sodales. Suspendisse pulvinar eu massa nec condimentum. Maecenas vitae congue est, nec egestas sapien. Pellentesque at fringilla risus.', 2, 3500, 0, '2021-08-05 20:42:34', '2021-08-05 21:58:02', 8),
(3, 'Trendyol Jakna', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut quam tortor. Ut in blandit leo. Etiam et tincidunt neque. Fusce placerat pellentesque turpis in maximus. Donec molestie sit amet ligula id sodales. Suspendisse pulvinar eu massa nec condimentum. Maecenas vitae congue est, nec egestas sapien. Pellentesque at fringilla risus.', 2, 10000, 0, '2021-08-05 20:43:14', '2021-08-05 21:36:56', 8),
(4, 'PocoFone F3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut quam tortor. Ut in blandit leo. Etiam et tincidunt neque. Fusce placerat pellentesque turpis in maximus. Donec molestie sit amet ligula id sodales. Suspendisse pulvinar eu massa nec condimentum. Maecenas vitae congue est, nec egestas sapien. Pellentesque at fringilla risus.', 3, 55000, 0, '2021-08-05 20:44:31', '2021-08-05 21:38:43', 9),
(5, 'S-BOX kabal', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut quam tortor. Ut in blandit leo. Etiam et tincidunt neque. Fusce placerat pellentesque turpis in maximus. Donec molestie sit amet ligula id sodales. Suspendisse pulvinar eu massa nec condimentum. Maecenas vitae congue est, nec egestas sapien. Pellentesque at fringilla risus.', 4, 1200, 2, '2021-08-05 20:44:55', '2021-08-05 21:38:43', 9),
(6, 'LOGITECH Bežična tastatura K400 PLUS', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In fermentum volutpat eleifend. In non gravida quam, sed vehicula enim. Aenean a dui sodales, vulputate massa a, dignissim risus. In ac augue a enim maximus scelerisque. Duis nec orci pulvinar, consectetur dui a, commodo neque. Ut laoreet porttitor volutpat. Aenean eleifend.', 4, 6000, 1, '2021-08-05 20:48:00', '2021-08-05 21:38:43', 10),
(7, 'Radeon Ryzen 7 3700X', '\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis at lectus luctus, dapibus velit ut, sagittis arcu. Vestibulum ut turpis egestas, bibendum lorem ut, tempus lorem. Integer feugiat semper odio, vitae sollicitudin ligula. Sed lacinia convallis ligula, accumsan rhoncus magna pellentesque vel. Duis blandit enim at sem semper, a facilisis.', 5, 35000, 3, '2021-08-05 20:48:38', '2021-08-05 21:07:36', 10);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `path`, `created_at`) VALUES
(1, 1, '../resources/product_images/13-3a-3cdd361114661_1.webp', '2021-08-05 20:40:38'),
(2, 1, '../resources/product_images/13-ab-db0705f314661_2.webp', '2021-08-05 20:40:38'),
(3, 1, '../resources/product_images/13-af-8b85c22b14661_3.webp', '2021-08-05 20:40:38'),
(4, 2, '../resources/product_images/f56-f6-f551580320210305060640_1210000126023_1.webp', '2021-08-05 20:42:34'),
(5, 2, '../resources/product_images/ad6-ec-ad40fb5620210305060640_1210000126023_2.webp', '2021-08-05 20:42:34'),
(6, 3, '../resources/product_images/676-86-67b3413920210212085424_5902228078722.webp', '2021-08-05 20:43:14'),
(7, 3, '../resources/product_images/a96-1c-a9bf461220210212085424_5902228078722_2.webp', '2021-08-05 20:43:14'),
(8, 3, '../resources/product_images/f16-96-f153f49920210212085424_5902228078722_1.webp', '2021-08-05 20:43:14'),
(9, 4, '../resources/product_images/XIAOMI-Poco-F3-256GB-Night-black-(Crna)-75.png', '2021-08-05 20:44:31'),
(10, 5, '../resources/product_images/image581b49b949b1a.png', '2021-08-05 20:44:55'),
(11, 6, '../resources/product_images/image57fdfc4ef0245.png', '2021-08-05 20:48:00'),
(12, 6, '../resources/product_images/image558a7bf543fbf.png', '2021-08-05 20:48:00'),
(13, 7, '../resources/product_images/image5d66752a42531.png', '2021-08-05 20:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `review` varchar(500) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `rate`, `review`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Odlican', '2021-08-05 21:41:52', '2021-08-05 21:51:06'),
(2, 2, 1, 2, 'Srednje zalosno', '2021-08-05 21:47:24', '2021-08-05 21:51:59'),
(3, 3, 1, 5, 'Savrsena zimska jakna', '2021-08-05 21:52:15', '2021-08-05 21:52:15'),
(4, 6, 1, 5, 'Odlicna tastatura za TV', '2021-08-05 21:52:39', '2021-08-05 21:52:39'),
(5, 7, 2, 5, 'Savrsen procesor za moje potrebe', '2021-08-05 21:54:14', '2021-08-05 21:54:14'),
(6, 2, 2, 5, 'Dobar kvalitet', '2021-08-05 21:58:31', '2021-08-05 21:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_profiles`
--

CREATE TABLE `shipping_profiles` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shipping_profiles`
--

INSERT INTO `shipping_profiles` (`user_id`, `first_name`, `last_name`, `address`, `city`, `zip_code`, `country`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'Test', 'Test`', 'Test', '32210', 'Test', '2021-08-05 21:04:16', '2021-08-05 21:04:16'),
(2, 'Tester', '2', 'Test', 'Test', '35410', 'Test', '2021-08-05 21:06:32', '2021-08-05 21:06:32'),
(5, 'Test', '5', 'Test 5', 'Test5', '89100', 'Test', '2021-08-05 21:37:46', '2021-08-05 21:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'test1', 'Test', '1', 'test@1.com', '5a105e8b9d40e1329780d62ea2265d8a', 'buyer', '2021-08-05 20:21:18', '2021-08-05 20:21:18'),
(2, 'test2', 'Test', '2', 'test@2.com', 'ad0234829205b9033196ba818f7a872b', 'buyer', '2021-08-05 20:21:42', '2021-08-05 20:21:42'),
(3, 'test3', 'Test', '3', 'test@3.com', '8ad8757baa8564dc136c1e07507f4a98', 'buyer', '2021-08-05 20:22:03', '2021-08-05 20:22:03'),
(4, 'test4', 'Test', '4', 'test@4.com', 'e3d704f3542b44a621ebed70dc0efe13', 'buyer', '2021-08-05 20:22:25', '2021-08-05 20:22:25'),
(5, 'test5', 'Test', '5', 'test@5.com', 'e3d704f3542b44a621ebed70dc0efe13', 'buyer', '2021-08-05 20:22:47', '2021-08-05 20:22:47'),
(8, 'tp1', 'TP', '1', '1@prodavac.com', '35a448b5c9018c4b93cd8dbe8502d060', 'seller', '2021-08-05 20:27:34', '2021-08-05 20:27:34'),
(9, 'tp2', 'TP', '2', '2@prodavac.com', '98d648825b692edb5772da0b209b82a3', 'seller', '2021-08-05 20:28:18', '2021-08-05 20:28:18'),
(10, 'tp3', 'TP', '3', '3@prodavac.com', '32efe2815eb7c9abd9e6978b427e680f', 'seller', '2021-08-05 20:28:39', '2021-08-05 20:28:39'),
(11, 'admin', 'Admin', 'Main', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2021-08-05 20:29:06', '2021-08-05 20:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2021-08-05 22:03:41', '2021-08-05 22:03:41'),
(2, 1, 2, '2021-08-05 22:03:43', '2021-08-05 22:03:43'),
(3, 1, 4, '2021-08-05 22:04:32', '2021-08-05 22:04:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shipping_profiles`
--
ALTER TABLE `shipping_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `shipping_profiles` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shipping_profiles`
--
ALTER TABLE `shipping_profiles`
  ADD CONSTRAINT `shipping_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
