-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 01 mei 2021 om 15:20
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
-- Tabelstructuur voor tabel `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `favorite_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `favorite_id`) VALUES
(1, 9, 8);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `description` varchar(300) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(300) NOT NULL,
  `price` int(11) NOT NULL,
  `currency` varchar(300) NOT NULL,
  `item_image` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `buyer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `address` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `btw` varchar(300) NOT NULL,
  `company` varchar(300) NOT NULL,
  `telephone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `active`, `fullname`, `email`, `password`, `profile_img`, `bio`, `location`, `address`, `status`, `btw`, `company`, `telephone`) VALUES
(7, '', 'Jasper Peeters', 'peeters.jasper98@gmail.com', '$2y$10$8VsPW1sCW.QnmRiDHc2e3OnXOp4H8MxivldHv3iam0C1ZALXJZIze', '1615808064011.jpg', 'Ik ben een koper', 'Wommelgem', 'Adolf Mortelmansstraat 74', 'buyer', '', '', '0'),
(8, '', 'Jasper Peeters', 'r0695883@student.thomasmore.be', '$2y$10$GKL2Hj3Xf3An5.HOaO8aT..yBzgURqZ.8YVylZgObgdjmVXw1bmti', '1615808064011.jpg', 'dit is mijn bio', 'Lier', 'Boomlaarstraat 118', 'seller', ' BE9885556', 'Thomas More', '0468230089'),
(9, '', 'Jasper Peeters', 'peeters.jasper@gmail.com', '$2y$10$z8PWAcpR5vkd1DHGo7sg5e9K2G5Z.k5Wuapre0r5yR6ReBbx/qXVa', '', '', 'Mechelen', 'Zandpoortvest 18', 'seller', 'BE98512218', 'Thomas More', '468230089'),
(10, '', 'Jasper Peeters', 'jasper@student.thomasmore.be', '$2y$10$cGhS8urqAu0yJi3vfC35HOdXxxQRe2LY/O4pJ.X/YhKEEZVRQGllm', '', '', 'Antwerpen', 'Lange Elzenstraat 465', 'buyer', '', '', '0');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
