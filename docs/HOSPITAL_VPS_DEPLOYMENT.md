# คู่มือนำระบบขึ้น VPS โรงพยาบาล

อัปเดตล่าสุด: 2026-09-03

## รูปแบบการทำงาน

ใช้โครงสร้างเดียวตลอดการพัฒนา:

```text
เครื่องพัฒนา XAMPP  ->  GitHub (origin/main)  ->  VPS โรงพยาบาล
ทดสอบในเครื่อง          เก็บรุ่นโค้ด              ใช้งานจริง
```

- XAMPP ใช้สำหรับพัฒนาและทดสอบเท่านั้น
- GitHub เก็บเฉพาะ source code, migration และเอกสาร ห้ามเก็บ `.env`, รหัสผ่าน, dump ฐานข้อมูลจริง หรือไฟล์อัปโหลด
- VPS ดึงโค้ดจาก GitHub และใช้ `.env`, ฐานข้อมูล และไฟล์อัปโหลดของ production ที่แยกเก็บบน VPS

## 1. ขั้นตอนจาก XAMPP ไป GitHub

ทดสอบระบบในเครื่องก่อนทุกครั้ง แล้วบันทึกรุ่นโค้ดขึ้น branch `main`:

```bash
git status
git add app routes views public database docs .gitignore .env.example
git commit -m "feat: describe the change"
git push origin main
```

ก่อน push ให้ตรวจว่าไม่มี `.env`, รหัสผ่าน, ข้อมูลผู้บริจาค, สลิปโอนเงิน หรือไฟล์ใน `public/uploads/` ติดไปกับ commit:

```bash
git status
git diff --cached --name-only
```

## 2. เตรียม VPS ครั้งแรก

แนะนำ Ubuntu 22.04/24.04, Apache 2.4, PHP 8.2+, MySQL 8 หรือ MariaDB 10.6+, Composer และ Git

บน VPS ให้ clone ไว้ในตำแหน่งที่ทีม IT ดูแล เช่น `/var/www/pdhfoundation`:

```bash
sudo mkdir -p /var/www
sudo git clone https://github.com/pharmacisttom/pdhfoundaation.git /var/www/pdhfoundation
cd /var/www/pdhfoundation
sudo composer install --no-dev --optimize-autoloader
sudo cp .env.example .env
```

แก้ `.env` บน VPS เท่านั้น ตัวอย่างค่าที่ต้องกำหนด:

```dotenv
APP_ENV=production
APP_URL=https://foundation.hospital.go.th
APP_DEBUG=false

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pdhfoundation
DB_USERNAME=foundation_app
DB_PASSWORD=use_a_unique_strong_password
CSRF_TOKEN_SECRET=use_a_long_random_secret
```

นำเข้า migration ตามลำดับใน `database/migrations` เข้าฐานข้อมูล production และสร้างโฟลเดอร์ runtime:

```bash
sudo mkdir -p public/uploads/{foundation,banks,cms/banners,slips} storage/logs
sudo chown -R www-data:www-data public/uploads storage
sudo find public/uploads storage -type d -exec chmod 775 {} \;
sudo find public/uploads storage -type f -exec chmod 664 {} \;
```

## 3. ตั้งค่า Apache และ HTTPS

ระบบนี้ใช้ `.htaccess` ที่ root project เพื่อส่งคำขอเข้าสู่ `public/` และยังมี URL เดิมบางส่วนที่เรียก `/public/...` อยู่ จึงต้องตั้ง `DocumentRoot` เป็นโฟลเดอร์ project:

```apache
<VirtualHost *:80>
    ServerName foundation.hospital.go.th
    DocumentRoot /var/www/pdhfoundation

    <Directory /var/www/pdhfoundation>
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/pdhfoundation-error.log
    CustomLog ${APACHE_LOG_DIR}/pdhfoundation-access.log combined
</VirtualHost>
```

เปิด `rewrite`, เปิด site แล้วทดสอบ config ก่อน reload:

```bash
sudo a2enmod rewrite
sudo a2ensite pdhfoundation.conf
sudo apachectl configtest
sudo systemctl reload apache2
```

ติดตั้งใบรับรอง HTTPS ตามมาตรฐาน IT ของโรงพยาบาลหรือ Let's Encrypt แล้วเปลี่ยน `APP_URL` ให้เป็น `https://...` เสมอ

## 4. ขั้นตอนอัปเดตระบบบน VPS

ทุกครั้งที่มี commit ใหม่บน GitHub ให้สำรองฐานข้อมูลและไฟล์อัปโหลดก่อน จากนั้นให้ทีม IT รัน:

```bash
cd /var/www/pdhfoundation
sudo -u www-data git fetch origin
sudo -u www-data git pull --ff-only origin main
sudo -u www-data composer install --no-dev --optimize-autoloader
```

ถ้ามี migration ใหม่ ให้สำรองฐานข้อมูลก่อนและ import เฉพาะไฟล์ migration นั้นตามขั้นตอนที่กำหนดใน release note ห้าม import ไฟล์ schema เริ่มต้นซ้ำในฐานข้อมูลที่ใช้งานแล้ว

หลัง deploy ให้ทดสอบหน้าเว็บ, login, เพิ่มรายการบริจาคทดสอบ, อัปโหลดไฟล์, ออกใบเสร็จ และรายงาน ก่อนแจ้งเปิดใช้งาน

## 5. ข้อมูลที่ต้องสำรอง

สำรองรายวันอย่างน้อย 2 ส่วน และเก็บสำเนานอก VPS:

- ฐานข้อมูล MySQL/MariaDB
- `public/uploads/` และ `storage/`

จำกัด SSH และหน้า `/admin` ผ่าน VPN หรือ IP ของโรงพยาบาลเมื่อทำได้ และเปลี่ยนรหัสผ่านผู้ดูแลเริ่มต้นทันทีหลังติดตั้ง
