<?php
/**
 * Created by PhpStorm.
 * User: Personal
 * Date: 10/23/14
 * Time: 6:45 PM
 * Update DB version 1.4
 */

//
// Event Organizers
//
global $table_prefix;
$commands = "CREATE TABLE IF NOT EXISTS `pec_organizers` (
    `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `userID` INT( 11 ) NOT NULL ,
    `organizer` VARCHAR( 512 ) NULL DEFAULT NULL ,
    `createdDate` TIMESTAMP NOT NULL
    ) ENGINE = INNODB;

    ALTER TABLE  `pec_events` ADD  `organizer` INT( 11 ) NOT NULL DEFAULT  '0' AFTER  `url`;
    ";

//
// Event conflict flag
//
$commands .= "ALTER TABLE `pec_settings` ADD `event_conflict` INT NOT NULL;";

//
// Table structure for table `pec_venues`
//
$commands .= "CREATE TABLE IF NOT EXISTS `pec_venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `venue_name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(200) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `post_code` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `website` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `pec_events` ADD `venue` INT NOT NULL AFTER `organizer`";

// Update version 1.4.2
$commands .= "ALTER TABLE `pec_events` ADD `thumbnail` VARCHAR( 10 ) NOT NULL AFTER `image`";
?>