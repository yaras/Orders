CREATE TABLE `users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(300) NULL DEFAULT '0',
	`password` VARCHAR(300) NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `orders` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(50) NOT NULL,
	`author_user_id` INT NOT NULL,
	`created` DATETIME NOT NULL,
	`order_time` VARCHAR(50) NOT NULL,
	`description` VARCHAR(50) NULL DEFAULT NULL,
	`archived` TINYINT NULL DEFAULT '0',
	`status` VARCHAR(50) NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `messages` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`order_id` INT(11) NOT NULL DEFAULT '0',
	`author_user_id` INT NOT NULL DEFAULT '0',
	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`message` VARCHAR(10000) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `positions` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`order_id` INT NOT NULL,
	`meal` VARCHAR(4000) NOT NULL,
	`cost` FLOAT NOT NULL,
	`paid` TINYINT NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `notifications` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`user_id` INT NOT NULL,
	`order_id` INT NULL,
	`title` VARCHAR(200) NOT NULL,
	`message` VARCHAR(4000) NOT NULL,
	`reload_order` TINYINT NOT NULL DEFAULT '0',
	`reload_orders` TINYINT(4) NOT NULL DEFAULT '0',
	`downloaded` TINYINT(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);
