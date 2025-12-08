ALTER TABLE `activiteit` DROP `locatie`;
ALTER TABLE `activiteit_event_tijd` ADD `locatie` VARCHAR(255) NULL AFTER `eind_tijd`;