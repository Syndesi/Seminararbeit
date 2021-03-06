
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- uba_station
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `uba_station`;

CREATE TABLE `uba_station`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(256) NOT NULL,
    `code` VARCHAR(10) NOT NULL,
    `network` VARCHAR(2) NOT NULL,
    `lat` FLOAT,
    `lng` FLOAT,
    `alt` FLOAT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- uba_o3_smw
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `uba_o3_smw`;

CREATE TABLE `uba_o3_smw`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `value` FLOAT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `uba_o3_smw_fi_c582fe` (`station_id`),
    CONSTRAINT `uba_o3_smw_fk_c582fe`
        FOREIGN KEY (`station_id`)
        REFERENCES `uba_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- uba_so2_smw
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `uba_so2_smw`;

CREATE TABLE `uba_so2_smw`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `value` FLOAT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `uba_so2_smw_fi_c582fe` (`station_id`),
    CONSTRAINT `uba_so2_smw_fk_c582fe`
        FOREIGN KEY (`station_id`)
        REFERENCES `uba_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- uba_pm10_smw
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `uba_pm10_smw`;

CREATE TABLE `uba_pm10_smw`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `value` FLOAT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `uba_pm10_smw_fi_c582fe` (`station_id`),
    CONSTRAINT `uba_pm10_smw_fk_c582fe`
        FOREIGN KEY (`station_id`)
        REFERENCES `uba_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- uba_no2_smw
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `uba_no2_smw`;

CREATE TABLE `uba_no2_smw`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `value` FLOAT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `uba_no2_smw_fi_c582fe` (`station_id`),
    CONSTRAINT `uba_no2_smw_fk_c582fe`
        FOREIGN KEY (`station_id`)
        REFERENCES `uba_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- uba_co_8smw
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `uba_co_8smw`;

CREATE TABLE `uba_co_8smw`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `value` FLOAT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `uba_co_8smw_fi_c582fe` (`station_id`),
    CONSTRAINT `uba_co_8smw_fk_c582fe`
        FOREIGN KEY (`station_id`)
        REFERENCES `uba_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_station
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_station`;

CREATE TABLE `dwd_station`
(
    `id` INTEGER NOT NULL,
    `name` VARCHAR(256) NOT NULL,
    `lat` FLOAT,
    `lng` FLOAT,
    `alt` FLOAT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_air_temperature
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_air_temperature`;

CREATE TABLE `dwd_air_temperature`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `quality` INTEGER NOT NULL,
    `tt_tu` FLOAT,
    `rf_tu` FLOAT,
    PRIMARY KEY (`id`),
    INDEX `dwd_air_temperature_fi_924087` (`station_id`),
    CONSTRAINT `dwd_air_temperature_fk_924087`
        FOREIGN KEY (`station_id`)
        REFERENCES `dwd_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_cloudiness
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_cloudiness`;

CREATE TABLE `dwd_cloudiness`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `quality` INTEGER NOT NULL,
    `v_n_i` VARCHAR(1),
    `v_n` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `dwd_cloudiness_fi_924087` (`station_id`),
    CONSTRAINT `dwd_cloudiness_fk_924087`
        FOREIGN KEY (`station_id`)
        REFERENCES `dwd_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_precipitation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_precipitation`;

CREATE TABLE `dwd_precipitation`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `quality` INTEGER NOT NULL,
    `r1` FLOAT,
    `rs_ind` TINYINT(1),
    `wrtr` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `dwd_precipitation_fi_924087` (`station_id`),
    CONSTRAINT `dwd_precipitation_fk_924087`
        FOREIGN KEY (`station_id`)
        REFERENCES `dwd_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_pressure
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_pressure`;

CREATE TABLE `dwd_pressure`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `quality` INTEGER NOT NULL,
    `p` FLOAT,
    `p0` FLOAT,
    PRIMARY KEY (`id`),
    INDEX `dwd_pressure_fi_924087` (`station_id`),
    CONSTRAINT `dwd_pressure_fk_924087`
        FOREIGN KEY (`station_id`)
        REFERENCES `dwd_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_soil_temperature
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_soil_temperature`;

CREATE TABLE `dwd_soil_temperature`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `quality` INTEGER NOT NULL,
    `v_te002` FLOAT,
    `v_te005` FLOAT,
    `v_te010` FLOAT,
    `v_te020` FLOAT,
    `v_te050` FLOAT,
    `v_te100` FLOAT,
    PRIMARY KEY (`id`),
    INDEX `dwd_soil_temperature_fi_924087` (`station_id`),
    CONSTRAINT `dwd_soil_temperature_fk_924087`
        FOREIGN KEY (`station_id`)
        REFERENCES `dwd_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_solar
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_solar`;

CREATE TABLE `dwd_solar`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `quality` INTEGER NOT NULL,
    `atmo_lberg` FLOAT,
    `fd_lberg` FLOAT,
    `fg_lberg` FLOAT,
    `sd_lberg` INTEGER,
    `zenit` FLOAT,
    PRIMARY KEY (`id`),
    INDEX `dwd_solar_fi_924087` (`station_id`),
    CONSTRAINT `dwd_solar_fk_924087`
        FOREIGN KEY (`station_id`)
        REFERENCES `dwd_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_sun
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_sun`;

CREATE TABLE `dwd_sun`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `quality` INTEGER NOT NULL,
    `sd_so` FLOAT,
    PRIMARY KEY (`id`),
    INDEX `dwd_sun_fi_924087` (`station_id`),
    CONSTRAINT `dwd_sun_fk_924087`
        FOREIGN KEY (`station_id`)
        REFERENCES `dwd_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- dwd_wind
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `dwd_wind`;

CREATE TABLE `dwd_wind`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `station_id` INTEGER NOT NULL,
    `time` DATETIME NOT NULL,
    `quality` INTEGER NOT NULL,
    `f` FLOAT,
    `d` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `dwd_wind_fi_924087` (`station_id`),
    CONSTRAINT `dwd_wind_fk_924087`
        FOREIGN KEY (`station_id`)
        REFERENCES `dwd_station` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- account
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `forename` VARCHAR(64) NOT NULL,
    `surname` VARCHAR(64) NOT NULL,
    `email` VARCHAR(256) NOT NULL,
    `email_verified` TINYINT(1) NOT NULL,
    `hash` VARCHAR(256) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- account_authorized
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `account_authorized`;

CREATE TABLE `account_authorized`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `account_id` INTEGER NOT NULL,
    `is_authorized` TINYINT(1) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `account_authorized_fi_474870` (`account_id`),
    CONSTRAINT `account_authorized_fk_474870`
        FOREIGN KEY (`account_id`)
        REFERENCES `account` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- account_verification
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `account_verification`;

CREATE TABLE `account_verification`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `account_id` INTEGER NOT NULL,
    `link` VARCHAR(256) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `account_verification_fi_474870` (`account_id`),
    CONSTRAINT `account_verification_fk_474870`
        FOREIGN KEY (`account_id`)
        REFERENCES `account` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
