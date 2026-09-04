<!-- Hero Section -->
<section class="hero-section">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8" data-aos="fade-up">
                <span class="badge bg-accent text-dark px-3 py-2 rounded-pill mb-3 fw-bold shadow-sm">
                    <i class="fa-solid fa-star me-1"></i> เพื่ออนาคตสาธารณสุขไทย
                </span>
                <h1 class="display-4 fw-bold mb-4" style="line-height: 1.2;">
                    ร่วมสร้างโอกาสทางสุขภาพ<br>
                    <span class="text-accent">เพื่อประชาชนอำเภอปลวกแดง</span>
                </h1>
                <p class="lead opacity-75 mb-5 fw-light" style="max-width: 600px;">
                    ทุกการให้ของคุณ คือพลังในการพัฒนาบริการสุขภาพ จัดซื้อเครื่องมือแพทย์ 
                    และยกระดับคุณภาพชีวิตของประชาชนในอำเภอปลวกแดงและพื้นที่ใกล้เคียง
                </p>
                <div class="d-flex gap-3">
                    <a href="<?php echo $_ENV['APP_URL']; ?>/donate" class="btn btn-accent btn-lg rounded-pill px-5 fw-bold shadow">
                        ร่วมบริจาคตอนนี้
                    </a>
                    <a href="<?php echo $_ENV['APP_URL']; ?>/projects" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-bold">
                        โครงการของเรา
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5" style="margin-top: -60px; position: relative; z-index: 10;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-box text-center">
                    <i class="fa-solid fa-users fa-3x text-primary mb-3 opacity-75"></i>
                    <h2 class="fw-bold mb-1">1,250+</h2>
                    <p class="text-muted mb-0">ผู้ร่วมบริจาคทั้งหมด</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-box text-center">
                    <i class="fa-solid fa-hand-holding-dollar fa-3x text-primary mb-3 opacity-75"></i>
                    <h2 class="fw-bold mb-1 text-accent">15.5M ฿</h2>
                    <p class="text-muted mb-0">ยอดเงินบริจาคสะสม</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-box text-center">
                    <i class="fa-solid fa-building-circle-check fa-3x text-primary mb-3 opacity-75"></i>
                    <h2 class="fw-bold mb-1">12</h2>
                    <p class="text-muted mb-0">โครงการที่สำเร็จแล้ว</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects -->
<section class="py-5 bg-white">
    <div class="container my-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-accent fw-bold text-uppercase tracking-widest">Our Projects</h6>
            <h2 class="fw-bold text-primary">โครงการระดมทุนที่กำลังเปิดรับ</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px;">
                ร่วมเป็นส่วนหนึ่งในการสนับสนุนโครงการสำคัญ เพื่อพัฒนาศักยภาพทางการแพทย์ของโรงพยาบาลปลวกแดง
            </p>
        </div>

        <div class="row g-4">
            <?php if (empty($data['projects'])): ?>
                <!-- Mock Data if no active projects -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="project-card h-100 d-flex flex-column">
                        <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Project 1" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="badge bg-light text-primary border mb-3 w-auto align-self-start">อุปกรณ์การแพทย์</span>
                            <h5 class="fw-bold mb-3">โครงการจัดซื้อเครื่องช่วยหายใจสำหรับทารกแรกเกิด</h5>
                            <p class="text-muted small mb-4 flex-grow-1">เพื่อรองรับผู้ป่วยทารกแรกเกิดที่มีภาวะวิกฤตทางเดินหายใจ...</p>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span class="text-primary">ยอดบริจาค: 450,000 ฿</span>
                                    <span class="text-muted">เป้าหมาย: 1,200,000 ฿</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 37%"></div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-outline-primary w-100 rounded-pill mt-auto">รายละเอียดและร่วมบริจาค</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Dynamic Data -->
                <?php foreach ($data['projects'] as $index => $project): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                        <div class="project-card h-100 d-flex flex-column">
                            <?php 
                            $img = $project['cover_image'] ? $_ENV['APP_URL'] . '/uploads/projects/' . $project['cover_image'] : 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';
                            ?>
                            <img src="<?php echo $img; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($project['name']); ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-4 d-flex flex-column">
                                <h5 class="fw-bold mb-3"><?php echo htmlspecialchars($project['name']); ?></h5>
                                <p class="text-muted small mb-4 flex-grow-1"><?php echo htmlspecialchars(mb_substr($project['description'] ?? 'ร่วมเป็นส่วนหนึ่งในโครงการนี้', 0, 100)); ?>...</p>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small fw-bold mb-1">
                                        <span class="text-primary"><?php echo number_format($project['received_amount'] ?? 0); ?> ฿</span>
                                        <span class="text-muted"><?php echo number_format($project['donation_target'] ?? 0); ?> ฿</span>
                                    </div>
                                    <?php 
                                    $percent = $project['donation_target'] > 0 ? min(100, (($project['received_amount'] ?? 0) / $project['donation_target']) * 100) : 0;
                                    ?>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $percent; ?>%"></div>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-outline-primary w-100 rounded-pill mt-auto">รายละเอียดและร่วมบริจาค</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="<?php echo $_ENV['APP_URL']; ?>/projects" class="btn btn-primary rounded-pill px-4">ดูโครงการทั้งหมด <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background-color: var(--primary-dark);">
    <div class="container my-5 text-center text-white" data-aos="zoom-in">
        <i class="fa-solid fa-hand-holding-heart fa-4x text-accent mb-4"></i>
        <h2 class="display-6 fw-bold mb-4">"การให้...ไม่สิ้นสุด"</h2>
        <p class="lead opacity-75 mb-5 mx-auto" style="max-width: 700px;">
            เงินบริจาคของคุณสามารถนำไปลดหย่อนภาษีได้ 1 เท่า<br>
            มูลนิธิเพื่อโรงพยาบาลปลวกแดง บริหารงานด้วยความโปร่งใส ตรวจสอบได้
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?php echo $_ENV['APP_URL']; ?>/donate" class="btn btn-accent btn-lg rounded-pill px-5 fw-bold shadow">
                ร่วมบริจาค
            </a>
            <a href="<?php echo $_ENV['APP_URL']; ?>/transparency" class="btn btn-outline-light btn-lg rounded-pill px-5">
                ความโปร่งใส
            </a>
        </div>
    </div>
</section>
