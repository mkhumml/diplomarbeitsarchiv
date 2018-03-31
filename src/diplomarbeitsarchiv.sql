-- MySQL Script generated by MySQL Workbench
-- 03/29/18 02:19:21
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering


SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema diplomarbeitsarchiv
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema diplomarbeitsarchiv
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `diplomarbeitsarchiv` DEFAULT CHARACTER SET utf8 ;
USE `diplomarbeitsarchiv` ;

-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`diploma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`diploma` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(256) NULL,
  `summary` TEXT NULL,
  `notes` TEXT NULL,
  `diplomathesis` VARCHAR(4096) NULL,
  `year` VARCHAR(255) NULL,
  `org_name` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`attachments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`attachments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(4096) NULL,
  `diploma_id` INT NOT NULL,
  `org_name` VARCHAR(255) NULL,
  PRIMARY KEY (`id`, `diploma_id`),
  INDEX `fk_attachments_diploma1_idx` (`diploma_id` ASC),
  CONSTRAINT `fk_attachments_diploma1`
    FOREIGN KEY (`diploma_id`)
    REFERENCES `diplomarbeitsarchiv`.`diploma` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`authors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`authors` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`deparments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`deparments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`tags` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`tutors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`tutors` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(256) NULL,
  `password` VARCHAR(129) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`tutors_has_diploma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`tutors_has_diploma` (
  `tutors_id` INT NOT NULL,
  `diploma_id` INT NOT NULL,
  PRIMARY KEY (`tutors_id`, `diploma_id`),
  INDEX `fk_tutors_has_diploma_diploma1_idx` (`diploma_id` ASC),
  INDEX `fk_tutors_has_diploma_tutors_idx` (`tutors_id` ASC),
  CONSTRAINT `fk_tutors_has_diploma_tutors`
    FOREIGN KEY (`tutors_id`)
    REFERENCES `diplomarbeitsarchiv`.`tutors` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tutors_has_diploma_diploma1`
    FOREIGN KEY (`diploma_id`)
    REFERENCES `diplomarbeitsarchiv`.`diploma` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`diploma_has_tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`diploma_has_tags` (
  `diploma_id` INT NOT NULL,
  `tags_id` INT NOT NULL,
  PRIMARY KEY (`diploma_id`, `tags_id`),
  INDEX `fk_diploma_has_tags_tags1_idx` (`tags_id` ASC),
  INDEX `fk_diploma_has_tags_diploma1_idx` (`diploma_id` ASC),
  CONSTRAINT `fk_diploma_has_tags_diploma1`
    FOREIGN KEY (`diploma_id`)
    REFERENCES `diplomarbeitsarchiv`.`diploma` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_diploma_has_tags_tags1`
    FOREIGN KEY (`tags_id`)
    REFERENCES `diplomarbeitsarchiv`.`tags` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`attachments_has_diploma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`attachments_has_diploma` (
  `attachments_id` INT NOT NULL,
  `diploma_id` INT NOT NULL,
  PRIMARY KEY (`attachments_id`, `diploma_id`),
  INDEX `fk_attachments_has_diploma_diploma1_idx` (`diploma_id` ASC),
  INDEX `fk_attachments_has_diploma_attachments1_idx` (`attachments_id` ASC),
  CONSTRAINT `fk_attachments_has_diploma_attachments1`
    FOREIGN KEY (`attachments_id`)
    REFERENCES `diplomarbeitsarchiv`.`attachments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attachments_has_diploma_diploma1`
    FOREIGN KEY (`diploma_id`)
    REFERENCES `diplomarbeitsarchiv`.`diploma` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`diploma_has_deparments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`diploma_has_deparments` (
  `diploma_id` INT NOT NULL,
  `deparments_id` INT NOT NULL,
  PRIMARY KEY (`diploma_id`, `deparments_id`),
  INDEX `fk_diploma_has_deparments_deparments1_idx` (`deparments_id` ASC),
  INDEX `fk_diploma_has_deparments_diploma1_idx` (`diploma_id` ASC),
  CONSTRAINT `fk_diploma_has_deparments_diploma1`
    FOREIGN KEY (`diploma_id`)
    REFERENCES `diplomarbeitsarchiv`.`diploma` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_diploma_has_deparments_deparments1`
    FOREIGN KEY (`deparments_id`)
    REFERENCES `diplomarbeitsarchiv`.`deparments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diplomarbeitsarchiv`.`authors_has_diploma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `diplomarbeitsarchiv`.`authors_has_diploma` (
  `authors_id` INT NOT NULL,
  `diploma_id` INT NOT NULL,
  PRIMARY KEY (`authors_id`, `diploma_id`),
  INDEX `fk_authors_has_diploma_diploma1_idx` (`diploma_id` ASC),
  INDEX `fk_authors_has_diploma_authors1_idx` (`authors_id` ASC),
  CONSTRAINT `fk_authors_has_diploma_authors1`
    FOREIGN KEY (`authors_id`)
    REFERENCES `diplomarbeitsarchiv`.`authors` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_authors_has_diploma_diploma1`
    FOREIGN KEY (`diploma_id`)
    REFERENCES `diplomarbeitsarchiv`.`diploma` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
