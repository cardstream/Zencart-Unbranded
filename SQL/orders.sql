/*WARNING!!! MAKE SURE TO EDIT THIS FILE AND CHANGE THE NAME OF THE ORDERS TABLE TO YOUR OWN FOUND IN YOUR ZEN CART DATABASE*/
ALTER TABLE orders ADD COLUMN `payment_network_xref` VARCHAR(128) NULL, ADD COLUMN `payment_network_transactionUnique` VARCHAR(128) NULL, ADD COLUMN `payment_network_amount_received` FLOAT NOT NULL DEFAULT '0.0', ADD COLUMN `payment_network_authorisationCode` VARCHAR(128) NULL, ADD COLUMN `payment_network_responseMessage` TEXT NULL, ADD COLUMN `payment_network_lastAction` VARCHAR(32) NULL