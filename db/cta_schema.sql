-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 09:33 AM
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
-- Database: `cta_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminaccount`
--

CREATE TABLE `adminaccount` (
  `admin_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `first_name` char(50) NOT NULL,
  `surname` char(50) NOT NULL,
  `email_address` char(100) NOT NULL,
  `admin_password` char(200) NOT NULL,
  `date_of_birth` char(20) NOT NULL,
  `hiring_date` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminaccount`
--

INSERT INTO `adminaccount` (`admin_id`, `type_id`, `first_name`, `surname`, `email_address`, `admin_password`, `date_of_birth`, `hiring_date`) VALUES
(1, 2, 'Tom', 'Evans', 'Evans@example.com', 'example123', '12/09/1990', '12/12/2012'),
(2, 3, 'Natalie', 'Brown', 'Brown@example.com', 'example123', '21/09/1970', '23/01/2024'),
(3, 4, 'Sarah', 'Fish', 'Fish@example.com', 'example123', '10/11/2001', '20/04/2023');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_id` char(3) NOT NULL,
  `currency_name` char(30) NOT NULL,
  `currency_sign` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_id`, `currency_name`, `currency_sign`) VALUES
('AUD', 'Australian Dollar', '$'),
('CAD', 'Canadian Dollar', '$'),
('CHF', 'Swiss Franc', 'Fr'),
('EUR', 'Euro', '€'),
('GBP', 'Great British Pound', '£'),
('HKD', 'Hong Kong Dollar', '$'),
('INR', 'Indian Rupee', '₹'),
('JPY', 'Japanese Yen', '¥'),
('KRW', 'South Korean Won', '₩'),
('MXN', 'Mexican Peso', '$'),
('NOK', 'Norwegian Krone', 'kr'),
('NZD', 'New Zealand Dollar', '$'),
('SEK', 'Swedish Krona', 'kr'),
('SGD', 'Singapore Dollar', '$'),
('TRY', 'Turkish Lira', '₺'),
('USD', 'American Dollar', '$');

-- --------------------------------------------------------

--
-- Table structure for table `currencywallet`
--

CREATE TABLE `currencywallet` (
  `wallets_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `currency_id` char(3) NOT NULL,
  `amount` float DEFAULT NULL,
  `amountLimit` float DEFAULT 1000000,
  `frozen` char(10) NOT NULL DEFAULT 'False',
  `proof` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currencywallet`
--

INSERT INTO `currencywallet` (`wallets_id`, `customer_id`, `currency_id`, `amount`, `amountLimit`, `frozen`, `proof`) VALUES
(1, 7, 'GBP', 100, 1000000, 'False', NULL),
(2, 8, 'GBP', 100, 1000000, 'False', NULL),
(32, 8, 'USD', 10, 1000000, 'True', 0x7573657255706c6f6164732f4354412d4552442e64726177696f202831292e706e67),
(33, 8, 'CAD', 100, 1000000, 'True', NULL),
(34, 9, 'GBP', 50, 1000000, 'False', NULL),
(37, 12, 'GBP', 1000, 1000000, 'False', 0x7573657255706c6f6164732f466978312e706e67),
(47, 12, 'EUR', 141.77, 1000000, 'False', NULL),
(50, 9, 'EUR', 0, 1000000, 'False', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customeraccounts`
--

CREATE TABLE `customeraccounts` (
  `customer_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT 1,
  `first_name` char(50) NOT NULL,
  `middle_name` char(50) DEFAULT NULL,
  `last_name` char(50) NOT NULL,
  `email_address` char(100) NOT NULL,
  `password` char(200) NOT NULL,
  `dob` char(20) NOT NULL,
  `suspension` char(10) NOT NULL DEFAULT 'False'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customeraccounts`
--

INSERT INTO `customeraccounts` (`customer_id`, `type_id`, `first_name`, `middle_name`, `last_name`, `email_address`, `password`, `dob`, `suspension`) VALUES
(7, 1, 'Maddy', '', 'Gibson', 'Gibson@example.com', '$2y$10$Up6rxn/PkKKX5Kbd33hZR.QCCC1rP.xASNUoGiHY4JZlfP.hr9kb2', '2024-04-25', 'False'),
(8, 1, 'June', 'Z', 'Terry', 'Terry@example.com', '$2y$10$q6DmgUHgxhFJxi8oiF7ozO7Zj1.pRCC0j5yntd8w2LuOzOlJn1IuO', '2024-04-01', 'True'),
(9, 1, 'Maisie', '', 'Payne', 'Payne@example.com', '$2y$10$nm/4sEze8BNyu82h.Njzp.cBQWEYzkehTNNCQxB.kJgASzGC.O3US', '2024-12-01', 'False'),
(12, 1, 'Ryan', 'Tom', 'Turner', 'Turner@example.com', '$2y$10$Avp5wRXzWNKDPXvsmg6WFupvRzpSisOuvbCsJYZlqx8xeoWgXwn3.', '2024-04-04', 'False');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactions_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `recipient_name` char(100) DEFAULT NULL,
  `name_on_card` char(50) NOT NULL,
  `acc_number` char(20) DEFAULT NULL,
  `sort_code` char(20) DEFAULT NULL,
  `expiry_date` char(20) NOT NULL,
  `iban_number` char(50) DEFAULT NULL,
  `bic_code` char(20) NOT NULL,
  `wallet_id` int(11) DEFAULT NULL,
  `amount_sent` float NOT NULL,
  `reference` text NOT NULL,
  `transfer_date` char(20) NOT NULL,
  `recipt` text DEFAULT NULL,
  `flagged` char(10) NOT NULL DEFAULT 'False'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactions_id`, `customer_id`, `recipient_name`, `name_on_card`, `acc_number`, `sort_code`, `expiry_date`, `iban_number`, `bic_code`, `wallet_id`, `amount_sent`, `reference`, `transfer_date`, `recipt`, `flagged`) VALUES
(6, 12, NULL, 'T Evans', '1234567890123456', '123', '12/12', NULL, '', NULL, 500, '', '2024/04/24', NULL, 'False');

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE `usertypes` (
  `type_id` int(11) NOT NULL,
  `type_name` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`type_id`, `type_name`) VALUES
(1, 'Customer'),
(2, 'System Admin'),
(3, 'Financial Admin'),
(4, 'Legal Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminaccount`
--
ALTER TABLE `adminaccount`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `currencywallet`
--
ALTER TABLE `currencywallet`
  ADD PRIMARY KEY (`wallets_id`),
  ADD KEY `currencywallet_ibfk_1` (`customer_id`),
  ADD KEY `currencywallet_ibfk_2` (`currency_id`);

--
-- Indexes for table `customeraccounts`
--
ALTER TABLE `customeraccounts`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactions_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `wallet_id` (`wallet_id`);

--
-- Indexes for table `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminaccount`
--
ALTER TABLE `adminaccount`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currencywallet`
--
ALTER TABLE `currencywallet`
  MODIFY `wallets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `customeraccounts`
--
ALTER TABLE `customeraccounts`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `usertypes`
--
ALTER TABLE `usertypes`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adminaccount`
--
ALTER TABLE `adminaccount`
  ADD CONSTRAINT `adminaccount_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `usertypes` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `currencywallet`
--
ALTER TABLE `currencywallet`
  ADD CONSTRAINT `currencywallet_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `currencywallet_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `customeraccounts` (`customer_id`);

--
-- Constraints for table `customeraccounts`
--
ALTER TABLE `customeraccounts`
  ADD CONSTRAINT `customeraccounts_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `usertypes` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customeraccounts` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`wallet_id`) REFERENCES `currencywallet` (`wallets_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
