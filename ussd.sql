-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2016 at 12:17 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ussd`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_hostels`
--

CREATE TABLE `available_hostels` (
  `block_a` varchar(5) NOT NULL,
  `block_b` varchar(5) NOT NULL,
  `block_c` varchar(5) NOT NULL,
  `mt_kenya` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `available_hostels`
--

INSERT INTO `available_hostels` (`block_a`, `block_b`, `block_c`, `mt_kenya`) VALUES
('A002', 'B002', 'C002', 'MK002'),
('A003', 'B003', 'C003', 'MK003'),
('A004', 'B004', 'C004', 'MK004'),
('A005', 'B005', 'C005', 'MK005'),
('A006', 'B006', 'C006', 'MK006'),
('A007', 'B007', 'C007', 'MK007'),
('A008', 'B008', 'C008', 'MK008'),
('A009', 'B009', 'C009', 'MK009'),
('A010', 'B010', 'C010', 'MK010'),
('A011', 'B011', 'C011', 'MK011');

-- --------------------------------------------------------

--
-- Table structure for table `book_hostel`
--

CREATE TABLE `book_hostel` (
  `Name` varchar(30) NOT NULL,
  `RegNo` varchar(15) NOT NULL,
  `room` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `RegNo` varchar(15) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Sex` varchar(1) NOT NULL,
  `Course` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`RegNo`, `Name`, `Sex`, `Course`) VALUES
('CS591-0109/2012', 'PAL NDIITHI', 'M', 'Bachelor of IT'),
('CS591-0110/2012', 'LENAH WAZOME', 'F', 'Bachelor of Science(food scien'),
('CS591-0111/2012', 'LUKE SHAW', 'F', 'Bachelor of Commerce'),
('CS591-0112/2012', 'DANIEL CRAYFORD', 'M', 'Bachelor of Business managemen'),
('CS591-0108/2012', 'EPHRAIM WAITHAKA', 'M', 'Bachelor of Computer Science'),
('CS591-0113/2012', 'HAROLD FINCH', 'M', 'Bachelor of Computer Science'),
('CS591-0115/2012', 'GRACE KEM', 'F', 'Diploma in Civil Engineering'),
('CS591-0116/2012', 'PENINAH KIRIGO', 'F', 'Bachelor of Purchases and Supp'),
('CS591-0117/2012', 'NANCY W', 'F', 'Bachelor of Statistics'),
('CS591-0118/2012', 'WILFRED MWANGI', 'M', 'Bachelor of Science(General)'),
('CS591-0119/2012', 'JIN CANVIEL', 'M', 'Bachelor of Computer Science'),
('CS591-0120/2012', 'BEN CARSON', 'M', 'Bachelor of Commerce'),
('CS591-0121/2012', 'GLADYS MBUTHIA', 'F', 'Bachelor of Purchases and Supp'),
('CS591-0122/2012', 'LOISE MAINA', 'F', 'Bachelor of Mathematics and Co');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
