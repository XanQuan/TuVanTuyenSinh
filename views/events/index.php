<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Cập nhật mới nhất</h6>
                <h2>Lịch Sự Kiện & Hội Thảo</h2>
            </div>
        </div>
    </div>
</section>

<section class="meetings-page" id="meetings">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php if(isset($events) && count($events) > 0): ?>
                        <?php foreach($events as $ev): ?>
                        <div class="col-lg-4 templatemo-item-col all soon">
                            <div class="meeting-item">
                                <div class="thumb">
                                    <div class="price">
                                        <span><?= htmlspecialchars($ev['price'] ?? 'Miễn phí') ?></span>
                                    </div>
                                    <a href="#">
                                        <img src="public/assets/images/<?= htmlspecialchars($ev['image'] ?? 'meeting-01.jpg') ?>" 
                                             alt="<?= htmlspecialchars($ev['title'] ?? '') ?>" 
                                             style="height: 220px; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="down-content">
                                    <div class="date">
                                        <h6>Tháng <span><?= date('m', strtotime($ev['event_date'] ?? 'now')) ?></span></h6>
                                    </div>
                                    <a href="#"><h4><?= htmlspecialchars($ev['title'] ?? 'Sự kiện mới') ?></h4></a>
                                    <p class="description">
                                        <i class="fa fa-map-marker"></i> <?= htmlspecialchars($ev['location'] ?? 'Online') ?><br>
                                        <?= mb_substr(htmlspecialchars($ev['description'] ?? ''), 0, 80) ?>...
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center text-white"><p>Hiện chưa có sự kiện nào.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>