-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 19 sep 2024 om 09:47
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easyevents`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event`
--

CREATE TABLE `event` (
  `ID` int(11) NOT NULL,
  `EventNaam` varchar(50) DEFAULT NULL,
  `Informatie` varchar(500) DEFAULT NULL,
  `Plaats` varchar(170) DEFAULT NULL,
  `Organistor` varchar(50) DEFAULT NULL,
  `AantalVrijwillegers` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event-tijd`
--

CREATE TABLE `event-tijd` (
  `Event_ID` int(11) NOT NULL,
  `Datum` date DEFAULT NULL,
  `BeginTijd` time DEFAULT NULL,
  `EindTijd` time DEFAULT NULL,
  `Sector` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

CREATE TABLE `gebruiker` (
  `ID` int(11) NOT NULL,
  `Voornaam` varchar(70) DEFAULT NULL,
  `Achternaam` varchar(70) DEFAULT NULL,
  `E-mail` varchar(120) DEFAULT NULL,
  `Telefoon` varchar(20) DEFAULT NULL,
  `Instellingen` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Instellingen`)),
  `Postcode` varchar(8) DEFAULT NULL,
  `Plaatsnaam` varchar(100) DEFAULT NULL,
  `Rol` varchar(50) DEFAULT NULL,
  `Wachtwoord` varchar(100) DEFAULT NULL,
  `Gebruikernaam` varchar(50) DEFAULT NULL,
  `Profiel_foto` mediumtext DEFAULT NULL,
  `Huisnummer` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `planning`
--

CREATE TABLE `planning` (
  `Event_ID` int(11) NOT NULL,
  `Gebruiker_ID` int(11) DEFAULT NULL,
  `StartTijd` time DEFAULT NULL,
  `EindTijd` time DEFAULT NULL,
  `Datum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vrijwilligers`
--

CREATE TABLE `vrijwilligers` (
  `Event_ID` int(11) NOT NULL,
  `Gebruiker_ID` int(11) DEFAULT NULL,
  `BeginTijd` time DEFAULT NULL,
  `EindTijd` time DEFAULT NULL,
  `Datum` date DEFAULT NULL,
  `Organisatie` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexen voor tabel `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`Event_ID`),
  ADD KEY `Gebruiker_ID` (`Gebruiker_ID`);

--
-- Indexen voor tabel `vrijwilligers`
--
ALTER TABLE `vrijwilligers`
  ADD PRIMARY KEY (`Event_ID`),
  ADD KEY `Gebruiker_ID` (`Gebruiker_ID`);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `event-tijd`
--
ALTER TABLE `event-tijd`
  ADD CONSTRAINT `event-tijd_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`ID`);

--
-- Beperkingen voor tabel `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`ID`),
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`Gebruiker_ID`) REFERENCES `gebruiker` (`ID`);

--
-- Beperkingen voor tabel `vrijwilligers`
--
ALTER TABLE `vrijwilligers`
  ADD CONSTRAINT `vrijwilligers_ibfk_1` FOREIGN KEY (`Gebruiker_ID`) REFERENCES `gebruiker` (`ID`),
  ADD CONSTRAINT `vrijwilligers_ibfk_2` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
