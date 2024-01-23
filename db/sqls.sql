ALTER TABLE `universities` ADD `show_on_top_universities` TINYINT(1) NOT NULL DEFAULT '0' AFTER `show_on_destination`;


ALTER TABLE `fair_events` ADD `day_date` VARCHAR(30) NULL AFTER `universities`, ADD `schools` VARCHAR(255) NULL AFTER `day_date`;

ALTER TABLE `wishlists` ADD `university_id` INT NULL AFTER `university_course_id`;

ALTER TABLE `university_courses` ADD `duration_type` TINYINT(1) NULL DEFAULT '0' AFTER `duration`; 