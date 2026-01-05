<?php require_once 'views/layouts/header.php'; ?>

<style>
    /* Hiệu ứng Header mượt mà */
    .detail-header {
        position: relative;
        padding: 100px 0;
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        color: #fff;
    }
    .header-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(180deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.8) 100%);
    }

    /* Card hiệu ứng Kính (Glassmorphism) */
    .glass-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 24px !important;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
    }

    /* Ảnh ngành học với hiệu ứng nổi */
    .major-main-img {
        width: 100%;
        max-height: 450px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    /* Sidebar Sticky thông tin */
    .info-item {
        padding: 15px 0;
        border-bottom: 1px dashed #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .info-item:last-child { border-bottom: none; }
    
    .info-label { color: #666; font-weight: 500; }
    .info-value { font-weight: 700; color: #a71d2a; }

    /* Nút bấm hiệu ứng loang màu */
    .btn-gradient {
        background: linear-gradient(90deg, #a71d2a 0%, #d62828 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }
    .btn-gradient:hover {
        filter: brightness(1.1);
        transform: scale(1.02);
        color: white;
        box-shadow: 0 10px 20px rgba(167, 29, 42, 0.3);
    }
</style>

<section class="detail-header" style="background-image: url('public/assets/images/heading-bg.jpg');">
    <div class="header-overlay"></div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="index.php?page=majors" class="text-white-50">Ngành học</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Chi tiết</li>
                    </ol>
                </nav>
                <h6 class="text-uppercase mb-3" style="letter-spacing: 3px; color: #ffcc00;">Thông tin chi tiết ngành học</h6>
                <h1 class="display-4 fw-bold"><?= htmlspecialchars($major['name']) ?></h1>
            </div>
        </div>
    </div>
</section>

<section class="major-details py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card glass-card shadow-sm p-4 mb-4">
                    <img src="public/assets/images/<?= htmlspecialchars($major['image']) ?>" 
                         class="major-main-img mb-4" 
                         alt="<?= htmlspecialchars($major['name']) ?>"
                         onerror="this.src='public/assets/images/meeting-02.jpg'">
                    
                    <div class="d-flex align-items-center mb-4">
                        <div style="width: 5px; height: 35px; background: #a71d2a; margin-right: 15px;"></div>
                        <h3 class="fw-bold m-0">Giới thiệu tổng quan</h3>
                    </div>
                    
                    <div class="content-text" style="line-height: 1.9; font-size: 1.15rem; color: #444; text-align: justify;">
                        <?= nl2br(htmlspecialchars($major['description'])) ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card glass-card shadow-sm p-4 sticky-top" style="top: 110px;">
                    <h4 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 text-danger"></i>Thông tin nhanh
                    </h4>
                    
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Mã nhóm ngành:</span>
                            <span class="info-value"><?= htmlspecialchars($major['group_code']) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Xếp hạng:</span>
                            <span class="text-warning">
                                <?php for($i=0; $i<$major['job_rating']; $i++) echo '<i class="fas fa-star"></i>'; ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Học phí dự kiến:</span>
                            <span class="info-value text-success"><?= htmlspecialchars($major['tuition']) ?></span>
                        </div>
                    </div>
                    
                    <div class="mt-4">
    <p class="small text-muted mb-4 text-center">Đừng bỏ lỡ cơ hội trúng tuyển vào ngành này với hệ thống tư vấn thông minh.</p>
    
    <a href="index.php?page=advice&group=<?= urlencode($major['group_code']) ?>#search-section" 
   class="btn btn-gradient w-100 rounded-pill py-3">
   <i class="fas fa-chart-line me-2"></i>XEM ĐIỂM CHUẨN NGAY
</a>
</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>