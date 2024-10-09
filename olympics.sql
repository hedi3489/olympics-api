-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2024 at 01:45 AM
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
-- Database: `olympics-api`
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

--
-- Dumping data for table `athletes`
--

INSERT INTO `athletes` (`athlete_id`, `athlete_name`, `country_id`, `gender`, `sport`, `date_of_birth`, `height`, `weight`, `ethnicity`, `is_paralymic`, `gold_medals`, `silver_medals`, `bronze_medals`, `total_medals`) VALUES
(41, 'ALEKSANYAN Artur', 86, 'Male', 'Wrestling', '1991-10-21', 0, 0, 'Armenian', 0, 0, 0, 0, 0),
(42, 'AMOYAN Malkhas', 86, 'Male', 'Wrestling', '1999-01-22', 0, 0, 'Armenian', 0, 0, 0, 0, 0),
(43, 'GALSTYAN Slavik', 86, 'Male', 'Wrestling', '1996-12-21', 0, 0, 'Armenian', 0, 0, 0, 0, 0),
(44, 'HARUTYUNYAN Arsen', 86, 'Male', 'Wrestling', '1999-11-22', 0, 0, 'Armenian', 0, 0, 0, 0, 0),
(45, 'TEVANYAN Vazgen', 86, 'Male', 'Wrestling', '1999-10-27', 0, 0, 'Armenian', 0, 0, 0, 0, 0),
(46, 'ARENAS Lorena', 87, 'Female', 'Athletics', '1993-09-17', 162, 0, 'Spanish', 0, 0, 0, 0, 0),
(47, 'RUEDA SANTOS Lizeth', 85, 'Female', 'Triathlon', '1994-03-07', 0, 0, 'Spanish', 0, 0, 0, 0, 0),
(48, 'BRUNO Fratus', 39, 'Male', 'Swimming', '1989-06-30', 188, 80, 'Brazilian', 0, 1, 0, 0, 1),
(49, 'KATIE Ledecky', 20, 'Female', 'Swimming', '1997-03-17', 183, 70, 'Caucasian', 0, 2, 1, 1, 4),
(50, 'NADINE Debois', 31, 'Female', 'Athletics', '2001-08-15', 176, 68, 'French Canadian', 0, 0, 0, 0, 0),
(51, 'FELIPE Aguilar', 76, 'Male', 'Golf', '1974-11-07', 178, 75, 'Chilean', 0, 0, 0, 0, 0),
(52, 'YULIMAR Rojas', 106, 'Female', 'Athletics', '1995-10-21', 192, 72, 'Afro-Venezuelan', 0, 1, 1, 0, 2),
(53, 'WAYDE van Niekerk', 64, 'Male', 'Athletics', '1992-07-15', 183, 74, 'South African', 0, 1, 1, 0, 2),
(54, 'CHEDDY El Haddad', 81, 'Male', 'Judo', '1998-04-22', 171, 68, 'Arab Moroccan', 0, 0, 0, 0, 0),
(55, 'COTE D’IVOIRE Mariama', 105, 'Female', 'Taekwondo', '2000-09-10', 165, 55, 'Ivorian', 0, 1, 0, 1, 2),
(56, 'ESMAIL Halima', 73, 'Female', 'Athletics', '2003-02-28', 177, 62, 'Egyptian', 0, 0, 0, 0, 0),
(57, 'NAITO Shigeru', 22, 'Male', 'Judo', '1999-05-06', 172, 70, 'Japanese', 0, 0, 1, 0, 1),
(58, 'AN San', 64, 'Female', 'Archery', '2001-02-27', 167, 58, 'Korean', 0, 3, 0, 1, 4),
(59, 'XU Jiayu', 21, 'Male', 'Swimming', '1995-08-19', 180, 73, 'Chinese', 0, 1, 1, 1, 3),
(60, 'SINDHU P.V.', 91, 'Female', 'Badminton', '1995-07-05', 179, 65, 'Indian', 0, 1, 2, 0, 3),
(61, 'TOMASSEVIC Jelena', 46, 'Female', 'Tennis', '1998-01-04', 175, 60, 'Serbian', 0, 0, 1, 0, 1),
(62, 'DA SILVA Tiago', 70, 'Male', 'Athletics', '1994-03-25', 185, 72, 'Portuguese', 0, 0, 0, 0, 0),
(63, 'BEATA Bajic', 33, 'Female', 'Shooting', '1996-06-12', 162, 58, 'Hungarian', 0, 0, 0, 0, 0),
(64, 'JANIS Krams', 90, 'Male', 'Basketball', '1992-09-29', 201, 90, 'Latvian', 0, 0, 1, 0, 1),
(65, 'NINA Jovic', 53, 'Female', 'Cycling', '2000-11-07', 168, 59, 'Slovenian', 0, 0, 0, 0, 0),
(85, 'Miller-Uibo Shauna', 52, 'Female', 'Athletics', '1993-04-15', 178, 68, 'Bahamian', 0, 0, 0, 0, 0),
(86, 'Lyles Noah', 20, 'Male', 'Athletics', '1997-07-18', 180, 77, 'American', 0, 0, 0, 0, 0),
(87, 'Schippers Dafne', 25, 'Female', 'Athletics', '1992-06-15', 179, 70, 'Dutch', 0, 0, 0, 0, 0),
(88, 'De Grasse Andre', 31, 'Male', 'Athletics', '1994-11-10', 180, 75, 'Canadian', 0, 0, 0, 0, 0),
(89, 'Semenya Caster', 64, 'Female', 'Athletics', '1991-01-07', 175, 68, 'South African', 0, 0, 0, 0, 0),
(90, 'Bolt Usain', 63, 'Male', 'Athletics', '1986-08-21', 195, 94, 'Jamaican', 0, 0, 0, 0, 0),
(91, 'Phelps Michael', 20, 'Male', 'Swimming', '1985-06-30', 193, 88, 'American', 0, 0, 0, 0, 0),
(92, 'Ledecky Katie', 20, 'Female', 'Swimming', '1997-03-17', 180, 70, 'American', 0, 0, 0, 0, 0),
(93, 'Dressel Caeleb', 20, 'Male', 'Swimming', '1996-08-16', 183, 77, 'American', 0, 0, 0, 0, 0),
(94, 'Woods Ben', 26, 'Male', 'Cycling', '1990-02-24', 180, 70, 'British', 0, 0, 0, 0, 0),
(95, 'Van Vleuten Annemiek', 25, 'Female', 'Cycling', '1982-10-08', 165, 54, 'Dutch', 0, 0, 0, 0, 0),
(96, 'Margarita Cifuentes', 87, 'Female', 'Cycling', '1995-07-12', 168, 58, 'Colombian', 0, 0, 0, 0, 0),
(97, 'Ticona Rosales, Joselyn', 107, 'Female', 'Athletics', '2003-11-17', 164, 55, 'Peruvian', 0, 0, 0, 0, 0),
(98, 'Gomez Juan', 34, 'Male', 'Athletics', '1996-02-23', 182, 73, 'Spanish', 0, 0, 0, 0, 0),
(99, 'Hernandez, Gabriela', 85, 'Female', 'Athletics', '1998-06-30', 165, 60, 'Mexican', 0, 0, 0, 0, 0),
(100, 'Vega, Julián', 72, 'Male', 'Athletics', '1995-12-01', 176, 68, 'Argentinian', 0, 0, 0, 0, 0),
(101, 'Zhang, Wei', 21, 'Male', 'Badminton', '1992-05-12', 178, 70, 'Chinese', 0, 0, 0, 0, 0),
(102, 'Fujimoto, Haruka', 22, 'Female', 'Judo', '2000-03-10', 160, 50, 'Japanese', 0, 0, 0, 0, 0),
(103, 'Yamamoto, Shun', 22, 'Male', 'Judo', '1995-09-21', 175, 73, 'Japanese', 0, 0, 0, 0, 0),
(104, 'TAPIA VIDAL Rosa Maria', 85, 'Female', 'Triathlon', '1997-08-27', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(105, 'GRAJALES Crisanto', 85, 'Male', 'Triathlon', '1987-05-06', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(106, 'DIOSDADO Nuria', 85, 'Female', 'Artistic Swimming', '1990-08-22', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(107, 'JIMENEZ Joana', 85, 'Female', 'Artistic Swimming', '1993-08-19', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(108, 'SOBRINO Jessica', 85, 'Female', 'Artistic Swimming', '1994-05-26', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(109, 'ALFEREZ Regina', 85, 'Female', 'Artistic Swimming', '1997-12-01', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(110, 'ARELLANO Fernanda', 85, 'Female', 'Artistic Swimming', '2002-02-28', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(111, 'TOSCANO Pamela', 85, 'Female', 'Artistic Swimming', '2000-01-13', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(112, 'GONZALEZ Itzamary', 85, 'Female', 'Artistic Swimming', '2003-11-14', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(113, 'RODRIGUEZ Samanta', 85, 'Female', 'Artistic Swimming', '1994-12-05', 0, 0, 'Mexican', 0, 0, 0, 0, 0),
(114, 'INZUNZA Glenda', 85, 'Female', 'Alternate Athlete', '2000-03-12', 0, 0, 'Mexican', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `athletes_coaches`
--

CREATE TABLE `athletes_coaches` (
  `athlete_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `athletes_coaches`
--

INSERT INTO `athletes_coaches` (`athlete_id`, `coach_id`) VALUES
(104, 10),
(105, 9),
(106, 11),
(107, 11),
(108, 11),
(109, 11),
(110, 11),
(111, 11),
(112, 11),
(113, 11),
(114, 11);

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
  `coach_id` int(11) NOT NULL,
  `coach_name` varchar(64) NOT NULL,
  `gender` varchar(11) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `been_in_olympics` tinyint(1) NOT NULL,
  `sport` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`coach_id`, `coach_name`, `gender`, `date_of_birth`, `been_in_olympics`, `sport`) VALUES
(1, 'Gevorg Aleksanyan', 'Male', NULL, 0, 'Wrestling'),
(2, 'Roman Amoyan', 'Male', NULL, 0, 'Wrestling'),
(3, 'Martin Alekhanyan', 'Male', NULL, 0, 'Wrestling'),
(4, 'Armen Babalaryan', 'Male', NULL, 0, 'Wrestling'),
(5, 'Habetnak Kurghinyan', 'Male', NULL, 0, 'Wrestling'),
(6, 'Brent Vallance', 'Male', NULL, 0, 'Athletics'),
(7, 'Luke Preston', 'Male', NULL, 0, 'Judo'),
(8, 'Christophe Belliard', 'Male', NULL, 1, 'Athletics'),
(9, 'Eugenio Chimal', 'Male', NULL, 1, 'Triathlon'),
(10, 'Luis Miguel Chávez Rincón', 'Male', NULL, 0, 'Triathlon'),
(11, 'Adriana Loftus', 'Female', NULL, 1, 'Artistic Swimming'),
(12, 'Marc-Olivier Froger', 'Male', NULL, 0, 'Swimming'),
(13, 'Franck Ne', 'Male', NULL, 0, 'Athletics'),
(15, 'Manuel Verde', 'Male', NULL, 1, 'Boxing'),
(16, 'Raul Gonzalez', 'Male', NULL, 1, 'Athletics'),
(17, 'Jose Luis Doctor', 'Male', NULL, 1, 'Athletics'),
(18, 'Alejandro Laberdesque', 'Male', NULL, 1, 'Athletics'),
(19, 'Manuel Verde', 'Male', NULL, 1, 'Boxing'),
(20, 'Raul Gonzalez', 'Male', NULL, 1, 'Athletics'),
(21, 'Ignacio Zamudio', 'Male', NULL, 1, 'Athletics'),
(22, 'Alejandro Laberdesque', 'Male', NULL, 1, 'Athletics'),
(23, 'Fernando Infante', 'Male', NULL, 0, 'Race Walking'),
(24, 'Jacek Kruszewski', 'Male', NULL, 0, 'Athletics'),
(25, 'Kenny McDonald', 'Male', NULL, 0, 'Athletics'),
(26, 'Andrew Mullen', 'Male', NULL, 0, 'Athletics');

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

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_code`, `gold_medals`, `silver_medals`, `bronze_medals`, `total_medals`) VALUES
(20, 'United States of America', 'USA', 40, 44, 42, 126),
(21, 'People\'s Republic of China', 'CHN', 40, 27, 24, 91),
(22, 'Japan', 'JPN', 20, 12, 13, 45),
(23, 'Australia', 'AUS', 18, 19, 16, 53),
(24, 'France', 'FRA', 16, 26, 22, 64),
(25, 'Netherlands', 'NED', 15, 7, 12, 34),
(26, 'Great Britain', 'GBR', 14, 22, 29, 65),
(27, 'Republic of Korea', 'KOR', 13, 9, 10, 32),
(28, 'Italy', 'ITA', 12, 13, 15, 40),
(29, 'Germany', 'GER', 12, 13, 8, 33),
(30, 'New Zealand', 'NZL', 10, 7, 3, 20),
(31, 'Canada', 'CAN', 9, 7, 11, 27),
(32, 'Uzbekistan', 'UZB', 8, 2, 3, 13),
(33, 'Hungary', 'HUN', 6, 7, 6, 19),
(34, 'Spain', 'ESP', 5, 4, 9, 18),
(35, 'Sweden', 'SWE', 4, 4, 3, 11),
(36, 'Kenya', 'KEN', 4, 2, 5, 11),
(37, 'Norway', 'NOR', 4, 1, 3, 8),
(38, 'Ireland', 'IRL', 4, 0, 3, 7),
(39, 'Brazil', 'BRA', 3, 7, 10, 20),
(40, 'Islamic Republic of Iran', 'IRI', 3, 6, 3, 12),
(41, 'Ukraine', 'UKR', 3, 5, 4, 12),
(42, 'Romania', 'ROU', 3, 4, 2, 9),
(43, 'Georgia', 'GEO', 3, 3, 1, 7),
(44, 'Belgium', 'BEL', 3, 1, 6, 10),
(45, 'Bulgaria', 'BUL', 3, 1, 3, 7),
(46, 'Serbia', 'SRB', 3, 1, 1, 5),
(47, 'Czechia', 'CZE', 3, 0, 2, 5),
(48, 'Denmark', 'DEN', 2, 2, 5, 9),
(49, 'Azerbaijan', 'AZE', 2, 2, 3, 7),
(50, 'Croatia', 'CRO', 2, 2, 3, 7),
(51, 'Cuba', 'CUB', 2, 1, 6, 9),
(52, 'Bahrain', 'BRN', 2, 1, 1, 4),
(53, 'Slovenia', 'SLO', 2, 1, 0, 3),
(54, 'Chinese Taipei', 'TPE', 2, 0, 5, 7),
(55, 'Austria', 'AUT', 2, 0, 3, 5),
(56, 'Hong Kong, China', 'HKG', 2, 0, 2, 4),
(57, 'Philippines', 'PHI', 2, 0, 2, 4),
(58, 'Algeria', 'ALG', 2, 0, 1, 3),
(59, 'Indonesia', 'INA', 2, 0, 0, 2),
(60, 'Israel', 'ISR', 1, 5, 1, 7),
(61, 'Poland', 'POL', 1, 4, 5, 10),
(62, 'Kazakhstan', 'KAZ', 1, 3, 3, 7),
(63, 'Jamaica', 'JAM', 1, 3, 2, 6),
(64, 'South Africa', 'RSA', 1, 3, 2, 6),
(65, 'Thailand', 'THA', 1, 3, 2, 6),
(66, 'AIN', 'AIN', 1, 3, 1, 5),
(67, 'Ethiopia', 'ETH', 1, 3, 0, 4),
(68, 'Switzerland', 'SUI', 1, 2, 5, 8),
(69, 'Ecuador', 'ECU', 1, 2, 2, 5),
(70, 'Portugal', 'POR', 1, 2, 1, 4),
(71, 'Greece', 'GRE', 1, 1, 6, 8),
(72, 'Argentina', 'ARG', 1, 1, 1, 3),
(73, 'Egypt', 'EGY', 1, 1, 1, 3),
(74, 'Tunisia', 'TUN', 1, 1, 1, 3),
(75, 'Botswana', 'BOT', 1, 1, 0, 2),
(76, 'Chile', 'CHI', 1, 1, 0, 2),
(77, 'Saint Lucia', 'LCA', 1, 1, 0, 2),
(78, 'Uganda', 'UGA', 1, 1, 0, 2),
(79, 'Dominican Republic', 'DOM', 1, 0, 2, 3),
(80, 'Guatemala', 'GUA', 1, 0, 1, 2),
(81, 'Morocco', 'MAR', 1, 0, 1, 2),
(82, 'Dominica', 'DMA', 1, 0, 0, 1),
(83, 'Pakistan', 'PAK', 1, 0, 0, 1),
(84, 'Türkiye', 'TUR', 0, 3, 5, 8),
(85, 'Mexico', 'MEX', 0, 3, 2, 5),
(86, 'Armenia', 'ARM', 0, 3, 1, 4),
(87, 'Colombia', 'COL', 0, 3, 1, 4),
(88, 'Democratic People\'s Republic of Korea', 'PRK', 0, 2, 4, 6),
(89, 'Kyrgyzstan', 'KGZ', 0, 2, 4, 6),
(90, 'Lithuania', 'LTU', 0, 2, 2, 4),
(91, 'India', 'IND', 0, 1, 5, 6),
(92, 'Republic of Moldova', 'MDA', 0, 1, 3, 4),
(93, 'Kosovo', 'KOS', 0, 1, 1, 2),
(94, 'Cyprus', 'CYP', 0, 1, 0, 1),
(95, 'Fiji', 'FIJ', 0, 1, 0, 1),
(96, 'Jordan', 'JOR', 0, 1, 0, 1),
(97, 'Mongolia', 'MGL', 0, 1, 0, 1),
(98, 'Panama', 'PAN', 0, 1, 0, 1),
(99, 'Tajikistan', 'TJK', 0, 0, 3, 3),
(100, 'Albania', 'ALB', 0, 0, 2, 2),
(101, 'Grenada', 'GRN', 0, 0, 2, 2),
(102, 'Malaysia', 'MAS', 0, 0, 2, 2),
(103, 'Puerto Rico', 'PUR', 0, 0, 2, 2),
(104, 'Cabo Verde', 'CPV', 0, 0, 1, 1),
(105, 'Côte d\'Ivoire', 'CIV', 0, 0, 1, 1),
(106, 'Refugee Olympic Team', 'EOR', 0, 0, 1, 1),
(107, 'Peru', 'PER', 0, 0, 1, 1),
(108, 'Qatar', 'QAT', 0, 0, 1, 1),
(109, 'Singapore', 'SGP', 0, 0, 1, 1),
(110, 'Slovakia', 'SVK', 0, 0, 1, 1),
(111, 'Zambia', 'ZAM', 0, 0, 1, 1);

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

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_sport`, `start_date`, `end_date`, `number_of_participants`, `is_paralympic`, `venue_id`) VALUES
(1, 'Athletics', 1, '2024-07-27', '2024-08-09', 3000, 0, 1),
(2, 'Opening Ceremony', 2, '2024-07-26', '2024-07-26', 10000, 0, 1),
(3, 'Closing Ceremony', 3, '2024-08-11', '2024-08-11', 10000, 0, 1),
(4, 'Tennis', 4, '2024-07-27', '2024-08-11', 128, 0, 2),
(5, '3x3 Basketball', 5, '2024-07-25', '2024-08-09', 24, 0, 3),
(6, 'BMX Freestyle', 6, '2024-08-08', '2024-08-10', 24, 0, 4),
(7, 'Skateboarding', 7, '2024-08-02', '2024-08-09', 24, 0, 4),
(8, 'Football', 8, '2024-07-24', '2024-08-10', 768, 0, 5),
(9, 'Equestrian - Dressage', 9, '2024-07-25', '2024-08-02', 60, 0, 6),
(10, 'Equestrian - Eventing', 10, '2024-08-01', '2024-08-05', 60, 0, 6),
(11, 'Fencing', 11, '2024-08-05', '2024-08-10', 200, 0, 7),
(12, 'Taekwondo', 12, '2024-08-08', '2024-08-10', 128, 0, 7),
(13, 'Gymnastics - Artistic', 13, '2024-08-03', '2024-08-09', 300, 0, 8),
(14, 'Gymnastics - Rhythmic', 14, '2024-08-12', '2024-08-15', 100, 0, 8),
(15, 'Basketball', 15, '2024-07-25', '2024-08-10', 350, 0, 8),
(16, 'Swimming', 16, '2024-07-27', '2024-08-04', 1000, 0, 9),
(17, 'Diving', 17, '2024-08-05', '2024-08-10', 200, 0, 9),
(18, 'Water Polo', 18, '2024-08-01', '2024-08-09', 200, 0, 9),
(19, 'Artistic Swimming', 19, '2024-08-08', '2024-08-12', 100, 0, 9),
(20, 'Modern Pentathlon - Fencing', 20, '2024-08-11', '2024-08-11', 150, 0, 10),
(21, 'Modern Pentathlon - Riding', 21, '2024-08-12', '2024-08-12', 150, 0, 10),
(22, 'Archery', 22, '2024-07-26', '2024-08-01', 128, 0, 11),
(23, 'Rugby Sevens', 23, '2024-07-24', '2024-08-10', 240, 0, 14),
(24, 'Rugby Union', 24, '2024-07-25', '2024-08-01', 200, 0, 15),
(25, 'Gymnastics - Trampoline', 25, '2024-08-08', '2024-08-09', 60, 0, 15),
(26, 'Basketball', 26, '2024-07-25', '2024-08-10', 350, 0, 16),
(27, 'Handball', 27, '2024-07-25', '2024-08-11', 192, 0, 17),
(28, 'Sailing', 28, '2024-07-29', '2024-08-03', 400, 0, 18);

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

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`athlete_id`, `event_id`, `ranking`, `result`, `record_set`, `category`, `date`) VALUES
(49, 16, 2, 'Received a Silver medal.\r\n', 0, 'Individual', '2024-08-07');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(11) NOT NULL,
  `venue_name` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL,
  `capacity` varchar(128) NOT NULL,
  `type` varchar(64) NOT NULL,
  `date_constructed` date NOT NULL,
  `historical_significance` text NOT NULL,
  `parking_facilities` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `venue_name`, `address`, `capacity`, `type`, `date_constructed`, `historical_significance`, `parking_facilities`) VALUES
(1, 'Stade de France', '93200 Saint-Denis, Paris, France', '81338', 'Multiuse stadium', '1998-01-28', 'Built for the 1998 FIFA World Cup, it has since hosted numerous global sports events, including UEFA Euro 2016 and Rugby World Cup matches.', 'Includes large-scale parking available for major events​.'),
(2, 'Roland-Garros Stadium', '16th arrondissement, Paris, France', '34000', 'Sports complex with clay courts', '1928-05-02', ' Famous for hosting the French Open, Roland-Garros is one of tennis most prestigious venues, with over 95 years of tennis history.', ' Limited parking on-site with additional parking nearby​.'),
(3, 'Eiffel Tower Stadium', 'Champ de Mars, Paris, France', '12,860', 'Outdoor arena', '1889-03-31', 'The venue is set up at the base of the Eiffel Tower, one of the most iconic landmarks in the world​.', 'Limited parking due to its central location.'),
(4, 'La Concorde', 'Place de la Concorde, Paris, France', '30000', 'Urban arena', '1772-10-25', 'One of Paris most famous public squares, central to many historical events like the French Revolution.', 'Limited on-site parking, with nearby public transportation​.'),
(5, 'Parc des Princes', '24 Rue du Commandant Guilbaud, 75016 Paris, France', '48229', 'Stadium', '1967-07-08', 'Home to Paris Saint-Germain football club since 1974, and has hosted major international tournaments like the 1998 FIFA World Cup​.', 'Underground and nearby parking facilities available​.'),
(6, 'Château de Versailles', 'Place d\'Armes, 78000 Versailles, Paris, France', '20000', 'Outdoor arena (temporary arena for equestrian events and modern ', '1682-05-06', 'A UNESCO World Heritage site renowned for its role in French history, particularly as the royal court of Louis XIV in the 17th century. It symbolizes France’s cultural heritage and has been a national museum since 1837. Originally constructed as a hunting lodge in 1623, with significant expansions during the reign of Louis XIV (official residence from 1682.', 'Parking available around the château, with special provisions for events.'),
(7, 'Grand Palais', 'Avenue Winston-Churchill, 75008 Paris, France', '8000', 'Arena', '1900-05-01', 'The Grand Palais is a historic Parisian monument, renowned for its large glass roof and steel structure. It has hosted a wide range of cultural and sporting events, including the 2010 World Fencing Championships. It will be used for fencing and taekwondo during the 2024 Olympics.', 'Limited parking, but public transportation options are highly accessible.'),
(8, 'Bercy Arena', '8 Boulevard de Bercy, Paris, France', '15000', 'Indoor arena', '1984-02-03', 'Regular host of major concerts and sports events.', 'On-site parking available, accessible by public transport.'),
(9, 'Aquatics Centre', '361, avenue du Président-Wilson, Saint-Denis, Paris, France', '5000', 'Aquatic facility (indoor)', '2023-05-20', 'Constructed specifically for Paris 2024, it is located next to Stade de France.', 'Limited parking, but the venue is accessible by public transport.'),
(10, 'Invalides', '75007 Paris, France', '5000', 'Outdoor venue', '1676-08-01', 'Known for its military history, home to Napoleon’s tomb, and the Musée de l\'Armée.', 'Limited parking, with better access by metro or bus.'),
(11, 'Pont Alexandre III', 'Pont Alexandre III, 75008 Paris, France', '1500', 'Outdoor public space', '1900-05-01', 'Iconic bridge known for its ornate sculptures and lamps, symbolizing Franco-Russian friendship.', 'Limited street parking, highly recommended public transportation.'),
(12, 'Marseille Marina', 'Marseille, France', '5000', 'Marina', '1974-06-10', 'France\'s largest commercial port, hosting numerous international sailing competitions.', 'Ample parking, with access to public transportation.'),
(13, 'Pierre Mauroy Stadium', '261 boulevard de Tournai, 59650 Villeneuve-d\'Ascq, North, France', '50000', 'Multi-purpose stadium', '2012-08-17', 'Venue for football, rugby, and concerts, with a retractable roof.', 'On-site parking facilities.'),
(14, 'Stade olympique Yves-du-Manoir', 'Colombes, France', '15000', 'Outdoor stadium', '1907-05-24', 'Hosted the 1924 Summer Olympics, and was the main stadium for the Games. It also has a long history in French sports, especially rugby and football.', 'On-site parking available, with improvements planned for the 2024 Games.'),
(15, 'Paris La Défense Arena', '99 Jardins de l\'Arche, La Défense, Nanterre, France', '40000', 'Indoor multi-purpose arena', '2017-10-19', 'One of Europe’s largest indoor arenas, regularly hosting major concerts and sports events, including rugby matches for Racing 92.', 'Extensive parking available, with connections to public transportation (RER A).'),
(16, 'Porte de La Chapelle Arena (Paris Arena II)', '58 Boulevard Ney 75018 Paris, France', '8000', 'Multi-sport arena.', '2024-03-11', 'The arena is part of an urban regeneration project aimed at enhancing community sports and cultural facilities in northern Paris. It will host events during the Paris 2024 Olympic Games, including badminton and rhythmic gymnastics, and later will accommodate para-badminton and powerlifting events for the Paralympics​', 'The venue includes a wheelchair-accessible parking area and drop-off zones for persons with disabilities​. Additionally, there are bike parking facilities nearby for those cycling to the venue'),
(17, 'Parc des Expositions de Villepinte', 'ZAC Paris Nord 2, 93420 Villepinte, France', '16000', 'Multi-purpose exhibition center (Arena', '1982-01-01', 'Initially designed for exhibitions, it is the largest exhibition centre in France. Its transformation into a sports arena for the Olympics showcases its versatility​', 'The venue is accessible via car, with nearby parking options including the Stade de France and Porte de la Chapelle, both equipped with designated parking for people with reduced mobility​.'),
(18, 'Le Bourget', '93350 Le Bourget, France', '6000', 'Indoor/Outdoor climbing', '2024-01-01', 'This venue marks the introduction of sport climbing into the Olympic program and is part of a legacy project aimed at addressing the lack of sports facilities in the Seine-Saint-Denis department. After the Games, the facility will be available for local clubs and communities.', 'Specific details on parking facilities weren\'t highlighted in the sources, but the venue is accessible via public transport, including the RER B train and Tram T11​.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `athletes`
--
ALTER TABLE `athletes`
  ADD PRIMARY KEY (`athlete_id`),
  ADD UNIQUE KEY `athlete_name` (`athlete_name`),
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
  MODIFY `athlete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
  MODIFY `coach_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
