-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2024 at 02:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_rental_agency_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(255) DEFAULT NULL,
  `car_id` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `no_of_days` int(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_id`, `car_id`, `customer_id`, `no_of_days`, `start_date`, `end_date`, `created_at`) VALUES
(1, 'C0cJDKTuEvMIUH6O8PDLu7ZijtY43q', '6WmYLtwlvv7vH7a3Xwqc5XWmgUGSkC', '9kSdGY3rVGrJ02qCxvfKABMwiou5Ik', 3, '2024-03-13', NULL, '2024-03-08 22:13:44'),
(2, 'MYr9bn8OJEO4vlIwEOQyMCCUiVP57p', 'G9uGYXunoMZ3wzqhyWVpt31hckOeYw', '9kSdGY3rVGrJ02qCxvfKABMwiou5Ik', 4, '2024-03-26', NULL, '2024-03-08 22:14:56'),
(3, 'faWLAPnjmIGItS9YlcdRyLSMcKKgTa', 'uIh9XtdCQLfbAP00SDZEkxsBFEO0KW', '9kSdGY3rVGrJ02qCxvfKABMwiou5Ik', 4, '2024-03-23', NULL, '2024-03-08 22:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `car_id` varchar(255) DEFAULT NULL,
  `agency_id` varchar(255) DEFAULT NULL,
  `vehicle_model` varchar(100) DEFAULT NULL,
  `vehicle_number` varchar(20) DEFAULT NULL,
  `seating_capacity` int(11) DEFAULT NULL,
  `rent_per_day` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `car_id`, `agency_id`, `vehicle_model`, `vehicle_number`, `seating_capacity`, `rent_per_day`, `image_url`, `created_at`) VALUES
(1, 'Xo7zOPF9jasSzvwSfUGBe15UhleVNh', 'bkcEb7y75ysUv77dkkZQeSAF5kN802', 'Toyota Camry', '4453324', 6, 63.00, 'uploads/car_images/1709907175_dima-panyukov-DwxlhTvC16Q-unsplash.jpg', '2024-03-08 14:12:56'),
(2, 'qLaVlmx7JwotgMDYtrgnT3QfZprC46', 'bkcEb7y75ysUv77dkkZQeSAF5kN802', 'Benx ', '334', 2, 535.00, 'uploads/car_images/1709907231_dhiva-krishna-YApS6TjKJ9c-unsplash.jpg', '2024-03-08 14:13:52'),
(6, 'G9uGYXunoMZ3wzqhyWVpt31hckOeYw', 'bkcEb7y75ysUv77dkkZQeSAF5kN802', 'Camry Toyota', '454', 343, 657.00, 'uploads/car_images/1709915105_marek-pospisil-oUBjd22gF6w-unsplash.jpg', '2024-03-08 16:24:58'),
(7, 'uIh9XtdCQLfbAP00SDZEkxsBFEO0KW', 'A0o6u7DrDgJeBCBT1h2nHOWUl9n16G', 'Toyota Camry', '335', 32, 40.00, 'uploads/car_images/1709915275_marek-pospisil-oUBjd22gF6w-unsplash.jpg', '2024-03-08 16:27:56'),
(8, '6WmYLtwlvv7vH7a3Xwqc5XWmgUGSkC', 'bkcEb7y75ysUv77dkkZQeSAF5kN802', 'Toyota Benz', '3453', 4, 43.00, 'uploads/car_images/1709921384_hakon-sataoen-qyfco1nfMtg-unsplash.jpg', '2024-03-08 18:09:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` enum('customer','agency') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `first_name`, `last_name`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'HhDJtUs6s63j9XmwkJTZwx8eABX28D', 'dcvb', 'ASD', 'admin@example.com', '$2y$10$LQ2h9WsYN.JrfEDJb6m8QuQ/LaWuVA/I8Z7ehrhXjDP11N2KZWaPe', 'customer', '2024-03-08 09:39:11'),
(2, '9kSdGY3rVGrJ02qCxvfKABMwiou5Ik', 'Loveday ', 'Rich', 'loverich@gmail.com', '$2y$10$F3xdj1wZc2VP2/8Zjw2DK.RqZIjKrO1mHzSu091ynSUCZAyVkF1hG', 'customer', '2024-03-08 09:41:12'),
(3, 'UKWOvpMa2dV8gnGOW96p3ARkumHKFv', 'Paul', 'Johnson', 'pauljohn@gmail.com', '$2y$10$DIYxHXPu3jopfggpcyvSHesNbB5XFxs.gchEtY4WXptNv00XOjI5u', 'customer', '2024-03-08 09:42:45'),
(4, 'bkcEb7y75ysUv77dkkZQeSAF5kN802', 'Micheal', 'Brown', 'micheal@gmail.com', '$2y$10$xHt/F7cgM10hfjObEbUtN.27qFwTBftEzY8JaYiRH7hH/gqkVkkLi', 'agency', '2024-03-08 09:45:23'),
(5, 'A0o6u7DrDgJeBCBT1h2nHOWUl9n16G', 'James', 'Bond', 'james@gmail.com', '$2y$10$BneMQksaE34CRWWdtEUkMethBqDNnWEpKds58EoAYEK71Rpn4j9Ge', 'agency', '2024-03-08 10:33:51'),
(6, 'WXOlF4YJa2AmyTLYVKiE9JmxyrjqbP', 'Mike', 'Joohn', 'mike@gmail.com', '$2y$10$aassxvSX1AukmXOtTAZ5PuRkQY8IOXLfx/lAoxvyb8ld7faNEsDbG', 'customer', '2024-03-08 12:54:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `car_id` (`car_id`),
  ADD UNIQUE KEY `vehicle_number` (`vehicle_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
