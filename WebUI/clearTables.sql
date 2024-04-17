
ALTER TABLE `purchases` DROP FOREIGN KEY `custID`;
ALTER TABLE `purchases` DROP FOREIGN KEY `ISBN`;

DROP TABLE IF EXISTS book;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS purchases;


CREATE TABLE `book` (
                        `ISBN` char(10) NOT NULL,
                        `title` varchar(45) NOT NULL,
                        `price` float NOT NULL,
                        PRIMARY KEY (`ISBN`)
) ENGINE=InnoDB;

CREATE TABLE `customer` (
                            `ID` int NOT NULL AUTO_INCREMENT,
                            `name` varchar(45) NOT NULL,
                            `password` varchar(45) NOT NULL,
                            `total_spent` FLOAT NOT NULL DEFAULT 0,
                            PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

CREATE TABLE `purchases` (
                             `purchaseID` int NOT NULL AUTO_INCREMENT,
                             `custID` int NOT NULL,
                             `ISBN` char(10) NOT NULL,
                             `quantity` int NOT NULL,
                             `title` VARCHAR(45) NOT NULL,
                             PRIMARY KEY (`purchaseID`),
                             KEY `custID` (`custID`),
                             KEY `ISBN` (`ISBN`),
                             CONSTRAINT `custID` FOREIGN KEY (`custID`) REFERENCES `customer` (`ID`) ON DELETE CASCADE,
                             CONSTRAINT `ISBN` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO `nicholas_s_snell`.`customer`
(`id`,
 `name`,
 `password`)
VALUES
    (0,
     "admin",
     "admin");
