-- 04_donation_engine.sql
-- Core Donation & Receipt Management System

-- Master data for dropdowns
CREATE TABLE IF NOT EXISTS `funds` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `bank_accounts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `bank_name` VARCHAR(100) NOT NULL,
  `account_name` VARCHAR(255) NOT NULL,
  `account_number` VARCHAR(50) NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert defaults
INSERT INTO `funds` (`name`) VALUES ('กองทุนทั่วไป'), ('กองทุนเพื่อจัดซื้อเครื่องมือแพทย์');
INSERT INTO `projects` (`name`) VALUES ('โครงการสร้างอาคารผู้ป่วย'), ('โครงการปรับปรุงห้องผ่าตัด');
INSERT INTO `bank_accounts` (`bank_name`, `account_name`, `account_number`) VALUES ('ธนาคารกรุงไทย', 'มูลนิธิเพื่อโรงพยาบาลปลวกแดง', '123-4-56789-0');

-- CRM: Donors
CREATE TABLE IF NOT EXISTS `donors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `donor_code` VARCHAR(50) NOT NULL UNIQUE,
  `donor_type` ENUM('INDIVIDUAL', 'ORGANIZATION') DEFAULT 'INDIVIDUAL',
  `prefix` VARCHAR(50) NULL,
  `first_name` VARCHAR(100) NULL,
  `last_name` VARCHAR(100) NULL,
  `company_name` VARCHAR(255) NULL,
  `tax_id` VARCHAR(50) NULL,
  `phone` VARCHAR(50) NULL,
  `email` VARCHAR(100) NULL,
  `address` TEXT NULL,
  `province` VARCHAR(100) NULL,
  `zip_code` VARCHAR(20) NULL,
  `is_vip` TINYINT(1) DEFAULT 0,
  `is_founding` TINYINT(1) DEFAULT 0,
  `is_benefactor` TINYINT(1) DEFAULT 0,
  `is_anonymous` TINYINT(1) DEFAULT 0,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Donations
CREATE TABLE IF NOT EXISTS `donations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `donation_number` VARCHAR(50) NOT NULL UNIQUE,
  `donation_date` DATE NOT NULL,
  `donor_id` INT NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `payment_method` VARCHAR(100) NULL,
  `bank_account_id` INT NULL,
  `fund_id` INT NULL,
  `project_id` INT NULL,
  `purpose` TEXT NULL,
  `slip_file` VARCHAR(255) NULL,
  `document_file` VARCHAR(255) NULL,
  `note` TEXT NULL,
  `status` ENUM('DRAFT', 'PENDING', 'VERIFIED', 'APPROVED', 'RECEIPT_ISSUED', 'COMPLETED', 'CANCELLED') DEFAULT 'DRAFT',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Receipts
CREATE TABLE IF NOT EXISTS `receipts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `receipt_number` VARCHAR(50) NOT NULL UNIQUE,
  `donation_id` INT NOT NULL,
  `print_count` INT DEFAULT 0,
  `printed_at` TIMESTAMP NULL,
  `printed_by` INT NULL,
  `is_cancelled` TINYINT(1) DEFAULT 0,
  `cancelled_at` TIMESTAMP NULL,
  `cancel_reason` TEXT NULL,
  `cancelled_by` INT NULL,
  `reference_receipt_id` INT NULL, -- If this receipt replaces a cancelled one
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Receipt Print Logs (Duplicate Print Log)
CREATE TABLE IF NOT EXISTS `receipt_print_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `receipt_id` INT NOT NULL,
  `printed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `printed_by` INT NOT NULL,
  `ip_address` VARCHAR(45) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
