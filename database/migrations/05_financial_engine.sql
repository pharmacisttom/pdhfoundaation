-- 05_financial_engine.sql
-- Core Financial Ledger, Projects, and Expense Engine

-- 1. Upgrade Funds Table
ALTER TABLE `funds` 
ADD COLUMN `fund_code` VARCHAR(50) NULL AFTER `id`,
ADD COLUMN `description` TEXT NULL AFTER `name`,
ADD COLUMN `opening_balance` DECIMAL(15,2) DEFAULT 0 AFTER `description`,
ADD COLUMN `current_balance` DECIMAL(15,2) DEFAULT 0 AFTER `opening_balance`,
ADD COLUMN `status` ENUM('OPEN', 'CLOSED') DEFAULT 'OPEN' AFTER `current_balance`,
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD COLUMN `created_by` INT NULL,
ADD COLUMN `updated_by` INT NULL;

-- 2. Upgrade Projects Table
ALTER TABLE `projects`
ADD COLUMN `project_code` VARCHAR(50) NULL AFTER `id`,
ADD COLUMN `description` TEXT NULL AFTER `name`,
ADD COLUMN `owner_id` INT NULL AFTER `description`,
ADD COLUMN `department` VARCHAR(100) NULL AFTER `owner_id`,
ADD COLUMN `start_date` DATE NULL AFTER `department`,
ADD COLUMN `end_date` DATE NULL AFTER `start_date`,
ADD COLUMN `budget` DECIMAL(15,2) DEFAULT 0 AFTER `end_date`,
ADD COLUMN `donation_target` DECIMAL(15,2) DEFAULT 0 AFTER `budget`,
ADD COLUMN `received_amount` DECIMAL(15,2) DEFAULT 0 AFTER `donation_target`,
ADD COLUMN `expense_amount` DECIMAL(15,2) DEFAULT 0 AFTER `received_amount`,
ADD COLUMN `balance` DECIMAL(15,2) DEFAULT 0 AFTER `expense_amount`,
ADD COLUMN `status` ENUM('DRAFT', 'OPEN', 'ACTIVE', 'COMPLETED', 'SUSPENDED', 'CLOSED') DEFAULT 'OPEN' AFTER `balance`,
ADD COLUMN `cover_image` VARCHAR(255) NULL AFTER `status`,
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD COLUMN `created_by` INT NULL,
ADD COLUMN `updated_by` INT NULL;

-- 3. The Master Ledger (fund_transactions)
CREATE TABLE IF NOT EXISTS `fund_transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `fund_id` INT NOT NULL,
  `transaction_date` DATETIME NOT NULL,
  `credit` DECIMAL(15,2) DEFAULT 0,
  `debit` DECIMAL(15,2) DEFAULT 0,
  `reference_type` ENUM('DONATION', 'EXPENSE', 'REVENUE', 'TRANSFER', 'OPENING', 'VOID') NOT NULL,
  `reference_id` INT NOT NULL,
  `running_balance` DECIMAL(15,2) NOT NULL,
  `note` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Expenses
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `expense_number` VARCHAR(50) NOT NULL UNIQUE,
  `expense_date` DATE NOT NULL,
  `requester_id` INT NOT NULL,
  `fund_id` INT NOT NULL,
  `project_id` INT NULL,
  `vendor` VARCHAR(255) NULL,
  `total_amount` DECIMAL(15,2) NOT NULL,
  `note` TEXT NULL,
  `status` ENUM('DRAFT', 'SUBMITTED', 'UNDER_REVIEW', 'APPROVED', 'REJECTED', 'PAID', 'CANCELLED', 'VOIDED') DEFAULT 'DRAFT',
  `cancel_reason` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `expense_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `expense_id` INT NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `quantity` DECIMAL(10,2) DEFAULT 1,
  `unit_price` DECIMAL(15,2) NOT NULL,
  `total` DECIMAL(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Expense Documents (ใบเสนอราคา, ใบสั่งซื้อ ฯลฯ)
CREATE TABLE IF NOT EXISTS `expense_documents` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `expense_id` INT NOT NULL,
  `document_type` VARCHAR(100) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Expense Approvals (Audit trail for workflow)
CREATE TABLE IF NOT EXISTS `expense_approvals` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `expense_id` INT NOT NULL,
  `approver_id` INT NOT NULL,
  `role_at_time` VARCHAR(100) NULL,
  `action` ENUM('SUBMITTED', 'APPROVED', 'REJECTED', 'PAID', 'CANCELLED', 'VOIDED') NOT NULL,
  `comment` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Revenues (Non-Donation Income)
CREATE TABLE IF NOT EXISTS `revenues` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `revenue_number` VARCHAR(50) NOT NULL UNIQUE,
  `revenue_date` DATE NOT NULL,
  `source_name` VARCHAR(255) NOT NULL,
  `fund_id` INT NOT NULL,
  `project_id` INT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `reference_document` VARCHAR(255) NULL,
  `note` TEXT NULL,
  `status` ENUM('DRAFT', 'COMPLETED', 'VOIDED') DEFAULT 'DRAFT',
  `cancel_reason` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Setup Workflow Configuration in system_settings
INSERT IGNORE INTO `system_settings` (`setting_group`, `setting_key`, `setting_value`) 
VALUES ('EXPENSE', 'approval_workflow', '[{"step": 1, "role": "หัวหน้า", "action": "UNDER_REVIEW"}, {"step": 2, "role": "เหรัญญิก", "action": "UNDER_REVIEW"}, {"step": 3, "role": "ประธาน", "action": "APPROVED"}, {"step": 4, "role": "การเงิน", "action": "PAID"}]');
