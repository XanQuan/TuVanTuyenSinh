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
                            <div class="meeting-item shadow-sm" style="border-radius: 20px; transition: 0.3s;">
                                <div class="down-content" style="border-radius: 20px; padding: 40px; background: #fff;">
                                    <div class="row align-items-center">
                                        <div class="col-md-3 text-center mb-3 mb-md-0">
                                            <?php 
                                                $type = $res['type'] ?? 'Doc';
                                                // Hiển thị Icon dựa trên loại tài liệu
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
                                            
                                            <div class="main-button-yellow mt-3 d-flex gap-2">
                                                <?php 
                                                    $file_name = $res['file_link'];
                                                    
                                                    // LOGIC QUAN TRỌNG: Kiểm tra link ngoài hay file nội bộ
                                                    if (strpos($file_name, 'http') !== false) {
                                                        // Nếu là link Youtube/Drive thì giữ nguyên
                                                        $final_url = $file_name;
                                                        $is_external = true;
                                                    } else {
                                                        // Nếu là file trong máy, nối thêm đường dẫn thư mục documents
                                                        $final_url = "public/assets/documents/" . $file_name;
                                                        $is_external = false;
                                                    }
                                                ?>

                                                <?php if(!empty($file_name)): ?>
                                                    <a href="<?= htmlspecialchars($final_url) ?>" target="_blank" class="btn btn-warning shadow-sm">
                                                        <i class="fa <?= $is_external ? 'fa-play' : 'fa-eye' ?> me-2"></i>
                                                        <?= $is_external ? 'XEM VIDEO' : 'XEM TRỰC TIẾP' ?>
                                                    </a>
                                                    
                                                    <?php if(!$is_external): ?>
                                                    <a href="<?= htmlspecialchars($final_url) ?>" download class="btn btn-outline-warning shadow-sm">
                                                        <i class="fa fa-download me-2"></i>TẢI VỀ MÁY
                                                    </a>
                                                    <?php endif; ?>

                                                <?php else: ?>
                                                    <button class="btn btn-secondary disabled" title="Tài liệu đang cập nhật">
                                                        <i class="fa fa-lock me-2"></i>CHƯA CÓ FILE
                                                    </button>
                                                <?php endif; ?>
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