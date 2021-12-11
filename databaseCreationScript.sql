-- -----------------------------------------------------
-- Schema otptask
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `otptask` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `otptask` ;

-- -----------------------------------------------------
-- Table `otptask`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `otptask`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NULL DEFAULT NULL,
    `password` VARCHAR(512) NULL DEFAULT NULL,
    `validated` TINYINT(1) NULL DEFAULT NULL,
    `phone` VARCHAR(255) NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    AUTO_INCREMENT = 31
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `otptask`.`users_verification_codes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `otptask`.`users_verification_codes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NULL DEFAULT NULL,
    `verification_code` VARCHAR(10) NULL DEFAULT NULL,
    `creation_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `active` TINYINT NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id_fk_idx` (`user_id` ASC) VISIBLE,
    CONSTRAINT `user_id_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `otptask`.`users` (`id`))
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `otptask`.`users_verification_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `otptask`.`users_verification_log` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NULL DEFAULT NULL,
    `datetime` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `user_id_log_fk_idx` (`user_id` ASC) VISIBLE,
    CONSTRAINT `user_id_log_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `otptask`.`users` (`id`))
    ENGINE = InnoDB
    AUTO_INCREMENT = 3
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci;