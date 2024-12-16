-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 10:13 PM
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
-- Database: `clinicdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL,
  `ResidentID` int(11) DEFAULT NULL,
  `ClinicID` int(11) DEFAULT NULL,
  `AppointmentDate` datetime DEFAULT NULL,
  `Status` enum('Booked','Cancelled','Completed') DEFAULT 'Booked',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinicavailability`
--

CREATE TABLE `clinicavailability` (
  `AvailabilityID` int(11) NOT NULL,
  `ClinicID` int(11) DEFAULT NULL,
  `AvailableDate` datetime DEFAULT NULL,
  `IsAvailable` tinyint(1) DEFAULT 1,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `ClinicID` int(11) NOT NULL,
  `ClinicName` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `ServicesAvailable` text DEFAULT NULL,
  `AvailabilityStatus` enum('Open','Closed') DEFAULT 'Open',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`ClinicID`, `ClinicName`, `Address`, `ContactNumber`, `Email`, `ServicesAvailable`, `AvailabilityStatus`, `CreatedAt`, `latitude`, `longitude`) VALUES
(1, 'General Clinic', NULL, NULL, NULL, NULL, 'Open', '2024-12-16 20:15:05', 11.0507, 124.004),
(2, 'Dental Clinic', NULL, NULL, NULL, NULL, 'Open', '2024-12-16 20:15:05', 11.0512, 124.006),
(3, 'Pediatrics Clinic', NULL, NULL, NULL, NULL, 'Open', '2024-12-16 20:15:05', 11.0487, 124.003);

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `ResidentID` int(11) NOT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `ResidentID` (`ResidentID`),
  ADD KEY `ClinicID` (`ClinicID`);

--
-- Indexes for table `clinicavailability`
--
ALTER TABLE `clinicavailability`
  ADD PRIMARY KEY (`AvailabilityID`),
  ADD KEY `ClinicID` (`ClinicID`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`ClinicID`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`ResidentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinicavailability`
--
ALTER TABLE `clinicavailability`
  MODIFY `AvailabilityID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `ClinicID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `ResidentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`ResidentID`) REFERENCES `residents` (`ResidentID`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`ClinicID`) REFERENCES `clinics` (`ClinicID`);

--
-- Constraints for table `clinicavailability`
--
ALTER TABLE `clinicavailability`
  ADD CONSTRAINT `clinicavailability_ibfk_1` FOREIGN KEY (`ClinicID`) REFERENCES `clinics` (`ClinicID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
