-- 06_enterprise_modules.sql
-- Bank, Asset, Document, and Meeting Management Modules

-- =====================================
-- 1. BANK MANAGEMENT
-- =====================================
-- Upgrade existing bank_accounts table (from Phase 2)
ALTER TABLE `bank_accounts`
ADD COLUMN `branch` VARCHAR(100) NULL AFTER `bank_name`,
ADD COLUMN `account_type` VARCHAR(50) NULL AFTER `account_number`,
ADD COLUMN `current_balance` DECIMAL(15,2) DEFAULT 0 AFTER `account_type`,
ADD COLUMN `qr_code_file` VARCHAR(255) NULL AFTER `current_balance`,
ADD COLUMN `status` ENUM('ACTIVE', 'INACTIVE', 'CLOSED') DEFAULT 'ACTIVE' AFTER `qr_code_file`;

-- Bank Transactions Ledger
CREATE TABLE IF NOT EXISTS `bank_transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `bank_account_id` INT NOT NULL,
  `transaction_date` DATETIME NOT NULL,
  `transaction_type` ENUM('DEPOSIT', 'WITHDRAW', 'TRANSFER', 'FEE', 'INTEREST') NOT NULL,
  `reference_id` VARCHAR(100) NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `balance_after` DECIMAL(15,2) NOT NULL,
  `note` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =====================================
-- 2. ASSET MANAGEMENT (ครุภัณฑ์)
-- =====================================
CREATE TABLE IF NOT EXISTS `assets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `asset_code` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(255) NOT NULL,
  `asset_type` VARCHAR(100) NULL,
  `serial_number` VARCHAR(100) NULL,
  `price` DECIMAL(15,2) DEFAULT 0,
  `purchase_date` DATE NULL,
  `fund_id` INT NULL,
  `project_id` INT NULL,
  `department` VARCHAR(100) NULL,
  `location` VARCHAR(255) NULL,
  `status` ENUM('IN_USE', 'BROKEN', 'MAINTENANCE', 'RETIRED', 'TRANSFERRED') DEFAULT 'IN_USE',
  `photo_file` VARCHAR(255) NULL,
  `qr_tag_file` VARCHAR(255) NULL,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `asset_transfers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `asset_id` INT NOT NULL,
  `transfer_date` DATE NOT NULL,
  `from_department` VARCHAR(100) NULL,
  `to_department` VARCHAR(100) NULL,
  `transferred_by` INT NULL, -- ผู้ส่งมอบ
  `received_by` INT NULL, -- ผู้รับ
  `document_file` VARCHAR(255) NULL,
  `photo_file` VARCHAR(255) NULL,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =====================================
-- 3. DOCUMENT MANAGEMENT (สารบรรณ)
-- =====================================
CREATE TABLE IF NOT EXISTS `document_categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL, -- e.g., ข้อบังคับ, ประกาศ, คำสั่ง
  `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `document_categories` (`name`) VALUES ('ข้อบังคับ'), ('ประกาศ'), ('คำสั่ง'), ('หนังสือเข้า'), ('หนังสือออก'), ('รายงานการประชุม'), ('สัญญา'), ('เอกสารการเงิน'), ('รายงานประจำปี');

CREATE TABLE IF NOT EXISTS `documents` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `document_direction` ENUM('IN', 'OUT', 'INTERNAL') DEFAULT 'INTERNAL',
  `doc_number` VARCHAR(100) NULL, -- เลขหนังสือ
  `receive_number` VARCHAR(100) NULL, -- เลขรับ (ถ้ามี)
  `doc_date` DATE NOT NULL,
  `receive_date` DATE NULL,
  `doc_from` VARCHAR(255) NULL,
  `doc_to` VARCHAR(255) NULL,
  `subject` VARCHAR(255) NOT NULL,
  `owner_id` INT NULL, -- ผู้รับผิดชอบ/ผู้ลงนาม
  `status` VARCHAR(50) DEFAULT 'ACTIVE',
  `file_path` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =====================================
-- 4. MEETING MANAGEMENT
-- =====================================
CREATE TABLE IF NOT EXISTS `meetings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `meeting_number` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(255) NOT NULL,
  `meeting_date` DATE NOT NULL,
  `meeting_time` TIME NOT NULL,
  `location` VARCHAR(255) NULL,
  `details` TEXT NULL,
  `status` ENUM('DRAFT', 'SCHEDULED', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED') DEFAULT 'DRAFT',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `meeting_attendees` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `meeting_id` INT NOT NULL,
  `person_name` VARCHAR(255) NOT NULL,
  `role` VARCHAR(100) NULL, -- e.g., ประธาน, กรรมการ, เลขานุการ
  `status` ENUM('ATTENDED', 'ABSENT', 'LEAVE') DEFAULT 'ATTENDED',
  `notes` TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `meeting_agendas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `meeting_id` INT NOT NULL,
  `agenda_number` VARCHAR(20) NOT NULL, -- e.g., 1.1, 1.2
  `topic` VARCHAR(255) NOT NULL,
  `details` TEXT NULL,
  `attachment_file` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `meeting_resolutions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `agenda_id` INT NOT NULL,
  `resolution_text` TEXT NOT NULL,
  `owner_id` INT NULL,
  `due_date` DATE NULL,
  `status` ENUM('PENDING', 'IN_PROGRESS', 'COMPLETED', 'OVERDUE') DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `resolution_id` INT NULL,
  `title` VARCHAR(255) NOT NULL,
  `owner_id` INT NOT NULL,
  `deadline` DATE NULL,
  `progress` INT DEFAULT 0, -- 0 to 100
  `status` ENUM('TODO', 'IN_PROGRESS', 'DONE', 'CANCELLED') DEFAULT 'TODO',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
