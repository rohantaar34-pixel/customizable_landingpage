-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2025 at 03:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inandout`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `about` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `about`) VALUES
(1, 'In & Out Cleaning Experts began with a simple story of starting fresh in South Australia. When we migrated here in 2023, we had no family nearby and had to build everything from the ground up — finding a home, a car, and a new beginning.\r\n\r\nOur first car, a 1992 Toyota Corolla, needed some work. I decided to restore and clean it myself, and that experience sparked something unexpected — a real passion for cleaning and transformation. From there, I thought, why not turn this passion into something meaningful?\r\n\r\nI registered my ABN, began subcontracting to learn the ins and outs of the cleaning industry, and soon started receiving amazing feedback from clients who appreciated my attention to detail. That encouragement inspired me to build something bigger — a cleaning service people could genuinely trust.\r\n\r\nI’m not a risk-taker by nature, but I believe in steady growth and doing things the right way. What started as a small side hustle after work has now grown into a fully operational cleaning business serving both *residential and commercial clients across South Australia*.\r\n\r\nAt *In & Out Cleaning Experts*, we’re committed to delivering cleaning services that are *reliable, thorough, and genuine*. Our goal is not only to keep homes and workplaces fresh and spotless, but also to provide opportunities for others who are just starting out — helping them earn, grow, and achieve their dreams alongside ours.\r\n\r\nFrom humble beginnings to a growing local business — we’re proud to serve our community, one clean space at a time.');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user`, `password`, `created_at`) VALUES
(1, 'user', '$2y$10$SZcY./YQUhhKulvmJ8LJCuZG/QXdoyHpqEquU67EcXDdsQYQD.nYK', '2025-11-06 11:57:13');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_ref` varchar(50) DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `booking_date` int(11) DEFAULT NULL,
  `booking_time` varchar(20) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_city` varchar(100) DEFAULT NULL,
  `customer_state` varchar(50) DEFAULT NULL,
  `customer_zip` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','approved','declined') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_ref`, `service`, `price`, `booking_date`, `booking_time`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_city`, `customer_state`, `customer_zip`, `notes`, `status`, `created_at`) VALUES
(1, 'BK202511021D54FE', 'Residential Cleaning', 48.00, 7, '12:00 PM', 'Rohan Taar', 'rohantaar34@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', 'wala', 'pending', '2025-11-02 12:02:09'),
(2, 'BK202511088C3580', 'Residential Cleaning', NULL, 8, '12:00 PM', 'Rohan Taar', 'Rohantaar70@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', '', 'pending', '2025-11-08 03:12:56'),
(3, 'BK202511086779D0', 'Residential Cleaning', NULL, 10, '6:00 AM', 'Rohan Taar', 'Rohantaar70@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', 'asd', 'pending', '2025-11-08 04:46:46'),
(4, 'BK20251108163A2B', 'Residential Cleaning', NULL, 8, '12:00 PM', 'Rohan Taar', 'Rohantaar70@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', '', 'pending', '2025-11-08 04:50:41'),
(5, 'BK202511087253D4', 'Residential Cleaning', NULL, 13, '6:00 AM', 'Rohan Taar', 'Rohantaar70@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', '', 'pending', '2025-11-08 04:54:31'),
(6, 'BK20251204AA5F25', 'Residential Cleaning', 130.00, 4, '1:00 PM', 'Rohan Taar', 'Rohantaar70@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', 'asdasd', 'pending', '2025-12-04 13:15:54'),
(7, 'BK2025120482AA00', 'Residential Cleaning', 137.00, 6, '6:30 AM', 'Rohan Taar', 'Rohantaar34@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', 'asdasd', 'pending', '2025-12-04 13:41:44'),
(8, 'BK20251204BC770E', 'Residential Cleaning', 142.00, 5, '2:00 PM', 'Rohan Taar', 'Rohantaar34@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', '', 'pending', '2025-12-04 13:52:43'),
(9, 'BK2025120523CAA5', 'Residential Cleaning', 136.00, 7, '1:00 PM', 'wasdasd', 'catcontrolalttrash@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', '', 'pending', '2025-12-05 13:51:46'),
(10, 'BK20251205038D06', 'Residential Cleaning', 136.00, 6, '1:00 PM', 'Rohan Taar', 'catcontrolalttrash@gmail.com', '09352632690', 'Purok1', 'Jaen', 'Nueva Ecija', '3109', '', 'pending', '2025-12-05 14:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `contact_method` varchar(50) DEFAULT 'email',
  `message` text NOT NULL,
  `agree_terms` tinyint(1) DEFAULT 1,
  `status` enum('new','in_progress','completed','cancelled') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_inquiries`
--

INSERT INTO `contact_inquiries` (`id`, `full_name`, `email`, `phone`, `service_type`, `contact_method`, `message`, `agree_terms`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Rohan Taar', 'Rohantaar70@gmail.com', '+639352632690', 'regular_cleaning', 'email', 'asdasd', 1, 'new', '2025-11-08 05:25:04', '2025-11-08 05:25:04'),
(2, 'Rohan Taar', 'Rohantaar70@gmail.com', '+639352632690', 'regular_cleaning', 'email', 'asdasd', 1, 'new', '2025-11-08 05:25:14', '2025-11-08 05:25:14'),
(3, 'Rohan Taar', 'Rohantaar70@gmail.com', '+639352632690', 'deep_cleaning', 'email', 'asdasd', 1, 'new', '2025-11-08 05:31:18', '2025-11-08 05:31:18'),
(4, 'Rohan Taar', 'Rohantaar70@gmail.com', '+639352632690', 'regular_cleaning', 'Email', 'asd', 1, 'new', '2025-11-08 05:37:05', '2025-11-08 05:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `homepage`
--

CREATE TABLE `homepage` (
  `id` int(11) NOT NULL,
  `cta` longtext NOT NULL,
  `support_headline` longtext NOT NULL,
  `button_cta` text NOT NULL,
  `card1` longtext NOT NULL,
  `card2` longtext NOT NULL,
  `card3` longtext NOT NULL,
  `card4` longtext NOT NULL,
  `image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage`
--

INSERT INTO `homepage` (`id`, `cta`, `support_headline`, `button_cta`, `card1`, `card2`, `card3`, `card4`, `image`) VALUES
(1, 'In & Out — We’ve Got You Covered.', 'From sparkling homes to spotless offices, In & Out Cleaning Experts delivers quality cleaning services you can trust. Proudly locally owned, we provide reliable, affordable, and professional cleaning solutions — keeping your space fresh, healthy, and beautifully maintained, inside and out.', 'Book  us now!', 'Excellent  Service', 'Locally Owned', 'Reliable Result', 'Affordable', 'uploads/ec2e86d8a706b875.png');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(12) NOT NULL,
  `service_name` text NOT NULL,
  `service_desc` longtext NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gst` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_name`, `service_desc`, `price`, `gst`) VALUES
(7, 'Residential Cleaning', 'Keep your home fresh, organised, and spotless.\n*Includes:* dusting, vacuuming, mopping, bathroom & kitchen cleaning, and more.\nOne-time or regular weekly/fortnightly cleaning available.', 120.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_adds_on`
--

CREATE TABLE `service_adds_on` (
  `id` int(12) NOT NULL,
  `service_id` int(12) NOT NULL,
  `adds_on` text NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_adds_on`
--

INSERT INTO `service_adds_on` (`id`, `service_id`, `adds_on`, `price`) VALUES
(51, 7, 'Oven cleaning', 10.00),
(52, 7, 'Exhaust cleaning', 6.00),
(53, 7, 'Fridge cleaning', 5.00),
(54, 7, 'Indoor & outdoor window cleaning', 4.00),
(55, 7, 'Inside window tracks & frames', 7.00),
(56, 7, 'Outdoor area cleaning', 8.00);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `feedback` text NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `before_image` varchar(255) DEFAULT NULL,
  `after_image` varchar(255) DEFAULT NULL,
  `rating` int(1) DEFAULT 5,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `service_type`, `feedback`, `avatar`, `before_image`, `after_image`, `rating`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Albert', 'Apartment Cleaning', 'They transformed my messy apartment into a spotless home! Super professional and fast. I couldn\'t believe how thorough they were - even the hard-to-reach corners were sparkling clean. The team was respectful of my belongings and finished everything on time. Highly recommended!', 'uploads/testimonials/avatar_1763259316_691933b460101.jpg', 'uploads/testimonials/before_1763259296_691933a049469.png', '../images/after-1.jpg', 3, 1, '2025-11-16 01:35:36', '2025-11-16 02:19:48'),
(2, 'Dr. Luis Ramos', 'Hospital Gardening', 'Our hospital garden now looks fresh and welcoming. They handled everything perfectly with attention to detail and professionalism. The patients and staff have all commented on how beautiful the grounds look now. Their maintenance schedule keeps everything looking pristine.', NULL, '../images/before-2.jpg', '../images/after-2.jpg', 5, 1, '2025-11-16 01:35:36', '2025-11-16 02:14:07'),
(3, 'Mia Santos', 'Office Cleaning', 'Reliable team! They made our office sparkling clean — even the corners! Our employees noticed the difference immediately. The cleaning crew is always punctual and professional. They\'ve helped create a much more pleasant work environment for everyone.', '', 'uploads/testimonials/before_1763259275_6919338ba6f2a.png', '../images/after-1.jpg', 5, 1, '2025-11-16 01:35:36', '2025-11-16 02:14:35'),
(4, 'Anna Reyes', 'Apartment Cleaning', 'They transformed my messy apartment into a spotless home! Super professional and fast. I couldn\'t believe how thorough they were - even the hard-to-reach corners were sparkling clean. The team was respectful of my belongings and finished everything on time. Highly recommended!', NULL, '../images/before-1.jpg', '../images/after-1.jpg', 5, 1, '2025-11-16 01:35:36', '2025-11-16 02:14:07'),
(5, 'Dr. Luis Ramos', 'Hospital Gardening', 'Our hospital garden now looks fresh and welcoming. They handled everything perfectly with attention to detail and professionalism. The patients and staff have all commented on how beautiful the grounds look now. Their maintenance schedule keeps everything looking pristine.', NULL, '../images/before-2.jpg', '../images/after-2.jpg', 5, 1, '2025-11-16 01:35:36', '2025-11-16 02:14:07'),
(6, 'Mia Santos', 'Office Cleaning', 'Reliable team! They made our office sparkling clean — even the corners! Our employees noticed the difference immediately. The cleaning crew is always punctual and professional. They\'ve helped create a much more pleasant work environment for everyone.', NULL, '../images/before-1.jpg', '../images/after-1.jpg', 5, 1, '2025-11-16 01:35:36', '2025-11-16 02:14:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_ref` (`booking_ref`);

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `homepage`
--
ALTER TABLE `homepage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_adds_on`
--
ALTER TABLE `service_adds_on`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `homepage`
--
ALTER TABLE `homepage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `service_adds_on`
--
ALTER TABLE `service_adds_on`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
