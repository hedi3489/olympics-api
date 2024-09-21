-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 11:55 PM
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
-- Database: `olympics`
--

-- --------------------------------------------------------

--
-- Table structure for table `athletes`
--

CREATE TABLE `athletes` (
  `athlete_id` int(11) NOT NULL,
  `athlete_name` varchar(64) NOT NULL,
  `country_id` int(11) NOT NULL,
  `gender` varchar(64) NOT NULL,
  `sport` varchar(64) NOT NULL,
  `date_of_birth` date NOT NULL,
  `height` int(4) NOT NULL,
  `weight` int(4) NOT NULL,
  `ethnicity` varchar(64) NOT NULL,
  `is_paralymic` tinyint(1) NOT NULL,
  `gold_medals` int(4) NOT NULL,
  `silver_medals` int(4) NOT NULL,
  `bronze_medals` int(4) NOT NULL,
  `total_medals` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `athletes_coaches`
--

CREATE TABLE `athletes_coaches` (
  `athlete_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
  `coach_id` int(11) NOT NULL,
  `coach_name` varchar(64) NOT NULL,
  `gender` varchar(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `been_in_olympics` tinyint(1) NOT NULL,
  `sport` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(64) NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `gold_medals` int(11) NOT NULL,
  `silver_medals` int(11) NOT NULL,
  `bronze_medals` int(11) NOT NULL,
  `total_medals` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(128) NOT NULL,
  `event_sport` int(128) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `number_of_participants` int(11) NOT NULL,
  `is_paralympic` tinyint(1) NOT NULL,
  `venue_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `athlete_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `ranking` int(11) NOT NULL,
  `result` text NOT NULL,
  `record_set` tinyint(1) NOT NULL,
  `category` varchar(64) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(11) NOT NULL,
  `venue_name` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL,
  `capacity` varchar(128) NOT NULL,
  `type` varchar(64) NOT NULL,
  `date_constructed` date NOT NULL,
  `historical_significance` text NOT NULL,
  `parking_facilities` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `athletes`
--
ALTER TABLE `athletes`
  ADD PRIMARY KEY (`athlete_id`),
  ADD KEY `Countries_Athletes_FK` (`country_id`);

--
-- Indexes for table `athletes_coaches`
--
ALTER TABLE `athletes_coaches`
  ADD PRIMARY KEY (`athlete_id`,`coach_id`),
  ADD KEY `Coaches_AC_FK` (`coach_id`);

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`coach_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `Venues_Events_FK` (`venue_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`athlete_id`,`event_id`),
  ADD KEY `Events_Results_FK` (`event_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`venue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `athletes`
--
ALTER TABLE `athletes`
  MODIFY `athlete_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
  MODIFY `coach_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `athletes`
--
ALTER TABLE `athletes`
  ADD CONSTRAINT `Countries_Athletes_FK` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`);

--
-- Constraints for table `athletes_coaches`
--
ALTER TABLE `athletes_coaches`
  ADD CONSTRAINT `Athletes_AC_FK` FOREIGN KEY (`athlete_id`) REFERENCES `athletes` (`athlete_id`),
  ADD CONSTRAINT `Coaches_AC_FK` FOREIGN KEY (`coach_id`) REFERENCES `coaches` (`coach_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `Venues_Events_FK` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`venue_id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `Athletes_Results_FK` FOREIGN KEY (`athlete_id`) REFERENCES `athletes` (`athlete_id`),
  ADD CONSTRAINT `Events_Results_FK` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
