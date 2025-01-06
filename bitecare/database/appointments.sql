-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 04:29 PM
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
-- Database: `bitecare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `PatientName` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` enum('Male','Female','Other') NOT NULL,
  `Address` text NOT NULL,
  `Contacts` varchar(15) NOT NULL,
  `DateOfBirth` date NOT NULL,
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

INSERT INTO `appointments` (`AppointmentID`, `AppointmentDate`, `PatientName`, `Age`, `Gender`, `Address`, `Contacts`, `DateOfBirth`, `DateBitten`, `SiteOfBite`, `BitingAnimal`, `AnimalStatus`, `AnimalOwner`, `Provoke`, `PlaceBitten`, `LocalWoundTreatment`) VALUES
(1, '2025-01-06', 'John Doe', 30, 'Male', '123 Main Street', '1234567890', '1995-05-15', '2025-01-03', 'Left Arm', 'Dog', 'Immunized', 'Jane Doe', 'No', 'Park', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
