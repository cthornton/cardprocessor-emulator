DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `number` char(15) NOT NULL,
  `expiration` date NOT NULL,
  `balance` decimal(14,2) NOT NULL,
  `created_at` datetime,
  `updated_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `persons`;
CREATE TABLE `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `address_2` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zipcode` char(5) DEFAULT NULL,
  `ssn` char(10) DEFAULT NULL,
  `phone` char(10) DEFAULT NULL,
  `created_at` datetime,
  `updated_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime,
  `updated_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(45) NOT NULL,
  `created_at` datetime,
  `updated_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;