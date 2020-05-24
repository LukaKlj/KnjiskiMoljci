-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 24, 2020 at 08:55 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `knjiskimoljci`
--
CREATE DATABASE IF NOT EXISTS `knjiskimoljci` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `knjiskimoljci`;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `IdKor` int(11) NOT NULL,
  PRIMARY KEY (`IdKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`IdKor`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
CREATE TABLE IF NOT EXISTS `cita` (
  `Strana` int(11) NOT NULL,
  `IdTeksta` int(11) NOT NULL,
  `IdKor` int(11) NOT NULL,
  PRIMARY KEY (`IdTeksta`,`IdKor`),
  KEY `R_15` (`IdKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cita`
--

INSERT INTO `cita` (`Strana`, `IdTeksta`, `IdKor`) VALUES
(23, 4, 14),
(6, 4, 19);

-- --------------------------------------------------------

--
-- Table structure for table `citalac`
--

DROP TABLE IF EXISTS `citalac`;
CREATE TABLE IF NOT EXISTS `citalac` (
  `VrstaKartice` varchar(20) NOT NULL,
  `BrojKartice` char(19) NOT NULL,
  `MesecIsteka` char(2) NOT NULL,
  `GodinaIsteka` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `CVV` char(4) NOT NULL,
  `IdKor` int(11) NOT NULL,
  PRIMARY KEY (`IdKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `citalac`
--

INSERT INTO `citalac` (`VrstaKartice`, `BrojKartice`, `MesecIsteka`, `GodinaIsteka`, `CVV`, `IdKor`) VALUES
('Visa', '4530 6542 1262 3248', '10', '2020', '983', 23),
('Master', '5515 9779 1340 0830', '8', '2023', '483', 24),
('American', '3715 9104 5047 734', '2', '2021', '948', 25);

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

DROP TABLE IF EXISTS `komentar`;
CREATE TABLE IF NOT EXISTS `komentar` (
  `IdKom` int(11) NOT NULL AUTO_INCREMENT,
  `Tekst` text NOT NULL,
  `Datum` date NOT NULL,
  `Vreme` time NOT NULL,
  `IdKor` int(11) NOT NULL,
  `IdTeksta` int(11) NOT NULL,
  PRIMARY KEY (`IdKom`),
  KEY `R_9` (`IdKor`),
  KEY `R_10` (`IdTeksta`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`IdKom`, `Tekst`, `Datum`, `Vreme`, `IdKor`, `IdTeksta`) VALUES
(1, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-17', '19:28:19', 21, 1),
(2, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-16', '20:20:20', 4, 1),
(3, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-18', '10:23:49', 17, 2),
(4, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-18', '19:58:54', 10, 2),
(5, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-18', '19:58:54', 14, 3),
(6, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-18', '09:09:12', 6, 3),
(7, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-18', '07:17:59', 9, 4),
(8, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-18', '21:29:54', 14, 4),
(9, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-18', '19:28:19', 22, 5),
(10, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus necessitatibus officiis dolore mollitia voluptate excepturi qui possimus rem iste repellat nemo adipisci eveniet repellendus, quia aut, perferendis reiciendis minima alias.', '2020-05-18', '05:47:38', 9, 5);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `Ime` varchar(30) NOT NULL,
  `Prezime` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `DatumRodjenja` date NOT NULL,
  `Pol` char(1) NOT NULL,
  `IdKor` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IdKor`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`Ime`, `Prezime`, `email`, `username`, `password`, `DatumRodjenja`, `Pol`, `IdKor`) VALUES
('Marija', 'Miletic', 'marija@mail.com', 'maya', 'sifra123', '1998-12-12', 'z', 1),
('Luka', 'Kljajic', 'luka@mail.com', 'luka', 'sifra123', '1998-09-22', 'm', 2),
('Filip', 'Lazovic', 'filip@mail.com', 'filip', 'sifra123', '1998-06-06', 'm', 3),
('Vlado', 'Jankovic', 'vlado@mail.com', 'vlado', 'sifra123', '1998-02-01', 'm', 4),
('Danka', 'Grbic', 'danka@mail.com', 'danka', 'sifra123', '1998-03-03', 'z', 5),
('Kristijan', 'Kovacic', 'kristijan@mail.com', 'kris', 'sifra123', '1997-08-08', 'm', 6),
('Draga', 'Tomcic', 'draga@mail.com', 'draga', 'sifra123', '1997-02-03', 'z', 7),
('Velimir', 'Brankovic', 'velja@mail.com', 'velja', 'sifra123', '1987-02-01', 'm', 8),
('Ivanka', 'Brankovic', 'ivanka@mail.com', 'ivanka', 'sifra123', '1981-02-07', 'z', 9),
('Vitomir', 'Zivkovic', 'vita@mail.com', 'vita', 'sifra123', '1945-02-07', 'm', 10),
('Anica', 'Lukic', 'anica@mail.com', 'anica', 'sifra123', '1976-07-01', 'z', 11),
('Zlatan', 'Ivanovic', 'zlatan@mail.com', 'zlatan', 'sifra123', '1999-09-08', 'm', 12),
('Stevo', 'Dragic', 'stevo@mail.com', 'stevo', 'sifra123', '1972-10-23', 'm', 13),
('Dubravka', 'Radic', 'dubravka@mail.com', 'dubravka', 'sifra123', '1980-11-30', 'z', 14),
('Mira', 'Gavrilovic', 'mira@mail.com', 'mira', 'sifra123', '1957-07-29', 'z', 15),
('Jelka', 'Tomcic', 'jelka@mail.com', 'jelka', 'sifra123', '1967-12-18', 'z', 16),
('Mirjana', 'Jovanovic', 'mira2@mail.com', 'mira2', 'sifra123', '1959-11-24', 'z', 17),
('Nina', 'Bogdanovic', 'nina@mail.com', 'nina', 'sifra123', '1975-01-27', 'z', 18),
('Drazen', 'Zivkovic', 'drazen@mail.com', 'drazen', 'sifra123', '1947-06-14', 'm', 19),
('Tatjana', 'Tomic', 'tanja@mail.com', 'tanja', 'sifra123', '1960-12-01', 'z', 20),
('Vladan', 'Zoric', 'vladan@mail.com', 'vladan', 'sifra123', '1957-11-09', 'm', 21),
('Vanja', 'Filipovic', 'vanja@mail.com', 'vanja', 'sifra123', '1987-06-10', 'z', 22),
('Zaklina', 'Babic', 'zaklina@mail.com', 'zaklina', 'sifra123', '1990-10-19', 'z', 23),
('Ivo', 'Loncar', 'ivo@mail.com', 'ivo', 'sifra123', '1937-06-20', 'm', 24),
('Vladimir', 'Jovanovic', 'vladimir@mail.com', 'vladimir', 'sifra123', '2000-12-12', 'm', 25),
('Lazar', 'Crncevic', 'lazar@mail.com', 'lazar', 'sifra123', '1992-09-28', 'm', 26),
('Radomir', 'Davidovic', 'rasa@mail.com', 'rasa', 'sifra123', '1969-12-07', 'm', 27);

-- --------------------------------------------------------

--
-- Table structure for table `oblast`
--

DROP TABLE IF EXISTS `oblast`;
CREATE TABLE IF NOT EXISTS `oblast` (
  `IdObl` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(20) NOT NULL,
  `BrojRecenzenata` int(11) NOT NULL,
  PRIMARY KEY (`IdObl`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `oblast`
--

INSERT INTO `oblast` (`IdObl`, `Naziv`, `BrojRecenzenata`) VALUES
(1, 'Beletristika', 1),
(2, 'Avantura', 1),
(3, 'Naucna fantastika', 1),
(4, 'Romantika', 1),
(5, 'Klasici', 1),
(6, 'Psihologija', 1),
(7, 'Krimi', 1),
(8, 'Prirodne nauke', 1),
(9, 'Geografija', 1),
(10, 'Istorija', 1),
(11, 'Medicina', 1),
(12, 'Poezija', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ocena`
--

DROP TABLE IF EXISTS `ocena`;
CREATE TABLE IF NOT EXISTS `ocena` (
  `Ocena` smallint(6) NOT NULL,
  `IdKor` int(11) NOT NULL,
  `IdTeksta` int(11) NOT NULL,
  PRIMARY KEY (`IdKor`,`IdTeksta`),
  KEY `R_8` (`IdTeksta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ocena`
--

INSERT INTO `ocena` (`Ocena`, `IdKor`, `IdTeksta`) VALUES
(3, 3, 8),
(3, 4, 5),
(5, 5, 5),
(4, 14, 1),
(2, 15, 1),
(2, 19, 3),
(4, 24, 8),
(4, 25, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pisac`
--

DROP TABLE IF EXISTS `pisac`;
CREATE TABLE IF NOT EXISTS `pisac` (
  `IdKor` int(11) NOT NULL,
  `PocetakKarijere` date NOT NULL,
  PRIMARY KEY (`IdKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pisac`
--

INSERT INTO `pisac` (`IdKor`, `PocetakKarijere`) VALUES
(14, '2020-01-03'),
(15, '2020-03-03'),
(16, '2016-12-12'),
(17, '2018-11-11'),
(18, '2016-09-18'),
(19, '2016-01-19'),
(20, '2016-12-12'),
(21, '2015-10-29'),
(22, '2015-12-17');

-- --------------------------------------------------------

--
-- Table structure for table `recenzent`
--

DROP TABLE IF EXISTS `recenzent`;
CREATE TABLE IF NOT EXISTS `recenzent` (
  `IdKor` int(11) NOT NULL,
  `BrojZavrsenihRecenzija` int(11) NOT NULL,
  `IdObl` int(11) NOT NULL,
  PRIMARY KEY (`IdKor`),
  KEY `R_11` (`IdObl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recenzent`
--

INSERT INTO `recenzent` (`IdKor`, `BrojZavrsenihRecenzija`, `IdObl`) VALUES
(2, 0, 7),
(3, 0, 9),
(4, 0, 8),
(5, 1, 1),
(6, 0, 2),
(7, 1, 3),
(8, 0, 4),
(9, 1, 5),
(10, 0, 6),
(11, 1, 10),
(12, 1, 11),
(13, 0, 12);

-- --------------------------------------------------------

--
-- Table structure for table `recenzija`
--

DROP TABLE IF EXISTS `recenzija`;
CREATE TABLE IF NOT EXISTS `recenzija` (
  `IdTeksta` int(11) NOT NULL,
  `IdKor` int(11) NOT NULL,
  PRIMARY KEY (`IdTeksta`),
  KEY `R_17` (`IdKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recenzija`
--

INSERT INTO `recenzija` (`IdTeksta`, `IdKor`) VALUES
(8, 5),
(5, 7),
(7, 9),
(3, 11),
(1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tekst`
--

DROP TABLE IF EXISTS `tekst`;
CREATE TABLE IF NOT EXISTS `tekst` (
  `IdTeksta` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(50) NOT NULL,
  `Odobren` tinyint(1) NOT NULL,
  `Tekst` varchar(20) NOT NULL,
  `IdKor` int(11) NOT NULL,
  `IdObl` int(11) NOT NULL,
  `Datum` date NOT NULL,
  `Vreme` time NOT NULL,
  PRIMARY KEY (`IdTeksta`),
  KEY `R_5` (`IdKor`),
  KEY `R_6` (`IdObl`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tekst`
--

INSERT INTO `tekst` (`IdTeksta`, `Naziv`, `Odobren`, `Tekst`, `IdKor`, `IdObl`, `Datum`, `Vreme`) VALUES
(1, 'Tekst 1', 1, '1.pdf', 7, 11, '2020-03-11', '10:23:49'),
(2, 'Tekst 2', 0, '2.pdf', 24, 1, '2020-04-08', '19:28:19'),
(3, 'Tekst 3', 1, '3.pdf', 20, 10, '2020-03-28', '20:20:20'),
(4, 'Tekst 4', 0, '4.pdf', 25, 3, '2020-05-01', '19:58:54'),
(5, 'Tekst 5', 1, '5.pdf', 1, 3, '2020-03-20', '19:58:54'),
(6, 'Tekst 6', 0, '6.pdf', 19, 11, '2020-05-11', '10:23:49'),
(7, 'Tekst 7', 1, '7.pdf', 5, 5, '2020-05-18', '19:58:54'),
(8, 'Tekst 8', 1, '8.pdf', 21, 1, '2020-05-04', '22:00:00'),
(9, 'Tekst 9', 0, '9.pdf', 7, 3, '2020-05-17', '21:08:12'),
(10, 'Tekst 10', 0, '10.pdf', 1, 3, '2020-05-18', '10:23:49'),
(11, 'naslov', 0, '11.pdf', 1, 1, '2020-05-24', '07:31:30'),
(12, 'naslov', 0, '12.pdf', 1, 1, '2020-05-24', '07:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `zahtev`
--

DROP TABLE IF EXISTS `zahtev`;
CREATE TABLE IF NOT EXISTS `zahtev` (
  `IdZah` int(11) NOT NULL AUTO_INCREMENT,
  `Datum` date NOT NULL,
  `Vreme` time NOT NULL,
  `IdKor` int(11) NOT NULL,
  `IdObl` int(11) NOT NULL,
  PRIMARY KEY (`IdZah`),
  KEY `R_12` (`IdKor`),
  KEY `R_13` (`IdObl`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `zahtev`
--

INSERT INTO `zahtev` (`IdZah`, `Datum`, `Vreme`, `IdKor`, `IdObl`) VALUES
(1, '2019-12-16', '10:23:49', 20, 1),
(2, '2020-02-04', '10:23:49', 16, 8),
(3, '2020-03-18', '10:23:49', 18, 10),
(4, '2020-04-08', '19:58:54', 21, 1),
(7, '2020-05-24', '07:48:19', 21, 5),
(8, '2020-05-24', '07:58:03', 21, 10),
(9, '2020-05-24', '08:03:59', 21, 8);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
