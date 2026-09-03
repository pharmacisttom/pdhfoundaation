-- 02_phase1_refinements.sql
-- Add running_numbers and force_password_change

CREATE TABLE IF NOT EXISTS `running_numbers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `prefix` VARCHAR(20) NOT NULL UNIQUE,
  `current_number` INT NOT NULL DEFAULT 0,
  `year` VARCHAR(4) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ALTER TABLE `users` ADD COLUMN `force_password_change` TINYINT(1) DEFAULT 1 AFTER `password`;
-- ALTER TABLE `users` CHANGE `name` `fullname` VARCHAR(100) NOT NULL;

ALTER TABLE `roles` MODIFY `name` VARCHAR(100) NOT NULL;
ALTER TABLE `permissions` MODIFY `name` VARCHAR(100) NOT NULL;

-- Re-seed roles to match specification
DELETE FROM `role_permissions`;
DELETE FROM `permissions`;
DELETE FROM `users`;
DELETE FROM `roles`;
ALTER TABLE `roles` AUTO_INCREMENT = 1;
ALTER TABLE `permissions` AUTO_INCREMENT = 1;
ALTER TABLE `users` AUTO_INCREMENT = 1;

INSERT INTO `roles` (`name`, `description`) VALUES 
('Super Admin', 'ผู้ดูแลระบบสูงสุด'),
('Admin', 'ผู้ดูแลระบบทั่วไป'),
('เจ้าหน้าที่มูลนิธิ', 'เจ้าหน้าที่ปฏิบัติการ'),
('การเงิน', 'เจ้าหน้าที่การเงิน'),
('เหรัญญิก', 'เหรัญญิกมูลนิธิ'),
('กรรมการ', 'กรรมการมูลนิธิ'),
('ประธาน', 'ประธานมูลนิธิ'),
('Auditor', 'ผู้ตรวจสอบบัญชี'),
('Webmaster', 'ผู้ดูแลเว็บไซต์');

-- Insert fine-grained permissions
INSERT INTO `permissions` (`name`, `description`) VALUES
('dashboard.view', 'ดูแดชบอร์ด'),
('donor.view', 'ดูข้อมูลผู้บริจาค'),
('donor.create', 'เพิ่มผู้บริจาค'),
('donor.update', 'แก้ไขผู้บริจาค'),
('donation.view', 'ดูรายการบริจาค'),
('donation.create', 'เพิ่มรายการบริจาค'),
('donation.verify', 'ตรวจสอบการบริจาค'),
('donation.approve', 'อนุมัติการบริจาค'),
('receipt.view', 'ดูใบเสร็จ'),
('receipt.create', 'ออกใบเสร็จ'),
('receipt.cancel', 'ยกเลิกใบเสร็จ'),
('expense.view', 'ดูรายการรายจ่าย'),
('expense.create', 'สร้างรายการรายจ่าย'),
('expense.approve', 'อนุมัติรายจ่าย'),
('cms.manage', 'จัดการเนื้อหาเว็บไซต์'),
('report.view', 'ดูรายงาน'),
('report.export', 'ส่งออกรายงาน'),
('user.manage', 'จัดการผู้ใช้งาน'),
('setting.manage', 'ตั้งค่าระบบ'),
('audit.view', 'ดูประวัติการใช้งาน');

-- Grant all to Super Admin (Role 1)
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 1, id FROM `permissions`;

-- Re-insert Super Admin user
INSERT INTO `users` (`username`, `password`, `force_password_change`, `fullname`, `role_id`, `status`) VALUES 
('admin', '$2y$10$SmhuiCbbNuwhcEosKuUXxul69DNemEagwhC8cbNmdcSAgb7AY0CxG', 1, 'Super Administrator', 1, 'ACTIVE');
-- Password for admin is set during deployment.
