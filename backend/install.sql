-- Tables pour le plugin Vault Assurances

-- Table App_User
CREATE TABLE IF NOT EXISTS `App_User` (
  `id_user` INT AUTO_INCREMENT PRIMARY KEY,
  `name_user` VARCHAR(255) NOT NULL UNIQUE,
  `email_user` VARCHAR(255) NOT NULL UNIQUE,
  `password_user` VARCHAR(255) NOT NULL,
  `is_admin` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Type_Category
CREATE TABLE IF NOT EXISTS `Type_Category` (
  `id_type_category` INT AUTO_INCREMENT PRIMARY KEY,
  `name_type_category` VARCHAR(255) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Category
CREATE TABLE IF NOT EXISTS `Category` (
  `id_category` INT AUTO_INCREMENT PRIMARY KEY,
  `name_category` VARCHAR(255) NOT NULL,
  `type_category_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`type_category_id`) REFERENCES `Type_Category`(`id_type_category`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Link
CREATE TABLE IF NOT EXISTS `Link` (
  `id_link` INT AUTO_INCREMENT PRIMARY KEY,
  `name_link` VARCHAR(255) NOT NULL,
  `url_link` VARCHAR(255) NOT NULL,
  `username_link` VARCHAR(255),
  `password_link` LONGTEXT,
  `commentary_link` TEXT,
  `image_link` LONGBLOB,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Assurance
CREATE TABLE IF NOT EXISTS `Assurance` (
  `id_assurance` INT AUTO_INCREMENT PRIMARY KEY,
  `name_assurance` VARCHAR(255) NOT NULL,
  `url_assurance` VARCHAR(255),
  `username_assurance` VARCHAR(255),
  `password_assurance` LONGTEXT,
  `code_courtage_assurance` VARCHAR(255),
  `commentary_assurance` TEXT,
  `image_assurance` LONGBLOB,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Propose (relation Assurance <-> Category)
CREATE TABLE IF NOT EXISTS `Propose` (
  `id_propose` INT AUTO_INCREMENT PRIMARY KEY,
  `id_assurance` INT NOT NULL,
  `id_category` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_assurance`) REFERENCES `Assurance`(`id_assurance`) ON DELETE CASCADE,
  FOREIGN KEY (`id_category`) REFERENCES `Category`(`id_category`) ON DELETE CASCADE,
  UNIQUE KEY `unique_propose` (`id_assurance`, `id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Favorite
CREATE TABLE IF NOT EXISTS `Favorite` (
  `id_favorite` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `id_assurance` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_user`) REFERENCES `App_User`(`id_user`) ON DELETE CASCADE,
  FOREIGN KEY (`id_assurance`) REFERENCES `Assurance`(`id_assurance`) ON DELETE CASCADE,
  UNIQUE KEY `unique_favorite` (`id_user`, `id_assurance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
