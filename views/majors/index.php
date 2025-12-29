<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Danh mục đào tạo</h6>
                <h2>Danh Sách Ngành Nghề Hot</h2>
            </div>
        </div>
    </div>
</section>

<section class="meetings-page" id="meetings">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php if(isset($majors) && count($majors) > 0): ?>
                        <?php foreach($majors as $m): ?>
                        <div class="col-lg-4 mb-4">
                            <div class="meeting-item h-100">
                                <div class="thumb">
                                    <img src="public/assets/images/meeting-02.jpg" alt="Major" style="height: 200px; object-fit: cover;">
                                </div>
                                <div class="down-content h-100 d-flex flex-column">
                                    <h4 class="mb-2"><?= htmlspecialchars($m['name']) ?></h4>
                                    <p class="text-danger fw-bold small">Mã ngành: <?= htmlspecialchars($m['code']) ?></p>
                                    <p class="flex-grow-1">
                                        <?= htmlspecialchars($m['description'] ?? 'Ngành học đang được quan tâm hàng đầu hiện nay.') ?>
                                    </p>
                                    <div class="main-button-red mt-3">
                                        <a href="index.php?page=advice&group=<?= htmlspecialchars($m['code']) ?>">Xem điểm chuẩn</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center text-white"><p>Đang cập nhật dữ liệu ngành học.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>