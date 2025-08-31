-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 10:00 AM
-- Server version: 10.11.6-MariaDB
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news-site`
--
CREATE DATABASE IF NOT EXISTS `news-site` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `news-site`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--
CREATE TABLE `category` (
  `category_id` INT(11) NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(100) NOT NULL,
  `post_count` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--
CREATE TABLE `user` (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(30) NOT NULL,
  `last_name` VARCHAR(30) NOT NULL,
  `username` VARCHAR(30) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','editor','author','subscriber') NOT NULL DEFAULT 'author',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--
CREATE TABLE `post` (
  `post_id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `category_id` INT(11) NOT NULL,
  `post_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` INT(11) UNSIGNED NOT NULL,
  `post_img` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  FOREIGN KEY (`category_id`) REFERENCES `category`(`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`author_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;