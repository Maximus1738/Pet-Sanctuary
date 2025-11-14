-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 09:00 PM
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
  `Customer_Id` int(11) NOT NULL,
  `Pet_ID` varchar(50) DEFAULT NULL,
  `Food_requirements` varchar(255) DEFAULT NULL,
  `Allergies` varchar(255) DEFAULT NULL,
  `Adoption_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption`
--

INSERT INTO `adoption` (`Customer_Id`, `Pet_ID`, `Food_requirements`, `Allergies`, `Adoption_status`) VALUES
(0, 'RP-2', 'Small fish and vegetables', 'None', 'Pending'),
(2, 'RP-3', 'Live or frozen rodents', 'None', 'Available'),
(3, 'RP-6', 'Hay and tortoise pellets', 'None', 'Pending'),
(4, 'RP-5', 'Vegetables and insects', 'Grass Pollen', 'Adopted'),
(6, 'RP-9', 'Standard diet', 'None', 'Pending'),
(8, 'RP-8', 'Standard diet', 'None', 'Pending'),
(9, 'RP-4', 'Leafy greens and fruits', 'Dust', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking_ID` char(10) NOT NULL,
  `Booking_Time` time DEFAULT NULL,
  `Booking_Date` date DEFAULT NULL,
  `Group_size` int(11) DEFAULT NULL,
  `Customer_Id` int(11) NOT NULL,
  `Pet_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking_ID`, `Booking_Time`, `Booking_Date`, `Group_size`, `Customer_Id`, `Pet_ID`) VALUES
('BK-1001', '10:00:00', '2025-10-10', 2, 1, 'RP-2'),
('BK-1002', '14:30:00', '2025-10-10', 4, 3, 'RP-4'),
('BK-1003', '11:00:00', '2025-10-11', 1, 2, 'RP-6'),
('BK-1004', '15:00:00', '2025-10-12', 3, 5, 'RP-5'),
('BK-1005', '09:00:00', '2025-10-13', 2, 4, 'RP-2');

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
  `Sex` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`Pet_ID`, `Pet_type`, `Pet_Name`, `Age_Years`, `Vaccinations`, `Environment_condition`, `Adoption_requirements`, `Booking_requirements`, `Sex`) VALUES
('', '', '', 0, 0, '', '', '', ''),
('CT-1', 'Cat', 'baxter', 9, 0, 'n/a', 'n/a', 'n/a', 'M'),
('DG-7', 'German Shepard', 'Lily', 4, 5, 'Large Play Area', 'Large Backyard', 'N/A', 'F'),
('DG-8', 'Dog', 'butta dog', 3, 0, 'e ojc ', 'ow', 'kek', 'M'),
('HM-1', 'Hamster', 'Chewy', 9, 0, 'n/a', 'n/a', 'n/a', 'M'),
('RP-2', 'Black Turtle', 'Brownie', 3, 3, 'Calm', 'A calm environment', 'none', 'M'),
('RP-3', 'Corn Snake', 'Buck', 2, 1, 'Quiet', 'Experienced handler only', 'none', 'M'),
('RP-4', 'Iguana', 'Jimmy', 4, 1, 'High energy', 'A stable and active home', 'none', 'M'),
('RP-5', 'Box Turtle', 'Dante', 2, 3, 'Calm', 'A calm environment', 'none', 'M'),
('RP-6', 'Russian Tortoise', 'Lisa', 8, 4, 'Calm', 'A calm environment', 'none', 'F'),
('RP-7', 'Dart Frog', 'Flo', 2, 2, 'High Sanitation', 'Gloves', 'Gloves', 'M'),
('RP-8', 'Red-Eared Slider', 'Shelly', 4, 2, 'Aquatic', 'Needs water filtration and basking area', 'none', 'F'),
('RP-9', 'Bearded Dragon', 'Spike', 5, 3, 'Warm and dry', 'Requires UVB lighting and heat lamp', 'none', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Customer_Id` int(11) NOT NULL,
  `First_name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Join_Date` date DEFAULT curdate(),
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Customer_Id`, `First_name`, `Last_Name`, `Address`, `Phone`, `Join_Date`, `Password`, `Email`) VALUES
(1, 'Sara', 'Conner', '123 Main St', '555-1234', '2025-01-15', 'sara123', 'sara.conner@example.com'),
(2, 'Kyle', 'Reese', '456 Oak Ave', '555-5678', '2025-02-20', 'kyle123', 'kyle.reese@example.com'),
(3, 'T-800', 'Terminator', '789 Pine Ln', '555-9012', '2025-03-01', 't800123', 't800.terminator@example.com'),
(4, 'Sarah', 'Connor', '321 Elm Rd', '555-3456', '2025-03-10', 'sarah123', 'sarah.connor@example.com'),
(5, 'John', 'Connor', '654 Birch Ct', '555-7890', '2025-04-05', 'john123', 'john.connor@example.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption`
--
ALTER TABLE `adoption`
  ADD PRIMARY KEY (`Customer_Id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Customer_Id` (`Customer_Id`),
  ADD KEY `Pet_ID` (`Pet_ID`);

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
  ADD UNIQUE KEY `Phone` (`Phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption`
--
ALTER TABLE `adoption`
  MODIFY `Customer_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Customer_Id`) REFERENCES `users` (`Customer_Id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Pet_ID`) REFERENCES `pets` (`Pet_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
