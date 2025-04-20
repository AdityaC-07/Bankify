-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 05:56 PM
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
-- Database: `bankify`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackid` int(11) NOT NULL,
  `message` varchar(111) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackid`, `message`, `userid`, `date`) VALUES
(10, 'hii \r\n', 57, '2023-01-02 05:31:43'),
(11, 'hii \r\n', 57, '2023-01-02 05:31:58'),
(12, 'hiiiii', 58, '2023-02-06 21:50:46'),
(13, 'hii', 61, '2025-04-19 05:15:19');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'cashier',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `password`, `type`, `date`) VALUES
(4, 'cashier0@gmail.com', '123', 'cashier', '2025-04-19 05:04:35');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'manager',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `email`, `password`, `type`, `date`) VALUES
(2, 'manager3@gmail.com', 'manager123', 'manager', '2025-04-18 13:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `notice` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otheraccounts`
--

CREATE TABLE `otheraccounts` (
  `id` int(11) NOT NULL,
  `accountno` varchar(11) NOT NULL,
  `bankname` varchar(11) NOT NULL,
  `holdername` varchar(11) NOT NULL,
  `balance` varchar(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transactionId` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `credit` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `debit` varchar(50) NOT NULL,
  `balance` varchar(50) NOT NULL,
  `beneld` varchar(50) NOT NULL,
  `other` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionId`, `action`, `credit`, `debit`, `balance`, `beneld`, `other`, `userid`, `date`) VALUES
(1, 'transfer', '', '2000', '', '', '1667924704', 52, '2022-11-08 16:26:17'),
(2, 'transfer', '', '5500', '', '', '1667924704', 52, '2022-11-08 16:50:56'),
(3, 'transfer', '', '5000', '', '', '1667924704', 52, '2022-11-08 16:58:58'),
(4, 'transfer', '', '500', '', '', '1667924704', 52, '2022-11-08 16:59:35'),
(5, 'transfer', '', '400', '', '', '1667924704', 52, '2022-11-08 17:00:06'),
(6, 'transfer', '', '3000', '', '', '1667924704', 52, '2022-11-08 17:09:59'),
(7, 'transfer', '', '3600', '', '', '1667924704', 52, '2022-11-08 17:10:32'),
(8, 'transfer', '', '3000', '', '', '1667924704', 53, '2022-11-08 17:33:36'),
(9, 'transfer', '', '3000', '', '', '1667489276', 53, '2022-11-08 17:35:14'),
(10, 'transfer', '', '3000', '', '', '1667966401', 54, '2022-11-09 04:02:01'),
(11, 'transfer', '', '3000', '', '', '1667966401', 55, '2022-11-09 04:05:01'),
(12, 'transfer', '', '5000', '', '', '1667966401', 55, '2022-11-09 04:06:00'),
(13, 'transfer', '', '5000', '', '', '1667966167', 55, '2022-11-09 04:11:17'),
(14, 'transfer', '', '3000', '', '', '1667966401', 54, '2022-11-09 04:17:45'),
(15, 'transfer', '', '4000', '', '', '1667966167', 55, '2022-11-09 04:19:09'),
(16, 'transfer', '', '5000', '', '', '1667966167', 54, '2022-11-09 04:19:44'),
(17, 'transfer', '', '3000', '', '', '1667966167', 54, '2022-11-09 04:20:09'),
(18, 'transfer', '', '6000', '', '', '1667966401', 54, '2022-11-09 04:36:25'),
(19, 'transfer', '', '3000', '', '', '1667966167', 55, '2022-11-09 04:50:11'),
(20, 'transfer', '', '3000', '', '', '1667971493', 55, '2022-11-09 05:27:38'),
(21, 'transfer', '', '5000', '', '', '1667966401', 56, '2022-11-09 14:24:07'),
(22, 'withdraw', '', '3000', '', '', '1', 0, '2022-11-09 15:50:04'),
(23, 'withdraw', '', '3000', '', '', '1', 0, '2022-11-09 15:50:44'),
(24, 'withdraw', '', '3000', '', '', '1', 0, '2022-11-09 15:51:25'),
(25, 'withdraw', '', '3000', '', '', '1', 0, '2022-11-09 15:51:36'),
(26, 'withdraw', '', '-4031', '', '', '1', 0, '2022-11-09 15:52:48'),
(27, 'withdraw', '', '-4031', '', '', '1', 0, '2022-11-09 15:53:14'),
(28, 'withdraw', '', '-4031', '', '', '1', 0, '2022-11-09 15:53:16'),
(29, 'withdraw', '', '500', '', '', '1', 55, '2022-11-09 15:53:25'),
(30, 'withdraw', '', '593', '', '', '15', 55, '2022-11-09 15:53:55'),
(31, 'withdraw', '', '2000', '', '', '1', 55, '2022-11-09 15:54:48'),
(32, 'deposit', '5000', '', '', '', '2', 55, '2022-11-09 15:56:33'),
(33, 'withdraw', '', '2500', '', '', '1', 55, '2022-11-09 15:58:29'),
(34, 'withdraw', '', '25', '', '', '1', 55, '2022-11-09 15:58:49'),
(35, 'withdraw', '', '7475', '', '', '', 55, '2022-11-09 16:00:46'),
(36, 'withdraw', '', '7475', '', '', '', 55, '2022-11-09 16:05:21'),
(37, 'withdraw', '', '7475', '', '', '', 55, '2022-11-09 16:06:35'),
(38, 'withdraw', '', '7475', '', '', '', 55, '2022-11-09 16:06:49'),
(39, 'deposit', '1', '', '', '', '1', 55, '2022-11-09 16:08:50'),
(40, 'withdraw', '', '3000', '', '', '1', 55, '2022-11-09 16:11:14'),
(41, 'deposit', '5000', '', '', '', '1', 55, '2022-11-09 16:29:33'),
(42, 'withdraw', '', '5000', '', '', '1', 55, '2022-11-09 16:34:15'),
(43, 'deposit', '5000', '', '', '', '1', 55, '2022-11-09 16:43:09'),
(44, 'deposit', '5000', '', '', '', '1', 55, '2022-11-09 16:43:39'),
(45, 'withdraw', '', '3000', '', '', '1', 55, '2022-11-09 16:43:52'),
(46, 'withdraw', '', '3000', '', '', '1', 55, '2022-11-09 16:44:04'),
(47, 'withdraw', '', '3000', '', '', '1', 55, '2022-11-09 16:46:49'),
(48, 'transfer', '', '5000', '', '', '1668057431', 57, '2023-01-02 05:34:29'),
(49, 'transfer', '', '5000', '', '', '1668057431', 57, '2023-02-06 21:49:02'),
(50, 'transfer', '', '4000', '', '', '1668057431', 57, '2023-02-06 21:49:51'),
(51, 'withdraw', '', '4000', '', '', '2', 59, '2023-03-18 14:41:04'),
(52, 'withdraw', '', '5000', '', '', '43434', 60, '2025-04-18 13:46:44'),
(53, 'transfer', '', '5000', '', '', '1744983028', 61, '2025-04-19 05:14:44'),
(54, 'deposit', '5000', '', '', '', '500', 61, '2025-04-19 14:02:38'),
(55, 'transfer', '', '3000', '', '', '1744983028', 61, '2025-04-20 15:14:44'),
(56, 'deposit', '3000', '', '', '', '555', 61, '2025-04-20 15:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

CREATE TABLE `useraccounts` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `aadhaar` varchar(15) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `profile` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `accountno` int(30) NOT NULL,
  `accounttype` varchar(10) NOT NULL,
  `deposit` int(10) NOT NULL,
  `branch` varchar(10) NOT NULL,
  `occupation` varchar(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `useraccounts`
--

INSERT INTO `useraccounts` (`id`, `name`, `aadhaar`, `gender`, `email`, `phonenumber`, `city`, `address`, `password`, `profile`, `dob`, `accountno`, `accounttype`, `deposit`, `branch`, `occupation`, `time`) VALUES
(60, 'Adit', '453612345678', 'Male', 'adit123@gmail.com', '5770840294', 'Mumbai', 'Kandivali East', 'adit123', 'Screenshot 2025-04-18 190908.png', '2004-02-02', 1744983028, 'Saving', 23000, '', 'Doctor', '2025-04-20 15:14:44'),
(61, 'Ram', '999912127810', 'Male', 'ram1231@gmail.com', '4520981871', 'Jaipur', 'Near Khandela Haveli', 'ram123', 'Screenshot 2025-04-18 190908.png', '1999-08-08', 1745037119, 'Saving', 50000, '', 'IT engineer', '2025-04-20 15:36:27'),
(62, 'Riya', '134528015723', 'Female', 'riya122@gmail.com', '8870321876', 'Kolkata ', 'Near Victoria Memorial', 'riya123', 'Screenshot 2025-04-18 190908.png', '1997-05-12', 1745047913, 'Saving', 8000, '', 'Developer', '2025-04-19 07:33:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackid`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otheraccounts`
--
ALTER TABLE `otheraccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transactionId`);

--
-- Indexes for table `useraccounts`
--
ALTER TABLE `useraccounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `otheraccounts`
--
ALTER TABLE `otheraccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `useraccounts`
--
ALTER TABLE `useraccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
