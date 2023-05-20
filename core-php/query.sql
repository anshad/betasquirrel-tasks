CREATE TABLE `students` (
    `id` int NOT NULL AUTO_INCREMENT,
    `first_name` varchar(255) NOT NULL,
    `last_name` varchar(255) NOT NULL,
    `mobile` varchar(20) NOT NULL,
    `email` varchar(255) NOT NULL,
    `branch` enum('Computer Science', 'Electronics', 'Mechanical') NOT NULL DEFAULT 'Computer Science',
    `is_hostel_opted` tinyint(1) DEFAULT '0',
    `additional_subjects` json DEFAULT NULL,
    `address` text NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
);