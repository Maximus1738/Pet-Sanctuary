-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 04:08 PM
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
(7, 'RP-3', 'ID-3', 'Live or frozen rodents', 'None', 'Adopted'),
(8, 'RP-4', NULL, 'Leafy greens and fruits', 'Dust', 'Available'),
(10, 'RP-6', NULL, 'Hay and tortoise pellets', 'None', 'Available'),
(11, 'RP-7', NULL, NULL, NULL, 'Processing'),
(12, 'RP-100', 'ID-3', NULL, NULL, 'Adopted'),
(13, 'RP-8', NULL, 'Gut-loaded insects and leafy greens', 'None', 'Available'),
(14, 'RP-9', NULL, 'Frozen/thawed mice or rats', 'Feathers or Dander', 'Available'),
(15, 'RP-10', NULL, 'Turtle pellets and occasional fish/greens', 'Chlorine', 'Available'),
(17, 'RP-12', NULL, 'Unlimited hay and specific pelleted food', 'Dust', 'Available'),
(18, 'RP-13', NULL, 'Small crickets or mealworms', 'None', 'Available'),
(19, 'RP-14', NULL, 'Crested Gecko diet powder and small insects', 'Pollen', 'Available'),
(20, 'HM-1', NULL, NULL, NULL, 'Processing'),
(21, 'TO-1', NULL, 'N/A', 'N/A', 'Processing'),
(22, 'GU-1', NULL, 'N/A', 'N/A', 'Processing'),
(23, 'BI-1', NULL, 'N/A', 'N/A', 'Processing'),
(24, 'OT-1', 'ID-1', 'N/A', 'N/A', 'Available'),
(25, 'FI-1', NULL, 'N/A', 'N/A', 'Available');

--
-- Triggers `adoption`
--
DELIMITER $$
CREATE TRIGGER `after_adoption_status_adopted` AFTER UPDATE ON `adoption` FOR EACH ROW BEGIN
    -- Check if the Adoption_status has changed to 'Adopted'
    IF NEW.Adoption_status = 'Adopted' AND OLD.Adoption_status != 'Adopted' THEN
        -- Update the corresponding pet status to 'unavailable'
        UPDATE pets
        SET status = 'unavailable'
        WHERE Pet_ID = NEW.Pet_ID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_adoption_pending_to_pet_unavailable` AFTER UPDATE ON `adoption` FOR EACH ROW BEGIN
    -- Only execute the update if the Adoption_status was changed to 'Pending'
    -- and the status actually changed (to prevent unnecessary updates)
    IF NEW.Adoption_status = 'Pending' AND NEW.Adoption_status <> OLD.Adoption_status THEN
        -- Update the corresponding pet's status to 'unavailable'
        UPDATE `pets`
        SET `status` = 'unavailable'
        WHERE `Pet_ID` = NEW.Pet_ID;
    END IF;
END
$$
DELIMITER ;

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
  `Pet_ID` varchar(20) NOT NULL,
  `Pet_Source` enum('pets','exotic') DEFAULT 'pets'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking_ID`, `Booking_Time`, `Booking_Date`, `Group_size`, `Customer_Id`, `Pet_ID`, `Pet_Source`) VALUES
('BK-1002', '14:30:00', '2025-10-10', NULL, 'ID-4', 'RP-4', 'pets'),
('BK-1272', '11:08:00', '2025-11-28', 1, 'ID-3', 'RP-14', 'pets'),
('BK-2929', '09:56:00', '2025-11-27', 3, 'ID-3', 'RP-8', 'pets'),
('BK-4354', '15:00:00', '2025-12-23', 1, 'ID-3', 'EX-1', 'exotic'),
('BK-4950', '11:08:00', '2025-11-28', 1, 'ID-3', 'RP-14', 'pets'),
('BK-5594', '10:30:00', '2025-11-19', 30, 'ID-3', 'RP-6', 'pets'),
('BK-8881', '10:01:00', '2025-11-27', 1, 'ID-3', 'RP-9', 'pets');

--
-- Triggers `booking`
--
DELIMITER $$
CREATE TRIGGER `before_booking_insert` BEFORE INSERT ON `booking` FOR EACH ROW BEGIN
    DECLARE pet_exists INT DEFAULT 0;
    DECLARE exotic_exists INT DEFAULT 0;
    
    -- Check if Pet_ID exists in pets table
    SELECT COUNT(*) INTO pet_exists FROM pets WHERE Pet_ID = NEW.Pet_ID;
    
    -- Check if Pet_ID exists in exotic table
    SELECT COUNT(*) INTO exotic_exists FROM exotic WHERE Pet_ID = NEW.Pet_ID;
    
    -- Set the Pet_Source based on where the pet exists
    IF pet_exists > 0 THEN
        SET NEW.Pet_Source = 'pets';
    ELSEIF exotic_exists > 0 THEN
        SET NEW.Pet_Source = 'exotic';
    ELSE
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Pet_ID does not exist in either pets or exotic table';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_booking_update` BEFORE UPDATE ON `booking` FOR EACH ROW BEGIN
    DECLARE pet_exists INT DEFAULT 0;
    DECLARE exotic_exists INT DEFAULT 0;
    
    -- Only validate if Pet_ID is being changed
    IF NEW.Pet_ID != OLD.Pet_ID THEN
        -- Check if Pet_ID exists in pets table
        SELECT COUNT(*) INTO pet_exists FROM pets WHERE Pet_ID = NEW.Pet_ID;
        
        -- Check if Pet_ID exists in exotic table
        SELECT COUNT(*) INTO exotic_exists FROM exotic WHERE Pet_ID = NEW.Pet_ID;
        
        -- Set the Pet_Source based on where the pet exists
        IF pet_exists > 0 THEN
            SET NEW.Pet_Source = 'pets';
        ELSEIF exotic_exists > 0 THEN
            SET NEW.Pet_Source = 'exotic';
        ELSE
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Pet_ID does not exist in either pets or exotic table';
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `exotic`
--

CREATE TABLE `exotic` (
  `Pet_ID` varchar(20) NOT NULL,
  `Pet_type` varchar(50) DEFAULT NULL,
  `Pet_Name` varchar(50) DEFAULT NULL,
  `Age_Years` int(11) DEFAULT NULL,
  `Vaccinations` int(11) DEFAULT NULL,
  `Environment_condition` varchar(100) DEFAULT NULL,
  `Booking_requirements` varchar(255) DEFAULT NULL,
  `Sex` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exotic`
--

INSERT INTO `exotic` (`Pet_ID`, `Pet_type`, `Pet_Name`, `Age_Years`, `Vaccinations`, `Environment_condition`, `Booking_requirements`, `Sex`) VALUES
('EX-1', 'Siberian Tiger', 'Rajah', 6, 3, 'Large, cooled, natural habitat enclosure', 'Glass viewing only. No flash photography.', 'M'),
('EX-2', 'Grizzly Bear', 'Kodiak', 10, 5, 'Rocky, forest-like enclosure with water access', 'Must maintain 50ft distance at all times.', 'M'),
('EX-3', 'Great White Shark', 'Jaws', 15, 0, 'Deep-sea simulated tank, controlled temperature', 'Underwater tunnel viewing only.', 'F'),
('EX-4', 'African Lion', 'Simba', 7, 4, 'Open savannah exhibit with high barriers', 'Viewing allowed during feeding time only.', 'M'),
('EX-5', 'Polar Bear', 'Blizzard', 5, 3, 'Tundra-like exhibit with ice and deep pool', 'Do not tap on glass.', 'F'),
('EX-6', 'King Cobra', 'Viper', 9, 0, 'Heated, secure glass vivarium with dense foliage', 'Strictly hands-off, expert observation only.', 'M'),
('EX-7', 'Silverback Gorilla', 'Kong', 12, 5, 'Large, multi-level jungle habitat', 'Quiet observation; no sudden movements.', 'M');

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
('BI-1', 'Bird', 'skittles', 3, 5, 'N/A', 'N/A', 'N/A', 'F', 'processing'),
('FI-1', 'Fish', 'Nemo', 1, 4, 'N/A', 'N/A', 'N/A', 'M', 'processed'),
('GU-1', 'Guinea Pig', 'Fat Nuggets', 2, 0, 'N/A', 'N/A', 'N/A', 'M', 'processed'),
('HM-1', 'Hamster', 'Leo', 5, 0, 'na', 'na', 'na', 'M', 'processing'),
('OT-1', 'Other', 'ottey', 2, 2, 'N/A', 'N/A', 'N/A', 'F', 'processed'),
('RP-10', 'Red-Eared Slider', 'Shelly', 5, 3, 'Large aquatic environment with basking area', 'Commitment to long-term care (20+ years)', 'Feeding time viewing', 'F', 'processed'),
('RP-100', 'cat', 'cant', 3, 2, '0', 'juw', 'qj', 'M', 'unavailable'),
('RP-12', 'Rabbit (Lionhead)', 'Fluffy', 2, 1, 'Indoor pen with running space', 'Requires daily exercise and specific vegetable diet', 'Outdoor run viewing (weather permitting)', 'F', 'processed'),
('RP-13', 'Tarantula (Chilean Rose)', 'Rosie', 6, 0, 'Dry, room temperature enclosure', 'Knowledge of invertebrate care, hands-off approach', 'Glass viewing only', 'F', 'processed'),
('RP-14', 'Crested Gecko', 'Gecky', 1, 0, 'Tropical forest habitat, vertical space', 'Requires nightly misting and fruit-based commercial diet', 'Brief observation period', 'M', 'processed'),
('RP-3', 'Corn Snake', 'Buck', 2, 1, 'Quiet', 'Experienced handler only', 'none', 'M', 'unavailable'),
('RP-4', 'Iguana', 'Jimmy', 4, 1, 'High energy', 'A stable and active home', 'none', 'M', 'unavailable'),
('RP-6', 'Russian Tortoise', 'Lisa', 8, 4, 'Calm', 'A calm environment', 'none', 'F', 'unavailable'),
('RP-7', 'Lizard', 'ywy', 2, 0, 'nw', 'jw', 'jw', 'M', 'unavailable'),
('RP-8', 'Bearded Dragon', 'Smaug', 1, 2, 'Desert-like, high UV light', 'Experienced reptile owner, large tank required', 'Brief handling session only', 'M', 'processed'),
('RP-9', 'Ball Python', 'Nagini', 3, 1, 'Warm, humid hideout', 'Must be comfortable handling snakes, secure enclosure', 'Viewing from behind glass only', 'F', 'processed'),
('TO-1', 'Tortoise', 'yurdle', 8, 0, 'N/A', 'N/A', 'N/A', 'M', 'processing');

--
-- Triggers `pets`
--
DELIMITER $$
CREATE TRIGGER `after_pet_status_unavailable` AFTER UPDATE ON `pets` FOR EACH ROW BEGIN
    -- Check if the status has changed to 'unavailable'
    IF NEW.status = 'unavailable' AND OLD.status != 'unavailable' THEN
        -- Update the corresponding Adoption_status to 'Adopted' (or another final status if needed)
        UPDATE adoption
        SET Adoption_status = 'Adopted'
        WHERE Pet_ID = NEW.Pet_ID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_pets_to_adoption_status_sync` AFTER UPDATE ON `pets` FOR EACH ROW BEGIN
    -- Check if the pet status was changed to 'processed'
    IF NEW.status = 'processed' AND NEW.status <> OLD.status THEN
        -- Update the corresponding adoption record's status to 'Available'
        -- It only updates records that are not already 'Adopted'.
        UPDATE `adoption`
        SET `Adoption_status` = 'Available'
        WHERE `Pet_ID` = NEW.Pet_ID AND `Adoption_status` != 'Adopted';
    END IF;
END
$$
DELIMITER ;

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
('ID-5', 'John', 'Connor', 'john@gmail.com', '654 Birch Ct', '555-7890', '2025-04-05', 'john123'),
('ID-6', 'jsj', '', 'jsj@gmail.com', 'somewhere', '7034541961', '2025-11-24', 'jsj');

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
-- Indexes for table `exotic`
--
ALTER TABLE `exotic`
  ADD PRIMARY KEY (`Pet_ID`);

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
  MODIFY `Adoption_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  ADD CONSTRAINT `fk_booking_customer` FOREIGN KEY (`Customer_Id`) REFERENCES `users` (`Customer_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
