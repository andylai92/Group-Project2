-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 10, 2023 at 09:19 PM
-- Server version: 10.6.11-MariaDB
-- PHP Version: 8.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `PROJECT`
--

-- --------------------------------------------------------

--
-- Table structure for table `CaseNum`
--

CREATE TABLE `CaseNum` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `case_num` int(11) NOT NULL DEFAULT 0,
  `death_num` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `CaseNum`
--

INSERT INTO `CaseNum` (`id`, `country_id`, `date`, `case_num`, `death_num`) VALUES
(1, 1, '2023-02-01', 500, 20),
(2, 1, '2023-01-01', 560, 30),
(3, 1, '2022-12-01', 600, 10),
(4, 1, '2022-11-01', 450, 20),
(5, 1, '2022-10-01', 150, 0),
(6, 1, '2022-09-01', 442, 15),
(7, 2, '2023-02-01', 733, 22),
(8, 2, '2023-01-01', 864, 19),
(9, 2, '2022-12-01', 577, 10),
(10, 2, '2022-11-01', 486, 17);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country_name` text NOT NULL,
  `country_population` int(11) NOT NULL,
  `caseNum_total` int(11) NOT NULL,
  `death_total` int(11) DEFAULT NULL,
  `vaccine_total` int(11) NOT NULL,
  `vaccine_booster` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`, `country_population`, `caseNum_total`, `death_total`, `vaccine_total`, `vaccine_booster`) VALUES
(1, 'China', 1439323776, 98747318, 87468, 1335692464, 1301148693),
(2, 'India', 1380004385, 44683862, 45345, 753769, 1753673),
(3, 'United States', 331002651, 101211478, 54354, 4577373, 7737373),
(4, 'France', 65273511, 38453595, 7537, 4753739, 7539337),
(5, 'Germany', 83783942, 37893892, 9567, 7573900, 456349),
(6, 'Brazil', 212559417, 36907890, 16596, 180246845, 152489637),
(7, 'Republic of Korea', 51383799, 30325483, 7589, 48627593, 45689321),
(8, 'Italy', 60461826, 25488166, 9555, 58457485, 54692327),
(9, 'Russia', 145934462, 22047525, 14586, 125473596, 115869332),
(10, 'Mexico', 128932753, 7390902, 13596, 107359638, 90056897),
(11, 'Japan', 126476461, 32879625, 11256, 114589653, 100458962);

-- --------------------------------------------------------

--
-- Table structure for table `infection`
--

CREATE TABLE `infection` (
  `Infection_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `virus_id` int(11) NOT NULL,
  `infection_percentage` double NOT NULL
  CHECK (infection_percentage>=0 AND infection_percentage<=100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `infection`
--

INSERT INTO `infection` (`Infection_id`, `country_id`, `virus_id`, `infection_percentage`) VALUES
(1, 1, 7, 5.8),
(2, 1, 10, 3.98),
(3, 1, 9, 39.68),
(4, 1, 8, 49.69),
(5, 1, 3, 0.19),
(6, 4, 9, 71.23),
(7, 4, 8, 10.22),
(8, 4, 10, 9.75),
(9, 4, 7, 6.65),
(10, 2, 7, 100);

-- --------------------------------------------------------

--
-- Table structure for table `restrictions`
--

CREATE TABLE `restrictions` (
  `restriction_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `entry_coutry_id` int(11) NOT NULL,
  `requirement_doseNum` int(11) DEFAULT NULL,
  `restriction_quarantine` int(11) DEFAULT NULL,
  `restriction_type` text NOT NULL
  CHECK(requirement_doseNum)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restrictions`
--

INSERT INTO `restrictions` (`restriction_id`, `country_id`, `entry_coutry_id`, `requirement_doseNum`, `restriction_quarantine`, `restriction_type`) VALUES
(1, 4, 1, NULL, NULL, 'Prohibited'),
(2, 2, 5, 2, NULL, 'Limited'),
(3, 11, 2, 1, NULL, 'Limited'),
(4, 10, 6, 1, NULL, 'Limited'),
(5, 8, 10, 3, NULL, 'Limited'),
(6, 1, 8, NULL, NULL, 'Prohibited'),
(7, 9, 1, NULL, NULL, 'Prohibited'),
(8, 6, 1, NULL, NULL, 'Prohibited'),
(9, 11, 4, NULL, NULL, 'Prohibited'),
(10, 1, 2, NULL, NULL, 'Prohibited');

-- --------------------------------------------------------

--
-- Table structure for table `travelplan`
--

CREATE TABLE `travelplan` (
  `TravelPlan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `TravelPlan_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travelplan`
--

INSERT INTO `travelplan` (`TravelPlan_id`, `user_id`, `country_id`, `TravelPlan_date`) VALUES
(1, 1, 8, '2023-06-25'),
(2, 2, 2, '2023-02-28'),
(3, 3, 6, '2023-08-16'),
(4, 4, 4, '2023-06-10'),
(5, 5, 3, '2023-07-18'),
(6, 6, 10, '2023-11-08'),
(7, 7, 6, '2023-09-30'),
(8, 8, 1, '2023-09-05'),
(9, 9, 5, '2023-04-20'),
(10, 10, 8, '2023-05-01'),
(11, 10, 1, '2023-03-10'),
(12, 10, 4, '2023-03-17'),
(13, 10, 5, '2023-03-09'),
(14, 8, 4, '2023-10-26'),
(15, 8, 5, '2023-03-10'),
(16, 9, 5, '2023-03-24'),
(17, 9, 1, '2023-03-30'),
(18, 10, 1, '2023-03-10'),
(19, 10, 1, '2023-03-30'),
(20, 10, 2, '2023-03-23'),
(21, 10, 11, '2023-03-29'),
(22, 10, 4, '2023-03-17'),
(23, 10, 4, '2023-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `user_country` int(11) DEFAULT NULL,
  `user_doseNum` int(11) NOT NULL DEFAULT 0,
  `user_email` text NOT NULL,
  `user_password` int(11) NOT NULL
  CHECK(user_doseNum>=0 AND user_country>=0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `user_country`, `user_doseNum`, `user_email`, `user_password`) VALUES
(1, 'Yihan', 'Ma', 1, 3, 'yihanm@gmail.com', 12345678),
(2, 'Jacky', 'Fong', 4, 2, 'jackyf@gmail.com', 12345678),
(3, 'Andy', 'Lai', 2, 0, 'andyl@gmail.com', 12345678),
(4, 'Codi', 'Chun', 11, 1, 'codic@gmail.com', 12345678),
(5, 'Raz', 'Consta', 5, 1, 'razc@gmail.com', 12345678),
(6, 'Damien ', 'Cruz', 6, 0, 'damienc@gmail.com', 12345678),
(7, 'Andrew', 'Dibble', 7, 3, 'andrewd@gmail.com', 12345678),
(8, 'Tommy', 'Diep', 8, 0, 'tommyd@gmail.com', 12345678),
(9, 'Lindsay', 'Ding', 9, 0, 'lindsayd@gmail.com', 12345678),
(10, 'Chloe', 'Duncan', 10, 2, 'chloed@gmail.com', 12345678);

-- --------------------------------------------------------

--
-- Table structure for table `viruses`
--

CREATE TABLE `viruses` (
  `virus_id` int(11) NOT NULL,
  `virus_name` text NOT NULL,
  `death_rate` double NOT NULL,
  `virus_detail` text DEFAULT NULL
  CHECK(death_rate>=0 AND death_rate<=100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `viruses`
--

INSERT INTO `viruses` (`virus_id`, `virus_name`, `death_rate`, `virus_detail`) VALUES
(1, 'Delta', 0.7, 'The Delta variant was a variant of SARS-CoV-2, the virus that causes COVID-19. It was first detected in India on 5 October 2020. The Delta variant was named on 31 May 2021 and had spread to over 179 countries by 22 November 2021.'),
(2, 'Original Omicron Variant', 0.4, 'Three doses of a COVID-19 vaccine provide protection against severe disease and hospitalisation caused by Omicron and its subvariants.For three-dose vaccinated individuals, the BA.4 and BA.5 variants are more infectious than previous subvariants but there is no evidence of greater sickness or severity'),
(3, 'Omicron (BA.2)', 0.31, ''),
(4, 'Alpha', 0.9, ''),
(5, 'Beta', 0.9, ''),
(6, 'Gamma', 0.5, ''),
(7, 'Omicron (BA.5)', 0.34, ''),
(8, 'Omicron (XBB)', 0.32, ''),
(9, 'Omicron (BQ.1)', 0.31, ''),
(10, 'Omicron (BA.2.75)', 0.32, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CaseNum`
--
ALTER TABLE `CaseNum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_case` (`country_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `infection`
--
ALTER TABLE `infection`
  ADD PRIMARY KEY (`Infection_id`),
  ADD KEY `country_infection` (`country_id`),
  ADD KEY `viruse_infection` (`virus_id`);

--
-- Indexes for table `restrictions`
--
ALTER TABLE `restrictions`
  ADD PRIMARY KEY (`restriction_id`),
  ADD KEY `country_restrictions` (`country_id`),
  ADD KEY `Ecountry_restrictions` (`entry_coutry_id`);

--
-- Indexes for table `travelplan`
--
ALTER TABLE `travelplan`
  ADD PRIMARY KEY (`TravelPlan_id`),
  ADD KEY `USER_TravelPlan` (`user_id`),
  ADD KEY `COUNTRY_TravelPlan` (`country_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `viruses`
--
ALTER TABLE `viruses`
  ADD PRIMARY KEY (`virus_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CaseNum`
--
ALTER TABLE `CaseNum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `travelplan`
--
ALTER TABLE `travelplan`
  MODIFY `TravelPlan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
-- 
-- All the constraints are ON DELET RESTRICT and ON UPDATE RESTRICT
-- It is what I setup and here is the script created by phpmyadmin
--
--

--
-- Constraints for table `CaseNum`
--
ALTER TABLE `CaseNum`
  ADD CONSTRAINT `country_case` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`);

--
-- Constraints for table `infection`
--
ALTER TABLE `infection`
  ADD CONSTRAINT `country_infection` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`),
  ADD CONSTRAINT `viruse_infection` FOREIGN KEY (`virus_id`) REFERENCES `viruses` (`virus_id`);

--
-- Constraints for table `restrictions`
--
ALTER TABLE `restrictions`
  ADD CONSTRAINT `Ecountry_restrictions` FOREIGN KEY (`entry_coutry_id`) REFERENCES `country` (`country_id`),
  ADD CONSTRAINT `country_restrictions` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`);

--
-- Constraints for table `travelplan`
--
ALTER TABLE `travelplan`
  ADD CONSTRAINT `COUNTRY_TravelPlan` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`),
  ADD CONSTRAINT `USER_TravelPlan` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

--
-- ***************************
--
-- Query 1
-- Purpose: get user information on name, destination, and date using selected email
-- Expected: a table containing details for the selected user’s name and destination country name, and the travel date
--
SELECT user.first_name AS "USER FIRST NAME", user.last_name AS "USER LAST NAME", country.country_name AS "DESTINATION", travelplan.TravelPlan_date AS "TRAVEL DATE"
FROM travelplan
JOIN user ON user.user_id = travelplan.user_id
JOIN country ON country.country_id = travelplan.country_id
WHERE user.user_id = (SELECT user_id 
                                       FROM user 
                                       WHERE user_email = "yihanm@gmail.com");
--
-- ***************************
--
-- Query2
-- Purpose: it will calculate the infection rate of countries that people plan to travel to
-- Expected: A list of countries and infection rates which related to travelplan table
--
SELECT country_name AS "COUNTRY",
caseNum_total / country_population * 100 AS "OVERALL INFECTION RATE",
death_total / caseNum_total * 100 AS "OVERALL DEATH RATE"
FROM country 
WHERE country_id IN (SELECT country_id FROM travelplan)
GROUP BY country_name;
--
-- ***************************
--
-- Query 3
-- Purpose: To show which virus and country which have it has a higher death rate than the -- average of all viruses
-- Expected: Those viruses whose death rate is higher than 0.49 and country which have it 
--
SELECT viruses.virus_name, viruses.death_rate, country.country_name
FROM viruses
JOIN infection ON infection.virus_id = viruses.virus_id
JOIN country ON country.country_id = infection.Infection_id
WHERE viruses.death_rate > (SELECT AVG(death_rate) FROM viruses);
--
-- ***************************
--
-- Query 4 
-- Purpose: Show the home country of the user 
-- Expected: A table containing details of the country of the user and the user's first name
--
SELECT country.country_name AS Home_Country, user.first_name AS Name
FROM country
LEFT OUTER JOIN user ON country.country_id = user.user_country
UNION
SELECT country.country_name, user.first_name
FROM user
RIGHT OUTER JOIN country ON country.country_id = user.user_country;
--
-- ***************************
--
-- Query 5 
-- Purpose: List all the countries that have no entry restrictions
-- Expected: Countries id are not in the restriction table’s country_id column
--
SELECT country_name
FROM country
WHERE country_id IN
(SELECT country_id FROM travelplan
EXCEPT
SELECT country_id FROM restrictions);
--
-- ***************************
--
-- Query 6     Kemeria  (the corrected one)
-- Purpose: To get the information of each person's travel plan.
-- Expected: User first name and number of travel plans.
--
SELECT u.First_name, COUNT(t.user_id) AS "Total Travel Plan"
FROM user u, travelplan t
WHERE u.user_id = t.user_id 
GROUP by u.First_name;
--
-- *********************************************
--
-- Query 7 
-- Purpose: To find the user who will travel within 48 hours, return their emails.
-- Expected: We are looking for the users and inform them to do COVID-test if they needed to do.
--
SELECT user.user_email, travelplan.TravelPlan_date
FROM travelplan, user
WHERE user.user_id = travelplan.user_id
AND DATEDIFF(TravelPlan_date, CURRENT_TIMESTAMP()) <= 2;
--
-- ***************************
--
-- Query 8 
-- Purpose: To get the countries and the viruses that are spreading if the infection percentage is higher than a certain amount
-- Expected: A table of the country names, the virus name, infection percentage
--
SELECT country.country_name AS Countries, viruses.virus_name AS Viruses, infection.infection_percentage AS "Infection Percentage"
FROM country, viruses, infection
WHERE country.country_id = infection.country_id
AND viruses.virus_id = infection.virus_id
AND infection.infection_percentage > 10;
--
-- ***************************
--
-- SQL Query9 
-- Purpose: show all the covid variants and their infected percentage in the country one user -- wants to go to.
-- Expected: all the covid variants and infected percentage of US, which user 5 add to the travel plan in desc order.
--
SELECT viruses.virus_name, country.country_name, infection.infection_percentage
FROM infection
JOIN viruses ON viruses.virus_id = infection.virus_id
JOIN travelplan ON travelplan.country_id = infection.country_id
JOIN country ON country.country_id = travelplan.country_id
WHERE travelplan.user_id = 8 
ORDER BY country.country_name DESC;
--
-- ***************************
--
-- Query 10
-- Purpose: To get the dose number of users to compare with the requirement of the country -- traveling to. If they did not fulfill the requirement, they would get alerted.
-- Expected: To show the list of who has not to fulfill the requirement of the country traveling -- to.
--
SELECT
    `user`.`first_name` AS user_first_name,
    `travelplan`.`country_id` AS ID_country,
    `user`.`user_doseNum` AS users_number_of_dose, 
    `restrictions`.`requirement_doseNum` AS required_dose_number
FROM `user`
JOIN `travelplan` ON `travelplan`.`user_id` = `user`.`user_id`
JOIN `country` ON `country`.`country_id` = `travelplan`.`country_id`
JOIN `restrictions` ON `travelplan`.`country_id` = `restrictions`.`country_id`
WHERE `user`.`user_doseNum` < `restrictions`.`requirement_doseNum`;
--
-- ***************************
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;