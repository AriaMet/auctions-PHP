-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2021 at 08:45 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auctions`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `auction_id` int(11) NOT NULL,
  `owner` int(11) NOT NULL COMMENT 'user id',
  `prod_serv_name` varchar(30) NOT NULL COMMENT 'τίτλος',
  `prod_serv_description` text DEFAULT NULL COMMENT 'περιγραφή',
  `start_datetime` datetime NOT NULL COMMENT 'ημ/νια ώρα έναρξης',
  `main_duration` time NOT NULL COMMENT 'χρόνος διάρκειας',
  `start_price` decimal(10,2) NOT NULL COMMENT 'αρχική τιμή',
  `price_step` decimal(10,2) DEFAULT NULL COMMENT 'βήμα τιμής',
  `allow_extensions` tinyint(1) NOT NULL COMMENT '0 ή 1 αν επιτρέπονται παρατάσεις',
  `max_extensions` int(11) DEFAULT NULL COMMENT 'μέγιστες παρατάσεις',
  `extension_duration` time DEFAULT NULL COMMENT 'χρόνος διάρκειας παράτασης',
  `crucial_time` time DEFAULT NULL COMMENT 'χρόνος ενεργοποίησης παράτασης',
  `type` int(11) NOT NULL COMMENT 'auction_types id',
  `last_extension` int(11) DEFAULT NULL COMMENT 'αριθμός παράτασης',
  `finished` tinyint(1) DEFAULT NULL COMMENT '0 ή 1 αν τελείωσε'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`auction_id`, `owner`, `prod_serv_name`, `prod_serv_description`, `start_datetime`, `main_duration`, `start_price`, `price_step`, `allow_extensions`, `max_extensions`, `extension_duration`, `crucial_time`, `type`, `last_extension`, `finished`) VALUES
(10, 12, 'Test', 'This is a test', '2021-02-26 17:58:00', '01:00:00', '250.00', '0.00', 0, 0, '00:10:00', '00:01:00', 1, 0, 1),
(12, 11, 'Test3', 'Another test', '2021-02-26 18:00:00', '05:00:00', '300.00', '0.00', 0, 0, '00:10:00', '00:01:00', 1, 0, 0),
(13, 10, 'Test4', 'One more test', '2021-02-26 19:43:00', '00:15:00', '50.00', '5.00', 1, 10, '00:05:00', '00:01:00', 1, 0, 1),
(14, 12, 'myTest', 'myTest', '2021-02-26 20:00:00', '00:02:00', '30.00', '5.00', 1, 2, '00:10:00', '00:02:00', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `auction_types`
--

CREATE TABLE `auction_types` (
  `a_type_id` int(11) NOT NULL,
  `a_type_descr` varchar(30) NOT NULL COMMENT 'περιγραφή του κάθε κωδικού (id) τύπου'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auction_types`
--

INSERT INTO `auction_types` (`a_type_id`, `a_type_descr`) VALUES
(1, 'Max. Price'),
(2, 'Min. Price');

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `bid_id` int(11) NOT NULL,
  `whoDoes` int(11) NOT NULL COMMENT 'το user id που αντιστοιχεί σε αυτόν/η που έκανε το bid',
  `auction` int(11) NOT NULL COMMENT 'auction id',
  `when_datetime` datetime NOT NULL COMMENT 'χρονική στιγμή που έγινε το bid',
  `amount` decimal(10,2) NOT NULL COMMENT 'το ποσό του bid',
  `status` int(11) NOT NULL COMMENT 'bid_status id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`bid_id`, `whoDoes`, `auction`, `when_datetime`, `amount`, `status`) VALUES
(72, 11, 10, '2021-02-26 17:58:55', '260.00', 0),
(73, 10, 10, '2021-02-26 17:59:08', '255.00', 1),
(74, 10, 10, '2021-02-26 17:59:12', '268.00', 0),
(75, 10, 12, '2021-02-26 17:59:21', '365.00', 2),
(76, 10, 12, '2021-02-26 19:42:09', '425.00', 0),
(77, 11, 13, '2021-02-26 19:43:38', '52.00', 1),
(78, 11, 13, '2021-02-26 19:43:41', '55.00', 0),
(79, 12, 13, '2021-02-26 19:43:57', '68.00', 1),
(80, 12, 13, '2021-02-26 19:44:02', '75.00', 0),
(81, 12, 13, '2021-02-26 19:58:31', '80.00', 2),
(82, 10, 14, '2021-02-26 20:00:54', '45.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bid_status`
--

CREATE TABLE `bid_status` (
  `b_status_id` int(11) NOT NULL,
  `b_status_descr` varchar(30) NOT NULL COMMENT 'περιγραφή του κάθε κωδικού (id) status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bid_status`
--

INSERT INTO `bid_status` (`b_status_id`, `b_status_descr`) VALUES
(0, 'Accepted'),
(1, 'Step violation'),
(2, 'Time violation'),
(3, 'Other violation');

-- --------------------------------------------------------

--
-- Table structure for table `knockdown`
--

CREATE TABLE `knockdown` (
  `bid_id` int(11) NOT NULL,
  `IsDelivered` tinyint(1) NOT NULL COMMENT '0 ή 1 αν είναι delivered',
  `IsPaidByBuyer` tinyint(1) NOT NULL COMMENT '0 ή 1 αν είναι paid by buyer',
  `IsPaidBySeller` tinyint(1) NOT NULL COMMENT '0 ή 1 αν είναι paid by seller',
  `ProviderFees` decimal(10,2) NOT NULL COMMENT 'αμοιβή παρόχου',
  `IsFeesPaid` tinyint(1) NOT NULL COMMENT '0 ή 1 αν πληρώθηκαν τα fees'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `knockdown`
--

INSERT INTO `knockdown` (`bid_id`, `IsDelivered`, `IsPaidByBuyer`, `IsPaidBySeller`, `ProviderFees`, `IsFeesPaid`) VALUES
(74, 0, 0, 0, '13.40', 0),
(80, 0, 0, 0, '3.75', 0),
(82, 0, 0, 0, '2.25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `providerormoderator`
--

CREATE TABLE `providerormoderator` (
  `pom_id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL COMMENT 'το email του provider/moderator',
  `username` varchar(30) NOT NULL COMMENT 'το username του provider/moderator',
  `password` char(40) NOT NULL COMMENT 'το password του provider/moderator',
  `isProvider` tinyint(1) NOT NULL COMMENT '0 αν δεν είναι ο provider ή 1 αν είναι ο provider',
  `isModerator` tinyint(1) NOT NULL COMMENT '0 αν δεν είναι ο moderator ή 1 αν είναι ο moderator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `providerormoderator`
--

INSERT INTO `providerormoderator` (`pom_id`, `email`, `username`, `password`, `isProvider`, `isModerator`) VALUES
(1, 'admin@admin.gr', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 0),
(2, 'mod@mod.gr', 'mod', '7dd30f0a95d522bfc058be4e75847f8b6df9f76b', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT 'status id',
  `email` varchar(30) NOT NULL COMMENT 'το email του user',
  `username` varchar(30) NOT NULL COMMENT 'το username του user',
  `password` char(40) NOT NULL COMMENT 'το password του user',
  `firstname` varchar(30) NOT NULL COMMENT 'το first name του user',
  `lastname` varchar(30) NOT NULL COMMENT 'το last name του user',
  `address` varchar(30) DEFAULT NULL COMMENT 'το address του user',
  `telephone` varchar(15) DEFAULT NULL COMMENT 'το telephone του user',
  `approval_pom` int(11) DEFAULT NULL COMMENT 'id του εγκρίνοντα Provider/Moderator',
  `approval_date` date DEFAULT NULL COMMENT 'ημ/νια έγκρισης'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `status`, `email`, `username`, `password`, `firstname`, `lastname`, `address`, `telephone`, `approval_pom`, `approval_date`) VALUES
(10, 3, 'amalda.viesta@gmail.com', 'amalda', '11735a185110c3d4507d11da6e8f2c09fa2f5c33', 'Amalda', 'Viesta', 'Dionysioy 35', '123456789', 1, '2021-02-09'),
(11, 3, 'ntountou19@hotmail.com', 'xristina', '861e2018805b36e075c7e9c32f32e3f0d822ebe3', 'Xristina', 'Ntountoulaki', 'Karaiskaki 8', '987654321', 1, '2021-02-09'),
(12, 3, 'ariadnim95@gmail.com', 'ariadni', '2cb6105cd919164f4c542389fdfbc6679031d552', 'Ariadni', 'Metaxa', 'Ermou 1', '690000000', 1, '2021-01-27'),
(17, 0, 'mar_pd@gmail.com', 'mariapd', 'a11ca7e2c2f1c032d9dade329d7c1ac512136368', 'Maria', 'Papadopoulou', 'Omonoias 13', '6999999999', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE `user_status` (
  `u_status_id` int(11) NOT NULL,
  `u_status_descr` varchar(30) DEFAULT NULL COMMENT 'περιγραφή του κάθε κωδικού (id) status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`u_status_id`, `u_status_descr`) VALUES
(0, 'Not activated'),
(1, 'Temporary deactivated'),
(2, 'Permanently deactivated'),
(3, 'Activated'),
(15, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`auction_id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auction_types`
--
ALTER TABLE `auction_types`
  ADD PRIMARY KEY (`a_type_id`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`bid_id`),
  ADD KEY `auction` (`auction`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `bid_status`
--
ALTER TABLE `bid_status`
  ADD PRIMARY KEY (`b_status_id`);

--
-- Indexes for table `knockdown`
--
ALTER TABLE `knockdown`
  ADD PRIMARY KEY (`bid_id`);

--
-- Indexes for table `providerormoderator`
--
ALTER TABLE `providerormoderator`
  ADD PRIMARY KEY (`pom_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `approval_pom` (`approval_pom`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`u_status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `auction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `knockdown`
--
ALTER TABLE `knockdown`
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `providerormoderator`
--
ALTER TABLE `providerormoderator`
  MODIFY `pom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `auctions_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `auctions_ibfk_2` FOREIGN KEY (`type`) REFERENCES `auction_types` (`a_type_id`);

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`auction_id`),
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`status`) REFERENCES `bid_status` (`b_status_id`);

--
-- Constraints for table `knockdown`
--
ALTER TABLE `knockdown`
  ADD CONSTRAINT `knockdown_ibfk_1` FOREIGN KEY (`bid_id`) REFERENCES `bids` (`bid_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`approval_pom`) REFERENCES `providerormoderator` (`pom_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`status`) REFERENCES `user_status` (`u_status_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
