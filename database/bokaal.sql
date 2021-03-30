-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 mrt 2021 om 11:12
-- Serverversie: 10.4.14-MariaDB
-- PHP-versie: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bokaal`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `active` varchar(300) NOT NULL,
  `fullname` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `profile_img` varchar(300) NOT NULL,
  `bio` varchar(300) NOT NULL,
  `location` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `btw` varchar(300) NOT NULL,
  `company` varchar(300) NOT NULL,
  `telephone` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `active`, `fullname`, `email`, `password`, `profile_img`, `bio`, `location`, `status`, `btw`, `company`, `telephone`) VALUES
(7, '', 'Jasper Peeters', 'peeters.jasper98@gmail.com', '$2y$10$8VsPW1sCW.QnmRiDHc2e3OnXOp4H8MxivldHv3iam0C1ZALXJZIze', '', '', '', 'buyer', '', '', 0),
(8, '', 'Jasper Peeters', 'r0695883@student.thomasmore.be', '$2y$10$GKL2Hj3Xf3An5.HOaO8aT..yBzgURqZ.8YVylZgObgdjmVXw1bmti', '', '', '', 'seller', 'BE9874226584', 'Thomas More', 468230089);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
