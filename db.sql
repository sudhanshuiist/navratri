CREATE TABLE `contest_entry`(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255),
    `email` VARCHAR(255),
    `phone` VARCHAR(13),
    `uploadkey` VARCHAR(255),
    `video` VARCHAR(1000),
    `status` VARCHAR(20) DEFAULT "pending",
    `score` FLOAT(3,2) DEFAULT '0.00'
);