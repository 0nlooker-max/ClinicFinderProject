-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 01:51 PM
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
-- Database: `bitecare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contacts` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_bitten` date NOT NULL,
  `site_of_bite` varchar(255) NOT NULL,
  `biting_animal` varchar(100) NOT NULL,
  `animal_status` enum('Immunized','Unimmunized','Unknown') NOT NULL,
  `animal_owner` varchar(255) DEFAULT NULL,
  `provoke` enum('Yes','No') NOT NULL,
  `place_bitten` varchar(255) DEFAULT NULL,
  `local_wound_treatment` enum('Yes','No') NOT NULL,
  `category_of_exposure` varchar(100) NOT NULL,
  `status_of_biting_animal` varchar(255) DEFAULT NULL,
  `vaccine_brand_name` varchar(255) DEFAULT NULL,
  `rig` varchar(255) DEFAULT NULL,
  `route` varchar(100) DEFAULT NULL,
  `d0_date` date DEFAULT NULL,
  `d3_date` date DEFAULT NULL,
  `d7_date` date DEFAULT NULL,
  `d14_date` date DEFAULT NULL,
  `d28_30_date` date DEFAULT NULL,
  `status_of_animal_after_exposure_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
