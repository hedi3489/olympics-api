-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2024 at 08:04 PM
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
