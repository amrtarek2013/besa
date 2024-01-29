ALTER TABLE
    `universities`
ADD
    `show_on_top_universities` TINYINT(1) NOT NULL DEFAULT '0'
AFTER
    `show_on_destination`;

ALTER TABLE
    `fair_events`
ADD
    `day_date` VARCHAR(30) NULL
AFTER
    `universities`,
ADD
    `schools` VARCHAR(255) NULL
AFTER
    `day_date`;

ALTER TABLE
    `wishlists`
ADD
    `university_id` INT NULL
AFTER
    `university_course_id`;

ALTER TABLE
    `university_courses`
ADD
    `duration_type` TINYINT(1) NULL DEFAULT '0'
AFTER
    `duration`;

ALTER TABLE
    `users`
ADD
    `completed_step` INT NULL DEFAULT NULL
AFTER
    `bd`,
ADD
    `preferred_countries` VARCHAR(100) NULL DEFAULT NULL
AFTER
    `completed_step`,
ADD
    `preferred_year` INT NULL
AFTER
    `preferred_countries`,
ADD
    `preferred_month` INT NULL
AFTER
    `preferred_year`,
ADD
    `min_budget` DECIMAL(10, 2) NULL DEFAULT '0.00'
AFTER
    `preferred_month`,
ADD
    `max_budget` DECIMAL(10, 2) NULL DEFAULT '0.00'
AFTER
    `min_budget`;

ALTER TABLE
    `subject_areas`
ADD
    `rank` INT(10) NULL
AFTER
    `is_old`,
ADD
    `apply_rank` INT(10) NULL
AFTER
    `rank`;

CREATE TABLE `university_subjects` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `subject_area_id` INT NOT NULL,
    `university_id` INT NOT NULL,
    `apply_rank` INT NOT NULL,
    `rank` INT NOT NULL,
    `use_rank` TINYINT(1) NOT NULL DEFAULT '0',
    `active` TINYINT(1) NOT NULL,
    `display_order` INT NOT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO
    `permissions` (
        `title`,
        `title_ar`,
        `controller`,
        `action`,
        `permission_group`,
        `created`,
        `modified`
    )
VALUES
    (
        'Edit UniversitySubject',
        NULL,
        'UniversitySubjects',
        'edit',
        'UniversitySubjects',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    ),
    (
        'Add UniversitySubject',
        NULL,
        'UniversitySubjects',
        'add',
        'UniversitySubjects',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    ),
    (
        'Delete UniversitySubject',
        NULL,
        'UniversitySubjects',
        'delete',
        'UniversitySubjects',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    ),
    (
        'List UniversitySubjects',
        NULL,
        'UniversitySubjects',
        'index',
        'UniversitySubjects',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    ),
    (
        'Delete Multi UniversitySubjects',
        NULL,
        'UniversitySubjects',
        'multi_delete',
        'UniversitySubjects',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    );

ALTER TABLE
    `users`
ADD
    `subject_area_ids` VARCHAR(100) NULL
AFTER
    `subject_area_id`;

ALTER TABLE
    `universities`
ADD
    `facilities_title` VARCHAR(150) NULL DEFAULT 'Facilities'
AFTER
    `is_partner`,
ADD
    `facilities_tab1_title` VARCHAR(150) NULL DEFAULT 'Over View'
AFTER
    `facilities_title`,
ADD
    `facilities_tab1_content` TEXT NULL
AFTER
    `facilities_tab1_title`,
ADD
    `facilities_tab2_title` VARCHAR(100) NULL DEFAULT 'Accommodation'
AFTER
    `facilities_tab1_content`,
ADD
    `facilities_tab2_content` TEXT NULL
AFTER
    `facilities_tab2_title`,
ADD
    `facilities_tab3_title` VARCHAR(150) NULL DEFAULT 'Campus Life'
AFTER
    `facilities_tab2_content`,
ADD
    `facilities_tab3_content` TEXT NULL
AFTER
    `facilities_tab3_title`,
ADD
    `show_facilities_section` TINYINT(1) NULL DEFAULT '0'
AFTER
    `facilities_tab3_content`,
ADD
    `city_life_title` VARCHAR(150) NULL DEFAULT 'City Life'
AFTER
    `show_facilities_section`,
ADD
    `show_city_life_section` TINYINT(1) NULL DEFAULT '0'
AFTER
    `city_life_title`,
ADD
    `city_life_section_content` TEXT NULL
AFTER
    `show_city_life_section`,
ADD
    `show_gallary_section` TINYINT(1) NULL DEFAULT '0'
AFTER
    `city_life_section_content`,
ADD
    `gallary_section_title` VARCHAR(150) NULL DEFAULT 'Gallary'
AFTER
    `show_gallary_section`;

INSERT INTO
    `permissions` (
        `title`,
        `title_ar`,
        `controller`,
        `action`,
        `permission_group`,
        `created`,
        `modified`
    )
VALUES
    (
        'Edit UniversityImage',
        NULL,
        'UniversityImages',
        'edit',
        'UniversityImages',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    ),
    (
        'Add UniversityImage',
        NULL,
        'UniversityImages',
        'add',
        'UniversityImages',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    ),
    (
        'Delete UniversityImage',
        NULL,
        'UniversityImages',
        'delete',
        'UniversityImages',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    ),
    (
        'List UniversityImages',
        NULL,
        'UniversityImages',
        'index',
        'UniversityImages',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    ),
    (
        'Delete Multi UniversityImages',
        NULL,
        'UniversityImages',
        'multi_delete',
        'UniversityImages',
        '0000-00-00 00:00:00',
        '0000-00-00 00:00:00'
    );