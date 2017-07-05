dminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `app` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `app`;

DROP TABLE IF EXISTS `exercise`;
CREATE TABLE `exercise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exerciceName` varchar(255) NOT NULL,
  `amountSets` int(11) NOT NULL DEFAULT '3',
  `amountReps` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `exercise` (`id`, `exerciceName`, `amountSets`, `amountReps`) VALUES
(1,	'Flat Benchpress',	3,	10),
(2,	'Incline Benchpress',	3,	10),
(3,	'Cable Flyes',	3,	12),
(4,	'Lat Pulldown',	3,	10),
(5,	'Seated Cable Rows',	3,	10),
(6,	'Reversed Cable Flyes',	3,	10),
(7,	'Tricep Pushdown',	3,	10),
(8,	'Tricep Kickback',	3,	10),
(9,	'Ez-Bar Curl',	3,	10),
(10,	'Hammer Curls',	3,	10),
(11,	'Leg Press',	3,	10),
(12,	'Squats',	3,	10),
(13,	'Leg Extension',	3,	10),
(14,	'Leg Curls',	3,	10),
(15,	'Hip Thrusts',	3,	10),
(16,	'Crunches',	3,	10),
(17,	'Deadlifts',	3,	8);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activated` int(1) NOT NULL,
  `activationstring` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `email`, `password`, `activated`, `activationstring`) VALUES
(5,	'rothert.jerome@gmail.com',	'$2y$10$HjhrGWve/a9KJWta8.uRsuqkWSiKk0MXEsil1q49pf8vVrc7T0hX2',	1,	'295f9e47fa3064be3187c0119434ac75');

DROP TABLE IF EXISTS `userWorkout`;
CREATE TABLE `userWorkout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `workoutId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `workoutId` (`workoutId`),
  CONSTRAINT `userWorkout_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `userWorkout_ibfk_2` FOREIGN KEY (`workoutId`) REFERENCES `workout` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `workout`;
CREATE TABLE `workout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workoutName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workout` (`id`, `workoutName`) VALUES
(1,	'Chest/Tri Day'),
(2,	'Back/Bi Day'),
(3,	'Leg Day');

DROP TABLE IF EXISTS `workoutExercise`;
CREATE TABLE `workoutExercise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workoutId` int(11) NOT NULL,
  `exerciseId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `workoutId` (`workoutId`),
  KEY `exerciseId` (`exerciseId`),
  CONSTRAINT `workoutExercise_ibfk_1` FOREIGN KEY (`workoutId`) REFERENCES `workout` (`id`),
  CONSTRAINT `workoutExercise_ibfk_2` FOREIGN KEY (`exerciseId`) REFERENCES `exercise` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workoutExercise` (`id`, `workoutId`, `exerciseId`) VALUES
(1,	1,	1),
(2,	1,	2),
(3,	1,	3),
(4,	1,	7),
(5,	1,	8),
(6,	2,	4),
(7,	2,	5),
(8,	2,	6),
(9,	2,	9),
(10,	2,	10),
(11,	3,	11),
(12,	3,	12),
(13,	3,	13),
(14,	3,	14),
(15,	3,	15),
(16,	3,	16);

-- 2017-07-05 06:00:39
