
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- admin
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) DEFAULT '' NOT NULL,
    `password` VARCHAR(30) DEFAULT '' NOT NULL,
    `api_key` VARCHAR(36) DEFAULT '' NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `admin_username_unique` (`username`),
    UNIQUE INDEX `admin_api_key_unique` (`api_key`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- permission
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `admin_id` INTEGER,
    `create_permission` INTEGER DEFAULT 0 NOT NULL,
    `read_permission` INTEGER DEFAULT 0 NOT NULL,
    `update_permission` INTEGER DEFAULT 0 NOT NULL,
    `delete_permission` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fi_mission_admin_id` (`admin_id`),
    CONSTRAINT `permission_admin_id`
        FOREIGN KEY (`admin_id`)
        REFERENCES `admin` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- client
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `client`;

CREATE TABLE `client`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) DEFAULT '' NOT NULL,
    `password` VARCHAR(30) DEFAULT '' NOT NULL,
    `email` VARCHAR(30) DEFAULT '' NOT NULL,
    `phone_number` VARCHAR(15) DEFAULT '' NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- seller
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `seller`;

CREATE TABLE `seller`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) DEFAULT '' NOT NULL,
    `password` VARCHAR(30) DEFAULT '' NOT NULL,
    `email` VARCHAR(30) DEFAULT '' NOT NULL,
    `phone_number` VARCHAR(15) DEFAULT '' NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `id_client` INTEGER,
    `id_seller` INTEGER,
    `expires_at` DATE DEFAULT '2025-01-01' NOT NULL,
    `type` VARCHAR(10) DEFAULT '' NOT NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `fi_er_id_client` (`id_client`),
    INDEX `fi_er_id_seller` (`id_seller`),
    CONSTRAINT `order_id_client`
        FOREIGN KEY (`id_client`)
        REFERENCES `client` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `order_id_seller`
        FOREIGN KEY (`id_seller`)
        REFERENCES `seller` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) DEFAULT '' NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `category_name_unique` (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cart
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `id_client` INTEGER DEFAULT 1 NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `fi_t_client_id` (`id_client`),
    CONSTRAINT `cart_client_id`
        FOREIGN KEY (`id_client`)
        REFERENCES `client` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cart_products
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cart_products`;

CREATE TABLE `cart_products`
(
    `id_cart` INTEGER DEFAULT 1 NOT NULL,
    `id_product` INTEGER DEFAULT 1 NOT NULL,
    `quantity` INTEGER DEFAULT 1 NOT NULL,
    INDEX `fi_t_product_cart` (`id_cart`),
    INDEX `fi_t_product_product` (`id_product`),
    CONSTRAINT `cart_product_cart`
        FOREIGN KEY (`id_cart`)
        REFERENCES `cart` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `cart_product_product`
        FOREIGN KEY (`id_product`)
        REFERENCES `product` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- seller_products
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `seller_products`;

CREATE TABLE `seller_products`
(
    `id_seller` INTEGER DEFAULT 1 NOT NULL,
    `id_product` INTEGER DEFAULT 1 NOT NULL,
    INDEX `fi_ler_product_seller` (`id_seller`),
    INDEX `fi_ler_product_product` (`id_product`),
    CONSTRAINT `seller_product_seller`
        FOREIGN KEY (`id_seller`)
        REFERENCES `seller` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `seller_product_product`
        FOREIGN KEY (`id_product`)
        REFERENCES `product` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order_products
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_products`;

CREATE TABLE `order_products`
(
    `id_order` INTEGER DEFAULT 1 NOT NULL,
    `id_product` INTEGER DEFAULT 1 NOT NULL,
    `quantity` INTEGER DEFAULT 1 NOT NULL,
    INDEX `fi_er_product_cart` (`id_order`),
    INDEX `fi_er_product_product` (`id_product`),
    CONSTRAINT `order_product_cart`
        FOREIGN KEY (`id_order`)
        REFERENCES `order` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `order_product_product`
        FOREIGN KEY (`id_product`)
        REFERENCES `product` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- address
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `country` VARCHAR(30) DEFAULT '' NOT NULL,
    `state` VARCHAR(2) DEFAULT '' NOT NULL,
    `city` VARCHAR(20) DEFAULT '' NOT NULL,
    `neighborhood` VARCHAR(20) DEFAULT '' NOT NULL,
    `street` VARCHAR(30) DEFAULT '' NOT NULL,
    `number` INTEGER DEFAULT 1 NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- address_owner
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `address_owner`;

CREATE TABLE `address_owner`
(
    `id_address` INTEGER DEFAULT 1 NOT NULL,
    `id_client` INTEGER,
    `id_seller` INTEGER,
    `type` VARCHAR(10) DEFAULT '' NOT NULL,
    INDEX `fi_ress_owner_address` (`id_address`),
    INDEX `fi_ress_owner_client` (`id_client`),
    INDEX `fi_ress_owner_seller` (`id_seller`),
    CONSTRAINT `address_owner_address`
        FOREIGN KEY (`id_address`)
        REFERENCES `address` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `address_owner_client`
        FOREIGN KEY (`id_client`)
        REFERENCES `client` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `address_owner_seller`
        FOREIGN KEY (`id_seller`)
        REFERENCES `seller` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50) DEFAULT '' NOT NULL,
    `desc` VARCHAR(200) DEFAULT '',
    `unity_price` FLOAT DEFAULT 1 NOT NULL,
    `in_stock` INTEGER DEFAULT 1 NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `product_title_unique` (`title`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- discount
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `discount`;

CREATE TABLE `discount`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(1) DEFAULT '' NOT NULL,
    `id_product` INTEGER,
    `id_category` INTEGER,
    `percent` INTEGER DEFAULT 1 NOT NULL,
    `start_at` TIMESTAMP NOT NULL DEFAULT '2024-01-01 00:00:00',
    `expires_at` TIMESTAMP NOT NULL DEFAULT '2024-01-01 00:00:00',
    PRIMARY KEY (`id`),
    INDEX `fi_count_product_id` (`id_product`),
    INDEX `fi_count_category_id` (`id_category`),
    CONSTRAINT `discount_product_id`
        FOREIGN KEY (`id_product`)
        REFERENCES `product` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `discount_category_id`
        FOREIGN KEY (`id_category`)
        REFERENCES `category` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- product_category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_category`;

CREATE TABLE `product_category`
(
    `id_product` INTEGER DEFAULT 1 NOT NULL,
    `id_category` INTEGER DEFAULT 1 NOT NULL,
    INDEX `fi_duct_category_product` (`id_product`),
    INDEX `fi_duct_category_category` (`id_category`),
    CONSTRAINT `product_category_product`
        FOREIGN KEY (`id_product`)
        REFERENCES `product` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `product_category_category`
        FOREIGN KEY (`id_category`)
        REFERENCES `category` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
