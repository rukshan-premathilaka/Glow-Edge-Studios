-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE =
        'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema glow_edge_studios
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema glow_edge_studios
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `glow_edge_studios` DEFAULT CHARACTER SET utf8mb3;
USE `glow_edge_studios`;

-- -----------------------------------------------------
-- Table `glow_edge_studios`.`portfolio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `glow_edge_studios`.`portfolio`
(
    `portfolio_id` INT          NOT NULL AUTO_INCREMENT,
    `title`        VARCHAR(255) NULL DEFAULT NULL,
    `description`  TEXT         NULL DEFAULT NULL,
    `image`        INT          NULL,
    PRIMARY KEY (`portfolio_id`),
    UNIQUE INDEX `image_UNIQUE` (`image` ASC) VISIBLE
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `glow_edge_studios`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `glow_edge_studios`.`role`
(
    `role_id` INT         NOT NULL AUTO_INCREMENT,
    `role`    VARCHAR(45) NOT NULL,
    PRIMARY KEY (`role_id`)
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 5
    DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `glow_edge_studios`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `glow_edge_studios`.`user`
(
    `user_id`  INT          NOT NULL AUTO_INCREMENT,
    `name`     VARCHAR(255) NOT NULL,
    `email`    VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`user_id`),
    UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 30
    DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `glow_edge_studios`.`user_has_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `glow_edge_studios`.`user_has_role`
(
    `user_user_id` INT NOT NULL,
    `role_role_id` INT NOT NULL,
    PRIMARY KEY (`user_user_id`, `role_role_id`),
    INDEX `fk_user_has_role_role1_idx` (`role_role_id` ASC) VISIBLE,
    INDEX `fk_user_has_role_user_idx` (`user_user_id` ASC) VISIBLE,
    CONSTRAINT `fk_user_has_role_role1`
        FOREIGN KEY (`role_role_id`)
            REFERENCES `glow_edge_studios`.`role` (`role_id`),
    CONSTRAINT `fk_user_has_role_user`
        FOREIGN KEY (`user_user_id`)
            REFERENCES `glow_edge_studios`.`user` (`user_id`)
            ON DELETE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `glow_edge_studios`.`user_has_portfolio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `glow_edge_studios`.`user_has_portfolio`
(
    `user_user_id`           INT NOT NULL,
    `portfolio_portfolio_id` INT NOT NULL,
    PRIMARY KEY (`user_user_id`, `portfolio_portfolio_id`),
    INDEX `fk_user_has_portfolio_portfolio1_idx` (`portfolio_portfolio_id` ASC) VISIBLE,
    INDEX `fk_user_has_portfolio_user1_idx` (`user_user_id` ASC) VISIBLE,
    CONSTRAINT `fk_user_has_portfolio_user1`
        FOREIGN KEY (`user_user_id`)
            REFERENCES `glow_edge_studios`.`user` (`user_id`)
            ON DELETE CASCADE
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_has_portfolio_portfolio1`
        FOREIGN KEY (`portfolio_portfolio_id`)
            REFERENCES `glow_edge_studios`.`portfolio` (`portfolio_id`)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
