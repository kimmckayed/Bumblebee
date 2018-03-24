-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2018 at 02:03 AM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cartow`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `companies_check` ()  BEGIN

DECLARE currentCompany_id INT;  
DECLARE  currentCompany_name VARCHAR(255);
Declare company_state text;
Declare company_needFix boolean;

Declare count INT;

DECLARE done INT DEFAULT FALSE;
DECLARE cur1 CURSOR FOR select id from company_accounts where id != 6;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

OPEN cur1;   
  read_loop: LOOP
    FETCH cur1 INTO currentCompany_id;
    IF done THEN
      LEAVE read_loop;
    END IF;
select  name from company_accounts where id=currentCompany_id into currentCompany_name;
	set company_state = '';
    set company_needFix = false;
    
    IF count = 0 THEN
		INSERT INTO company_payment_method (company_id,payment_method_id) values(currentCompany_id,1);
	  set company_state = CONCAT(company_state, 'payment_methods: company has no payment methods. ');
      set company_needFix = true;    
    ELSEIf count > 1 then    
	  set company_state = CONCAT(company_state, 'payment_methods: company has '+ count + ' payment methods. ');
    set company_needFix = true;
    END IF;
     SELECT count(id) FROM `agent_accounts` INNER join role_users on agent_accounts.user_id = role_users.user_id WHERE company_id=currentCompany_id and role_users.role_id = '9' into count;
	IF count = 0 THEN
	   
	  set company_state = CONCAT(company_state, 'Master Accounts: company has no master account. ');
    set company_needFix = true;
    END IF;
    IF company_needFix Then
		insert into companyState values(currentCompany_id,currentCompany_name,company_state);
    END IF;
  END LOOP;

CLOSE cur1;
	select * from companyState;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `_Navicat_Temp_Stored_Proc` ()  CREATE TEMPORARY TABLE  IF Not EXISTS companyState(company_id int(11),company_name VARCHAR(255) , state text)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activations`
--

CREATE TABLE `activations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 10, 'KPG1OFr0FZA4r9hDze4swpiy5B8sijIj', 1, '2015-08-19 09:52:37', '2015-08-19 09:52:37', '2015-08-19 09:52:37'),
(2, 10, 'EFvIty7da0llguHyGmIWJmmNGiEmh8mY', 1, '2015-08-19 10:06:28', '2015-08-19 10:06:28', '2015-08-19 10:06:28'),
(3, 49, 'GkFJ3m3TfuoSVQMFCtOPANUHXLfvvREf', 1, '2015-08-19 10:09:13', '2015-08-19 10:09:13', '2015-08-19 10:09:13'),
(4, 45, 'CNBfggKFrTVCsbQSC5OWkIuN7KpKsTwl', 1, '2015-08-19 15:01:32', '2015-08-19 15:01:32', '2015-08-19 15:01:32'),
(5, 51, 'HMCoV74EAWwEfOMaOUx5iGED1gPi5WeW', 1, '2015-08-19 15:14:18', '2015-08-19 15:14:18', '2015-08-19 15:14:18'),
(6, 55, '7Akm2wr88eSwpF4AY7gnMdCSMoNVwYrz', 1, '2015-08-25 15:08:05', '2015-08-25 15:08:05', '2015-08-25 15:08:05'),
(7, 56, 'JfocYUEBTT0lGBzapfKI8J3d2nNt2v5U', 1, '2015-08-25 15:09:04', '2015-08-25 15:09:04', '2015-08-25 15:09:04'),
(8, 58, 'VIGTXJ2BbMkHnLnQ6GXxCGIdx8dIYj2c', 1, '2015-08-25 16:18:38', '2015-08-25 16:18:38', '2015-08-25 16:18:38'),
(9, 59, '6E2gW9uLlQb4rT4fO7WMZhqzr7sWpEyK', 1, '2015-08-25 16:23:45', '2015-08-25 16:23:45', '2015-08-25 16:23:45'),
(10, 60, 'VutACOdYwdqkotqT1YY9eQod48IHVOQ2', 1, '2015-08-26 09:06:23', '2015-08-26 09:06:23', '2015-08-26 09:06:23'),
(11, 61, 'zBaqxvB4Thd67LmzPpcW640tWRWGFQzV', 1, '2015-08-26 09:11:13', '2015-08-26 09:11:13', '2015-08-26 09:11:13'),
(12, 62, '9DybZtswNyxa7L2EXkqBCfQSv93MJBLA', 1, '2015-08-26 09:14:41', '2015-08-26 09:14:41', '2015-08-26 09:14:41'),
(13, 63, 'PWENXeYxsNChXh17mEUk6Ss2fdblQT4I', 1, '2015-08-26 09:18:51', '2015-08-26 09:18:51', '2015-08-26 09:18:51'),
(14, 64, '1Ez3ex1wp1uOgGeAXKOO86PaDAEHLK1H', 1, '2015-08-26 09:20:25', '2015-08-26 09:20:25', '2015-08-26 09:20:25'),
(15, 65, 'cJXyhjtyOf5WTV9kIFdCDtelKtHzDlLI', 1, '2015-08-26 09:57:28', '2015-08-26 09:57:27', '2015-08-26 09:57:28'),
(16, 66, 'OUTU5Knmuo7Zp67wPnOcGqfD9gGS0glE', 1, '2015-08-26 09:58:51', '2015-08-26 09:58:51', '2015-08-26 09:58:51'),
(17, 67, '1cjajrxXTgfsY4pJr0P7FUbvjP33oHeb', 1, '2015-08-26 11:51:00', '2015-08-26 11:50:59', '2015-08-26 11:51:00'),
(18, 68, 'qZhZqXTfcwlHaZvZEhXjbLcKZQFg3Zkt', 1, '2015-08-26 11:51:45', '2015-08-26 11:51:44', '2015-08-26 11:51:45'),
(19, 69, '4eFJimCsqOsZDhS5PKj5tSbXe1YBi99y', 1, '2015-08-26 13:30:01', '2015-08-26 13:30:01', '2015-08-26 13:30:01'),
(20, 70, '4LLZDMIgeGIfYgNvJkTdySeWSDNFcmQi', 1, '2015-08-26 13:30:54', '2015-08-26 13:30:54', '2015-08-26 13:30:54'),
(21, 71, 'UbTdmwYUhHbwHDnofqQQuL9XB44M3JH8', 1, '2015-08-26 13:31:38', '2015-08-26 13:31:38', '2015-08-26 13:31:38'),
(22, 72, 'DOZ5ssBgZcRFTywYRRfm5hKTOWeFKoX4', 1, '2015-08-26 13:31:56', '2015-08-26 13:31:56', '2015-08-26 13:31:56'),
(23, 73, 'RxsFXZ9dqizWmwg6t1688NpP4DpNeoAB', 1, '2015-08-26 13:32:54', '2015-08-26 13:32:54', '2015-08-26 13:32:54'),
(24, 74, 'lqbPe0qWMA9dObqGhGn6e1sNjLS0kwCw', 1, '2015-08-26 13:36:19', '2015-08-26 13:36:19', '2015-08-26 13:36:19'),
(25, 75, 'PigKabmwErW0OoGvgX9iQshrw3fa4DcH', 1, '2015-08-26 13:38:58', '2015-08-26 13:38:58', '2015-08-26 13:38:58'),
(26, 76, '4haaM8w1sbMB1egnIeEQ6GtKvL1R2qX0', 1, '2015-08-26 13:42:37', '2015-08-26 13:42:36', '2015-08-26 13:42:37'),
(27, 77, 'Q8z2meNSakoNYWlapfH5DntnQxB3FXWZ', 1, '2015-08-26 15:16:20', '2015-08-26 15:16:20', '2015-08-26 15:16:20'),
(28, 78, 'djyozQDIHYivdlHdSwXjRsmMmCzYIlQ0', 1, '2015-08-26 18:08:47', '2015-08-26 18:08:47', '2015-08-26 18:08:47'),
(29, 79, 'v4cDPsjPSF8ROYqXXAbmoa5lqTh1ra2B', 1, '2015-08-26 18:20:56', '2015-08-26 18:20:56', '2015-08-26 18:20:56'),
(30, 80, 'onrTWKFRQjrm9J6QDqWJJ4VwBnTGipP5', 1, '2015-08-26 19:02:50', '2015-08-26 19:02:50', '2015-08-26 19:02:50'),
(31, 81, 'Bh2bozpS1qAA3ItFalgAF6Hr5xNAOwZ3', 1, '2015-08-26 19:42:10', '2015-08-26 19:42:10', '2015-08-26 19:42:10'),
(32, 82, 'BZpmqPpWaifKPo9WdxnSwR6tvVkwaPNc', 1, '2015-08-26 19:44:48', '2015-08-26 19:44:48', '2015-08-26 19:44:48'),
(33, 83, 'wf5YC5dcbaArDzre3dbCw8jvmAsu7oh7', 1, '2015-08-26 20:03:12', '2015-08-26 20:03:12', '2015-08-26 20:03:12'),
(34, 84, '3J4lvxUq77RWIek40L721pTpZBCKIQAq', 1, '2015-08-27 05:06:18', '2015-08-27 05:06:18', '2015-08-27 05:06:18'),
(35, 85, 'pUMGMFp4IqcNCEGbE1CUxMqcKKJBJJ8G', 1, '2015-08-27 05:07:48', '2015-08-27 05:07:48', '2015-08-27 05:07:48'),
(36, 86, 'P4RyTeQVY54m49klmFBgnBzJIRFNtjD9', 1, '2015-08-27 05:15:28', '2015-08-27 05:15:28', '2015-08-27 05:15:28'),
(37, 87, '5ymzMJkLhGdofzYUFM1TqApcGjkqGJf9', 1, '2015-08-27 05:15:44', '2015-08-27 05:15:43', '2015-08-27 05:15:44'),
(38, 88, 'MCNzdCSRrW7mjaWQnP1gZF5Xw3SC75Zb', 1, '2015-08-27 05:16:38', '2015-08-27 05:16:38', '2015-08-27 05:16:38'),
(39, 89, 'heK5vLYsULU8GU338IMq8XqaxOEFo9pk', 1, '2015-08-27 05:19:07', '2015-08-27 05:19:07', '2015-08-27 05:19:07'),
(40, 90, 'rtF8vrYyl52WW0LmyMAxkiJxYupHjUj5', 1, '2015-08-27 05:22:46', '2015-08-27 05:22:46', '2015-08-27 05:22:46'),
(41, 91, 'wSriQl42BcQmCrd8NtuwbjWqDFK1pdtq', 1, '2015-08-27 06:07:30', '2015-08-27 06:07:29', '2015-08-27 06:07:30'),
(42, 92, 'eM0IdnSiUMqooPwwhwujwy0haL33thTq', 1, '2015-08-27 06:27:29', '2015-08-27 06:27:29', '2015-08-27 06:27:29'),
(43, 93, '97Q7wjVrqqRxp2ZnIntGdZJ0iF6N626K', 1, '2015-08-27 06:29:47', '2015-08-27 06:29:47', '2015-08-27 06:29:47'),
(44, 94, 'm4NzEZuH6VWHqn7bCS3bwB9RvdZhbncS', 1, '2015-08-27 07:33:40', '2015-08-27 07:33:40', '2015-08-27 07:33:40'),
(45, 95, 'ZRJ5UUieQjxOvwwvr22c3wtwSpOkE8Ji', 1, '2015-08-27 11:26:11', '2015-08-27 11:26:11', '2015-08-27 11:26:11'),
(46, 96, 'DJWXe9PV1dSTQmaVKdch3VOWfy0fs9Vv', 1, '2015-08-27 11:30:16', '2015-08-27 11:30:16', '2015-08-27 11:30:16'),
(47, 97, 'OJwrWDkcGPumH5K5XtHmGtVgGpGcSI80', 1, '2015-08-27 11:32:00', '2015-08-27 11:32:00', '2015-08-27 11:32:00'),
(48, 98, 'YrSSp6Oo1kVPrFWaPDRwQdT0MXPqyKns', 1, '2015-08-27 11:52:26', '2015-08-27 11:52:26', '2015-08-27 11:52:26'),
(49, 99, 'MbvMOJvEVEdxNUIJNHuxSc75LC1JQy8C', 1, '2015-08-27 11:54:47', '2015-08-27 11:54:47', '2015-08-27 11:54:47'),
(50, 100, 'APJjsTiJqkLYcZfxSeJ7rwcHFatW9O7F', 1, '2015-08-27 12:07:08', '2015-08-27 12:07:08', '2015-08-27 12:07:08'),
(51, 101, '51AzzTNAzqkEfTqUajrE4lmAOvR3FiND', 1, '2015-08-31 12:14:29', '2015-08-31 12:14:28', '2015-08-31 12:14:29'),
(52, 102, 'EY2R7SIKUlkYRFGGzNZ4lSk7lcoaxmNe', 1, '2015-08-31 12:15:14', '2015-08-31 12:15:14', '2015-08-31 12:15:14'),
(53, 103, 'CbcoidrqbS1UP74tmp106rjdvbXS3VtI', 1, '2015-08-31 12:22:43', '2015-08-31 12:22:42', '2015-08-31 12:22:43'),
(54, 104, 'mr6EILd7kLcu7FknFNXSKgVNA3CYFxwJ', 1, '2015-08-31 13:02:37', '2015-08-31 13:02:37', '2015-08-31 13:02:37'),
(55, 105, 'vzJzoo5AleZRCVmYmoyE4ahluWNfpMzw', 1, '2015-09-02 12:48:54', '2015-09-02 12:48:54', '2015-09-02 12:48:54'),
(56, 106, '52ZzkS6n4cmDcpoSOj1V3fFQtqD0keFr', 1, '2015-09-02 19:17:32', '2015-09-02 19:17:32', '2015-09-02 19:17:32'),
(57, 107, 'ugGhUeUbWt0uDsfKuKM7EFox1QX37262', 1, '2015-09-02 19:50:00', '2015-09-02 19:50:00', '2015-09-02 19:50:00'),
(58, 108, 'yOxudNrFDenBVq5RIx0BJ3vsL2wmF0nD', 1, '2015-09-02 19:50:27', '2015-09-02 19:50:26', '2015-09-02 19:50:27'),
(59, 109, '6ifFXpoZcW6FqdoLEzR5xWpiUq9UXBHk', 1, '2015-09-02 21:59:36', '2015-09-02 21:59:36', '2015-09-02 21:59:36'),
(60, 110, '7hA5uuYdfdk9qVJbcYxGxMrFnRfHmElk', 1, '2015-09-02 22:01:05', '2015-09-02 22:01:05', '2015-09-02 22:01:05'),
(61, 113, 'pwwUJNIaesaAOvZQbcZrIVx6uiEtRh30', 1, '2015-09-03 06:22:24', '2015-09-03 06:22:24', '2015-09-03 06:22:24'),
(62, 114, 'oJkjw6ocwZJQ4xkxuTBDB6c2GAntk60i', 1, '2015-09-03 06:37:30', '2015-09-03 06:37:30', '2015-09-03 06:37:30'),
(63, 115, '4Vre9SA7de9P9PD7feimFdrkUDLZ4U9k', 1, '2015-09-08 07:19:57', '2015-09-08 07:19:57', '2015-09-08 07:19:57'),
(64, 116, 'E1draS6GEqe6yQePUjU9XxGNBDPYpChP', 1, '2015-09-10 12:27:29', '2015-09-10 12:27:29', '2015-09-10 12:27:29'),
(65, 117, 'cHVOxgoYtF4pBXVFVguSgLAh5s7AIykb', 1, '2015-09-13 13:26:53', '2015-09-13 13:26:53', '2015-09-13 13:26:53'),
(68, 3, 'p4NclSehtDYELU0ySSjZWzDQyMlyNlMj', 1, '2015-09-22 14:57:30', '2015-09-22 14:57:30', '2015-09-22 14:57:30'),
(69, 118, 'g7iehohDVrTIlka2iLlcVdGVXCobMEFC', 1, '2015-09-22 15:11:15', '2015-09-22 15:11:15', '2015-09-22 15:11:15'),
(70, 119, 'DD72ItErrTk1MBrhsHIkmnazF2boHoRs', 1, '2015-09-28 11:05:07', '2015-09-28 11:05:07', '2015-09-28 11:05:07'),
(71, 120, 'dEeToX96OL1DnrMQFCOQzt0yF5TL833Z', 1, '2015-09-28 11:06:28', '2015-09-28 11:06:28', '2015-09-28 11:06:28'),
(72, 121, 'IUKFgp0U4YdskFT5XNfdlP9cqE6nWiA8', 1, '2015-09-29 14:08:44', '2015-09-29 14:08:44', '2015-09-29 14:08:44'),
(73, 122, 'oraFgFOryUzmWjeIJbtDMpn2jyev7Vvv', 1, '2015-09-29 14:12:53', '2015-09-29 14:12:52', '2015-09-29 14:12:53'),
(74, 123, 'zM8qZYfFQ2zwFblp6GPwg7QtETwPokMi', 1, '2015-09-30 09:21:17', '2015-09-30 09:21:17', '2015-09-30 09:21:17'),
(75, 124, 'WdCDeQm6prohTnyLuoS5m7wjvmbbX0hm', 1, '2015-09-30 13:18:23', '2015-09-30 13:18:23', '2015-09-30 13:18:23'),
(76, 125, 'abEVf8dEm6wJ92TJE4HHzRDL4iQnecYJ', 1, '2015-09-30 13:20:53', '2015-09-30 13:20:53', '2015-09-30 13:20:53'),
(77, 126, 'Ybj3sYzoCGBeMWkdmFIy38nOC1ubjshS', 1, '2015-09-30 13:21:14', '2015-09-30 13:21:14', '2015-09-30 13:21:14'),
(78, 127, 'Nuy3jMTqHlpkVLknMUwfvJ3UulY73O8t', 1, '2015-09-30 13:22:23', '2015-09-30 13:22:23', '2015-09-30 13:22:23'),
(79, 128, 'C9EhSN8xL9U1T3HJf9dMZbRdYuIgSQPr', 1, '2015-09-30 13:22:45', '2015-09-30 13:22:45', '2015-09-30 13:22:45'),
(80, 129, 'Afuw6L3tCsWhVNP0paxYkZVrFHaTtg6W', 1, '2015-10-06 08:04:42', '2015-10-06 08:04:42', '2015-10-06 08:04:42'),
(81, 130, '5OgnFaOwzQnK01mXiPo0nRBZaXp02PyO', 1, '2015-10-06 15:04:12', '2015-10-06 15:04:11', '2015-10-06 15:04:12'),
(82, 131, 'NzaDuH9dVS7wmIA4XXWZ4jPjKYjmfMTl', 1, '2015-10-11 09:47:41', '2015-10-11 09:47:41', '2015-10-11 09:47:41'),
(83, 132, 'kYdCr4xYMdwIsiiYOHgB5bC8VIURu5ka', 1, '2015-10-11 11:55:52', '2015-10-11 11:55:52', '2015-10-11 11:55:52'),
(84, 134, 'hzymmPLak3mLxDWD5YInNa4vn2jjPkOb', 1, '2015-10-11 12:53:23', '2015-10-11 12:53:23', '2015-10-11 12:53:23'),
(85, 137, 'Pa4lgIcCDvwQxt0TbR1972XPKtYLrmuj', 1, '2015-10-11 13:59:02', '2015-10-11 13:59:02', '2015-10-11 13:59:02'),
(86, 139, 'eeBz9ircshDB14MJ2Yv1J9XengYMKql5', 1, '2015-10-13 12:31:26', '2015-10-13 12:31:25', '2015-10-13 12:31:26'),
(87, 140, 'DdjYx5444stHey4eBA3GOlok8jAoml3C', 1, '2015-10-13 12:33:07', '2015-10-13 12:33:07', '2015-10-13 12:33:07'),
(88, 141, 't9eQc1ygtCuujKyi5d0Rvkd8iAK4hrbP', 1, '2015-10-13 12:38:01', '2015-10-13 12:38:01', '2015-10-13 12:38:01'),
(89, 142, 'jvV5EyFjzRLiWIsO34KfodvJ4ZGWepia', 1, '2015-10-13 12:56:39', '2015-10-13 12:56:39', '2015-10-13 12:56:39'),
(90, 143, 'RET36ocCkHmyfInf0AL9jyO3LOXZBIkY', 1, '2015-10-13 13:50:00', '2015-10-13 13:50:00', '2015-10-13 13:50:00'),
(91, 3, 'uNhEAb6iDadYoVmQfWAxJPA9hmq9bJKV', 1, '2015-11-10 14:35:52', '2015-11-10 14:35:52', '2015-11-10 14:35:52'),
(92, 3, 'VMRYT4QPXoNDP3DwLK3xgNTVnTFc8hcP', 1, '2015-11-10 14:35:56', '2015-11-10 14:35:56', '2015-11-10 14:35:56'),
(93, 3, 'sAzWuNkMA4CeyUFnWilPo0keQVUj4KaH', 1, '2015-11-10 14:36:01', '2015-11-10 14:36:01', '2015-11-10 14:36:01'),
(94, 3, 'ozUAWN4EIjB2iCHRWW4n73g3kXWKqcZr', 1, '2015-11-10 14:36:01', '2015-11-10 14:36:01', '2015-11-10 14:36:01'),
(95, 3, 'YIXwRieAi6doh6VFST5KTNfOjUE7Rg4w', 1, '2015-11-10 14:36:09', '2015-11-10 14:36:05', '2015-11-10 14:36:09'),
(96, 3, '89qRDPj9not9pE6WmUO1fSF9L6Gme38k', 1, '2015-11-10 14:36:15', '2015-11-10 14:36:14', '2015-11-10 14:36:15'),
(97, 3, 'iMqlERR1HvHIhXOQYbsbinpIwnbjfXEK', 1, '2015-11-10 14:36:16', '2015-11-10 14:36:15', '2015-11-10 14:36:16'),
(98, 3, 'bkcEpzESfyNLhKZJ6Kg6t3Yw706pa9Q3', 1, '2015-11-10 14:36:18', '2015-11-10 14:36:18', '2015-11-10 14:36:18'),
(99, 3, 'BzuXpKvke2TBBuVzUDI2Ig92aeoMBLOe', 1, '2015-11-10 15:53:42', '2015-11-10 15:53:42', '2015-11-10 15:53:42'),
(100, 3, 'daL5FCYpAK5n8610ggVOMHoyrPNK4fvZ', 1, '2015-11-10 15:53:44', '2015-11-10 15:53:44', '2015-11-10 15:53:44'),
(101, 3, 'nX8aho5cynlQILDC1LCXV26NvQbMT4T2', 1, '2015-11-10 16:36:03', '2015-11-10 16:36:03', '2015-11-10 16:36:03'),
(102, 188, 'ka5aXDz9VEkXY100Tfi8ABBpxHgiYnyb', 1, '2015-11-15 08:33:51', '2015-11-15 08:33:51', '2015-11-15 08:33:51'),
(103, 189, 'OoRRBeXTV7iKCkOt40EXXtl9OofwmuqS', 1, '2015-11-15 08:35:30', '2015-11-15 08:35:30', '2015-11-15 08:35:30'),
(104, 190, 'OF2GMg8pFw52tPO8jaWFJnkTd4SF5kyO', 1, '2015-11-15 09:36:53', '2015-11-15 09:36:53', '2015-11-15 09:36:53'),
(105, 192, 'qbt0SY0twGDVx3A0WBZNoBFxy95DRGQ7', 1, '2015-11-15 09:45:33', '2015-11-15 09:45:33', '2015-11-15 09:45:33'),
(106, 193, 'TRucTXlemXFoe4FdQUoQWhPhooRSRojS', 1, '2015-11-15 09:49:33', '2015-11-15 09:49:33', '2015-11-15 09:49:33'),
(107, 194, '4BZV7TNstD4yU5rjav5YTb7KWsPM2kUu', 1, '2015-11-15 09:51:49', '2015-11-15 09:51:49', '2015-11-15 09:51:49'),
(108, 195, 'Q3Q1T2Xe4yZNeYvlHHjV2CmL979P8mLk', 1, '2015-11-15 10:59:22', '2015-11-15 10:59:22', '2015-11-15 10:59:22'),
(109, 196, '0WSGdD0KWBoj6KnQ6YKpTVq4RXX5nudJ', 1, '2015-11-15 11:02:24', '2015-11-15 11:02:24', '2015-11-15 11:02:24'),
(110, 197, 'KGf45oa5vcL6HcAWF5w4LV7a706Fy7E1', 1, '2015-11-15 11:04:31', '2015-11-15 11:04:31', '2015-11-15 11:04:31'),
(111, 198, 'APqe8JJaTSIrv9x29Zsfr97wT6C2oh21', 1, '2015-11-15 11:05:59', '2015-11-15 11:05:59', '2015-11-15 11:05:59'),
(112, 200, 'wU9PUZvvnchLyJvLSUCyJ0kCteDh5z3e', 1, '2015-11-15 11:10:54', '2015-11-15 11:10:54', '2015-11-15 11:10:54'),
(113, 202, '0SlFHCA6DPGzsmKzO03FrlTJE1UObHW0', 1, '2015-11-15 11:11:49', '2015-11-15 11:11:49', '2015-11-15 11:11:49'),
(114, 205, 'oNFzKaokFBdHol9lQKa2Pai5o6g9I7aE', 1, '2015-11-15 11:16:09', '2015-11-15 11:16:09', '2015-11-15 11:16:09'),
(115, 206, 'okWYlftBE0YpBoZmOBQoomnFvnkCuaUy', 1, '2015-11-19 11:01:44', '2015-11-19 11:01:44', '2015-11-19 11:01:44'),
(116, 207, 'Demk7ZTMlouMZtpX4RdZNhMKqmzqMGYx', 1, '2016-02-02 08:58:10', '2016-02-02 08:58:10', '2016-02-02 08:58:10'),
(117, 208, 'GfoslC1hvvf7dG1yvTHW5DSjFnQrz6GG', 1, '2016-02-10 06:53:48', '2016-02-10 06:53:48', '2016-02-10 06:53:48'),
(118, 209, 'BlyaGyJNB1RbfOaKLfpnB6wZ4GrSuCYJ', 1, '2016-02-10 07:11:23', '2016-02-10 07:11:23', '2016-02-10 07:11:23'),
(119, 251, '55ELcXZtaos5Dn2pkBxlGpLu8Koe5r4k', 1, '2016-02-10 07:13:08', '2016-02-10 07:13:08', '2016-02-10 07:13:08'),
(120, 252, 'kdetrkVpBgU1gjIjdP3fpF9dDeS5NGub', 1, '2016-03-06 12:31:56', '2016-03-06 12:31:56', '2016-03-06 12:31:56'),
(121, 248, 'wCYn4GwHQRPQbAE12mNHpV9ePdHi57AR', 1, '2016-04-10 09:19:22', '2016-04-10 09:19:22', '2016-04-10 09:19:22'),
(122, 199, '7cK0gWuPJGI9N1ztwL4BNXCCMKh15GRO', 1, '2016-04-10 12:22:26', '2016-04-10 12:22:26', '2016-04-10 12:22:26'),
(123, 254, 'gdbrRGktVHmAr3WkVepQ1ULSRVQZeSAL', 1, '2016-04-10 14:23:41', '2016-04-10 14:23:41', '2016-04-10 14:23:41'),
(124, 256, 'spExnx7DRDwZmnL6ib5yD08S1uGHOERe', 1, '2016-04-10 14:27:09', '2016-04-10 14:27:09', '2016-04-10 14:27:09'),
(125, 257, 'CUtGmxuyl6qy1v2jL0B9VkbY1gY3QX2E', 1, '2016-06-16 11:20:17', '2016-06-16 11:20:17', '2016-06-16 11:20:17'),
(126, 258, 'U7Nn5HgLQE8O6xd9CzSZQ0LGHcePWR1t', 1, '2016-06-16 11:24:43', '2016-06-16 11:24:43', '2016-06-16 11:24:43'),
(127, 259, 'ZKio8oiJ1NWEhqPAB256h07La8O9vXE6', 1, '2016-06-16 11:27:27', '2016-06-16 11:27:27', '2016-06-16 11:27:27'),
(128, 260, '4Wq3rrNcLj6R4yzHZBJJKmre9a9qHP5F', 1, '2016-06-16 11:40:00', '2016-06-16 11:40:00', '2016-06-16 11:40:00'),
(129, 261, '8BLtJU7Uac3BkQdOyaa3GnxyzuJpnqCN', 1, '2016-06-16 11:40:55', '2016-06-16 11:40:55', '2016-06-16 11:40:55'),
(130, 262, 'AaS173Kw4qyGaASMDughIXkCG2GADRuE', 1, '2017-06-21 13:32:11', '2017-06-21 13:32:11', '2017-06-21 13:32:11'),
(131, 263, 'WZFIorcIuiF7jWP6sZIF56I9d6wKNJVG', 1, '2017-07-26 19:28:03', '2017-07-26 19:28:03', '2017-07-26 19:28:03'),
(132, 264, 'a8NDCbeBrKWvQyHKZC5604Bivzwg1jec', 1, '2017-08-13 16:34:53', '2017-08-13 16:34:52', '2017-08-13 16:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `agent_accounts`
--

CREATE TABLE `agent_accounts` (
  `id` int(11) NOT NULL,
  `user_type` int(11) DEFAULT '3' COMMENT 'defaults to staff ',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `mobile_number` varchar(50) DEFAULT NULL,
  `phone_number` varchar(50) NOT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `home_address` varchar(200) DEFAULT NULL,
  `next_of_kin` int(11) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 0 kB; (`added_by`) REFER `cartow/users`(`id`); (`company_id`) REFER';

--
-- Dumping data for table `agent_accounts`
--

INSERT INTO `agent_accounts` (`id`, `user_type`, `first_name`, `last_name`, `mobile_number`, `phone_number`, `email_address`, `email`, `home_address`, `next_of_kin`, `company_id`, `added_by`, `user_id`) VALUES
(14, 3, 'ddsfsdf', 'sdfsdf', NULL, '11111', NULL, 'sfsd@sfsdf.com', NULL, NULL, 6, 3, 3),
(44, 3, '', '', NULL, 'Kim ', NULL, '', NULL, NULL, 28, 3, 58),
(45, 3, '', '', NULL, '0861514965', NULL, '', NULL, NULL, 6, 3, 66),
(49, 3, '', '', NULL, '01121322123', NULL, '', NULL, NULL, 29, 3, 70),
(50, 3, '', '', NULL, 'Bren', NULL, '', NULL, NULL, 30, 3, 71),
(52, 3, '', '', NULL, '086151495', NULL, '', NULL, NULL, 6, 3, 73),
(54, 3, '', '', NULL, '0020120584176', NULL, '', NULL, NULL, 6, 3, 75),
(55, 3, '', '', NULL, '0868988530', NULL, '', NULL, NULL, 6, 3, 77),
(58, 3, '', '', NULL, 'John', NULL, '', NULL, NULL, 31, 3, 88),
(59, 3, '', '', NULL, 'Paul', NULL, '', NULL, NULL, 32, 3, 89),
(60, 3, '', '', NULL, '0876707316', NULL, '', NULL, NULL, 32, 89, 91),
(61, 3, '', '', NULL, '0868988530', NULL, '', NULL, NULL, 6, 3, 93),
(62, 3, '', '', NULL, 'paul', NULL, '', NULL, NULL, 33, 3, 94),
(63, 3, '', '', NULL, '123', NULL, '', NULL, NULL, 33, 94, 95),
(64, 3, '', '', NULL, 'Kim', NULL, '', NULL, NULL, 34, 3, 96),
(67, 3, '', '', NULL, 'Bill', NULL, '', NULL, NULL, 35, 3, 101),
(68, 3, '', '', NULL, 'Mike Dineen', NULL, '', NULL, NULL, 36, 3, 103),
(69, 3, '', '', NULL, '0123', NULL, '', NULL, NULL, 6, 3, 186),
(70, 3, '', '', NULL, '016877443', NULL, '', NULL, NULL, 6, 3, 193),
(71, 3, '', '', NULL, '0', NULL, '', NULL, NULL, 6, 3, 195),
(73, 3, '', '', NULL, 'Fayez Raw', NULL, '', NULL, NULL, 38, 3, 199),
(74, 3, '', '', NULL, '', NULL, '', NULL, NULL, 6, 3, 200),
(77, 3, '', '', NULL, '0861514965', NULL, '', NULL, NULL, 6, 3, 239),
(79, 3, '', '', NULL, '0861514965', NULL, '', NULL, NULL, 6, 3, 243),
(80, 3, '', '', NULL, '0862149656', NULL, '', NULL, NULL, 6, 3, 245),
(81, 3, '', '', NULL, '1850227869', NULL, '', NULL, NULL, 6, 3, 246),
(82, 3, '', '', NULL, '1850227869', NULL, '', NULL, NULL, 6, 3, 247),
(83, 3, '', '', NULL, 'vms_auto', NULL, '', NULL, NULL, 39, 3, 248),
(84, 3, '', '', NULL, 'Mahamad Fayez', NULL, '', NULL, NULL, 41, 3, 263),
(85, 3, '', '', NULL, '', NULL, '', NULL, NULL, 6, 3, 264);

-- --------------------------------------------------------

--
-- Table structure for table `agent_activities`
--

CREATE TABLE `agent_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `activity_type_id` int(10) DEFAULT NULL,
  `entry_by` int(10) DEFAULT NULL,
  `note` text,
  `user_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at_integer` int(11) DEFAULT NULL,
  `updated_at_integer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agent_activities`
--

INSERT INTO `agent_activities` (`id`, `activity_type_id`, `entry_by`, `note`, `user_id`, `created_at`, `updated_at`, `created_at_integer`, `updated_at_integer`) VALUES
(1, 1, 115, '', 115, NULL, NULL, NULL, 0),
(2, 1, 115, '', 115, '2015-09-08 16:35:53', NULL, NULL, 0),
(3, 1, 115, '', 115, '2015-09-08 16:36:09', NULL, NULL, 0),
(4, 1, 115, 'normal login to the system', 115, '2015-09-08 17:57:39', '2015-09-08 17:57:39', NULL, 0),
(5, 1, 115, 'normal login to the system', 115, '2015-09-08 17:57:41', '2015-09-08 17:57:41', NULL, 0),
(6, 1, 115, 'normal login to the system', 115, '2015-09-08 17:57:43', '2015-09-08 17:57:43', NULL, 0),
(7, 1, 115, 'normal login to the system', 115, '2015-09-09 09:42:34', '2015-09-09 09:42:34', NULL, 0),
(8, 1, 94, 'normal login to the system', 94, '2015-09-09 10:14:25', '2015-09-09 10:14:25', NULL, 0),
(9, 2, 94, 'Logout to the system', 94, '2015-09-09 10:14:30', '2015-09-09 10:14:30', NULL, 0),
(10, 1, 99, 'normal login to the system', 99, '2015-09-09 10:14:41', '2015-09-09 10:14:41', NULL, 0),
(11, 2, 99, 'Logout to the system', 99, '2015-09-09 10:17:41', '2015-09-09 10:17:41', NULL, 0),
(12, 1, 3, 'normal login to the system', 3, '2015-09-09 10:18:00', '2015-09-09 10:18:00', NULL, 0),
(13, 2, 3, 'Logout to the system', 3, '2015-09-09 10:24:48', '2015-09-09 10:24:48', NULL, 0),
(14, 1, 3, 'normal login to the system', 3, '2015-09-09 11:25:18', '2015-09-09 11:25:18', NULL, 0),
(15, 2, 3, 'Logout to the system', 3, '2015-09-09 12:56:37', '2015-09-09 12:56:37', NULL, 0),
(16, 1, 99, 'normal login to the system', 99, '2015-09-09 12:56:45', '2015-09-09 12:56:45', NULL, 0),
(17, 2, 99, '12', 1, '2015-09-09 13:51:17', '2015-09-09 13:51:17', NULL, 0),
(18, 2, 99, '12', 1, '2015-09-09 13:51:19', '2015-09-09 13:51:19', NULL, 0),
(19, 2, 99, 'Logout to the system', 99, '2015-09-09 14:04:33', '2015-09-09 14:04:33', NULL, 0),
(20, 1, 3, 'normal login to the system', 3, '2015-09-09 14:36:00', '2015-09-09 14:36:00', NULL, 0),
(21, 1, 92, 'normal login to the system', 92, '2015-09-10 10:38:30', '2015-09-10 10:38:30', NULL, 0),
(22, 2, 92, 'Logout to the system', 92, '2015-09-10 10:39:10', '2015-09-10 10:39:10', NULL, 0),
(23, 1, 3, 'normal login to the system', 3, '2015-09-10 10:39:15', '2015-09-10 10:39:15', NULL, 0),
(24, 1, 3, 'normal login to the system', 3, '2015-09-10 13:22:41', '2015-09-10 13:22:41', NULL, 0),
(25, 4, 3, 'registered member with username :  shady', 116, '2015-09-10 14:27:30', '2015-09-10 14:27:30', NULL, 0),
(26, 1, 3, 'Force Login by test username', 3, '2015-09-10 17:28:30', '2015-09-10 17:28:30', NULL, 0),
(27, 1, 3, 'normal login to the system', 3, '2015-09-10 17:28:54', '2015-09-10 17:28:54', NULL, 0),
(28, 1, 3, 'normal login to the system', 3, '2015-09-13 14:55:09', '2015-09-13 14:55:09', NULL, 0),
(29, 1, 3, 'Force Login by test username', 3, '2015-09-13 14:56:05', '2015-09-13 14:56:05', NULL, 0),
(30, 1, 91, 'Force Login by test username', 91, '2015-09-13 14:57:56', '2015-09-13 14:57:56', NULL, 0),
(31, 1, 91, 'Force Login by Testing', 91, '2015-09-13 14:58:29', '2015-09-13 14:58:29', NULL, 0),
(32, 1, 98, 'Force Login by Testing', 98, '2015-09-13 14:58:38', '2015-09-13 14:58:38', NULL, 0),
(33, 2, 98, 'Logout to the system', 98, '2015-09-13 14:58:45', '2015-09-13 14:58:45', NULL, 0),
(34, 1, 3, 'normal login to the system', 3, '2015-09-13 14:58:50', '2015-09-13 14:58:50', NULL, 0),
(35, 2, 3, 'Logout to the system', 3, '2015-09-13 15:23:50', '2015-09-13 15:23:50', NULL, 0),
(36, 1, 3, 'normal login to the system', 3, '2015-09-13 15:24:03', '2015-09-13 15:24:03', NULL, 0),
(37, 2, 3, 'Logout to the system', 3, '2015-09-13 15:27:07', '2015-09-13 15:27:07', NULL, 0),
(38, 1, 117, 'normal login to the system', 117, '2015-09-13 15:27:22', '2015-09-13 15:27:22', NULL, 0),
(39, 1, 91, 'Force Login by shadywallas2', 91, '2015-09-13 15:42:59', '2015-09-13 15:42:59', NULL, 0),
(40, 2, 91, 'Logout to the system', 91, '2015-09-13 15:45:12', '2015-09-13 15:45:12', NULL, 0),
(41, 1, 117, 'normal login to the system', 117, '2015-09-13 15:45:18', '2015-09-13 15:45:18', NULL, 0),
(42, 1, 117, 'normal login to the system', 117, '2015-09-14 09:40:53', '2015-09-14 09:40:53', NULL, 0),
(43, 2, 117, 'Logout to the system', 117, '2015-09-14 09:44:23', '2015-09-14 09:44:23', NULL, 0),
(44, 1, 3, 'normal login to the system', 3, '2015-09-14 09:44:31', '2015-09-14 09:44:31', NULL, 0),
(45, 2, 3, 'Logout to the system', 3, '2015-09-14 09:45:04', '2015-09-14 09:45:04', NULL, 0),
(46, 1, 117, 'normal login to the system', 117, '2015-09-14 09:45:08', '2015-09-14 09:45:08', NULL, 0),
(47, 2, 117, 'Logout to the system', 117, '2015-09-14 09:48:11', '2015-09-14 09:48:11', NULL, 0),
(48, 1, 3, 'normal login to the system', 3, '2015-09-14 09:48:16', '2015-09-14 09:48:16', NULL, 0),
(49, 1, 91, 'Force Login by test username', 91, '2015-09-14 10:53:15', '2015-09-14 10:53:15', NULL, 0),
(50, 2, 91, 'Logout to the system', 91, '2015-09-14 12:41:29', '2015-09-14 12:41:29', NULL, 0),
(51, 1, 117, 'normal login to the system', 117, '2015-09-14 12:41:34', '2015-09-14 12:41:34', NULL, 0),
(52, 1, 117, 'normal login to the system', 117, '2015-09-14 15:34:09', '2015-09-14 15:34:09', NULL, 0),
(53, 1, 117, 'normal login to the system', 117, '2015-09-15 07:47:53', '2015-09-15 07:47:53', NULL, 0),
(54, 1, 117, 'normal login to the system', 117, '2015-09-17 08:10:35', '2015-09-17 08:10:35', NULL, 0),
(55, 1, 117, 'normal login to the system', 117, '2015-09-18 16:54:01', '2015-09-18 16:54:01', NULL, 0),
(56, 1, 117, 'normal login to the system', 117, '2015-09-18 19:18:23', '2015-09-18 19:18:23', NULL, 0),
(57, 1, 117, 'normal login to the system', 117, '2015-09-18 19:41:11', '2015-09-18 19:41:11', NULL, 0),
(58, 1, 117, 'normal login to the system', 117, '2015-09-20 13:11:09', '2015-09-20 13:11:09', NULL, 0),
(59, 1, 117, 'normal login to the system', 117, '2015-09-20 13:24:10', '2015-09-20 13:24:10', NULL, 0),
(60, 1, 117, 'normal login to the system', 117, '2015-09-20 13:58:20', '2015-09-20 13:58:20', NULL, 0),
(61, 1, 117, 'normal login to the system', 117, '2015-09-20 14:39:24', '2015-09-20 14:39:24', NULL, 0),
(62, 1, 117, 'normal login to the system', 117, '2015-09-20 14:53:30', '2015-09-20 14:53:30', NULL, 0),
(63, 1, 117, 'normal login to the system', 117, '2015-09-20 15:00:33', '2015-09-20 15:00:33', NULL, 0),
(64, 1, 117, 'normal login to the system', 117, '2015-09-21 12:29:58', '2015-09-21 12:29:58', NULL, 0),
(65, 2, 117, 'Logout to the system', 117, '2015-09-21 15:24:54', '2015-09-21 15:24:54', NULL, 0),
(66, 1, 3, 'normal login to the system', 3, '2015-09-21 15:25:01', '2015-09-21 15:25:01', NULL, 0),
(67, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:25:13', '2015-09-21 15:25:13', NULL, 0),
(68, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:25:35', '2015-09-21 15:25:35', NULL, 0),
(69, 1, 3, 'normal login to the system', 3, '2015-09-21 15:26:50', '2015-09-21 15:26:50', NULL, 0),
(70, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:26:54', '2015-09-21 15:26:54', NULL, 0),
(71, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:27:08', '2015-09-21 15:27:08', NULL, 0),
(72, 1, 117, 'normal login to the system', 117, '2015-09-21 15:27:58', '2015-09-21 15:27:58', NULL, 0),
(73, 2, 117, 'Logout to the system', 117, '2015-09-21 15:28:02', '2015-09-21 15:28:02', NULL, 0),
(74, 1, 3, 'normal login to the system', 3, '2015-09-21 15:28:09', '2015-09-21 15:28:09', NULL, 0),
(75, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:28:18', '2015-09-21 15:28:18', NULL, 0),
(76, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:29:01', '2015-09-21 15:29:01', NULL, 0),
(77, 1, 3, 'normal login to the system', 3, '2015-09-21 15:29:49', '2015-09-21 15:29:49', NULL, 0),
(78, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:29:54', '2015-09-21 15:29:54', NULL, 0),
(79, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:29:55', '2015-09-21 15:29:55', NULL, 0),
(80, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:30:32', '2015-09-21 15:30:32', NULL, 0),
(81, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:30:33', '2015-09-21 15:30:33', NULL, 0),
(82, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:31:06', '2015-09-21 15:31:06', NULL, 0),
(83, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:31:35', '2015-09-21 15:31:35', NULL, 0),
(84, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:31:39', '2015-09-21 15:31:39', NULL, 0),
(85, 1, 3, 'Force Login by test username', 3, '2015-09-21 15:31:40', '2015-09-21 15:31:40', NULL, 0),
(86, 1, 91, 'Force Login by test username', 91, '2015-09-21 15:31:48', '2015-09-21 15:31:48', NULL, 0),
(87, 1, 98, 'Force Login by Testing', 98, '2015-09-21 15:32:01', '2015-09-21 15:32:01', NULL, 0),
(88, 1, 91, 'Force Login by Testinguu', 91, '2015-09-21 15:32:03', '2015-09-21 15:32:03', NULL, 0),
(89, 2, 91, 'Logout to the system', 91, '2015-09-21 15:32:09', '2015-09-21 15:32:09', NULL, 0),
(90, 1, 117, 'normal login to the system', 117, '2015-09-21 16:28:24', '2015-09-21 16:28:24', NULL, 0),
(91, 1, 117, 'normal login to the system', 117, '2015-09-22 10:55:16', '2015-09-22 10:55:16', NULL, 0),
(92, 2, 117, 'Logout to the system', 117, '2015-09-22 14:22:12', '2015-09-22 14:22:12', NULL, 0),
(93, 1, 3, 'normal login to the system', 3, '2015-09-22 14:22:21', '2015-09-22 14:22:21', NULL, 0),
(94, 1, 98, 'Force Login by test username', 98, '2015-09-22 14:25:42', '2015-09-22 14:25:42', NULL, 0),
(95, 1, 3, 'Force Login by Testinguu', 3, '2015-09-22 14:25:50', '2015-09-22 14:25:50', NULL, 0),
(96, 1, 98, 'Force Login by test username', 98, '2015-09-22 14:26:05', '2015-09-22 14:26:05', NULL, 0),
(97, 1, 3, 'Force Login by Testinguu', 3, '2015-09-22 14:26:47', '2015-09-22 14:26:47', NULL, 0),
(98, 1, 98, 'Force Login by test username', 98, '2015-09-22 14:27:23', '2015-09-22 14:27:23', NULL, 0),
(99, 1, 3, 'Force Login by Testinguu', 3, '2015-09-22 14:28:51', '2015-09-22 14:28:51', NULL, 0),
(100, 2, 3, 'Logout to the system', 3, '2015-09-22 14:52:31', '2015-09-22 14:52:31', NULL, 0),
(101, 1, 117, 'normal login to the system', 117, '2015-09-22 14:52:34', '2015-09-22 14:52:34', NULL, 0),
(102, 2, 117, 'Logout to the system', 117, '2015-09-22 15:03:48', '2015-09-22 15:03:48', NULL, 0),
(103, 1, 3, 'normal login to the system', 3, '2015-09-22 15:03:54', '2015-09-22 15:03:54', NULL, 0),
(104, 2, 3, 'Logout to the system', 3, '2015-09-22 16:52:09', '2015-09-22 16:52:09', NULL, 0),
(105, 1, 94, 'normal login to the system', 94, '2015-09-22 16:52:15', '2015-09-22 16:52:15', NULL, 0),
(106, 2, 94, 'Logout to the system', 94, '2015-09-22 16:53:44', '2015-09-22 16:53:44', NULL, 0),
(107, 1, 117, 'normal login to the system', 117, '2015-09-22 16:53:50', '2015-09-22 16:53:50', NULL, 0),
(108, 2, 117, 'Logout to the system', 117, '2015-09-22 16:53:52', '2015-09-22 16:53:52', NULL, 0),
(109, 1, 3, 'normal login to the system', 3, '2015-09-22 16:53:56', '2015-09-22 16:53:56', NULL, 0),
(110, 2, 3, 'Logout to the system', 3, '2015-09-22 16:57:35', '2015-09-22 16:57:35', NULL, 0),
(111, 1, 3, 'normal login to the system', 3, '2015-09-22 16:57:39', '2015-09-22 16:57:39', NULL, 0),
(112, 2, 3, 'Logout to the system', 3, '2015-09-22 16:57:55', '2015-09-22 16:57:55', NULL, 0),
(113, 1, 3, 'normal login to the system', 3, '2015-09-22 16:57:59', '2015-09-22 16:57:59', NULL, 0),
(114, 1, 3, 'normal login to the system', 3, '2015-09-22 16:58:03', '2015-09-22 16:58:03', NULL, 0),
(115, 1, 117, 'normal login to the system', 117, '2015-09-22 16:58:18', '2015-09-22 16:58:18', NULL, 0),
(116, 2, 117, 'Logout to the system', 117, '2015-09-22 17:05:07', '2015-09-22 17:05:07', NULL, 0),
(117, 1, 3, 'normal login to the system', 3, '2015-09-22 17:05:12', '2015-09-22 17:05:12', NULL, 0),
(118, 1, 98, 'normal login to the system', 98, '2015-09-28 13:01:38', '2015-09-28 13:01:38', NULL, 0),
(119, 2, 98, 'Logout to the system', 98, '2015-09-28 13:04:20', '2015-09-28 13:04:20', NULL, 0),
(120, 1, 3, 'normal login to the system', 3, '2015-09-28 13:04:24', '2015-09-28 13:04:24', NULL, 0),
(121, 4, 3, 'registered member with username :  ashraf', 119, '2015-09-28 13:05:07', '2015-09-28 13:05:07', NULL, 0),
(122, 4, 3, 'registered member with username :  gdsfgsdfg', 120, '2015-09-28 13:06:28', '2015-09-28 13:06:28', NULL, 0),
(123, 1, 117, 'normal login to the system', 117, '2015-09-29 09:44:38', '2015-09-29 09:44:38', NULL, 0),
(124, 2, 117, 'Logout to the system', 117, '2015-09-29 09:44:54', '2015-09-29 09:44:54', NULL, 0),
(125, 1, 3, 'normal login to the system', 3, '2015-09-29 09:44:58', '2015-09-29 09:44:58', NULL, 0),
(126, 1, 3, 'normal login to the system', 3, '2015-09-29 15:55:19', '2015-09-29 15:55:19', NULL, 0),
(127, 1, 122, 'Force Login by test username', 122, '2015-09-29 16:48:17', '2015-09-29 16:48:17', NULL, 0),
(128, 1, 3, 'Force Login by Testingsss', 3, '2015-09-29 16:48:19', '2015-09-29 16:48:19', NULL, 0),
(129, 1, 122, 'Force Login by test username', 122, '2015-09-29 16:48:26', '2015-09-29 16:48:26', NULL, 0),
(130, 1, 3, 'normal login to the system', 3, '2015-09-29 16:48:46', '2015-09-29 16:48:46', NULL, 0),
(131, 1, 3, 'Force Login by test username', 3, '2015-09-29 16:48:51', '2015-09-29 16:48:51', NULL, 0),
(132, 1, 122, 'Force Login by test username', 122, '2015-09-29 16:48:58', '2015-09-29 16:48:58', NULL, 0),
(133, 1, 117, 'normal login to the system', 117, '2015-09-29 16:49:54', '2015-09-29 16:49:54', NULL, 0),
(134, 1, 3, 'Force Login by shadywallas2', 3, '2015-09-29 16:49:55', '2015-09-29 16:49:55', NULL, 0),
(135, 1, 122, 'Force Login by test username', 122, '2015-09-29 16:50:06', '2015-09-29 16:50:06', NULL, 0),
(136, 1, 3, 'normal login to the system', 3, '2015-09-29 16:51:19', '2015-09-29 16:51:19', NULL, 0),
(137, 1, 3, 'Force Login by test username', 3, '2015-09-29 16:51:19', '2015-09-29 16:51:19', NULL, 0),
(138, 1, 122, 'Force Login by test username', 122, '2015-09-29 17:08:43', '2015-09-29 17:08:43', NULL, 0),
(139, 2, 122, 'Logout to the system', 122, '2015-09-29 17:14:31', '2015-09-29 17:14:31', NULL, 0),
(140, 1, 3, 'normal login to the system', 3, '2015-09-29 17:14:45', '2015-09-29 17:14:45', NULL, 0),
(141, 1, 3, 'Force Login by test username', 3, '2015-09-29 17:14:51', '2015-09-29 17:14:51', NULL, 0),
(142, 1, 122, 'Force Login by test username', 122, '2015-09-29 17:48:09', '2015-09-29 17:48:09', NULL, 0),
(143, 1, 3, 'Force Login by Testingsss', 3, '2015-09-29 17:48:15', '2015-09-29 17:48:15', NULL, 0),
(144, 1, 3, 'normal login to the system', 3, '2015-09-30 10:52:43', '2015-09-30 10:52:43', NULL, 0),
(145, 2, 3, 'Logout to the system', 3, '2015-09-30 11:22:14', '2015-09-30 11:22:14', NULL, 0),
(146, 1, 123, 'normal login to the system', 123, '2015-09-30 11:22:31', '2015-09-30 11:22:31', NULL, 0),
(147, 1, 123, 'normal login to the system', 123, '2015-09-30 12:42:07', '2015-09-30 12:42:07', NULL, 0),
(148, 1, 123, 'normal login to the system', 123, '2015-10-04 13:20:39', '2015-10-04 13:20:39', NULL, 0),
(149, 1, 123, 'normal login to the system', 123, '2015-10-06 10:04:06', '2015-10-06 10:04:06', NULL, 0),
(150, 4, 123, 'registered member with username :  shadywallas', 129, '2015-10-06 10:04:42', '2015-10-06 10:04:42', NULL, 0),
(151, 2, 123, 'Logout to the system', 123, '2015-10-06 11:47:00', '2015-10-06 11:47:00', NULL, 0),
(152, 1, 3, 'normal login to the system', 3, '2015-10-06 11:47:08', '2015-10-06 11:47:08', NULL, 0),
(153, 1, 122, 'Force Login by test username', 122, '2015-10-06 11:49:48', '2015-10-06 11:49:48', NULL, 0),
(154, 1, 3, 'Force Login by Testingsss', 3, '2015-10-06 11:51:07', '2015-10-06 11:51:07', NULL, 0),
(155, 1, 123, 'normal login to the system', 123, '2015-10-06 14:22:05', '2015-10-06 14:22:05', NULL, 0),
(156, 1, 123, 'normal login to the system', 123, '2015-10-07 09:50:59', '2015-10-07 09:50:59', NULL, 0),
(157, 2, 123, 'Logout to the system', 123, '2015-10-07 09:51:05', '2015-10-07 09:51:05', NULL, 0),
(158, 1, 3, 'normal login to the system', 3, '2015-10-07 09:51:11', '2015-10-07 09:51:11', NULL, 0),
(159, 2, 3, 'Logout to the system', 3, '2015-10-07 11:32:48', '2015-10-07 11:32:48', NULL, 0),
(160, 1, 123, 'normal login to the system', 123, '2015-10-07 11:36:00', '2015-10-07 11:36:00', NULL, 0),
(161, 2, 123, 'Logout to the system', 123, '2015-10-07 11:40:29', '2015-10-07 11:40:29', NULL, 0),
(162, 1, 3, 'normal login to the system', 3, '2015-10-07 11:40:33', '2015-10-07 11:40:33', NULL, 0),
(163, 2, 3, 'Logout to the system', 3, '2015-10-07 14:23:37', '2015-10-07 14:23:37', NULL, 0),
(164, 1, 123, 'normal login to the system', 123, '2015-10-07 14:24:05', '2015-10-07 14:24:05', NULL, 0),
(165, 2, 123, 'Logout to the system', 123, '2015-10-07 14:28:38', '2015-10-07 14:28:38', NULL, 0),
(166, 1, 3, 'normal login to the system', 3, '2015-10-07 14:28:43', '2015-10-07 14:28:43', NULL, 0),
(167, 1, 3, 'normal login to the system', 3, '2015-10-11 11:11:15', '2015-10-11 11:11:15', NULL, 0),
(168, 2, 3, 'Logout to the system', 3, '2015-10-11 12:13:50', '2015-10-11 12:13:50', NULL, 0),
(169, 1, 123, 'normal login to the system', 123, '2015-10-11 12:30:02', '2015-10-11 12:30:02', NULL, 0),
(170, 2, 123, 'Logout to the system', 123, '2015-10-11 13:08:46', '2015-10-11 13:08:46', NULL, 0),
(171, 1, 123, 'normal login to the system', 123, '2015-10-11 13:08:50', '2015-10-11 13:08:50', NULL, 0),
(172, 2, 123, 'Logout to the system', 123, '2015-10-11 13:08:53', '2015-10-11 13:08:53', NULL, 0),
(173, 2, NULL, 'Logout to the system', 88, '2015-10-11 13:27:38', '2015-10-11 13:27:38', NULL, 0),
(174, 1, 88, 'normal login to the system', 88, '2015-10-11 13:29:43', '2015-10-11 13:29:43', NULL, 0),
(175, 2, 88, 'Logout to the system', 88, '2015-10-11 13:41:12', '2015-10-11 13:41:12', NULL, 0),
(176, 1, 99, 'normal login to the system', 99, '2015-10-11 13:41:19', '2015-10-11 13:41:19', NULL, 0),
(177, 2, 99, 'Logout to the system', 99, '2015-10-11 13:41:21', '2015-10-11 13:41:21', NULL, 0),
(178, 1, 3, 'normal login to the system', 3, '2015-10-11 13:41:25', '2015-10-11 13:41:25', NULL, 0),
(179, 2, 3, 'Logout to the system', 3, '2015-10-11 13:54:19', '2015-10-11 13:54:19', NULL, 0),
(180, 1, 3, 'normal login to the system', 3, '2015-10-11 13:55:29', '2015-10-11 13:55:29', NULL, 0),
(181, 2, 3, 'Logout to the system', 3, '2015-10-11 13:56:08', '2015-10-11 13:56:08', NULL, 0),
(182, 1, 132, 'normal login to the system', 132, '2015-10-11 13:56:15', '2015-10-11 13:56:15', NULL, 0),
(183, 4, 132, 'registered member with username :  shadywallasssadre', 137, '2015-10-11 15:59:04', '2015-10-11 15:59:04', NULL, 0),
(184, 1, 3, 'normal login to the system', 3, '2015-10-13 12:47:12', '2015-10-13 12:47:12', NULL, 0),
(185, 2, 3, 'Logout to the system', 3, '2015-10-13 13:40:53', '2015-10-13 13:40:53', NULL, 0),
(186, 1, 3, 'normal login to the system', 3, '2015-10-13 14:09:34', '2015-10-13 14:09:34', NULL, 0),
(187, 1, 132, 'normal login to the system', 132, '2015-10-27 13:29:54', '2015-10-27 13:29:54', NULL, 0),
(188, 1, 3, 'normal login to the system', 3, '2015-11-02 13:42:32', '2015-11-02 13:42:32', NULL, 0),
(189, 1, 98, 'normal login to the system', 98, '2015-11-03 07:38:22', '2015-11-03 07:38:22', NULL, 0),
(190, 1, 98, 'normal login to the system', 98, '2015-11-03 08:11:33', '2015-11-03 08:11:33', NULL, 0),
(191, 2, 98, 'Logout to the system', 98, '2015-11-03 08:11:37', '2015-11-03 08:11:37', NULL, 0),
(192, 1, 3, 'normal login to the system', 3, '2015-11-03 08:11:42', '2015-11-03 08:11:42', NULL, 0),
(193, 1, 3, 'normal login to the system', 3, '2015-11-03 10:17:42', '2015-11-03 10:17:42', NULL, 0),
(194, 1, 3, 'normal login to the system', 3, '2015-11-03 10:57:51', '2015-11-03 10:57:51', NULL, 0),
(195, 1, 3, 'normal login to the system', 3, '2015-11-03 11:24:20', '2015-11-03 11:24:20', NULL, 0),
(196, 1, 3, 'normal login to the system', 3, '2015-11-04 08:56:23', '2015-11-04 08:56:23', NULL, 0),
(197, 1, 3, 'normal login to the system', 3, '2015-11-04 11:36:49', '2015-11-04 11:36:49', NULL, 0),
(198, 1, 3, 'normal login to the system', 3, '2015-11-04 13:19:53', '2015-11-04 13:19:53', NULL, 0),
(199, 1, 3, 'normal login to the system', 3, '2015-11-08 08:20:15', '2015-11-08 08:20:15', NULL, 0),
(200, 1, 3, 'normal login to the system', 3, '2015-11-08 10:02:43', '2015-11-08 10:02:43', NULL, 0),
(201, 1, 3, 'normal login to the system', 3, '2015-11-08 11:49:15', '2015-11-08 11:49:15', NULL, 0),
(202, 1, 3, 'normal login to the system', 3, '2015-11-10 14:31:23', '2015-11-10 14:31:23', NULL, 0),
(203, 1, 3, 'normal login to the system', 3, '2015-11-10 15:52:54', '2015-11-10 15:52:54', NULL, 0),
(204, 1, 3, 'normal login to the system', 3, '2015-11-10 16:28:46', '2015-11-10 16:28:46', NULL, 0),
(205, 2, 3, 'Logout to the system', 3, '2015-11-10 16:35:56', '2015-11-10 16:35:56', NULL, 0),
(206, 1, 3, 'normal login to the system', 3, '2015-11-10 16:36:01', '2015-11-10 16:36:01', NULL, 0),
(207, 1, 3, 'normal login to the system', 3, '2015-11-10 17:53:42', '2015-11-10 17:53:42', NULL, 0),
(208, 1, 3, 'normal login to the system', 3, '2015-11-15 10:23:18', '2015-11-15 10:23:18', NULL, 0),
(209, 4, 3, 'registered member with username :  shadywallas3456345', 188, '2015-11-15 10:33:51', '2015-11-15 10:33:51', NULL, 0),
(210, 11, 3, 'bypassed Payment for the user with username :  shadywallas3456345', 188, '2015-11-15 10:33:51', '2015-11-15 10:33:51', NULL, 0),
(211, 12, 3, 'bypassed notification for the user with username :  shadywallas3456345', 188, '2015-11-15 10:33:51', '2015-11-15 10:33:51', NULL, 0),
(212, 4, 3, 'registered member with username :  adsfasdf sdfsdfasdf', 189, '2015-11-15 10:35:31', '2015-11-15 10:35:31', NULL, 0),
(213, 13, 3, '[]', 189, '2015-11-15 10:35:31', '2015-11-15 10:35:31', NULL, 0),
(214, 4, 3, 'registered member with username :  fasdfsadf15sd6f1aasdfasdf', 190, '2015-11-15 11:36:54', '2015-11-15 11:36:54', NULL, 0),
(215, 13, 3, '{}', 190, '2015-11-15 11:36:54', '2015-11-15 11:36:54', NULL, 0),
(216, 4, 3, 'registered member with username :  fasdfsads9f15sd6f1as', 192, '2015-11-15 11:45:39', '2015-11-15 11:45:39', NULL, 0),
(217, 13, 3, '{}', 192, '2015-11-15 11:45:39', '2015-11-15 11:45:39', NULL, 0),
(218, 4, 3, 'registered member with username :  dfasdfasdfasd', 193, '2015-11-15 11:49:34', '2015-11-15 11:49:34', NULL, 0),
(219, 13, 3, '{}', 193, '2015-11-15 11:49:34', '2015-11-15 11:49:34', NULL, 0),
(220, 4, 3, 'registered member with username :  dfasdfasdfasds', 194, '2015-11-15 11:51:50', '2015-11-15 11:51:50', NULL, 0),
(221, 4, 3, 'registered member with username :  fasdfsadf15sd6f1as', 195, '2015-11-15 12:59:24', '2015-11-15 12:59:24', NULL, 0),
(222, 4, 3, 'registered member with username :  fasdfssadf15sd6f1as', 196, '2015-11-15 13:02:26', '2015-11-15 13:02:26', NULL, 0),
(223, 4, 3, 'registered member with username :  sdfafasdfssadf15sd6f1as', 197, '2015-11-15 13:04:33', '2015-11-15 13:04:33', NULL, 0),
(224, 4, 3, 'registered member with username :  sdfafaasdfsdfssadf15sd6f1as', 198, '2015-11-15 13:06:00', '2015-11-15 13:06:00', NULL, 0),
(225, 13, 3, '{"id":"ch_177QCgFzyYJMdSqeSuWYgxZH","object":"charge","amount":10000,"amount_refunded":0,"application_fee":null,"balance_transaction":"txn_177QCgFzyYJMdSqexRcnODIw","captured":true,"created":1447592758,"currency":"eur","customer":null,"description":null,"destination":null,"dispute":null,"failure_code":null,"failure_message":null,"fraud_details":[],"invoice":null,"livemode":false,"metadata":{},"paid":true,"receipt_email":null,"receipt_number":null,"refunded":false,"refunds":{},"shipping":null,"source":{},"statement_descriptor":null,"status":"succeeded"}', 198, '2015-11-15 13:06:00', '2015-11-15 13:06:00', NULL, 0),
(226, 4, 3, 'registered member with username :  fasdfasdfsadf15sd6f1as', 200, '2015-11-15 13:10:55', '2015-11-15 13:10:55', NULL, 0),
(227, 13, 3, '{"id":"ch_177QHRFzyYJMdSqeJVHmsMlX","object":"charge","amount":10000,"amount_refunded":0,"application_fee":null,"balance_transaction":"txn_177QHRFzyYJMdSqe2TBoQihD","captured":true,"created":1447593053,"currency":"eur","customer":null,"description":null,"destination":null,"dispute":null,"failure_code":null,"failure_message":null,"fraud_details":[],"invoice":null,"livemode":false,"metadata":{},"paid":true,"receipt_email":null,"receipt_number":null,"refunded":false,"refunds":{},"shipping":null,"source":{},"statement_descriptor":null,"status":"succeeded"}', 200, '2015-11-15 13:10:55', '2015-11-15 13:10:55', NULL, 0),
(228, 4, 3, 'registered member with username :  fasdfsdsafadf15sd6f1as', 202, '2015-11-15 13:11:50', '2015-11-15 13:11:50', NULL, 0),
(229, 13, 3, '{"amount":0,"currency":"eur","card":"tok_177QILFzyYJMdSqeGKI2OO3M"}', 202, '2015-11-15 13:11:50', '2015-11-15 13:11:50', NULL, 0),
(230, 4, 3, 'registered member with username :  fasdasdfasdffsdgfsdfsadf15sd6f1as', 205, '2015-11-15 13:16:13', '2015-11-15 13:16:13', NULL, 0),
(231, 11, 3, 'bypassed Payment for the user with username :  fasdasdfasdffsdgfsdfsadf15sd6f1as', 205, '2015-11-15 13:16:13', '2015-11-15 13:16:13', NULL, 0),
(232, 1, 3, 'normal login to the system', 3, '2015-11-16 08:23:42', '2015-11-16 08:23:42', NULL, 0),
(233, 1, 3, 'normal login to the system', 3, '2015-11-18 10:01:39', '2015-11-18 10:01:39', NULL, 0),
(234, 1, 3, 'normal login to the system', 3, '2015-11-18 11:43:05', '2015-11-18 11:43:05', NULL, 0),
(235, 1, 3, 'normal login to the system', 3, '2015-11-19 09:45:37', '2015-11-19 09:45:37', NULL, 0),
(236, 1, 122, 'Force Login by test username', 122, '2015-11-19 13:00:23', '2015-11-19 13:00:23', NULL, 0),
(237, 2, 122, 'Logout to the system', 122, '2015-11-19 13:19:05', '2015-11-19 13:19:05', NULL, 0),
(238, 1, 3, 'normal login to the system', 3, '2015-11-19 13:19:08', '2015-11-19 13:19:08', NULL, 0),
(239, 1, 3, 'normal login to the system', 3, '2015-11-22 09:35:06', '2015-11-22 09:35:06', NULL, 0),
(240, 1, 3, 'normal login to the system', 3, '2015-11-22 10:06:49', '2015-11-22 10:06:49', NULL, 0),
(241, 2, 3, 'Logout to the system', 3, '2015-11-22 10:13:07', '2015-11-22 10:13:07', NULL, 0),
(242, 1, 3, 'normal login to the system', 3, '2015-11-22 10:13:10', '2015-11-22 10:13:10', NULL, 0),
(243, 1, 3, 'normal login to the system', 3, '2015-11-22 11:35:06', '2015-11-22 11:35:06', NULL, 0),
(244, 1, 3, 'normal login to the system', 3, '2015-11-23 14:28:52', '2015-11-23 14:28:52', NULL, 0),
(245, 1, 3, 'normal login to the system', 3, '2015-12-01 18:15:28', '2015-12-01 18:15:28', NULL, 0),
(246, 1, 3, 'normal login to the system', 3, '2015-12-02 11:27:47', '2015-12-02 11:27:47', NULL, 0),
(247, 1, 117, 'normal login to the system', 117, '2015-12-15 15:32:08', '2015-12-15 15:32:08', NULL, 0),
(248, 1, 98, 'normal login to the system', 98, '2015-12-15 16:10:36', '2015-12-15 16:10:36', NULL, 0),
(249, 2, 98, 'Logout to the system', 98, '2015-12-15 16:11:27', '2015-12-15 16:11:27', NULL, 0),
(250, 1, 3, 'normal login to the system', 3, '2015-12-15 16:11:30', '2015-12-15 16:11:30', NULL, 0),
(251, 2, 3, 'Logout to the system', 3, '2015-12-15 16:11:52', '2015-12-15 16:11:52', NULL, 0),
(252, 1, 3, 'normal login to the system', 3, '2015-12-15 16:11:55', '2015-12-15 16:11:55', NULL, 0),
(253, 1, 3, 'normal login to the system', 3, '2015-12-16 08:51:53', '2015-12-16 08:51:53', NULL, 0),
(254, 1, 3, 'normal login to the system', 3, '2015-12-22 12:42:47', '2015-12-22 12:42:47', NULL, 0),
(255, 1, 3, 'normal login to the system', 3, '2015-12-22 15:09:06', '2015-12-22 15:09:06', NULL, 0),
(256, 1, 3, 'normal login to the system', 3, '2015-12-30 10:24:36', '2015-12-30 10:24:36', NULL, 0),
(257, 1, 3, 'normal login to the system', 3, '2015-12-30 13:00:15', '2015-12-30 13:00:15', NULL, 0),
(258, 1, 3, 'normal login to the system', 3, '2016-01-11 14:59:15', '2016-01-11 14:59:15', NULL, 0),
(259, 1, 3, 'normal login to the system', 3, '2016-01-12 08:43:54', '2016-01-12 08:43:54', NULL, 0),
(260, 1, 3, 'normal login to the system', 3, '2016-01-18 09:42:45', '2016-01-18 09:42:45', NULL, 0),
(261, 1, 3, 'normal login to the system', 3, '2016-02-01 08:30:24', '2016-02-01 08:30:24', NULL, 0),
(262, 1, 3, 'normal login to the system', 3, '2016-02-02 10:45:49', '2016-02-02 10:45:49', NULL, 0),
(263, 2, 3, 'Logout to the system', 3, '2016-02-02 11:00:00', '2016-02-02 11:00:00', NULL, 0),
(264, 1, 207, 'normal login to the system', 207, '2016-02-02 11:01:03', '2016-02-02 11:01:03', NULL, 0),
(265, 2, 207, 'Logout to the system', 207, '2016-02-02 11:11:11', '2016-02-02 11:11:11', NULL, 0),
(266, 1, 3, 'normal login to the system', 3, '2016-02-02 11:11:16', '2016-02-02 11:11:16', NULL, 0),
(267, 2, 3, 'Logout to the system', 3, '2016-02-02 11:13:25', '2016-02-02 11:13:25', NULL, 0),
(268, 1, 207, 'normal login to the system', 207, '2016-02-02 11:13:31', '2016-02-02 11:13:31', NULL, 0),
(269, 2, 207, 'Logout to the system', 207, '2016-02-02 11:18:21', '2016-02-02 11:18:21', NULL, 0),
(270, 1, 3, 'normal login to the system', 3, '2016-02-02 11:18:26', '2016-02-02 11:18:26', NULL, 0),
(271, 2, 3, 'Logout to the system', 3, '2016-02-02 11:20:35', '2016-02-02 11:20:35', NULL, 0),
(272, 1, 123, 'normal login to the system', 123, '2016-02-02 11:21:44', '2016-02-02 11:21:44', NULL, 0),
(273, 2, 123, 'Logout to the system', 123, '2016-02-07 17:03:30', '2016-02-07 17:03:30', NULL, 0),
(274, 1, 207, 'normal login to the system', 207, '2016-02-07 17:03:42', '2016-02-07 17:03:42', NULL, 0),
(275, 2, 207, 'Logout to the system', 207, '2016-02-07 17:46:33', '2016-02-07 17:46:33', NULL, 0),
(276, 1, 3, 'normal login to the system', 3, '2016-02-07 17:46:40', '2016-02-07 17:46:40', NULL, 0),
(277, 1, 3, 'normal login to the system', 3, '2016-02-08 13:33:11', '2016-02-08 13:33:11', NULL, 0),
(278, 1, 3, 'normal login to the system', 3, '2016-02-10 11:15:13', '2016-02-10 11:15:13', NULL, 0),
(279, 1, 3, 'normal login to the system', 3, '2016-03-06 14:06:49', '2016-03-06 14:06:49', NULL, 0),
(280, 4, 3, 'registered member with username :  shadywallas', 252, '2016-03-06 14:31:58', '2016-03-06 14:31:58', NULL, 0),
(281, 13, 3, '{"id":"ch_17m2vIB75lTuLEBiNJpBT4Lc","object":"charge","amount":1439,"amount_refunded":0,"application_fee":null,"balance_transaction":"txn_17m2vIB75lTuLEBiQMfpQM7J","captured":true,"created":1457274716,"currency":"eur","customer":null,"description":null,"destination":null,"dispute":null,"failure_code":null,"failure_message":null,"fraud_details":[],"invoice":null,"livemode":false,"metadata":{},"order":null,"paid":true,"receipt_email":null,"receipt_number":null,"refunded":false,"refunds":{},"shipping":null,"source":{},"source_transfer":null,"statement_descriptor":null,"status":"succeeded"}', 252, '2016-03-06 14:31:59', '2016-03-06 14:31:59', NULL, 0),
(282, 1, 3, 'normal login to the system', 3, '2016-03-22 15:28:11', '2016-03-22 15:28:11', NULL, 0),
(283, 1, 3, 'normal login to the system', 3, '2016-03-24 10:29:52', '2016-03-24 10:29:52', NULL, 0),
(284, 1, 3, 'normal login to the system', 3, '2016-04-10 11:18:28', '2016-04-10 11:18:28', NULL, 0),
(285, 1, 248, 'Force Login by test username', 248, '2016-04-10 11:19:22', '2016-04-10 11:19:22', NULL, 0),
(286, 1, 3, 'Force Login by vms_auto', 3, '2016-04-10 11:24:48', '2016-04-10 11:24:48', NULL, 0),
(287, 1, 248, 'Force Login by test username', 248, '2016-04-10 11:36:25', '2016-04-10 11:36:25', NULL, 0),
(288, 1, 3, 'Force Login by vms_auto', 3, '2016-04-10 13:21:22', '2016-04-10 13:21:22', NULL, 0),
(289, 1, 248, 'Force Login by test username', 248, '2016-04-10 14:22:07', '2016-04-10 14:22:07', NULL, 0),
(290, 1, 3, 'Force Login by vms_auto', 3, '2016-04-10 14:22:15', '2016-04-10 14:22:15', NULL, 0),
(291, 1, 199, 'Force Login by test username', 199, '2016-04-10 14:22:26', '2016-04-10 14:22:26', NULL, 0),
(292, 1, 3, 'Force Login by mfayez', 3, '2016-04-10 14:22:32', '2016-04-10 14:22:32', NULL, 0),
(293, 1, 3, 'normal login to the system', 3, '2016-04-25 12:57:03', '2016-04-25 12:57:03', NULL, 0),
(294, 1, 3, 'normal login to the system', 3, '2016-06-16 12:12:36', '2016-06-16 12:12:36', NULL, 0),
(295, 1, 3, 'normal login to the system', 3, '2016-09-06 16:14:39', '2016-09-06 16:14:39', NULL, 0),
(296, 2, 3, 'Logout to the system', 3, '2016-09-06 16:14:45', '2016-09-06 16:14:45', NULL, 0),
(297, 1, 3, 'normal login to the system', 3, '2016-10-13 11:01:36', '2016-10-13 11:01:36', NULL, 0),
(298, 1, 3, 'normal login to the system', 3, '2017-01-08 16:46:51', '2017-01-08 16:46:51', NULL, 0),
(299, 1, 3, 'normal login to the system', 3, '2017-04-10 17:01:38', '2017-04-10 17:01:38', NULL, 0),
(300, 2, 3, 'Logout to the system', 3, '2017-04-10 17:02:14', '2017-04-10 17:02:14', NULL, 0),
(301, 1, 3, 'normal login to the system', 3, '2017-05-10 14:13:46', '2017-05-10 14:13:46', NULL, 0),
(302, 1, 88, 'Force Login by test username', 88, '2017-05-10 14:15:24', '2017-05-10 14:15:24', NULL, 0),
(303, 1, 3, 'Force Login by johndowling', 3, '2017-05-10 14:15:28', '2017-05-10 14:15:28', NULL, 0),
(304, 1, 70, 'Force Login by test username', 70, '2017-05-10 14:15:46', '2017-05-10 14:15:46', NULL, 0),
(305, 1, 3, 'Force Login by kimshadycustomer', 3, '2017-05-10 14:15:48', '2017-05-10 14:15:48', NULL, 0),
(306, 1, 248, 'Force Login by test username', 248, '2017-05-10 14:16:00', '2017-05-10 14:16:00', NULL, 0),
(307, 1, 3, 'normal login to the system', 3, '2017-05-11 13:15:30', '2017-05-11 13:15:30', NULL, 0),
(308, 1, 3, 'normal login to the system', 3, '2017-05-11 17:31:02', '2017-05-11 17:31:02', NULL, 0),
(309, 1, 3, 'normal login to the system', 3, '2017-05-14 11:21:21', '2017-05-14 11:21:21', NULL, 0),
(310, 1, 3, 'normal login to the system', 3, '2017-05-14 14:43:40', '2017-05-14 14:43:40', NULL, 0),
(311, 1, 3, 'normal login to the system', 3, '2017-05-15 13:57:01', '2017-05-15 13:57:01', NULL, 0),
(312, 14, 3, 'Renewed a membership with id : M08W1605 & vehicle registration : 08W1605', 3, '2017-05-15 14:02:17', '2017-05-15 14:02:17', NULL, 0),
(313, 1, 3, 'normal login to the system', 3, '2017-05-15 19:49:38', '2017-05-15 19:49:38', NULL, 0),
(314, 1, 3, 'normal login to the system', 3, '2017-05-16 14:50:26', '2017-05-16 14:50:26', NULL, 0),
(315, 1, 3, 'normal login to the system', 3, '2017-05-16 19:46:28', '2017-05-16 19:46:28', NULL, 0),
(316, 1, 3, 'normal login to the system', 3, '2017-05-17 12:47:04', '2017-05-17 12:47:04', NULL, 0),
(317, 1, 3, 'normal login to the system', 3, '2017-05-23 15:57:12', '2017-05-23 15:57:12', NULL, 0),
(318, 1, 3, 'normal login to the system', 3, '2017-05-25 16:49:11', '2017-05-25 16:49:11', NULL, 0),
(319, 1, 3, 'normal login to the system', 3, '2017-05-31 14:14:01', '2017-05-31 14:14:01', NULL, 0),
(320, 1, 3, 'normal login to the system', 3, '2017-06-12 14:09:30', '2017-06-12 14:09:30', NULL, 0),
(321, 1, 3, 'normal login to the system', 3, '2017-06-14 13:05:00', '2017-06-14 13:05:00', NULL, 0),
(322, 1, 3, 'normal login to the system', 3, '2017-06-15 12:43:02', '2017-06-15 12:43:02', NULL, 0),
(323, 1, 3, 'normal login to the system', 3, '2017-06-18 11:55:58', '2017-06-18 11:55:58', NULL, 0),
(324, 1, 3, 'normal login to the system', 3, '2017-06-19 11:57:18', '2017-06-19 11:57:18', NULL, 0),
(325, 1, 3, 'normal login to the system', 3, '2017-06-20 12:24:51', '2017-06-20 12:24:51', NULL, 0),
(326, 1, 3, 'normal login to the system', 3, '2017-06-21 12:32:34', '2017-06-21 12:32:34', NULL, 0),
(327, 1, 3, 'normal login to the system', 3, '2017-06-22 10:05:43', '2017-06-22 10:05:43', NULL, 0),
(328, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-06-22 10:54:38', '2017-06-22 10:54:38', NULL, 0),
(329, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-06-22 10:54:38', '2017-06-22 10:54:38', NULL, 0),
(330, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-06-22 11:41:22', '2017-06-22 11:41:22', NULL, 0),
(331, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-06-22 11:41:22', '2017-06-22 11:41:22', NULL, 0),
(332, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-06-22 12:55:22', '2017-06-22 12:55:22', NULL, 0),
(333, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-06-22 12:55:22', '2017-06-22 12:55:22', NULL, 0),
(334, 4, 3, 'Fleet member registered with vehicle reg :  v55', 262, '2017-06-22 13:02:04', '2017-06-22 13:02:04', NULL, 0),
(335, 4, 3, 'Fleet member registered with vehicle reg :  v555', 262, '2017-06-22 13:02:04', '2017-06-22 13:02:04', NULL, 0),
(336, 4, 3, 'Fleet member registered with vehicle reg :  v55', 262, '2017-06-22 13:02:53', '2017-06-22 13:02:53', NULL, 0),
(337, 4, 3, 'Fleet member registered with vehicle reg :  v555', 262, '2017-06-22 13:02:53', '2017-06-22 13:02:53', NULL, 0),
(338, 1, 3, 'normal login to the system', 3, '2017-06-28 16:44:00', '2017-06-28 16:44:00', NULL, 0),
(339, 2, 3, 'Logout to the system', 3, '2017-06-28 16:59:34', '2017-06-28 16:59:34', NULL, 0),
(340, 1, 3, 'normal login to the system', 3, '2017-06-28 17:19:19', '2017-06-28 17:19:19', NULL, 0),
(341, 2, 3, 'Logout to the system', 3, '2017-06-28 17:19:26', '2017-06-28 17:19:26', NULL, 0),
(342, 1, 3, 'normal login to the system', 3, '2017-06-28 17:19:41', '2017-06-28 17:19:41', NULL, 0),
(343, 1, 3, 'normal login to the system', 3, '2017-07-04 10:40:25', '2017-07-04 10:40:25', NULL, 0),
(344, 1, 3, 'normal login to the system', 3, '2017-07-05 13:25:56', '2017-07-05 13:25:56', NULL, 0),
(345, 1, 3, 'normal login to the system', 3, '2017-07-05 16:54:44', '2017-07-05 16:54:44', NULL, 0),
(346, 4, 3, 'Fleet member registered with vehicle reg :  v23', 262, '2017-07-05 21:52:31', '2017-07-05 21:52:31', NULL, 0),
(347, 1, 3, 'normal login to the system', 3, '2017-07-06 10:03:26', '2017-07-06 10:03:26', NULL, 0),
(348, 1, 3, 'normal login to the system', 3, '2017-07-06 12:43:53', '2017-07-06 12:43:53', NULL, 0),
(349, 1, 3, 'normal login to the system', 3, '2017-07-09 11:14:45', '2017-07-09 11:14:45', NULL, 0),
(350, 1, 3, 'normal login to the system', 3, '2017-07-09 11:16:12', '2017-07-09 11:16:12', NULL, 0),
(351, 1, 3, 'normal login to the system', 3, '2017-07-09 18:35:05', '2017-07-09 18:35:05', NULL, 0),
(352, 1, 3, 'normal login to the system', 3, '2017-07-10 12:48:40', '2017-07-10 12:48:40', NULL, 0),
(353, 1, 3, 'normal login to the system', 3, '2017-07-10 18:04:44', '2017-07-10 18:04:44', NULL, 0),
(354, 14, 3, 'Renewed a membership with id : Mv5 & vehicle registration : v5', 3, '2017-07-10 18:36:34', '2017-07-10 18:36:34', NULL, 0),
(355, 13, 3, '{"id":"ch_1Ae6kHB75lTuLEBimWyR2SPc","object":"charge","amount":100,"amount_refunded":0,"application":null,"application_fee":null,"balance_transaction":"txn_1Ae6kIB75lTuLEBibGlerN3n","captured":true,"created":1499711793,"currency":"eur","customer":null,"description":null,"destination":null,"dispute":null,"failure_code":null,"failure_message":null,"fraud_details":[],"invoice":null,"livemode":false,"metadata":{},"on_behalf_of":null,"order":null,"outcome":{},"paid":true,"receipt_email":null,"receipt_number":null,"refunded":false,"refunds":{},"review":null,"shipping":null,"source":{},"source_transfer":null,"statement_descriptor":null,"status":"succeeded","transfer_group":null}', 3, '2017-07-10 18:36:34', '2017-07-10 18:36:34', NULL, 0),
(356, 14, 3, 'Renewed a membership with id : Mv5 & vehicle registration : v5', 3, '2017-07-10 18:43:32', '2017-07-10 18:43:32', NULL, 0),
(357, 13, 3, '{"id":"ch_1Ae6r2B75lTuLEBiPjuSlMHC","object":"charge","amount":100,"amount_refunded":0,"application":null,"application_fee":null,"balance_transaction":"txn_1Ae6r2B75lTuLEBins8aM8YK","captured":true,"created":1499712212,"currency":"eur","customer":null,"description":null,"destination":null,"dispute":null,"failure_code":null,"failure_message":null,"fraud_details":[],"invoice":null,"livemode":false,"metadata":{},"on_behalf_of":null,"order":null,"outcome":{},"paid":true,"receipt_email":null,"receipt_number":null,"refunded":false,"refunds":{},"review":null,"shipping":null,"source":{},"source_transfer":null,"statement_descriptor":null,"status":"succeeded","transfer_group":null}', 3, '2017-07-10 18:43:32', '2017-07-10 18:43:32', NULL, 0),
(358, 14, 3, 'Renewed a membership with id : Mv5 & vehicle registration : v5', 3, '2017-07-10 18:46:42', '2017-07-10 18:46:42', NULL, 0),
(359, 11, 3, 'bypassed Payment for the user with username :  test username', 3, '2017-07-10 18:46:42', '2017-07-10 18:46:42', NULL, 0),
(360, 1, 3, 'normal login to the system', 3, '2017-07-12 11:24:55', '2017-07-12 11:24:55', NULL, 0),
(361, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-12 14:03:38', '2017-07-12 14:03:38', NULL, 0),
(362, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-12 14:04:25', '2017-07-12 14:04:25', NULL, 0),
(363, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-12 14:11:48', '2017-07-12 14:11:48', NULL, 0),
(364, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-12 14:16:10', '2017-07-12 14:16:10', NULL, 0),
(365, 4, 3, 'Fleet member registered with vehicle reg :  v5', 200, '2017-07-12 19:13:52', '2017-07-12 19:13:52', NULL, 0),
(366, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-12 20:31:44', '2017-07-12 20:31:44', NULL, 0),
(367, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-12 20:40:50', '2017-07-12 20:40:50', NULL, 0),
(368, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-12 20:43:52', '2017-07-12 20:43:52', NULL, 0),
(369, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-12 20:47:48', '2017-07-12 20:47:48', NULL, 0),
(370, 1, 3, 'normal login to the system', 3, '2017-07-13 09:57:30', '2017-07-13 09:57:30', NULL, 0),
(371, 1, 3, 'normal login to the system', 3, '2017-07-13 10:04:07', '2017-07-13 10:04:07', NULL, 0),
(372, 4, 3, 'Fleet member registered with vehicle reg :  v5', 89, '2017-07-13 12:41:29', '2017-07-13 12:41:29', NULL, 0),
(373, 4, 3, 'Fleet member registered with vehicle reg :  v5', 89, '2017-07-13 12:42:56', '2017-07-13 12:42:56', NULL, 0),
(374, 4, 3, 'Fleet member registered with vehicle reg :  v5', 89, '2017-07-13 12:43:31', '2017-07-13 12:43:31', NULL, 0),
(375, 4, 3, 'Fleet member registered with vehicle reg :  v5', 262, '2017-07-13 13:13:18', '2017-07-13 13:13:18', NULL, 0),
(376, 1, 3, 'normal login to the system', 3, '2017-07-16 13:46:13', '2017-07-16 13:46:13', NULL, 0),
(377, 1, 3, 'normal login to the system', 3, '2017-07-17 18:44:28', '2017-07-17 18:44:28', NULL, 0),
(378, 1, 3, 'normal login to the system', 3, '2017-07-18 17:28:49', '2017-07-18 17:28:49', NULL, 0),
(379, 2, 3, 'Logout to the system', 3, '2017-07-18 17:36:18', '2017-07-18 17:36:18', NULL, 0),
(380, 1, 3, 'normal login to the system', 3, '2017-07-20 11:55:31', '2017-07-20 11:55:31', NULL, 0),
(381, 1, 3, 'normal login to the system', 3, '2017-07-20 16:31:28', '2017-07-20 16:31:28', NULL, 0),
(382, 1, 3, 'normal login to the system', 3, '2017-07-25 14:02:23', '2017-07-25 14:02:23', NULL, 0),
(383, 1, 3, 'normal login to the system', 3, '2017-07-26 11:48:57', '2017-07-26 11:48:57', NULL, 0),
(384, 1, 3, 'normal login to the system', 3, '2017-07-26 18:15:51', '2017-07-26 18:15:51', NULL, 0),
(385, 1, 263, 'normal login to the system', 263, '2017-07-27 12:15:52', '2017-07-27 12:15:52', NULL, 0),
(386, 2, 263, 'Logout to the system', 263, '2017-07-27 12:17:40', '2017-07-27 12:17:40', NULL, 0),
(387, 1, 3, 'normal login to the system', 3, '2017-07-27 12:18:23', '2017-07-27 12:18:23', NULL, 0),
(388, 1, 3, 'normal login to the system', 3, '2017-08-01 16:21:25', '2017-08-01 16:21:25', NULL, 0),
(389, 1, 3, 'normal login to the system', 3, '2017-08-13 18:31:13', '2017-08-13 18:31:13', NULL, 0),
(390, 2, 3, 'Logout to the system', 3, '2017-08-13 18:34:59', '2017-08-13 18:34:59', NULL, 0),
(391, 1, 264, 'normal login to the system', 264, '2017-08-13 18:35:40', '2017-08-13 18:35:40', NULL, 0),
(392, 1, 3, 'normal login to the system', 3, '2017-08-14 17:43:21', '2017-08-14 17:43:21', NULL, 0),
(393, 1, 3, 'normal login to the system', 3, '2017-09-14 19:15:04', '2017-09-14 19:15:04', NULL, 0),
(394, 1, 3, 'normal login to the system', 3, '2017-09-20 12:02:20', '2017-09-20 12:02:20', NULL, 0),
(395, 1, 3, 'normal login to the system', 3, '2017-09-20 16:05:19', '2017-09-20 16:05:19', NULL, 0),
(396, 1, 3, 'normal login to the system', 3, '2017-09-20 18:13:10', '2017-09-20 18:13:10', NULL, 0),
(397, 2, 3, 'Logout to the system', 3, '2017-09-20 18:18:48', '2017-09-20 18:18:48', NULL, 0),
(398, 1, 264, 'normal login to the system', 264, '2017-09-20 18:23:04', '2017-09-20 18:23:04', NULL, 0),
(399, 1, 3, 'normal login to the system', 3, '2017-09-21 10:22:37', '2017-09-21 10:22:37', NULL, 0),
(400, 1, 3, 'normal login to the system', 3, '2017-09-24 14:50:04', '2017-09-24 14:50:04', NULL, 0),
(401, 1, 3, 'normal login to the system', 3, '2017-09-24 18:06:46', '2017-09-24 18:06:46', NULL, 0),
(402, 1, 3, 'normal login to the system', 3, '2017-09-26 12:53:25', '2017-09-26 12:53:25', NULL, 0),
(403, 2, 3, 'Logout to the system', 3, '2017-09-26 12:53:36', '2017-09-26 12:53:36', NULL, 0),
(404, 1, 3, 'normal login to the system', 3, '2017-09-26 12:54:00', '2017-09-26 12:54:00', NULL, 0),
(405, 2, 3, 'Logout to the system', 3, '2017-09-26 12:54:02', '2017-09-26 12:54:02', NULL, 0),
(406, 1, 3, 'normal login to the system', 3, '2017-09-26 12:54:14', '2017-09-26 12:54:14', NULL, 0),
(407, 1, 3, 'normal login to the system', 3, '2017-09-26 15:59:27', '2017-09-26 15:59:27', NULL, 0),
(408, 1, 3, 'normal login to the system', 3, '2017-09-26 19:33:00', '2017-09-26 19:33:00', NULL, 0),
(409, 1, 3, 'normal login to the system', 3, '2017-09-27 09:10:31', '2017-09-27 09:10:31', NULL, 0),
(410, 1, 3, 'normal login to the system', 3, '2017-09-27 15:32:57', '2017-09-27 15:32:57', NULL, 0),
(411, 1, 3, 'normal login to the system', 3, '2017-09-28 12:17:46', '2017-09-28 12:17:46', NULL, 0),
(412, 1, 3, 'normal login to the system', 3, '2017-10-01 13:42:11', '2017-10-01 13:42:11', NULL, 0),
(413, 1, 3, 'normal login to the system', 3, '2017-10-01 16:34:39', '2017-10-01 16:34:39', NULL, 0),
(414, 1, 3, 'normal login to the system', 3, '2017-10-02 12:16:59', '2017-10-02 12:16:59', NULL, 0),
(415, 1, 3, 'normal login to the system', 3, '2017-10-02 19:09:40', '2017-10-02 19:09:40', NULL, 0),
(416, 1, 3, 'normal login to the system', 3, '2017-10-03 20:02:38', '2017-10-03 20:02:38', NULL, 0),
(417, 1, 3, 'normal login to the system', 3, '2017-10-08 14:39:46', '2017-10-08 14:39:46', NULL, 0),
(418, 1, 3, 'normal login to the system', 3, '2017-10-16 13:08:09', '2017-10-16 13:08:09', NULL, 0),
(419, 1, 3, 'normal login to the system', 3, '2017-10-16 17:04:46', '2017-10-16 17:04:46', NULL, 0),
(420, 1, 3, 'normal login to the system', 3, '2017-10-19 17:06:44', '2017-10-19 17:06:44', NULL, 0),
(421, 1, 3, 'normal login to the system', 3, '2017-10-22 15:10:33', '2017-10-22 15:10:33', NULL, 0),
(422, 1, 3, 'normal login to the system', 3, '2017-10-23 12:57:48', '2017-10-23 12:57:48', NULL, 0),
(423, 1, 3, 'normal login to the system', 3, '2017-10-23 19:13:43', '2017-10-23 19:13:43', NULL, 0),
(424, 1, 3, 'normal login to the system', 3, '2017-10-24 15:40:17', '2017-10-24 15:40:17', NULL, 0),
(425, 1, 3, 'normal login to the system', 3, '2017-10-25 16:39:10', '2017-10-25 16:39:10', NULL, 0),
(426, 1, 3, 'normal login to the system', 3, '2017-10-25 20:22:32', '2017-10-25 20:22:32', NULL, 0),
(427, 1, 3, 'normal login to the system', 3, '2017-10-26 12:38:15', '2017-10-26 12:38:15', NULL, 0),
(428, 1, 3, 'normal login to the system', 3, '2017-10-26 17:50:26', '2017-10-26 17:50:26', NULL, 0),
(429, 1, 3, 'normal login to the system', 3, '2017-10-29 20:33:26', '2017-10-29 20:33:26', NULL, 0),
(430, 1, 3, 'normal login to the system', 3, '2017-10-31 18:23:03', '2017-10-31 18:23:03', NULL, 0),
(431, 2, 3, 'Logout to the system', 3, '2017-10-31 18:23:19', '2017-10-31 18:23:19', NULL, 0),
(432, 1, 264, 'normal login to the system', 264, '2017-10-31 18:23:36', '2017-10-31 18:23:36', NULL, 0),
(433, 1, 3, 'normal login to the system', 3, '2017-11-01 16:54:21', '2017-11-01 16:54:21', NULL, 0),
(434, 1, 3, 'normal login to the system', 3, '2017-11-02 14:14:52', '2017-11-02 14:14:52', NULL, 0),
(435, 2, 3, 'Logout to the system', 3, '2017-11-02 14:15:06', '2017-11-02 14:15:06', NULL, 0),
(436, 1, 264, 'normal login to the system', 264, '2017-11-02 14:19:44', '2017-11-02 14:19:44', NULL, 0),
(437, 2, 264, 'Logout to the system', 264, '2017-11-02 14:20:44', '2017-11-02 14:20:44', NULL, 0),
(438, 1, 264, 'normal login to the system', 264, '2017-11-02 14:21:26', '2017-11-02 14:21:26', NULL, 0),
(439, 1, 264, 'normal login to the system', 264, '2017-11-02 22:43:43', '2017-11-02 22:43:43', NULL, 0),
(440, 2, 264, 'Logout to the system', 264, '2017-11-02 22:55:58', '2017-11-02 22:55:58', NULL, 0),
(441, 1, 264, 'normal login to the system', 264, '2017-11-02 22:56:04', '2017-11-02 22:56:04', NULL, 0),
(442, 2, 264, 'Logout to the system', 264, '2017-11-02 23:11:52', '2017-11-02 23:11:52', NULL, 0),
(443, 1, 3, 'normal login to the system', 3, '2017-12-11 15:29:45', '2017-12-11 15:29:45', NULL, 0),
(444, 1, 3, 'normal login to the system', 3, '2017-12-13 16:06:28', '2017-12-13 16:06:28', NULL, 0),
(445, 1, 3, 'normal login to the system', 3, '2017-12-14 10:48:03', '2017-12-14 10:48:03', NULL, 0),
(446, 2, 3, 'Logout to the system', 3, '2017-12-14 11:11:26', '2017-12-14 11:11:26', NULL, 0),
(447, 1, 264, 'normal login to the system', 264, '2017-12-14 11:11:40', '2017-12-14 11:11:40', NULL, 0),
(448, 2, 264, 'Logout to the system', 264, '2017-12-14 11:11:56', '2017-12-14 11:11:56', NULL, 0),
(449, 1, 264, 'normal login to the system', 264, '2017-12-14 11:18:52', '2017-12-14 11:18:52', NULL, 0),
(450, 1, 264, 'normal login to the system', 264, '2017-12-14 15:08:46', '2017-12-14 15:08:46', NULL, 0),
(451, 1, 3, 'normal login to the system', 3, '2017-12-17 11:05:05', '2017-12-17 11:05:05', NULL, 0),
(452, 1, 3, 'normal login to the system', 3, '2017-12-17 14:47:48', '2017-12-17 14:47:48', NULL, 0),
(453, 1, 3, 'normal login to the system', 3, '2017-12-18 10:03:00', '2017-12-18 10:03:00', NULL, 0),
(454, 1, 3, 'normal login to the system', 3, '2017-12-19 11:08:16', '2017-12-19 11:08:16', NULL, 0),
(455, 1, 3, 'normal login to the system', 3, '2017-12-19 16:17:35', '2017-12-19 16:17:35', NULL, 0),
(456, 1, 3, 'normal login to the system', 3, '2017-12-20 09:46:32', '2017-12-20 09:46:32', NULL, 0),
(457, 1, 3, 'normal login to the system', 3, '2017-12-20 16:44:23', '2017-12-20 16:44:23', NULL, 0),
(458, 1, 3, 'normal login to the system', 3, '2017-12-21 11:20:27', '2017-12-21 11:20:27', NULL, 0),
(459, 1, 3, 'normal login to the system', 3, '2018-01-01 15:41:33', '2018-01-01 15:41:33', NULL, 0),
(460, 1, 3, 'normal login to the system', 3, '2018-01-02 10:06:13', '2018-01-02 10:06:13', NULL, 0),
(461, 1, 3, 'normal login to the system', 3, '2018-01-03 09:45:01', '2018-01-03 09:45:01', NULL, 0);
INSERT INTO `agent_activities` (`id`, `activity_type_id`, `entry_by`, `note`, `user_id`, `created_at`, `updated_at`, `created_at_integer`, `updated_at_integer`) VALUES
(462, 1, 3, 'normal login to the system', 3, '2018-01-04 09:28:43', '2018-01-04 09:28:43', NULL, 0),
(463, 2, 3, 'Logout to the system', 3, '2018-01-04 09:51:28', '2018-01-04 09:51:28', NULL, 0),
(464, 1, 264, 'normal login to the system', 264, '2018-01-04 09:51:34', '2018-01-04 09:51:34', NULL, 0),
(465, 2, 264, 'Logout to the system', 264, '2018-01-04 11:19:37', '2018-01-04 11:19:37', NULL, 0),
(466, 1, 3, 'normal login to the system', 3, '2018-01-04 11:19:41', '2018-01-04 11:19:41', NULL, 0),
(467, 1, 3, 'normal login to the system', 3, '2018-01-04 14:29:16', '2018-01-04 14:29:16', NULL, 0),
(468, 1, 3, 'normal login to the system', 3, '2018-01-08 12:47:24', '2018-01-08 12:47:24', NULL, 0),
(469, 1, 3, 'normal login to the system', 3, '2018-01-08 15:18:27', '2018-01-08 15:18:27', NULL, 0),
(470, 1, 3, 'normal login to the system', 3, '2018-01-09 13:07:50', '2018-01-09 13:07:50', NULL, 0),
(471, 1, 3, 'normal login to the system', 3, '2018-01-09 15:50:51', '2018-01-09 15:50:51', NULL, 0),
(472, 1, 3, 'normal login to the system', 3, '2018-01-10 14:16:25', '2018-01-10 14:16:25', NULL, 0),
(473, 1, 3, 'normal login to the system', 3, '2018-01-11 12:15:15', '2018-01-11 12:15:15', NULL, 0),
(474, 1, 3, 'normal login to the system', 3, '2018-01-16 10:54:31', '2018-01-16 10:54:31', NULL, 0),
(475, 1, 3, 'normal login to the system', 3, '2018-01-17 15:50:51', '2018-01-17 15:50:51', NULL, 0),
(476, 1, 3, 'normal login to the system', 3, '2018-01-21 15:24:10', '2018-01-21 15:24:10', NULL, 0),
(477, 1, 3, 'normal login to the system', 3, '2018-01-22 14:30:24', '2018-01-22 14:30:24', NULL, 0),
(478, 1, 3, 'normal login to the system', 3, '2018-01-23 12:39:55', '2018-01-23 12:39:55', NULL, 0),
(479, 1, 3, 'normal login to the system', 3, '2018-01-24 12:11:40', '2018-01-24 12:11:40', NULL, 0),
(480, 1, 3, 'normal login to the system', 3, '2018-01-24 16:12:56', '2018-01-24 16:12:56', NULL, 0),
(481, 1, 3, 'normal login to the system', 3, '2018-01-24 19:51:30', '2018-01-24 19:51:30', NULL, 0),
(482, 1, 3, 'normal login to the system', 3, '2018-02-01 10:57:24', '2018-02-01 10:57:24', NULL, 0),
(483, 1, 3, 'normal login to the system', 3, '2018-02-01 15:38:33', '2018-02-01 15:38:33', NULL, 0),
(484, 1, 3, 'normal login to the system', 3, '2018-02-04 10:13:44', '2018-02-04 10:13:44', NULL, 0),
(485, 2, 3, 'Logout to the system', 3, '2018-02-04 11:13:44', '2018-02-04 11:13:44', NULL, 0),
(486, 1, 3, 'normal login to the system', 3, '2018-02-06 14:00:32', '2018-02-06 14:00:32', NULL, 0),
(487, 1, 3, 'normal login to the system', 3, '2018-02-06 22:27:24', '2018-02-06 22:27:24', NULL, 0),
(488, 1, 3, 'normal login to the system', 3, '2018-02-07 09:35:51', '2018-02-07 09:35:51', NULL, 0),
(489, 1, 3, 'normal login to the system', 3, '2018-02-08 11:41:21', '2018-02-08 11:41:21', NULL, 0),
(490, 1, 3, 'normal login to the system', 3, '2018-02-12 14:11:22', '2018-02-12 14:11:22', NULL, 0),
(491, 1, 3, 'normal login to the system', 3, '2018-02-13 16:57:26', '2018-02-13 16:57:26', NULL, 0),
(492, 1, 3, 'normal login to the system', 3, '2018-02-20 15:29:57', '2018-02-20 15:29:57', NULL, 0),
(493, 1, 3, 'normal login to the system', 3, '2018-02-21 11:02:47', '2018-02-21 11:02:47', NULL, 0),
(494, 1, 3, 'normal login to the system', 3, '2018-02-21 15:57:58', '2018-02-21 15:57:58', NULL, 0),
(495, 1, 3, 'normal login to the system', 3, '2018-02-22 09:56:12', '2018-02-22 09:56:12', NULL, 0),
(496, 1, 3, 'normal login to the system', 3, '2018-02-22 16:29:31', '2018-02-22 16:29:31', NULL, 0),
(497, 1, 3, 'normal login to the system', 3, '2018-02-25 10:48:11', '2018-02-25 10:48:11', NULL, 0),
(498, 1, 3, 'normal login to the system', 3, '2018-02-26 11:52:55', '2018-02-26 11:52:55', NULL, 0),
(499, 2, 3, 'Logout to the system', 3, '2018-02-26 11:53:02', '2018-02-26 11:53:02', NULL, 0),
(500, 1, 3, 'normal login to the system', 3, '2018-03-01 11:08:36', '2018-03-01 11:08:36', NULL, 0),
(501, 1, 3, 'normal login to the system', 3, '2018-03-04 11:21:49', '2018-03-04 11:21:49', NULL, 0),
(502, 1, 3, 'normal login to the system', 3, '2018-03-05 10:17:19', '2018-03-05 10:17:19', NULL, 0),
(503, 1, 3, 'normal login to the system', 3, '2018-03-05 13:16:44', '2018-03-05 13:16:44', NULL, 0),
(504, 1, 3, 'normal login to the system', 3, '2018-03-05 15:25:37', '2018-03-05 15:25:37', NULL, 0),
(505, 1, 3, 'normal login to the system', 3, '2018-03-05 22:19:47', '2018-03-05 22:19:47', NULL, 0),
(506, 1, 3, 'normal login to the system', 3, '2018-03-06 10:07:29', '2018-03-06 10:07:29', NULL, 0),
(507, 1, 3, 'normal login to the system', 3, '2018-03-07 10:27:51', '2018-03-07 10:27:51', NULL, 0),
(508, 1, 3, 'normal login to the system', 3, '2018-03-07 21:50:59', '2018-03-07 21:50:59', NULL, 0),
(509, 1, 3, 'normal login to the system', 3, '2018-03-08 08:42:27', '2018-03-08 08:42:27', NULL, 0),
(510, 1, 3, 'normal login to the system', 3, '2018-03-08 17:25:13', '2018-03-08 17:25:13', NULL, 0),
(511, 1, 3, 'normal login to the system', 3, '2018-03-12 12:08:25', '2018-03-12 12:08:25', NULL, 0),
(512, 1, 3, 'normal login to the system', 3, '2018-03-13 11:05:25', '2018-03-13 11:05:25', NULL, 0),
(513, 1, 3, 'normal login to the system', 3, '2018-03-14 10:06:30', '2018-03-14 10:06:30', NULL, 0),
(514, 1, 3, 'normal login to the system', 3, '2018-03-14 14:33:35', '2018-03-14 14:33:35', NULL, 0),
(515, 1, 3, 'normal login to the system', 3, '2018-03-15 09:28:38', '2018-03-15 09:28:38', NULL, 0),
(516, 1, 3, 'normal login to the system', 3, '2018-03-15 13:35:35', '2018-03-15 13:35:35', NULL, 0),
(517, 1, 3, 'normal login to the system', 3, '2018-03-18 11:16:02', '2018-03-18 11:16:02', NULL, 0),
(518, 1, 3, 'normal login to the system', 3, '2018-03-18 13:39:22', '2018-03-18 13:39:22', NULL, 0),
(519, 1, 3, 'normal login to the system', 3, '2018-03-19 11:49:04', '2018-03-19 11:49:04', NULL, 0),
(520, 2, 3, 'Logout to the system', 3, '2018-03-19 14:37:47', '2018-03-19 14:37:47', NULL, 0),
(521, 1, 3, 'normal login to the system', 3, '2018-03-21 09:52:22', '2018-03-21 09:52:22', NULL, 0),
(522, 2, 3, 'Logout to the system', 3, '2018-03-21 10:27:33', '2018-03-21 10:27:33', NULL, 0),
(523, 1, 3, 'normal login to the system', 3, '2018-03-21 11:46:39', '2018-03-21 11:46:39', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `applegreen_codes`
--

CREATE TABLE `applegreen_codes` (
  `id` int(11) NOT NULL,
  `applegreen_code` varchar(30) NOT NULL,
  `used` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `client_companies`
--

CREATE TABLE `client_companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `maximum_allowance` float NOT NULL DEFAULT '0',
  `additional_value` float DEFAULT NULL,
  `covered` tinyint(1) NOT NULL DEFAULT '0',
  `call_out_value` float DEFAULT NULL,
  `additional_tolls` tinyint(1) NOT NULL DEFAULT '0',
  `bringg_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `distance_unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'km'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `client_companies`
--

INSERT INTO `client_companies` (`id`, `name`, `maximum_allowance`, `additional_value`, `covered`, `call_out_value`, `additional_tolls`, `bringg_id`, `distance_unit`) VALUES
(5, '7 DAY AUTO', 0, 0, 0, NULL, 0, '8380', 'km'),
(6, 'A 1 MARSDEN', 0, 0, 0, NULL, 0, '8380', 'km'),
(7, 'A1 MOTORS', 0, 0, 0, NULL, 0, '8380', 'km'),
(8, 'AA AUTOS HAROLDS CROSS', 0, 0, 0, NULL, 0, '8380', 'km'),
(9, 'About Time Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(10, 'Ace Autobody (Finglas)', 0, 0, 0, NULL, 0, '8380', 'km'),
(11, 'Ace Autobody (Long Mile)', 0, 0, 0, NULL, 0, '8380', 'km'),
(12, 'Ace Autobody (Naas)', 0, 0, 0, NULL, 0, '8380', 'km'),
(13, 'Ace Autobody Bray', 0, 0, 0, NULL, 0, '8380', 'km'),
(14, 'Ace Autobody Coolock Ltd.', 0, 0, 0, NULL, 0, '8380', 'km'),
(15, 'Ace Autobody Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(16, 'ACME SYSTEMS LTD', 0, 0, 0, NULL, 0, '8380', 'km'),
(17, 'Additional Cash Charges', 0, 0, 0, NULL, 0, '8380', 'km'),
(18, 'Advance Assist Membership', 0, 0, 0, NULL, 0, '8380', 'km'),
(19, 'Advance Pitstop Head Office', 0, 0, 0, NULL, 0, '8380', 'km'),
(20, 'Aerlingus Cash Account', 0, 0, 0, NULL, 0, '8380', 'km'),
(21, 'Agnew Recovery Services LTD', 0, 0, 0, NULL, 0, '8380', 'km'),
(22, 'Airport Kia Motors', 0, 0, 0, NULL, 0, '8380', 'km'),
(23, 'Airside Ford', 0, 0, 0, NULL, 0, '8380', 'km'),
(24, 'Airside Renault', 0, 0, 0, NULL, 0, '8380', 'km'),
(25, 'AJK Motors Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(26, 'ALAN MCCLEAN', 0, 0, 0, NULL, 0, '8380', 'km'),
(27, 'Alexandra School Motoring', 0, 0, 0, NULL, 0, '8380', 'km'),
(28, 'ALLIANZ PLC', 0, 0, 0, NULL, 0, '8380', 'km'),
(29, 'Allspares Kildare', 0, 0, 0, NULL, 0, '8380', 'km'),
(30, 'An Garda Sochna', 0, 0, 0, NULL, 0, '8380', 'km'),
(31, 'Annesley Williams', 0, 0, 0, NULL, 0, '8380', 'km'),
(32, 'Ansley Motors', 0, 0, 0, NULL, 0, '8380', 'km'),
(33, 'ARB UNDERWRITING', 0, 0, 0, NULL, 0, '8380', 'km'),
(34, 'AS NEW CRASH REPAIRS', 0, 0, 0, NULL, 0, '8380', 'km'),
(35, 'Asgard Claims', 0, 0, 0, NULL, 0, '8380', 'km'),
(36, 'Ashley Ford', 0, 0, 0, NULL, 0, '8380', 'km'),
(37, 'AshMore Ryder Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(38, 'Assoc of Veh Rec Oper Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(39, 'Atlas Autoservice (Kylemore)', 0, 0, 0, NULL, 0, '8380', 'km'),
(40, 'ATLAS AUTOSERVICE LTD', 0, 0, 0, NULL, 0, '8380', 'km'),
(41, 'Atlas Autoservices (Baldoyle)', 0, 0, 0, NULL, 0, '8380', 'km'),
(42, 'Atlas Autoservices (Drumcondra)', 0, 0, 0, NULL, 0, '8380', 'km'),
(43, 'Atlas Blanchardstown', 0, 0, 0, NULL, 0, '8380', 'km'),
(44, 'Atlas Cash Sales', 0, 0, 0, NULL, 0, '8380', 'km'),
(45, 'Atlas Sandyford', 0, 0, 0, NULL, 0, '8380', 'km'),
(46, 'Auto Claims Solutions Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(47, 'Autocity', 0, 0, 0, NULL, 0, '8380', 'km'),
(48, 'Automobile Association', 0, 0, 0, NULL, 0, '8380', 'km'),
(49, 'AUTOMOTIVE INCIDENT MANAGEMENT', 0, 0, 0, NULL, 0, '8380', 'km'),
(50, 'Avis', 0, 0, 0, NULL, 0, '8380', 'km'),
(51, 'AVIVA IRELAND', 0, 0, 0, NULL, 0, '8380', 'km'),
(52, 'AWP Assistance Ireland Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(53, 'AWP Assistance UK Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(54, 'AXA Assistance', 0, 0, 0, NULL, 0, '8380', 'km'),
(55, 'Axa Assistance France Assurances', 0, 0, 0, NULL, 0, '8380', 'km'),
(56, 'Axa Assistance Polska S.A.', 0, 0, 0, NULL, 0, '8380', 'km'),
(57, 'AXA RTA', 0, 0, 0, NULL, 0, '8380', 'km'),
(58, 'Balgriffin Motors', 0, 0, 0, NULL, 0, '8380', 'km'),
(59, 'Blanchardtsown 4 x 4', 0, 0, 0, NULL, 0, '8380', 'km'),
(60, 'BO BO MOTORS', 0, 0, 0, NULL, 0, '8380', 'km'),
(61, 'Bodycraft', 0, 0, 0, NULL, 0, '8380', 'km'),
(62, 'Bodyshop Direct', 0, 0, 0, NULL, 0, '8380', 'km'),
(63, 'Brooks Garage', 0, 0, 0, NULL, 0, '8380', 'km'),
(64, 'C W TRANSPORT', 0, 0, 0, NULL, 0, '8380', 'km'),
(65, 'Call Assist Limited', 0, 0, 0, NULL, 0, '8380', 'km'),
(66, 'Canavan Ford', 0, 0, 0, NULL, 0, '8380', 'km'),
(67, 'CAR CRAFT', 0, 0, 0, NULL, 0, '8380', 'km'),
(68, 'CAR DOCK', 0, 0, 0, NULL, 0, '8380', 'km'),
(69, 'Cardock Classics', 0, 0, 0, NULL, 0, '8380', 'km'),
(70, 'CARS OF FAIRVIEW', 0, 0, 0, NULL, 0, '8380', 'm'),
(71, 'CarTow.ie', 5, 2, 1, NULL, 0, '8380', 'km'),
(72, 'CarTow.ie Membership', 0, 0, 1, NULL, 0, '8380', 'km'),
(73, 'Carworx', 0, 0, 0, NULL, 0, '8380', 'km'),
(74, 'CASH SALES ZERO', 0, 0, 0, NULL, 0, '8380', 'km'),
(75, 'Cassin Auto Repairs', 0, 0, 0, NULL, 0, '8380', 'km'),
(76, 'Catalpa Underwriting Agency Limited', 0, 0, 0, NULL, 0, '8380', 'km'),
(77, 'CLIFFORDS FIRE PLACE', 0, 0, 0, NULL, 0, '8380', 'km'),
(78, 'CLIFFORDS FIRE PLACE (TIGHE)', 0, 0, 0, NULL, 0, '8380', 'km'),
(79, 'Clontarf Autos', 0, 0, 0, NULL, 0, '8380', 'km'),
(80, 'Collinson Insurance Services Ltd.', 0, 0, 0, NULL, 0, '8380', 'km'),
(81, 'Coolock Commercials', 0, 0, 0, NULL, 0, '8380', 'km'),
(82, 'COURTNEY MOTORS', 0, 0, 0, NULL, 0, '8380', 'km'),
(83, 'CRASH SERVICES', 0, 0, 0, NULL, 0, '8380', 'km'),
(84, 'CROFTON MOTORS', 0, 0, 0, NULL, 0, '8380', 'km'),
(85, 'CUBIC MODULSYSTEMS', 0, 0, 0, NULL, 0, '8380', 'km'),
(86, 'DELANY MOTORS', 0, 0, 0, NULL, 0, '8380', 'km'),
(87, 'Denning Cars', 0, 0, 0, NULL, 0, '8380', 'km'),
(88, 'DENNIS MAHONY', 0, 0, 0, NULL, 0, '8380', 'km'),
(89, 'DENNIS MAHONY BODY REPAIRS', 0, 0, 0, NULL, 0, '8380', 'km'),
(90, 'Do not use see Cash Sales A/C', 0, 0, 0, NULL, 0, '8380', 'km'),
(91, 'DOLPHIN MOTORS', 0, 0, 0, NULL, 0, '8380', 'km'),
(92, 'DOMINIC LILLIS', 0, 0, 0, NULL, 0, '8380', 'km'),
(93, 'Dunwoody & Dobson', 0, 0, 0, NULL, 0, '8380', 'km'),
(94, 'easyAssist (Direct Payment)', 0, 0, 0, NULL, 0, '8380', 'km'),
(95, 'easyAssist Membership', 0, 0, 0, NULL, 0, '8380', 'km'),
(96, 'Electronic Tuning Service Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(97, 'Emerald Facilities', 0, 0, 0, NULL, 0, '8380', 'km'),
(98, 'Enterprise Rent A Car', 0, 0, 0, NULL, 0, '8380', 'km'),
(99, 'ER TRAVEL LTD. T/A EASIRENT', 0, 0, 0, NULL, 0, '8380', 'km'),
(100, 'ESB Network fleet & Equipment (Tallaght)', 0, 0, 0, NULL, 0, '8380', 'km'),
(101, 'ESB Network Fleet & Equipment (Summerhill)', 0, 0, 0, NULL, 0, '8380', 'km'),
(102, 'ESB TALBOT MOTORS', 0, 0, 0, NULL, 0, '8380', 'km'),
(103, 'Euro Assistance UK Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(104, 'EUROPCAR RENTAL', 0, 0, 0, NULL, 0, '8380', 'km'),
(105, 'Europe Assistance', 0, 0, 0, NULL, 0, '8380', 'km'),
(106, 'EXCEL AUTO CARE', 0, 0, 0, NULL, 0, '8380', 'km'),
(107, 'Excel Autocare (Old Airport)', 0, 0, 0, NULL, 0, '8380', 'km'),
(108, 'Excel Autocare (Santry)', 0, 0, 0, NULL, 0, '8380', 'km'),
(109, 'Fairview Motors', 0, 0, 0, NULL, 0, '8380', 'km'),
(110, 'FINGLAS FORD (JD)', 0, 0, 0, NULL, 0, '8380', 'km'),
(111, 'First Choice Auto\'s', 0, 0, 0, NULL, 0, '8380', 'km'),
(112, 'Fleet Support', 0, 0, 0, NULL, 0, '8380', 'km'),
(113, 'FMG', 0, 0, 0, NULL, 0, '8380', 'km'),
(114, 'FOUR POINT ASSISTANCE', 0, 0, 0, NULL, 0, '8380', 'km'),
(115, 'FUEL INJECTIONS SERVICES', 0, 0, 0, NULL, 0, '8380', 'km'),
(116, 'Galway Plant & Tool Hire', 0, 0, 0, NULL, 0, '8380', 'km'),
(117, 'Gannons City Recovery', 0, 0, 0, NULL, 0, '8380', 'km'),
(118, 'garage express', 0, 0, 0, NULL, 0, '8380', 'km'),
(119, 'Gerry Nolan (AUTOPOIN)', 0, 0, 0, NULL, 0, '8380', 'km'),
(120, 'Gerry Nolan (GERRYN)', 0, 0, 0, NULL, 0, '8380', 'km'),
(121, 'Grange Road Motors Ltd', 0, 0, 0, NULL, 0, '8380', 'km'),
(122, 'Green Flag', 0, 0, 0, NULL, 0, '8380', 'km'),
(123, 'Greg Martin Crash Repairs', 0, 0, 0, NULL, 0, '8380', 'km'),
(124, 'GT SALES & SERVICES', 0, 0, 0, NULL, 0, '8380', 'km'),
(125, 'Hanover Tyres Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(126, 'HOWARDS ENGINEERING', 0, NULL, 0, NULL, 0, NULL, 'km'),
(127, 'Hutton & Meade (Blanchardstown)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(128, 'HUTTON & MEADE (Norhtwest Business Park)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(129, 'Inter Partner Assistance (Leatherhead)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(130, 'Inter Partner Assistance Espana', 0, NULL, 0, NULL, 0, NULL, 'km'),
(131, 'INTER PARTNER ASSISTANCE.', 0, NULL, 0, NULL, 0, NULL, 'km'),
(132, 'IRELAND ASSIST', 0, NULL, 0, NULL, 0, NULL, 'km'),
(133, 'Irish School Motoring', 0, NULL, 0, NULL, 0, NULL, 'km'),
(134, 'IRISH TOWING SERVICE', 0, NULL, 0, NULL, 0, NULL, 'km'),
(135, 'Irish Towing Services', 0, NULL, 0, NULL, 0, NULL, 'km'),
(136, 'JD RECOVERY', 0, NULL, 0, NULL, 0, NULL, 'km'),
(137, 'JDM Specialist Cars Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(138, 'JF Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(139, 'JOHN BEAVER AUTO REPAIRS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(140, 'JOHNNY / TOMMY JOBS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(141, 'K & C GARAGE', 0, NULL, 0, NULL, 0, NULL, 'km'),
(142, 'KEENAN Property Managment', 0, NULL, 0, NULL, 0, NULL, 'km'),
(143, 'Kenco Underwriting Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(144, 'Lamb & O\'Connor', 0, NULL, 0, NULL, 0, NULL, 'km'),
(145, 'Lambe & O Connor', 0, NULL, 0, NULL, 0, NULL, 'km'),
(146, 'Lanesborough C; D; E; & F', 0, NULL, 0, NULL, 0, NULL, 'km'),
(147, 'LANTERN RECOVERY SPECIALSTS PLC', 0, NULL, 0, NULL, 0, NULL, 'km'),
(148, 'M50 Truck & Van Centre', 0, NULL, 0, NULL, 0, NULL, 'km'),
(149, 'M50 TRUCK AND VAN CENTRE', 0, NULL, 0, NULL, 0, NULL, 'km'),
(150, 'Manor Mill Managment', 0, NULL, 0, NULL, 0, NULL, 'km'),
(151, 'Maple Leaf Property Mgnt Co Lt', 0, NULL, 0, NULL, 0, NULL, 'km'),
(152, 'Marren Enginerring', 0, NULL, 0, NULL, 0, NULL, 'km'),
(153, 'MARTIN FORRESTER MOTORS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(154, 'Marvis Properties', 0, NULL, 0, NULL, 0, NULL, 'km'),
(155, 'MC kenna O Neill motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(156, 'MC NAMARAS GARAGE', 0, NULL, 0, NULL, 0, NULL, 'km'),
(157, 'MD PROPERTY', 0, NULL, 0, NULL, 0, NULL, 'km'),
(158, 'Merrion Fleet Management Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(159, 'MICHAEL GRANT RENAULT MOTORS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(160, 'Michael Regan', 0, NULL, 0, NULL, 0, NULL, 'km'),
(161, 'Micheal Grant Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(162, 'Micheal O\'Reilly Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(163, 'MILES REILLY', 0, NULL, 0, NULL, 0, NULL, 'km'),
(164, 'Moore Garage', 0, NULL, 0, NULL, 0, NULL, 'km'),
(165, 'MOTO WORLD', 0, NULL, 0, NULL, 0, NULL, 'km'),
(166, 'Motorfreight', 0, NULL, 0, NULL, 0, NULL, 'km'),
(167, 'MOTORIST LEGAL PROTECTION', 0, NULL, 0, NULL, 0, NULL, 'km'),
(168, 'Motorists Insurance Services (MIS001)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(169, 'Motorists Insurance Services (MISINSUR)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(170, 'MR GEARBOX FINGLAS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(171, 'Mr Ray Ebbs', 0, NULL, 0, NULL, 0, NULL, 'km'),
(172, 'NATION WIDE BREAKDOWN', 0, NULL, 0, NULL, 0, NULL, 'km'),
(173, 'Newgate motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(174, 'NISSAN LIFFEY VALLEY', 0, NULL, 0, NULL, 0, NULL, 'km'),
(175, 'North Brook Motor Company', 0, NULL, 0, NULL, 0, NULL, 'km'),
(176, 'Paddywagon Tours Ltd.', 0, NULL, 0, NULL, 0, NULL, 'km'),
(177, 'Parfit', 0, NULL, 0, NULL, 0, NULL, 'km'),
(178, 'Park Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(179, 'Patrona Underwriters', 0, NULL, 0, NULL, 0, NULL, 'km'),
(180, 'PC Commercials', 0, NULL, 0, NULL, 0, NULL, 'km'),
(181, 'Philip Scanlon', 0, NULL, 0, NULL, 0, NULL, 'km'),
(182, 'Phonix Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(183, 'Pilsen Auto Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(184, 'PK Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(185, 'PK MOTORS BLACKROCK', 0, NULL, 0, NULL, 0, NULL, 'km'),
(186, 'PLANT AND PLANTERS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(187, 'Pollock Lifts', 0, NULL, 0, NULL, 0, NULL, 'km'),
(188, 'Porsche Centre Dublin', 0, NULL, 0, NULL, 0, NULL, 'km'),
(189, 'PPRD Managment LTD (ODPM)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(190, 'PPRD Managment LTD (PPRD)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(191, 'Q Park', 0, NULL, 0, NULL, 0, NULL, 'km'),
(192, 'R.A.C. ACCOUNTS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(193, 'Rath Service Station', 0, NULL, 0, NULL, 0, NULL, 'km'),
(194, 'Rathfarnham Ford', 0, NULL, 0, NULL, 0, NULL, 'km'),
(195, 'Realt Paper Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(196, 'Recovery24', 0, NULL, 0, NULL, 0, NULL, 'km'),
(197, 'Rialto Ford', 0, NULL, 0, NULL, 0, NULL, 'km'),
(198, 'RIGHT PRICE CARS (RIGHTPC)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(199, 'RIGHT PRICE CARS (RSCARS)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(200, 'RINGSUN BLINDS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(201, 'Robertstown Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(202, 'ROYAL SUN ALLIANCE', 0, NULL, 0, NULL, 0, NULL, 'km'),
(203, 'RSA Insurance IRL', 0, NULL, 0, NULL, 0, NULL, 'km'),
(204, 'RTR', 0, NULL, 0, NULL, 0, NULL, 'km'),
(205, 'Saint Michaels House', 0, NULL, 0, NULL, 0, NULL, 'km'),
(206, 'SALVAGE DIRECT (SALDIREC)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(207, 'SALVAGE DIRECT (SALNORTH)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(208, 'SANTRY MOTORS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(209, 'SCAN AUTO ELECTRICAL', 0, NULL, 0, NULL, 0, NULL, 'km'),
(210, 'SCAN taxi centre', 0, NULL, 0, NULL, 0, NULL, 'km'),
(211, 'SCRAP / ABANDONDED', 0, NULL, 0, NULL, 0, NULL, 'km'),
(212, 'scully autocare', 0, NULL, 0, NULL, 0, NULL, 'km'),
(213, 'Seat Ireland', 0, NULL, 0, NULL, 0, NULL, 'km'),
(214, 'See Airside Ford A/c', 0, NULL, 0, NULL, 0, NULL, 'km'),
(215, 'SEJIM MTRS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(216, 'SERTIS INSURANCE', 0, NULL, 0, NULL, 0, NULL, 'km'),
(217, 'Sertus', 0, NULL, 0, NULL, 0, NULL, 'km'),
(218, 'Sheehy Mtrs', 0, NULL, 0, NULL, 0, NULL, 'km'),
(219, 'SHOOTING STAR', 0, NULL, 0, NULL, 0, NULL, 'km'),
(220, 'Sigma Wireless Communications Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(221, 'SIMPLY SWEDISH LTD.', 0, NULL, 0, NULL, 0, NULL, 'km'),
(222, 'SIXT Rent A Car Ireland', 0, NULL, 0, NULL, 0, NULL, 'km'),
(223, 'SMITH & BRANIGAN LTD.', 0, NULL, 0, NULL, 0, NULL, 'km'),
(224, 'SORAGHANS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(225, 'Statewide Towing', 0, NULL, 0, NULL, 0, NULL, 'km'),
(226, 'STEVE GUARD', 0, NULL, 0, NULL, 0, NULL, 'km'),
(227, 'Stoney Property Management Co', 0, NULL, 0, NULL, 0, NULL, 'km'),
(228, 'Supervalve', 0, NULL, 0, NULL, 0, NULL, 'km'),
(229, 'SWEENEYS GARAGE (SWEENEY)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(230, 'SWEENEYS GARAGE (SWEENEYS)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(231, 'TADG RIORDAN MOTORS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(232, 'TALBOT MTRS GARAGE', 0, NULL, 0, NULL, 0, NULL, 'km'),
(233, 'Taragan Alex', 0, NULL, 0, NULL, 0, NULL, 'km'),
(234, 'The Bodyshop and Service Centre', 0, NULL, 0, NULL, 0, NULL, 'km'),
(235, 'THRIFTY VAN RENTALS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(236, 'TOM HARRINGTON', 0, NULL, 0, NULL, 0, NULL, 'km'),
(237, 'Tom Murphy Recovery (TMUR01)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(238, 'Tom Murphy Recovery (TOM001)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(239, 'Tom Murphy Recovery (TOMMURPH)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(240, 'TOM WALSH MOTORS (TOMWALSH)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(241, 'TOM WALSH MOTORS (WALSH)', 0, NULL, 0, NULL, 0, NULL, 'km'),
(242, 'Top In Pops', 0, NULL, 0, NULL, 0, NULL, 'km'),
(243, 'TOTAL FUNDRAISING', 0, NULL, 0, NULL, 0, NULL, 'km'),
(244, 'TOTAL RECOVERY LTD', 0, NULL, 0, NULL, 0, NULL, 'km'),
(245, 'TR Motor Services Ltd.', 0, NULL, 0, NULL, 0, NULL, 'km'),
(246, 'Tractamotors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(247, 'Travelers Insurance', 0, NULL, 0, NULL, 0, NULL, 'km'),
(248, 'Treanor Security Systems', 0, NULL, 0, NULL, 0, NULL, 'km'),
(249, 'Truck & Bus Parts', 0, NULL, 0, NULL, 0, NULL, 'km'),
(250, 'Unified Technology Solutions', 0, NULL, 0, NULL, 0, NULL, 'km'),
(251, 'V R N L', 0, NULL, 0, NULL, 0, NULL, 'km'),
(252, 'Vantastic Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(253, 'VEHICLE RESCUE NETWORK LTD', 0, NULL, 0, NULL, 0, NULL, 'km'),
(254, 'Volkwagon Group Ireland Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(255, 'WEBB MOTORS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(256, 'WESTBROOK MOTORS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(257, 'Westly Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(258, 'White and Delahunty', 0, NULL, 0, NULL, 0, NULL, 'km'),
(259, 'White and Delahunty Motors Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(260, 'Willie O Brien', 0, NULL, 0, NULL, 0, NULL, 'km'),
(261, 'Windsor Airside', 0, NULL, 0, NULL, 0, NULL, 'km'),
(262, 'WINDSOR LIFFEY VALLEY', 0, NULL, 0, NULL, 0, NULL, 'km'),
(263, 'Windsor Motors', 0, NULL, 0, NULL, 0, NULL, 'km'),
(264, 'WINSOR MOTORS BRAY', 0, NULL, 0, NULL, 0, NULL, 'km'),
(265, 'WISE PROPERTY', 0, NULL, 0, NULL, 0, NULL, 'km'),
(266, 'Wrightway Underwriting Ltd', 0, NULL, 0, NULL, 0, NULL, 'km'),
(267, 'X GARAGE LIMITED', 0, NULL, 0, NULL, 0, NULL, 'km'),
(268, 'YOMAC CARS', 0, NULL, 0, NULL, 0, NULL, 'km'),
(269, 'Zoe Wong', 0, NULL, 0, NULL, 0, NULL, 'km'),
(270, 'ZURICH INSURANCE', 0, NULL, 0, NULL, 0, NULL, 'km'),
(271, 'AIG', 0, 0, 0, NULL, 0, '8820', 'km'),
(272, 'First Ireland (Direct Payment)', 0, 0, 0, NULL, 0, '8713', 'km'),
(273, 'First Ireland Membership Account', 0, 0, 0, NULL, 0, '8713', 'km'),
(274, 'First Ireland Roadside Assistance / Breakdown Recovery', 0, 0, 0, NULL, 0, '8713', 'km'),
(275, 'FBD', 0, 0, 0, NULL, 0, '8254', 'km'),
(276, 'Joe Duffy', 0, 0, 0, NULL, 0, '8302', 'km'),
(277, 'Liberty Insurance', 0, 0, 0, NULL, 0, '8253', 'km'),
(278, 'Mapfre', 0, 0, 0, NULL, 0, '8184', 'km'),
(279, 'teest', 0, 0, 0, 0, 0, '8380', 'km');

-- --------------------------------------------------------

--
-- Table structure for table `company_accounts`
--

CREATE TABLE `company_accounts` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `website` varchar(300) NOT NULL,
  `address` varchar(300) NOT NULL,
  `main_poc` int(11) NOT NULL,
  `accounts_poc` int(11) NOT NULL,
  `memberships` varchar(100) NOT NULL,
  `added_by` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 0 kB; (`added_by`) REFER `cartow/users`(`id`); (`main_poc`) REFER `';

--
-- Dumping data for table `company_accounts`
--

INSERT INTO `company_accounts` (`id`, `code`, `name`, `website`, `address`, `main_poc`, `accounts_poc`, `memberships`, `added_by`, `status`) VALUES
(6, 'CP12', 'Cartow', 'www.company.com', '2 Test St.', 2, 0, '["1"]', 3, 1),
(14, 'APG', 'applegreeen', 'www.applegreeen.com', '100 Test address St.', 11, 0, '["1","2","4"]', 3, 1),
(28, 'KS', 'KS', '', '', 33, 34, '["1","2","4"]', 3, 1),
(29, 'kct', 'Kim Customer ', '', '', 38, 39, '["1","2","4"]', 3, 1),
(30, 'BCT', 'BREN', '', '', 41, 42, '["1","6","12"]', 3, 1),
(31, 'TBMB', 'Talbot Motors', '', '', 43, 44, '["13"]', 3, 1),
(32, 'PMB', 'PaulTestDealer', '', '', 45, 46, '["1","2","4"]', 3, 1),
(33, 'Testing me', 'Paul CT test', 'www.cartow.ie', 'Dublin Ireland', 47, 48, '["6","9","14"]', 3, 1),
(34, 'KMMB', 'Kimbo', '', '', 49, 50, '["1","2","4"]', 3, 1),
(35, 'monthly', 'Monthly bill', 'CarTow.ie', 'Dublin', 51, 52, '["1"]', 3, 1),
(36, 'A2BMEM', 'A2B Recovery', '', 'Ballymcquinn Ardfert Tralee Co Kerry', 53, 54, '["16"]', 3, 0),
(38, '0129319', 'adajkd', 'adjad', 'dasda', 57, 58, '["6"]', 3, 1),
(39, 'vms', 'vms', 'http://vms.ie/', 'irland', 59, 60, '["15"]', 3, 1),
(40, 'MF', 'The Mohamed Fayez', '', '', 63, 0, '["5","9"]', 3, 1),
(41, 'MF', 'The Mohamed Fayez', '', '', 64, 0, '["5","9"]', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_payment_method`
--

CREATE TABLE `company_payment_method` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company_payment_method`
--

INSERT INTO `company_payment_method` (`id`, `company_id`, `payment_method_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 16, 2, 0, '2015-08-04 13:19:17', '2015-08-04 13:19:17'),
(43, 18, 2, 1, '2015-08-05 13:21:17', '2015-08-05 13:21:17'),
(44, 19, 2, 1, '2015-08-12 06:40:58', '2015-08-12 06:40:58'),
(45, 20, 2, 1, '2015-08-12 09:11:29', '2015-08-12 09:11:29'),
(46, 21, 2, 1, '2015-08-12 09:18:36', '2015-08-12 09:18:36'),
(47, 22, 2, 0, '2015-08-12 11:23:48', '2015-08-12 11:23:48'),
(48, 23, 2, 0, '2015-08-12 12:06:54', '2015-08-12 12:06:54'),
(49, 24, 1, 0, '2015-08-19 07:27:00', '2015-08-19 07:27:00'),
(50, 25, 1, 0, '2015-08-19 10:07:53', '2015-08-19 10:07:53'),
(51, 26, 1, 0, '2015-08-26 11:17:23', '2015-08-26 11:17:23'),
(52, 27, 2, 1, '2015-08-27 12:58:24', '2015-08-27 12:58:24'),
(53, 28, 1, 1, '2015-08-31 08:57:54', '2015-08-31 08:57:54'),
(54, 29, 2, 1, '2015-09-09 08:29:23', '2015-09-09 08:29:23'),
(55, 30, 1, 1, '2015-09-14 09:03:33', '2015-09-14 09:03:33'),
(56, 31, 2, 1, '2015-09-30 09:12:24', '2015-09-30 09:12:24'),
(57, 32, 2, 1, '2015-09-30 10:27:54', '2015-09-30 10:27:54'),
(58, 33, 1, 1, '2015-09-30 12:32:07', '2015-09-30 12:32:07'),
(59, 34, 2, 1, '2015-09-30 13:04:45', '2015-09-30 13:04:45'),
(60, 35, 2, 1, '2015-10-01 19:41:27', '2015-10-01 19:41:27'),
(61, 36, 2, 1, '2015-10-05 09:01:15', '2015-10-05 09:01:15'),
(62, 37, 1, 1, '2015-11-01 09:16:37', '2015-11-01 09:16:37'),
(63, 38, 1, 1, '2015-11-03 13:07:07', '2015-11-03 13:07:07'),
(64, 39, 1, 1, '2016-02-07 12:24:04', '2016-02-07 12:24:04'),
(65, 41, 1, 1, '2017-07-26 19:28:03', '2017-07-26 19:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `credit_card_info`
--

CREATE TABLE `credit_card_info` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `cd_number` varchar(100) NOT NULL,
  `security_code` varchar(50) NOT NULL,
  `expiration_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credit_card_info`
--

INSERT INTO `credit_card_info` (`id`, `first_name`, `last_name`, `cd_number`, `security_code`, `expiration_date`) VALUES
(1, 'Sherifa', 'Mazhar', '3827528981203', '789', 2016);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `membership_id` varchar(20) NOT NULL,
  `title` varchar(10) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address_line_1` varchar(100) NOT NULL,
  `address_line_2` varchar(100) DEFAULT NULL,
  `town` varchar(50) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(50) NOT NULL,
  `nok_phone_number` varchar(50) DEFAULT NULL,
  `number_of_assists` int(11) NOT NULL DEFAULT '0',
  `vehicle_registration` varchar(10) NOT NULL,
  `odometer_reading` int(30) NOT NULL,
  `odometer_type` varchar(30) NOT NULL,
  `membership` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `expiration_date` date NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `accept_terms` tinyint(4) DEFAULT '0',
  `certificate` tinyint(4) DEFAULT '0',
  `welcome_pack` tinyint(4) DEFAULT '0',
  `completed` tinyint(4) DEFAULT '0',
  `is_archived` tinyint(4) DEFAULT '0' COMMENT '0=>no , 1=>yes',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `have_nct` tinyint(4) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 0 kB; (`membership`) REFER `cartow/memberships`(`id`); (`added_by`)';

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `membership_id`, `title`, `first_name`, `last_name`, `email`, `address_line_1`, `address_line_2`, `town`, `county`, `postal_code`, `phone_number`, `nok_phone_number`, `number_of_assists`, `vehicle_registration`, `odometer_reading`, `odometer_type`, `membership`, `start_date`, `expiration_date`, `vehicle_id`, `company_id`, `added_by`, `accept_terms`, `certificate`, `welcome_pack`, `completed`, `is_archived`, `deleted_at`, `have_nct`, `type`, `created_at`, `updated_at`) VALUES
(33, 56, 'M06ww681', 'Mrs', 'Mary', 'Meagher', 'marymeagher2010@hotmail.com', '150 Beachdale\r\nKilcoole\r\nCo Wicklow', NULL, NULL, NULL, NULL, '0863091525', NULL, 0, '06ww681', 109, 'k', 5, '2015-07-01 00:00:00', '2016-07-01', 26, NULL, 0, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(48, NULL, 'M07C16358', 'Mr', 'Dan', 'Dowling', 'daniel.dowling@cartow.ie', '10 Collinstown', 'Lane', 'Airport', 'Dublin', 'Co.Dublin', '0861514965', '0861654965', 7, '07C16358', 1000, 'k', 11, '2015-07-01 00:00:00', '2016-07-19', 34, NULL, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(50, NULL, 'M01-LS-407', 'Ms', 'Patricia', 'Norton', 'trisha.norton@cartow.ie', 'Barrow Street', 'Ringsend', 'Dublin 4', 'Dublin', '90210', '0834568630', NULL, 1, '01-LS-407', 2000, 'k', 9, '2015-07-01 00:00:00', '2016-08-08', 37, NULL, 0, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(54, NULL, 'M12D2383', 'Mr', 'David', 'Foley', 'david.foley@cartow.ie', '', '', '', '', '', '0868988530', NULL, 0, '12D2383', 40000, 'k', 9, '2015-07-01 00:00:00', '2016-08-14', 45, NULL, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(55, NULL, 'M11D11849', 'Mr', 'Ken', 'Morgan', 'ken.morgan@cartow.ie', '', '', '', '', '', '0862664154', NULL, 1, '11D11849', 62, 'm', 9, '2015-07-01 00:00:00', '2016-08-14', 46, 6, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(57, 53, 'M05MO5533', 'Mr', 'Eamonn', 'Doyle', 'eamonn_doyle@ie.ibm.com', 'Cedar Cottage', 'Ballyhmorris Lower', 'Aughrim', 'Co. Wicklow', 'Y14 CK18', '0867842479', NULL, 0, '05MO5533', 296378, 'k', 5, '2015-07-01 00:00:00', '2016-08-16', 48, 6, 0, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(68, 63, 'M08-DL-5746', 'Mrs', 'Desiree', 'Casburn', 'desiree.casburn@gmail.com', 'Stackernagh', '', 'Churchill', 'Donegal', '0000', '+353879957775', NULL, 0, '08-DL-5746', 76446, 'm', 5, '2015-07-01 00:00:00', '2016-09-06', 59, 14, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(69, 64, 'M04wx2406', 'Ms', 'Kate', 'Kinsella', 'kate.carley@gmail.com', '', '', '', '', '', '0857892855', '', 0, '04wx2406', 64900, 'k', 5, '2015-07-01 00:00:00', '2016-09-10', 60, 6, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(70, 65, 'M05KE10973', 'Mr', 'Kim', 'McKayed', 'kim.mckayed@311-solutions.com', '', '', '', '', '', '0861514965', NULL, 0, '05KE10973', 100, 'k', 5, '2015-07-01 00:00:00', '2016-09-09', 61, 14, 3, 0, 0, 0, 1, 1, '2016-01-25 09:33:19', 0, 'customer', NULL, NULL),
(71, 76, 'M11d42485', 'Mr', 'John', 'Butler', 'johnbutler289@gmail.com', '13 riverston garden', 'Ashington', 'dublin 7', 'dublin', '', '0868257075', NULL, 0, '11d42485', 510000, 'k', 9, '2015-09-24 00:00:00', '2016-09-24', 62, 6, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(72, 78, 'M11d42485', 'Mr', 'John ', 'Butler ', 'johnbutler285@gmail.com', '13 riverston garden ', 'Ashington ', 'Navan rd ', 'Dublin 7', '', '0868257075', '', 0, '11d42485', 52000, 'k', 15, '2015-09-25 00:00:00', '2016-09-25', 63, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(73, 79, 'M11D42485', 'Mr', 'John', 'Butler', 'johnbutler285@gmail.com', 'Ashington Navan', 'Navan Road', '', 'Dublin', 'Dublin 7', '0868257075', '', 0, '11D42485', 52000, 'k', 15, '2015-09-25 00:00:00', '2016-09-25', 64, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(74, 80, 'M11d42485', 'Mr', 'John', 'Butler', 'johnbutler285@gmail.com', '', '', '', '', '', '0868257075', '', 0, '11d42485', 52000, 'k', 15, '2015-09-26 00:00:00', '2016-09-26', 65, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(75, 81, 'M11d42485', 'Mr', 'John', 'Butler', 'johnbutler285@gmail.com', '', '', '', '', '', '0868257075', '', 0, '11d42485', 52000, 'k', 15, '2015-09-26 00:00:00', '2016-09-26', 66, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(76, 82, 'M06ww681', 'Mr', 'shady', 'mohammed', 'shadywallas@gmail.com', '', '', '', '', '', '0020120584176', '', 0, '06ww681', 1200, 'k', 15, '2016-01-01 00:00:00', '2017-08-01', 67, 39, 248, 0, 1, 0, 1, 0, '2016-01-15 09:48:48', 0, 'customer', NULL, '2017-07-27 16:45:04'),
(77, 83, 'M05KE10973', 'Mr', 'Kim ', 'McKayed ', 'kim.mckayed@311-solutions.com', '18 hasbdasf st.', NULL, NULL, 'Eregion', NULL, '0861514965', NULL, 1, '05KE10973', 100, 'k', 15, '2015-10-14 00:00:00', '2017-08-14', 68, 39, 248, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, '2017-07-27 16:50:50'),
(78, 84, 'M05KE10973', 'Mr', 'Kim ', 'McKayed', 'kim.mckayed@311-solutions.com', '', '', '', '', '', '0861514965', '', 2, '05KE10973', 100, 'k', 15, '2015-02-11 00:00:00', '2016-02-11', 69, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2017-09-27 19:25:26'),
(79, 87, 'M05KE10973', 'Mr', 'Kim ', 'McKayed ', 'kim.mckayed@webelevate.ie', '', '', '', '', '', '0861514965', '', 0, '05KE10973', 100, 'k', 9, '2015-10-03 00:00:00', '2016-10-03', 70, 6, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(80, 90, 'M06d76858', 'Mr', 'Bruce', 'Wayne', 'paulcartow@gmail.com', '24 Castlefield', 'Lawns, ringsend', 'Dublin 2', 'Dublin', '2', '0876707316', '0862352114', 0, '06d76858', 11620, 'k', 15, '2015-10-03 00:00:00', '2016-10-03', 71, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(81, 92, 'M06d76858', 'Mr', 'Paul', 'O\'Halloran', 'paulcartow@gmail.com', 'test', 'test', 'test', 'test', 'test', '0876707316', '0876707316', 0, '06d76858', 112100, 'k', 4, '2015-10-03 00:00:00', '2016-10-03', 72, 6, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(82, 98, 'M05KE10973', 'Mr', 'Kim ', 'McKayed ', 'kim.mckayed@webelevate.ie', '', '', '', '', '', '0861514965', '', 7, '05KE10973', 101, 'k', 9, '2015-10-03 00:00:00', '2016-10-03', 73, 6, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2017-10-29 20:53:57'),
(83, 99, 'M12D2383', 'Mr', 'David', 'Foley', 'david.foley@cartow.ie', '', '', '', '', '', '0861514965', '', 0, '12D2383', 101, 'k', 15, '2015-09-01 00:00:00', '2016-09-01', 74, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(84, 102, 'M06D9800', 'Mr', 'trevor', 'gilligan', 'trevorgilligan@gmail.com', '12 griffeen glen park', 'lucan', 'co. dublin', 'co. dublin', 'co. dublin', '0857145005', NULL, 0, '06D9800', 0, 'k', 9, '2015-10-05 00:00:00', '2016-10-05', 75, 6, 3, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(85, 104, 'M05c4507', 'Mr', 'Donna ', 'Hagan', 'marc@vms.ie', '180 steeplechase green', 'Ratoath', '', 'meath', '', '0863494192', '', 0, '05c4507', 100000, 'k', 15, '2015-03-28 00:00:00', '2016-03-28', 76, 39, 248, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(86, 105, 'M05ke16162', 'Mr', 'Michael', 'Regan', 'marc@vms.ie', '31 brighton gardens', 'rathgar', '', 'dublin 6', '', '0871233014', '', 0, '05ke16162', 100000, 'k', 15, '2015-04-04 00:00:00', '2016-04-04', 77, 39, 248, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(87, 106, 'M08d44001', 'Mr', 'Ben', 'Enrhart', 'marc@vms.ie', 'apt 52 grand canal square ', 'lazer lane ', '', 'dublin 2', '', '0876119311', '', 0, '08d44001', 100000, 'k', 8, '2015-04-05 00:00:00', '2016-04-05', 78, 6, 3, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(88, 107, 'M05d61568', 'Mr', 'Denise ', 'lloyd', 'marc@vms.ie', '83 Monastery drive ', 'clondalkin', '', 'dublin 22', '', '0871317099', '', 0, '05d61568', 100000, 'k', 15, '2015-04-11 00:00:00', '2016-04-11', 79, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(89, 108, 'M05kk3401', 'Ms', 'ann marie', 'ogrady', 'amogrady@gmail.com', '2 patrick doyle rd', 'windy arbour', '', 'dublin 2', '', '0862600050', '', 0, '05kk3401', 100000, 'k', 15, '2015-04-12 00:00:00', '2016-04-12', 80, 39, 248, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(90, 109, 'M00d90995', 'Mr', 'ken ', 'murphy', 'marc@vms.ie', '11 ramor park', 'blanchardstown ', '', 'dublin 15', '', '0857664655', '', 0, '00d90995', 100000, 'k', 15, '2015-04-13 00:00:00', '2016-04-13', 81, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(91, 110, 'M05dl6849', 'Ms', 'aishling', 'mccann', 'marc@vms.ie', '113 castleknock park', 'castleknock', '', 'dublin 15', '', '0868922197', '', 0, '05dl6849', 100000, 'k', 15, '2015-10-09 00:00:00', '2016-10-09', 82, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(92, 111, 'M08d3900', 'Mr', 'peter ', 'travers', 'marc@vms.ie', '163 whitestown avenue', 'blanchardstown', '', 'Dublin15', '', '0863405590', '', 0, '08d3900', 100000, 'k', 15, '2015-10-09 00:00:00', '2016-10-09', 83, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(93, 112, 'M03d33244', 'Mr', 'clare ', 'mc cluskey', 'marc@vms.ie', 'cricketfield cottage ', 'carranstown', 'ballivor', 'meath', '', '0868590271', '', 0, '03d33244', 100000, 'k', 15, '2015-04-17 00:00:00', '2016-04-17', 84, 39, 248, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(94, 113, 'M11mh4607', 'Mr', 'peter ', 'frelly', 'marc@vms.ie', 'rathendrick', 'kells', '', 'meath', '', '0863635434', '', 0, '11mh4607', 100000, 'k', 15, '2015-04-19 00:00:00', '2016-04-19', 85, 39, 248, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(95, 114, 'M08d36874', 'Mr', 'jennifer ', 'kennedy', 'sales@usedcarcentre.ie', 'warrenstown', 'drumree', '', 'meath', '', '0862856964', '', 1, '08d36874', 100000, 'k', 15, '2015-04-22 00:00:00', '2016-04-22', 86, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(96, 115, 'M03c23973', 'Mr', 'lena', 'moran ', 'marc@vms.ie', 'jadham house', 'ballinaparka aglish ', 'cappaquinn', 'waterford', '', '0877931216', '', 0, '03c23973', 100000, 'k', 15, '2015-10-09 00:00:00', '2016-10-09', 87, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(97, 116, 'Mhn60ztl', 'Ms', 'rosie ', 'cruise', 'rcruise150@hotmail.com', '48 foxfield ', 'carrickmacross', 'monaghan', 'monaghan', '', '0874157499', '', 0, 'hn60ztl', 100000, 'k', 15, '2015-04-27 00:00:00', '2016-04-27', 88, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(98, 117, 'M08w1605', 'Mr', 'justin', 'kavanagh', 'marc@vms.ie', '49 beverstown orchard', '', 'donabate', 'dublin', '', '0858503006', '', 0, '08w1605', 100000, 'k', 15, '2015-04-29 00:00:00', '2016-04-29', 89, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(99, 118, 'M02d120620', 'Mr', 'roy ', 'hunt', 'rhunter2085@gmail.com', '49 canon ', 'lillis ave ', 'seville place ', 'dublin 1', '', '0877040622', '', 0, '02d120620', 100000, 'k', 15, '2015-03-29 00:00:00', '2016-03-29', 90, 39, 248, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(100, 119, 'M12d25462', 'Mrs', 'bridet', 'gill', 'dgmotorsdubin@gmail.com', '47 kilbaron park ', 'coolock', '', 'dublin 5', '', '0851662428', '', 0, '12d25462', 100000, 'k', 15, '2015-04-29 00:00:00', '2016-04-29', 91, 39, 248, 0, 1, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(101, 120, 'M93d42003', 'Mr', 'thomas ', 'doyle', 'sales@justgoodcars.ie', 'station road ', 'lusk', '', 'dublin', '', '0879026322', '', 0, '93d42003', 100000, 'k', 15, '2015-10-09 00:00:00', '2016-10-09', 92, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(102, 121, 'M10d127008', 'Ms', 'jackie ', 'carter ', 'marc@vms.ie', 'ivy cottage', 'warrenstown', 'drunree', 'meath', '', '0860555833', '', 0, '10d127008', 100000, 'k', 15, '2015-10-09 00:00:00', '2016-10-09', 93, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(103, 122, 'M06d22939', 'Mr', 'sean', 'mcdonagh', 'marc@vms.ie', '73 meldain', 'dunshaughlin', '', 'meath', '', '0877961062', '', 0, '06d22939', 100000, 'k', 15, '2015-05-01 00:00:00', '2016-05-01', 94, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(104, 123, 'M06d22939', 'Ms', 'sean ', 'mcdonagh', 'marc@vms.ie', '73 meldain', 'deunshaughlin', '', 'meath', '', '0877961062', '', 0, '06d22939', 100000, 'k', 15, '2015-10-09 00:00:00', '2016-10-09', 95, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(105, 124, 'M07d72186', 'Mr', 'brendan', 'carolan', 'marc@vms', 'ardcalf', 'slane', '', 'meath', '', '0872609653', '', 0, '07d72186', 100000, 'k', 15, '2015-05-01 00:00:00', '2016-05-01', 96, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(106, 125, 'M08lh5524', 'Mr', 'stevyn ', 'kelly', 'marc@vms.ie', '29 st bridgets park', 'blanchardstown', '', 'dublin 15', '', '0862178253', '', 0, '08lh5524', 100000, 'k', 15, '2015-05-01 00:00:00', '2016-05-01', 97, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(107, 126, 'M04d9315', 'Ms', 'mary ann', 'soliman', 'marc@vms.ie', '16 the willows', 'the gallops', 'latt', 'cavan', '', '0879343033', '', 0, '04d9315', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 98, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(108, 127, 'M06ww400', 'Mr', 'james', 'daniel', 'marc@vms.ie', '24 mark green', 'artane ', '', 'dublin 5', '', '0852357994', '', 0, '06ww400', 100000, 'k', 15, '2015-05-01 00:00:00', '2016-05-01', 99, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(109, 128, 'MFE12FMO', 'Mr', 'KEVIN', 'HEGARTY', 'nualahegarty1@yahoo.ie', 'ballyderown', 'kilworth ', '', 'Cork', '', '0874142787', '', 0, 'FE12FMO', 100000, 'k', 15, '2015-05-02 00:00:00', '2016-05-02', 100, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(110, 129, 'M11d11333', 'Mr', 'Iseult', 'Bouarroudj', 'marc@vms.ie', '46 belvedere hills', 'mullingar', '', 'westmeath', '', '0879963956', '', 0, '11d11333', 100000, 'k', 15, '2015-05-02 00:00:00', '2016-05-02', 101, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(111, 130, 'M12d1662', 'Mr', 'jim ', 'darcy', 'northcountyusedcars@gmail.com', 'murphys yard', 'old airport rd ', 'cloghran', 'Dublin ', '', '0852867604', '', 0, '12d1662', 100000, 'k', 15, '2015-05-03 00:00:00', '2016-05-03', 102, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(112, 131, 'M00d112129', 'Mr', 'rob', 'molloy', 'robbie_molloy@hotmail.com', 'rosemount ind est', 'ballycoolin', 'blanchardstown', 'dublin', '', '0871330032', '', 0, '00d112129', 100000, 'k', 15, '2015-05-07 00:00:00', '2016-05-07', 103, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(113, 132, 'M07d10815', 'Mrs', 'mary ', 'lambe ', 'marylambe@hotmail.com', '36 shelmartin ave ', 'marino', '', 'dublin 3', '', '0851351139', '', 0, '07d10815', 100000, 'k', 15, '2015-05-08 00:00:00', '2016-05-08', 104, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(114, 133, 'M06kE7995', 'Mr', 'darren', 'langton ', 'marc@vms.ie', '8 kilshane road', 'finglas', '', 'dublin 11', '', '0851135583', '', 0, '06kE7995', 100000, 'k', 15, '2015-05-09 00:00:00', '2016-05-09', 105, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(115, 134, 'M01ky3850', 'Ms', 'roy ', 'james', 'sales@amcdublin.ie', '5 standview terrece', '', '', 'dublin', '', '0860270135', '', 0, '01ky3850', 100000, 'k', 15, '2015-05-10 00:00:00', '2016-05-10', 106, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(116, 135, 'M06d75285', 'Mr', 'karl ', 'o brien', 'sales@drimnaghmotors.com', '121 drimnagh rd ', 'drimnagh ', '', 'dublin 12', '', '014099508', '', 0, '06d75285', 100000, 'k', 15, '2015-05-17 00:00:00', '2016-05-17', 107, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(117, 136, 'M01d8636', 'Mr', 'paddy ', 'mcphillips ', 'hillsidegarages@gmail.com', 'unit a3 south city', 'south city business park ', 'tallaght ', 'dublin 24', '', '0860864977', '', 0, '01d8636', 100000, 'k', 15, '2015-05-21 00:00:00', '2016-05-21', 108, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(118, 137, 'M07d4568', 'Ms', 'louise ', 'lambe', 'thelambe4@gmail.com', '17 Willowbrook ', 'donabate ', '', 'dublin ', '', '0862029053', '', 0, '07d4568', 100000, 'k', 15, '2015-05-21 00:00:00', '2016-05-21', 109, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(119, 138, 'M06d45995', 'Ms', 'deborah', 'kavanagh', 'marc@vms.ie', '9 lakeview cresent', 'wicklow', '', 'wicklow', '', '0851794873', '', 0, '06d45995', 100000, 'k', 15, '2015-05-24 00:00:00', '2016-05-24', 110, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(120, 139, 'M07cn2132', 'Mr', 'shane', 'o brien', 'shanetobrien@gmail.com', 'highfield lodge', '38 highfield road', 'rathgar', 'dublin 6', '', '0876344912', '', 0, '07cn2132', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 111, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(121, 140, 'M07d91022', 'Mr', 'shane ', 'Higgins', 'marc@vms.ie', 'levally cottage', 'boffenaun', 'pontoon ', 'mayo', '', '0862744664', '', 0, '07d91022', 100000, 'k', 15, '2015-06-06 00:00:00', '2016-06-06', 112, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(122, 141, 'M09d12836', 'Mr', 'austin ', 'hill', 'marc@vms.ie', 'singing meadow ', 'old russian village', 'kilquade ', 'wicklow', '', '0872322484', '', 0, '09d12836', 100000, 'k', 15, '2015-06-06 00:00:00', '2016-06-06', 113, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(123, 142, 'M05mh1367', 'Ms', 'mary', 'rooney', 'marc@vms.ie', 'nirvana ', 'castleknock ', '', 'dublin 15', '', '0868142482', '', 0, '05mh1367', 100000, 'k', 15, '2015-06-06 00:00:00', '2016-06-06', 114, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(124, 143, 'M03d54899', 'Ms', 'sarah ', 'flynn', 'marc@vms.ie', 'castlecraddock ', 'annestown', '', 'waterford ', '', '0866069678', '', 0, '03d54899', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 115, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(125, 144, 'M04mh7446', 'Mr', 'eoghan', 'mcgoldrick', 'marc@vms.ie', '12 knockabawn ', 'rush ', '', 'dublin  ', '', '0860573233', '', 0, '04mh7446', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 116, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(126, 145, 'M02d10117', 'Ms', 'teresa ', 'keogh', 'marc@vms.ie', '35 rathvilly park ', 'finglas  south ', '', 'dublin 11', '', '0851397244', '', 0, '02d10117', 100000, 'k', 15, '2015-06-06 00:00:00', '2016-06-06', 117, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(127, 146, 'M07Ke3949', 'Mr', 'anthony ', 'brennan', 'marc@vms.ie', '2 jugback terrace ', 'applewood village ', 'swords ', 'dublin', '', '0872762599', '', 0, '07Ke3949', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 118, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(128, 147, 'M07d75628', 'Mr', 'David ', 'cregan', 'marc@vms.ie', '20 roselawn grove ', 'castleknock ', '', 'dublin 15 ', '', '0872183679', '', 0, '07d75628', 100000, 'k', 15, '2015-06-12 00:00:00', '2016-06-12', 119, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(129, 148, 'M11g3353', 'Mr', 'david duignan', 'david duignan ', 'marc@vms.ie', 'kittymooden ', 'ballinmore ', '', 'leitrim', '', '0861045531', '', 0, '11g3353', 100000, 'k', 15, '2015-06-13 00:00:00', '2016-06-13', 120, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(130, 149, 'M07d49525', 'Mr', 'david ', 'mcfadden ', 'marc@vms.ie', '1 kinsealy cottages ', 'chapel road ', 'old kinsealy ', 'dublin ', '', '0878783762', '', 0, '07d49525', 100000, 'k', 15, '2015-06-15 00:00:00', '2016-06-15', 121, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(131, 150, 'M12d45473', 'Mr', 'edward ', 'byrne ', 'marc@vms.ie', '84 prussian street ', 'dublin 7', '', 'Dublin 7', '', '0833811415', '', 0, '12d45473', 100000, 'k', 15, '2015-06-15 00:00:00', '2016-06-15', 122, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(132, 151, 'M11d50517', 'Mr', 'peter ', 'morgan', 'marc@vms.ie', 'elm park golf club ', 'nutley lane ', 'donnybrook ', 'dublin 4', '', '0872896358', '', 0, '11d50517', 100000, 'k', 15, '2015-06-16 00:00:00', '2016-06-16', 123, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(133, 152, 'M04d63775', 'Mr', 'holly ', 'sheahan ', 'marc@vms.ie', 'clonshambo ', 'donadea', 'naas ', 'kildare', '', '0857723685', '', 0, '04d63775', 100000, 'k', 15, '2015-06-20 00:00:00', '2016-06-20', 124, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(134, 153, 'M05wx6236', 'Mr', 'darren', 'bedford', 'marc@vms', '21 mount drynan park ', 'kinsealy ', 'swords ', 'dublin ', '', '0857860301', '', 0, '05wx6236', 100000, 'k', 15, '2015-06-26 00:00:00', '2016-06-26', 125, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(135, 154, 'M06d11417', 'Mr', 'lisa ', 'egan', 'l.egan@hotmail.com', '171 lymewood mews', 'Northwood', 'santry ', 'dublin 9', '', '0857386476', '', 0, '06d11417', 100000, 'k', 15, '2015-06-28 00:00:00', '2016-06-28', 126, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(136, 155, 'M06d68632', 'Mr', 'gary ', 'skedgwell', 'marc@vms.ie', 'rathellen road ', 'leighlinbridge ', '', 'carlow ', '', '08583365718', '', 0, '06d68632', 100000, 'k', 15, '2015-06-29 00:00:00', '2016-06-29', 127, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(137, 156, 'M00d10890', 'Mr', 'raphaela ', 'sleafer', 'marc@vms.ie', '9b windmillands brackenstown swords  ', '', '', 'dublin ', '', '0857530290', '', 0, '00d10890', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 128, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(139, 158, 'M08d124640', 'Mr', 'paul ', 'elebert', 'marc@vms.ie', '24 chalfont road', '', 'malahide', 'Dublin', '', '0876408259', '', 0, '08d124640', 100000, 'k', 15, '2015-07-03 00:00:00', '2016-07-03', 130, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(144, 163, 'M12d45894', 'Ms', 'breege ', 'kelly ', 'senatorjohnkelly@gmail.com', 'the avenue', 'castlemore', 'ballaghaderreen', 'roscommon', '', '0868094698', '', 0, '12d45894', 100000, 'k', 15, '2015-10-26 00:00:00', '2016-10-26', 135, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(145, 164, 'M08d8784', 'Ms', 'deirdre', 'foley', 'marc@vms.ie', '30 oaklands park ', 'ballyjamesduff', '', 'cavan ', '', '0876123871', '', 0, '08d8784', 100000, 'k', 15, '2015-07-30 00:00:00', '2016-07-30', 136, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(146, 165, 'M06d41531', 'Mr', 'tom ', 'lawlor', 'marc@vms.ie', 'castletown', 'gorey', '', 'wexford', '', '0872250366', '', 0, '06d41531', 100000, 'k', 15, '2015-07-31 00:00:00', '2016-07-31', 137, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(147, 166, 'M03d2727', 'Mr', 'danielle', 'shannon', 'marc@vms.ie', '8 druid court', 'popintree', 'ballymun', 'dublin', '', '0863721129', '', 0, '03d2727', 100000, 'k', 15, '2015-08-07 00:00:00', '2016-08-07', 138, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(149, 168, 'M11mh669', 'Ms', 'gd', 'ceilings', 'marc@vms.ie', 'annahale', 'castleblaney ', '', 'monaghan', '', '0860415661', '', 0, '11mh669', 100000, 'k', 15, '2015-08-12 00:00:00', '2016-08-12', 140, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(150, 169, 'M06d84596', 'Mr', ' michelle ', 'bruton ', 'marc@vms.ie', 'barconey ', 'ballyjamesduff ', '', 'cavan ', '', '0857285010', '', 0, '06d84596', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 141, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(151, 170, 'M08ke6713', 'Ms', 'rhoda ', 'morales ', 'marc@vms.ie', '38 willow wood view ', 'hartstown ', 'clonsilla ', 'dublin 15', '', '0879277089', '', 0, '08ke6713', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 142, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(152, 171, 'M131rn717', 'Ms', 'bernie ', 'duffy', 'marc@vms.ie', 'kilcoleman ', 'ballaghaderreen ', '', 'roscommon', '', '0879124045', '', 0, '131rn717', 100000, 'k', 15, '2015-08-22 00:00:00', '2016-08-22', 143, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(153, 172, 'M131d27970', 'Mr', 'pat ', 'corless ', 'lewdpat@gmail.com', '44 ashleigh grove ', 'knock na carra ', '', 'galway ', '', '0860547249', '', 0, '131d27970', 100000, 'k', 15, '2015-08-26 00:00:00', '2016-08-26', 144, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(154, 173, 'M131d27707', 'Mr', 'john ', 'harding', 'marc@vms.ie', '25 abbeywell ', 'chapel road ', 'kinsealy ', 'dublin ', '', '0861211735', '', 0, '131d27707', 100000, 'k', 15, '2015-08-27 00:00:00', '2016-08-27', 145, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(155, 174, 'M131c7237', 'Ms', 'elaine ', 'hourigan', 'elaineh2010@hotmail.com', 'feenagh road ', 'ballyagran', 'killmanock', 'limerick', '', '0879131537', '', 0, '131c7237', 100000, 'k', 15, '2015-08-30 00:00:00', '2016-08-30', 146, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(156, 175, 'M11d35936', 'Mr', 'paul ', 'mcgann', 'ian@hainesfleet.ie', 'R.N.L.I', 'Airside retail  park', 'swords', 'dublin', '', '0879974038', '', 0, '11d35936', 100000, 'k', 15, '2015-08-20 00:00:00', '2016-08-20', 147, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(157, 176, 'M09d124417', 'Mr', 'ian ', 'flood', 'ian@hainesfleet.ie', 'haines fleet management ltd', 'independent fleet solutions', 'unit d airside business pk', '', '', '0879572086', '', 0, '09d124417', 100000, 'k', 15, '2015-08-20 00:00:00', '2016-08-20', 148, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(158, 177, 'M10d38628', 'Mr', 'ian', 'flood', 'ian@hainesfleet.ie', '	Haines Fleet Management Ltd', 'Independent Fleet Solutions', 'Unit D5, Airside Enterprise Centre', ' Airside, Swords, Co. Dublin.', '', '0879572086', '', 0, '10d38628', 100000, 'k', 15, '2015-08-20 00:00:00', '2016-08-20', 149, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(159, 178, 'M05d79265', 'Mr', 'ian', 'flood', 'ian@hainesfleet.ie', 'Haines Fleet Management Ltd', ' Independent Fleet Solutions', ' Unit D5 Airside Enterprise Centre', 'dublin', '', '0879572086', '', 0, '05d79265', 100000, 'k', 15, '2015-08-20 00:00:00', '2016-08-20', 150, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(160, 179, 'M09d124418', 'Mr', 'ian ', 'flood ', 'ian@hainesfleet.ie', 'Haines Fleet Management Ltd', ' Independent Fleet Solutions,', ' Unit D5, Airside Enterprise Centre', 'dublin', '', '0879572086', '', 0, '09d124418', 100000, 'k', 15, '2015-08-20 00:00:00', '2016-08-20', 151, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(161, 180, 'M08RN3063', 'Mr', 'sean', 'murphy', 'seaneenmurpf2@gmail.com', '19 meadow court', 'elm park', 'claremorris ', 'mayo', '', '0858257382', '', 0, '08RN3063', 100000, 'k', 15, '2015-08-20 00:00:00', '2016-08-20', 152, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-11 11:31:51'),
(162, 181, 'M11d38736', 'Mr', 'john ', 'maguire ', 'marc@vms.ie', '31 cherryfield court', 'hartstown', 'clonsilla', 'dublin15', '', '0871259477', '', 0, '11d38736', 100000, 'k', 15, '2015-08-20 00:00:00', '2016-08-20', 153, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(163, 182, 'M07d50914', 'Mr', 'clint', 'engelbrecht', 'marc@vms.ie', 'killinick village ', 'killinick', '', 'wexford', '', '0860647957', '', 0, '07d50914', 100000, 'k', 15, '2015-10-08 00:00:00', '2016-10-08', 154, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(164, 183, 'M05KE10973', 'Mr', 'Kim ', 'McKayed ', 'kim.mckayed@webelevate.ie', '', '', '', '', '', '0861514965', '', 0, '05KE10973', 100, 'k', 15, '2015-10-11 00:00:00', '2016-10-11', 155, 39, 248, 0, 0, 0, 1, 1, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(165, 184, 'M05KE10973', 'Mr', 'Kim', 'McKayed', 'kim.mckayed@webelevate.ie', '', '', '', '', '', '0861514965', '', 0, '05KE10973', 100, 'k', 15, '2015-10-11 00:00:00', '2016-10-11', 156, 39, 248, 0, 0, 0, 1, 1, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(166, 185, 'M05KE10973', 'Mr', 'Kamel ', 'McKayed', 'kim.mckayed@311-solutions.com', '', '', '', '', '', '0861514965', NULL, 0, '05KE10973', 100, 'k', 9, '2015-10-13 00:00:00', '2016-10-13', 157, 6, 3, 0, 1, 0, 1, 1, NULL, 0, 'customer', NULL, NULL),
(167, 187, 'M11D1774', 'Ms', 'gemma ', 'synnott', 'marc@vms.ie', '15 Riverwood Gardens', 'Castleknock', 'Dublin 15', '', '', '0862135535', '', 0, '11D1774', 100000, 'k', 15, '2015-10-10 00:00:00', '2016-10-10', 158, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(168, 188, 'M05KE10973', 'Mr', 'Kim', 'McKayed', 'kim.mckayed@webelevate.ie', '', '', '', '', '', '0861514965', NULL, 1, '05KE10973', 100, 'k', 9, '2015-10-18 00:00:00', '2016-10-18', 159, 6, 186, 1, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-02-05 12:19:40'),
(169, 189, 'M05c499', 'Mr', 'shane ', 'downey', 'shane.downey77@hotmail.com', '10 cedarfield close ', 'drogheda', 'co louth ', '', '', '1850227869', '', 0, '05c499', 100000, 'k', 15, '2015-10-25 00:00:00', '2016-10-25', 160, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:34:49'),
(170, 190, 'M07D55646', 'Ms', 'Orla ', 'Scanlon', 'scanlonorla@gmail.com', '26 birch drive ', 'johnstown ', 'navan ', '', '', '1850227869', '', 0, '07D55646', 100000, 'k', 9, '2015-10-25 00:00:00', '2016-10-25', 161, 6, 100, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(171, 191, 'M99D90054', 'Mr', 'lisa ', 'Warren', 'sales@cartow.ie', '121 Belmayne park south ', 'belgriffen ', '', 'Dublin 13', '', '1850227869', '', 0, '99D90054', 100000, 'k', 9, '2015-10-25 00:00:00', '2016-10-25', 162, 6, 100, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(172, 192, 'M11d45413', 'Mr', 'jim ', 'judge ', 'info@malahidecarsales.ie', '9 Barley Cove ', 'Wheaton Hall', 'drogheda ', 'Louth', '', '0862853863', '', 0, '11d45413', 100000, 'k', 15, '2015-10-27 00:00:00', '2016-10-27', 163, 39, 248, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, '2016-04-10 11:23:44'),
(173, 194, 'M07c14814', 'Mr', 'stefan', 'ludwig', 'stefan.cork@gmail.com', 'gate lodge', 'east grove', 'cobh', 'cork', '0002', '0864403689', NULL, 0, '07c14814', 141000, 'k', 5, '2015-10-31 00:00:00', '2016-10-31', 164, 14, 186, 1, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(174, 197, 'M02D82004', 'Ms', 'Zoe', 'Wakerley', 'zwakerley@gmail.com', 'Charlesfort', 'Tombrack', 'Ferns,', 'Wexford', 'Y21 YV12', '+353872913146', NULL, 0, '02D82004', 151487, 'm', 5, '2015-11-04 00:00:00', '2016-11-04', 165, 14, 186, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(175, 198, 'M02ce4413', 'Mr', 'Gerard', 'Rellis', 'gerryrellis@yahoo.com', '5 clonmore hall', 'Piltown', 'Piltown', 'Kilkenny', 'E32 ER88', '0866000656', NULL, 0, '02ce4413', 155000, 'k', 5, '2015-11-04 00:00:00', '2016-11-04', 166, 14, 186, 0, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(176, 202, 'M08DL5746', 'Mr', 'DESIREE', 'CASBURN', 'desiree.casburn@gmail.com', '', '', '', '', '', '0879957775', '', 0, '08DL5746', 100000, 'k', 5, '2015-11-14 00:00:00', '2016-11-14', 167, 6, 3, 0, 0, 0, 1, 0, '2016-01-25 09:36:41', 0, 'customer', NULL, NULL),
(177, 203, 'M07WW7076', 'Mr', 'BUISH', 'VINCENT', 'OBRIENSOUTSIDECATERING@EIRCOM.NET', 'IRISH LIFE MALL TALBOT STREET', 'TALBOT STREET', 'DUBLIN', 'DUBLIN ', '', '0872995450', '', 0, '07WW7076', 151000, 'k', 1, '2015-11-15 00:00:00', '2016-11-15', 168, 6, 193, 1, 0, 0, 1, 0, NULL, 0, 'customer', NULL, NULL),
(178, 214, 'M03OY2504', 'Mr', 'DARREN ', 'JOHNSON ', 'DARREN.JOHNSON@CROSSINGS.IE', 'DONARD WALK', 'BLACKHORSE AVENUE ', '', 'DUBLIN 7', '', '0879209955', '', 0, '03OY2504', 1000000, 'k', 8, '2015-07-01 00:00:00', '2016-07-01', 169, 6, 100, 0, 1, 1, 1, 0, NULL, 0, 'customer', NULL, NULL),
(179, 217, 'M06d13140', 'Mr', 'John', 'Test', 'john.dowling@cartow.ie', '', NULL, NULL, NULL, NULL, '0876666811', '-3', 0, '06d13140', 50000, 'm', 19, '2015-11-20 00:00:00', '2016-11-20', 170, 6, 93, 1, 1, 1, 1, 1, '2016-01-15 09:53:36', 0, 'customer', NULL, NULL),
(180, 221, 'M07c8618', 'Ms', 'ciara ', 'obrien ', 'sales@cartow.ie', '30 ceader park ', 'oldlawn house ', 'lexlip', 'dublin', NULL, '0866482394', NULL, 0, '07c8618', 100000, 'k', 19, '2015-11-30 00:00:00', '2016-11-30', 171, 6, 100, 0, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(181, 222, 'M05ts2656', 'Mr', 'Dean', 'Madden', 'dean.madden@aerarann.com', '11 Russell Lawn', 'Fr. Russell Road', 'Limerick', 'Limerick', '', '0857412976', '', 0, '05ts2656', 210000, 'k', 20, '2015-12-05 00:00:00', '2016-12-05', 172, 6, 93, 0, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(182, 223, 'M03WW4487', 'Ms', 'Emma', 'Ward', 'accessdrains@hotmail.com', '26 Northway Estateq', 'Finglas', 'Dublin', 'Dublin', NULL, '0863393729', NULL, 0, '03WW4487', 129069, 'K', 9, '2015-12-26 00:00:00', '2016-12-26', 173, 6, 186, 1, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(183, 224, 'M03WW4487', 'Ms', 'Emma', 'Ward', 'accessdrains@hotmail.com', '26 Northway Estateq', 'Finglas', 'Dublin', 'Dublin', NULL, '0863393729', NULL, 0, '03WW4487', 129069, 'K', 9, '2015-12-26 00:00:00', '2016-12-26', 174, 6, 186, 1, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(184, 225, 'M04LS1197', 'Mr', 'Gavin', 'Ward', 'accessdrains@hotmail.com', '26 Northway Estateq', 'Finglas', 'Dublin', 'Dublin', NULL, '0863393729', NULL, 0, '04LS1197', 115462, 'K', 9, '2015-12-26 00:00:00', '2016-12-26', 175, 6, 186, 1, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(185, 226, 'M05D7975', 'Mrs', 'Michelle', 'Bourke', 'michelletbourke@gmail.com', '14 Peyton View', 'Stoney lane', 'Rathcoole', 'Co Dublin', 'Dublin', '0876455488', NULL, 0, '05D7975', 55000, 'm', 9, '2016-01-08 00:00:00', '2017-01-08', 176, 6, 186, 1, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(186, 227, 'M01DL9709', 'Mr', 'Hitesh', 'Singh', 'hiteshswork@gmail.com', '67 Brighton Road', 'Rathgar', 'Dublin', 'Dublin', '06', '0899788708', NULL, 0, '01DL9709', 129000, 'k', 9, '2016-01-15 00:00:00', '2017-01-15', 177, 6, 186, 1, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(187, 228, 'M04D35666', 'Mr', 'tommy ', 'Gorman ', 'tommygorman210@hotmail.com', '84 walnut rise ', 'drumcondra ', 'dublin 9', '', '', '018379807', '', 0, '04D35666', 140000, 'm', 1, '2016-01-17 00:00:00', '2017-01-17', 178, 6, 100, 0, 0, 0, 0, 1, '2016-01-15 09:26:46', 1, 'customer', NULL, NULL),
(188, 229, 'M04d35666', 'Mr', 'tommy ', 'Gorman ', 'tommygorman210@hotmail.com', '84 walnut rise ', 'drumcondra ', 'dublin 9', '', '', '018379807', '', 0, '04d35666', 140000, 'm', 1, '2016-01-17 00:00:00', '2017-01-17', 179, 6, 100, 0, 0, 0, 0, 0, '2016-01-15 09:26:35', 1, 'customer', NULL, NULL),
(190, 231, 'M04D35666', 'Mr', 'tommy ', 'Gorman ', 'tommygorman210@hotmail.com', '84 walnut rise ', 'drumcondra ', 'dublin 9', 'dublin', NULL, '0868107170', NULL, 0, '04D35666', 140000, 'm', 9, '2016-01-17 00:00:00', '2017-01-17', 181, 6, 186, 1, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(191, 232, 'M08D74716', 'Ms', 'Anne', 'McCabe', 'mccabeanne@hotmail.com', '', '', '', '', '', '0879181888', NULL, 0, '08D74716', 157000, 'm', 5, '2016-01-19 00:00:00', '2017-01-19', 182, 14, 186, 1, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(192, 233, 'M11D8641', 'Mr', 'Brendan', 'Ryan', 'brendan_ryan1@icloud.com', '', '', '', '', '', '0862684054', NULL, 0, '11D8641', 215000, 'k', 5, '2016-01-19 00:00:00', '2017-01-19', 183, 14, 186, 1, 1, 1, 1, 0, NULL, 1, 'customer', NULL, NULL),
(193, 234, 'M05D51104', 'Mr', 'RONAN', 'MARKEY', 'ronanm98@yahoo.com', '16 Willowbrook ', 'Letterkenny ', '', 'donegal', '', '0877866079', '4', 0, '05D51104', 160000, 'k', 19, '2016-01-23 00:00:00', '2017-01-23', 184, 6, 100, 0, 0, 0, 0, 0, '2016-01-20 11:45:24', 1, 'customer', NULL, NULL),
(194, 235, 'M05d51104', 'Mr', 'ronan', 'Markey', 'ronanm98@yahoo.com', '16 willowbrook', 'letterkenny ', '', 'donegal', '', '0877866079', '', 0, '05d51104', 160000, 'k', 19, '2016-01-20 00:00:00', '2017-01-20', 185, 6, 100, 0, 0, 0, 0, 0, NULL, 1, 'customer', NULL, NULL),
(195, 237, 'M07D48227', 'Mr', 'steven ', 'byatt', 'sales@cartow.ie', 'baloran road ', 'louth village', 'louth ', '', '', '0831549485', '', 0, '07D48227', 1440000, 'k', 9, '2016-01-23 00:00:00', '2017-01-23', 186, 6, 236, 0, 0, 0, 0, 0, NULL, 1, 'customer', NULL, NULL),
(196, 238, 'M07KE4563', 'Mr', 'William', 'Kavanagh', 'sales@airwaysmotorcompany.ie', '82 Charlesland wood', 'greystones', '', 'Wicklow', '', '018084508', '', 0, '07KE4563', 134000, 'k', 21, '2016-01-25 00:00:00', '2017-01-25', 187, 6, 3, 0, 0, 0, 0, 0, NULL, 1, 'customer', NULL, NULL),
(197, 240, 'M00d114488', 'Mr', 'lesley', 'leonard', 'lesleyleonard55@gmail.com', '55 Wellmount cresent ', 'finglas', '', 'dublin ', '11', '0868474234', NULL, 6, '00d114488', 234000, 'k', 9, '2016-02-04 00:00:00', '2017-02-04', 188, 6, 186, 0, 0, 0, 0, 0, NULL, 1, 'customer', NULL, '2016-02-10 11:19:13'),
(198, 241, 'Mv5', 'Mr', 'Shady', 'Keshk', 'shady.keshk2@311-solutions.com', 'tawinat monkhafad el takalif b', '', 'suez', 'fisal', '43221', '0020120584176', '', 1, 'v5', 1200, 'k', 5, '2016-02-08 00:00:00', '2017-02-08', 189, 6, 3, 0, 0, 0, 0, 0, NULL, 1, 'customer', '2016-02-05 11:25:14', '2016-02-05 13:02:41'),
(199, 244, 'M02ce4801', 'Mr', 'marc ', 'mcgrath', 'marcmcgrath91@gmail.com', '51 The Green, Larch Hill, Oscar Traynor Road, Coolock, Dublin 17', NULL, NULL, 'dublin', NULL, '0874637542', NULL, 1, '02ce4801', 198000, 'k', 15, '2015-12-11 00:00:00', '2016-12-11', 190, 39, 248, 0, 0, 0, 0, 0, NULL, 1, 'customer', '2016-02-05 12:05:10', '2017-10-23 15:21:20'),
(200, 249, 'Mv5', NULL, 'shady', 'wallas', 'shadywallas9@gmail.com', 'asdf', NULL, NULL, NULL, NULL, '123185', NULL, 0, 'v5', 1200, 'km', 15, '0000-00-00 00:00:00', '0000-00-00', 191, 39, 248, 0, 0, 0, 0, 0, NULL, 0, 'customer', '2016-02-07 12:38:36', '2016-02-07 12:38:36'),
(201, 250, 'Mv5', NULL, 'shady', 'wallas', 'shadywallas10@gmail.com', 'asdf', NULL, NULL, NULL, NULL, '123185', NULL, 0, 'v5', 1200, 'km', 15, '2016-02-10 00:00:00', '2017-02-10', 192, 39, 248, 0, 0, 0, 0, 0, NULL, 0, 'customer', '2016-02-07 12:42:40', '2016-02-07 12:42:40'),
(202, 251, 'Mv5', NULL, 'shady', 'wallas', 'shadywallas111@gmail.com', 'asdf', NULL, NULL, NULL, NULL, '123185', NULL, 3, 'v5', 1200, 'km', 15, '2016-02-10 00:00:00', '2017-02-10', 99, 39, 248, 0, 0, 0, 0, 0, NULL, 0, 'customer', '2016-02-10 07:13:08', '2016-02-10 12:54:47'),
(203, 252, 'Mv5', 'Mr', 'raef', 'elsherbiny', 'raef_elsherbiny@yahoo.com', 'Hod Aldars .suez', NULL, NULL, 'السويس', NULL, '201060006574', NULL, 0, 'v5', 23232, 'k', 5, '2016-03-09 00:00:00', '2017-03-09', 100, 6, 3, 0, 0, 0, 0, 0, NULL, 1, 'customer', '2016-03-06 12:31:56', '2016-03-24 08:32:17'),
(204, 256, 'Mv5', 'Mr', 'Mohamed', 'Fayez', 'mohamedfz_1@hotmail.com', '', '', '', '', '', '123123123', NULL, 2, 'v5', 1200, 'k', 9, '2017-07-13 18:46:42', '2018-07-13', 102, 6, 186, 1, 0, 0, 0, 0, NULL, 1, 'customer', '2016-04-10 14:27:09', '2017-10-08 18:07:59'),
(205, 257, 'M08W1605', NULL, 'VMS', 'TEST', 'justin.kavanagh@gmail.com', 'VMW TEST', NULL, NULL, NULL, NULL, '858503006', NULL, 1, '08W1605', 100000, 'km', 15, '2017-05-15 00:00:00', '2018-05-15', 103, 39, 248, 0, 0, 0, 0, 0, NULL, 0, 'customer', '2016-06-16 11:20:17', '2017-05-15 14:03:54'),
(209, 261, 'M08W1605', NULL, 'VMS', 'TEST', 'mohamedfz_1@yahoo.com', 'VMW TEST', NULL, NULL, NULL, NULL, '858503006', NULL, 1, '08W1605', 100000, 'km', 15, '2016-05-28 00:00:00', '2016-08-27', 107, 39, 248, 0, 0, 0, 1, 0, '2017-05-15 12:01:31', 0, 'customer', '2016-06-16 11:40:55', '2017-05-15 12:01:31'),
(214, 262, 'Mv5', NULL, 'Test', 'Fleet', 'sherifa.mazhar@311-solutions.com', '17 test st.', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v5', 0, 'k', 9, '2017-06-25 00:00:00', '2018-06-25', 117, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-06-22 10:55:22', '2017-06-22 10:55:22'),
(215, 262, 'Mv5', NULL, 'Test', 'Fleet', 'sherifa.mazhar@311-solutions.com', '17 test st.', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v5', 0, 'k', 9, '2017-06-25 00:00:00', '2018-06-25', 118, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-06-22 10:55:22', '2017-06-22 10:55:22'),
(216, 262, 'Mv55', NULL, 'Test', 'Fleet', 'sherifa.mazhar@311-solutions.com', '17 ahmed st', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v55', 0, 'k', 5, '2017-06-25 00:00:00', '2018-06-25', 119, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-06-22 11:02:04', '2017-06-22 11:02:04'),
(217, 262, 'Mv555', NULL, 'Test', 'Fleet', 'sherifa.mazhar@311-solutions.com', '17 ahmed st', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v555', 0, 'k', 5, '2017-06-25 00:00:00', '2018-06-25', 120, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-06-22 11:02:04', '2017-06-22 11:02:04'),
(218, 262, 'Mv55', NULL, 'Test', 'Fleet', 'sherifa.mazhar@311-solutions.com', '17 ahmed st', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v55', 0, 'k', 5, '2017-06-25 00:00:00', '2018-06-25', 121, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-06-22 11:02:53', '2017-06-22 11:02:53'),
(219, 262, 'Mv555', NULL, 'Test', 'Fleet', 'sherifa.mazhar@311-solutions.com', '17 ahmed st', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v555', 0, 'k', 5, '2017-06-25 00:00:00', '2018-06-25', 122, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-06-22 11:02:53', '2017-06-22 11:02:53'),
(220, 262, 'Mv23', NULL, 'Hamada', 'Esmat', 'sherifa.mazhar@311-solutions.com', '2 Test St.', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v23', 0, 'k', 9, '2018-09-01 00:00:00', '2019-09-01', 125, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-07-05 19:52:31', '2017-07-05 19:52:31'),
(221, 262, 'Mv5', NULL, 'Mohamed', 'Fayez', 'sherifa.mazhar@311-solutions.com', '2 Test St.', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v5', 0, 'k', 9, '2017-01-09 00:00:00', '2018-01-09', 126, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-07-12 12:03:38', '2017-07-12 12:03:38'),
(222, 262, 'Mv5', NULL, 'Mohamed', 'Fayez', 'sherifa.mazhar@311-solutions.com', '2 Test St.', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v5', 0, 'k', 9, '2017-01-09 00:00:00', '2018-01-09', 127, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-07-12 12:04:25', '2017-07-12 12:04:25'),
(223, 262, 'Mv5', NULL, 'Mohamed', 'Fayez', 'sherifa.mazhar@311-solutions.com', '2 Test St.', NULL, NULL, NULL, NULL, '0123456789', NULL, 0, 'v5', 0, 'k', 9, '2017-01-09 00:00:00', '2018-01-09', 128, 6, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-07-12 12:11:48', '2017-07-12 12:11:48'),
(225, 200, 'Mv5', NULL, 'Mohamed', 'Hamada', 'mohamed.fayez@311-solutions.com', '28 El Falaky st', NULL, NULL, NULL, NULL, '123123123', NULL, 0, 'v5', 0, 'k', 9, '2017-10-01 00:00:00', '2018-10-01', 130, 33, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-07-12 17:13:52', '2017-07-12 17:13:52'),
(230, 89, 'Mv5', NULL, 'Mahamad', 'Fawaz', 'paulcartow@gmail.com', 'Dublin Ireland', NULL, NULL, NULL, NULL, '123456789', NULL, 0, 'v5', 0, 'k', 9, '2018-07-15 12:41:29', '2018-07-15', 136, 33, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-07-13 10:41:29', '2017-07-13 10:41:29'),
(231, 89, 'Mv5', NULL, 'Mahamad', 'Fawaz', 'paulcartow@gmail.com', 'Dublin Ireland', NULL, NULL, NULL, NULL, '123456789', NULL, 0, 'v5', 0, 'k', 9, '2018-07-15 12:42:56', '2018-07-15', 137, 33, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-07-13 10:42:56', '2017-07-13 10:42:56'),
(232, 89, 'Mv5', NULL, 'Mahamad', 'Fawaz', 'paulcartow@gmail.com', 'Dublin Ireland', NULL, NULL, NULL, NULL, '123456789', NULL, 1, 'v5', 0, 'k', 9, '2017-07-15 12:43:31', '2018-07-15', 138, 33, 3, 0, 0, 0, 0, 0, NULL, 0, 'fleet', '2017-07-13 10:43:31', '2017-10-02 21:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `customers_services`
--

CREATE TABLE `customers_services` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `bringg_id` varchar(255) NOT NULL,
  `client_company` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `vehicle_address` varchar(255) DEFAULT NULL,
  `vehicle_lat` varchar(255) DEFAULT NULL,
  `vehicle_lon` varchar(255) DEFAULT NULL,
  `vehicle_dest` varchar(255) DEFAULT NULL,
  `dest_lat` varchar(255) DEFAULT NULL,
  `dest_lon` varchar(255) DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers_services`
--

INSERT INTO `customers_services` (`id`, `customer_id`, `service_id`, `bringg_id`, `client_company`, `note`, `vehicle_address`, `vehicle_lat`, `vehicle_lon`, `vehicle_dest`, `dest_lat`, `dest_lon`, `added_by`, `updated_at`, `created_at`) VALUES
(1, 197, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 09:15:27', '2016-02-10 09:15:27'),
(2, 197, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 09:18:46', '2016-02-10 09:18:46'),
(3, 197, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 09:18:51', '2016-02-10 09:18:51'),
(4, 197, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 09:18:57', '2016-02-10 09:18:57'),
(5, 197, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 09:19:00', '2016-02-10 09:19:00'),
(6, 197, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 09:19:13', '2016-02-10 09:19:13'),
(7, 202, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 10:53:03', '2016-02-10 10:53:03'),
(8, 202, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 10:53:07', '2016-02-10 10:53:07'),
(9, 202, 1, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 10:54:47', '2016-02-10 10:54:47'),
(10, 209, 1, '', NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-10-13 09:57:09', '2016-10-13 09:57:09'),
(11, 205, 2, '', NULL, 'test note', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-15 12:03:54', '2017-05-15 12:03:54'),
(12, 78, 1, '', NULL, 'Test note', NULL, '53.35109', '-6.27388', '', NULL, NULL, NULL, '2017-09-27 17:25:26', '2017-09-27 17:25:26'),
(13, 232, 5, '8573507', NULL, 'Test Note', NULL, '53.34262', '-6.26771', 'The Parnell Centre, Parnell St, Rotunda, Dublin 1', NULL, NULL, NULL, '2017-10-02 19:12:38', '2017-10-02 19:12:38'),
(14, 204, 4, '', 'Mapfre', 'Test note', NULL, '53.33730', '-6.26121', 'Smithfield/Queen Street Car Park, Queen st, Dublin', NULL, NULL, NULL, '2017-10-08 15:56:04', '2017-10-08 15:56:04'),
(15, 204, 4, '', 'Mapfre', 'Test note', NULL, '53.33730', '-6.26121', 'Smithfield/Queen Street Car Park, Queen st, Dublin', '53.34887', '-6.27966', NULL, '2017-10-08 16:07:59', '2017-10-08 16:07:59'),
(16, 199, 1, '', 'CarTow.ie', '', NULL, '53.34821', '-6.27472', '', NULL, NULL, NULL, '2017-10-23 14:21:20', '2017-10-23 14:21:20'),
(17, 82, 3, '', 'CarTow.ie', 'Main note', NULL, '53.33003', '-6.25510', '', NULL, NULL, NULL, '2017-10-29 18:34:59', '2017-10-29 18:34:59'),
(18, 82, 2, '', 'CarTow.ie', 'Main note', NULL, '53.33385', '-6.25744', '', NULL, NULL, NULL, '2017-10-29 18:40:38', '2017-10-29 18:40:38'),
(19, 82, 3, '', 'CarTow.ie', 'asdf', NULL, '53.33494', '-6.25790', 'Smithfield/Queen Street Car Park, Queen st, Dublin', NULL, NULL, NULL, '2017-10-29 18:45:53', '2017-10-29 18:45:53'),
(20, 82, 5, '', 'CarTow.ie', 'main note', NULL, '53.33065', '-6.25216', 'Smithfield/Queen Street Car Park, Queen st, Dublin', NULL, NULL, NULL, '2017-10-29 18:47:02', '2017-10-29 18:47:02'),
(21, 82, 6, '', 'CarTow.ie', 'main note', NULL, '53.33343', '-6.25597', '', NULL, NULL, NULL, '2017-10-29 18:48:23', '2017-10-29 18:48:23'),
(22, 82, 3, '', 'CarTow.ie', 'test note', NULL, '53.32497', '-6.25552', 'Smithfield/Queen Street Car Park, Queen st, Dublin', NULL, NULL, NULL, '2017-10-29 18:50:02', '2017-10-29 18:50:02'),
(23, 82, 4, '8822063', 'CarTow.ie', 'test note', NULL, '53.33687', '-6.27289', 'Smithfield/Queen Street Car Park, Queen st, Dublin', NULL, NULL, 'test man', '2017-10-29 18:53:57', '2017-10-29 18:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `customers_trial`
--

CREATE TABLE `customers_trial` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `expiration_date` date NOT NULL,
  `myvehicle_ref` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers_trial`
--

INSERT INTO `customers_trial` (`id`, `first_name`, `last_name`, `address_line`, `start_date`, `expiration_date`, `myvehicle_ref`, `created_at`, `updated_at`) VALUES
(1, 'test', 'user', '123 teest st', '2018-02-15', '2018-02-25', '12345', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_activities`
--

CREATE TABLE `customer_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `activity_type_id` int(10) DEFAULT NULL,
  `entry_by` int(10) DEFAULT NULL,
  `note` text,
  `user_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at_integer` int(11) DEFAULT NULL,
  `updated_at_integer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department`) VALUES
(1, 'Finance'),
(2, 'Administration');

-- --------------------------------------------------------

--
-- Table structure for table `fleets`
--

CREATE TABLE `fleets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `membership_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fleets`
--

INSERT INTO `fleets` (`id`, `name`, `company_id`, `membership_id`, `created_at`, `updated_at`) VALUES
(3, 'Test Fayez', 0, 25, '2017-07-26 21:06:50', '2017-07-26 21:06:50'),
(4, 'Test Fayez', 0, 25, '2017-07-26 21:07:24', '2017-07-26 21:07:24'),
(5, 'Test Fayez', 0, 25, '2017-07-26 21:07:32', '2017-07-26 21:07:32'),
(6, 'Test Fayez', 0, 25, '2017-07-26 21:08:20', '2017-07-26 21:08:20'),
(7, 'Test Fayez', 0, 25, '2017-07-26 21:09:43', '2017-07-26 21:09:43'),
(8, 'Test Fayez', 0, 25, '2017-07-26 21:12:13', '2017-07-26 21:12:13'),
(9, 'Test Fayez', 0, 25, '2017-07-26 21:14:24', '2017-07-26 21:14:24'),
(10, 'Test Fayez', 0, 25, '2017-07-26 21:19:49', '2017-07-26 21:19:49'),
(11, 'Test Fayez', 0, 25, '2017-07-26 21:20:39', '2017-07-26 21:20:39'),
(12, 'Test Fayez', 0, 25, '2017-07-26 21:22:50', '2017-07-26 21:22:50'),
(13, 'Test Fayez', 0, 25, '2017-07-26 21:24:58', '2017-07-26 21:24:58'),
(14, 'Test Fayez', 0, 25, '2017-07-26 21:27:50', '2017-07-26 21:27:50'),
(15, 'Test Fayez', 0, 25, '2017-07-26 21:28:03', '2017-07-26 21:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `fleet_members`
--

CREATE TABLE `fleet_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `fleet_id` int(10) UNSIGNED NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fleet_members`
--

INSERT INTO `fleet_members` (`id`, `fleet_id`, `member_id`, `created_at`, `updated_at`) VALUES
(4, 5, 225, '2017-07-12 19:13:52', '2017-07-12 19:13:52'),
(9, 5, 230, '2017-07-13 12:41:29', '2017-07-13 12:41:29'),
(10, 5, 231, '2017-07-13 12:42:56', '2017-07-13 12:42:56'),
(11, 5, 232, '2017-07-13 12:43:31', '2017-07-13 12:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `login_account_types`
--

CREATE TABLE `login_account_types` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_account_types`
--

INSERT INTO `login_account_types` (`id`, `type`) VALUES
(1, 'Master'),
(2, 'Subuser'),
(3, 'Company'),
(4, 'Agent'),
(5, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `master_accounts`
--

CREATE TABLE `master_accounts` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `department` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_accounts`
--

INSERT INTO `master_accounts` (`id`, `first_name`, `last_name`, `department`) VALUES
(6, 'Sherifa', 'Mazhar', 1),
(7, 'Master', 'Account', 2),
(8, 'Ken', 'Morgan', 2),
(9, 'Ken', 'Morgan', 2);

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `membership_name` varchar(100) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  `number_of_callouts` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `membership_name`, `price`, `duration`, `code`, `number_of_callouts`, `deleted_at`) VALUES
(1, 'Membership 1', '0.00', '12 months', 'CT01', NULL, '2016-01-15 09:28:02'),
(2, 'Membership 2', '0.00', '6 months', 'CT02', NULL, '2016-01-15 09:28:16'),
(4, 'Membership 3', '5.00', '12 months', 'CTMBR', NULL, '2016-01-15 09:28:39'),
(5, 'APL Membership', '14.50', '12 months', 'APLMB', NULL, NULL),
(7, 'Finance Gold', '20.00', '12 months', 'FAMBR', NULL, '2016-01-15 09:29:35'),
(8, 'Diane', '25.00', '12 months', 'DCT', NULL, '2016-01-15 09:29:50'),
(9, 'Web Membership', '39.95', '12 months', 'CTWM', NULL, NULL),
(11, 'Dan', '100.00', '12 months', 'DNCT', 3, '2016-01-15 09:29:20'),
(12, '7 Day Auto', '30.75', '12 months', 'SDA', 3, NULL),
(13, 'TalbotMB', '25.00', '3 months', 'TBMB', 6, '2016-01-26 09:34:59'),
(14, 'paul mb', '15.00', '3 months', 'pmb', 1, '2016-01-15 09:30:02'),
(15, 'VMS', '25.00', '12 months', 'VMSMB', 3, NULL),
(16, 'A2B', '24.60', '12 months', 'A2BMEM', 3, NULL),
(19, 'Cash Customer Discounted', '29.95', '12 months', 'CCD', 3, NULL),
(20, 'Group Value Network', '30.00', '12 months', 'GVN', 3, NULL),
(21, 'Dealer', '25.00', '12 months', 'DEALMEM', 3, NULL),
(22, 'Cheap ', '1.00', '1 months', 'cheap', 1, NULL),
(23, 'VMS 3 Month', '10.00', '3 months', 'VMS3', 1, NULL),
(24, 'VMS 6 Month', '15.00', '6 months', 'VMS6', 1, NULL),
(25, 'Fayez', '30.00', '12', 'Fezo', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table', 1),
('2014_10_12_000000_create_users_table', 2),
('2014_10_12_100000_create_password_resets_table', 1),
('2014_10_12_000000_create_users_table', 2),
('2015_08_04_135218_create_company_payment_method_table', 3),
('2015_08_04_135408_create_payment_methods_table', 3),
('2014_10_12_100000_create_password_resets_table', 1),
('2014_10_12_000000_create_users_table', 2),
('2014_07_02_230147_migration_cartalyst_sentinel', 4);

-- --------------------------------------------------------

--
-- Table structure for table `next_of_kin`
--

CREATE TABLE `next_of_kin` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `next_of_kin`
--

INSERT INTO `next_of_kin` (`id`, `first_name`, `last_name`, `phone_number`, `address`) VALUES
(1, 'Sherifa', 'Mazhar', '0123456789', '4 address St.'),
(2, '', '', '', ''),
(3, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `non_member_services`
--

CREATE TABLE `non_member_services` (
  `id` int(11) NOT NULL,
  `bringg_id` varchar(255) NOT NULL,
  `vehicle_reg` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `service_id` int(11) NOT NULL,
  `client_company` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `vehicle_address` varchar(255) DEFAULT NULL,
  `vehicle_lat` varchar(255) DEFAULT NULL,
  `vehicle_lon` varchar(255) DEFAULT NULL,
  `vehicle_dest` varchar(255) DEFAULT NULL,
  `dest_lat` varchar(255) DEFAULT NULL,
  `dest_lon` varchar(255) DEFAULT NULL,
  `to_pay` varchar(255) DEFAULT NULL,
  `override_reason` varchar(1000) DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'complete',
  `completed_by` varchar(255) DEFAULT NULL,
  `assigned_due_time` datetime DEFAULT NULL,
  `due_time` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `non_member_services`
--

INSERT INTO `non_member_services` (`id`, `bringg_id`, `vehicle_reg`, `customer_name`, `customer_phone`, `service_id`, `client_company`, `note`, `vehicle_address`, `vehicle_lat`, `vehicle_lon`, `vehicle_dest`, `dest_lat`, `dest_lon`, `to_pay`, `override_reason`, `added_by`, `status`, `completed_by`, `assigned_due_time`, `due_time`, `updated_at`, `created_at`) VALUES
(1, '', 'v512', 'John Fayez', '0123456789', 3, 'Mapfre', 'Test note', NULL, '53.33846', '-6.26193', '', '53.34766', '-6.28444', 'Override', 'because this', '', 'complete', NULL, NULL, NULL, '2017-10-08 18:15:50', '2017-10-08 18:15:50'),
(2, '11106664', 'v5', 'John Fayez', '0123456789', 4, 'Mapfre', 'Test note', NULL, '53.33644', '-6.25836', 'The Parnell Centre, Parnell St, Rotunda, Dublin 1', NULL, NULL, '', NULL, NULL, 'complete', 'CEO of Cartow', NULL, NULL, '2018-03-06 15:25:30', '2017-10-16 12:44:15'),
(3, '', 'N/A', 'CarTow.ie', '', 0, 'CarTow.ie', '', NULL, '53.35645', '-6.30343', '', NULL, NULL, '', NULL, NULL, 'complete', NULL, NULL, NULL, '2017-10-19 19:54:03', '2017-10-19 19:54:03'),
(4, '11106939', 'v5', 'asd', '1234', 1, 'CarTow.ie', '', '1-3 Brighton Square, Dublin, Ireland', '53.31514', '-6.27903', 'Ashbourne, Ireland', NULL, NULL, '', NULL, NULL, 'complete', 'CEO of Cartow', NULL, NULL, '2018-03-14 08:20:44', '2017-12-21 11:00:23'),
(5, '11875211', 'v5', '7amada', '0123456789', 1, 'CarTow.ie', '', 'Guinness Storehouse, Market Street South, Ushers, Dublin 8, Ireland', '53.34181', '-6.28672', 'University College Dublin, Belfield, Dublin 4, Ireland', NULL, NULL, 'Client to pay', '', 'CEO of Cartow', 'open', 'CEO of Cartow', NULL, NULL, '2018-03-06 12:00:20', '2018-03-04 16:23:21'),
(6, '11640238', 'v5', 'ahmed', '0123456789', 1, 'CarTow.ie', '', 'Guinness Storehouse, Market Street South, Ushers, Dublin 8, Ireland', '53.34181', '-6.28672', 'University College Dublin, Belfield, Dublin 4, Ireland', NULL, NULL, 'Customer to pay', '', 'CEO of Cartow', 'open', NULL, NULL, '2018-03-07 04:22:00', '2018-03-19 12:03:33', '2018-03-07 14:42:23'),
(7, '', 'v5', 'asdf', '012345', 4, 'CarTow.ie', '', 'Guinness Storehouse, Market St S, Ushers, Dublin 8, Ireland', '53.34194', '-6.28693', 'University College Dublin, Belfield, Dublin 4, Ireland', NULL, NULL, 'Client to pay', '', 'CEO of Cartow', 'open', NULL, '2018-03-18 14:09:47', '2018-03-18 12:24:47', '2018-03-18 11:39:47', '2018-03-18 11:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(140) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `text`, `is_read`, `created_at`) VALUES
(1, 3, 'A company account for Test Company was created successfully', 1, 1436273773),
(2, 3, 'A company account for Test Company was created successfully', 1, 1436274296),
(3, 3, 'A company account for Test Company was created successfully', 1, 1436274501),
(4, 29, 'An agent account for Sherifa Mazhar was created successfully', 0, 1436275236),
(5, 3, 'An agent account for Sherifa Mazhar was created successfully by test.company', 1, 1436275236),
(6, 25, 'An agent account for Sherifa Mazhar was created successfully by test.company', 0, 1436275236),
(7, 29, 'Sherifa was added successfully as a customer', 0, 1436276011),
(8, 3, 'Sherifa was added successfully as a customer by test.company', 1, 1436276011),
(9, 25, 'Sherifa was added successfully as a customer by test.company', 0, 1436276011),
(10, 30, 'Sherifa was added successfully as a customer', 0, 1436276317),
(11, 3, 'Sherifa was added successfully as a customer by new.agent', 1, 1436276317),
(12, 25, 'Sherifa was added successfully as a customer by new.agent', 0, 1436276317),
(13, 3, 'A company account for Talbot Motors was created successfully', 1, 1436349581),
(14, 31, 'Tommy was added successfully as a customer', 0, 1436350234),
(15, 3, 'Tommy was added successfully as a customer by Talbot', 1, 1436350234),
(16, 25, 'Tommy was added successfully as a customer by Talbot', 0, 1436350234),
(17, 10, 'Sherifa was added successfully as a customer', 0, 1436350247),
(18, 3, 'Sherifa was added successfully as a customer by test company', 1, 1436350247),
(19, 25, 'Sherifa was added successfully as a customer by test company', 0, 1436350247),
(20, 3, 'A company account for Finance Test was created successfully', 1, 1436357091),
(21, 3, 'A company account for Diane\'s Garage was created successfully', 1, 1436369972),
(22, 3, 'Sherifa was added successfully as a customer through the CarTow.ie Membership form', 1, 1436707606),
(23, 25, 'Sherifa was added successfully as a customer through the CarTow.ie Membership form', 0, 1436707606),
(24, 32, 'Sherifa was added successfully as a customer through the CarTow.ie Membership form', 0, 1436707606),
(25, 3, 'Sherifa was added successfully as a customer through the CarTow.ie Membership form', 1, 1437059626),
(26, 25, 'Sherifa was added successfully as a customer through the CarTow.ie Membership form', 0, 1437059626),
(27, 32, 'Sherifa was added successfully as a customer through the CarTow.ie Membership form', 0, 1437059626),
(28, 3, 'Dan was added successfully as a customer', 1, 1437060406),
(29, 3, 'Kim was added successfully as a customer through the CarTow.ie Membership form', 1, 1437063850),
(30, 25, 'Kim was added successfully as a customer through the CarTow.ie Membership form', 0, 1437063850),
(31, 32, 'Kim was added successfully as a customer through the CarTow.ie Membership form', 0, 1437063850),
(32, 3, 'A sub user account for Patricia Norton was created successfully', 1, 1437653085),
(33, 3, 'A company account for conan egypt was created successfully', 1, 1438788078),
(34, 25, 'A company account for conan egypt was created successfully', 0, 1438788078),
(35, 32, 'A company account for conan egypt was created successfully', 0, 1438788078),
(36, 3, 'Patricia was added successfully as a customer through the CarTow.ie Membership form', 1, 1438858672),
(37, 25, 'Patricia was added successfully as a customer through the CarTow.ie Membership form', 0, 1438858672),
(38, 32, 'Patricia was added successfully as a customer through the CarTow.ie Membership form', 0, 1438858672),
(39, 3, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1439135884),
(40, 25, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439135884),
(41, 32, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439135884),
(42, 3, 'A company account for Monthly bill was created successfully', 1, 1439368858),
(43, 25, 'A company account for Monthly bill was created successfully', 0, 1439368858),
(44, 32, 'A company account for Monthly bill was created successfully', 0, 1439368858),
(45, 3, 'A company account for DEF Monthly was created successfully', 1, 1439377889),
(46, 25, 'A company account for DEF Monthly was created successfully', 0, 1439377889),
(47, 32, 'A company account for DEF Monthly was created successfully', 0, 1439377889),
(48, 3, 'A company account for Conan Comapny was created successfully', 1, 1439378316),
(49, 25, 'A company account for Conan Comapny was created successfully', 0, 1439378316),
(50, 32, 'A company account for Conan Comapny was created successfully', 0, 1439378316),
(51, 3, 'A sub user account for Agent CarTow was created successfully', 1, 1439381570),
(52, 3, 'Kim was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1439383626),
(53, 25, 'Kim was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439383626),
(54, 32, 'Kim was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439383626),
(55, 3, 'Kim was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1439384692),
(56, 25, 'Kim was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439384692),
(57, 32, 'Kim was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439384692),
(58, 3, 'David was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1439385292),
(59, 25, 'David was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439385292),
(60, 32, 'David was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439385292),
(61, 3, 'A company account for Test was created successfully', 1, 1439385828),
(62, 25, 'A company account for Test was created successfully', 0, 1439385828),
(63, 32, 'A company account for Test was created successfully', 0, 1439385828),
(64, 3, 'Ken was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1439386345),
(65, 25, 'Ken was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439386345),
(66, 32, 'Ken was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439386345),
(67, 3, 'A company account for August Test was created successfully', 1, 1439388414),
(68, 25, 'A company account for August Test was created successfully', 0, 1439388414),
(69, 32, 'A company account for August Test was created successfully', 0, 1439388414),
(70, 45, 'A company account for August Test was created successfully', 0, 1439388414),
(71, 3, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1439520794),
(72, 25, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439520794),
(73, 32, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439520794),
(74, 45, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439520794),
(75, 3, 'Eamonn was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1439563312),
(76, 25, 'Eamonn was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439563312),
(77, 32, 'Eamonn was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439563312),
(78, 45, 'Eamonn was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439563312),
(79, 3, 'An agent account for Kim McKayed was created successfully', 1, 1439638665),
(80, 3, 'Kim  was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1439639238),
(81, 25, 'Kim  was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439639238),
(82, 32, 'Kim  was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439639238),
(83, 45, 'Kim  was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1439639238),
(84, 3, 'A company account for CompanyTest was created successfully', 1, 1439976420),
(85, 25, 'A company account for CompanyTest was created successfully', 0, 1439976420),
(86, 32, 'A company account for CompanyTest was created successfully', 0, 1439976420),
(87, 45, 'A company account for CompanyTest was created successfully', 0, 1439976420),
(88, 3, 'A company account for Diane Motors was created successfully', 1, 1439986073),
(89, 25, 'A company account for Diane Motors was created successfully', 0, 1439986073),
(90, 32, 'A company account for Diane Motors was created successfully', 0, 1439986073),
(91, 45, 'A company account for Diane Motors was created successfully', 0, 1439986073),
(92, 49, 'An agent account for Kim McKayed was created successfully', 0, 1439986231),
(93, 3, 'An agent account for Kim McKayed was created successfully by ddtest', 1, 1439986231),
(94, 25, 'An agent account for Kim McKayed was created successfully by ddtest', 0, 1439986231),
(95, 32, 'An agent account for Kim McKayed was created successfully by ddtest', 0, 1439986231),
(96, 45, 'An agent account for Kim McKayed was created successfully by ddtest', 0, 1439986231),
(97, 3, 'shady was added successfully as a customer ', 1, 1439991607),
(98, 25, 'shady was added successfully as a customer ', 0, 1439991607),
(99, 32, 'shady was added successfully as a customer ', 0, 1439991607),
(100, 45, 'shady was added successfully as a customer ', 0, 1439991607),
(101, 3, 'maged was added successfully as a customer ', 1, 1440004458),
(102, 25, 'maged was added successfully as a customer ', 0, 1440004458),
(103, 32, 'maged was added successfully as a customer ', 0, 1440004458),
(104, 45, 'maged was added successfully as a customer ', 0, 1440004458),
(105, 3, 'shady was added successfully as a customer ', 1, 1440522544),
(106, 25, 'shady was added successfully as a customer ', 0, 1440522544),
(107, 32, 'shady was added successfully as a customer ', 0, 1440522544),
(108, 45, 'shady was added successfully as a customer ', 0, 1440522544),
(109, 3, 'shady was added successfully as a customer ', 1, 1440526718),
(110, 25, 'shady was added successfully as a customer ', 0, 1440526718),
(111, 32, 'shady was added successfully as a customer ', 0, 1440526718),
(112, 45, 'shady was added successfully as a customer ', 0, 1440526719),
(113, 3, 'shady was added successfully as a customer ', 1, 1440527025),
(114, 25, 'shady was added successfully as a customer ', 0, 1440527025),
(115, 32, 'shady was added successfully as a customer ', 0, 1440527025),
(116, 45, 'shady was added successfully as a customer ', 0, 1440527025),
(117, 3, 'fine was added successfully as a customer ', 1, 1440587183),
(118, 25, 'fine was added successfully as a customer ', 0, 1440587183),
(119, 32, 'fine was added successfully as a customer ', 0, 1440587183),
(120, 45, 'fine was added successfully as a customer ', 0, 1440587183),
(121, 3, 'shady was added successfully as a customer ', 1, 1440609381),
(122, 25, 'shady was added successfully as a customer ', 0, 1440609381),
(123, 32, 'shady was added successfully as a customer ', 0, 1440609381),
(124, 45, 'shady was added successfully as a customer ', 0, 1440609381),
(125, 3, 'shady was added successfully as a customer ', 1, 1440619727),
(126, 25, 'shady was added successfully as a customer ', 0, 1440619727),
(127, 32, 'shady was added successfully as a customer ', 0, 1440619727),
(128, 45, 'shady was added successfully as a customer ', 0, 1440619727),
(129, 3, 'fine was added successfully as a customer ', 1, 1440620456),
(130, 25, 'fine was added successfully as a customer ', 0, 1440620456),
(131, 32, 'fine was added successfully as a customer ', 0, 1440620456),
(132, 45, 'fine was added successfully as a customer ', 0, 1440620456),
(133, 3, 'shady was added successfully as a customer ', 1, 1440622970),
(134, 25, 'shady was added successfully as a customer ', 0, 1440622970),
(135, 32, 'shady was added successfully as a customer ', 0, 1440622970),
(136, 45, 'shady was added successfully as a customer ', 0, 1440622970),
(137, 3, 'shady was added successfully as a customer ', 1, 1440625330),
(138, 25, 'shady was added successfully as a customer ', 0, 1440625330),
(139, 32, 'shady was added successfully as a customer ', 0, 1440625330),
(140, 45, 'shady was added successfully as a customer ', 0, 1440625330),
(141, 3, 'James was added successfully as a customer ', 1, 1440625488),
(142, 25, 'James was added successfully as a customer ', 0, 1440625488),
(143, 32, 'James was added successfully as a customer ', 0, 1440625488),
(144, 45, 'James was added successfully as a customer ', 0, 1440625488),
(145, 3, 'chaly was added successfully as a customer ', 1, 1440626592),
(146, 25, 'chaly was added successfully as a customer ', 0, 1440626592),
(147, 32, 'chaly was added successfully as a customer ', 0, 1440626592),
(148, 45, 'chaly was added successfully as a customer ', 0, 1440626592),
(149, 85, 'An agent account for shady wallas was created successfully', 0, 1440659268),
(150, 86, 'An agent account for shady mohammed was created successfully', 0, 1440659728),
(151, 87, 'An agent account for shady keshk was created successfully', 0, 1440659744),
(152, 88, 'An agent account for raef mohammed was created successfully', 1, 1440659798),
(153, 89, 'An agent account for momo deh was created successfully', 0, 1440659947),
(154, 90, 'An agent account for hany masry was created successfully', 0, 1440660166),
(155, 91, 'An agent account for shady mohammed was created successfully', 0, 1440662850),
(156, 92, 'An agent account for shady mohammed was created successfully', 0, 1440664050),
(157, 93, 'An agent account for shady mohammed was created successfully', 0, 1440664187),
(158, 94, 'An agent account for shady mohammed was created successfully', 0, 1440668021),
(159, 96, 'An agent account for shady mohammed  was created successfully', 0, 1440682216),
(160, 3, 'A company account for sdfasdf was created successfully', 1, 1440682220),
(161, 25, 'A company account for sdfasdf was created successfully', 0, 1440682220),
(162, 32, 'A company account for sdfasdf was created successfully', 0, 1440682220),
(163, 45, 'A company account for sdfasdf was created successfully', 0, 1440682220),
(164, 97, 'An agent account for shady mohammed  was created successfully', 0, 1440682320),
(165, 3, 'A company account for sdfasdf was created successfully', 1, 1440682322),
(166, 25, 'A company account for sdfasdf was created successfully', 0, 1440682322),
(167, 32, 'A company account for sdfasdf was created successfully', 0, 1440682322),
(168, 45, 'A company account for sdfasdf was created successfully', 0, 1440682322),
(169, 98, 'An agent account for shady mohammed  was created successfully', 1, 1440683546),
(170, 3, 'A company account for fciapps was created successfully', 1, 1440683548),
(171, 25, 'A company account for fciapps was created successfully', 0, 1440683548),
(172, 32, 'A company account for fciapps was created successfully', 0, 1440683548),
(173, 45, 'A company account for fciapps was created successfully', 0, 1440683548),
(174, 99, 'An agent account for shady mohammed was created successfully', 0, 1440683688),
(175, 3, 'shady was added successfully as a customer ', 1, 1440684429),
(176, 25, 'shady was added successfully as a customer ', 0, 1440684429),
(177, 32, 'shady was added successfully as a customer ', 0, 1440684429),
(178, 45, 'shady was added successfully as a customer ', 0, 1440684429),
(179, 101, 'An agent account for sdfdsf sdfs was created successfully', 0, 1441030469),
(180, 3, 'An agent account for sdfdsf was added successfully by CEO', 1, 1441030469),
(181, 25, 'An agent account for sdfdsf was added successfully by CEO', 0, 1441030469),
(182, 32, 'An agent account for sdfdsf was added successfully by CEO', 0, 1441030469),
(183, 45, 'An agent account for sdfdsf was added successfully by CEO', 0, 1441030469),
(184, 102, 'An agent account for sdfdsf sdfs was created successfully', 0, 1441030514),
(185, 3, 'An agent account for sdfdsf was added successfully by CEO', 1, 1441030514),
(186, 25, 'An agent account for sdfdsf was added successfully by CEO', 0, 1441030514),
(187, 32, 'An agent account for sdfdsf was added successfully by CEO', 0, 1441030514),
(188, 45, 'An agent account for sdfdsf was added successfully by CEO', 0, 1441030514),
(189, 103, 'An agent account for dsfsfd sdds was created successfully', 0, 1441030963),
(190, 3, 'An agent account for dsfsfd was added successfully by CEO', 1, 1441030963),
(191, 25, 'An agent account for dsfsfd was added successfully by CEO', 0, 1441030963),
(192, 32, 'An agent account for dsfsfd was added successfully by CEO', 0, 1441030963),
(193, 45, 'An agent account for dsfsfd was added successfully by CEO', 0, 1441030963),
(194, 3, 'shady was added successfully as a customer ', 1, 1441033357),
(195, 25, 'shady was added successfully as a customer ', 0, 1441033357),
(196, 32, 'shady was added successfully as a customer ', 0, 1441033357),
(197, 45, 'shady was added successfully as a customer ', 0, 1441033357),
(198, 105, 'An agent account for army maged was created successfully', 0, 1441205335),
(199, 3, 'shady was added successfully as a customer ', 1, 1441228653),
(200, 25, 'shady was added successfully as a customer ', 0, 1441228653),
(201, 32, 'shady was added successfully as a customer ', 0, 1441228653),
(202, 45, 'shady was added successfully as a customer ', 0, 1441228653),
(203, 3, 'shady was added successfully as a customer ', 1, 1441238465),
(204, 25, 'shady was added successfully as a customer ', 0, 1441238465),
(205, 32, 'shady was added successfully as a customer ', 0, 1441238465),
(206, 45, 'shady was added successfully as a customer ', 0, 1441238465),
(207, 3, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1441238466),
(208, 25, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441238466),
(209, 32, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441238466),
(210, 45, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441238466),
(211, 3, 'shady was added successfully as a customer ', 1, 1441268544),
(212, 25, 'shady was added successfully as a customer ', 0, 1441268544),
(213, 32, 'shady was added successfully as a customer ', 0, 1441268544),
(214, 45, 'shady was added successfully as a customer ', 0, 1441268544),
(215, 3, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1441268546),
(216, 25, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441268546),
(217, 32, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441268546),
(218, 45, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441268546),
(219, 3, 'shady was added successfully as a customer ', 1, 1441269450),
(220, 25, 'shady was added successfully as a customer ', 0, 1441269450),
(221, 32, 'shady was added successfully as a customer ', 0, 1441269450),
(222, 45, 'shady was added successfully as a customer ', 0, 1441269450),
(223, 3, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1441269452),
(224, 25, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441269452),
(225, 32, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441269452),
(226, 45, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 0, 1441269452),
(227, 115, 'An agent account for seif shehap was created successfully', 0, 1441703997),
(228, 117, 'An agent account for shady keshk was created successfully', 1, 1442158014),
(229, 118, 'An agent account for shady mohammed  was created successfully', 0, 1442941875),
(230, 3, 'A company account for samsung was created successfully', 1, 1442941878),
(231, 121, 'An agent account for   was created successfully', 0, 1443542924),
(232, 122, 'An agent account for shady mohammed  was created successfully', 1, 1443543173),
(233, 3, 'A company account for google developer group suez was created successfully', 1, 1443543175),
(234, 123, 'An agent account for shady mohammed was created successfully', 1, 1443612077),
(235, 3, 'shady was added successfully as a customer ', 1, 1443626304),
(236, 3, 'shady was added successfully as a customer ', 1, 1443626453),
(237, 3, 'shady was added successfully as a customer ', 1, 1443626474),
(238, 3, 'shady was added successfully as a customer ', 1, 1443626543),
(239, 3, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1443626546),
(240, 3, 'shady was added successfully as a customer ', 1, 1443626566),
(241, 3, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1443626569),
(242, 3, 'shady was added successfully as a customer ', 1, 1444151052),
(243, 3, 'shady was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1444151055),
(244, 131, 'An agent account for shady mohammed was created successfully', 0, 1444564061),
(245, 132, 'An agent account for shady finance was created successfully', 1, 1444571753),
(247, 3, 'shady was added successfully as a customer ', 1, 1444579142),
(248, 139, 'An agent account for raef mohammed was created successfully', 0, 1444746687),
(249, 140, 'An agent account for shady mohammed was created successfully', 0, 1444746788),
(250, 141, 'An agent account for shady mohammed was created successfully', 0, 1444747081),
(251, 142, 'An agent account for shady mohammed was created successfully', 0, 1444748200),
(252, 143, 'An agent account for shady mohammed was created successfully', 0, 1444751401),
(253, 3, 'shady was added successfully as a customer ', 1, 1447583730),
(254, 3, 'shady was added successfully as a customer ', 1, 1447587413),
(255, 3, 'shady was added successfully as a customer ', 1, 1447587933),
(256, 3, 'shady was added successfully as a customer ', 1, 1447588173),
(257, 3, 'shady was added successfully as a customer ', 1, 1447588309),
(258, 3, 'shady was added successfully as a customer ', 1, 1447592362),
(259, 3, 'shady was added successfully as a customer ', 1, 1447592545),
(260, 3, 'shady was added successfully as a customer ', 1, 1447592672),
(261, 3, 'shady was added successfully as a customer ', 1, 1447592759),
(262, 3, 'shady was added successfully as a customer ', 1, 1447593054),
(263, 3, 'shady was added successfully as a customer ', 1, 1447593109),
(264, 3, 'shady was added successfully as a customer ', 1, 1447593369),
(265, 206, 'An agent account for henry nancy was created successfully', 0, 1447938104),
(266, 207, 'An agent account for shady mohammed was created successfully', 1, 1454410691),
(267, 3, 'shady was added successfully as a customer ', 1, 1455095588),
(268, 3, 'raef was added successfully as a customer ', 1, 1457274716),
(269, 3, 'Mohamed was added successfully as a customer ', 1, 1460305629),
(270, 3, 'Mohamed was added successfully as a customer_repository through the CarTow.ie Membership form', 1, 1460305631),
(271, 3, 'VMS was added successfully as a customer ', 1, 1466083217),
(272, 3, 'VMS was added successfully as a customer ', 1, 1466083483),
(273, 3, 'VMS was added successfully as a customer ', 1, 1466083647),
(274, 3, 'VMS was added successfully as a customer ', 1, 1466084400),
(275, 3, 'VMS was added successfully as a customer ', 1, 1466084456),
(276, 263, 'An agent account for Mahamad Fayez  was created successfully', 1, 1501104484),
(277, 3, 'A company account for The Mohamed Fayez was created successfully', 1, 1501104488),
(278, 264, 'An agent account for Mohamed Fayez was created successfully', 1, 1502649293);

-- --------------------------------------------------------

--
-- Table structure for table `oc_order`
--

CREATE TABLE `oc_order` (
  `order_id` int(11) NOT NULL,
  `invoice_no` varchar(255) DEFAULT '0',
  `invoice_prefix` varchar(26) DEFAULT NULL,
  `customer_id` int(11) DEFAULT '0',
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `email` varchar(96) DEFAULT NULL,
  `telephone` varchar(32) DEFAULT NULL,
  `fax` varchar(32) DEFAULT NULL,
  `custom_field` text,
  `payment_firstname` varchar(32) DEFAULT NULL,
  `payment_lastname` varchar(32) DEFAULT NULL,
  `payment_company` varchar(40) DEFAULT NULL,
  `payment_address_1` varchar(128) DEFAULT NULL,
  `payment_address_2` varchar(128) DEFAULT NULL,
  `payment_city` varchar(128) DEFAULT NULL,
  `payment_postcode` varchar(10) DEFAULT NULL,
  `payment_country` varchar(128) DEFAULT NULL,
  `payment_country_id` int(11) DEFAULT NULL,
  `payment_zone` varchar(128) DEFAULT NULL,
  `payment_zone_id` int(11) DEFAULT NULL,
  `payment_address_format` text,
  `payment_custom_field` text,
  `payment_method` varchar(128) DEFAULT NULL,
  `payment_code` varchar(128) DEFAULT NULL,
  `comment` text,
  `total` decimal(15,4) DEFAULT '0.0000',
  `order_status_id` int(11) DEFAULT '0',
  `commission` decimal(15,4) DEFAULT NULL,
  `tracking` varchar(64) DEFAULT NULL,
  `currency_code` varchar(3) DEFAULT NULL,
  `currency_value` decimal(15,8) DEFAULT '1.00000000',
  `ip` varchar(40) DEFAULT NULL,
  `forwarded_ip` varchar(40) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oc_order`
--

INSERT INTO `oc_order` (`order_id`, `invoice_no`, `invoice_prefix`, `customer_id`, `firstname`, `lastname`, `email`, `telephone`, `fax`, `custom_field`, `payment_firstname`, `payment_lastname`, `payment_company`, `payment_address_1`, `payment_address_2`, `payment_city`, `payment_postcode`, `payment_country`, `payment_country_id`, `payment_zone`, `payment_zone_id`, `payment_address_format`, `payment_custom_field`, `payment_method`, `payment_code`, `comment`, `total`, `order_status_id`, `commission`, `tracking`, `currency_code`, `currency_value`, `ip`, `forwarded_ip`, `user_agent`, `date_added`, `date_modified`) VALUES
(60, 'OFFLINE_60', 'OFFLINE', 6, 'Sherifa Mazhar', NULL, 'sherifa.mazhar@311-solutions.com', '0123456789', NULL, NULL, 'Sherifa Mazhar', NULL, 'Cartow', NULL, NULL, 'asd', '1214', 'asda', 5454, 'asd', 5454, 'adssad', 'asdsas', NULL, NULL, 'Generate invoice by finance user after ', '8415.0000', 4, '54545.0000', 'asdd', 'ada', '0.00000000', '127.0.0.1', '127.0.0.1', 'asssdsa', '2015-09-29 17:44:11', '2015-09-29 17:44:11');

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_history`
--

CREATE TABLE `oc_order_history` (
  `order_history_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_option`
--

CREATE TABLE `oc_order_option` (
  `order_option_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_product`
--

CREATE TABLE `oc_order_product` (
  `order_product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `model` varchar(64) NOT NULL,
  `quantity` int(4) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `reward` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oc_order_product`
--

INSERT INTO `oc_order_product` (`order_product_id`, `order_id`, `product_id`, `name`, `model`, `quantity`, `price`, `total`, `tax`, `reward`) VALUES
(71, 60, 2, 'Membership 2', '', 1, '0.0000', '0.0000', '0.0000', 0),
(72, 60, 4, 'Membership 3', '', 1, '500.0000', '500.0000', '0.0000', 0),
(73, 60, 6, 'Gold', '', 1, '2000.0000', '2000.0000', '0.0000', 0),
(74, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(75, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(76, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(77, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(78, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(79, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(80, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(81, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(82, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(83, 60, 12, '7 Day Auto', '', 1, '3075.0000', '3075.0000', '0.0000', 0),
(84, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(85, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(86, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(87, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(88, 60, 2, 'Membership 2', '', 1, '0.0000', '0.0000', '0.0000', 0),
(89, 60, 5, 'APL Membership', '', 1, '1170.0000', '1170.0000', '0.0000', 0),
(90, 60, 5, 'APL Membership', '', 1, '1170.0000', '1170.0000', '0.0000', 0),
(91, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(92, 60, 1, 'Membership 1', '', 1, '0.0000', '0.0000', '0.0000', 0),
(93, 60, 4, 'Membership 3', '', 1, '500.0000', '500.0000', '0.0000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_status`
--

CREATE TABLE `oc_order_status` (
  `order_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oc_order_status`
--

INSERT INTO `oc_order_status` (`order_status_id`, `language_id`, `name`) VALUES
(3, 1, 'caneled'),
(1, 0, 'pending'),
(2, 0, 'caneleble');

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_total`
--

CREATE TABLE `oc_order_total` (
  `order_total_id` int(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('shadywallas@gmail.com', '1f249bdb4376a537cd9c0dd2ad373d09e3d26fa5b33689ddc9643d0555310245', '2015-12-22 10:29:10');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `type`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'online', 'pay as you go ', 1, '2015-08-04 21:00:00', '2015-08-04 21:00:00'),
(2, 'offline', 'monthly bill', 1, '2015-08-04 21:00:00', '2015-08-04 21:00:00'),
(3, '10', '1', 1, '2015-12-30 10:32:47', '2015-12-30 10:32:47'),
(4, '14', '1', 1, '2015-12-30 10:32:47', '2015-12-30 10:32:47'),
(5, '15', '1', 1, '2015-12-30 10:32:47', '2015-12-30 10:32:47'),
(6, '17', '1', 1, '2015-12-30 10:32:47', '2015-12-30 10:32:47'),
(7, '26', '1', 1, '2015-12-30 10:32:48', '2015-12-30 10:32:48'),
(8, '28', '1', 1, '2015-12-30 10:32:48', '2015-12-30 10:32:48'),
(9, '29', '1', 1, '2015-12-30 10:32:48', '2015-12-30 10:32:48'),
(10, '30', '1', 1, '2015-12-30 10:32:48', '2015-12-30 10:32:48'),
(11, '10', '1', 1, '2015-12-30 10:32:53', '2015-12-30 10:32:53'),
(12, '14', '1', 1, '2015-12-30 10:32:53', '2015-12-30 10:32:53'),
(13, '15', '1', 1, '2015-12-30 10:32:53', '2015-12-30 10:32:53'),
(14, '17', '1', 1, '2015-12-30 10:32:53', '2015-12-30 10:32:53'),
(15, '26', '1', 1, '2015-12-30 10:32:54', '2015-12-30 10:32:54'),
(16, '28', '1', 1, '2015-12-30 10:32:54', '2015-12-30 10:32:54'),
(17, '29', '1', 1, '2015-12-30 10:32:54', '2015-12-30 10:32:54'),
(18, '30', '1', 1, '2015-12-30 10:32:54', '2015-12-30 10:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `persistences`
--

CREATE TABLE `persistences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(6, 49, 'BUA0B57WrS0MJfgOwGPZkpOZfXnZ0FBE', '2015-08-19 10:09:12', '2015-08-19 10:09:12'),
(7, 49, 'Lplj11sZwAOihpufNOk1PJ6HuKJfaMkS', '2015-08-19 10:15:31', '2015-08-19 10:15:31'),
(13, 49, 'thrDy43IkdWqsZbgtsGS4vLZGBAOSbZI', '2015-08-19 14:56:21', '2015-08-19 14:56:21'),
(15, 45, 'zTwZ0pYY0tryuBuRh9BzitjfyieeoSeB', '2015-08-19 15:06:19', '2015-08-19 15:06:19'),
(16, 10, '9lPKXTA9Eqo1Kwz4FvJPcHTaPyM6VL6D', '2015-08-19 15:11:04', '2015-08-19 15:11:04'),
(18, 3, 'ccFLA24M0Gv7AYtor74Nf9ABYaUgxZY9', '2015-08-20 06:38:02', '2015-08-20 06:38:02'),
(20, 10, 'FpACwCd86vP4RQ4Hc3WMoAL9h7GTZ0Lz', '2015-08-20 14:03:42', '2015-08-20 14:03:42'),
(22, 10, 'CPEVpdIbUVNxPmZ4jzUr8xxoV8AK9LYF', '2015-08-23 09:20:03', '2015-08-23 09:20:03'),
(24, 3, 'Kd4CNdJHIl6fR1i59COvLzn6KtKm8u6M', '2015-08-23 14:28:09', '2015-08-23 14:28:09'),
(27, 10, 'GzVhqDfbtAHkvl1Uuw5dZ8evW0lNMA3F', '2015-08-24 12:30:20', '2015-08-24 12:30:20'),
(44, 3, 'igAcYSazQNgLDNRFtI2lzcakEMayKaK9', '2015-08-24 13:08:09', '2015-08-24 13:08:09'),
(45, 3, 'UeLNzzAyNbDWYfE9lek8W7fWdzgQAdJx', '2015-08-24 13:25:23', '2015-08-24 13:25:23'),
(46, 3, 'znidGpiByf7m8vzWVaxvGruBKBgfdtqb', '2015-08-25 09:08:44', '2015-08-25 09:08:44'),
(47, 3, 'sjFbQqzafUjSF7xOKGJPJKNJQMiLdgQG', '2015-08-25 09:21:13', '2015-08-25 09:21:13'),
(48, 3, 'HQQNStMUNG0KORSfbgcIvwowTSsR67KZ', '2015-08-25 12:03:27', '2015-08-25 12:03:27'),
(50, 3, 'zg0qcxFOa0QE3sJUzpaNpq2q0LYMLi0w', '2015-08-26 09:04:19', '2015-08-26 09:04:19'),
(51, 3, 'M0BcXkRP6RPPD22G9ekDMtsyei9W0Dw3', '2015-08-26 09:08:32', '2015-08-26 09:08:32'),
(63, 3, 'CSYfYdwomqJe7kuXMWfuQZ1hjJKlNEOZ', '2015-08-26 21:04:14', '2015-08-26 21:04:14'),
(73, 94, '7QMzTYSjrtfYFZggBjjZGQ7CA89PHIiZ', '2015-08-27 07:40:54', '2015-08-27 07:40:54'),
(75, 3, 'Fg7ZQ0OXqxJBtIkgpQtMx9B4eFiC0M68', '2015-08-27 11:23:17', '2015-08-27 11:23:17'),
(81, 98, 'yDPWoVebKyTz3cNChL3PRB54xByK6ptt', '2015-08-27 12:49:15', '2015-08-27 12:49:15'),
(83, 3, '5kOsWJBQSYE6kTzku3CGaLIxe9sfipDG', '2015-08-31 09:19:05', '2015-08-31 09:19:05'),
(84, 3, '6UMECpapOWKuZjYhdJQXwnhkw7QL5J2e', '2015-08-31 12:13:20', '2015-08-31 12:13:20'),
(86, 99, 'ZbkPWkwWINH0iVizA0mTx25lNeRBAGAX', '2015-09-01 07:51:46', '2015-09-01 07:51:46'),
(90, 10, 'FqPNvxZedDen740SsZkwMyytBONwt0L9', '2015-09-01 10:18:56', '2015-09-01 10:18:56'),
(91, 10, 'CFL9DS0qmRHLrvhic6Bab2bsfqK3WT6W', '2015-09-01 10:40:14', '2015-09-01 10:40:14'),
(92, 10, 'GRFZdP7pHLJYXI2KirXuMxpiikQvUU6Y', '2015-09-02 10:45:38', '2015-09-02 10:45:38'),
(100, 105, 'Kfsfgb0BXXCzCKK2S3gQ9Z3LKde7RthA', '2015-09-02 12:49:26', '2015-09-02 12:49:26'),
(113, 3, 'hhWaFCQQPVdhsmSEK4lNRUMig3ndSZnf', '2015-09-02 21:28:06', '2015-09-02 21:28:06'),
(114, 3, '77zh4gMGGyIk6j4yvl6duOyazyLbjcuQ', '2015-09-03 04:58:10', '2015-09-03 04:58:10'),
(115, 3, 'Zlh70zeOtqadNLoND9587mxLfbn5k4is', '2015-09-03 06:45:53', '2015-09-03 06:45:53'),
(117, 3, 'glDqcg3YjyU9S3BYQ1lntBCynRaL5M40', '2015-09-06 10:22:40', '2015-09-06 10:22:40'),
(118, 3, 'PqVj32x8wO3O2eRQYmPm2WWKdgJ4FYwU', '2015-09-07 11:35:09', '2015-09-07 11:35:09'),
(119, 3, '1OBed91xC3vEZC99fb9uBGR9QdDtkb5Y', '2015-09-07 14:45:31', '2015-09-07 14:45:31'),
(122, 115, 'cIlRhJCY9pgmoAlsf6PIU5vZfj6c1ktb', '2015-09-08 07:20:45', '2015-09-08 07:20:45'),
(124, 115, 'gZncScoFGQm6c5KWPLDRW335NpZJBUk0', '2015-09-08 14:28:41', '2015-09-08 14:28:41'),
(129, 115, 'BpqB8NRSvGRT1JdHXjgWB883QsSlsnaB', '2015-09-08 15:57:43', '2015-09-08 15:57:43'),
(130, 115, 'LgdyVlQN6MewHsXewCCZv039kQN5nZ0E', '2015-09-09 07:42:34', '2015-09-09 07:42:34'),
(136, 3, 'P73JW6cGAEuBVJLn1hQwUMjbK4yOQCFo', '2015-09-09 12:36:00', '2015-09-09 12:36:00'),
(138, 3, 'TX7TOk4S02O1SxvnnCL3qJ1Gxjja9yNU', '2015-09-10 08:39:15', '2015-09-10 08:39:15'),
(139, 3, '20LnxDhaBJSe6a7GQNAFaVEu0u0VnLeC', '2015-09-10 11:22:40', '2015-09-10 11:22:40'),
(140, 3, '4sJwLOFUPsGYFBpt9AQjJnoUJNij4M9q', '2015-09-10 15:28:29', '2015-09-10 15:28:29'),
(141, 3, 'HHKjv4aDwWqB65VagF8VprHxd42d0BVJ', '2015-09-10 15:28:54', '2015-09-10 15:28:54'),
(142, 3, 'n0uWreI2RFWKHV2928slQExsNtGg6UZL', '2015-09-13 12:55:09', '2015-09-13 12:55:09'),
(143, 3, 'vUBDbonTY3V8O0di3FlvdejHQPImEvAP', '2015-09-13 12:56:05', '2015-09-13 12:56:05'),
(144, 91, 'PoWIrFWLPDCGzmg0xst1G77FhJcZGA7L', '2015-09-13 12:57:55', '2015-09-13 12:57:55'),
(145, 91, 'sAhcY3I1SHnf0QzWw8LFfoROEJkiYPyb', '2015-09-13 12:58:29', '2015-09-13 12:58:29'),
(149, 117, 'FpY3Ax6IIMsCfwjmcTrSZ9Zka5o0uyGS', '2015-09-13 13:27:22', '2015-09-13 13:27:22'),
(151, 117, '632IdaTv7nIPpph313EnUYZldPRksPSK', '2015-09-13 13:45:17', '2015-09-13 13:45:17'),
(155, 3, 'oce65qiwcPu7CW2meZBcevnffQY33s8e', '2015-09-14 07:48:16', '2015-09-14 07:48:16'),
(157, 117, 'WvEwHRgsvjSOktOKwLqQSxa2GWgAUl9V', '2015-09-14 10:41:34', '2015-09-14 10:41:34'),
(158, 117, '4cQzuchw7QaWdBcJ35obhJGdB0AiXzd0', '2015-09-14 13:34:08', '2015-09-14 13:34:08'),
(159, 117, 'GQ80Qy3b95C1QuttKyAvsDSBBwFUU97l', '2015-09-15 05:47:53', '2015-09-15 05:47:53'),
(160, 117, '0JNK7g9mecfNc4EJW4ItfvSFamhe5hq1', '2015-09-17 06:10:33', '2015-09-17 06:10:33'),
(161, 117, '8iYMIKlyNAXBrBYnWUgRO91xFP4PfG2S', '2015-09-18 14:54:01', '2015-09-18 14:54:01'),
(162, 117, 'ZM3CrYYQayIObDr0fe4SHMwXUmQMe73j', '2015-09-18 17:18:23', '2015-09-18 17:18:23'),
(163, 117, 'FlfdLF55sD6AKLTldTsyheh06hBGfkNu', '2015-09-18 17:41:11', '2015-09-18 17:41:11'),
(164, 117, 'Of3BBeZvONjlChIHOiWOPOwtgPbh4QCw', '2015-09-20 11:11:08', '2015-09-20 11:11:08'),
(165, 117, 'XP5But8A96s01AcK7NdDW7Aqgxiy3jw2', '2015-09-20 11:24:10', '2015-09-20 11:24:10'),
(166, 117, '3jrWE80IZBnnBXE1RZcktixqVeBihQa5', '2015-09-20 11:58:20', '2015-09-20 11:58:20'),
(167, 117, '2iqDHiD7unbAqS2PbrQ6qxb0Ak8Ap73X', '2015-09-20 12:39:24', '2015-09-20 12:39:24'),
(168, 117, 'Bba8rCHnZs2OJV1PhMdeW8MUCPETtm8L', '2015-09-20 12:53:30', '2015-09-20 12:53:30'),
(169, 117, 'EbHFngwaWJSLCDwh4CP7nokPTyrzBsxr', '2015-09-20 13:00:33', '2015-09-20 13:00:33'),
(171, 3, '4Ciky75V0Lg1l9t9I79gp1srtphozwVg', '2015-09-21 13:25:01', '2015-09-21 13:25:01'),
(172, 3, 'lRuItn81XWReB0itxjUM1OBcA56hBJwL', '2015-09-21 13:25:13', '2015-09-21 13:25:13'),
(173, 3, 'PP95iAw6br1XfgYwm73KRPP4MUQhMMyq', '2015-09-21 13:25:35', '2015-09-21 13:25:35'),
(174, 3, 'JQMPcZeZaMNVK0wy5X3K9nO4Ianqgrzx', '2015-09-21 13:26:50', '2015-09-21 13:26:50'),
(175, 3, '6FO6sLiZaD5bZQzZDoUTuj47LMYiRAIv', '2015-09-21 13:26:54', '2015-09-21 13:26:54'),
(176, 3, 'U5MMyxmqOszz9SKEw9YE6CLrdBeVB7yB', '2015-09-21 13:27:08', '2015-09-21 13:27:08'),
(178, 3, 'E3ptVoXQHTUNQKKg4DV06v7i3nbCzmoQ', '2015-09-21 13:28:09', '2015-09-21 13:28:09'),
(179, 3, '51llFqQsnkX65kYBtT9ZYomZnipQCG0w', '2015-09-21 13:28:18', '2015-09-21 13:28:18'),
(180, 3, 'W4cyYwrdNOFOlXvZE5t24LTLL0lUaP09', '2015-09-21 13:29:01', '2015-09-21 13:29:01'),
(181, 3, 'vbx56B0HxnQAzQPtXjcDlDNLzgLwaX3K', '2015-09-21 13:29:49', '2015-09-21 13:29:49'),
(182, 3, 'DUJV19AoEwF22FM7gOOkeKAhgVnJzHYm', '2015-09-21 13:29:53', '2015-09-21 13:29:53'),
(183, 3, 'zaxTJT9I5ZgiJzswUROnjxd437TIRg2I', '2015-09-21 13:29:55', '2015-09-21 13:29:55'),
(184, 3, 'epiOw2bfjakMQy2nCvo8DnXYITSAIEJz', '2015-09-21 13:30:31', '2015-09-21 13:30:31'),
(185, 3, 'dTIebuU0iLUQB6RUSFkWzT2GmJFUafSz', '2015-09-21 13:30:33', '2015-09-21 13:30:33'),
(186, 3, '6PLbZVF3e6HhqFwGnDE66T2tGt42qquT', '2015-09-21 13:31:06', '2015-09-21 13:31:06'),
(187, 3, 'wlAMkfhb6Ln5kvLUz0f7M1Q1N7WtP8p2', '2015-09-21 13:31:35', '2015-09-21 13:31:35'),
(188, 3, 'SAmRyH0kzYwdRjHzcx9rG1Y82vlws6dm', '2015-09-21 13:31:39', '2015-09-21 13:31:39'),
(189, 3, 'MS6zy7i5o9NGR3PAGRy3iq6PLxEiHs1s', '2015-09-21 13:31:40', '2015-09-21 13:31:40'),
(190, 91, 'qtGXirYaoLhubsm4iCluPlR8c49V9xCR', '2015-09-21 13:31:47', '2015-09-21 13:31:47'),
(191, 98, '4xjXd8Evjexvi61keekKmkaipb95VGsM', '2015-09-21 13:32:01', '2015-09-21 13:32:01'),
(193, 117, 'MYTltWuA5hput69Eo5y2VHbxwXjOIkr3', '2015-09-21 14:28:24', '2015-09-21 14:28:24'),
(195, 3, '6gp19txCX9KdiaqzFNWztGabB59W7YUu', '2015-09-22 12:22:21', '2015-09-22 12:22:21'),
(196, 98, 'enGcC23Es4bfOaX0yk0vxw6oYdM8yeQT', '2015-09-22 12:25:42', '2015-09-22 12:25:42'),
(197, 3, 'OpZW7K7C4ZYK61fMTwBGuiOhpDCxExNr', '2015-09-22 12:25:50', '2015-09-22 12:25:50'),
(198, 98, 'bStpE4MbDxccIpISzU3xb6AaS0mn7Upo', '2015-09-22 12:26:05', '2015-09-22 12:26:05'),
(199, 3, 'aUOszlKQQhOIU0imLrHfwlhFIX11qlb9', '2015-09-22 12:26:47', '2015-09-22 12:26:47'),
(200, 98, 'Zhyzio4fvyx0d26viYLKYn9zEE8rm8kF', '2015-09-22 12:27:23', '2015-09-22 12:27:23'),
(208, 3, 'gvqAVQn9oRX5F320ZymdCRC7WWIbPZM8', '2015-09-22 14:57:59', '2015-09-22 14:57:59'),
(209, 3, '8lRnXgLKoHFsbypNr0JHxnuKQyJ90bLq', '2015-09-22 14:58:03', '2015-09-22 14:58:03'),
(211, 3, 'LlWxQ7BSxPJWyyAGSyylaluKCmt7PXhC', '2015-09-22 15:05:12', '2015-09-22 15:05:12'),
(213, 3, 'Wfad8VGMIoFy8g1DRqFfO28mLx8y2Ow2', '2015-09-28 11:04:24', '2015-09-28 11:04:24'),
(215, 3, 'OO5Vt9efFXwYLAQJkdc8pf4L8JhJHbY2', '2015-09-29 07:44:58', '2015-09-29 07:44:58'),
(216, 3, 'GzIknvT7kq3YMH25phLUX2HrqIKGWygK', '2015-09-29 13:55:19', '2015-09-29 13:55:19'),
(217, 122, 'juh0TLmZKyE8z1N3YTf9JhXablUOg0fC', '2015-09-29 14:48:17', '2015-09-29 14:48:17'),
(218, 3, 'C1VIxTbcbWTekBbFIS8ZYyXOfOB2hFGE', '2015-09-29 14:48:19', '2015-09-29 14:48:19'),
(219, 122, 'YXjvrDbN51V0iiDhKAI9fjUsOJkRpTq7', '2015-09-29 14:48:25', '2015-09-29 14:48:25'),
(220, 3, 'iJzQGfD9Z9w8IbeAISXt1DofvhQEdsag', '2015-09-29 14:48:46', '2015-09-29 14:48:46'),
(221, 3, '5rxGTu6KpHipOeLayXswHhHWJ6OovGiI', '2015-09-29 14:48:51', '2015-09-29 14:48:51'),
(222, 122, 'FBEZoFyQu3dmAmhScWF8YZEE91kw6nwf', '2015-09-29 14:48:58', '2015-09-29 14:48:58'),
(223, 117, 'dsig3Ps3E5c1buKgj7NrWdbg7cT0g7mV', '2015-09-29 14:49:53', '2015-09-29 14:49:53'),
(224, 3, 'AeX7flHeuLPOEQe2jNXeqwhXRmbsEPC1', '2015-09-29 14:49:55', '2015-09-29 14:49:55'),
(225, 122, 'Lr7WRN9qE9aC3NyPHWO0cICDzTJJOBnn', '2015-09-29 14:50:06', '2015-09-29 14:50:06'),
(226, 3, 'Z500NjInndTdWL2WVfgbyYQKypzP0dHt', '2015-09-29 14:51:19', '2015-09-29 14:51:19'),
(227, 3, 'hzeFYR10t1j3pfDZ0wLNwYSTQXkkSRIU', '2015-09-29 14:51:19', '2015-09-29 14:51:19'),
(229, 3, 'PN7tAUUfnwwAlsWUEP4Bu9KC36iH9irg', '2015-09-29 15:14:45', '2015-09-29 15:14:45'),
(230, 3, '2OugaHX50d0GastoyyHRBmfQgr3ytK84', '2015-09-29 15:14:51', '2015-09-29 15:14:51'),
(231, 122, 'SRSiseYo0utwQwr77nVPVuBy6ZfOf4pJ', '2015-09-29 15:48:09', '2015-09-29 15:48:09'),
(232, 3, '0dwTlyYzHjBV9SnImjsqC9VQGCdTdt9B', '2015-09-29 15:48:15', '2015-09-29 15:48:15'),
(234, 123, 'G2mZejkdb5DYrMfSaMsDwmNTrtlFTfQa', '2015-09-30 09:22:31', '2015-09-30 09:22:31'),
(235, 123, 'zCwIcYnTw5HRjvoEoWuFmSBhiuVsOnuU', '2015-09-30 10:42:07', '2015-09-30 10:42:07'),
(236, 123, '3nI0aj1rmOeq8vUI2ODa6RO79PK09mjL', '2015-10-04 11:20:39', '2015-10-04 11:20:39'),
(238, 3, 'rNLw34onizThxruPKyatwaAKQoQESJnA', '2015-10-06 09:47:08', '2015-10-06 09:47:08'),
(239, 122, 'aTgsrkWJt3TPYawciZc12W2l2vJ6iAXI', '2015-10-06 09:49:48', '2015-10-06 09:49:48'),
(240, 3, 'BMUKZ4GKIQREPkVfItVesaFzNCvViMEK', '2015-10-06 09:51:07', '2015-10-06 09:51:07'),
(241, 123, 'HyWANoi9up267FtYqJKZpgxcSYWVaOU5', '2015-10-06 12:22:05', '2015-10-06 12:22:05'),
(247, 3, '1h1UWWO1WScS4njUwA49VoXE3NFCZoRn', '2015-10-07 12:28:43', '2015-10-07 12:28:43'),
(255, 132, 'qPkbwXyrOnkY2KI68d9al95yKnaqB8kT', '2015-10-11 11:56:15', '2015-10-11 11:56:15'),
(257, 3, 'j6WpRKLUMS4deCbETGZSXz9IpO7M5gZn', '2015-10-13 12:09:33', '2015-10-13 12:09:33'),
(258, 132, 'X1RQcMvwUublFHVyp8viiVRMUbuvYdPb', '2015-10-27 11:29:53', '2015-10-27 11:29:53'),
(259, 3, 'eFEB1U6Smafc3tMcyBlKVQdl6N7LjgEs', '2015-11-02 11:42:31', '2015-11-02 11:42:31'),
(260, 98, 'Y8pmJf77cmEZGYQwi8CL68OXdbZJP92U', '2015-11-03 05:38:21', '2015-11-03 05:38:21'),
(262, 3, 'lLjGw2AgQICntnb5NgQ3lezIqZASpQSA', '2015-11-03 06:11:42', '2015-11-03 06:11:42'),
(263, 3, '0M2hwRcZz5akjGnH0GKfPaB4aFFcQA8W', '2015-11-03 08:17:42', '2015-11-03 08:17:42'),
(264, 3, 'kJh9HVBHBjZMUtpLo1GWTCm76UN88LCK', '2015-11-03 08:57:50', '2015-11-03 08:57:50'),
(265, 3, 'OYcnx0qQnZE8bbcB0vjIxJnbyoMG5LoV', '2015-11-03 09:24:20', '2015-11-03 09:24:20'),
(266, 3, 'PFpg1rfcf8db6gfn6boIofd4cV78LURr', '2015-11-04 06:56:22', '2015-11-04 06:56:22'),
(267, 3, 'OchTqYvm8JD6bwvNzlhmUnNykfJqp9gn', '2015-11-04 09:36:48', '2015-11-04 09:36:48'),
(268, 3, 'j4TID47CDdYEfIlPbgmNkrbK9kmB9mhZ', '2015-11-04 11:19:53', '2015-11-04 11:19:53'),
(269, 3, 'X2sZHNXPhUN37WShXkG3OSM2WCYtlJP0', '2015-11-08 06:20:15', '2015-11-08 06:20:15'),
(270, 3, 'bDbvqbSGbViJz2rAeDWkZwy9RcpnGliY', '2015-11-08 08:02:43', '2015-11-08 08:02:43'),
(271, 3, 'FFxdAkWSSEx3TymZ6KqMJ4H54PQCryiI', '2015-11-08 09:49:14', '2015-11-08 09:49:14'),
(272, 3, 'dO6vIFG9bFoBOvc1J2GfiJsoGpRhWu6Q', '2015-11-09 14:09:07', '2015-11-09 14:09:07'),
(273, 3, 'YER9tI6qHVqqyWYaySfJydYmje3KZLHq', '2015-11-10 12:31:22', '2015-11-10 12:31:22'),
(274, 3, 'TLzTpCwgP6NrKCYEmuwk1b86fWUzZ3q4', '2015-11-10 13:52:53', '2015-11-10 13:52:53'),
(276, 3, 'j7xWdzB0KMb8XaDNooiYav7STRrtwyeR', '2015-11-10 14:36:01', '2015-11-10 14:36:01'),
(277, 3, 'h6LzfIYQLp2oEThWS8QYnLyDQk9pkQga', '2015-11-10 15:53:42', '2015-11-10 15:53:42'),
(278, 3, 'rKEYbVLDCNUnlHqcUperKifz4oQk4ksq', '2015-11-15 08:23:18', '2015-11-15 08:23:18'),
(279, 3, 'kDTvF91VNHQrKyWiCQbiCeaX0akMdtID', '2015-11-16 06:23:41', '2015-11-16 06:23:41'),
(280, 3, 'Ge8OWmtvDTt0kcZNM2Niss76Yripn3lg', '2015-11-18 08:01:38', '2015-11-18 08:01:38'),
(281, 3, 'aKYxMSMfZ7qdZ1Lgl2RHM80k5bQx4wBk', '2015-11-18 09:43:05', '2015-11-18 09:43:05'),
(282, 3, '7zrPYtd85wkCxLiKVPRTOKlIdadOoeHM', '2015-11-19 07:45:36', '2015-11-19 07:45:36'),
(284, 3, 'ATieMBGtNz6ac4pO3tMNbrnPy6mw3a0J', '2015-11-19 11:19:08', '2015-11-19 11:19:08'),
(286, 3, 'g9jKFzHCby8TVe7x5ckcizRi4S7gZjLw', '2015-11-22 08:06:49', '2015-11-22 08:06:49'),
(287, 3, 'tMgRP0tofWQdu3wcBaRGt399AI1Zkykd', '2015-11-22 08:13:10', '2015-11-22 08:13:10'),
(288, 3, '5E3WUUSCoIzQKlptJQERJdYQEz9zKiL7', '2015-11-22 09:35:05', '2015-11-22 09:35:05'),
(289, 3, '0oo2mJrLEcrRy6IitSofOLgjw5dUJwd0', '2015-11-23 12:28:52', '2015-11-23 12:28:52'),
(290, 3, 'Y6yf94dztQEeKHzPuMqBYvbflgOh2axv', '2015-12-01 16:15:28', '2015-12-01 16:15:28'),
(291, 3, '5Maia77dGfY6LjWGFxGHqeghtxtX6vvv', '2015-12-02 09:27:47', '2015-12-02 09:27:47'),
(292, 117, 'WwqTaSVDiwgPnNggPoN23KuaEaGsPNmp', '2015-12-15 13:32:08', '2015-12-15 13:32:08'),
(295, 3, '1a3ANQUq4DRPghpD8hP7B8CM9sppkFbj', '2015-12-15 14:11:55', '2015-12-15 14:11:55'),
(296, 3, 'hgFUFe7mfrmlPcHI9lPclAr2DQRe894P', '2015-12-16 06:51:53', '2015-12-16 06:51:53'),
(297, 3, 'VweAITaIu3B1wWyFeePpGjcoelnyJdqP', '2015-12-22 10:42:46', '2015-12-22 10:42:46'),
(298, 3, 'fL0HNRJgCWFkyvq9ZEvWljsJSzbEei6q', '2015-12-22 13:09:06', '2015-12-22 13:09:06'),
(299, 3, 'AFbAEQFFdAGlRZSO9Wzcm5QLO7Ct0KVV', '2015-12-30 08:24:36', '2015-12-30 08:24:36'),
(300, 3, '9aOh6uwJOKZ4gS1JqcE7pcPYfPwCTbFf', '2015-12-30 11:00:15', '2015-12-30 11:00:15'),
(301, 3, 'j2PIfo6i6zj4P5W1kVUckyykaGPEYbkq', '2016-01-11 12:59:15', '2016-01-11 12:59:15'),
(302, 3, 'kSAyD65XgHiPVfvi2MT6vmu9lhjVY84n', '2016-01-12 06:43:54', '2016-01-12 06:43:54'),
(303, 3, 'biCjrzTmlzaT0N0vyn05XxJEg9xADcIA', '2016-01-18 07:42:44', '2016-01-18 07:42:44'),
(304, 3, 'cbZBCldP7qwVjKM1Y3EQ2ftrJuovl9dV', '2016-02-01 06:30:24', '2016-02-01 06:30:24'),
(312, 3, 'LAS8GXr9U7Jh4OsFWK6C5oNnZAUnLBRU', '2016-02-07 15:46:40', '2016-02-07 15:46:40'),
(313, 3, '5ehbHhuNwEYKGQJWpyFOVuiuXHQrL3li', '2016-02-08 11:33:11', '2016-02-08 11:33:11'),
(314, 3, 'MCBkMa0u5djNWWa5BNZd700zvJnldJxJ', '2016-02-10 09:15:12', '2016-02-10 09:15:12'),
(315, 3, 'gg6onPSmuOqVfHiG2bd5vZfNSb3Yxgu0', '2016-03-06 12:06:49', '2016-03-06 12:06:49'),
(316, 3, '178BkZlRnovwtujNAPnceKmluGa7kvwz', '2016-03-22 13:28:11', '2016-03-22 13:28:11'),
(317, 3, 'rqjmejsv7WfjhFbGaXtblEbkt4JMtAKU', '2016-03-24 08:29:52', '2016-03-24 08:29:52'),
(318, 3, 'mA3jIpkY3mZjarzwEfXFdeGhwjDRCh1W', '2016-04-10 09:18:28', '2016-04-10 09:18:28'),
(319, 248, 'JqhoBsU2lPA7IMw2PB1trRZNkQVXAX8P', '2016-04-10 09:19:22', '2016-04-10 09:19:22'),
(320, 3, 'tE8W7t2lFSIoOtmnHa8tFHpTrDXlBDlc', '2016-04-10 09:24:48', '2016-04-10 09:24:48'),
(321, 248, 'zhuR8onYsJYzKdUDr2yWv1uZFj6R2mnm', '2016-04-10 09:36:25', '2016-04-10 09:36:25'),
(322, 3, 'y2vChYHoY306JmDltlDy9gcW1krLUK4j', '2016-04-10 11:21:22', '2016-04-10 11:21:22'),
(323, 248, 'oPmU8NdVpHi3O1LCR2u1QxDzdMd9rYzp', '2016-04-10 12:22:07', '2016-04-10 12:22:07'),
(324, 3, '2MoOI0SXc43vGGT38EpyqeRIPIMbabZq', '2016-04-10 12:22:14', '2016-04-10 12:22:14'),
(325, 199, 'an6K650u48VtKOKJgxfYPRGZciLb6pQm', '2016-04-10 12:22:26', '2016-04-10 12:22:26'),
(326, 3, 'UNpki8WX3sKklSnQrhMqaEkDFYaWyM2s', '2016-04-10 12:22:32', '2016-04-10 12:22:32'),
(327, 3, 'azxco192xAGJBKHxSkU7a3eGNvJW1gSm', '2016-04-25 10:57:03', '2016-04-25 10:57:03'),
(328, 3, 'Ra8s8oSsUKBbGO3S2qjbRtZwffy935I7', '2016-06-16 10:12:36', '2016-06-16 10:12:36'),
(329, 3, '7ZyHFY0GE7Rh5gMO6C5wMC4DPpX3quMX', '2016-10-13 09:01:36', '2016-10-13 09:01:36'),
(330, 3, 'CLohmdjsyFkNlY7wqajEsT6iuXE5kHyU', '2017-01-08 14:46:51', '2017-01-08 14:46:51'),
(331, 3, 'JdsVfrUUqpALUDy4Ylr5hBaW19msc8g0', '2017-05-10 12:13:46', '2017-05-10 12:13:46'),
(332, 88, 'kehgawf8Xu5A1l4O7fuZTrm19lxxkoyq', '2017-05-10 12:15:24', '2017-05-10 12:15:24'),
(333, 3, 'x2t3Pnp4FLDLaABynLMMnlvit3wLL9zs', '2017-05-10 12:15:28', '2017-05-10 12:15:28'),
(334, 70, 'P1Vw4kSXkEL4P85GmGRY8wqL7Cvwk9lC', '2017-05-10 12:15:46', '2017-05-10 12:15:46'),
(335, 3, 'QoHPoJks2Bgt4hGIBURWrcm63gRdHZzQ', '2017-05-10 12:15:48', '2017-05-10 12:15:48'),
(336, 248, '76cE9rmEzD8DSOkZYMeZ2RWFgUF365iJ', '2017-05-10 12:16:00', '2017-05-10 12:16:00'),
(337, 3, 'n1abtLq0LUImbE8fYBxP42kokBOu8Uc0', '2017-05-11 11:15:30', '2017-05-11 11:15:30'),
(338, 3, 'maMVCsNq8UwbihrXCdifUu1WN9lFzI58', '2017-05-11 15:31:02', '2017-05-11 15:31:02'),
(339, 3, 'M0pATIYtJEjnuv57SYcJdLBRfRTnUIXp', '2017-05-14 09:21:21', '2017-05-14 09:21:21'),
(340, 3, 'vMREUESWhbiRbhIsfd78tizJBv2YagV3', '2017-05-14 12:43:40', '2017-05-14 12:43:40'),
(341, 3, 'vLDkgRZO2XsX3RdmFBYfvovi1DVxViqZ', '2017-05-15 11:57:01', '2017-05-15 11:57:01'),
(342, 3, 'OFSV2imy0Xt6d0Zae26z1NsD2LEPg5RH', '2017-05-15 17:49:38', '2017-05-15 17:49:38'),
(343, 3, 'Xk5fAVWs0g7S3z9RIsgJKvyy2sRyx0j6', '2017-05-16 12:50:25', '2017-05-16 12:50:25'),
(344, 3, 'r6ifpABp70DJM2KNQO4F1QVVfgwn6gmH', '2017-05-16 17:46:28', '2017-05-16 17:46:28'),
(345, 3, 'oUYvDFwv7INx4joc2N9b1WkiTVBUOihm', '2017-05-17 10:47:04', '2017-05-17 10:47:04'),
(346, 3, '7blyVSkYv5OsBdioNP5SFMewLbdZM3AL', '2017-05-23 13:57:11', '2017-05-23 13:57:11'),
(347, 3, 'F6V9Lstc8BdXTg9EpgnoHrIMBSfJCtTM', '2017-05-25 14:49:11', '2017-05-25 14:49:11'),
(348, 3, 'zdAp1oKzMGbberqxs1lkSINipaCqgPO6', '2017-05-31 12:14:01', '2017-05-31 12:14:01'),
(349, 3, 'f1Mlryt6nraomowkNlzoZw6DS6SQTtDK', '2017-06-12 12:09:29', '2017-06-12 12:09:29'),
(350, 3, '8mD2fWIGBXQ8FmAd8Qe8TpqgC1tKkrJx', '2017-06-14 11:05:00', '2017-06-14 11:05:00'),
(351, 3, 'kLebaDyt67dDqk8GEq3RVM6kmm0OcIYU', '2017-06-15 10:43:02', '2017-06-15 10:43:02'),
(352, 3, 'Jrt4Y7x5UToevY9NEmtbk8CaBegthwYg', '2017-06-18 09:55:58', '2017-06-18 09:55:58'),
(353, 3, 'qtnGnofNY0hQVv9zEk6Is8CeQtEyKPLn', '2017-06-19 09:57:18', '2017-06-19 09:57:18'),
(354, 3, 'SHdHjOKLorWY98mZ4TqpqoOZAg1zbCmy', '2017-06-20 10:24:51', '2017-06-20 10:24:51'),
(355, 3, 'f8WjEeWdTQhfxeWGnRvurIFC3EKtrbAe', '2017-06-21 10:32:34', '2017-06-21 10:32:34'),
(356, 3, 'IKFBRswLBMSL6zEjNWAeVMuqBROmNSth', '2017-06-22 08:05:42', '2017-06-22 08:05:42'),
(359, 3, 'm735ZVMRM2IkImnWCDt78vgXRXhcYAKy', '2017-06-28 15:19:40', '2017-06-28 15:19:40'),
(360, 3, 'av6zhbH7V2pWxvA450A8ETVdSvInK6iL', '2017-07-04 08:40:25', '2017-07-04 08:40:25'),
(361, 3, 'Y9LdXgrOqzrigExdmyoKCc5TPglksLS6', '2017-07-05 11:25:56', '2017-07-05 11:25:56'),
(362, 3, 'qp2kfCnDd07UyyqzhZN81nx16a80HRH8', '2017-07-05 14:54:44', '2017-07-05 14:54:44'),
(363, 3, 'yOpz07bFgYRvKhxCBLgWNeabMlFI65u8', '2017-07-06 08:03:26', '2017-07-06 08:03:26'),
(364, 3, 'js8ohlBSfCrV9k2KNOsRTKHIK5iuz6YM', '2017-07-06 10:43:53', '2017-07-06 10:43:53'),
(365, 3, 'I0Og6HjTc4Hu0s39D4OikTb7g3gXckFP', '2017-07-09 09:14:45', '2017-07-09 09:14:45'),
(366, 3, 'ovBUwewk5zL9IcOziFPwFSZ79sWxzEY6', '2017-07-09 09:16:12', '2017-07-09 09:16:12'),
(367, 3, 'Fu5Nxg4lcqDgfBBNn25I97XlRLWQXkpB', '2017-07-09 16:35:05', '2017-07-09 16:35:05'),
(368, 3, 'EAikEv35lmrYdh3CIvAAn9thUdX2Pdb2', '2017-07-10 10:48:40', '2017-07-10 10:48:40'),
(369, 3, '0M7YOS3xtnxyyViZ68L4r9de89qIyKb9', '2017-07-10 16:04:44', '2017-07-10 16:04:44'),
(370, 3, 'CZABxFs4KgBr4WGhmJUviDoHXHcsTe5E', '2017-07-12 09:24:54', '2017-07-12 09:24:54'),
(371, 3, 'yZoBlVicHMDsMH6jTSa2bLg5CKaBTm7V', '2017-07-13 07:57:29', '2017-07-13 07:57:29'),
(372, 3, 'j2bfbaShl9FpOTnfXDkYoJyQaFok2HCR', '2017-07-13 08:04:07', '2017-07-13 08:04:07'),
(373, 3, 'USfjtLacvDrSXZY54bvIxUy0v7ojlkzL', '2017-07-16 11:46:13', '2017-07-16 11:46:13'),
(374, 3, 'Mm0tU7851Y5UmmaKYDStSyUOgCTmSJfh', '2017-07-17 16:44:27', '2017-07-17 16:44:27'),
(375, 3, 'eesiRBDWXXkF0e1V0nIEPj3m1M8yye1V', '2017-07-20 09:55:31', '2017-07-20 09:55:31'),
(376, 3, 'SDpMChWy79x03IDpv5yOAnbZnFmV39zf', '2017-07-20 14:31:28', '2017-07-20 14:31:28'),
(377, 3, 'r3oNeUZT0ijj6VfihqL5LTgZKF6frxIi', '2017-07-25 12:02:23', '2017-07-25 12:02:23'),
(378, 3, 'w9OW8hHaScZB9r6rdaWz8sAO1XA9KvD7', '2017-07-26 09:48:57', '2017-07-26 09:48:57'),
(379, 3, 'ouJo2J0BWyiLrO8MHrspazKWvqK9dAXT', '2017-07-26 16:15:51', '2017-07-26 16:15:51'),
(381, 3, 'xzRt0xLuE9KmJFaORPb8nxw84ks4DdLm', '2017-07-27 10:18:23', '2017-07-27 10:18:23'),
(382, 3, 'bA4ixNweJ3QFf77CAG7HQU3GsjiMSZXt', '2017-08-01 14:21:25', '2017-08-01 14:21:25'),
(384, 264, 'iAFOGTg4x8p3tKID4qSuWd6WFJesCzTA', '2017-08-13 16:35:40', '2017-08-13 16:35:40'),
(385, 3, 'S0joL9vOZJoSI6qT8NPe6ZvZFONfdpt8', '2017-08-14 15:43:20', '2017-08-14 15:43:20'),
(386, 3, '6dqR6ByvdQHAt04Ev76JB1QupiOKiYXq', '2017-09-14 17:15:04', '2017-09-14 17:15:04'),
(387, 3, 'pzbvqpeP4PcfhwAouEh66nb12T3au24y', '2017-09-20 10:02:20', '2017-09-20 10:02:20'),
(388, 3, '6HjROqInrKPJvBLcxxecPNxScLcjdwyz', '2017-09-20 14:05:19', '2017-09-20 14:05:19'),
(390, 264, 'FMKNewdTKrsJgpLeKOuDtMMTaMBhj4cm', '2017-09-20 16:23:04', '2017-09-20 16:23:04'),
(391, 3, 'vGI2WzyXRk9i1nkDcvTpuRIRiPqHQn2P', '2017-09-21 08:22:37', '2017-09-21 08:22:37'),
(392, 3, '9NzTRiE9SV5npJqQFAgzc9Tgd5mUItAl', '2017-09-24 12:50:03', '2017-09-24 12:50:03'),
(393, 3, 'JtVWCToM21M7AEWbLjg4xIBgDPEhqvlQ', '2017-09-24 16:06:46', '2017-09-24 16:06:46'),
(396, 3, '8mkKTFdOb7CAQI6RcFJWbmdmWhrZr4TM', '2017-09-26 10:54:14', '2017-09-26 10:54:14'),
(397, 3, '0bviWSuTnAHWjgKSrhLcxx3P1C6VhJ1c', '2017-09-26 13:59:26', '2017-09-26 13:59:26'),
(398, 3, 'CW9ns6t8G3aZBYWIB3LUwjWkXdE1CN4p', '2017-09-26 17:33:00', '2017-09-26 17:33:00'),
(399, 3, 'jYni29TflQRdpqpZN5j7AVWwgD9Zp5th', '2017-09-27 07:10:31', '2017-09-27 07:10:31'),
(400, 3, 'J50O2l1szV1zIMLUW2tVzQ91pH1qaKwm', '2017-09-27 13:32:57', '2017-09-27 13:32:57'),
(401, 3, 'oryu7lvXo8gwmJqGsHaXKzYWO4TKE9es', '2017-09-28 10:17:46', '2017-09-28 10:17:46'),
(402, 3, 'fcohV3TimEUwg1D76Frfn1uiy8BQ1550', '2017-10-01 11:42:11', '2017-10-01 11:42:11'),
(403, 3, 'aIOaPOgmasRARU6lbXEEIJG6Emcs8LPU', '2017-10-01 14:34:39', '2017-10-01 14:34:39'),
(404, 3, 'jnWzYRor9ujRwztVzMMcJBHLGlM1dJC4', '2017-10-02 10:16:59', '2017-10-02 10:16:59'),
(405, 3, 'B4bwVFNLQMFyevEp7J9kbESycCzBcOqF', '2017-10-02 17:09:40', '2017-10-02 17:09:40'),
(406, 3, 'UupfaLNtbd7KeYNRAlpKurGaZK76npEp', '2017-10-03 18:02:38', '2017-10-03 18:02:38'),
(407, 3, 'CLeHmhn5zig9w0lRdsu6H4G467ZeClW7', '2017-10-08 12:39:46', '2017-10-08 12:39:46'),
(408, 3, 'pEiOIsFuX5aGhItwi98iSZoP6UUoHluP', '2017-10-16 11:08:09', '2017-10-16 11:08:09'),
(409, 3, '9Qu8YZuGgnc1maaf6JqpqQVqHI6h3ttF', '2017-10-16 15:04:46', '2017-10-16 15:04:46'),
(410, 3, 'DAzCkrF1WpoJB5uoLO3z5snjmzWvPIUw', '2017-10-19 15:06:44', '2017-10-19 15:06:44'),
(411, 3, 'KCZ2EuRqf7wix9e3ogIGJtyNL8aW4Vwf', '2017-10-22 13:10:33', '2017-10-22 13:10:33'),
(412, 3, 'NmNien3jYr6sSxsGAwKk12Nf8dqxcxvp', '2017-10-23 10:57:48', '2017-10-23 10:57:48'),
(413, 3, 'mmndwM1cz5dRFWdZL4Wx4Nba1d4erusJ', '2017-10-23 17:13:43', '2017-10-23 17:13:43'),
(414, 3, 'ZCd8myZJW0gCFQK6S92YpZSIsdHuV6zX', '2017-10-24 13:40:17', '2017-10-24 13:40:17'),
(415, 3, 'tRBJBH0o0ppwgyLY4GWBKn1p7rXgqwCc', '2017-10-25 14:39:09', '2017-10-25 14:39:09'),
(416, 3, '7Gq1eJOpM0FptHh05tu9Kdu9Q3x45ENT', '2017-10-25 18:22:32', '2017-10-25 18:22:32'),
(417, 3, 'sf3Vj3s0xgE1kXkhD8WHTFNS7zVqBjxV', '2017-10-26 10:38:14', '2017-10-26 10:38:14'),
(418, 3, '7WuDsnyxONuQVVR92UXqbujzqtICxZO3', '2017-10-26 15:50:26', '2017-10-26 15:50:26'),
(419, 3, 'WI2A0dfJC0DfSbD6CrcDQylhi8RNPgoz', '2017-10-29 18:33:26', '2017-10-29 18:33:26'),
(421, 264, 'FlzB9UNkrGVzpkKdqNDRAZjIIoHjTHvT', '2017-10-31 16:23:36', '2017-10-31 16:23:36'),
(422, 3, 'XXt2qMf7kfLhAs6NDYjTKYDFkqFtNGJF', '2017-11-01 14:54:21', '2017-11-01 14:54:21'),
(427, 264, 'q09qvHyjJV03pYLH5JHWRVaHjxKMNfcZ', '2017-11-02 12:21:26', '2017-11-02 12:21:26'),
(428, 3, 'eOq0VBEsiK6FAJrsULNtrPhJwia6twOt', '2017-12-11 13:29:45', '2017-12-11 13:29:45'),
(429, 3, 'UA7kTGq5KQE7MiLphIG17cEVpUmIVHbZ', '2017-12-13 14:06:27', '2017-12-13 14:06:27'),
(432, 264, 'YqdqZuCvVlJNdwVuJTpuFqyFlNeYPkdh', '2017-12-14 09:18:52', '2017-12-14 09:18:52'),
(433, 264, 'lwrE9QadTwIIgYwW85gXbroiLdTeC1oF', '2017-12-14 13:08:46', '2017-12-14 13:08:46'),
(434, 3, 'KQDVbGXs7RaPBYaYRpeFvtWYh3X61Bv6', '2017-12-17 09:05:05', '2017-12-17 09:05:05'),
(435, 3, 'DLizVNmdgeqUWGbtDAVouDG4SmNlSPCT', '2017-12-17 12:47:48', '2017-12-17 12:47:48'),
(436, 3, 'sR2dFOMZt7UthsonrGK28zau1O9lbJWR', '2017-12-18 08:03:00', '2017-12-18 08:03:00'),
(437, 3, 'PXe1MPLd7hjYd1xNm08jlZ4oXSd103Qq', '2017-12-19 09:08:16', '2017-12-19 09:08:16'),
(438, 3, 'prPIi8ZKiizraIsVuKfpc8P786vuW8jG', '2017-12-19 14:17:35', '2017-12-19 14:17:35'),
(439, 3, 'WzRO05gtaGeKrwbPAFb00B0l0whUl0js', '2017-12-20 07:46:32', '2017-12-20 07:46:32'),
(440, 3, 'cjcXaEHneDC2ptN3euFGBuibEzElCWqJ', '2017-12-20 14:44:23', '2017-12-20 14:44:23'),
(441, 3, '2k6piWdI9iKU69d52TnacJvGkBtnlOcE', '2017-12-21 09:20:26', '2017-12-21 09:20:26'),
(442, 3, 'OEuDi0l5KoaXFikWjmKpZXn3fsVf22T3', '2018-01-01 13:41:33', '2018-01-01 13:41:33'),
(443, 3, 'SmGpSRI6rtd3uB5XJY7hUSg8ZJPwTI51', '2018-01-02 08:06:12', '2018-01-02 08:06:12'),
(444, 3, 'XwwdYr54AMUtHHzMMoHtX5EfHcHTHsb3', '2018-01-03 07:45:01', '2018-01-03 07:45:01'),
(447, 3, '0a3d6q11DM7a0tCppSn97m2I2hXjzrZo', '2018-01-04 09:19:41', '2018-01-04 09:19:41'),
(448, 3, 'sGZdy3fG4Rrv0RDFcyaN6dkIVdT64OGP', '2018-01-04 12:29:16', '2018-01-04 12:29:16'),
(449, 3, '0SVqoYVVTiFgVBihr221g3RftG3UIaAo', '2018-01-08 10:47:24', '2018-01-08 10:47:24'),
(450, 3, 'WcdNz9fuzqVJUsXr9rOhXlO7J2bVjyA1', '2018-01-08 13:18:27', '2018-01-08 13:18:27'),
(451, 3, 'dcjrZdiAglw9hq2npOynXKGszgy47OFb', '2018-01-09 11:07:50', '2018-01-09 11:07:50'),
(452, 3, 'Sv76WqXv5DIf4BZap8qnMuuVCH1cuLEF', '2018-01-09 13:50:51', '2018-01-09 13:50:51'),
(453, 3, 'tVQ08g2w8lvWZMYvv4TkFU9FxMtW3q2m', '2018-01-10 12:16:25', '2018-01-10 12:16:25'),
(454, 3, 'gS5CMuB2Mw1cq0iS2eclrNC5Czpgef1v', '2018-01-11 10:15:14', '2018-01-11 10:15:14'),
(455, 3, 'XN3vAW0eaJVIi2xbdIFqeRjp0Rp0Hkgn', '2018-01-16 08:54:31', '2018-01-16 08:54:31'),
(456, 3, 'ht9yQ4gkJtmAf7fcSb5IXUaDvlKF2cJh', '2018-01-17 13:50:51', '2018-01-17 13:50:51'),
(457, 3, 'alXomGGtTzhin3c8dSiCeyovdqbZ1jxN', '2018-01-21 13:24:10', '2018-01-21 13:24:10'),
(458, 3, 'iE3lJhHC36SLLGftEgRqNs894hvvUq4f', '2018-01-22 12:30:24', '2018-01-22 12:30:24'),
(459, 3, 'JGRtswyc3lBLtUns80Ln1oJnJQuQefbP', '2018-01-23 10:39:55', '2018-01-23 10:39:55'),
(460, 3, 'Y59uBxwtdecbO1EYwoK1qR6sCaGPnKk5', '2018-01-24 10:11:40', '2018-01-24 10:11:40'),
(461, 3, 'rVzxs4BClD9NEUL8qDQPnM0hGnaih14M', '2018-01-24 14:12:56', '2018-01-24 14:12:56'),
(462, 3, 'scvvjKtpiETREtpKytFGh4OjXnhRzN2c', '2018-01-24 17:51:30', '2018-01-24 17:51:30'),
(463, 3, 'Qd9EEGyUG8gZ3QLg3JjZwR7SeIN1Lpx4', '2018-02-01 08:57:24', '2018-02-01 08:57:24'),
(464, 3, 'BEjubNVqs6cT6YW62fDe0PgAy6Xe8rUj', '2018-02-01 13:38:33', '2018-02-01 13:38:33'),
(466, 3, 'lTa4ik4HVUldW5RfIUXzLus6xOq8koAy', '2018-02-06 12:00:32', '2018-02-06 12:00:32'),
(467, 3, 'varmZLp1thzSy2R26kUJShitto2dACX3', '2018-02-06 20:27:24', '2018-02-06 20:27:24'),
(468, 3, 'l5OBXVcS5h78dT7NESou79VHDTzYRPm4', '2018-02-07 07:35:50', '2018-02-07 07:35:50'),
(469, 3, 'dn2311JEbTQC1NscSiCsGc5dSne2FAiY', '2018-02-08 09:41:21', '2018-02-08 09:41:21'),
(470, 3, 'zdhAJz6f3uLxzQIGznaemaYOdTqY1D5C', '2018-02-12 12:11:21', '2018-02-12 12:11:21'),
(471, 3, 'cDoCapAjfx1Ep2n51kGRhO96mGuM6gnS', '2018-02-13 14:57:26', '2018-02-13 14:57:26'),
(472, 3, 'ZAZLEMfBNcV9Vgx47mQtsZdhYzOw7vHL', '2018-02-20 13:29:57', '2018-02-20 13:29:57'),
(473, 3, 'OPNxNEbxai3egH5yQUPdu4VLBkp9T23x', '2018-02-21 09:02:47', '2018-02-21 09:02:47'),
(474, 3, 'xgsFXnDrhexNagpe4SYFwPrNnOzgwhA2', '2018-02-21 13:57:58', '2018-02-21 13:57:58'),
(475, 3, 't69jPdZ4Qcy7KhVvR0QF63zeXUyKQckh', '2018-02-22 07:56:12', '2018-02-22 07:56:12'),
(476, 3, 'gAPs3Oj3xf5vs55FbNVAZirDtWLeUvsZ', '2018-02-22 14:29:31', '2018-02-22 14:29:31'),
(477, 3, 'kb6RFyPsaraQjJQ5juAli8F5BSTQUQdJ', '2018-02-25 08:48:11', '2018-02-25 08:48:11'),
(478, 3, 'wDSTiS33oB8UDhRzjXLgt1vf3bBytr4Q', '2018-03-01 09:08:36', '2018-03-01 09:08:36'),
(479, 3, 'hW8UqsYCVrYTCuK6vawRDygEOTep0fFR', '2018-03-04 09:21:49', '2018-03-04 09:21:49'),
(480, 3, 'h7bwXin0RB0bpN9wWmmSuKmVwMNRR9B8', '2018-03-05 08:17:18', '2018-03-05 08:17:18'),
(481, 3, 'vCGmZpTl7duMrCErfFv3GlqH15kAPk76', '2018-03-05 11:16:44', '2018-03-05 11:16:44'),
(482, 3, '0poX2glUVoMEkp8UBVfrlhKWmyUIM4wm', '2018-03-05 13:25:37', '2018-03-05 13:25:37'),
(483, 3, '7vur4B65SFvjiqv7wiMBImfRkmEbFbUB', '2018-03-05 20:19:47', '2018-03-05 20:19:47'),
(484, 3, 'yuWBJtmSEybbcvHk3CCFhIQScK4OdCnC', '2018-03-06 08:07:29', '2018-03-06 08:07:29'),
(485, 3, '4MtsH4DooEEf9oSpwIeKqHWwe2UqnlgC', '2018-03-07 08:27:51', '2018-03-07 08:27:51'),
(486, 3, 'AMn5y1DtY3b25cIkUzOEI21WogdjaKF4', '2018-03-07 19:50:58', '2018-03-07 19:50:58'),
(487, 3, '2CyELEodOJ699MftQcZOOKAIy8vky6Zw', '2018-03-08 06:42:27', '2018-03-08 06:42:27'),
(488, 3, 'ilIiw4jqjJF3UxhQ0hRBnXRDcsk99TJG', '2018-03-08 15:25:13', '2018-03-08 15:25:13'),
(489, 3, 'fXOQmcqsx81EM342lTfsj1YYMuprttbD', '2018-03-12 10:08:24', '2018-03-12 10:08:24'),
(490, 3, 'gmtQiBogEjI4VfUwEZZt8IJ82bj0gc7o', '2018-03-13 09:05:25', '2018-03-13 09:05:25'),
(491, 3, 'QqbEfneqaAJ2KnNBLo0CjfOXl7GjOiOp', '2018-03-14 08:06:29', '2018-03-14 08:06:29'),
(492, 3, 'XTBm8XmEW5JFASC0g7IEfMU5WSDZ4hP0', '2018-03-14 12:33:35', '2018-03-14 12:33:35'),
(493, 3, 'QTJOeYkK5Pd0E9D1XsR7lnxaRU9yafdq', '2018-03-15 07:28:38', '2018-03-15 07:28:38'),
(494, 3, 'Gu1IuOma4LVKGncFDcukkmLf8OWeBAl5', '2018-03-15 11:35:35', '2018-03-15 11:35:35'),
(495, 3, 'v2586C3niPIiTMuKLhjLnsPJpdw5LyK4', '2018-03-18 09:16:02', '2018-03-18 09:16:02'),
(496, 3, 'HLq3p4wXOQDW2ALaRwxRKlkl8MaMnRmc', '2018-03-18 11:39:22', '2018-03-18 11:39:22'),
(498, 3, 'pXN9yZVTVNzGBFyyNuidOq7TjrOaS2yn', '2018-03-21 09:46:39', '2018-03-21 09:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `poc`
--

CREATE TABLE `poc` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poc`
--

INSERT INTO `poc` (`id`, `name`, `email`, `phone_number`, `address`) VALUES
(2, 'Sherifa Mazhar', 'sherifa.mazhar@311-solutions.com', '0123456789', NULL),
(3, 'Sherifa Mazhar', 'sherifa.mazhar@gmail.com', '0123456789', NULL),
(4, 'Sherifa Mazhar', 'sherifa.mazhar@gmail.com', '01006476610', NULL),
(5, 'Sherifa Mazhar', 'sherifa.mazhar@gmail.com', '01006476610', NULL),
(6, 'Sherifa Mazhar', 'sherifa.mazhar@gmail.com', '01006476610', NULL),
(7, 'Sherifa Mazhar', 'sherifa.mazhar@gmail.com', '01006476610', NULL),
(8, 'Sherifa Mazhar', 'sherifa.mazhar@gmail.com', '01006476610', NULL),
(9, 'Sherifa Mazhar', 'sherifa.mazhar@gmail.com', '01006476610', NULL),
(10, '', '', '', NULL),
(11, 'Sherifa Mazhar', 'sherifa.mazhar@gmail.com', '01006476610', NULL),
(12, 'Jonh Dowling', 'john.dowlingtm@gmail.com', '0876666811', NULL),
(13, 'David', 'Foley', '0861514965', NULL),
(14, 'Kim ', 'sales@cartow.ie', '0861514965', NULL),
(15, 'shady K', 'shadywallas@gmail.com', '01122277229', NULL),
(16, 'Kim ', 'kim.mckayed@webelevate.ie', '0861514965', NULL),
(17, 'Kim ', 'kim.mckayed@webelevate.ie', '0861514965', NULL),
(18, 'shady', 'shadywallas@gmail.com', '01122277229', NULL),
(19, 'David Foley', 'david.foley@cartow.ie', '123123123', NULL),
(20, 'David Foley', 'kim.mckayed@webelevate.ie', '0861514965', NULL),
(21, 'Kim ', 'Kim.mckayed@311-solutions.com', '0861514965', NULL),
(22, 'Kim McKayed', 'kim.mckayed@webelevate..ie', '0861514965', NULL),
(23, 'Kim ', 'Kim.mckayed@311-solutions.com', '0861514965', NULL),
(24, 'Kim McKayed', 'kim.mckayed@webelevate..ie', '0861514965', NULL),
(25, 'Kim', 'kim.mckayed@webelevate.ie', '', NULL),
(26, 'Kim', 'kim.mckayed@311-solutions.com', '', NULL),
(27, 'Diane', 'sales@cartow.ie', '0861514965', NULL),
(28, 'Diane', 'kim.mckayed@webelevate.ie', '0861514965', NULL),
(29, 'Kim', 'kim.mckayed@webelevate.ie', '123123123', NULL),
(30, 'Kim ', 'kim.mckayed@311-solutions.com', '123123123', NULL),
(31, 'shady mohammed', 'shadywallas@gmail.com', '0020120584176', NULL),
(32, '', '', '', NULL),
(33, 'Kim ', 'kim.mckayed@webelevate.ie', '2123412', NULL),
(34, 'Kim', 'kim.mckayed@311-solutions.com', '1234123423', NULL),
(35, 'shady mohammed', 'shadywallas@gmail.com', '01122277229', NULL),
(36, 'shady K', 'shadywallas@gmail.com', '01122277229', NULL),
(37, 'Kamellia', 'kim.mckayed@311-solutions.com', '0861514954', NULL),
(38, 'Shady Keshk', 'shady.keshk@311-solutions.com', '123234234', NULL),
(39, 'Kim', 'kim.mckayed@311-solutions.com', '12312123', NULL),
(40, 'Kim ', 'kim.mckayed9@gmail.com', '08613', NULL),
(41, 'Bren', 'brendan.dowling@cartow.ie', '', NULL),
(42, 'Brendan', 'brendan.dowling@cartow.ie', '', NULL),
(43, 'John', 'john.dowling@cartow.ie', '0876666811', NULL),
(44, 'Kim ', 'kim.mckayed@webelevate.ie', '0861514965', NULL),
(45, 'Paul', 'paulcartow@gmail.com', '086123343', NULL),
(46, 'Kim ', 'kim.mckayed@webelevate.ie', '0861514965', NULL),
(47, 'paul', 'paulcartow@gmail.com', '0876707316', NULL),
(48, 'paul', 'paulcartow@gmail.com', '0876707316', NULL),
(49, 'Kim', 'kim.mckayed@webelevate.ie', '', NULL),
(50, 'Kim', 'kim.mckayed@311-solutions.com', '', NULL),
(51, 'Bill', 'paulcartow@gmail.com', '00000', NULL),
(52, 'Paul', 'paulcartow@gmail.com', '00000', NULL),
(53, 'Mike Dineen', 'a2brecovery@eircom.net', '0879795284', NULL),
(54, 'Mike', 'a2brecovery@eircom.net', '0879795284', NULL),
(55, 'nancy', 'nancy.henry@311-solutions.com', '012', NULL),
(56, 'kim', 'kim.mckayed@311-solutions.com', '011', NULL),
(57, 'asdads', 'asdaa.com', '0141231', NULL),
(58, 'adajskd', 'asdasd', '1041931', NULL),
(59, 'vms_auto', 'vms_auto@vms.ie', '353014509192', NULL),
(60, 'vms_account', 'info@vms.ie', '353018205134', NULL),
(61, '', 'lavolpero@gmail.com', '', NULL),
(62, 'Mahamad Fayez', 'lavolpero@gmail.com', '', NULL),
(63, 'Mahamad Fayez', 'lavolpero@gmail.com', '', NULL),
(64, 'Mahamad Fayez', 'lavolpero@gmail.com', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poc_to_company`
--

CREATE TABLE `poc_to_company` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `poc_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poc_to_company`
--

INSERT INTO `poc_to_company` (`id`, `company_id`, `poc_id`, `type`) VALUES
(1, 21, 35, NULL),
(2, 6, 36, NULL),
(3, 19, 37, NULL),
(4, 14, 40, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotional_code`
--

CREATE TABLE `promotional_code` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(10) NOT NULL,
  `type` char(1) NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `shipping` tinyint(1) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `uses_total` int(11) NOT NULL,
  `uses_customer` varchar(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `promotional_code`
--

INSERT INTO `promotional_code` (`id`, `name`, `code`, `type`, `discount`, `logged`, `shipping`, `total`, `date_start`, `date_end`, `uses_total`, `uses_customer`, `status`, `date_added`) VALUES
(6, 'soso', 'code', '1', '16.0000', 0, 0, '0.0000', '2015-10-06', '2017-10-07', 0, '', 0, '0000-00-00 00:00:00'),
(7, 'sakia-media', 'sdafsd', '8', '80.0000', 0, 0, '0.0000', '2015-10-12', '2015-10-31', 0, '', 0, '2015-10-06 15:21:51');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'master', 'Master Account', '{"view.members.all":true,"members.delete":true, "members.edit":true,"view.members.new":true,"master":true,"reports.*":true, "widgets.top.cartow_users":true, "widgets.top.active_companies":true,"widgets.top.active_agents":true,"widgets.top.due_renewal":true, "widgets.top.active_memberships":true, "widgets.top.active_memberships_value":true, "widgets.top.expired_memberships":true, "widgets.top.expired_memberships_value":true, "widgets.middle.company_activities":true, "widgets.middle.sales_summary":true, "billing":true}', '2015-08-18 13:25:44', '2015-08-18 13:25:44'),
(2, 'sales', 'Sales Account', '{"view.members.all":true,"view.members.new":true,"master":true,"reports.*":true, "widgets.top.cartow_users":true, "widgets.top.active_companies":true,"widgets.top.active_agents":true,"widgets.top.due_renewal":true, "widgets.top.active_memberships":true, "widgets.top.active_memberships_value":true, "widgets.top.expired_memberships":true, "widgets.top.expired_memberships_value":true, "widgets.middle.company_activities":true, "widgets.middle.sales_summary":true, "billing":true}', '2015-09-02 14:03:55', '2015-09-02 14:03:57'),
(3, 'finance', 'Finance Account', '{"view.members.all":true,"members.delete":true, "members.edit":true,"view.members.new":true,"master":true,"reports.*":true,"widgets.top.cartow_users":true, "widgets.top.active_companies":true,"widgets.top.active_agents":true,"widgets.top.due_renewal":true, "widgets.top.active_memberships":true, "widgets.top.active_memberships_value":true, "widgets.top.expired_memberships":true, "widgets.top.expired_memberships_value":true, "widgets.middle.company_activities":true, "widgets.middle.sales_summary":true, "billing":true}', '2015-08-23 09:47:13', '2015-08-23 09:47:13'),
(4, 'administration', 'Administration Account', '{"view.members.all":true,"view.members.new":true,"master":true}', '2015-08-23 09:47:13', '2015-08-23 09:47:13'),
(5, 'staff', 'Staff Account', '{"view.members.all":true,"view.members.new":true,"master":true}', '2015-08-23 09:47:13', '2015-08-23 09:47:13'),
(6, 'driver', 'Driver Account', '{"view.members.all":true,"view.members.new":true,"master":true}', '2015-08-23 09:47:13', '2015-08-23 09:47:13'),
(7, 'company_agent', 'Company Agent', '{"view.members.all":true,"members.delete":true, "members.edit":true,"master":true, "widgets.top.due_renewal":true, "widgets.top.active_memberships":true, "widgets.top.active_memberships_value":true, "widgets.top.expired_memberships":true, "widgets.top.expired_memberships_value":true,  "widgets.middle.sales_summary":true}', '2015-08-23 09:47:13', '2015-08-23 09:47:13'),
(9, 'company_master', 'Company Master Account', '{"view.members.all":true, "members.edit":true,"members.delete":true,"master":false, "widgets.top.active_agents":true,"widgets.top.due_renewal":true, "widgets.top.active_memberships":true, "widgets.top.active_memberships_value":true, "widgets.top.expired_memberships":true, "widgets.top.expired_memberships_value":true,  "widgets.middle.sales_summary":true}', '2015-08-23 09:47:13', '2015-08-23 09:47:13'),
(10, 'member', 'Member Account', '{"master":false}', '2015-09-02 14:03:05', '2015-09-02 14:03:07'),
(11, 'customer_service', 'Customer Service', '{"view.members.all":true,"widgets.add_member":true}', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'service_company', 'Service Company', '{"service.order.add":true,"service.order.view":true}', '2017-11-01 22:00:00', '2017-11-01 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(3, 1, '2015-08-18 13:25:44', '2015-08-18 13:25:44'),
(10, 9, '2015-08-18 13:25:44', '2015-08-18 13:25:44'),
(55, 9, '2015-08-27 12:58:24', '2015-08-27 12:58:24'),
(56, 10, '2015-08-27 13:10:57', '2015-08-27 13:10:57'),
(57, 7, '2015-08-28 09:09:51', '2015-08-28 09:09:51'),
(58, 9, '2015-08-31 08:57:54', '2015-08-31 08:57:54'),
(59, 10, '2015-09-03 06:42:53', '2015-09-03 06:42:53'),
(60, 10, '2015-09-03 09:21:10', '2015-09-03 09:21:10'),
(61, 10, '2015-09-03 10:23:09', '2015-09-03 10:23:09'),
(62, 10, '2015-09-03 11:18:02', '2015-09-03 11:18:02'),
(63, 10, '2015-09-04 07:50:22', '2015-09-04 07:50:22'),
(64, 10, '2015-09-07 06:50:44', '2015-09-07 06:50:44'),
(65, 10, '2015-09-07 08:48:15', '2015-09-07 08:48:15'),
(66, 1, '2015-09-08 07:31:00', '2015-09-08 07:31:00'),
(67, 2, '2015-09-08 09:19:23', '2015-09-08 09:19:23'),
(68, 7, '2015-09-08 09:24:02', '2015-09-08 09:24:02'),
(69, 9, '2015-09-08 09:44:32', '2015-09-08 09:44:32'),
(70, 9, '2015-09-09 08:29:23', '2015-09-09 08:29:23'),
(71, 9, '2015-09-14 09:03:33', '2015-09-14 09:03:33'),
(72, 1, '2015-09-17 09:24:39', '2015-09-17 09:24:39'),
(73, 1, '2015-09-17 09:26:34', '2015-09-17 09:26:34'),
(74, 3, '2015-09-17 09:29:47', '2015-09-17 09:29:47'),
(75, 3, '2015-09-21 12:48:13', '2015-09-21 12:48:13'),
(76, 10, '2015-09-22 07:49:38', '2015-09-22 07:49:38'),
(77, 3, '2015-09-23 08:00:37', '2015-09-23 08:00:37'),
(78, 10, '2015-09-23 08:39:55', '2015-09-23 08:39:55'),
(79, 10, '2015-09-23 08:54:12', '2015-09-23 08:54:12'),
(80, 10, '2015-09-23 08:57:32', '2015-09-23 08:57:32'),
(81, 10, '2015-09-23 09:01:11', '2015-09-23 09:01:11'),
(82, 10, '2015-09-28 11:07:37', '2015-09-28 11:07:37'),
(83, 10, '2015-09-28 11:12:43', '2015-09-28 11:12:43'),
(84, 10, '2015-09-29 08:23:39', '2015-09-29 08:23:39'),
(85, 3, '2015-09-30 06:29:22', '2015-09-30 06:29:22'),
(86, 2, '2015-09-30 06:29:47', '2015-09-30 06:29:47'),
(87, 10, '2015-09-30 08:54:56', '2015-09-30 08:54:56'),
(88, 5, '2015-08-23 14:02:54', '2015-08-23 14:02:54'),
(88, 9, '2015-09-30 09:12:24', '2015-09-30 09:12:24'),
(89, 5, '2015-08-23 14:03:02', '2015-08-23 14:03:02'),
(89, 9, '2015-09-30 10:27:55', '2015-09-30 10:27:55'),
(90, 5, '2015-08-23 14:04:39', '2015-08-23 14:04:39'),
(90, 10, '2015-09-30 10:57:58', '2015-09-30 10:57:58'),
(91, 1, '2015-08-23 14:06:45', '2015-08-23 14:06:45'),
(91, 7, '2015-09-30 11:14:42', '2015-09-30 11:14:42'),
(92, 10, '2015-09-30 12:23:21', '2015-09-30 12:23:21'),
(93, 3, '2015-09-30 12:25:58', '2015-09-30 12:25:58'),
(94, 9, '2015-09-30 12:32:07', '2015-09-30 12:32:07'),
(95, 7, '2015-09-30 12:38:28', '2015-09-30 12:38:28'),
(96, 9, '2015-09-30 13:04:45', '2015-09-30 13:04:45'),
(97, 5, '2015-09-30 13:14:32', '2015-09-30 13:14:32'),
(98, 10, '2015-09-30 13:28:21', '2015-09-30 13:28:21'),
(99, 10, '2015-09-30 13:30:37', '2015-09-30 13:30:37'),
(100, 2, '2015-09-30 14:06:50', '2015-09-30 14:06:50'),
(101, 9, '2015-10-01 19:41:28', '2015-10-01 19:41:28'),
(102, 10, '2015-10-03 12:38:15', '2015-10-03 12:38:15'),
(103, 9, '2015-10-05 09:01:15', '2015-10-05 09:01:15'),
(104, 10, '2015-10-06 09:04:28', '2015-10-06 09:04:28'),
(105, 10, '2015-10-06 09:12:02', '2015-10-06 09:12:02'),
(106, 10, '2015-10-06 09:23:25', '2015-10-06 09:23:25'),
(107, 10, '2015-10-06 09:27:46', '2015-10-06 09:27:46'),
(108, 10, '2015-10-06 09:34:25', '2015-10-06 09:34:25'),
(109, 10, '2015-10-06 09:39:24', '2015-10-06 09:39:24'),
(110, 10, '2015-10-06 12:46:55', '2015-10-06 12:46:55'),
(111, 10, '2015-10-06 12:53:05', '2015-10-06 12:53:05'),
(112, 10, '2015-10-06 12:58:27', '2015-10-06 12:58:27'),
(113, 10, '2015-10-06 13:02:37', '2015-10-06 13:02:37'),
(114, 10, '2015-10-06 13:07:41', '2015-10-06 13:07:41'),
(115, 10, '2015-10-06 13:11:44', '2015-10-06 13:11:44'),
(116, 10, '2015-10-06 13:15:34', '2015-10-06 13:15:34'),
(117, 10, '2015-10-06 13:19:42', '2015-10-06 13:19:42'),
(118, 10, '2015-10-06 13:24:06', '2015-10-06 13:24:06'),
(119, 10, '2015-10-06 13:35:39', '2015-10-06 13:35:39'),
(120, 10, '2015-10-06 13:44:36', '2015-10-06 13:44:36'),
(121, 10, '2015-10-06 13:54:54', '2015-10-06 13:54:54'),
(122, 10, '2015-10-06 14:01:57', '2015-10-06 14:01:57'),
(123, 10, '2015-10-06 14:10:23', '2015-10-06 14:10:23'),
(124, 10, '2015-10-06 14:26:43', '2015-10-06 14:26:43'),
(125, 10, '2015-10-07 06:36:57', '2015-10-07 06:36:57'),
(126, 10, '2015-10-07 06:41:57', '2015-10-07 06:41:57'),
(127, 10, '2015-10-07 06:49:00', '2015-10-07 06:49:00'),
(128, 10, '2015-10-07 06:57:30', '2015-10-07 06:57:30'),
(129, 10, '2015-10-07 07:10:36', '2015-10-07 07:10:36'),
(130, 10, '2015-10-07 07:23:39', '2015-10-07 07:23:39'),
(131, 10, '2015-10-07 07:29:44', '2015-10-07 07:29:44'),
(132, 10, '2015-10-07 07:40:36', '2015-10-07 07:40:36'),
(133, 10, '2015-10-07 07:49:44', '2015-10-07 07:49:44'),
(134, 10, '2015-10-07 08:03:28', '2015-10-07 08:03:28'),
(135, 10, '2015-10-07 08:11:45', '2015-10-07 08:11:45'),
(136, 10, '2015-10-07 08:18:04', '2015-10-07 08:18:04'),
(137, 10, '2015-10-07 08:40:01', '2015-10-07 08:40:01'),
(138, 10, '2015-10-07 08:49:30', '2015-10-07 08:49:30'),
(139, 10, '2015-10-07 08:57:21', '2015-10-07 08:57:21'),
(140, 10, '2015-10-07 09:00:47', '2015-10-07 09:00:47'),
(141, 10, '2015-10-07 09:06:10', '2015-10-07 09:06:10'),
(142, 10, '2015-10-07 09:11:31', '2015-10-07 09:11:31'),
(143, 10, '2015-10-07 09:28:36', '2015-10-07 09:28:36'),
(144, 10, '2015-10-07 09:45:13', '2015-10-07 09:45:13'),
(145, 10, '2015-10-07 09:55:41', '2015-10-07 09:55:41'),
(146, 10, '2015-10-07 10:10:04', '2015-10-07 10:10:04'),
(147, 10, '2015-10-07 10:14:19', '2015-10-07 10:14:19'),
(148, 10, '2015-10-07 10:18:39', '2015-10-07 10:18:39'),
(149, 10, '2015-10-07 10:26:20', '2015-10-07 10:26:20'),
(150, 10, '2015-10-07 10:31:38', '2015-10-07 10:31:38'),
(151, 10, '2015-10-07 10:35:50', '2015-10-07 10:35:50'),
(152, 10, '2015-10-07 10:39:51', '2015-10-07 10:39:51'),
(153, 10, '2015-10-07 10:44:28', '2015-10-07 10:44:28'),
(154, 10, '2015-10-07 10:47:15', '2015-10-07 10:47:15'),
(155, 10, '2015-10-07 10:59:13', '2015-10-07 10:59:13'),
(156, 10, '2015-10-07 11:12:21', '2015-10-07 11:12:21'),
(157, 10, '2015-10-07 12:08:34', '2015-10-07 12:08:34'),
(158, 10, '2015-10-07 12:13:46', '2015-10-07 12:13:46'),
(159, 10, '2015-10-07 12:32:51', '2015-10-07 12:32:51'),
(160, 10, '2015-10-07 12:38:06', '2015-10-07 12:38:06'),
(161, 10, '2015-10-07 12:44:53', '2015-10-07 12:44:53'),
(162, 10, '2015-10-07 12:55:35', '2015-10-07 12:55:35'),
(163, 10, '2015-10-07 13:04:33', '2015-10-07 13:04:33'),
(164, 10, '2015-10-07 13:18:15', '2015-10-07 13:18:15'),
(165, 10, '2015-10-07 13:29:12', '2015-10-07 13:29:12'),
(166, 10, '2015-10-07 13:32:30', '2015-10-07 13:32:30'),
(167, 10, '2015-10-07 13:35:24', '2015-10-07 13:35:24'),
(168, 10, '2015-10-07 13:42:15', '2015-10-07 13:42:15'),
(169, 10, '2015-10-07 13:56:44', '2015-10-07 13:56:44'),
(170, 10, '2015-10-07 14:08:57', '2015-10-07 14:08:57'),
(171, 10, '2015-10-07 14:13:02', '2015-10-07 14:13:02'),
(172, 10, '2015-10-07 14:16:40', '2015-10-07 14:16:40'),
(173, 10, '2015-10-07 14:22:09', '2015-10-07 14:22:09'),
(174, 10, '2015-10-07 14:32:34', '2015-10-07 14:32:34'),
(175, 10, '2015-10-07 14:37:09', '2015-10-07 14:37:09'),
(176, 10, '2015-10-07 14:41:53', '2015-10-07 14:41:53'),
(177, 10, '2015-10-07 14:48:00', '2015-10-07 14:48:00'),
(178, 10, '2015-10-07 14:54:33', '2015-10-07 14:54:33'),
(179, 10, '2015-10-07 15:01:02', '2015-10-07 15:01:02'),
(180, 10, '2015-10-07 15:13:19', '2015-10-07 15:13:19'),
(181, 10, '2015-10-07 15:17:39', '2015-10-07 15:17:39'),
(182, 10, '2015-10-08 08:46:57', '2015-10-08 08:46:57'),
(183, 10, '2015-10-08 10:08:04', '2015-10-08 10:08:04'),
(184, 10, '2015-10-08 10:09:13', '2015-10-08 10:09:13'),
(185, 10, '2015-10-11 09:25:48', '2015-10-11 09:25:48'),
(186, 2, '2015-10-11 12:52:27', '2015-10-11 12:52:27'),
(187, 10, '2015-10-13 07:52:32', '2015-10-13 07:52:32'),
(188, 10, '2015-10-16 10:01:23', '2015-10-16 10:01:23'),
(189, 10, '2015-10-22 07:36:54', '2015-10-22 07:36:54'),
(190, 10, '2015-10-22 07:41:07', '2015-10-22 07:41:07'),
(191, 10, '2015-10-22 07:44:38', '2015-10-22 07:44:38'),
(192, 10, '2015-10-27 10:28:12', '2015-10-27 10:28:12'),
(193, 1, '2015-10-29 09:49:20', '2015-10-29 09:49:20'),
(194, 10, '2015-10-29 13:09:42', '2015-10-29 13:09:42'),
(195, 1, '2015-10-30 12:33:37', '2015-10-30 12:33:37'),
(196, 9, '2015-11-01 09:16:37', '2015-11-01 09:16:37'),
(197, 10, '2015-11-02 14:41:17', '2015-11-02 14:41:17'),
(198, 10, '2015-11-02 17:00:42', '2015-11-02 17:00:42'),
(199, 9, '2015-11-03 13:07:07', '2015-11-03 13:07:07'),
(200, 5, '2015-11-03 14:00:09', '2015-11-03 14:00:09'),
(201, 7, '2015-11-06 09:21:29', '2015-11-06 09:21:29'),
(202, 10, '2015-11-11 13:04:34', '2015-11-11 13:04:34'),
(203, 10, '2015-11-12 14:48:05', '2015-11-12 14:48:05'),
(214, 10, '2015-11-16 07:36:27', '2015-11-16 07:36:27'),
(217, 10, '2015-11-17 10:44:16', '2015-11-17 10:44:16'),
(221, 10, '2015-11-27 11:16:20', '2015-11-27 11:16:20'),
(222, 10, '2015-12-21 08:42:48', '2015-12-21 08:42:48'),
(223, 10, '2016-01-05 09:52:37', '2016-01-05 09:52:37'),
(224, 10, '2016-01-05 09:52:37', '2016-01-05 09:52:37'),
(225, 10, '2016-01-05 09:52:37', '2016-01-05 09:52:37'),
(226, 10, '2016-01-06 11:04:20', '2016-01-06 11:04:20'),
(227, 10, '2016-01-13 10:10:20', '2016-01-13 10:10:20'),
(228, 10, '2016-01-14 08:51:06', '2016-01-14 08:51:06'),
(229, 10, '2016-01-14 09:09:20', '2016-01-14 09:09:20'),
(230, 10, '2016-01-15 09:16:21', '2016-01-15 09:16:21'),
(231, 10, '2016-01-15 10:05:15', '2016-01-15 10:05:15'),
(232, 10, '2016-01-17 13:37:57', '2016-01-17 13:37:57'),
(233, 10, '2016-01-17 13:42:35', '2016-01-17 13:42:35'),
(234, 10, '2016-01-20 09:33:19', '2016-01-20 09:33:19'),
(235, 10, '2016-01-20 11:43:53', '2016-01-20 11:43:53'),
(236, 2, '2016-01-20 12:25:48', '2016-01-20 12:25:48'),
(237, 10, '2016-01-20 14:31:15', '2016-01-20 14:31:15'),
(238, 10, '2016-01-26 09:41:05', '2016-01-26 09:41:05'),
(239, 2, '2016-01-29 13:08:43', '2016-01-29 13:08:43'),
(240, 10, '2016-02-02 11:17:58', '2016-02-02 11:17:58'),
(241, 10, '2016-02-05 11:25:14', '2016-02-05 11:25:14'),
(242, 11, '2016-02-05 11:41:03', '2016-02-05 11:41:03'),
(243, 11, '2016-02-05 11:44:43', '2016-02-05 11:44:43'),
(244, 10, '2016-02-05 12:05:10', '2016-02-05 12:05:10'),
(245, 2, '2016-02-05 12:14:14', '2016-02-05 12:14:14'),
(246, 11, '2016-02-05 12:44:20', '2016-02-05 12:44:20'),
(247, 11, '2016-02-05 12:58:30', '2016-02-05 12:58:30'),
(248, 9, '2016-02-07 12:24:05', '2016-02-07 12:24:05'),
(249, 10, '2016-02-07 12:38:36', '2016-02-07 12:38:36'),
(250, 10, '2016-02-07 12:42:40', '2016-02-07 12:42:40'),
(251, 10, '2016-02-10 07:13:08', '2016-02-10 07:13:08'),
(252, 10, '2016-03-06 12:31:56', '2016-03-06 12:31:56'),
(254, 10, '2016-04-10 14:23:41', '2016-04-10 14:23:41'),
(256, 10, '2016-04-10 14:27:09', '2016-04-10 14:27:09'),
(257, 10, '2016-06-16 11:20:17', '2016-06-16 11:20:17'),
(258, 10, '2016-06-16 11:24:43', '2016-06-16 11:24:43'),
(259, 10, '2016-06-16 11:27:27', '2016-06-16 11:27:27'),
(260, 10, '2016-06-16 11:40:00', '2016-06-16 11:40:00'),
(261, 10, '2016-06-16 11:40:55', '2016-06-16 11:40:55'),
(262, 10, '2017-06-21 13:32:12', '2017-06-21 13:32:12'),
(263, 9, '2017-07-26 19:28:04', '2017-07-26 19:28:04'),
(264, 11, '2017-08-13 16:34:53', '2017-08-13 16:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `service_cc_comments`
--

CREATE TABLE `service_cc_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_cc_comments`
--

INSERT INTO `service_cc_comments` (`id`, `service_id`, `service_type`, `added_by`, `comment`, `created_at`, `updated_at`) VALUES
(1, 5, 'non member', 'CEO of Cartow', 'asdf', '2018-03-06 10:16:35', '2018-03-06 10:16:35'),
(2, 2, 'non member', 'CEO of Cartow', 'test comment', '2018-03-06 10:52:54', '2018-03-06 10:52:54'),
(3, 5, 'non member', 'CEO of Cartow', 'another comment', '2018-03-06 12:00:49', '2018-03-06 12:00:49'),
(4, 5, 'non member', 'CEO of Cartow', '', '2018-03-07 11:39:08', '2018-03-07 11:39:08'),
(5, 6, 'non member', 'CEO of Cartow', 'asdf', '2018-03-19 13:36:03', '2018-03-19 13:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `service_quotes`
--

CREATE TABLE `service_quotes` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `total_distance` varchar(255) DEFAULT NULL,
  `extra_distance` varchar(255) DEFAULT NULL,
  `extra_distance_tax` varchar(255) DEFAULT NULL,
  `tolls` varchar(1000) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_quotes`
--

INSERT INTO `service_quotes` (`id`, `service_id`, `service_type`, `total_distance`, `extra_distance`, `extra_distance_tax`, `tolls`, `total`) VALUES
(1, 5, 'non member', '15.01 km', '10.01km: €20.02', '€4.60', 'Test toll: €5.65', '€30.27'),
(2, 65, 'non member', '15.01 km', '10.01km: €20.02', '€4.60', 'M50: €4.90, Test toll: €5.65', '€35.17'),
(3, 6, 'non member', '5.64 km', '0km: €0', '€€0', '', '€0.00');

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `type`) VALUES
(1, 'Roadside assistance'),
(2, 'Battery start'),
(3, 'Repair on site'),
(4, 'Wheel change'),
(5, 'Local tow'),
(6, 'Re-fuel');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `item` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `code`, `item`, `value`) VALUES
(1, 'due-renewal', 'Due renewal range (in days)', '30'),
(2, 'eta-span', 'ETA span (in minutes)', '70'),
(3, 'max-distance', 'Max distance allowed (in Kms)', '5'),
(4, 'extra-distance-tax', 'Extra Distance Tax (%)', '23'),
(5, 'assigned-status-kpi', 'Service Assigned Status KPI (in minutes)', '30');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `status`) VALUES
(1, 'Active'),
(2, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `sub_user_types`
--

CREATE TABLE `sub_user_types` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_user_types`
--

INSERT INTO `sub_user_types` (`id`, `type`) VALUES
(1, 'Staff'),
(2, 'Driver'),
(3, 'Company user');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE `throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tolls`
--

CREATE TABLE `tolls` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cost` float NOT NULL,
  `tax` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_type` int(11) NOT NULL COMMENT 'Master = 1;Subuser = 2;Company = 3;Agent = 4; Customer = 5',
  `account_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '(1->active,2->inactive)',
  `created_at` int(11) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `permissions`, `first_name`, `last_name`, `remember_token`, `account_type`, `account_id`, `status`, `created_at`, `last_login`, `updated_at`) VALUES
(3, 'test username', 'ceo@carotw.ie', '$2y$10$yQP4ts6axzD2lB6uT8FeHe5C5nk3MGLDrZBpmoRut/A/fAGNdigzm', '{"user.create":true,"user.delete":false}', 'CEO', 'of Cartow', '6F0JNvMtOuH1n1pEoRbKoHL5Q4YvJzBe3NoD7WjLQIA4JJqFOhaU9bgv42oH', 1, 6, 1, 1432826603, '2018-03-21 09:46:39', '2018-03-21 09:46:39'),
(10, 'test company', 'asdf', '$2y$10$01oKt3NP0C/7rfbzD4QCsOrGs5BsoYZIf7OpsE/ngOQpKZrb8uMq2', '{"user.create":true,"user.delete":false}', 'Shady', 'KEshk', 'zqa1M78pFS4qlX2nRHEwKeeYvJTPJYjnjHR2zylU81d34bS6sqPbWC7LUyw1', 3, 6, 1, 1433321390, '2016-02-01 10:14:16', '2015-09-03 07:58:51'),
(30, '', 'asdfasd', '', NULL, NULL, NULL, NULL, 0, 0, 1, 2015, '2016-02-01 10:14:17', '2015-09-14 09:17:57'),
(55, 'Testing', 'shadywallas@gmail.comsasdf', '$2y$10$GyZ/D/FaEsoNL3f7aP0Azu4y2vOR9CVgBYa0Uk70HuciKFpjzfEVm', '{"user.create":true,"user.delete":false}', 'shady ', 'mohammed', 'NTNjtAvYVxIffqs7NRPaj4HYBauEQhdkkHhcY8zqJKoRG499uB65DDNsn6xg', 4, 0, 1, 2015, '2016-02-01 10:31:02', '2015-10-11 12:46:58'),
(56, 'finefoods', 'asdfasdfasdf', '$2y$10$6GjGZ4cvB.KjngKOLNwSPe0y.0LbZCMwwpsCcKvBN.kPUS/22Rc56', NULL, NULL, NULL, NULL, 5, 0, 1, 2015, '2016-02-01 10:14:20', '2015-08-27 13:10:57'),
(57, 'kim2', 'kim.mckayed@webelevate.ie141', '$2y$10$s1O4JVv6HpYojWtUXli8GOMEil6tVclEsR/8lKJtzf0rCzfYxOPtC', '{"user.create":true,"user.delete":false}', 'kim', 'mckayed', 'vhuLKyGI1bFZnYApGT9XSrhbwD2GA08uL2jQslg4k4lme12ssM3dmo7MvqCD', 4, 0, 1, 2015, '2016-02-01 10:22:56', '2015-11-16 07:50:10'),
(58, 'kimshady', 'kim.mckayed@webelevate.ie', '$2y$10$By7tRYBmX5TMfcY02khlOejofqH5AkyxCIlB2PXuGBR5JYCKRoE8G', '{"user.create":true,"user.delete":false}', 'Kim ', NULL, '97JuTvYiCexUPCcBOyC7XWrq6MwwqVZUxZqRgpjRW4SRGPtP1DRo5XJO6NA6', 4, 0, 1, 2015, '2016-01-15 10:55:56', '2016-01-15 10:55:56'),
(59, '', 'shadywallas@gmail.com_old0', '$2y$10$gQ0.xI/y251ojfqwU0mr3e4ZNhmMiyj/zGDlxnAQqiCcYqjs6OB1e', NULL, 'shady', 'mohammed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:03', '2016-02-01 10:13:03'),
(60, '', 'shadywallas@gmail.com_old1', '$2y$10$4leLryTPIl4UCQObnAx1A.R1hJxiDm/ki7GICGSHCw98fAS64UsvK', NULL, 'shady', 'mohammed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:03', '2016-02-01 10:13:03'),
(61, '', 'shadywallas@gmail.com_old2', '$2y$10$gC8qptalgPisjVUBr91P/O5RiXSHuZn.URlZWnL1XTM4k6D7.6lbm', NULL, 'raef', 'mohammed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:03', '2016-02-01 10:13:03'),
(62, '', 'mckayek@tcd.ie', '$2y$10$il7L.fHaPKrPwfO52iP.p.J1/9HVdRaM5RpHarctthVDvXRDMza2G', NULL, 'Kim ', 'McKayed ', NULL, 5, 0, 1, 2015, '2015-09-03 12:18:02', '2015-09-03 11:18:02'),
(63, '', 'desiree.casburn@gmail.com_old0', '$2y$10$pbWtI/piMt5vz8i98dxTgOwzB00GLjChxFAo3a.OX/O.7ewE1SnyO', NULL, 'Desiree', 'Casburn', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:07', '2016-02-01 10:13:07'),
(64, 'kate.carley@gmail.com', 'kate.carley@gmail.com', '$2y$10$V4Fq.r894JIXXRWfSRg/vuWGlDnoh2d/b9B1WS/zaj/BI0JSIxp5m', NULL, 'Kate', 'Kinsella', NULL, 5, 0, 1, 2015, '2015-09-07 07:50:44', '2015-09-07 06:50:44'),
(65, '', 'kim.mckayed@311-solutions.com_old0', '$2y$10$I9Nmee7a/PNnKOWovXaEqeD7E3hg5YdqcDnB5C0zy39NUuZURPGvG', NULL, 'Kim', 'McKayed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:02', '2016-02-01 10:13:02'),
(66, 'kimmckayed', 'kim.mckayed@311-solutions.com', '$2y$10$sR7qqHOsyMbFDjVL.JCE6Ot2hDskKgsT.hFnGogMIYgCi8whklAeq', NULL, 'Kim', 'McKayed', NULL, 4, 0, 1, 2015, '2015-09-08 08:31:00', '2015-09-08 07:31:00'),
(67, 'dianne.warren2', 'sales@cartow.ie1', '$2y$10$X5hnGCnSV6OxAbUXA2s1s.B8lLbOvaitHTwKW.T.OPCdMAkI43YMO', '{"user.create":true,"user.delete":false}', 'Kim', 'McKayed', 'CPiDI2iPgLpIgjA3PXjDnENfZlR3IMz1BKf5LFQypQppCeXwzThjQupUspOr', 4, 0, 1, 2015, '2016-01-20 12:23:48', '2016-01-20 12:09:27'),
(68, 'agentkim', 'kim.mckayed@webelevate.ie45345', '$2y$10$2EYwkvID5zF6DKWCsNadeux3RYxDNKZtnXdPgqUUjN9PNNXOCruLq', '{"user.create":true,"user.delete":false}', 'Kim', 'McKayed ', 'u7Fwuy2GiyaiFbYuHGVchL9HC0qP31T41qFM37IZiipc9tTBy2gRXgQZgibH', 4, 0, 1, 2015, '2016-02-01 10:23:03', '2015-09-08 09:43:04'),
(69, 'kimcustomer', 'kim.mckayed@311-solutions.com52', '$2y$10$0d2o6Srwh5GIsKKnoaSk4uKRYCkXUgphvcvcxxCAovZoHJ2rUZJga', NULL, 'Kim', 'McKayed ', NULL, 4, 0, 1, 2015, '2016-02-01 10:21:52', '2015-09-08 09:44:32'),
(70, 'kimshadycustomer', 'shady.keshk@311-solutions.com', '$2y$10$XIPAZ0/w0V2JrxI1HskNs.wxT/5i/qAZoA9tv9VeBoiwFUrMfK51u', '{"user.create":true,"user.delete":false}', 'Shady ', 'Keshk', 'oP6DTpiseg675LBDKl8oWWOApMZbHsKgaQEBRZ3DO10JYx6ct9MJIVxIMrRi', 4, 0, 1, 2015, '2017-05-10 12:15:46', '2017-05-10 12:15:46'),
(71, 'brentest', 'brendan.dowling@cartow.ie', '$2y$10$W9n/mqdIlNiXGZSzf9YZkuReBIBZn0f56dkvrXWxfAQV3/pW33SMG', '{"user.create":true,"user.delete":false}', 'Bren', NULL, NULL, 4, 0, 1, 2015, '2015-09-30 09:03:37', '2015-09-30 09:03:37'),
(72, 'kimfinance', 'kim.mckayed@webelevate.ie453', '$2y$10$5YHeZP3u.hGP7zkpmD6PQuXn0bk92TT1aJ8cjBZKPGvR/Gu12Okj.', NULL, 'Kim', 'McKayed', NULL, 4, 0, 1, 2015, '2016-02-01 10:23:00', '2015-09-17 09:24:39'),
(73, 'kimfinancetest', 'kim.mckayed@webelevate.ie5345', '$2y$10$aag07LBKliMcdlkGIhI4k.VV.fkHbLgEkCmT4NjGWzV6yV7vCnZv6', '{"user.create":true,"user.delete":false}', 'Kim', 'McKayed', '04lehIkioKRdTQ3ePLzveLGyunU2VnYdgULObBPrSIC9QVtMyn7kas2eeiwX', 4, 0, 1, 2015, '2016-02-01 10:22:59', '2015-09-21 11:26:02'),
(74, 'financekimtest', 'kim.mckayed@311-solutions.com144', '$2y$10$4ZRCHD4nf.u2.Rw9qVQgjen0NuJssu6OKvKAOcv60r2EDKL5vITz.', '{"user.create":true,"user.delete":false}', 'Kim', 'McKayed', 'cSIIpovuDVyWmU3vg7ffdr4n1AWq7ATHe9ayjZlGq2xFP8hgaVO173IH1pY0', 4, 0, 1, 2015, '2016-02-01 10:21:47', '2015-09-17 09:50:28'),
(75, 'shadywallasf', 'shadywallas@gmail.com', '$2y$10$o/xlT7QpxU3LhHzI/XDoX.DxrhP0gnBaDsPL6P/Hn.gzXvVV0r2A.', '{"user.create":true,"user.delete":false}', 'shady', 'mohammed', '6No9ExCvaDVvxqagajnkKw0iValKoSB8ZrBf7Vl84QX2nb85h4tiPuj8lWTT', 4, 0, 1, 2015, '2016-01-28 11:47:32', '2016-01-28 11:47:32'),
(76, '', 'johnbutler289@gmail.com', '$2y$10$a5AjeOX6PhwJLpAopsNGBeC4XlsbRimWvKgOS8BBkniURhu19bXDm', NULL, 'John', 'Butler', NULL, 5, 0, 1, 2015, '2015-09-22 08:49:38', '2015-09-22 07:49:38'),
(77, 'dfoley', 'david.foley@cartow.ie_6', '$2y$10$OMo2LKwtWrZZlczdyF1VDOOLcgmcKZ5g3kbWP.Lg5NvuV.UvkElwW', NULL, 'David', 'Foley', 'fRg3AMnNZKzhvdoJm02CapDNhlETwhxntQGjt311xqPFOvgIrR3pWQ1ldXBr', 4, 0, 1, 2015, '2016-02-01 10:19:36', '2015-09-29 05:45:49'),
(78, 'jbutler', 'johnbutler285@gmail.com_old0', '$2y$10$oF/KtjrMk4E2x4CGyDsaseUstucSwUbTthdL7hyc/DUTQzWb3Wae6', NULL, 'John ', 'Butler ', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:05', '2016-02-01 10:13:05'),
(79, 'jbutler', 'johnbutler285@gmail.com_old1', '$2y$10$uMUZuCfRBKAGeECRg/suJOZb/iEaGQPIFB.xsYt/zNUZ/cpnQeFfi', NULL, 'John', 'Butler', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:05', '2016-02-01 10:13:05'),
(80, 'jbutler', 'johnbutler285@gmail.com_old2', '$2y$10$SZTJLG.6jEuPMGo0qAcP2.g1fnRQd5iF4i8hwOQOKGgaMVbk9XbWW', NULL, 'John', 'Butler', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:05', '2016-02-01 10:13:05'),
(81, 'jbutler', 'johnbutler285@gmail.com', '$2y$10$nIW1PbUsudUR8P0eo7jzAuOQKBlwJ8riABX5WltqVN7rfYAIGZD9m', NULL, 'John', 'Butler', NULL, 5, 0, 1, 2015, '2015-09-23 10:01:11', '2015-09-23 09:01:11'),
(82, 'Testing', 'shadywallas@gmail.com_old3', '$2y$10$kYg.XJeMva9tIXaUSww1G.GIrWND0CK7M5p3abaSxNll8tMundr5.', NULL, 'shady', 'mohammed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:03', '2016-02-01 10:13:03'),
(83, 'kimmckayed', 'kim.mckayed_old1@311-solutions.com', '$2y$10$mdHOt4cXYy.lcFdDm/L6luXrA7MJn14YRsdLESHjxoYsijW3pBvYG', NULL, 'Kim ', 'McKayed ', NULL, 5, 0, 1, 2015, '2016-04-10 16:41:23', '2016-04-10 14:41:23'),
(84, 'kimmckayed', 'kim.mckayed@311-solutions.com_old2', '$2y$10$ZMPP6eSV0LZjzHTt7z9nZOjhg4sOrNr1zsoiHUztHRC3l4tZY0zfK', NULL, 'Kim ', 'McKayed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:02', '2016-02-01 10:13:02'),
(85, 'billingtest', 'kim.mckayed@webelevate.ie523', '$2y$10$UjPAeEl0HTnE83qtPNHhS.QdTwiSbza0Tx4c0JA18n01gOad88zae', NULL, 'Kim', 'McKayed', 'lc0EC4cUCHOowhcWJ4XSdAfoXA6BFUWfhzkZZsR7IykpuFJopis89BI6S8Nt', 4, 0, 1, 2015, '2016-02-01 10:22:57', '2015-09-30 09:14:14'),
(86, 'salestest', 'kim.mckayed@311-solutions.com14', '$2y$10$brIB56pCA.f9yIA.jl4ZWuiCt62Hn8T3.xErCSa9p06JL9.cbzHMW', NULL, 'Kim', 'McKayed', 'XzNfvl0ZGtuwHr4ucqqR8bcAGmZtoIoMBohmLeF7VEIQELoUG0NnMoKklPiV', 4, 0, 1, 2015, '2016-02-01 10:21:43', '2015-09-30 13:47:18'),
(87, 'kimmckayed', 'kim.mckayed@webelevate.ie_old0', '$2y$10$2TOVyF1ukBicFDywt1IfMufWNftTjOCQzHwb5GlvfxxGKMFUvCH.G', NULL, 'Kim ', 'McKayed ', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:01', '2016-02-01 10:13:01'),
(88, 'johndowling', 'john.dowling@cartow.ie', '$2y$10$nbXH1EeX8ZeADToEJv3jQeNAZXNF6wth1nmLQ7HfYpANrnzo/hWwC', NULL, 'John', NULL, NULL, 4, 0, 1, 2015, '2017-05-10 12:15:24', '2017-05-10 12:15:24'),
(89, 'paulohalloran', 'paulcartow@gmail.com', '$2y$10$ySNj0WVaGR2JQxwpYzLWmOM5FfPT3UaONkafL5n2qC5DsmwLDLBlK', NULL, 'Paul', NULL, 'SpKb8ECGGc5SVwIZ4dEITD0nQUJTmQbODV0A2GdPhF8VDwHK6ujRUyJmolUd', 4, 0, 1, 2015, '2016-01-06 06:24:21', '2016-01-06 06:24:21'),
(90, 'bruce wayne', 'paulcartow@gmail.com_old0', '$2y$10$1uSFQ2Al1kT.UbfUhDAFdOBqS1vxcj9H3lEqHz2DdiswUIoBBlya6', NULL, 'Bruce', 'Wayne', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:04', '2016-02-01 10:13:04'),
(91, 'Paulagent', 'paulcartow@gmail.com1235', '$2y$10$pqVFJKUflTWS4Ju55vimWen.PEun7duuUOV5PihGl2noG2Xx6/wSq', NULL, 'Paul', 'O\'Halloran', '9ekRKoIzxg5BtCEmjjSJMIQSfBn8ZrxH4UvsLqfa8uDxsIJMTjnXD2xQE2Dl', 4, 0, 1, 2015, '2016-02-01 10:25:19', '2015-09-30 11:28:22'),
(92, 'paultesting', 'paulcartow@gmail.com_old1', '$2y$10$/tKGmHzi8tWfKX9QZ7kkz.tJaxnHgYt704EmYEJ1oCq4Obt7K6s/6', NULL, 'Paul', 'O\'Halloran', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:04', '2016-02-01 10:13:04'),
(93, 'davidfoley', 'david.foley@cartow.ie', '$2y$10$H/PX1EpzLt3g7Ehugp0clu3Lx8pUxGDZD4rDa6zb82dW65v2PWYXi', NULL, 'David', 'Foley', 'O28dU1tIlQMloxWGUfUVkOxqQhJeyYcKWE9HdEngiYkr1hD0KKL9gJyPvbCg', 4, 0, 1, 2015, '2016-02-09 07:08:04', '2016-02-09 07:08:04'),
(94, 'paulcartow', 'paulcartow@gmail.com12', '$2y$10$GyS6lI4ysYJd9WtLLNe05O2Dk3xvYKoItsX2FjawQV71ZVkTXijIq', NULL, 'paul', NULL, NULL, 4, 0, 1, 2015, '2016-02-01 10:25:07', '2015-11-12 15:54:22'),
(95, 'agent 1', 'agent1@gmaill.com', '$2y$10$NvGHYZtNOQILjNjABVpoGOo4TJhUOOdPghoMyTKg8yd1g9y51Rogq', NULL, '	agent1', 'tester', NULL, 4, 0, 1, 2015, '2015-09-30 13:38:28', '2015-09-30 12:38:28'),
(96, 'kimbotest', 'kim.mckayed@webelevate.ie14', '$2y$10$S9EX9MMlNGLSCGUlNzTZo.vsljEQOPInhdhXRQOwbSpa3vpqL1BBe', NULL, 'Kim', NULL, NULL, 4, 0, 1, 2015, '2016-02-01 10:22:54', '2015-11-23 12:58:11'),
(97, 'cartow', 'should provide email', '$2y$10$Av8OMwRqE3/Fcn9AA0T9Dexga07J6fc87JmN6EdLhQABkYy/MRLv.', NULL, '', '', '6k5sdGfP12N4aHw3nQlgLzGgy7RazmvUUxk7tDxyu42DM0KBNkCFo6VXRgq5', 4, 0, 1, 2015, '2016-02-01 10:36:15', '2015-10-06 19:19:51'),
(98, 'kim.mckayed', 'kim.mckayed@webelevate.ie_old1', '$2y$10$2C1ElksDHi7NVXeVpM6UN.k0mpcUXJJ1fEsGphXrAz/QD9x4sWd1a', NULL, 'Kim ', 'McKayed ', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:01', '2016-02-01 10:13:01'),
(99, 'kimmeb1', 'david.foley@cartow.ie_old0', '$2y$10$AHcJgx1zuhq1clettolld.X17HC9Bm9kgIuM01mBl16Ey1DU3JLhm', NULL, 'David', 'Foley', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:06', '2016-02-01 10:13:06'),
(100, 'dianewarren2', 'sales@cartow.ie2', '$2y$10$yYEV86iuJqsxVDJu6cDUnekWTG3SpCZeR5rRQpf84xPd.VkIDwnc.', NULL, 'Diane', 'Warren', 'KDRgHBq2072CuQE2tEgGHvVtHL1PFxfStS5FUDakUHtK0HUwVvOaN5mLYz48', 4, 0, 1, 2015, '2016-01-20 12:23:45', '2016-01-20 11:50:05'),
(101, 'monthlybill', 'paulcartow@gmail.com123', '$2y$10$wQZRshiBEUsdTuHpRZPXhuKltRa1.tbMp7TyrCRD62zn/9/au7Koq', NULL, 'Bill', NULL, 'OpPgwznOloQYofbhQl9NDRmEdjINqNlXjpCAdd0JxAZkaChEGV0cnuPB207U', 4, 0, 1, 2015, '2016-02-01 10:25:10', '2015-10-06 19:15:04'),
(102, '', 'trevorgilligan@gmail.com', '$2y$10$twVMbQxWpj.ReZyKzQXJb.wOEt9Az82orFZCNTBrgeNQPOg6dTtbG', NULL, 'trevor', 'gilligan', NULL, 5, 0, 1, 2015, '2015-10-03 13:38:15', '2015-10-03 12:38:15'),
(103, 'mdineen', 'a2brecovery@eircom.net', '$2y$10$ZhiwDwYME6qwcbbkYRkZPOEey.9Zu.SoPWirivXGdk3uhrveApG62', NULL, 'Mike Dineen', NULL, 'ReiT7WVB8I0WOaRNcO69CUJmmJnpebI4YUhuVAf5duKtQwXrP2t4eguBV1sT', 4, 0, 0, 2015, '2015-10-07 14:05:04', '2015-10-07 13:05:04'),
(104, 'dhagan', 'marc@vms.ie_old0', '$2y$10$8kcrJQNZCTUZIdV3VfAAqOA8JTJp9aPFF8pyGU3D9OpngqAp.BcLS', NULL, 'Donna ', 'Hagan', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:53', '2016-02-01 10:12:53'),
(105, 'mregan', 'marc@vms.ie_old1', '$2y$10$JkMmlAEoPkW8LB5HpUO4Au5PkZcRuPcjsdM5iWuvcocNm7opebqT6', NULL, 'Michael', 'Regan', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:53', '2016-02-01 10:12:53'),
(106, 'behrhart', 'marc@vms.ie_old2', '$2y$10$s57FBmCy0I/lfq9O82vxiO.O797g6zNE4xgk61Q0YpwAz9d0.Bayy', NULL, 'Ben', 'Enrhart', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:54', '2016-02-01 10:12:53'),
(107, 'dlloyd', 'marc@vms.ie_old3', '$2y$10$66.juSGLNIBNLZ9q7BTJEuSKNutzrgDDaME1ZVTc/dPSoIo2gUCWS', NULL, 'Denise ', 'lloyd', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:54', '2016-02-01 10:12:54'),
(108, 'aogrady', 'amogrady@gmail.com', '$2y$10$s8fmAUmfxkgRkYHL9pwb/.19AFFvk067bYz.GOk81oVj/qCtwOKIu', NULL, 'ann marie', 'ogrady', NULL, 5, 0, 1, 2015, '2015-10-06 10:34:25', '2015-10-06 09:34:25'),
(109, 'kmurphy', 'marc@vms.ie_old4', '$2y$10$UL/JjuwUu2gNxLM9sCTQ2eugApgWAudlqES/cWVYMEz5h.a4atQF2', NULL, 'ken ', 'murphy', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:54', '2016-02-01 10:12:54'),
(110, 'amccann', 'marc@vms.ie_old5', '$2y$10$KSNddlEVngFsr0WWJ1GVWeVgYGHKDT2LqG4k2mriAcp4ODc3693..', NULL, 'aishling', 'mccann', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:54', '2016-02-01 10:12:54'),
(111, 'ptravers', 'marc@vms.ie_old6', '$2y$10$Vv7slg2onSzeojljx5prkeO89YeAz7v64Z6.0EV/Omvh/KThKDbU6', NULL, 'peter ', 'travers', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:54', '2016-02-01 10:12:54'),
(112, 'cmccluskey', 'marc@vms.ie_old7', '$2y$10$BqWqQya2Jmd36UQtSrOk5uR/QvoSalJ6P.H4jePsxd5R.Rou0KUr2', NULL, 'clare ', 'mc cluskey', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:54', '2016-02-01 10:12:54'),
(113, 'pfrelly', 'marc@vms.ie_old8', '$2y$10$OzexligqB8UO7Hk01ruYxe3qiOZY41DUmJWNShGwNjrIshGsR2FM2', NULL, 'peter ', 'frelly', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:54', '2016-02-01 10:12:54'),
(114, 'jkennedy', 'sales@usedcarcentre.ie', '$2y$10$S9VuTE6dHmdymIaj1p69NuZ8V5xaU2p334Gw4ogDinFu9n1LqgoXu', NULL, 'jennifer ', 'kennedy', NULL, 5, 0, 1, 2015, '2015-10-06 14:07:41', '2015-10-06 13:07:41'),
(115, 'Lmoran', 'marc@vms.ie_old9', '$2y$10$Xqeg9wMl3HZ7w9inCX5Yhe8zJejfkcf1WmczrXuRr.sHNYQFALq6y', NULL, 'lena', 'moran ', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:55', '2016-02-01 10:12:55'),
(116, 'rcruise', 'rcruise150@hotmail.com', '$2y$10$WldzGGju/CkxE3QCLD5l5OLSPELoPKAL.l6lKpiTpmxOvzS6QNy3C', NULL, 'rosie ', 'cruise', NULL, 5, 0, 1, 2015, '2015-10-06 14:15:34', '2015-10-06 13:15:34'),
(117, 'jkavanagh', 'marc@vms.ie_old10', '$2y$10$7Yeu0Jcvf.Zzdoukhu298eNLkHf9RyYxXVdzL7/8GfU1zjrsoclmG', NULL, 'justin', 'kavanagh', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:55', '2016-02-01 10:12:55'),
(118, 'rhunt', 'rhunter2085@gmail.com', '$2y$10$srd7u.VYSjJ8lUX2jZIgleV3iBYNazsddzsOB49QV.M0m1ayDKLJ.', NULL, 'roy ', 'hunt', NULL, 5, 0, 1, 2015, '2015-10-06 14:24:06', '2015-10-06 13:24:06'),
(119, 'bgill', 'dgmotorsdubin@gmail.com', '$2y$10$i5SXqc7I1f6uyrj4EaRJ5.3u1VTsXAFR1RrAePhY1vfXmZvvGkjda', NULL, 'bridet', 'gill', NULL, 5, 0, 1, 2015, '2015-10-06 14:35:39', '2015-10-06 13:35:39'),
(120, 'tdoyle', 'sales@justgoodcars.ie', '$2y$10$TRKbLa/A7JbB7eAzxq.XZ.LWUvJUmCTD/kK.gcdOQWWtkJzHzepW2', NULL, 'thomas ', 'doyle', NULL, 5, 0, 1, 2015, '2015-10-06 14:44:36', '2015-10-06 13:44:36'),
(121, 'jcarter', 'marc@vms.ie_old11', '$2y$10$5NYaKGpS6S/DOel4LdGL4Ot6fi0T1d6vePHa7d5h0C.FpMLiCPLTW', NULL, 'jackie ', 'carter ', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:55', '2016-02-01 10:12:55'),
(122, 'smcdonagh', 'marc@vms.ie_old12', '$2y$10$zIaOJ2.kUMDA3Dg4/Sdeb.cmrlCMr0hGR9uemkAXuyou.AqgeB7Qe', NULL, 'sean', 'mcdonagh', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:55', '2016-02-01 10:12:55'),
(123, 'smcdonagh', 'marc@vms.ie_old13', '$2y$10$bD6OxFuLDrv3/wYepH897ONsHhmJOK0Pc6Y7LGsK/bB0dyrNb8kxy', NULL, 'sean ', 'mcdonagh', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:55', '2016-02-01 10:12:55'),
(124, 'bcarolan', 'marc@vms_old0', '$2y$10$FpUTDKBi72v/9QVGkN8O7u1GBRFaIt.sWy7.UKSDLU/XkLfWBTl4i', NULL, 'brendan', 'carolan', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:06', '2016-02-01 10:13:06'),
(125, 'skelly', 'marc@vms.ie_old14', '$2y$10$eZM3V1cb4ZFkCWpDnMCdku.axiqEaAeSnzzyIrs4Dk96E1aJR7rXm', NULL, 'stevyn ', 'kelly', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:55', '2016-02-01 10:12:55'),
(126, 'msoliman', 'marc@vms.ie_old15', '$2y$10$lIUzB.uN6rZqkAukqpuwz.8rUICqwHWoFjEbnfbQjFCTZbcrIy8Y6', NULL, 'mary ann', 'soliman', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:56', '2016-02-01 10:12:55'),
(127, 'jdaniel', 'marc@vms.ie_old16', '$2y$10$ynNtgA3Emxi4th3/cddETOhQgFnmZ3QIUem3vcefcIIqbX7ktkHrK', NULL, 'james', 'daniel', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:56', '2016-02-01 10:12:56'),
(128, 'khegarty', 'nualahegarty1@yahoo.ie', '$2y$10$xilfl2J4OHYb1bKU3PeDZekCEsUyVUzyNtg8iqfImDJU9EjXWFlQ2', NULL, 'KEVIN', 'HEGARTY', NULL, 5, 0, 1, 2015, '2015-10-07 07:57:30', '2015-10-07 06:57:30'),
(129, 'Ibouarroudi', 'marc@vms.ie_old17', '$2y$10$n/dDNoZyLnV6w4pgg5P2puN8oRwoq7G9QNNS3eGzrxZlp26oELXUm', NULL, 'Iseult', 'Bouarroudj', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:56', '2016-02-01 10:12:56'),
(130, 'jdarcy', 'northcountyusedcars@gmail.com', '$2y$10$LuiQbtWlKOA3xsLl4iUik.VY9EcK1DTzSW9V0HHKx3urTt5X5zppa', NULL, 'jim ', 'darcy', NULL, 5, 0, 1, 2015, '2015-10-07 08:23:39', '2015-10-07 07:23:39'),
(131, 'rmolloy', 'robbie_molloy@hotmail.com', '$2y$10$yoTblf7AdK3w7ezZ7oHm7eAdwn/nYLN7qyVZ6CVDei9MGSJvjIWG6', NULL, 'rob', 'molloy', NULL, 5, 0, 1, 2015, '2015-10-07 08:29:43', '2015-10-07 07:29:43'),
(132, 'mlambe', 'marylambe@hotmail.com', '$2y$10$9Vp70oIWFKSXI2ENiRvGWe5i71r./TRmSKleCjTWGDOIQ2dL.gP6u', NULL, 'mary ', 'lambe ', NULL, 5, 0, 1, 2015, '2015-10-07 08:40:36', '2015-10-07 07:40:36'),
(133, 'dlangton', 'marc@vms.ie_old18', '$2y$10$DwAwT/Akxsy7QwCnrwVpcOAzZW5EQPs76lGV8jEHTmmL3jGNG6Tju', NULL, 'darren', 'langton ', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:56', '2016-02-01 10:12:56'),
(134, 'rjames', 'sales@amcdublin.ie', '$2y$10$qUDPuJWYjLa03fSP8Pii/OlxVe1lZ6sk.A99vFU5Salt9dHirFEWG', NULL, 'roy ', 'james', NULL, 5, 0, 1, 2015, '2015-10-07 09:03:28', '2015-10-07 08:03:28'),
(135, 'kobrien', 'sales@drimnaghmotors.com', '$2y$10$CYg3HPLNQKkIu0/4Ddis9eXx9syNts..GHtsCOINXVmNLNC2nu5AO', NULL, 'karl ', 'o brien', NULL, 5, 0, 1, 2015, '2015-10-07 09:11:45', '2015-10-07 08:11:45'),
(136, 'pmcphillips', 'hillsidegarages@gmail.com', '$2y$10$0Y0GVOy8.A9FmypKH70Yqu8KMwfnwmLMiPe7.b.YDkGUVVY8wp7sW', NULL, 'paddy ', 'mcphillips ', NULL, 5, 0, 1, 2015, '2015-10-07 09:18:04', '2015-10-07 08:18:04'),
(137, 'llambe', 'thelambe4@gmail.com', '$2y$10$UFPtzJvXVSWhNLAfyuQIF.EROaf.mOD2bCiP1TxsPVdpWdBpguEnC', NULL, 'louise ', 'lambe', NULL, 5, 0, 1, 2015, '2015-10-07 09:40:01', '2015-10-07 08:40:01'),
(138, 'dkavanagh', 'marc@vms.ie_old19', '$2y$10$pCCJmHbqWRcwhPBtixcyEuP7PEfVVNmlfQBBDwWZmFzvLyQ8BYwQW', NULL, 'deborah', 'kavanagh', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:56', '2016-02-01 10:12:56'),
(139, 'sobrien', 'shanetobrien@gmail.com', '$2y$10$t8Bo9ksl0SvdEjJ/OC0XnOAVGlVtVwrulX2vM7VH3QRLXTXhTV/Z2', NULL, 'shane', 'o brien', NULL, 5, 0, 1, 2015, '2015-10-07 09:57:21', '2015-10-07 08:57:21'),
(140, 'shiggins', 'marc@vms.ie_old20', '$2y$10$BDAmNN8mHq9Y4WtxWD68..yYP.LxL41Ufwr8eTDrg1UJaDTOtvMme', NULL, 'shane ', 'Higgins', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:56', '2016-02-01 10:12:56'),
(141, 'ahill', 'marc@vms.ie_old21', '$2y$10$zGa.hZmFpfB4YRA5/.eHsO9JiRrsPYXeKqF5HRUxTjgrisofOFCfK', NULL, 'austin ', 'hill', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:57', '2016-02-01 10:12:56'),
(142, 'mrooney', 'marc@vms.ie_old22', '$2y$10$LenSlt7mtijwHjd/G8ZaRudbxn0Hgcnr76.XAJJTFoRXrM5l4d2fW', NULL, 'mary', 'rooney', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:57', '2016-02-01 10:12:57'),
(143, 'sflynn', 'marc@vms.ie_old23', '$2y$10$2O7UwYnUoD1peM/.MFSP6u0yS6S8X17B30p09gWRErbxNoZTXf9SS', NULL, 'sarah ', 'flynn', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:57', '2016-02-01 10:12:57'),
(144, 'emcgoldrick', 'marc@vms.ie_old24', '$2y$10$iO9bu9naz6zvYp/MhlYMyuzwhiWM1jsYcjt5sP4ErnV3gl0haHcBm', NULL, 'eoghan', 'mcgoldrick', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:57', '2016-02-01 10:12:57'),
(145, 'tkeogh ', 'marc@vms.ie_old25', '$2y$10$UBXlrJr8amdJScPP3Conn.0Zu2ZiIsnxR8ws2lDw7OK9w4KRPbsRK', NULL, 'teresa ', 'keogh', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:57', '2016-02-01 10:12:57'),
(146, 'abrennan', 'marc@vms.ie_old26', '$2y$10$eO1onAK..q/dMj4Bha31euHVHwaOGH1n8Et5cPQFrk/70p6lJC0FW', NULL, 'anthony ', 'brennan', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:57', '2016-02-01 10:12:57'),
(147, 'dcregan ', 'marc@vms.ie_old27', '$2y$10$VqMg0vptdR2b.zfcRrY5BuOUPY.E52z7/OPNqY6QAvJJ6MMgE3mZO', NULL, 'David ', 'cregan', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:58', '2016-02-01 10:12:57'),
(148, 'dduignan', 'marc@vms.ie_old28', '$2y$10$1lM1WgT1Wsdi3YB8iSXyCegGGEeC.cc5eIPVetq6ohZ.SfQhCarva', NULL, 'david duignan', 'david duignan ', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:58', '2016-02-01 10:12:58'),
(149, 'dmcfadden ', 'marc@vms.ie_old29', '$2y$10$hdYl4yTvfylHD3JavWUdMODeMH1.JRhAPgweSlZfNelOG9BubZMAm', NULL, 'david ', 'mcfadden ', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:58', '2016-02-01 10:12:58'),
(150, 'ebyrne ', 'marc@vms.ie_old30', '$2y$10$UlbFgaS7VORvqxtcMQuqlu5YaRVipOgK7zdKV6FcczMqMIC4Ml/ZS', NULL, 'edward ', 'byrne ', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:58', '2016-02-01 10:12:58'),
(151, 'pmorgan', 'marc@vms.ie_old31', '$2y$10$8s/rkZGfMsL8a9tk8zIUVeOQJvNvd0xXZfieRqJbkOwuYhxZiW4u2', NULL, 'peter ', 'morgan', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:58', '2016-02-01 10:12:58'),
(152, 'hsheahan', 'marc@vms.ie_old32', '$2y$10$kZs1CrWK8bEdcH1S/4Q4POLmNvVQ3NpothYXFr.10WlPxoUihfwEC', NULL, 'holly ', 'sheahan ', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:58', '2016-02-01 10:12:58'),
(153, 'dbedford ', 'marc@vms', '$2y$10$Ly8EdJlVVcuVA3P0g8ljA.EhgF7blVzYQ6yS2AuVF/EVDaG1m0wN6', NULL, 'darren', 'bedford', NULL, 5, 0, 1, 2015, '2015-10-07 11:44:28', '2015-10-07 10:44:28'),
(154, 'legan ', 'l.egan@hotmail.com', '$2y$10$YP.X5ji6dBZJ1R3aAi98Ruhdn2.MaIEoLmGpriEp6696brPDcdIM.', NULL, 'lisa ', 'egan', NULL, 5, 0, 1, 2015, '2015-10-07 11:47:15', '2015-10-07 10:47:15'),
(155, 'gskedgwell', 'marc@vms.ie_old33', '$2y$10$y7hKXD7aHDnVCGj03NBQa.x26dO0Gk5zWnlegqZuttDuSyC/z6Rjq', NULL, 'gary ', 'skedgwell', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:58', '2016-02-01 10:12:58'),
(156, 'rsleafer ', 'marc@vms.ie_old34', '$2y$10$v3XOq0BYTbERNARDS73ZjuPgGg9offkaK2/VWz5TV98c8FFp9lZMO', NULL, 'raphaela ', 'sleafer', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:59', '2016-02-01 10:12:58'),
(157, 'fdeabreu', 'marc@vms.ie_old35', '$2y$10$CUOOsU5h24aikFd9s25sxuhUJyNw4C2RH8U1Z.MiDAPiMI9Aug62.', NULL, 'felipe ', 'pereira de abreu', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:59', '2016-02-01 10:12:59'),
(158, 'pelebert', 'marc@vms.ie_old36', '$2y$10$7gwPmorwXGoJnf6L65F2x.t/N/3NphxtV1yDfDl.EsuIHIizAMTx2', NULL, 'paul ', 'elebert', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:59', '2016-02-01 10:12:59'),
(159, 'kcoleman', 'kcole031@gmail.com', '$2y$10$RIbpm6DFNrHnzA5x7tLjEe2NUX.ekNchrIXycmXRXwkpxNeGCkMRu', NULL, 'keith', 'coleman', NULL, 5, 0, 1, 2015, '2015-10-07 13:32:51', '2015-10-07 12:32:51'),
(160, 'boneill', 'marc@vms.ie_old37', '$2y$10$fuSl3wYEN/MEwMdLBY8PWu8ZSyRPeBNF/OkBGtv/sTFUGhUYqd.mu', NULL, 'brian ', 'oneill', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:59', '2016-02-01 10:12:59'),
(161, 'kgibney', 'karengibney@gmail.com', '$2y$10$g2mmF.wHPF7.CkvOCfbbFOFyJWMTbn7LLm9ZH40oTe2RrlkinImlm', NULL, 'karen ', 'gibney ', NULL, 5, 0, 1, 2015, '2015-10-07 13:44:53', '2015-10-07 12:44:53'),
(162, 'pomahony', 'paulineomahony@hotmail.com', '$2y$10$cEm2TL5z1mXRFqzU.0dVHOM4RZk0bhpv4yWglW8J3UrlEV0TTXz42', NULL, 'pauline ', 'o mahony ', NULL, 5, 0, 1, 2015, '2015-10-07 13:55:35', '2015-10-07 12:55:35'),
(163, 'bkelly', 'senatorjohnkelly@gmail.com', '$2y$10$CxQoIacUr0U1aFCJojIV2eGRV0TeSGL9JHn1DF8xD.aZCz04LlUsa', NULL, 'breege ', 'kelly ', NULL, 5, 0, 1, 2015, '2015-10-07 14:04:33', '2015-10-07 13:04:33'),
(164, 'dfoley', 'marc@vms.ie_old38', '$2y$10$A3JFSwdknRj6NbTXX8Rap.Q/4xKnxJhL2lbV1I155Me/Cf0CoV55m', NULL, 'deirdre', 'foley', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:59', '2016-02-01 10:12:59'),
(165, 'tlawlor', 'marc@vms.ie_old39', '$2y$10$YNCTZKkl.sYa5YRqvZMNZejDejrbXZab9sXXfGcdJSzZMmHAkpKvO', NULL, 'tom ', 'lawlor', NULL, 5, 0, 1, 2015, '2016-02-01 10:12:59', '2016-02-01 10:12:59'),
(166, 'dshannon ', 'marc@vms.ie_old40', '$2y$10$vToq8NGxhDcN2kyg312IkuelHSdWtwfSf8Z4VZ72vYv.2DzRIgVLS', NULL, 'danielle', 'shannon', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:00', '2016-02-01 10:12:59'),
(167, 'ycoleman', 'marc@vms.ie_old41', '$2y$10$ydzB.zGW.NdFXw437p.A9.cT8dqyYzeFlufiIgybTOYz3G9AM7wQC', NULL, 'yvonne ', 'coleman', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:00', '2016-02-01 10:13:00'),
(168, 'gdceilings', 'marc@vms.ie_old42', '$2y$10$0ZcxdGRXwdsjJo1x0Z4CbuPu/ejkCl.F4meQYUVuX.WTHaHSbDNXG', NULL, 'gd', 'ceilings', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:00', '2016-02-01 10:13:00'),
(169, 'mbruton ', 'marc@vms.ie_old43', '$2y$10$EZvl7MGN3rdqiVPrJr7Jr.ze2lcZRqbELD0WXbDBlbCwdPsoJdJe.', NULL, ' michelle ', 'bruton ', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:00', '2016-02-01 10:13:00'),
(170, 'rmorales', 'marc@vms.ie_old44', '$2y$10$xoYRvom1Yk1hqGYKt4rUN.qhVtSa0hXPLDhGVXtDcj6sXKJbj08eq', NULL, 'rhoda ', 'morales ', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:00', '2016-02-01 10:13:00'),
(171, 'bduffy ', 'marc@vms.ie_old45', '$2y$10$jGmHeHfPFp6SkwVjH1uvfOt2TKkngVDG4uaMbMFzO0yT0u./xWbTu', NULL, 'bernie ', 'duffy', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:00', '2016-02-01 10:13:00'),
(172, 'pcorless', 'lewdpat@gmail.com', '$2y$10$hSzOMiIH2w9PisDzyUJYxOvJYOy8BK4gk6jOFHNagGDUQSMBlsh2m', NULL, 'pat ', 'corless ', NULL, 5, 0, 1, 2015, '2015-10-07 15:16:40', '2015-10-07 14:16:40'),
(173, 'jharding', 'marc@vms.ie_old46', '$2y$10$5t8q11EM2/Vp.F0zQIEMIuxscppT/5XXyj9kHLZxURKGL/oicvuby', NULL, 'john ', 'harding', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:01', '2016-02-01 10:13:00'),
(174, 'ehourigan', 'elaineh2010@hotmail.com', '$2y$10$5BAL2Eg7/3v3lYNROiQ8L.zdQS3AmSOHO5nEgDHrAZkTIFheoCGMy', NULL, 'elaine ', 'hourigan', NULL, 5, 0, 1, 2015, '2015-10-07 15:32:34', '2015-10-07 14:32:34'),
(175, 'pmcgann', 'ian@hainesfleet.ie_old0', '$2y$10$QVrjK4kiGfFNsxS8GDuOOuSUmxb9NPMAXLiNWW7vj9mIWQhZJFbr.', NULL, 'paul ', 'mcgann', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:04', '2016-02-01 10:13:04'),
(176, 'iflood', 'ian@hainesfleet.ie_old1', '$2y$10$ZOg3Z.a3.U5vyJNAhHf9Iejor0OvFcQi0ub1vMe18rFhybCxnYPFK', NULL, 'ian ', 'flood', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:04', '2016-02-01 10:13:04'),
(177, 'iflood ', 'ian@hainesfleet.ie_old2', '$2y$10$VCBIosYWcgV./K8o4.wSDOTR2647pz3mlI02m/vV/MO6SomipZYzK', NULL, 'ian', 'flood', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:04', '2016-02-01 10:13:04'),
(178, 'iflood', 'ian@hainesfleet.ie_old3', '$2y$10$iEYwrMnzSG6cdL.J0Y8deuAZYiCjN.Tll1tIXQl50C5tIwP5ZdZE2', NULL, 'ian', 'flood', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:05', '2016-02-01 10:13:05'),
(179, 'iflood ', 'ian@hainesfleet.ie', '$2y$10$MvgPn/Ju6Xt.mT8/sziVsOcmj3UkHC2spFLFiNDbVQqEUvAwdya3S', NULL, 'ian ', 'flood ', NULL, 5, 0, 1, 2015, '2015-10-07 16:01:02', '2015-10-07 15:01:02'),
(180, 'smurphy', 'seaneenmurpf2@gmail.com', '$2y$10$PE5ONLfpYFZfrBD0khLRXOWGnQgvK5M8Z/4GNp5hEWUL0A1oVIDtW', NULL, 'sean', 'murphy', NULL, 5, 0, 1, 2015, '2015-10-07 16:13:19', '2015-10-07 15:13:19'),
(181, 'jmaguire', 'marc@vms.ie_old47', '$2y$10$o8Ujd6/q71EKHqKPLBP8Dez8yG8f/E8GTkAIq.muQ9vKrsK3fJI8u', NULL, 'john ', 'maguire ', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:01', '2016-02-01 10:13:01'),
(182, 'cengelbrecht', 'marc@vms.ie_old48', '$2y$10$mgbsMgLkQBpbZjyxclFfEO.7cgMdowiSOL2VaBzuC.KgVabDUGo3W', NULL, 'clint', 'engelbrecht', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:01', '2016-02-01 10:13:01'),
(183, 'kmckayed', 'kim.mckayed@webelevate.ie_old2', '$2y$10$q3dWFU/fGMxPaCDHIDevfOXAz1b0vRXTAKCitSlVwYS.oRCWGV7bq', NULL, 'Kim ', 'McKayed ', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:02', '2016-02-01 10:13:01'),
(184, 'kmckayed', 'kim.mckayed@webelevate.ie_old3', '$2y$10$x6skBib9xgvGRnbFFzieb.jV4cj4mOWi./zSmBbZD3lixPeydR7Wm', NULL, 'Kim', 'McKayed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:02', '2016-02-01 10:13:02'),
(185, '', 'kim.mckayed@311-solutions.com_old3', '$2y$10$OMvgNU2t1MK/qwEX7Nt9SOluO3psAMlUbYEzQt1p94guB3iSWB3k.', NULL, 'Kamel ', 'McKayed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:03', '2016-02-01 10:13:02'),
(186, 'onilineform', 'shadywallasonilineform@gmail.com', '$2y$10$T7Hf2GeEFsC7KHlz8qpZjeBccERtKrou5ismKb08kYjKyeOMbgmFu', NULL, 'online', 'form', NULL, 4, 0, 1, 2015, '2016-02-01 10:31:16', '2015-10-11 12:52:27'),
(187, 'Gsynnott', 'marc@vms.ie', '$2y$10$svL5pu9GLGBGQhcvRZ3jueBzwsohxhUTLLIuWNNNPlLXpy77gIUfG', NULL, 'gemma ', 'synnott', NULL, 5, 0, 1, 2015, '2015-10-13 08:52:32', '2015-10-13 07:52:32'),
(188, '', 'kim.mckayed@webelevate.ie_old4', '$2y$10$62NBBgXn1w05jpERLR2VpeQ9oTaZkssRMHcIzqsV2BZY3/O7eF9K2', NULL, 'Kim', 'McKayed', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:02', '2016-02-01 10:13:02'),
(189, 'sdowney ', 'shane.downey77@hotmail.com', '$2y$10$.Q/xdWIxiW6.rWtxPG1MI.rwiqCY9xZRxJqGvxUXI7NweOCFwgxze', NULL, 'shane ', 'downey', NULL, 5, 0, 1, 2015, '2015-10-22 08:36:54', '2015-10-22 07:36:54'),
(190, 'oscanlon', 'scanlonorla@gmail.com', '$2y$10$8TEESvvLtmXEhN7ziD/qZ.aEN6T4zU0CWTShdu2quHml5wL0eePSS', NULL, 'Orla ', 'Scanlon', NULL, 5, 0, 1, 2015, '2015-10-22 08:41:07', '2015-10-22 07:41:07'),
(191, 'oscanlon2', 'sales@cartow.ie3', '$2y$10$TqR2huyae3J3oSyjI8jtouEFuu5oO0RsrVuJ49Sw9DsfL5mnEKebG', NULL, 'lisa ', 'Warren', NULL, 5, 0, 1, 2015, '2016-01-20 12:24:07', '2015-10-22 07:44:38'),
(192, 'jjudge ', 'info@malahidecarsales.ie', '$2y$10$yjU2tLCYDoLlyZ9eG0fplOWh.jUUW2HD5HP8koAxePGNv9bu063zS', NULL, 'jim ', 'judge ', NULL, 5, 0, 1, 2015, '2015-10-27 10:28:12', '2015-10-27 10:28:12'),
(193, 'llacken', 'lianne.lacken@cartow.ie', '$2y$10$yQP4ts6axzD2lB6uT8FeHe5C5nk3MGLDrZBpmoRut/A/fAGNdigzm', NULL, 'Lianne', 'Lacken', 's7APCD3W9HdDqpW4TBGiXRfBQsjkWNFaJIth2MGXbs50w0XiVfiV7nxj08FA', 4, 0, 1, 2015, '2015-11-15 05:24:23', '2015-11-15 05:24:23'),
(194, '', 'stefan.cork@gmail.com', '$2y$10$e9cM8.JOA8ZlvKP6UrbevOCCmTczcX5i2qBXxyr6FkqaCnaPnlFI2', NULL, 'stefan', 'ludwig', NULL, 5, 0, 1, 2015, '2015-10-29 13:09:42', '2015-10-29 13:09:42'),
(195, 'kate.harelik', 'kate.h@belitsoft.com', '$2y$10$yUBhzri9e4kQthmQdLfH9uZRF.Ww39eSsDIwkLQdSqpOKZdGkiKwu', NULL, 'Katie', 'Harelik', 'sn7FRgOYWXA9driQS4u6sT2KUFQC5xnzCpbpVsvJrhBQ6yDl7rQN5qbjhrM3', 4, 0, 1, 2015, '2015-11-02 06:29:57', '2015-11-02 06:29:57'),
(196, 'nancy.henry', 'nancy.henry@311-solutions.com', '$2y$10$ykvLob0evpPJFSiPvkFiH.BLVvpeoyMJC/MFp4EYUSAVAyibUvkBe', NULL, 'nancy', NULL, 'hAcFjpfxe0sz5PEsl6Ih3uCWYNxoRxf2r0TDPuvZo4aNa86GOksptT3ISVZs', 4, 0, 1, 2015, '2015-11-19 11:03:12', '2015-11-19 11:03:12'),
(197, '', 'zwakerley@gmail.com', '$2y$10$X8gSY15DGQXxbPgnXa6v0uT8InH1b/6agmKEF43rY1U7Z1tbmeBQ.', NULL, 'Zoe', 'Wakerley', NULL, 5, 0, 1, 2015, '2015-11-02 14:41:17', '2015-11-02 14:41:17'),
(198, '', 'gerryrellis@yahoo.com', '$2y$10$LXkEXokkGof.DxkEO2cSIO5bQaS9XtOKguBr.KvEZ4XWeyRMxhzt2', NULL, 'Gerard', 'Rellis', NULL, 5, 0, 1, 2015, '2015-11-02 17:00:42', '2015-11-02 17:00:42'),
(199, 'mfayez', 'mfayez.311sol@gmail.com', '$2y$10$0sOU8uNrYaMjo1Sw8AyoKupd2KnZrqKu/V2GFaIH3.WAmdNo9vwwq', NULL, 'Fayez Raw', NULL, NULL, 4, 0, 1, 2015, '2016-04-10 12:22:26', '2016-04-10 12:22:26'),
(200, 'fayez', 'mohamed.fayez@311-solutions.com', '$2y$10$wTDnDFzVYO1VCAaGdSJDyeo5N4rei9I/UykacLZfrxVFQtwEPia46', NULL, 'Mohamed', 'Fayez', 'TvIkQkoZIoX9isAgMiTvT1c1PPyL2sTHjzq7COXcxT6aGzsXG0zMRRaQ24GZ', 4, 0, 1, 2015, '2015-11-23 12:38:15', '2015-11-23 12:38:15'),
(201, 'kimnancy', 'kim.mckayed9@gmail.com', '$2y$10$BI4KYplxABkCvjYgfjtT6eTWAPQK6jbAAtdeEmXsNBCKzFTta59XS', NULL, 'Kim', 'McKayed', 'tl5zhKqUDeJ2UEhkfcsrvysDQ38AVjnZ3N9d07GQZaingKKxK9fSrwq8cfEp', 4, 0, 1, 2015, '2015-11-06 09:38:32', '2015-11-06 09:38:32'),
(202, 'dcasburn', 'desiree.casburn@gmail.com', '$2y$10$Ce9tcPMPpbhcv/722biUfecnyX6w2aL9NmzjjMFwtNne6Hj6Fcq0u', NULL, 'DESIREE', 'CASBURN', NULL, 5, 0, 1, 2015, '2015-11-11 13:04:34', '2015-11-11 13:04:34'),
(203, 'VINCENT', 'OBRIENSOUTSIDECATERING@EIRCOM.NET', '$2y$10$pGup69j8Qvbju//e5TVndOOt7v8AK9EOHDD0J9fmP1ymYYjnHP3Ti', NULL, 'BUISH', 'VINCENT', NULL, 5, 0, 1, 2015, '2015-11-12 14:48:05', '2015-11-12 14:48:05'),
(204, '', 'CONTACTCENTRE@CARTOW.IE', '$2y$10$H291p4H4jn9bU9ewsEw73.1GlnjiLEe.UEODpdNg6JvucmyRVWzFC', NULL, 'DOLORES', 'MCCORMACK', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 14:56:51'),
(205, '', 'DOROLESCARTOW@GMAIL.COM', '$2y$10$ZKIkoBtpiIe4bNNCGn1LwOGeeckKHBjVNnIeH08esb.50DRQgXMRq', NULL, 'DOLORES', 'MCCORMACK', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 14:58:29'),
(206, '', 'KEITHCARTOW@GMAIL.COM', '$2y$10$At.TFtPBUE7aGrs9PXjleuOh4CTZGB4R6gpT0p207E9h2.sHtFRBC', NULL, 'KEITH', 'HUGHES', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 14:58:54'),
(207, '', 'EVECARTOW@GMAIL.COM', '$2y$10$NgpS4fII5BRuBochfb92feHzQISVrBQCcUZi3kVIVjDBBHEefSW8q', NULL, 'EVE', 'SMULLEN', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 14:59:23'),
(208, '', 'GLENNCARTOW@GMAIL.COM', '$2y$10$oSTEkgZuMXk56Y5hLBFNuejtDIzJQ6tgQ62/KMZdF30a4egPTYROO', NULL, 'GLENN', 'HAZLEY', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 14:59:54'),
(209, '', 'HELENCARTOW@GMAIL.COM', '$2y$10$TaNVV4VmIFgze9.ELseYOun5b1DtQCerxGYmhS8j7djRdea1a5bbq', NULL, 'HELEN', 'CLINTON', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 15:00:31'),
(210, '', 'ALOUGHREY60@GMAIL.COM', '$2y$10$J9OgG9nvxRrxduY6DFUzaebyFetwBCMQ3mYr6M3/ULE33szs.mOra', NULL, 'AMY', 'LOUGHREY', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 15:01:21'),
(211, '', 'CHRIS@CARTOW.IE', '$2y$10$WXWiC0HPAt9hTjcPRD5pLu7MTj9yNGAZV3/QIcDnadmxQ/2LSrTFm', NULL, 'CHRIS', 'CRONIN', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 15:01:59'),
(212, '', 'dolorescartow@gmail.com', '$2y$10$isSHvGET.4gSFNTiXJMDX.cB/VC5JMkJ6lWZwGPmaxzEw.flYYGYS', NULL, 'Dolores', 'McCormack', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 15:29:28'),
(213, '', 'TEST@TEST.IE', '$2y$10$L9ACMRjvkXh6V6FdKwTpEeWgy4dsh4dJDRPDO/oCz1Hv8mL7Od8nO', NULL, 'TEST', 'TEST', NULL, 0, 0, 1, 2015, NULL, '2015-11-12 15:53:05'),
(214, 'DJOHNSON', 'DARREN.JOHNSON@CROSSINGS.IE', '$2y$10$4nDG0Ln7OMQwUotbwtQafeZXKd/XMwUkkzutrkQcZTbQ41/eyJyae', NULL, 'DARREN ', 'JOHNSON ', NULL, 5, 0, 1, 2015, '2015-11-16 07:36:27', '2015-11-16 07:36:27'),
(215, '', 'comaher78@gmail.com1', '$2y$10$LyCHOECUnAeYFtmTooVWuOMnqT3NDFxSaT6I1rlVfu5M.Ygtk1w4G', NULL, 'Colin', 'Maher', NULL, 0, 0, 1, 2015, '2016-02-01 10:18:25', '2015-11-16 09:15:16'),
(216, '', 'comaher78@gmail.com12', '$2y$10$rvTbwzGJdhnLc6CT/zsxLenXoFT1CpmUp0hggM4xPQHslMPs2ej/e', NULL, 'Colin', 'Maher', NULL, 0, 0, 1, 2015, '2016-02-01 10:18:27', '2015-11-16 09:18:03'),
(217, 'john test', 'john.dowling@cartow.ie_old0', '$2y$10$tAk37JTzvJQ6nTkTOndXxeJ87MFok5fcpVNSZJbIls6oSKSPoR2Y6', NULL, 'John', 'Test', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:07', '2016-02-01 10:13:07'),
(218, '', 'nancyhenry89@gmail.com', '$2y$10$ZgcEtLnQuJVDmgtKjgrXsugu/vJRa1nj9jbm7GxzCmU7..9FDdSe2', NULL, 'nancy', 'henry', NULL, 0, 0, 1, 2015, NULL, '2015-11-19 11:03:48'),
(219, '', 'comaher78@gmail.com123', '$2y$10$aRSqBMfQ/FQ1JSWnpwzUOe05hNNYJlyrjLKIPAiwp0UdVWhup/jYa', NULL, 'Colin', 'Maher', NULL, 0, 0, 1, 2015, '2016-02-01 10:18:29', '2015-11-24 14:04:48'),
(220, '', 'comaher78@gmail.com1234', '$2y$10$uNBDDSSGpr4UUAg9PQWOvOP9JaWFTL5Z4KFgjcyjraY6Q1WwjUzFW', NULL, 'Colin', 'Maher', NULL, 0, 0, 1, 2015, '2016-02-01 10:18:32', '2015-11-24 14:07:17'),
(221, 'cobrien 2', 'sales@cartow.ie4', '$2y$10$mmKS2jGaVJjRB9KHc.SYtufEu4GQxnJ9axA/3YxxQS0lduukXNXd2', NULL, 'ciara ', 'obrien ', NULL, 5, 0, 1, 2015, '2016-01-20 12:24:10', '2015-11-27 11:16:20'),
(222, 'dmadden', 'dean.madden@aerarann.com', '$2y$10$qj7.CC.JsqIFzlwn1b4KrO8jMRwN4pUDdGJVFqGA6yILSkTpQk3XW', NULL, 'Dean', 'Madden', NULL, 5, 0, 1, 2015, '2015-12-21 08:42:48', '2015-12-21 08:42:48'),
(223, 'eward', 'accessdrains@hotmail.com_old0', '$2y$2y$10$PDSeEjnaz3x/enc7KnaG9eVmOCyBHZyTVU0xOVCDgZhkKLqRCS', NULL, 'Emma', 'Ward', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:06', '2016-02-01 10:13:06'),
(224, 'eward1', 'accessdrains@hotmail.com_old1', '$2y$2y$10$fq0Y.1rdM93Y0vDShsopg.lmUgU3YHipxUdaOU8QzYiZKk18qU', NULL, 'Emma', 'Ward', NULL, 5, 0, 1, 2015, '2016-02-01 10:13:06', '2016-02-01 10:13:06'),
(225, 'gward', 'accessdrains@hotmail.com', '$2y$2y$10$2DH9hXcYkKdN5EOO7fhOGuZl/mq5lE1OW1pKbo3UJj4lUlpsLE', NULL, 'Gavin', 'Ward', NULL, 5, 0, 1, 2015, '2016-01-05 07:52:51', '2015-12-24 16:53:55'),
(226, '', 'michelletbourke@gmail.com', '$2y$10$u725rIxkUcW5gsZOwmw8puN0zmXZeePI8hHgWRrmAhnyOrxn0rrCe', NULL, 'Michelle', 'Bourke', NULL, 5, 0, 1, 2016, '2016-01-06 11:04:20', '2016-01-06 11:04:20'),
(227, '', 'hiteshswork@gmail.com', '$2y$10$zuNba74U7ABQLJs1WO1gP.2D2v8oeEF2DGPmxEoavHFf0LrWqM3Iy', NULL, 'Hitesh', 'Singh', NULL, 5, 0, 1, 2016, '2016-01-13 10:10:20', '2016-01-13 10:10:20'),
(228, 'tgorman', 'tommygorman210@hotmail.com_old0', '$2y$10$PuIj1y8vLfReW5ouup1lrODZY8zfKwrFpKw8o/CQ2JZL2Kl2N6GdO', NULL, 'tommy ', 'Gorman ', NULL, 5, 0, 1, 2016, '2016-02-01 10:13:07', '2016-02-01 10:13:07'),
(229, 'tgorman', 'tommygorman210@hotmail.com', '$2y$10$T42Fh7JIH8A0XvQqH4o6k.Uwe4ZkbmArbhCrH/YOsDnhrIv2J/Jra', NULL, 'tommy ', 'Gorman ', NULL, 5, 0, 1, 2016, '2016-01-14 09:09:20', '2016-01-14 09:09:20'),
(231, '2', 'sales@cartow.ie5', '$2y$10$9.kgT4uE0QA8X6yEBWfjBem1R7wKsXvtHhzlDPVWVwtZ.rTQNx7lm', NULL, 'tommy ', 'Gorman ', NULL, 5, 0, 1, 2016, '2016-01-20 12:24:21', '2016-01-15 10:05:15'),
(232, '', 'mccabeanne@hotmail.com', '$2y$10$eoAYF5gDkbiWU/eFgnxvw.v1LskWMl3e37tZcfZys3EiU0K9gTV0O', NULL, 'Anne', 'McCabe', NULL, 5, 0, 1, 2016, '2016-01-17 13:37:57', '2016-01-17 13:37:57'),
(233, '', 'brendan_ryan1@icloud.com', '$2y$10$T4xWnsz52kmFD2ku/NV2LO/bfYmi2SILh6rZ2V7WHCfgld.Pr7iiO', NULL, 'Brendan', 'Ryan', NULL, 5, 0, 1, 2016, '2016-01-17 13:42:35', '2016-01-17 13:42:35'),
(234, 'rmarkey98@yahoo.com', 'ronanm98@yahoo.com_old0', '$2y$10$e1VZeynhQVQqvLQ94wd8P.CxM7.2OxwqobEhdmKyP2fgnjnNn7Y3K', NULL, 'RONAN', 'MARKEY', NULL, 5, 0, 1, 2016, '2016-02-01 10:13:13', '2016-02-01 10:13:09'),
(235, 'rmarkey', 'ronanm98@yahoo.com', '$2y$10$xN.E670GEZ9UP4pcM1SDkepnfEt97eeAUpB/L3RcynCbU.0Y./FB2', NULL, 'ronan', 'Markey', NULL, 5, 0, 1, 2016, '2016-01-20 11:43:53', '2016-01-20 11:43:53'),
(236, 'dianewarren', 'sales@cartow.ie', '$2y$10$EocmM/w1qHCYZDFIRzuXhOo9gUaBh7clI7rPItyGFV8b/.y5zWU9u', NULL, 'diane', 'warren', 'F3rrufxOy8MIfXcKaDRtnx46K8B7piosJUAAIyLQZrYiFFUqeHC5Y1Nt5KkE', 4, 0, 1, 2016, '2016-02-07 16:13:08', '2016-02-07 16:13:08'),
(237, 'sbyatt', 'sales@cartow.ie_old0', '$2y$10$QDXjjrQwD8VAlkKjH.xhe.dhlCOI3vJYcBQEkHb7qKTWvY5f6tmG.', NULL, 'steven ', 'byatt', NULL, 5, 0, 1, 2016, '2016-02-01 10:13:25', '2016-02-01 10:13:22'),
(238, 'WKAVANAGH', 'sales@airwaysmotorcompany.ie', '$2y$10$So7VHfIrUD5v7di/BB.tge8O5u5MFkESmfq45Z3aZqTmH/M3cxkz.', NULL, 'William', 'Kavanagh', NULL, 5, 0, 1, 2016, '2016-01-26 09:41:05', '2016-01-26 09:41:05'),
(239, 'salesuser', 'cartow.webmaster@outlook.com', '$2y$10$TWsKK4gmRJ17rlBHHayR5.5dduoesODZ3Gk1E0CVRtV4McfwdrArO', NULL, 'Sales', 'User', 'ITD2HNNirA22NIbuiFVoVVr7jvyRJ1zWwsQKlDTgos8jrpGcYRusRJBZsIuC', 4, 0, 1, 2016, '2016-01-29 13:21:49', '2016-01-29 13:21:49'),
(240, '', 'lesleyleonard55@gmail.com', '$2y$10$7bO.x1br8EqvNj0HSsYioez9ABWpaoGnOGTHXwWdC1u3uIL97tNDW', NULL, 'lesley', 'leonard', NULL, 5, 0, 1, 2016, '2016-02-02 11:17:58', '2016-02-02 11:17:58'),
(241, 'shadykeshk', 'shady.keshk2@311-solutions.com', '$2y$10$iWyU7FTDhNiRwn.iSp5IOu5MXfycRf2gQcS9e/PmsLyFvxv/0ra5K', NULL, 'Shady', 'Keshk', NULL, 5, 0, 1, 2016, '2016-02-05 11:25:14', '2016-02-05 11:25:14'),
(242, 'Call Centre', 'info@cartow.ie', '$2y$10$Ep/JkxBRD/Mx1o8uZmvW5.bWDyF4DRc68mXKRKvAPIMlZfG4B/i4e', NULL, 'Call ', 'Centre', NULL, 4, 0, 1, 2016, '2016-02-05 11:41:03', '2016-02-05 11:41:03'),
(243, 'kimsales', 'info@tochildrenwithlove.ie', '$2y$10$0FlKIZewyvmyalGAHf7Cke0PPkdxjKQNKKALk5Pco4HpygS8GU./C', NULL, 'Kim', 'McKayed', 'pzaVz4t4sepizaJVOlFm6NqyEQVegRPeKRbPgA7pWQaomG31qvPkykzOlRXa', 4, 0, 1, 2016, '2016-02-05 13:24:38', '2016-02-05 13:24:38'),
(244, 'mmcgrath', 'marcmcgrath91@gmail.com', '$2y$10$cAByv6M.UuOz0nsms2oQ/efJFth692/fpbIU697BKtyOpqT6e4OQq', NULL, 'marc ', 'mcgrath', NULL, 5, 0, 1, 2016, '2016-02-05 12:05:10', '2016-02-05 12:05:10'),
(245, 'dainewarren ', 'dianewarren79@gmail.com', '$2y$10$RUcyQiQ5dDTVfTaWv0KgWO168lazhsqf1eugfJL2M3p6Z/WT6jRT2', NULL, 'Diane', 'Warren', NULL, 4, 0, 1, 2016, '2016-02-05 12:14:14', '2016-02-05 12:14:14'),
(246, 'callcentre', 'kim@childrenwithlove.ie', '$2y$10$PDKbjhW3pM0ZoAa8cLGoyOe1euJ6gJ3.0.aibivSt5tw5/ZDfqFba', NULL, 'Call', 'Centre', NULL, 4, 0, 1, 2016, '2016-02-05 12:44:20', '2016-02-05 12:44:20'),
(247, 'davecallcentre', 'davidfo84@gmail.com', '$2y$10$9HgxsBX.Po2QirdjjTXiG.XFeYmWYtRduD1v.iDK8wzroGi9LXc6m', NULL, 'Call', 'Centre', 'R4iNoPTRmH8TrqNCkDsmrJHjCbEzbGS18r9VxAmyRJy4DlYatQbG2iVfexoS', 4, 0, 1, 2016, '2016-02-05 13:29:22', '2016-02-05 13:29:22'),
(248, 'vms_auto', 'vms_auto@vms.ie', '$2y$10$W8nXSNtUjNf5.6N9ptkwoOl9UrYnsC6u/qbW4RvdaugoYSANZO6jG', NULL, 'vms_auto', NULL, NULL, 4, 0, 1, 2016, '2017-05-10 12:16:00', '2017-05-10 12:16:00'),
(249, '', 'shadywallas9@gmail.com', '$2y$10$KgXZ4BMOvft5LTN0EGgSCevwGSrCs6NKOR6sC8UHRa1sujLGthJNi', NULL, 'shady', 'wallas', NULL, 5, 0, 1, 2016, '2016-02-07 12:38:36', '2016-02-07 12:38:36'),
(250, '', 'shadywallas10@gmail.com', '$2y$10$lQT/QFiNPDHFQcXZB1ybYOBjcYGMk2wtvfi5RPRZIkUhWoOjPrEnq', NULL, 'shady', 'wallas', NULL, 5, 0, 1, 2016, '2016-02-07 12:42:40', '2016-02-07 12:42:40'),
(251, '', 'shadywallas111@gmail.com', '$2y$10$efruEwwaCaQb4rAE0GNT/./DTcUi5MmAV0oW0NjnpZvoIq37XFshy', NULL, 'shady', 'wallas', NULL, 5, 0, 1, 2016, '2016-02-10 09:13:08', '2016-02-10 07:13:08'),
(252, 'shadywallas', 'raef_elsherbiny@yahoo.coms', '$2y$10$OiU8Ts.NJAD/ocpcH5w5Fu4LnZVhxYfNSqAlK/qCKffOL7uXQubOC', NULL, 'raef', 'elsherbiny', NULL, 5, 0, 1, 2016, '2016-03-24 10:32:17', '2016-03-24 08:32:17'),
(256, '', 'mohamedfz_1@hotmail.com', '$2y$10$uY7/2TKg/YMSJOq21akgFO1cplmvTW/dOkZfVOjtJBVpeSAkuVMt2', NULL, 'Mohamed', 'Fayez', NULL, 5, 0, 1, 2016, '2016-04-10 16:27:09', '2016-04-10 14:27:09'),
(257, '', 'justin.kavanagh@gmail.com', '$2y$10$KQmYzAZtU5h3JlIkznQLXO0z0wK88B3lEufga6QUv7q3e/4HhBZD2', NULL, 'VMS', 'TEST', NULL, 5, 0, 1, 2016, '2016-06-16 13:20:17', '2016-06-16 11:20:17'),
(261, '', 'mohamedfz_1@yahoo_old.com', '$2y$10$p5Lf097K0jW9hijW.uuw8OccYA.aWK8zUZSFdfFHRSDtZKV59YU3y', NULL, 'VMS', 'TEST', NULL, 5, 0, 1, 2016, '2017-08-01 16:25:05', '2016-06-16 11:40:55'),
(262, 'sherifa.mazhar@311-solutions.com', 'sherifa.mazhar@311-solutions.com', '$2y$10$d920O0WLdRcJtfpjDA2ciuVRUi.elsbV8vosGp8xZFem653WvWWxC', NULL, 'asdfs', 'fa', NULL, 5, 0, 1, 2017, '2017-06-21 15:32:11', '2017-06-21 13:32:11'),
(263, 'mahamadfayez', 'lavolpero@gmail.com_old', '$2y$10$hVbBCGOpkXILCR064gwDi.ecmf.xt.XFwASKe686OVjqY0t6SYPCm', NULL, 'Mahamad Fayez', NULL, 'vYOcFBnni6TweOMz9jIN8WbYQk9XLKUiqqfbHpvS3yb7Z6k9STn3G7guQVWv', 4, 0, 1, 2017, '2017-08-13 18:30:57', '2017-07-27 10:17:40'),
(264, 'mfayez_cc', 'lavolpero@gmail.com', '$2y$10$s13RGsvA38c0GRweCT47h.g8Uau7Y/rzv3c84I7fNPYxgvYhdjtia', NULL, 'Mohamed', 'Fayez', 'WixpQI3rSKJtx0ZZ0lJmBYXXLVvU6272hq0dnj1PLCNeGcikKmrgAUa76SsH', 4, 0, 1, 2017, '2018-01-04 11:19:37', '2018-01-04 09:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `make` varchar(40) NOT NULL,
  `model` varchar(40) NOT NULL,
  `version_type` varchar(40) DEFAULT NULL,
  `engine_size` decimal(4,0) DEFAULT NULL,
  `fuel_type` varchar(10) DEFAULT NULL,
  `transmission` varchar(10) DEFAULT NULL,
  `colour` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_accounts`
--
ALTER TABLE `agent_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added_by` (`added_by`) USING BTREE,
  ADD KEY `company_id` (`company_id`) USING BTREE,
  ADD KEY `user_type` (`user_type`) USING BTREE,
  ADD KEY `next_of_kin` (`next_of_kin`) USING BTREE;

--
-- Indexes for table `agent_activities`
--
ALTER TABLE `agent_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applegreen_codes`
--
ALTER TABLE `applegreen_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applegreen_membership_id` (`applegreen_code`) USING BTREE,
  ADD KEY `customer_id` (`customer_id`) USING BTREE;

--
-- Indexes for table `client_companies`
--
ALTER TABLE `client_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_accounts`
--
ALTER TABLE `company_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added_by` (`added_by`) USING BTREE,
  ADD KEY `main_poc` (`main_poc`) USING BTREE;

--
-- Indexes for table `company_payment_method`
--
ALTER TABLE `company_payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_card_info`
--
ALTER TABLE `credit_card_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `membership` (`membership`) USING BTREE,
  ADD KEY `added_by` (`added_by`) USING BTREE,
  ADD KEY `company_id` (`company_id`) USING BTREE,
  ADD KEY `car_id` (`vehicle_id`) USING BTREE,
  ADD KEY `vehicle_id` (`vehicle_id`) USING BTREE;

--
-- Indexes for table `customers_services`
--
ALTER TABLE `customers_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`) USING BTREE,
  ADD KEY `service_id` (`service_id`) USING BTREE,
  ADD KEY `customer_id_2` (`customer_id`) USING BTREE;

--
-- Indexes for table `customers_trial`
--
ALTER TABLE `customers_trial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_activities`
--
ALTER TABLE `customer_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fleets`
--
ALTER TABLE `fleets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fleet_members`
--
ALTER TABLE `fleet_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_account_types`
--
ALTER TABLE `login_account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_accounts`
--
ALTER TABLE `master_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`) USING BTREE;

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `non_member_services`
--
ALTER TABLE `non_member_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_name`) USING BTREE,
  ADD KEY `service_id` (`service_id`) USING BTREE,
  ADD KEY `customer_id_2` (`customer_name`) USING BTREE;

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `oc_order`
--
ALTER TABLE `oc_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `oc_order_history`
--
ALTER TABLE `oc_order_history`
  ADD PRIMARY KEY (`order_history_id`);

--
-- Indexes for table `oc_order_option`
--
ALTER TABLE `oc_order_option`
  ADD PRIMARY KEY (`order_option_id`);

--
-- Indexes for table `oc_order_product`
--
ALTER TABLE `oc_order_product`
  ADD PRIMARY KEY (`order_product_id`);

--
-- Indexes for table `oc_order_status`
--
ALTER TABLE `oc_order_status`
  ADD PRIMARY KEY (`order_status_id`,`language_id`);

--
-- Indexes for table `oc_order_total`
--
ALTER TABLE `oc_order_total`
  ADD PRIMARY KEY (`order_total_id`),
  ADD KEY `order_id` (`order_id`) USING BTREE;

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`) USING BTREE,
  ADD KEY `password_resets_token_index` (`token`) USING BTREE;

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persistences`
--
ALTER TABLE `persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`) USING BTREE;

--
-- Indexes for table `poc`
--
ALTER TABLE `poc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poc_to_company`
--
ALTER TABLE `poc_to_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotional_code`
--
ALTER TABLE `promotional_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`) USING BTREE;

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indexes for table `service_cc_comments`
--
ALTER TABLE `service_cc_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_quotes`
--
ALTER TABLE `service_quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_user_types`
--
ALTER TABLE `sub_user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`) USING BTREE;

--
-- Indexes for table `tolls`
--
ALTER TABLE `tolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`) USING BTREE,
  ADD KEY `account_type` (`account_type`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE,
  ADD KEY `status_2` (`status`) USING BTREE;

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activations`
--
ALTER TABLE `activations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `agent_accounts`
--
ALTER TABLE `agent_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `agent_activities`
--
ALTER TABLE `agent_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524;
--
-- AUTO_INCREMENT for table `applegreen_codes`
--
ALTER TABLE `applegreen_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10001;
--
-- AUTO_INCREMENT for table `client_companies`
--
ALTER TABLE `client_companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;
--
-- AUTO_INCREMENT for table `company_accounts`
--
ALTER TABLE `company_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `company_payment_method`
--
ALTER TABLE `company_payment_method`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `credit_card_info`
--
ALTER TABLE `credit_card_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;
--
-- AUTO_INCREMENT for table `customers_services`
--
ALTER TABLE `customers_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `customers_trial`
--
ALTER TABLE `customers_trial`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_activities`
--
ALTER TABLE `customer_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fleets`
--
ALTER TABLE `fleets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `fleet_members`
--
ALTER TABLE `fleet_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `login_account_types`
--
ALTER TABLE `login_account_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `master_accounts`
--
ALTER TABLE `master_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `non_member_services`
--
ALTER TABLE `non_member_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;
--
-- AUTO_INCREMENT for table `oc_order`
--
ALTER TABLE `oc_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `oc_order_history`
--
ALTER TABLE `oc_order_history`
  MODIFY `order_history_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oc_order_option`
--
ALTER TABLE `oc_order_option`
  MODIFY `order_option_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oc_order_product`
--
ALTER TABLE `oc_order_product`
  MODIFY `order_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `oc_order_status`
--
ALTER TABLE `oc_order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `oc_order_total`
--
ALTER TABLE `oc_order_total`
  MODIFY `order_total_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `persistences`
--
ALTER TABLE `persistences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=499;
--
-- AUTO_INCREMENT for table `poc`
--
ALTER TABLE `poc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `poc_to_company`
--
ALTER TABLE `poc_to_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `promotional_code`
--
ALTER TABLE `promotional_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `service_cc_comments`
--
ALTER TABLE `service_cc_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `service_quotes`
--
ALTER TABLE `service_quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sub_user_types`
--
ALTER TABLE `sub_user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tolls`
--
ALTER TABLE `tolls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent_accounts`
--
ALTER TABLE `agent_accounts`
  ADD CONSTRAINT `agent_accounts_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `agent_accounts_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company_accounts` (`id`),
  ADD CONSTRAINT `agent_accounts_ibfk_3` FOREIGN KEY (`next_of_kin`) REFERENCES `next_of_kin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `agent_accounts_ibfk_4` FOREIGN KEY (`user_type`) REFERENCES `sub_user_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `applegreen_codes`
--
ALTER TABLE `applegreen_codes`
  ADD CONSTRAINT `applegreen_codes_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `company_accounts`
--
ALTER TABLE `company_accounts`
  ADD CONSTRAINT `company_accounts_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `company_accounts_ibfk_2` FOREIGN KEY (`main_poc`) REFERENCES `poc` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`membership`) REFERENCES `memberships` (`id`),
  ADD CONSTRAINT `customers_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customers_ibfk_3` FOREIGN KEY (`company_id`) REFERENCES `company_accounts` (`id`),
  ADD CONSTRAINT `customers_ibfk_4` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customers_services`
--
ALTER TABLE `customers_services`
  ADD CONSTRAINT `customers_services_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customers_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service_types` (`id`);

--
-- Constraints for table `master_accounts`
--
ALTER TABLE `master_accounts`
  ADD CONSTRAINT `master_accounts_ibfk_1` FOREIGN KEY (`department`) REFERENCES `departments` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
