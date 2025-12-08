ALTER TABLE `activiteit_event_tijd` ADD `aantal_personen` INT NOT NULL AFTER `eind_tijd`;
-- Aantal personen opslaan bij elke instantie

ALTER TABLE `activiteit` DROP `locatie`;
ALTER TABLE `activiteit_event_tijd` ADD `locatie` VARCHAR(255) NULL AFTER `aantal_personen`;
-- Locatie bij vacature opslaan, zodat activiteiten op meerdere locaties kunnen worden gebruikt.