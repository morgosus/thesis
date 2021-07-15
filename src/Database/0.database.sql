-- MySQL Script generated by MySQL Workbench
-- Mon Mar 15 01:30:56 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema revision-actual
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema revision-actual
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `revision-actual` DEFAULT CHARACTER SET utf8 ;
USE `revision-actual` ;

-- -----------------------------------------------------
-- Table `revision-actual`.`language`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`language` (
  `code` CHAR(5) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`code`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`user` (
  `id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(16) NOT NULL,
  `hash` CHAR(60) NOT NULL,
  `creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `id_user_UNIQUE` (`id_user` ASC),
  UNIQUE INDEX `hash_UNIQUE` (`hash` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`audio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`audio` (
  `path` VARCHAR(50) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `language_code` CHAR(5) NOT NULL,
  PRIMARY KEY (`path`),
  UNIQUE INDEX `path_UNIQUE` (`path` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  INDEX `FK_audio_language_idx` (`language_code` ASC),
  CONSTRAINT `FK_audio_language`
    FOREIGN KEY (`language_code`)
    REFERENCES `revision-actual`.`language` (`code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`image` (
  `id_image` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `alt` VARCHAR(125) NOT NULL,
  `path` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_image`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `path_UNIQUE` (`path` ASC),
  UNIQUE INDEX `id_image_UNIQUE` (`id_image` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`topic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`topic` (
  `id_topic` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `langcode` CHAR(5) NOT NULL,
  `parent` INT UNSIGNED NULL,
  `title` VARCHAR(50) NOT NULL,
  `link` VARCHAR(50) NOT NULL,
  `creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `public` BIT(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id_topic`, `langcode`),
  UNIQUE INDEX `id_topic_UNIQUE` (`id_topic` ASC),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC),
  INDEX `FK_topic_topic_idx` (`parent` ASC),
  UNIQUE INDEX `link_UNIQUE` (`link` ASC),
  INDEX `FK_topic_language1_idx` (`langcode` ASC),
  CONSTRAINT `FK_topic_topic`
    FOREIGN KEY (`parent`)
    REFERENCES `revision-actual`.`topic` (`id_topic`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `FK_topic_language1`
    FOREIGN KEY (`langcode`)
    REFERENCES `revision-actual`.`language` (`code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`article` (
  `id_article` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `langcode` CHAR(5) NOT NULL,
  `id_image` INT UNSIGNED NOT NULL,
  `link` VARCHAR(50) NOT NULL,
  `content` TEXT NOT NULL,
  `audiopath` VARCHAR(50) NULL,
  `digest` VARCHAR(100) NOT NULL,
  `keywords` VARCHAR(150) NULL,
  `id_writer` INT UNSIGNED NOT NULL,
  `creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `public` BIT(1) NULL DEFAULT b'0',
  `featured` BIT(1) NULL DEFAULT b'0',
  `wordcount` SMALLINT UNSIGNED NULL DEFAULT 0,
  `id_topic` INT UNSIGNED NOT NULL,
  `next` INT UNSIGNED NULL,
  PRIMARY KEY (`id_article`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC),
  UNIQUE INDEX `id_article_UNIQUE` (`id_article` ASC),
  UNIQUE INDEX `link_UNIQUE` (`link` ASC),
  UNIQUE INDEX `content_UNIQUE` (`content` ASC),
  INDEX `FK_article_language_idx` (`langcode` ASC),
  INDEX `FK_article_user_idx` (`id_writer` ASC),
  INDEX `FK_article_audio_idx` (`audiopath` ASC),
  INDEX `FK_article_image_idx` (`id_image` ASC),
  INDEX `FK_article_article_idx` (`next` ASC),
  INDEX `FK_article_topic_idx` (`id_topic` ASC),
  CONSTRAINT `FK_article_language`
    FOREIGN KEY (`langcode`)
    REFERENCES `revision-actual`.`language` (`code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_article_user`
    FOREIGN KEY (`id_writer`)
    REFERENCES `revision-actual`.`user` (`id_user`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_article_audio`
    FOREIGN KEY (`audiopath`)
    REFERENCES `revision-actual`.`audio` (`path`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `FK_article_image`
    FOREIGN KEY (`id_image`)
    REFERENCES `revision-actual`.`image` (`id_image`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_article_article`
    FOREIGN KEY (`next`)
    REFERENCES `revision-actual`.`article` (`id_article`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_article_topic`
    FOREIGN KEY (`id_topic`)
    REFERENCES `revision-actual`.`topic` (`id_topic`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`role` (
  `id_role` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id_role`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `id_role_UNIQUE` (`id_role` ASC),
  UNIQUE INDEX `description_UNIQUE` (`description` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`audio_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`audio_user` (
  `path` VARCHAR(50) NOT NULL,
  `id_user` INT UNSIGNED NOT NULL,
  `id_role` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`path`, `id_user`),
  INDEX `FK_audio_user_user_idx` (`id_user` ASC),
  INDEX `FK_audio_user_audio_idx` (`path` ASC),
  INDEX `FK_audio_user_role_idx` (`id_role` ASC),
  CONSTRAINT `FK_audio_user_audio`
    FOREIGN KEY (`path`)
    REFERENCES `revision-actual`.`audio` (`path`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_audio_user_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `revision-actual`.`user` (`id_user`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_audio_user_role`
    FOREIGN KEY (`id_role`)
    REFERENCES `revision-actual`.`role` (`id_role`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`serialized`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`serialized` (
  `id_serialized` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `data` TEXT NOT NULL,
  `code` CHAR(5) NOT NULL,
  PRIMARY KEY (`id_serialized`),
  INDEX `FK_serialized_language_idx` (`code` ASC),
  UNIQUE INDEX `id_serialized_UNIQUE` (`id_serialized` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `data_UNIQUE` (`data` ASC),
  CONSTRAINT `FK_serialized_language`
    FOREIGN KEY (`code`)
    REFERENCES `revision-actual`.`language` (`code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `revision-actual`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revision-actual`.`comment` (
  `id_comment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent` INT UNSIGNED NOT NULL,
  `name` VARCHAR(16) NOT NULL,
  `content` VARCHAR(255) NOT NULL,
  `creation` TIMESTAMP NOT NULL,
  `approved` TINYINT(1) NOT NULL DEFAULT 0,
  `id_article` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_comment`, `id_article`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `creation_UNIQUE` (`creation` ASC),
  INDEX `FK_comment_comment1_idx` (`parent` ASC),
  UNIQUE INDEX `id_comment_UNIQUE` (`id_comment` ASC),
  INDEX `FK_comment_article1_idx` (`id_article` ASC),
  CONSTRAINT `FK_comment_comment1`
    FOREIGN KEY (`parent`)
    REFERENCES `revision-actual`.`comment` (`id_comment`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_comment_article1`
    FOREIGN KEY (`id_article`)
    REFERENCES `revision-actual`.`article` (`id_article`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `revision-actual`.`language`
-- -----------------------------------------------------
START TRANSACTION;
USE `revision-actual`;
INSERT INTO `revision-actual`.`language` (`code`, `name`) VALUES ('en-us', 'English');
INSERT INTO `revision-actual`.`language` (`code`, `name`) VALUES ('cs-cz', 'Czech');

COMMIT;

-- #What do I need?
-- Related articles - public articles from public categories
-- title, link , image, imageAlt, id_topic

-- Next or previous articles - public articles from any categories
-- title, link , image, imageAlt, id_topic

-- SELECT a.title, a.next, (SELECT b.id_article FROM article b WHERE b.next = a.id_article) AS previous FROM article a;


-- public article in a public topic
-- search in this
-- select related from this
-- select next or previous from this

CREATE OR REPLACE VIEW publicArticles AS
  SELECT
    a.id_article,
    l.code AS 'id_language',
    t.id_topic,
    a.title,
    a.link,
    i.path AS 'src',
    i.alt AS 'name',
    a.content,
    a.digest,
    a.keywords,
    a.creation,
    a.modified,
    u.id_user,
    u.username,
    next,
    a.wordcount,
    a.audiopath AS audio
  FROM article a
    JOIN image i ON a.id_image = i.id_image
    JOIN topic t ON a.id_topic = t.id_topic
    JOIN language l ON a.langcode = l.code
    JOIN user u ON a.id_writer = u.id_user
  WHERE a.public = 1 AND t.public = 1;

CREATE OR REPLACE VIEW articles AS
  SELECT
    a.id_article,
    l.code AS 'id_language',
    t.id_topic,
    a.title,
    a.link,
    i.path AS 'src',
    i.alt AS 'name',
    a.content,
    a.digest,
    a.keywords,
    a.creation,
    a.modified,
    u.id_user,
    next,
    u.username,
    a.wordcount,
    a.audiopath AS audio
  FROM article a
    JOIN image i ON a.id_image = i.id_image
    JOIN topic t ON a.id_topic = t.id_topic
    JOIN language l ON a.langcode = l.code
    JOIN user u ON a.id_writer = u.id_user
  WHERE a.public = 1;

CREATE OR REPLACE VIEW hiddenArticles AS
  SELECT
    a.id_article,
    l.code AS 'id_language',
    t.id_topic,
    a.title,
    a.link,
    i.path AS 'src',
    i.alt AS 'name',
    a.content,
    a.digest,
    a.keywords,
    next,
    a.creation,
    a.modified,
    u.id_user,
    u.username,
    a.wordcount,
    a.audiopath AS audio
  FROM article a
    JOIN image i ON a.id_image = i.id_image
    JOIN topic t ON a.id_topic = t.id_topic
    JOIN language l ON a.langcode = l.code
    JOIN user u ON a.id_writer = u.id_user
  WHERE a.public = 1 AND t.public = 0;


ALTER TABLE `article` ADD FULLTEXT( `title`, `link`, `content`, `digest`);

INSERT INTO `user` (`id_user`, `username`, `hash`, `creation`) VALUES (NULL, 'Morgosus', '#to-be-added', '2020-11-28 12:31:40');
INSERT INTO `language` (`code`, `name`) VALUES ('en-us', 'English'), ('cs-cz', 'Czech');
INSERT INTO `audio` (`path`, `name`, `language_code`) VALUES ('latte-php-template-engine.m4a', 'Latte PHP Template Engine', 'en-us'), ('markdown-i-like-it.m4a', 'Markdown, I like it', 'en-us');


INSERT INTO `image` (`id_image`, `name`, `alt`, `path`) VALUES
(1, 'placeholder', 'placeholder', 'placeholder.svg'),
(2, 'Mathematics', 'Mathematics', 'mathematics-actual.svg'),
(3, 'Economy', 'Economy', 'economy-actual.svg'),
(4, 'Database systems', 'Database systems', 'database-systems-actual.svg'),
(5, 'Náhled vzorečníku', 'Náhled vzorečníku', 'vzorecnik-preview.png'),
(6, 'Transport leaving', 'Transport leaving', 'transport-leaving.gif'),
(7, 'Sagittarius', 'Sagittarius', 'sagittarius.svg'),
(8, 'The Factory', 'The Factory', 'the-factory.svg'),
(9, 'Mundis', 'Mundis', 'mundis.svg'),
(10, 'Cthonians', 'Cthonians', 'cthonians.svg'),
(11, 'Cthonian Lightning', 'Cthonian Lightning', 'cth-lightning.gif'),
(12, 'Shoggoth', 'Shoggoth', 'shoggoth.svg'),
(13, 'Werewolf', 'Werewolf', 'werewolf.svg'),
(14, 'Deep One', 'Deep One', 'deep-one.svg'),
(15, 'Frogman', 'Frogman', 'frogman.svg'),
(16, 'Cultist', 'Cultist', 'cultist.svg'),
(17, 'MariaDB', 'MariaDB', 'mariadb.svg'),
(18, 'Markdown', 'Markdown', 'markdown.svg'),
(19, 'HTTP Header', 'HTTP Header', 'http.png'),
(20, 'cURL', 'cURL', 'curl.png');



INSERT INTO `revision-actual`.`topic` (`id_topic`, `langcode`, `parent`, `title`, `link`, `creation`, `public`) VALUES (1, 'cs-cz', NULL, 'Vzdělávání', 'vzdelavani', '2020-07-28 23:07:44', 1),
 (2, 'cs-cz', 1, 'Aplikovaná matematika', 'aplikovana-matematika', '2019-11-02 18:19:11', 1),
 (3, 'cs-cz', 1, 'Ekonomie', 'ekonomie', '2019-12-23 23:10:56', 1),
 (4, 'cs-cz', 3, 'Mikroekonomie', 'mikroekonomie', '2019-12-23 23:10:56', 1),
 (5, 'cs-cz', 3, 'Makroekonomie', 'makroekonomie', '2019-12-25 14:10:28', 1),
 (6, 'cs-cz', 1, 'Databázové systémy', 'databazove-systemy', '2019-12-25 15:23:24', 1),
 (7, 'cs-cz', 1, 'Pro spolužáky', 'pro-spoluzaky', '2020-05-22 22:56:19', 1),
 (8, 'en-us', NULL, 'Casual Writing', 'writing', '2020-08-04 04:06:25', 1),
 (9, 'en-us', 8, 'Sagittarius', 'sagittarius', '2020-02-13 11:46:00', 1),
 (10, 'en-us', 8, 'The Factory', 'the-factory', '2020-08-05 09:45:11', 1),
 (11, 'en-us', NULL, 'Programming', 'programming', '2020-08-26 12:57:33', 1),
 (12, 'en-us', 11, 'MariaDB SQL', 'mariadb-sql', '2020-08-26 16:16:16', 1),
 (13, 'en-us', 11, 'Mundis - the Prototype Pet Project', 'mundis-the-prototype-pet-project', '2020-09-09 23:26:23', 1),
 (14, 'en-us', 11, 'PHP', 'php', '2020-09-23 12:45:50', 1),
 (16, 'en-us', 11, 'SQL', 'sql', '2020-10-19 14:08:11', 1),
 (17, 'en-us', 11, 'CSS', 'css', '2020-10-19 19:55:24', 1);