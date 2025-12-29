<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Mạng lưới kết nối</h6>
                <h2>Đội Ngũ Chuyên Gia & Cựu Sinh Viên</h2>
            </div>
        </div>
    </div>
</section>

<section class="our-courses" id="courses" style="padding-top: 100px;">
    <div class="container">
        <div class="row">
            <?php if(isset($mentors) && count($mentors) > 0): ?>
                <?php foreach($mentors as $m): ?>
                <div class="col-lg-4 mb-4">
                    <div class="item">
                        <img src="public/assets/images/<?= htmlspecialchars($m['image'] ?? 'course-01.jpg') ?>" 
                             alt="Mentor" style="height: 300px; object-fit: cover;">
                        
                        <div class="down-content">
                            <h4><?= htmlspecialchars($m['name'] ?? 'Chuyên gia tư vấn') ?></h4>
                            <p class="text-danger fw-bold mb-2"><?= htmlspecialchars($m['expertise'] ?? 'Cố vấn chuyên môn') ?></p>
                            
                            <div class="info">
                                <div class="row">
                                    <div class="col-12">
                                        <p><?= htmlspecialchars($m['bio'] ?? 'Chuyên gia giàu kinh nghiệm.') ?></p>
                                    </div>
                                    <div class="col-12 mt-3 text-center">
                                        <div class="main-button-red">
                                            <a href="mailto:<?= htmlspecialchars($m['email'] ?? '#') ?>">Liên hệ ngay</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>Đang cập nhật danh sách chuyên gia.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>