CREATE DATABASE catalogue;

use catalogue;

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `slug` varchar(50) NOT NULL ,
  `name` varchar(50) NOT NULL ,
  `description` text NOT NULL,
  `price` float NOT NULL ,
  `quantity` float,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65;

CREATE TABLE `users` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` varchar(100),
  `name` varchar(100),
  `price` float,
  `quantity` float
);

