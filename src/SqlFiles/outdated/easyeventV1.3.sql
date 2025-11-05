-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 10.250.0.103
-- Gegenereerd op: 19 nov 2024 om 10:41
-- Serverversie: 8.0.40-0ubuntu0.24.04.1
-- PHP-versie: 8.1.2-1ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easyevent`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `afbeeldingen`
--

CREATE TABLE `afbeeldingen` (
  `Event_ID` int NOT NULL,
  `Afbeelding` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `Beschrijving` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event`
--

CREATE TABLE `event` (
  `ID` int NOT NULL,
  `Eventnaam` varchar(50) DEFAULT NULL,
  `Info` varchar(500) DEFAULT NULL,
  `Plaats` varchar(170) DEFAULT NULL,
  `Organisator` varchar(50) DEFAULT NULL,
  `Banner` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event-tijd`
--

CREATE TABLE `event-tijd` (
  `Event_ID` int NOT NULL,
  `Datum` date DEFAULT NULL,
  `BeginTijd` time DEFAULT NULL,
  `EindTijd` time DEFAULT NULL,
  `Sector` varchar(50) DEFAULT NULL,
  `AantalVrijwilligers` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `event-tijd`
--

INSERT INTO `event-tijd` (`Event_ID`, `Datum`, `BeginTijd`, `EindTijd`, `Sector`, `AantalVrijwilligers`) VALUES
(1, '2024-12-01', '14:00:00', '18:00:00', 'Bar', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

CREATE TABLE `gebruiker` (
  `ID` int NOT NULL,
  `Voornaam` varchar(70) NOT NULL,
  `Achternaam` varchar(70) NOT NULL,
  `E-mail` varchar(120) NOT NULL,
  `Telefoon` varchar(20) NOT NULL,
  `Instellingen` json DEFAULT NULL,
  `Postcode` varchar(8) DEFAULT NULL,
  `Plaatsnaam` varchar(100) DEFAULT NULL,
  `Rol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Wachtwoord` varchar(100) NOT NULL,
  `Gebruikersnaam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Profiel_foto` mediumtext,
  `Huisnummer` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`ID`, `Voornaam`, `Achternaam`, `E-mail`, `Telefoon`, `Instellingen`, `Postcode`, `Plaatsnaam`, `Rol`, `Wachtwoord`, `Gebruikersnaam`, `Profiel_foto`, `Huisnummer`) VALUES
(23, 'Bart', 'Stoffels', 'bart.stoffels@student.gildeopleidingen.nl', '0630024611', NULL, NULL, NULL, 'admin', '$2y$10$qSEUj/wGUliOqf7/KT.kAOEonhEtzJ2d02lU1hWwgI0y27WXyfYyS', 'bart.stoffels@student.gildeopleidingen.nl', NULL, NULL),
(28, 'Kyan', 'Gerritsma', 'Kyan.Gerritsma@student.gildeopleidingen.nl', '123456789', NULL, NULL, NULL, 'gebruiker', '$2y$10$k4qSVNpqcy0DGR0xXceMmePbqJTzLVKaVLslr.Ic3zk9hV6pC7hxi', 'Kyan.Gerritsma@student.gildeopleidingen.nl', NULL, NULL),
(29, 'Emre', 'Simseker', 'emre.simseker@student.gildeopleidingen.nl', '06987654321', NULL, NULL, NULL, 'gebruiker', '$2y$10$k2AjRLWyqrYs56ZXb2NJreEZftDmWGYMx4kMXRJlHTXKg0A.71IFe', 'emre.simseker@student.gildeopleidingen.nl', NULL, NULL),
(31, 'Runar', 'Hosli', 'runar.hosli@student.gildeopleidingen.nl', '+31 06 41783027', NULL, NULL, NULL, 'gebruiker', '$2y$10$LFXnIxGzaSDIpEzw8h3az.dO0MESblxY54TKZsOSnQekcwaspIDLW', 'runar.hosli@student.gildeopleidingen.nl', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `planning`
--

CREATE TABLE `planning` (
  `Event_ID` int NOT NULL,
  `Gebruiker_ID` int NOT NULL,
  `StartTijd` time DEFAULT NULL,
  `EindTijd` time DEFAULT NULL,
  `Datum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `planning`
--

INSERT INTO `planning` (`Event_ID`, `Gebruiker_ID`, `StartTijd`, `EindTijd`, `Datum`) VALUES
(1, 1, '14:00:00', '18:00:00', '2024-12-01');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vrijwilligers`
--

CREATE TABLE `vrijwilligers` (
  `Event_ID` int NOT NULL,
  `Gebruiker_ID` int NOT NULL,
  `BeginTijd` time NOT NULL,
  `EindTijd` time NOT NULL,
  `Datum` date NOT NULL,
  `Organisatie` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `vrijwilligers`
--

INSERT INTO `vrijwilligers` (`Event_ID`, `Gebruiker_ID`, `BeginTijd`, `EindTijd`, `Datum`, `Organisatie`) VALUES
(1, 1, '14:00:00', '18:00:00', '2024-12-01', 'Gilde');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `event-tijd`
--
ALTER TABLE `event-tijd`
  ADD PRIMARY KEY (`Event_ID`);

--
-- Indexen voor tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `event`
--
ALTER TABLE `event`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `event-tijd`
--
ALTER TABLE `event-tijd`
  MODIFY `Event_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
