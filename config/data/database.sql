CREATE DATABASE catalogue;

use catalogue;

CREATE TABLE `products` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` varchar(100),
  `name` varchar(100),
  `price` float,
  `quantity` float
);

CREATE TABLE `users` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` varchar(100),
  `name` varchar(100),
  `price` float,
  `quantity` float
);

