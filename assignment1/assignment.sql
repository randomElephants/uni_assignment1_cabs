
DROP TABLE IF EXISTS `cabsBooking` ;
DROP TABLE IF EXISTS `cabsCustomer` ;

-- -----------------------------------------------------
-- Table `cabsCustomer`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `cabsCustomer` (
  `email_address` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`email_address`));

-- -----------------------------------------------------
-- Table `cabsBooking`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cabsBooking` (
  `reference_number` INT unsigned NOT NULL AUTO_INCREMENT,
  `customer` VARCHAR(255) NOT NULL,
  `passenger_name` VARCHAR(255) NOT NULL,
  `status` ENUM('UNASSIGNED', 'ASSIGNED') NOT NULL DEFAULT 'UNASSIGNED',
  `passenger_phone` VARCHAR(20) NOT NULL,
  `dest_suburb` VARCHAR(100) NOT NULL,
  `placement_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pickup_datetime` DATETIME NOT NULL,
  `unit_number` VARCHAR(45) DEFAULT NULL,
  `street_number` VARCHAR(45) NOT NULL,
  `street_name` VARCHAR(45) NOT NULL,
  `pickup_suburb` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`reference_number`),
  CONSTRAINT `fk_booking_customer`
    FOREIGN KEY (`customer`)
    REFERENCES `cabsCustomer` (`email_address`));

ALTER TABLE cabsBooking auto_increment = 10500;

