<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Kho dữ liệu học tập</h6>
                <h2>Thư Viện Tài Nguyên</h2>
            </div>
        </div>
    </div>
</section>

<section class="meetings-page" id="meetings">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php if(isset($resources) && count($resources) > 0): ?>
                        <?php foreach($resources as $res): ?>
                        <div class="col-lg-6 mb-4">
                            <div class="meeting-item">
                                <div class="down-content" style="border-radius: 20px; padding: 40px;">
                                    <div class="row align-items-center">
                                        <div class="col-md-3 text-center mb-3 mb-md-0">
                                            <?php 
                                                $type = $res['type'] ?? 'Doc';
                                                if(stripos($type, 'Video') !== false): 
                                            ?>
                                                <i class="fas fa-play-circle fa-4x text-danger"></i>
                                            <?php elseif(stripos($type, 'PDF') !== false): ?>
                                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            <?php else: ?>
                                                <i class="fas fa-folder-open fa-4x text-warning"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-9">
                                            <h4><?= htmlspecialchars($res['title'] ?? 'Tài liệu') ?></h4>
                                            <span class="badge bg-secondary mb-2"><?= htmlspecialchars($type) ?></span>
                                            <p><?= htmlspecialchars($res['description'] ?? 'Mô tả tài liệu.') ?></p>
                                            
                                            <div class="main-button-yellow mt-3">
                                                <a href="<?= htmlspecialchars($res['link'] ?? '#') ?>" target="_blank">Xem / Tải về</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center text-white"><p>Chưa có tài liệu nào.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>