-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2025 at 06:33 AM
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
-- Database: `pet_sanctuary`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption`
--

CREATE TABLE `adoption` (
  `Adoption_ID` int(11) NOT NULL,
  `Pet_ID` varchar(20) NOT NULL,
  `Customer_Id` varchar(10) DEFAULT NULL,
  `Food_requirements` varchar(255) DEFAULT NULL,
  `Allergies` varchar(255) DEFAULT NULL,
  `Adoption_status` enum('Pending','Processing','Available','Adopted') NOT NULL DEFAULT 'Processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption`
--

INSERT INTO `adoption` (`Adoption_ID`, `Pet_ID`, `Customer_Id`, `Food_requirements`, `Allergies`, `Adoption_status`) VALUES
(0, 'RP-5', 'ID-3', 'Vegetables and insects', 'Grass Pollen', 'Pending'),
(6, 'RP-2', 'ID-2', 'Small fish and vegetables', 'None', 'Pending'),
(7, 'RP-3', NULL, 'Live or frozen rodents', 'None', 'Pending'),
(8, 'RP-4', 'ID-4', 'Leafy greens and fruits', 'Dust', 'Pending'),
(10, 'RP-6', 'ID-3', 'Hay and tortoise pellets', 'None', 'Pending'),
(11, 'RP-7', NULL, NULL, NULL, 'Processing'),
(12, 'RP-100', 'ID-3', NULL, NULL, 'Adopted'),
(13, 'RP-8', NULL, 'Gut-loaded insects and leafy greens', 'None', 'Pending'),
(14, 'RP-9', NULL, 'Frozen/thawed mice or rats', 'Feathers or Dander', 'Available'),
(15, 'RP-10', NULL, 'Turtle pellets and occasional fish/greens', 'Chlorine', 'Available'),
(16, 'RP-11', NULL, 'Hay, Vitamin C pellets, and fresh veggies', 'Timothy Hay', 'Available'),
(17, 'RP-12', NULL, 'Unlimited hay and specific pelleted food', 'Dust', 'Pending'),
(18, 'RP-13', NULL, 'Small crickets or mealworms', 'None', 'Available'),
(19, 'RP-14', NULL, 'Crested Gecko diet powder and small insects', 'Pollen', 'Available'),
(20, 'HM-1', NULL, NULL, NULL, 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking_ID` char(10) NOT NULL,
  `Booking_Time` time DEFAULT NULL,
  `Booking_Date` date DEFAULT NULL,
  `Group_size` int(11) DEFAULT NULL,
  `Customer_Id` varchar(10) DEFAULT NULL,
  `Pet_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking_ID`, `Booking_Time`, `Booking_Date`, `Group_size`, `Customer_Id`, `Pet_ID`) VALUES
('BK-1001', '10:00:00', '2025-10-10', NULL, 'ID-2', 'RP-2'),
('BK-1002', '14:30:00', '2025-10-10', NULL, 'ID-4', 'RP-4'),
('BK-1005', '09:00:00', '2025-10-13', NULL, 'ID-2', 'RP-2'),
('BK-5594', '10:30:00', '2025-11-19', 30, 'ID-3', 'RP-6');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `Pet_ID` varchar(20) NOT NULL,
  `Pet_type` varchar(50) DEFAULT NULL,
  `Pet_Name` varchar(50) DEFAULT NULL,
  `Age_Years` int(11) DEFAULT NULL,
  `Vaccinations` int(11) DEFAULT NULL,
  `Environment_condition` varchar(100) DEFAULT NULL,
  `Adoption_requirements` varchar(255) DEFAULT NULL,
  `Booking_requirements` varchar(255) DEFAULT NULL,
  `Sex` char(1) DEFAULT NULL,
  `status` enum('processing','processed','unavailable') NOT NULL DEFAULT 'processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`Pet_ID`, `Pet_type`, `Pet_Name`, `Age_Years`, `Vaccinations`, `Environment_condition`, `Adoption_requirements`, `Booking_requirements`, `Sex`, `status`) VALUES
('HM-1', 'Hamster', 'Leo', 5, 0, 'na', 'na', 'na', 'M', 'processing'),
('RP-10', 'Red-Eared Slider', 'Shelly', 5, 3, 'Large aquatic environment with basking area', 'Commitment to long-term care (20+ years)', 'Feeding time viewing', 'F', 'processed'),
('RP-100', 'cat', 'cant', 3, 2, '0', 'juw', 'qj', 'M', 'unavailable'),
('RP-11', 'Guinea Pig', 'Cuddles', 0, 0, 'Clean, bedding-filled cage', 'A home with a companion guinea pig or committed interaction time', 'Supervised petting area', 'M', 'processed'),
('RP-12', 'Rabbit (Lionhead)', 'Fluffy', 2, 1, 'Indoor pen with running space', 'Requires daily exercise and specific vegetable diet', 'Outdoor run viewing (weather permitting)', 'F', 'processed'),
('RP-13', 'Tarantula (Chilean Rose)', 'Rosie', 6, 0, 'Dry, room temperature enclosure', 'Knowledge of invertebrate care, hands-off approach', 'Glass viewing only', 'F', 'processed'),
('RP-14', 'Crested Gecko', 'Gecky', 1, 0, 'Tropical forest habitat, vertical space', 'Requires nightly misting and fruit-based commercial diet', 'Brief observation period', 'M', 'processed'),
('RP-2', 'Black Turtle', 'Brownie', 3, 3, 'Calm', 'A calm environment', 'none', 'M', 'unavailable'),
('RP-3', 'Corn Snake', 'Buck', 2, 1, 'Quiet', 'Experienced handler only', 'none', 'M', 'unavailable'),
('RP-4', 'Iguana', 'Jimmy', 4, 1, 'High energy', 'A stable and active home', 'none', 'M', 'unavailable'),
('RP-5', 'Box Turtle', 'Dante', 2, 3, 'Calm', 'A calm environment', 'none', 'M', 'unavailable'),
('RP-6', 'Russian Tortoise', 'Lisa', 8, 4, 'Calm', 'A calm environment', 'none', 'F', 'unavailable'),
('RP-7', 'Lizard', 'ywy', 2, 0, 'nw', 'jw', 'jw', 'M', 'unavailable'),
('RP-8', 'Bearded Dragon', 'Smaug', 1, 2, 'Desert-like, high UV light', 'Experienced reptile owner, large tank required', 'Brief handling session only', 'M', 'processed'),
('RP-9', 'Ball Python', 'Nagini', 3, 1, 'Warm, humid hideout', 'Must be comfortable handling snakes, secure enclosure', 'Viewing from behind glass only', 'F', 'processed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Customer_Id` varchar(10) NOT NULL,
  `First_name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Join_Date` date DEFAULT curdate(),
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Customer_Id`, `First_name`, `Last_Name`, `Email`, `Address`, `Phone`, `Join_Date`, `Password`) VALUES
('ID-1', 'Sara', 'Conner', 'sara@gmail.com', '123 Main St', '555-1234', '2025-01-15', 'sara123'),
('ID-2', 'Kyle', 'Reese', 'kyle@gmail.com', '456 Oak Ave', '555-5678', '2025-02-20', 'kyle123'),
('ID-3', 'T-800', 'Terminator', 't800@gmail.com', '789 Pine Ln', '555-9012', '2025-03-01', 't800123'),
('ID-4', 'Sarah', 'Connor', 'sarah@gmail.com', '321 Elm Rd', '555-3456', '2025-03-10', 'sarah123'),
('ID-5', 'John', 'Connor', 'john@gmail.com', '654 Birch Ct', '555-7890', '2025-04-05', 'john123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption`
--
ALTER TABLE `adoption`
  ADD PRIMARY KEY (`Adoption_ID`),
  ADD KEY `fk_adoption_customer` (`Customer_Id`),
  ADD KEY `fk_adoption_pet` (`Pet_ID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Pet_ID` (`Pet_ID`),
  ADD KEY `fk_booking_customer` (`Customer_Id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`Pet_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Customer_Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Phone` (`Phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption`
--
ALTER TABLE `adoption`
  MODIFY `Adoption_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption`
--
ALTER TABLE `adoption`
  ADD CONSTRAINT `fk_adoption_customer` FOREIGN KEY (`Customer_Id`) REFERENCES `users` (`Customer_Id`),
  ADD CONSTRAINT `fk_adoption_pet` FOREIGN KEY (`Pet_ID`) REFERENCES `pets` (`Pet_ID`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Pet_ID`) REFERENCES `pets` (`Pet_ID`),
  ADD CONSTRAINT `fk_booking_customer` FOREIGN KEY (`Customer_Id`) REFERENCES `users` (`Customer_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
