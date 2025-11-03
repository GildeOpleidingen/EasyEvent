-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 10.250.0.103
-- Gegenereerd op: 05 dec 2024 om 08:30
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
  `Banner` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `SubEvent` int DEFAULT NULL
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
  `Huisnummer` varchar(6) DEFAULT NULL,
  `is_geverifieerd` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`ID`, `Voornaam`, `Achternaam`, `E-mail`, `Telefoon`, `Instellingen`, `Postcode`, `Plaatsnaam`, `Rol`, `Wachtwoord`, `Gebruikersnaam`, `Profiel_foto`, `Huisnummer`, `is_geverifieerd`) VALUES
(1, 'Bart', 'Stoffels', 'bart.stoffels@student.gildeopleidingen.nl', '0630024611', NULL, NULL, NULL, 'admin', '$2y$10$qSEUj/wGUliOqf7/KT.kAOEonhEtzJ2d02lU1hWwgI0y27WXyfYyS', 'bart.stoffels@student.gildeopleidingen.nl', NULL, NULL, '0'),
(3, 'Emre', 'Simseker', 'emre.simseker@student.gildeopleidingen.nl', '06987654321', NULL, NULL, NULL, 'gebruiker', '$2y$10$k2AjRLWyqrYs56ZXb2NJreEZftDmWGYMx4kMXRJlHTXKg0A.71IFe', 'emre.simseker@student.gildeopleidingen.nl', NULL, NULL, '0'),
(4, 'Runar', 'Hosli', 'runar.hosli@student.gildeopleidingen.nl', '+31 06 41783027', NULL, NULL, NULL, 'gebruiker', '$2y$10$LFXnIxGzaSDIpEzw8h3az.dO0MESblxY54TKZsOSnQekcwaspIDLW', 'runar.hosli@student.gildeopleidingen.nl', NULL, NULL, '0'),
(5, 'Hamza', 'Sheikdon', 'HamzaSheikdon@gmail.com', '0612345678', NULL, NULL, NULL, 'gebruiker', '$2y$10$rrCJQjZo9YVN/tFhC0Te9.QAABkG.aN1D7Kw8yUqeE.9w4eST10JC', 'HamzaSheikdon@gmail.com', NULL, NULL, '0'),
(7, 'Joep', 'Verhofstad', 'joepverhofstad1@gmail.com', '+31 6 123456789', NULL, NULL, NULL, 'gebruiker', '$2y$10$mRpsC5ltyIVTEln1VULMCOmi6dy/NGUsEwvKV5ucx7xgL.vuoCtai', 'joepverhofstad1@gmail.com', NULL, NULL, '0'),
(8, 'John', 'Pork', 'JohnPork@gmail.com', '+62 95985982', NULL, NULL, NULL, 'gebruiker', '$2y$10$uie.FZT19YDNaPpFcQ73ouq.QGVxfI.HRAjmQEEmSbYpMp32mvBAi', 'JohnPork@gmail.com', NULL, NULL, '0'),
(9, 'Disco', 'Piet', 'DJYoner@gmail.com', '12345789', NULL, NULL, NULL, 'gebruiker', '$2y$10$KlMNQE.6i6.UwqT3mZmY2./nTknInirnmGIEKXtcYLHsRmlQ0XO9C', 'DJYoner@gmail.com', NULL, NULL, '0'),
(10, 'John', 'Doe', 'Johndoe@schaapje.nl', '12345789', NULL, NULL, NULL, 'gebruiker', '$2y$10$OKWWloPQSwOPOq8wpkYgM.s5gtaGPJdCHD6g3Ia49aarp5IhElrda', 'Johndoe@schaapje.nl', NULL, NULL, '0'),
(11, 'test', 'test', 'test@gmail.com', '+31 06 41783027', NULL, NULL, NULL, 'gebruiker', '$2y$10$VT8o4nA3P7uOTrqrFEl1QuQODWLn9qhzhsCFO83bzUdbAAi6y6REO', 'test@gmail.com', NULL, NULL, '0'),
(12, 'Runar', 'Hosli', 'runarcaretta@gmail.com', '+31 06 41783027', NULL, NULL, NULL, 'gebruiker', '$2y$10$dyTRTtytAZZhAW3qJ4kWzOWrJFdwi7LSwxdAl2WYdr1xzZ/OM8C0G', 'runarcaretta@gmail.com', NULL, NULL, '0'),
(14, 'Kyan', 'Gerritsma', 'Kyan.Gerritsma@student.gildeopleidingen.nl', '12345789', NULL, NULL, NULL, 'gebruiker', '$2y$10$Y18BB.2byvEdyQvApZAp8u7.qfSmbZW5LRQoRvbp/ynyrkkjiv6fa', 'Kyan.Gerritsma@student.gildeopleidingen.nl', NULL, NULL, ''),
(17, 'Trow', 'Away', 'Trowawayacc124@gmail.com', '0612345678', NULL, NULL, NULL, 'gebruiker', '$2y$10$VYxw5rJKo7fbB3HiTwt5kejGcWaTQt/zeBkXJj6btHUwUTxdjnbey', 'Trowawayacc124@gmail.com', NULL, NULL, ''),
(18, 'e', 'e', 'emresimseker10@gmail.com', '123', NULL, NULL, NULL, 'gebruiker', '$2y$10$7mfFrhS6eTDwF6RKl4dmpeZHuevUht17qNtncJOegyhh76Z6d7mVC', 'emresimseker10@gmail.com', NULL, NULL, 'ja'),
(19, 'Runar', 'Hosli', 'runarcaretta1@gmail.com', '123456789', NULL, NULL, NULL, 'gebruiker', '$2y$10$mSicln8s1B8CwEEqtwG0h.L09v3FKt0OeN8Gkb/5.HcYpOXXikkfW', 'runarcaretta1@gmail.com', NULL, NULL, '');

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
  `Organisatie` varchar(150) DEFAULT NULL,
  `Betaalt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `afbeeldingen`
--
ALTER TABLE `afbeeldingen`
  ADD PRIMARY KEY (`Event_ID`);

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
  ADD PRIMARY KEY (`Event_ID`,`Gebruiker_ID`),
  ADD KEY `Gebruiker_ID` (`Gebruiker_ID`);

--
-- Indexen voor tabel `vrijwilligers`
--
ALTER TABLE `vrijwilligers`
  ADD PRIMARY KEY (`Event_ID`,`Gebruiker_ID`),
  ADD KEY `Gebruiker_ID` (`Gebruiker_ID`);

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
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `afbeeldingen` (`Event_ID`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `event-tijd`
--
ALTER TABLE `event-tijd`
  ADD CONSTRAINT `event-tijd_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`ID`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`Gebruiker_ID`) REFERENCES `gebruiker` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`ID`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `vrijwilligers`
--
ALTER TABLE `vrijwilligers`
  ADD CONSTRAINT `vrijwilligers_ibfk_1` FOREIGN KEY (`Gebruiker_ID`) REFERENCES `gebruiker` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `vrijwilligers_ibfk_2` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
