-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2025 at 08:13 AM
-- Server version: 8.0.43-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easyevent_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `activiteit`
--

CREATE TABLE `activiteit` (
  `id` int NOT NULL,
  `naam` varchar(255) NOT NULL,
  `locatie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activiteit_event_tijd`
--

CREATE TABLE `activiteit_event_tijd` (
  `id` int NOT NULL,
  `activiteit_id` int NOT NULL,
  `event_tijd_id` int NOT NULL,
  `begin_tijd` time NOT NULL,
  `eind_tijd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int NOT NULL,
  `naam` varchar(50) NOT NULL,
  `beschrijving` text,
  `hoofd_event` int DEFAULT NULL,
  `organisator_id` int DEFAULT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `naam`, `beschrijving`, `hoofd_event`, `organisator_id`, `removed`) VALUES
(1, 'Pool', 'poolen', NULL, 4, 0),
(2, 'Pool', 'poolen', NULL, 4, 0),
(3, 'Pool', 'poolen', NULL, 4, 0),
(4, 'Pool', 'poolen', NULL, 4, 0),
(5, 'Pool', 'poolen', NULL, 4, 0),
(6, 'Pool', 'poolen', NULL, 4, 0),
(7, 'Pool', 'poolen', NULL, 4, 0),
(8, 'Pool', 'poolen', NULL, 4, 0),
(9, 'Pool2', 'trwea', NULL, 4, 0),
(10, 'hooi', 'hooi harken', NULL, 4, 0),
(11, 'hooi', 'hooi harken', NULL, 4, 0),
(12, 'goon', 'goonstar', NULL, 4, 0),
(13, 'game', 'gaming', NULL, 4, 0),
(14, 'game', 'gaming', NULL, 4, 0),
(15, 'game', 'gaming', NULL, 4, 0),
(16, 'fußball', 'fußball spielen', NULL, 4, 0),
(17, 'golf', 'gee', NULL, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_tijd`
--

CREATE TABLE `event_tijd` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `land` varchar(255) DEFAULT NULL,
  `plaatsnaam` varchar(255) DEFAULT NULL,
  `straatnaam` varchar(255) DEFAULT NULL,
  `huisnummer` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `datum` date NOT NULL,
  `begin_tijd` time NOT NULL,
  `eind_tijd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_tijd`
--

INSERT INTO `event_tijd` (`id`, `event_id`, `land`, `plaatsnaam`, `straatnaam`, `huisnummer`, `postcode`, `datum`, `begin_tijd`, `eind_tijd`) VALUES
(1, 8, 'Netherland', 'Amsterdam', 'Kalverstraat', '1', '1234 AB', '2025-09-26', '14:48:00', '17:51:00'),
(2, 9, 'Netherland', 'Rotterdam', 'Hoofdstraat', '67', '3123 GH', '2025-09-26', '12:15:00', '23:45:00'),
(3, 11, 'Netherland', 'Groningen', 'groningseweg', '34', '9704 gt', '2025-10-09', '15:36:00', '18:38:00'),
(4, 12, 'Netherland', 'war', 'raw', '21', '1234 gg', '2025-09-20', '16:54:00', '18:57:00'),
(5, 15, 'Netherland', '12', 'akla', '1', '1233 gh', '2025-09-01', '14:50:00', '14:00:00'),
(6, 16, 'Germany', 'Berlin', 'strasse', '54', '1223 GH', '2025-10-11', '10:10:00', '10:15:00'),
(7, 17, 'Belgium', 'Deurne', 'Schutsboom', '31', '5751 JA', '2025-10-16', '10:04:00', '10:05:00'),
(8, 17, 'Belgium', 'Deurne', 'Schutsboom', '31', '5751 JA', '2025-10-15', '09:00:00', '12:00:00'),
(9, 17, 'Belgium', 'Deurne', 'Schutsboom', '31', '5751 JA', '2025-10-16', '13:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `gebruiker`
--

CREATE TABLE `gebruiker` (
  `id` int NOT NULL,
  `voornaam` varchar(255) NOT NULL,
  `achternaam` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefoon` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `plaatsnaam` varchar(255) DEFAULT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `profiel_foto` blob,
  `huisnummer` varchar(255) DEFAULT NULL,
  `geverifieerd` tinyint(1) NOT NULL DEFAULT '0',
  `kleding_maat_id` int DEFAULT NULL,
  `ouder_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gebruiker`
--

INSERT INTO `gebruiker` (`id`, `voornaam`, `achternaam`, `email`, `telefoon`, `postcode`, `plaatsnaam`, `wachtwoord`, `profiel_foto`, `huisnummer`, `geverifieerd`, `kleding_maat_id`, `ouder_id`) VALUES
(4, 'Lars', 'Rutjens', 'Larsrutjens1@gmail.com', '0681543006', '5751 JA', 'Deurne', '$2y$10$bq7Yignv9IZb5wdcVhANpO8uSDo63JH5a1LncKKooE4ynZ0Cl5TFC', NULL, '31', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gebruiker_rol`
--

CREATE TABLE `gebruiker_rol` (
  `id` int NOT NULL,
  `gebruiker_id` int NOT NULL,
  `rol_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gebruiker_rol`
--

INSERT INTO `gebruiker_rol` (`id`, `gebruiker_id`, `rol_id`) VALUES
(1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inschrijving`
--

CREATE TABLE `inschrijving` (
  `id` int NOT NULL,
  `gebruiker_id` int NOT NULL,
  `event_tijd_id` int NOT NULL,
  `heeft_betaald` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kleding_maat`
--

CREATE TABLE `kleding_maat` (
  `id` int NOT NULL,
  `maat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `planning`
--

CREATE TABLE `planning` (
  `id` int NOT NULL,
  `activiteit_event_tijd_id` int NOT NULL,
  `gebruiker_id` int NOT NULL,
  `vereniging_id` int NOT NULL,
  `begin_tijd` time DEFAULT NULL,
  `eind_tijd` time DEFAULT NULL,
  `is_betaald` tinyint(1) NOT NULL DEFAULT '0',
  `gewerkte_uren` float DEFAULT NULL,
  `goedgekeurd` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id` int NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'Gebruiker'),
(2, 'Admin'),
(3, 'Organisator'),
(4, 'Begeleider'),
(5, 'Speler');

-- --------------------------------------------------------

--
-- Table structure for table `sector`
--

CREATE TABLE `sector` (
  `id` int NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sector_event`
--

CREATE TABLE `sector_event` (
  `event_id` int NOT NULL,
  `sector_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vereniging`
--

CREATE TABLE `vereniging` (
  `id` int NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activiteit`
--
ALTER TABLE `activiteit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activiteit_event_tijd`
--
ALTER TABLE `activiteit_event_tijd`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activiteit_id` (`activiteit_id`,`event_tijd_id`),
  ADD KEY `idx_aet_activiteit` (`activiteit_id`),
  ADD KEY `idx_aet_eventtijd` (`event_tijd_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_hoofd` (`hoofd_event`),
  ADD KEY `fk_event_organisator` (`organisator_id`);

--
-- Indexes for table `event_tijd`
--
ALTER TABLE `event_tijd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_eventtijd_event` (`event_id`),
  ADD KEY `idx_eventtijd_datum` (`datum`);

--
-- Indexes for table `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_gebruiker_kledingmaat` (`kleding_maat_id`),
  ADD KEY `fk_gebruiker_ouder` (`ouder_id`);

--
-- Indexes for table `gebruiker_rol`
--
ALTER TABLE `gebruiker_rol`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gebruiker_id` (`gebruiker_id`,`rol_id`),
  ADD KEY `idx_gebruikerrol_gebruiker` (`gebruiker_id`),
  ADD KEY `idx_gebruikerrol_rol` (`rol_id`);

--
-- Indexes for table `inschrijving`
--
ALTER TABLE `inschrijving`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gebruiker_id` (`gebruiker_id`,`event_tijd_id`),
  ADD KEY `idx_inschrijving_gebruiker` (`gebruiker_id`),
  ADD KEY `idx_inschrijving_eventtijd` (`event_tijd_id`);

--
-- Indexes for table `kleding_maat`
--
ALTER TABLE `kleding_maat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gebruiker_id` (`gebruiker_id`,`activiteit_event_tijd_id`),
  ADD KEY `fk_planning_membership` (`gebruiker_id`,`vereniging_id`),
  ADD KEY `idx_planning_user` (`gebruiker_id`),
  ADD KEY `idx_planning_vereniging` (`vereniging_id`),
  ADD KEY `idx_planning_aet` (`activiteit_event_tijd_id`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sector_event`
--
ALTER TABLE `sector_event`
  ADD PRIMARY KEY (`event_id`,`sector_id`),
  ADD KEY `idx_sectorevent_event` (`event_id`),
  ADD KEY `idx_sectorevent_sector` (`sector_id`);

--
-- Indexes for table `vereniging`
--
ALTER TABLE `vereniging`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activiteit`
--
ALTER TABLE `activiteit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activiteit_event_tijd`
--
ALTER TABLE `activiteit_event_tijd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `event_tijd`
--
ALTER TABLE `event_tijd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gebruiker_rol`
--
ALTER TABLE `gebruiker_rol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inschrijving`
--
ALTER TABLE `inschrijving`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kleding_maat`
--
ALTER TABLE `kleding_maat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sector`
--
ALTER TABLE `sector`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vereniging`
--
ALTER TABLE `vereniging`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activiteit_event_tijd`
--
ALTER TABLE `activiteit_event_tijd`
  ADD CONSTRAINT `fk_aet_activiteit` FOREIGN KEY (`activiteit_id`) REFERENCES `activiteit` (`id`),
  ADD CONSTRAINT `fk_aet_eventtijd` FOREIGN KEY (`event_tijd_id`) REFERENCES `event_tijd` (`id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_hoofd` FOREIGN KEY (`hoofd_event`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `fk_event_organisator` FOREIGN KEY (`organisator_id`) REFERENCES `gebruiker` (`id`);

--
-- Constraints for table `event_tijd`
--
ALTER TABLE `event_tijd`
  ADD CONSTRAINT `fk_eventtijd_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);

--
-- Constraints for table `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD CONSTRAINT `fk_gebruiker_kledingmaat` FOREIGN KEY (`kleding_maat_id`) REFERENCES `kleding_maat` (`id`),
  ADD CONSTRAINT `fk_gebruiker_ouder` FOREIGN KEY (`ouder_id`) REFERENCES `gebruiker` (`id`);

--
-- Constraints for table `gebruiker_rol`
--
ALTER TABLE `gebruiker_rol`
  ADD CONSTRAINT `fk_gebruikerrol_gebruiker` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`id`),
  ADD CONSTRAINT `fk_gebruikerrol_rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);

--
-- Constraints for table `inschrijving`
--
ALTER TABLE `inschrijving`
  ADD CONSTRAINT `fk_inschrijving_eventtijd` FOREIGN KEY (`event_tijd_id`) REFERENCES `event_tijd` (`id`),
  ADD CONSTRAINT `fk_inschrijving_gebruiker` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`id`);

--
-- Constraints for table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `fk_planning_aet` FOREIGN KEY (`activiteit_event_tijd_id`) REFERENCES `activiteit_event_tijd` (`id`),
  ADD CONSTRAINT `fk_planning_gebruiker` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`id`),
  ADD CONSTRAINT `fk_planning_vereniging` FOREIGN KEY (`vereniging_id`) REFERENCES `vereniging` (`id`);

--
-- Constraints for table `sector_event`
--
ALTER TABLE `sector_event`
  ADD CONSTRAINT `fk_sectorevent_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `fk_sectorevent_sector` FOREIGN KEY (`sector_id`) REFERENCES `sector` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
