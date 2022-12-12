-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema appDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema appDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `appDB` DEFAULT CHARACTER SET utf8 ;
USE `appDB` ;

-- -----------------------------------------------------
-- Table `appDB`.`Skins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `appDB`.`Skins` (
  `id_skin` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_skin` VARCHAR(45) NOT NULL,
  `conditionType_skin` ENUM('wins', 'loses', 'percentage') NOT NULL,
  `conditionNumber_skin` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_skin`),
  UNIQUE INDEX `id_skin_UNIQUE` (`id_skin` ASC) VISIBLE,
  UNIQUE INDEX `name_skin_UNIQUE` (`name_skin` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO Skins (name_skin, conditionType_skin, conditionNumber_skin)
VALUES ("default", 'wins', 0),
	   ("rainbow", 'loses', 1),
	   ("golden", 'wins', 1),
	   ("coin", 'percentage', 50);

-- -----------------------------------------------------
-- Table `appDB`.`Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `appDB`.`Users` (
  `id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_user` VARCHAR(45) NOT NULL,
  `pass_user` VARCHAR(45) NOT NULL,
  `id_skin` INT UNSIGNED NOT NULL DEFAULT 1,
  `wins_user` INT UNSIGNED NOT NULL DEFAULT 0,
  `loses_user` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `id_user_UNIQUE` (`id_user` ASC) VISIBLE,
  UNIQUE INDEX `name_user_UNIQUE` (`name_user` ASC) VISIBLE,
  INDEX `fk_Users_Skins_idx` (`id_skin` ASC) VISIBLE,
  CONSTRAINT `fk_Users_Skins`
    FOREIGN KEY (`id_skin`)
    REFERENCES `appDB`.`Skins` (`id_skin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `appDB`.`Games`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `appDB`.`Games` (
  `id_game` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_game` VARCHAR(45) NOT NULL,
  `pass_game` VARCHAR(45) NOT NULL,
  `turnTime_game` INT UNSIGNED NOT NULL,
  `width_game` INT UNSIGNED NOT NULL,
  `height_game` INT UNSIGNED NOT NULL,
  `length_game` INT UNSIGNED NOT NULL,
  `namePlayerOne_user` VARCHAR(45),
  `namePlayerTwo_user` VARCHAR(45),
  `nameWinner_user` VARCHAR(45),
  `isPlayerOneTurn_game` TINYINT(1) UNSIGNED NOT NULL,
  `state_game` VARCHAR(100),
  `endTime_game` DATETIME,
  PRIMARY KEY (`id_game`),
  UNIQUE INDEX `id_game_UNIQUE` (`id_game` ASC) VISIBLE,
  UNIQUE INDEX `name_game_UNIQUE` (`name_game` ASC) VISIBLE)
ENGINE = InnoDB;

CREATE TRIGGER before_insert_app_games
  BEFORE INSERT ON `appDB`.`Games` 
  FOR EACH ROW
  SET new.isPlayerOneTurn_game = ROUND(RAND(), 0);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
