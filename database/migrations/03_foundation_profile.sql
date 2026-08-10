-- 03_foundation_profile.sql

CREATE TABLE `foundation_profiles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name_th` VARCHAR(255) NOT NULL,
  `name_en` VARCHAR(255) NULL,
  `short_name` VARCHAR(100) NULL,
  `logo` VARCHAR(255) NULL,
  `favicon` VARCHAR(255) NULL,
  `registration_no` VARCHAR(100) NULL,
  `tax_id` VARCHAR(100) NULL,
  `founded_date` DATE NULL,
  `address` TEXT NULL,
  `phone` VARCHAR(100) NULL,
  `email` VARCHAR(100) NULL,
  `website` VARCHAR(255) NULL,
  `facebook` VARCHAR(255) NULL,
  `line_oa` VARCHAR(100) NULL,
  `google_maps` TEXT NULL,
  `working_hours` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `foundation_history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `history_text` TEXT NULL,
  `intent_text` TEXT NULL,
  `vision_text` TEXT NULL,
  `mission_text` TEXT NULL,
  `objective_text` TEXT NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `foundation_patrons` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `prefix` VARCHAR(50) NULL,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `display_name` VARCHAR(255) NULL,
  `position` VARCHAR(255) NULL,
  `photo` VARCHAR(255) NULL,
  `biography` TEXT NULL,
  `honor_text` TEXT NULL,
  `start_date` DATE NULL,
  `end_date` DATE NULL,
  `sort_order` INT DEFAULT 0,
  `is_published` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `foundation_founders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `photo` VARCHAR(255) NULL,
  `position` VARCHAR(255) NULL,
  `role_description` VARCHAR(255) NULL,
  `biography` TEXT NULL,
  `sort_order` INT DEFAULT 0,
  `is_published` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `founding_donors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `donor_type` ENUM('INDIVIDUAL', 'ORGANIZATION') DEFAULT 'INDIVIDUAL',
  `name` VARCHAR(255) NOT NULL,
  `donation_date` DATE NULL,
  `support_type` ENUM('MONEY', 'LAND', 'BUILDING', 'EQUIPMENT', 'ASSET', 'OTHER') DEFAULT 'MONEY',
  `amount` DECIMAL(15,2) NULL,
  `asset_value` DECIMAL(15,2) NULL,
  `details` TEXT NULL,
  `show_name` TINYINT(1) DEFAULT 1,
  `show_amount` TINYINT(1) DEFAULT 1,
  `photo` VARCHAR(255) NULL,
  `sort_order` INT DEFAULT 0,
  `is_published` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `foundation_benefactors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `photo` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `achievements` TEXT NULL,
  `support_type` VARCHAR(100) NULL,
  `sort_order` INT DEFAULT 0,
  `is_published` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `foundation_milestones` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `milestone_date` DATE NULL,
  `year_th` VARCHAR(4) NULL,
  `title` VARCHAR(255) NOT NULL,
  `details` TEXT NULL,
  `photo` VARCHAR(255) NULL,
  `sort_order` INT DEFAULT 0,
  `is_published` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `board_terms` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `term_name` VARCHAR(255) NOT NULL,
  `start_date` DATE NULL,
  `end_date` DATE NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `board_members` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `board_term_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `photo` VARCHAR(255) NULL,
  `position` VARCHAR(255) NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initialize single row for settings tables
INSERT INTO `foundation_profiles` (`name_th`) VALUES ('มูลนิธิเพื่อโรงพยาบาลปลวกแดง');
INSERT INTO `foundation_history` (`history_text`) VALUES ('');
