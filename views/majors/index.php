<?php require_once 'views/layouts/header.php'; ?>

<?php $highlight_code = isset($_GET['highlight']) ? $_GET['highlight'] : ''; ?>

<section class="heading-page header-text" id="top" style="background-image: url('public/assets/images/meetings-bg.jpg'); background-attachment: fixed; position: relative;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row">
            <div class="col-lg-12">
                <h6 class="text-uppercase" style="letter-spacing: 2px; color: #f1f1f1;">Danh mục đào tạo</h6>
                <h2 style="font-weight: 800; text-transform: uppercase;">
                    <?= $highlight_code ? "Ngành Học Phù Hợp Với Bạn" : "Danh Sách Ngành Nghề Hot" ?>
                </h2>
            </div>
        </div>
    </div>
</section>

<section class="meetings-page" id="meetings" style="background: #f4f7f6; padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php if(isset($majors) && count($majors) > 0): ?>
                        <?php foreach($majors as $m): ?>
                            
                            <?php $is_suggested = ($m['group_code'] == $highlight_code); ?>

                            <div class="col-lg-4 mb-5">
                                <a href="index.php?page=majors&action=detail&id=<?= $m['id'] ?>" class="text-decoration-none h-100 d-block">
                                    
                                    <div class="major-card-custom h-100 <?= $is_suggested ? 'highlight-active' : '' ?>">
                                        <div class="thumb-wrapper">
                                            <?php 
                                                $imgName = !empty($m['image']) ? $m['image'] : 'meeting-02.jpg'; 
                                                $imgPath = "public/assets/images/" . $imgName;
                                            ?>
                                            <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($m['name']) ?>" 
                                                 class="img-fluid main-img"
                                                 onerror="this.src='public/assets/images/meeting-02.jpg'">
                                            
                                            <?php if($is_suggested): ?>
                                                <div class="star-badge"><i class="fa fa-star me-1"></i> PHÙ HỢP NHẤT</div>
                                            <?php endif; ?>

                                            <?php if(!empty($m['group_code'])): ?>
                                                <div class="group-badge"><?= htmlspecialchars($m['group_code']) ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="down-content">
                                            <h4 class="title"><?= htmlspecialchars($m['name']) ?></h4>
                                            <div class="info-row">
                                                <span class="code-text"><i class="fa fa-barcode me-1"></i> Mã ngành: <?= htmlspecialchars($m['code'] ?? 'Chưa cập nhật') ?></span>
                                            </div>
                                            
                                            <p class="description">
                                                <?= mb_substr(htmlspecialchars($m['description'] ?? 'Ngành học đang được quan tâm hàng đầu hiện nay.'), 0, 100) ?>...
                                            </p>
                                            
                                            <div class="action-footer mt-auto">
                                                <div class="btn-main <?= $is_suggested ? 'btn-red' : '' ?>">
                                                    <span>XEM CHI TIẾT NGÀNH</span>
                                                    <i class="fa fa-arrow-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <div class="empty-state">
                                <i class="fa fa-folder-open fa-3x mb-3 text-muted"></i>
                                <p class="text-muted">Đang cập nhật dữ liệu ngành học.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* --- GIỮ NGUYÊN STYLE CŨ CỦA BẠN --- */
    .major-card-custom {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .major-card-custom:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(167, 29, 42, 0.15); 
    }
    .thumb-wrapper { position: relative; height: 220px; overflow: hidden; }
    .main-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .major-card-custom:hover .main-img { transform: scale(1.1); }
    .group-badge { position: absolute; top: 15px; left: 15px; background: #a71d2a; color: #fff; padding: 5px 15px; border-radius: 30px; font-size: 12px; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    .down-content { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
    .title { font-size: 20px; font-weight: 700; color: #1f272b; margin-bottom: 12px; line-height: 1.4; }
    .code-text { color: #a71d2a; font-weight: 600; font-size: 13px; display: block; margin-bottom: 15px; }
    .description { color: #777; font-size: 14px; line-height: 1.6; margin-bottom: 25px; }
    .btn-main { background: #1f272b; color: #fff !important; display: flex; align-items: center; justify-content: center; padding: 12px 20px; border-radius: 12px; font-weight: 600; font-size: 14px; transition: all 0.3s ease; gap: 10px; }
    .empty-state { background: #fff; padding: 50px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }

    /* --- STYLE BỔ SUNG CHO NGÀNH GỢI Ý --- */
    .highlight-active {
        border: 2px solid #be1e2d !important; /* Viền đỏ nổi bật */
        background: #fffdfd !important;
        transform: scale(1.02);
        box-shadow: 0 15px 30px rgba(190, 30, 45, 0.1) !important;
    }

    .star-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #28a745; /* Màu xanh lá cây tin cậy */
        color: white;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 800;
        z-index: 10;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .btn-red {
        background: #be1e2d !important;
    }
</style>

<?php require_once 'views/layouts/footer.php'; ?>