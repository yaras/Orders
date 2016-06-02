ALTER TABLE `notifications`
	ALTER `title` DROP DEFAULT,
	ALTER `message` DROP DEFAULT;

ALTER TABLE `notifications`
	CHANGE COLUMN `title` `title` VARCHAR(200) NULL AFTER `order_id`,
	CHANGE COLUMN `message` `message` VARCHAR(4000) NULL AFTER `title`,
	ADD COLUMN `silent` TINYINT(4) NOT NULL DEFAULT '0' AFTER `downloaded`;
