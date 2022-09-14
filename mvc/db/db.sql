-- phpMyAdmin SQL Dump
-- version 5.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS cmsdb;

CREATE DATABASE cmsdb CHARACTER SET utf8 COLLATE utf8_general_ci;

use cmsdb;


CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `tag` varchar(255) NULL  
) auto_increment=0,
  ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) auto_increment=0,
  ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `file_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NULL,
  `body` text NULL,
  `file` longblob NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL 
) auto_increment=0,
  ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) auto_increment=0,
  ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Jeandrei', 'jeandreiwalter@gmail.com', '$2y$10$lyyCqzV/cJw5A8TpddC47Ow8K2iVHOHbKl.Nzs0fm/CgjuDBRZoMq', '2018-11-23 10:19:18'),
(2, 'teste1', 'teste1r@gmail.com', '$2y$10$Y3Phy8lW7ACZ41qrXjqOjuS26Jzj5WEoWa3mjNrNwWcHpyPKnOtji', '2018-11-27 15:29:36'),
(3, 'teste', 'jean.walter@penha.sc.gov.br', '$2y$10$EwxO3Gf78AQdSoVhVf6yxefdZFR2n3ON2w.t9XnyXsZPLJTNXfTGi', '2019-01-09 16:46:20'),
(4, 'jeandrei', 'jeandreiwalter@educapenha.com.br', '$2y$10$RczfzoEUQTT69IMzK6BxYO9nlzd/r.BP7e1JyUaPNV0Hjva1c2ZOq', '2020-06-21 19:13:23');


INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `created_at`) VALUES
(2, 1, 'Post Two', 'This is a test for post two', '2018-11-27 20:01:26');
