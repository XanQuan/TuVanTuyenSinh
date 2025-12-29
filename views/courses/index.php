<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Đào tạo & Kỹ năng</h6>
                <h2>Các Khóa Học Phổ Biến</h2>
            </div>
        </div>
    </div>
</section>

<section class="meetings-page" id="meetings">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php if(isset($courses) && count($courses) > 0): ?>
                        <?php foreach($courses as $c): ?>
                        <div class="col-lg-4 templatemo-item-col all soon mb-4">
                            <div class="meeting-item h-100">
                                <div class="thumb">
                                    <div class="price">
                                        <span><?= htmlspecialchars($c['price'] ?? 'Liên hệ') ?></span>
                                    </div>
                                    <a href="#">
                                        <img src="public/assets/images/<?= htmlspecialchars($c['image'] ?? 'course-01.jpg') ?>" 
                                             alt="<?= htmlspecialchars($c['title']) ?>" 
                                             style="height: 220px; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="down-content">
                                    <a href="#"><h4><?= htmlspecialchars($c['title']) ?></h4></a>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted"><i class="fa fa-user-tie"></i> <?= htmlspecialchars($c['teacher'] ?? 'UniGuide') ?></small>
                                        <small class="text-warning fw-bold"><i class="fa fa-star"></i> <?= $c['rating'] ?? 5.0 ?></small>
                                    </div>

                                    <p class="description border-top pt-3 mt-3">
                                        <?= mb_substr(htmlspecialchars($c['description'] ?? ''), 0, 80) ?>...
                                    </p>
                                    
                                    <div class="main-button-red mt-3">
                                        <a href="#">Đăng ký ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center text-white">
                            <p>Hiện chưa có khóa học nào được mở.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>