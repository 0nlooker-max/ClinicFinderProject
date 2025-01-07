-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 09:01 AM
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
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `address` text NOT NULL,
  `contacts` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `DateBitten` date NOT NULL,
  `SiteOfBite` varchar(100) DEFAULT NULL,
  `BitingAnimal` varchar(100) DEFAULT NULL,
  `AnimalStatus` enum('Immunized','Unimmunized','Unknown') NOT NULL,
  `AnimalOwner` varchar(100) DEFAULT NULL,
  `Provoke` enum('Yes','No') NOT NULL,
  `PlaceBitten` varchar(100) DEFAULT NULL,
  `LocalWoundTreatment` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`AppointmentID`, `AppointmentDate`, `patient_name`, `age`, `gender`, `address`, `contacts`, `dob`, `DateBitten`, `SiteOfBite`, `BitingAnimal`, `AnimalStatus`, `AnimalOwner`, `Provoke`, `PlaceBitten`, `LocalWoundTreatment`) VALUES
(1, '2025-01-06', 'John Doe', 30, 'Male', '123 Main Street', '1234567890', '1995-05-15', '2025-01-03', 'Left Arm', 'Dog', 'Immunized', 'Jane Doe', 'No', 'Park', 'Yes'),
(2, '2025-01-08', 'df', 12, 'Female', 'adasfs', 'f000', '2025-01-21', '2025-01-16', 'legs', 'dog', 'Unimmunized', 'na', 'No', 'add', 'Yes'),
(3, '2025-01-09', 'asdfg', 22, '', 'asdf', 'asdf', '2025-01-13', '2025-01-22', 'asdf', 'asdfg', 'Unimmunized', 'asdf', 'Yes', 'asdf', 'Yes'),
(4, '2025-01-09', 'kate', 21, '', 'asd', 'asd', '2025-01-13', '2025-01-08', 'asdf', 'awsedrf', 'Immunized', 'asdf', 'Yes', 'asd', 'Yes'),
(5, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', ''),
(6, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', ''),
(7, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', ''),
(8, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', ''),
(9, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', ''),
(10, '2025-01-09', '', 0, 'Male', '', '', '0000-00-00', '0000-00-00', NULL, NULL, 'Immunized', NULL, 'Yes', NULL, 'Yes'),
(11, '2025-01-09', '', 0, 'Male', '', '', '0000-00-00', '0000-00-00', NULL, NULL, 'Immunized', NULL, 'Yes', NULL, 'Yes'),
(12, '2025-01-09', '', 0, 'Male', '', '', '0000-00-00', '0000-00-00', NULL, NULL, 'Immunized', NULL, 'Yes', NULL, 'Yes'),
(13, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', ''),
(14, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', ''),
(15, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', ''),
(16, '0000-00-00', '', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_slots`
--

CREATE TABLE `appointment_slots` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `available_slots` int(11) NOT NULL DEFAULT 0,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_slots`
--

INSERT INTO `appointment_slots` (`id`, `date`, `available_slots`, `status`) VALUES
(11, '2025-01-09', 2, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_bitten` date NOT NULL,
  `site_of_bite` varchar(100) NOT NULL,
  `biting_animal` varchar(50) NOT NULL,
  `animal_status` enum('Immunized','Unimmunized','Unknown') NOT NULL,
  `animal_owner` varchar(100) DEFAULT NULL,
  `provoke` enum('Yes','No') NOT NULL,
  `place_bitten` varchar(100) NOT NULL,
  `local_wound_treatment` enum('Yes','No') NOT NULL,
  `reservation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contacts` varchar(255) DEFAULT NULL,
  `usertype` enum('admin','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `contacts`, `usertype`) VALUES
(1, 'Admin', 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227', '1234567890', 'admin'),
(7, 'kate', 'kate', '44844b8aa9d746a5d4c101a588644394115d190f', '09773211205', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`);

--
-- Indexes for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
