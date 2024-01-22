ALTER TABLE `universities` ADD `show_on_top_universities` TINYINT(1) NOT NULL DEFAULT '0' AFTER `show_on_destination`;


ALTER TABLE `fair_events` ADD `day_date` VARCHAR(30) NULL AFTER `universities`, ADD `schools` VARCHAR(255) NULL AFTER `day_date`;