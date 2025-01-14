-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 14, 2025 at 02:46 PM
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
-- Database: `imbs_campus`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `course` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `nic`, `name`, `address`, `telephone`, `course`, `created_at`, `updated_at`, `active`) VALUES
(1, '199087654321', 'Nimal Perera', '123 Galle Road, Colombo 03', '0712345678', 'Diploma in Business Studies', '2023-05-15 04:00:00', '2025-01-14 13:26:46', 1),
(2, '945678123V', 'Kumari Silva', '45 Kandy Road, Kandy', '0771234567', 'Diploma in HR Management', '2023-06-22 09:15:00', '2025-01-14 13:26:46', 1),
(3, '198976543210', 'Saman Rathnayake', '67 Marine Drive, Colombo 06', '0751234567', 'Diploma in IT', '2023-07-30 05:45:00', '2025-01-14 13:26:46', 1),
(4, '926789012V', 'Malini Fernando', '89 Nawala Road, Nugegoda', '0724567890', 'Diploma in Psychology & Counselling', '2023-08-12 04:30:00', '2025-01-14 13:26:46', 1),
(5, '197265432109', 'Asanka Gunawardena', '12 Hospital Road, Jaffna', '0777890123', 'Diploma in Business Studies', '2023-09-05 11:00:00', '2025-01-14 13:26:46', 1),
(6, '935678901V', 'Chamathka Lakmali', '34 Galle Road, Matara', '0785678901', 'Diploma in English', '2023-10-18 07:50:00', '2025-01-14 13:26:46', 1),
(7, '197543210987', 'Roshan Dissanayake', '56 Baseline Road, Colombo 09', '0713456789', 'Diploma in IT', '2023-11-25 04:15:00', '2025-01-14 13:26:46', 1),
(8, '955432109V', 'Dilini Jayasinghe', '78 Peradeniya Road, Kandy', '0728901234', 'Diploma in HR Management', '2023-12-30 09:40:00', '2025-01-14 13:26:46', 1),
(9, '198132109876', 'Pradeep Bandara', '90 Galle Road, Galle', '0759012345', 'Diploma in Psychology & Counselling', '2024-01-14 06:00:00', '2025-01-14 13:26:46', 1),
(10, '916543210V', 'Ishara Wickramasinghe', '23 Negombo Road, Negombo', '0776789012', 'Diploma in Business Studies', '2024-02-28 08:30:00', '2025-01-14 13:26:46', 1),
(11, '197698765432', 'Thilina Rajapaksa', '45 Kandy Road, Kegalle', '0723456789', 'Diploma in English', '2024-03-17 05:15:00', '2025-01-14 13:26:46', 1),
(12, '196754321098', 'Chaminda Herath', '67 Beach Road, Matara', '0715678901', 'Diploma in Business Studies', '2023-04-10 03:30:00', '2025-01-14 13:26:46', 0),
(13, '925678901V', 'Nilmini Kumarasinghe', '89 Hill Street, Ratnapura', '0778901234', 'Diploma in IT', '2023-08-05 10:45:00', '2025-01-14 13:26:46', 0),
(14, '198887654321', 'Lakmal Weerasinghe', '12 Temple Road, Colombo 10', '0729012345', 'Diploma in HR Management', '2023-11-20 08:00:00', '2025-01-14 13:26:46', 0),
(15, '936789012V', 'Anusha Ratnayake', '34 Lake Road, Kurunegala', '0756789012', 'Diploma in Psychology & Counselling', '2024-01-05 05:30:00', '2025-01-14 13:26:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$kxhySivsO4U6VpuB6x3yp.BGFON3DNFMaZMI/b2ITN4NR8FLg6fY6', '2025-01-14 06:48:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
