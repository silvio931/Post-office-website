-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 16, 2020 at 09:33 PM
-- Server version: 5.5.62-0+deb8u1
-- PHP Version: 7.2.25-1+0~20191128.32+debian8~1.gbp108445

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `WebDiP2019x083`
--

-- --------------------------------------------------------

--
-- Table structure for table `dnevnik`
--

CREATE TABLE `dnevnik` (
  `dnevnik_id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `tip_radnje_id` int(11) NOT NULL,
  `radnja` text,
  `upit` text,
  `datum_vrijeme` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dnevnik`
--

INSERT INTO `dnevnik` (`dnevnik_id`, `korisnik_id`, `tip_radnje_id`, `radnja`, `upit`, `datum_vrijeme`) VALUES
(1, 1, 1, NULL, NULL, '2020-04-08 15:32:41'),
(2, 2, 2, NULL, 'select * from poštanski_ured', '2020-04-09 16:00:00'),
(3, 3, 2, NULL, 'INSERT INTO `država` (`država_id`, `ime`) VALUES (NULL, \'Hrvatska\');', '2020-02-04 19:00:00'),
(4, 4, 3, 'Zaprimljena i proslijeđena pošiljka id 5', NULL, '2020-04-02 11:00:00'),
(5, 5, 1, NULL, '', '2020-04-01 14:00:00'),
(6, 6, 2, NULL, 'INSERT INTO `država` (`država_id`, `ime`) VALUES (NULL, \'Slovenija\');', '2020-04-02 17:00:00'),
(7, 6, 3, 'Kreirao izvještaj neplaćenih računa za ured id 5', NULL, '2020-04-03 00:00:00'),
(8, 8, 1, NULL, NULL, '2020-04-01 10:00:00'),
(14, 10, 2, NULL, 'select * from računi', '2020-03-16 19:30:29'),
(15, 7, 3, 'Pregledava dokumentaciju', NULL, '2020-04-02 14:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `dokumentacija`
--

CREATE TABLE `dokumentacija` (
  `dokumentacija_id` int(11) NOT NULL,
  `naziv_dokumenta` varchar(45) NOT NULL,
  `putanja_dokumenta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dokumentacija`
--

INSERT INTO `dokumentacija` (`dokumentacija_id`, `naziv_dokumenta`, `putanja_dokumenta`) VALUES
(1, 'Zaštita privatnosti', 'barka.foi.hr/posta/dokumentacija/dokument1'),
(2, 'Opći uvjeti za obavljanje usluge', 'barka.foi.hr/posta/dokumentacija/dokument2'),
(3, 'Ispravak općih uvjeta', 'barka.foi.hr/posta/dokumentacija/dokument3'),
(4, 'Zakon o elektroničkim komunikacijama', 'barka.foi.hr/posta/dokumentacija/dokument4'),
(5, 'Izvadak iz cjenika unutarnji promet', 'barka.foi.hr/posta/dokumentacija/dokument5'),
(6, 'Izvadak iz cjenika međunarodni promet', 'barka.foi.hr/posta/dokumentacija/dokument6'),
(7, 'Cjenik ostalih usluga', 'barka.foi.hr/posta/dokumentacija/dokument7'),
(8, 'Slovne oznake na markama Europe', 'barka.foi.hr/posta/dokumentacija/dokument8'),
(9, 'Slovne oznake na markama Azije', 'barka.foi.hr/posta/dokumentacija/dokument9'),
(10, 'Slovne oznake na markama Amerike', 'barka.foi.hr/posta/dokumentacija/dokument10');

-- --------------------------------------------------------

--
-- Table structure for table `dokumenti_ureda`
--

CREATE TABLE `dokumenti_ureda` (
  `poštanski_ured_id` int(11) NOT NULL,
  `dokumentacija_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dokumenti_ureda`
--

INSERT INTO `dokumenti_ureda` (`poštanski_ured_id`, `dokumentacija_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 8),
(2, 1),
(2, 2),
(2, 4),
(2, 8),
(3, 8),
(4, 8),
(5, 8),
(6, 8),
(7, 8),
(10, 1),
(10, 2),
(10, 10),
(11, 1),
(11, 9);

-- --------------------------------------------------------

--
-- Table structure for table `država`
--

CREATE TABLE `država` (
  `država_id` int(11) NOT NULL,
  `ime` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `država`
--

INSERT INTO `država` (`država_id`, `ime`) VALUES
(4, 'Austrija'),
(2, 'Engleska'),
(8, 'Francuska'),
(1, 'Hrvatska'),
(6, 'Mađarska'),
(5, 'Njemačka'),
(10, 'Rusija'),
(9, 'Sjedinjene Američke Države'),
(3, 'Slovenija'),
(16, 'Španjolska'),
(7, 'Švicarska');

-- --------------------------------------------------------

--
-- Table structure for table `DZ4_korisnik`
--

CREATE TABLE `DZ4_korisnik` (
  `korisnik_id` int(11) NOT NULL,
  `uloga_id` int(11) NOT NULL,
  `ime` varchar(45) NOT NULL,
  `prezime` varchar(45) NOT NULL,
  `korisnicko_ime` varchar(25) NOT NULL,
  `godina_rodenja` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `lozinka` varchar(25) NOT NULL,
  `lozinka_sha1` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DZ4_korisnik`
--

INSERT INTO `DZ4_korisnik` (`korisnik_id`, `uloga_id`, `ime`, `prezime`, `korisnicko_ime`, `godina_rodenja`, `email`, `lozinka`, `lozinka_sha1`) VALUES
(1, 1, 'admin', 'admin', 'admin', 1990, 'admin@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(2, 2, 'moderator', 'moderator', 'moderator', 1995, 'moderator@gmail.com', 'moderator', '79f52b5b92498b00cb18284f1dcb466bd40ad559'),
(3, 3, 'korisnik', 'korisnik', 'korisnik', 1997, 'korisnik@gmail.com', 'korisnik', 'b26c4eb9e78bc0544b234c4720916ad062c7bb72'),
(4, 4, 'neprijavljen', 'neprijavljen', 'neprijavljen', 1995, 'neprijavljen@gmail.com', 'neprijavljen', 'a467051d18c53b1a8512ffc6aec414a702d526ec'),
(7, 3, '', 'pPrezime', '2000', 0, '', '', ''),
(8, 3, '', 'pPrezime', '2000', 0, '', '', ''),
(9, 3, '', 'pPrezime', '2000', 0, '', '', ''),
(10, 3, '', 'pPrezime', '2000', 0, '', '', ''),
(11, 3, '', 'pPrezime', '2000', 0, '', '', ''),
(12, 3, '', 'pPrezime', '2000', 0, '', '', ''),
(13, 3, '', 'pPrezime', '2000', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `DZ4_popis`
--

CREATE TABLE `DZ4_popis` (
  `zapis_id` int(11) NOT NULL,
  `ime_prezime` varchar(40) NOT NULL,
  `datum_rodenja` datetime NOT NULL,
  `email` varchar(45) NOT NULL,
  `url_adresa` varchar(45) NOT NULL,
  `telefon` varchar(45) NOT NULL,
  `najdraze_utrke` varchar(100) NOT NULL,
  `pracenje_sporta` varchar(45) NOT NULL,
  `razlozi_utrka` varchar(100) NOT NULL,
  `najdrazi_vozac` varchar(45) NOT NULL,
  `broj_prvenstava` int(11) NOT NULL,
  `boja_ociju` varchar(10) NOT NULL,
  `slika_vozaca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DZ4_popis`
--

INSERT INTO `DZ4_popis` (`zapis_id`, `ime_prezime`, `datum_rodenja`, `email`, `url_adresa`, `telefon`, `najdraze_utrke`, `pracenje_sporta`, `razlozi_utrka`, `najdrazi_vozac`, `broj_prvenstava`, `boja_ociju`, `slika_vozaca`) VALUES
(1, 'Ivo Ivic', '2020-05-13 00:00:00', 'iivic@gmail.com', 'https://www.foi.unizg.hr', '001111111', 'Velika nagrada Australije Velika nagrada Kine', 'Samo utrku Samo kvalifikacije', 'Neki razlozi', 'Lewis Hamilston', 7, '#000040', '../multimedija/1.jpg'),
(2, 'Ana Anic', '2019-12-04 00:00:00', 'aanic@gmail.com', 'https://www.foi.unizg.hr/', '+486415', 'Velika nagrada Nizozemske Velika nagrada Španjolske', 'Samo utrku Samo kvalifikacije', 'Neki razlozi', 'Charles Leclerc', 0, '#000045', '../multimedija/1.jpg'),
(9, 'Pero Peric', '2020-05-01 00:00:00', 'peric@gmail.com', 'https://www.foi.unizg.hr', '+6654', 'Velika nagrada Vijetnama,Velika nagrada Kine', 'Samo utrku,Samo kvalifikacije', 'Razlozi...', 'Valtteri Bottas', 0, '#8080ff', '../multimedija/lotus-f1-iphone-wallpaper.jpg'),
(10, 'Marko Markovic', '2020-04-01 02:02:00', 'markovic@gmail.com', 'https://www.foi.unizg.hr', '+64864', 'Velika nagrada Vijetnama,Velika nagrada Kine', 'Samo utrku,Samo kvalifikacije', 'Razlozi', 'Lando Norris', 0, '#00ff00', '../multimedija/lotus-f1-iphone-wallpaper.jpg'),
(11, 'Dario Daric', '2019-12-04 00:00:00', 'daric@gmail.com', 'https://www.foi.unizg.hr', '+6665', 'Velika nagrada Australije,Velika nagrada Vijetnama,Velika nagrada Kine', 'Samo utrku,Samo kvalifikacije', 'Razlozi', 'Lewis Hamilton', 7, '#808040', '../multimedija/lotus-f1-iphone-wallpaper.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `DZ4_uloga`
--

CREATE TABLE `DZ4_uloga` (
  `uloga_id` int(11) NOT NULL,
  `naziv` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DZ4_uloga`
--

INSERT INTO `DZ4_uloga` (`uloga_id`, `naziv`) VALUES
(1, 'Administrator'),
(2, 'Moderator'),
(3, 'Registriran korisnik'),
(4, 'Neregistrirani korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `korisnik_id` int(11) NOT NULL,
  `uloga_id` int(11) NOT NULL,
  `vrsta_statusa_id` int(11) NOT NULL,
  `ime` varchar(45) NOT NULL,
  `prezime` varchar(45) NOT NULL,
  `godina_rodenja` int(11) NOT NULL,
  `korisnicko_ime` varchar(25) NOT NULL,
  `email` varchar(45) NOT NULL,
  `lozinka` varchar(25) NOT NULL,
  `lozinka_sha1` char(40) NOT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `datum_registracije` datetime NOT NULL,
  `uvjeti_koristenja` datetime DEFAULT NULL,
  `blokiran_do` datetime DEFAULT NULL,
  `broj_neuspjela_prijava` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`korisnik_id`, `uloga_id`, `vrsta_statusa_id`, `ime`, `prezime`, `godina_rodenja`, `korisnicko_ime`, `email`, `lozinka`, `lozinka_sha1`, `salt`, `datum_registracije`, `uvjeti_koristenja`, `blokiran_do`, `broj_neuspjela_prijava`) VALUES
(1, 3, 2, 'Ivo', 'Ivić', 1995, 'iivic', 'iivic@gmail.com', 'ivoivic123', '0616939ffeeb5f1489b0ab5ff1987e403ba28b27', 'ded30ad730a2ddb32963b48af115fc9e270c7a3b', '2020-01-08 12:15:16', '2020-01-08 12:35:38', NULL, 0),
(2, 3, 2, 'Ana', 'Anic', 1994, 'aanic', 'aanic@gmail.com', 'anaanic123', '9589e8a6fa7cd2d4e9795144715fe7789b94edcb', '924db99219bf140af3983f540b6238c98453c4e6', '2020-04-01 06:21:26', '2020-04-07 20:44:44', NULL, 0),
(3, 1, 2, 'Silvio', 'Mihalic', 1999, 'smihalic', 'smihalic@gmail.com', 'silviomihalic123', '18331a26c14a22bff615dcf0c535cb9b12811951', 'f71feb6f68861a0fbcc7b1e7b9e122d0c6a456e7', '2020-03-01 17:44:44', '2020-03-01 21:54:53', NULL, 0),
(4, 2, 2, 'Domagoj', 'Mahnet', 1999, 'dmahnet', 'dmahnet@gmail.com', 'domagoj12345', '5c4800d988a400d09a0ce85f365c5416e0aabd91', '36849f2a9b5b3cad1d34a8313a5359aaf9bbf78d', '2020-01-01 15:38:41', '2020-01-01 19:43:33', NULL, 0),
(5, 3, 2, 'Antonio', 'Oletić', 1998, 'aoletic', 'aoletic@gmail.com', 'oletic555', 'faea9103e4a9bf1bcaf339e8db880ff426e0ae71', 'a89849148a8e7d605d28e290aa05c47857714587', '2020-04-01 09:22:27', '2020-04-01 12:00:00', NULL, 0),
(6, 1, 2, 'Lewis', 'Hamilton', 1985, 'lhamilton', 'lhamilton@gmail.com', 'mercedes', 'd94c0d5d6ab9e0bf3dac69162fba398c40b8b1e6', 'fb9e0cc0d8c2d28e962cc7edb24fab55f0d780e6', '2019-12-10 10:32:48', '2019-12-10 20:51:48', NULL, 0),
(7, 3, 2, 'Charles', 'Leclerc', 1996, 'charles', 'leclerc@gmail.com', 'ferrari', '1f347fc130c2bc6ed29c53a719a423d26c5ec8fd', '8d5e3914a2738074299f0c67472cf6bcb281b983', '2020-04-01 15:37:41', '2020-04-01 20:33:33', NULL, 0),
(8, 3, 2, 'Alex', 'Albon', 1997, 'aalbon', 'aalbon@gmail.com', 'albon123', '25b14f4944e53a5f101a127f11e56fe82370f271', '2bdfcb0a5479848dd86ccca8120ed26754c40950', '2020-02-11 08:23:24', '2020-02-11 08:33:00', NULL, 0),
(9, 2, 2, 'Sebastian', 'Vettel', 1984, 'vettel', 'vettel@gmail.com', 'sebastianferrari', '5bca3599d216fc1b7979ff11936f249f1c42a002', '560bf37456936baab0c6ca48de1c4343fbff0dcc', '2020-02-04 16:40:40', '2020-02-04 21:41:40', NULL, 0),
(10, 2, 2, 'Lando', 'Norris', 1997, 'lnorris', 'lnorris@gmail.com', 'mclaren', '0f4a036a9ff196b728ea51da2e1bf56d110f7277', '911c6ce2e9f10cb4c4bd3bceeae32027ec5f4cfc', '2020-04-01 16:38:37', '2020-04-01 19:51:29', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pošiljka`
--

CREATE TABLE `pošiljka` (
  `pošiljka_id` int(11) NOT NULL,
  `početni_ured_id` int(11) DEFAULT NULL,
  `trenutni_ured_id` int(11) DEFAULT NULL,
  `sljedeći_ured_id` int(11) DEFAULT NULL,
  `završni_ured_id` int(11) DEFAULT NULL,
  `pošiljatelj` int(11) NOT NULL,
  `primatelj` int(11) NOT NULL,
  `datum_kreiranja` datetime NOT NULL,
  `datum_otpreme` datetime DEFAULT NULL,
  `cijena_kg` varchar(25) DEFAULT NULL,
  `težina_kg` varchar(25) DEFAULT NULL,
  `datum_pristizanja` datetime DEFAULT NULL,
  `račun_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pošiljka`
--

INSERT INTO `pošiljka` (`pošiljka_id`, `početni_ured_id`, `trenutni_ured_id`, `sljedeći_ured_id`, `završni_ured_id`, `pošiljatelj`, `primatelj`, `datum_kreiranja`, `datum_otpreme`, `cijena_kg`, `težina_kg`, `datum_pristizanja`, `račun_id`) VALUES
(1, 4, 2, 2, 2, 1, 5, '2020-03-18 15:00:00', '2020-06-07 17:52:47', '10', '3', '2020-06-16 14:25:45', NULL),
(2, NULL, NULL, NULL, NULL, 2, 5, '2020-04-02 15:00:00', NULL, NULL, '10', NULL, NULL),
(4, NULL, NULL, NULL, NULL, 10, 8, '2020-04-02 12:00:00', NULL, NULL, '2', NULL, NULL),
(5, 2, 1, 4, 7, 6, 5, '2020-04-02 14:00:00', '2020-04-08 09:00:00', '10', '1', NULL, NULL),
(6, 5, 1, 2, 2, 10, 7, '2020-04-02 16:00:00', '2020-04-10 12:00:00', '8', '3', NULL, NULL),
(7, 5, 8, 8, 8, 6, 8, '2020-03-16 15:00:00', '2020-04-02 13:00:00', '7', '4', '2020-06-07 15:30:30', 46),
(8, 12, 4, 4, 4, 4, 6, '2020-04-01 14:00:00', '2020-04-03 09:00:00', '8', '4', '2020-06-16 14:25:22', 45),
(10, 2, 8, 8, 8, 4, 7, '2020-03-04 16:00:00', '2020-03-16 15:00:00', '6', '6', '2020-04-03 14:00:00', 1),
(12, 2, 12, 12, 12, 3, 7, '2020-02-29 16:00:00', '2020-03-17 09:00:00', '8', '7', '2020-04-01 10:00:00', 3),
(14, 2, 9, 9, 9, 4, 8, '2020-03-04 18:00:00', '2020-03-30 15:00:00', '10', '1', '2020-04-02 14:37:44', 5),
(15, 6, 12, 12, 12, 5, 9, '2020-02-10 14:00:00', '2020-03-03 14:00:00', '8', '8', '2020-04-01 14:00:00', NULL),
(16, 2, 11, 11, 11, 3, 8, '2020-03-04 16:38:38', '2020-03-29 16:33:50', '7', '7', '2020-04-01 12:38:21', NULL),
(18, NULL, NULL, NULL, NULL, 3, 2, '2020-05-29 18:50:04', NULL, NULL, '10', NULL, NULL),
(19, 5, 5, 9, 10, 3, 1, '2020-05-29 18:53:46', '2020-06-16 14:23:22', '20', '1', NULL, NULL),
(20, 4, 10, 10, 10, 3, 1, '2020-05-29 18:55:24', '2020-06-10 21:11:49', '5', '1', '2020-06-11 18:29:39', NULL),
(21, NULL, NULL, NULL, NULL, 3, 2, '2020-05-29 19:39:56', NULL, NULL, '1.3', NULL, NULL),
(22, 11, 5, 9, 9, 8, 5, '2020-06-01 22:51:40', '2020-06-16 14:22:34', '12.50', '5', NULL, NULL),
(33, 4, 2, 2, 2, 7, 8, '2020-06-10 19:15:39', '2020-06-10 19:18:16', '9', '9', '2020-06-10 19:23:12', 39),
(34, 4, 1, 1, 1, 10, 5, '2020-06-10 19:49:12', '2020-06-10 19:50:24', '5', '5', '2020-06-10 19:50:58', 40),
(35, 4, 2, 2, 2, 7, 8, '2020-06-15 19:28:57', '2020-06-15 19:31:40', '5', '5', '2020-06-15 19:35:46', 41),
(37, 2, 1, 1, 1, 7, 8, '2020-06-15 20:42:12', '2020-06-15 20:43:12', '5', '4', '2020-06-15 20:43:35', 43),
(38, NULL, NULL, NULL, NULL, 7, 1, '2020-06-16 14:02:16', NULL, NULL, '9', NULL, NULL),
(40, 9, 3, 3, 3, 7, 9, '2020-06-16 14:07:12', '2020-06-16 14:22:57', '15.00', '0.5', '2020-06-16 14:25:13', NULL),
(41, NULL, NULL, NULL, NULL, 1, 7, '2020-06-16 14:09:40', NULL, NULL, '0.7', NULL, NULL),
(42, 4, 4, 1, 2, 1, 10, '2020-06-16 14:09:48', '2020-06-16 14:22:11', '10.99', '0.2', NULL, NULL),
(43, NULL, NULL, NULL, NULL, 3, 3, '2020-06-16 14:16:13', NULL, NULL, '0.5', NULL, NULL),
(44, NULL, NULL, NULL, NULL, 3, 6, '2020-06-16 14:20:41', NULL, NULL, '0.4', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poštanski_ured`
--

CREATE TABLE `poštanski_ured` (
  `poštanski_ured_id` int(11) NOT NULL,
  `država_id` int(11) NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `naziv` varchar(45) NOT NULL,
  `adresa` varchar(45) NOT NULL,
  `broj_zaposlenih` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poštanski_ured`
--

INSERT INTO `poštanski_ured` (`poštanski_ured_id`, `država_id`, `moderator_id`, `naziv`, `adresa`, `broj_zaposlenih`) VALUES
(1, 1, 9, 'Zagreb', 'Zagrebacka, 55', 10),
(2, 1, 9, 'Split', 'Splitska, 88', 7),
(3, 2, 9, 'London', 'Street 15', 6),
(4, 3, 9, 'Maribor', 'Ljubljanska 10', 4),
(5, 4, 9, 'Beč', 'Strasse 108', 4),
(6, 5, 10, 'Frankfurt', 'Strasse Frankfurt', 15),
(7, 6, 10, 'Budimpešta', 'Hungaroring 55', 5),
(8, 7, 10, 'Bern', 'Strasse 4', 4),
(9, 8, 10, 'Pariz', 'Rue Bonaparte 6', 6),
(10, 9, 10, 'Los Angeles', 'Hollywood 45', 10),
(11, 10, 4, 'Moskva', 'Lenin 55', 3),
(12, 3, 4, 'Ljubljana', 'Lubljanska 18', 4);

-- --------------------------------------------------------

--
-- Table structure for table `račun`
--

CREATE TABLE `račun` (
  `račun_id` int(11) NOT NULL,
  `izdao` int(11) NOT NULL,
  `primatelj_id` int(11) NOT NULL,
  `datum_izdavanja` datetime NOT NULL,
  `jedinična_cijena` varchar(25) NOT NULL,
  `težina_kg` varchar(25) NOT NULL,
  `iznos_obrade` varchar(25) NOT NULL,
  `ukupna_cijena` varchar(25) NOT NULL,
  `datum_plaćanja` datetime DEFAULT NULL,
  `putanja_slike` text,
  `slika_javna` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `račun`
--

INSERT INTO `račun` (`račun_id`, `izdao`, `primatelj_id`, `datum_izdavanja`, `jedinična_cijena`, `težina_kg`, `iznos_obrade`, `ukupna_cijena`, `datum_plaćanja`, `putanja_slike`, `slika_javna`) VALUES
(1, 9, 7, '2020-04-05 11:00:00', '6', '6', '10', '46', '2020-06-03 23:09:07', '5.PNG', 1),
(3, 10, 7, '2020-05-27 13:00:00', '8', '7', '10', '66', '2020-06-06 12:27:44', '6.PNG', 1),
(5, 4, 8, '2020-04-12 12:00:00', '10', '1', '15', '25', '2020-04-30 16:00:00', '4.PNG', 1),
(39, 9, 8, '2020-06-10 19:25:32', '9', '9', '9', '90', '2020-06-10 19:29:05', '7.PNG', 1),
(40, 9, 5, '2020-06-10 19:53:48', '5', '5', '5', '30', '0000-00-00 00:00:00', '8.jpg', 0),
(41, 9, 8, '2020-06-14 19:37:56', '5', '5', '5', '30', '2020-06-15 19:44:06', '15062020194300.PNG', 0),
(43, 9, 8, '2020-06-15 20:46:33', '5', '4', '10', '30', '2020-06-15 20:47:18', '7.PNG', 0),
(45, 9, 6, '2020-06-16 14:29:37', '8', '4', '20', '52', '2020-06-16 14:32:00', '15062020194300.PNG', 1),
(46, 10, 8, '2020-06-16 14:35:58', '7', '4', '5', '33', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tip_radnje`
--

CREATE TABLE `tip_radnje` (
  `tip_radnje_id` int(11) NOT NULL,
  `naziv` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tip_radnje`
--

INSERT INTO `tip_radnje` (`tip_radnje_id`, `naziv`) VALUES
(1, 'Prijava/odjava'),
(2, 'Rad s bazom'),
(3, 'Ostale radnje');

-- --------------------------------------------------------

--
-- Table structure for table `uloga`
--

CREATE TABLE `uloga` (
  `uloga_id` int(11) NOT NULL,
  `naziv` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uloga`
--

INSERT INTO `uloga` (`uloga_id`, `naziv`) VALUES
(1, 'Administrator/upravitelj'),
(2, 'Moderator/poštar'),
(3, 'Registriran korisnik'),
(4, 'Neregistriran korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `vrsta_statusa`
--

CREATE TABLE `vrsta_statusa` (
  `vrsta_statusa_id` int(11) NOT NULL,
  `naziv` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vrsta_statusa`
--

INSERT INTO `vrsta_statusa` (`vrsta_statusa_id`, `naziv`) VALUES
(1, 'Neaktivan'),
(2, 'Aktivan'),
(3, 'Blokiran');

-- --------------------------------------------------------

--
-- Table structure for table `zahtjevi_izdavanje_računa`
--

CREATE TABLE `zahtjevi_izdavanje_računa` (
  `korisnik_id` int(11) NOT NULL,
  `pošiljka_id` int(11) NOT NULL,
  `datum_izvadanja` datetime NOT NULL,
  `račun_izdan` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zahtjevi_izdavanje_računa`
--

INSERT INTO `zahtjevi_izdavanje_računa` (`korisnik_id`, `pošiljka_id`, `datum_izvadanja`, `račun_izdan`) VALUES
(5, 1, '2020-06-16 14:28:00', 0),
(5, 34, '2020-06-10 19:52:56', 1),
(6, 8, '2020-06-16 14:28:25', 1),
(7, 10, '2020-04-05 06:00:00', 1),
(7, 12, '2020-04-07 16:00:00', 1),
(8, 7, '2020-06-16 14:35:00', 1),
(8, 14, '2020-04-05 15:00:00', 1),
(8, 33, '2020-06-10 19:24:20', 1),
(8, 35, '2020-06-15 19:36:50', 1),
(8, 37, '2020-06-15 20:43:53', 1),
(9, 15, '2020-06-16 14:29:21', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dnevnik`
--
ALTER TABLE `dnevnik`
  ADD PRIMARY KEY (`dnevnik_id`,`korisnik_id`,`tip_radnje_id`),
  ADD KEY `fk_dnevnik_korisnik1_idx` (`korisnik_id`),
  ADD KEY `fk_dnevnik_tip_radnje1_idx` (`tip_radnje_id`);

--
-- Indexes for table `dokumentacija`
--
ALTER TABLE `dokumentacija`
  ADD PRIMARY KEY (`dokumentacija_id`);

--
-- Indexes for table `dokumenti_ureda`
--
ALTER TABLE `dokumenti_ureda`
  ADD PRIMARY KEY (`poštanski_ured_id`,`dokumentacija_id`),
  ADD KEY `fk_dokumenti_ureda_poštanski_ured1_idx` (`poštanski_ured_id`),
  ADD KEY `fk_dokumenti_ureda_dokumentacija1` (`dokumentacija_id`);

--
-- Indexes for table `država`
--
ALTER TABLE `država`
  ADD PRIMARY KEY (`država_id`),
  ADD UNIQUE KEY `ime_UNIQUE` (`ime`),
  ADD UNIQUE KEY `država_id_UNIQUE` (`država_id`);

--
-- Indexes for table `DZ4_korisnik`
--
ALTER TABLE `DZ4_korisnik`
  ADD PRIMARY KEY (`korisnik_id`),
  ADD UNIQUE KEY `korisnik_id_UNIQUE` (`korisnik_id`),
  ADD KEY `fk_korisnik_uloga_idx` (`uloga_id`);

--
-- Indexes for table `DZ4_popis`
--
ALTER TABLE `DZ4_popis`
  ADD PRIMARY KEY (`zapis_id`);

--
-- Indexes for table `DZ4_uloga`
--
ALTER TABLE `DZ4_uloga`
  ADD PRIMARY KEY (`uloga_id`),
  ADD UNIQUE KEY `uloga_id_UNIQUE` (`uloga_id`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`korisnik_id`),
  ADD UNIQUE KEY `korisnik_id_UNIQUE` (`korisnik_id`),
  ADD KEY `fk_korisnik_uloga_idx` (`uloga_id`),
  ADD KEY `fk_korisnik_vrsta_statusa1_idx` (`vrsta_statusa_id`);

--
-- Indexes for table `pošiljka`
--
ALTER TABLE `pošiljka`
  ADD PRIMARY KEY (`pošiljka_id`),
  ADD KEY `fk_pošiljka_postanski_ured1_idx` (`trenutni_ured_id`),
  ADD KEY `fk_pošiljka_postanski_ured2_idx` (`završni_ured_id`),
  ADD KEY `fk_pošiljka_korisnik1_idx` (`pošiljatelj`),
  ADD KEY `fk_pošiljka_korisnik2_idx` (`primatelj`),
  ADD KEY `fk_pošiljka_postanski_ured3_idx` (`sljedeći_ured_id`),
  ADD KEY `fk_pošiljka_postanski_ured4_idx` (`početni_ured_id`),
  ADD KEY `fk_pošiljka_račun1_idx` (`račun_id`);

--
-- Indexes for table `poštanski_ured`
--
ALTER TABLE `poštanski_ured`
  ADD PRIMARY KEY (`poštanski_ured_id`),
  ADD UNIQUE KEY `postanski_ured_id_UNIQUE` (`poštanski_ured_id`),
  ADD KEY `fk_postanski_ured_država1_idx` (`država_id`),
  ADD KEY `fk_postanski_ured_korisnik1_idx` (`moderator_id`);

--
-- Indexes for table `račun`
--
ALTER TABLE `račun`
  ADD PRIMARY KEY (`račun_id`),
  ADD KEY `fk_račun_korisnik1_idx` (`izdao`),
  ADD KEY `fk_račun_korisnik2_idx` (`primatelj_id`);

--
-- Indexes for table `tip_radnje`
--
ALTER TABLE `tip_radnje`
  ADD PRIMARY KEY (`tip_radnje_id`),
  ADD UNIQUE KEY `tip_id_UNIQUE` (`tip_radnje_id`);

--
-- Indexes for table `uloga`
--
ALTER TABLE `uloga`
  ADD PRIMARY KEY (`uloga_id`),
  ADD UNIQUE KEY `uloga_id_UNIQUE` (`uloga_id`);

--
-- Indexes for table `vrsta_statusa`
--
ALTER TABLE `vrsta_statusa`
  ADD PRIMARY KEY (`vrsta_statusa_id`);

--
-- Indexes for table `zahtjevi_izdavanje_računa`
--
ALTER TABLE `zahtjevi_izdavanje_računa`
  ADD PRIMARY KEY (`korisnik_id`,`pošiljka_id`),
  ADD KEY `fk_zahtjevi_izdavanje_računa_korisnik1_idx` (`korisnik_id`),
  ADD KEY `fk_zahtjevi_izdavanje_računa_pošiljka1_idx` (`pošiljka_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dnevnik`
--
ALTER TABLE `dnevnik`
  MODIFY `dnevnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `dokumentacija`
--
ALTER TABLE `dokumentacija`
  MODIFY `dokumentacija_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `država`
--
ALTER TABLE `država`
  MODIFY `država_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `DZ4_korisnik`
--
ALTER TABLE `DZ4_korisnik`
  MODIFY `korisnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `DZ4_popis`
--
ALTER TABLE `DZ4_popis`
  MODIFY `zapis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `DZ4_uloga`
--
ALTER TABLE `DZ4_uloga`
  MODIFY `uloga_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `korisnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `pošiljka`
--
ALTER TABLE `pošiljka`
  MODIFY `pošiljka_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `poštanski_ured`
--
ALTER TABLE `poštanski_ured`
  MODIFY `poštanski_ured_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `račun`
--
ALTER TABLE `račun`
  MODIFY `račun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `tip_radnje`
--
ALTER TABLE `tip_radnje`
  MODIFY `tip_radnje_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `uloga`
--
ALTER TABLE `uloga`
  MODIFY `uloga_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `vrsta_statusa`
--
ALTER TABLE `vrsta_statusa`
  MODIFY `vrsta_statusa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `dnevnik`
--
ALTER TABLE `dnevnik`
  ADD CONSTRAINT `fk_dnevnik_korisnik1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dnevnik_tip_radnje1` FOREIGN KEY (`tip_radnje_id`) REFERENCES `tip_radnje` (`tip_radnje_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dokumenti_ureda`
--
ALTER TABLE `dokumenti_ureda`
  ADD CONSTRAINT `fk_dokumenti_ureda_dokumentacija1` FOREIGN KEY (`dokumentacija_id`) REFERENCES `dokumentacija` (`dokumentacija_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dokumenti_ureda_poštanski_ured1` FOREIGN KEY (`poštanski_ured_id`) REFERENCES `poštanski_ured` (`poštanski_ured_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `fk_korisnik_uloga` FOREIGN KEY (`uloga_id`) REFERENCES `uloga` (`uloga_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_korisnik_vrsta_statusa1` FOREIGN KEY (`vrsta_statusa_id`) REFERENCES `vrsta_statusa` (`vrsta_statusa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pošiljka`
--
ALTER TABLE `pošiljka`
  ADD CONSTRAINT `fk_pošiljka_korisnik1` FOREIGN KEY (`pošiljatelj`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pošiljka_korisnik2` FOREIGN KEY (`primatelj`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pošiljka_postanski_ured1` FOREIGN KEY (`trenutni_ured_id`) REFERENCES `poštanski_ured` (`poštanski_ured_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pošiljka_postanski_ured2` FOREIGN KEY (`završni_ured_id`) REFERENCES `poštanski_ured` (`poštanski_ured_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pošiljka_postanski_ured3` FOREIGN KEY (`sljedeći_ured_id`) REFERENCES `poštanski_ured` (`poštanski_ured_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pošiljka_postanski_ured4` FOREIGN KEY (`početni_ured_id`) REFERENCES `poštanski_ured` (`poštanski_ured_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pošiljka_račun1` FOREIGN KEY (`račun_id`) REFERENCES `račun` (`račun_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poštanski_ured`
--
ALTER TABLE `poštanski_ured`
  ADD CONSTRAINT `fk_postanski_ured_država1` FOREIGN KEY (`država_id`) REFERENCES `država` (`država_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_postanski_ured_korisnik1` FOREIGN KEY (`moderator_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `račun`
--
ALTER TABLE `račun`
  ADD CONSTRAINT `fk_račun_korisnik1` FOREIGN KEY (`izdao`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_račun_korisnik2` FOREIGN KEY (`primatelj_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zahtjevi_izdavanje_računa`
--
ALTER TABLE `zahtjevi_izdavanje_računa`
  ADD CONSTRAINT `fk_zahtjevi_izdavanje_računa_korisnik1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_zahtjevi_izdavanje_računa_pošiljka1` FOREIGN KEY (`pošiljka_id`) REFERENCES `pošiljka` (`pošiljka_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
