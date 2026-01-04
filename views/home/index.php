<?php require_once 'views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --primary-red: #be1e2d;
        --secondary-yellow: #f5a425;
        --dark-bg: #1f272b;
    }

    body { 
        font-family: 'Inter', sans-serif; 
        background-color: #f0f2f5; 
        overflow-x: hidden; 
        scroll-behavior: smooth; 
    }

    /* 1. BANNER VIDEO HIỆN ĐẠI */
    .main-banner { position: relative; overflow: hidden; height: 100vh; }
    #bg-video { width: 100%; height: 100%; object-fit: cover; }
    .video-overlay { 
        background: rgba(0, 0, 0, 0.6); 
        position: absolute; width: 100%; height: 100%; top: 0; 
        display: flex; align-items: center; 
    }
    .caption h2 { font-size: 3.5rem; font-weight: 800; color: #fff; text-transform: uppercase; }
    .caption h2 span { color: var(--secondary-yellow); }

    /* 2. HIỆU ỨNG 3D CHO CÁC Ô CHỌN (TOOL CARDS) */
    .tools-container { perspective: 1500px; }

    .tool-card-link {
        text-decoration: none !important;
        display: block;
        height: 100%;
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .tool-card {
        background: #ffffff;
        border-radius: 30px;
        padding: 45px 30px;
        border: 1px solid rgba(0,0,0,0.03);
        text-align: center;
        position: relative;
        z-index: 1;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s ease;
        height: 100%;
    }

    .tool-card-link:hover {
        transform: translateY(-15px) rotateX(8deg) rotateY(-8deg);
    }

    .tool-card-link:hover .tool-card {
        box-shadow: 25px 40px 80px rgba(190, 30, 45, 0.15);
        border-color: var(--primary-red);
    }

    .icon-box {
        width: 85px; height: 85px;
        background: #fff1f2;
        color: var(--primary-red);
        border-radius: 25px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 25px;
        font-size: 32px;
        transition: all 0.5s ease;
        transform: translateZ(30px); /* Hiệu ứng nổi icon */
    }

    .tool-card-link:hover .icon-box {
        background: var(--primary-red);
        color: #fff;
        transform: scale(1.15) rotate(12deg);
        box-shadow: 0 10px 25px rgba(190, 30, 45, 0.3);
    }

    .tool-card h4 { font-weight: 800; color: #333; margin-bottom: 15px; }
    .btn-text { color: var(--primary-red); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; display: block; margin-top: 20px; }

    /* 3. KHU VỰC TRA CỨU PREMIUM */
    .consulting-wrapper {
        background: linear-gradient(135deg, #a71d2a 0%, #3a0a0e 100%);
        border-radius: 50px; padding: 70px; color: #fff;
        box-shadow: 0 30px 70px rgba(167, 29, 42, 0.4);
    }

    .input-premium {
        background: rgba(255, 255, 255, 0.12) !important;
        border: 2px solid rgba(255, 255, 255, 0.25) !important;
        border-radius: 25px !important; 
        padding: 18px 25px !important;
        color: #ffffff !important;
        font-size: 1.1rem;
        transition: all 0.4s ease;
        backdrop-filter: blur(15px);
        width: 100%;
        outline: none;
    }

    .input-premium:focus {
        background: rgba(255, 255, 255, 0.22) !important;
        border-color: var(--secondary-yellow) !important;
        box-shadow: 0 0 25px rgba(245, 164, 37, 0.3) !important;
    }

    .input-premium option { color: #333; background: #fff; }

    /* 4. KẾT QUẢ UNI-ITEM */
    .result-box {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 35px; color: #333; padding: 40px;
        height: 100%; min-height: 500px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .uni-item {
        background: #ffffff; border-radius: 20px; padding: 25px;
        margin-bottom: 20px; border-left: 6px solid var(--primary-red);
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .uni-item:hover { transform: scale(1.02) translateX(10px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }

    .btn-glow:hover {
        box-shadow: 0 0 30px rgba(245, 164, 37, 0.6);
        transform: translateY(-3px);
    }
</style>

<section class="main-banner" id="top">
    <video autoplay muted loop id="bg-video">
        <source src="public/assets/images/course-video.mp4" type="video/mp4" />
    </video>
    <div class="video-overlay">
        <div class="container text-center">
            <div class="caption">
                <h6 class="text-white-50 text-uppercase letter-spacing-2">Kiến tạo tương lai cùng UniGuide</h6>
                <h2>Hệ Thống <span>Tư Vấn Tuyển Sinh</span> AI</h2>
                <p class="text-white opacity-75 fs-5 mb-5 mx-auto" style="max-width: 700px;">
                    Định hướng nghề nghiệp thông minh dựa trên mô hình tâm lý học Holland và thuật toán phân tích điểm chuẩn chính xác nhất.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="#consulting" class="btn btn-danger rounded-pill px-5 py-3 fw-bold shadow">🔍 TRA CỨU ĐIỂM</a>
                    <a href="index.php?page=assessment" class="btn btn-warning rounded-pill px-5 py-3 fw-bold shadow">🧩 TEST HOLLAND</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="tools">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark" style="font-size: 2.8rem;">Hệ sinh thái <span class="text-danger">UniGuide</span></h2>
            <p class="text-muted fs-5">Lựa chọn công cụ phù hợp để bắt đầu hành trình đại học của bạn</p>
        </div>
        
        <div class="row g-4 tools-container">
            <div class="col-lg-4 col-md-6">
                <a href="index.php?page=assessment" class="tool-card-link">
                    <div class="tool-card">
                        <div class="icon-box"><i class="fas fa-brain"></i></div>
                        <h4>Trắc Nghiệm</h4>
                        <p class="text-muted">Khám phá bản thân qua 6 nhóm tính cách Holland để chọn đúng ngành nghề.</p>
                        <span class="btn-text">BẮT ĐẦU NGAY →</span>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="index.php?page=majors" class="tool-card-link">
                    <div class="tool-card">
                        <div class="icon-box"><i class="fas fa-graduation-cap"></i></div>
                        <h4>Ngành Đào Tạo</h4>
                        <p class="text-muted">Cập nhật thông tin chi tiết về các nhóm ngành triển vọng năm 2026.</p>
                        <span class="btn-text">KHÁM PHÁ NGÀNH →</span>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="#consulting" class="tool-card-link">
                    <div class="tool-card">
                        <div class="icon-box"><i class="fas fa-chart-bar"></i></div>
                        <h4>Tra Cứu Điểm</h4>
                        <p class="text-muted">Dựa trên điểm thi để tìm trường có tỷ lệ đậu cao nhất cho bạn.</p>
                        <span class="btn-text">TRA CỨU NGAY →</span>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="index.php?page=events" class="tool-card-link">
                    <div class="tool-card">
                        <div class="icon-box"><i class="fas fa-calendar-alt"></i></div>
                        <h4>Sự Kiện</h4>
                        <p class="text-muted">Tham gia các buổi workshop tư vấn trực tiếp cùng đại diện các trường.</p>
                        <span class="btn-text">XEM LỊCH TRÌNH →</span>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="index.php?page=compare" class="tool-card-link">
                    <div class="tool-card">
                        <div class="icon-box"><i class="fas fa-balance-scale"></i></div>
                        <h4>So Sánh</h4>
                        <p class="text-muted">Đặt lên bàn cân các ngôi trường về học phí, môi trường và đầu ra.</p>
                        <span class="btn-text">SO SÁNH NGAY →</span>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="index.php?page=resources" class="tool-card-link">
                    <div class="tool-card">
                        <div class="icon-box"><i class="fas fa-book-open"></i></div>
                        <h4>Tài Nguyên</h4>
                        <p class="text-muted">Kho đề thi thử, tài liệu ôn thi THPT Quốc gia đạt điểm tối ưu.</p>
                        <span class="btn-text">TẢI VỀ NGAY →</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="container pb-5" id="consulting">
    <div class="consulting-wrapper">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <h2 class="fw-bold mb-4"><i class="fas fa-robot text-warning me-2"></i>UniBot AI</h2>
                <p class="mb-5 fs-5 opacity-75">UniBot đang sử dụng dữ liệu tuyển sinh thực tế để phân tích cơ hội cho bạn.</p>
                
                <form method="POST" action="index.php?page=advice&action=result#consulting">
                    <div class="mb-4">
                        <label class="fw-bold text-warning small mb-2 text-uppercase">Tổng điểm thi dự kiến (3 môn)</label>
                        <input type="number" step="0.01" name="score" class="input-premium" 
                               placeholder="Ví dụ: 25.50" required 
                               value="<?= isset($_POST['score']) ? htmlspecialchars($_POST['score']) : '' ?>">
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-warning small mb-2 text-uppercase">Lĩnh vực bạn quan tâm</label>
                        <select name="group" class="input-premium" required>
                            <option value="" disabled selected>-- Chọn nhóm ngành --</option>
                            <?php if (!empty($major_groups)): foreach ($major_groups as $g): ?>
                                <option value="<?= $g['group_code'] ?>" <?= (isset($_POST['group']) && $_POST['group'] == $g['group_code']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($g['group_name']) ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <button type="submit" name="submit_advice" class="btn btn-warning w-100 py-3 rounded-pill fw-bold btn-glow" style="font-size: 1.1rem;">
                        🚀 PHÂN TÍCH CƠ HỘI NGAY
                    </button>
                </form>
            </div>

            <div class="col-lg-7">
                <div class="result-box">
                    <?php if (isset($results)): ?>
                        <h5 class="fw-bold mb-4 text-dark">Kết quả phù hợp nhất:</h5>
                        <div class="scroll-results" style="max-height: 450px; overflow-y: auto;">
                            <?php if (count($results) > 0): foreach ($results as $row): ?>
                                <div class="uni-item shadow-sm">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-bold text-danger mb-1"><?= htmlspecialchars($row['uni_name']) ?></h6>
                                        <span class="badge bg-success rounded-pill px-3">Tỷ lệ đậu cao</span>
                                    </div>
                                    <p class="small text-muted mb-2"><i class="fas fa-check-circle me-1"></i> Ngành: <?= htmlspecialchars($row['major_name']) ?></p>
                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                        <span class="small">Điểm chuẩn: <strong><?= $row['score'] ?></strong></span>
                                        <span class="text-primary fw-bold small">Dư: +<?= round($searchScore - $row['score'], 2) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-search-minus fa-3x text-muted mb-3 opacity-50"></i>
                                    <p class="text-muted">Không tìm thấy trường phù hợp. Thử lại với ngành khác nhé!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 h-100 d-flex flex-column justify-content-center align-items-center">
                            <img src="https://cdn-icons-png.flaticon.com/512/6104/6104865.png" width="150" class="mb-4 opacity-50">
                            <h5 class="fw-bold text-muted">Đang chờ dữ liệu đầu vào...</h5>
                            <p class="small text-muted px-5">UniBot cần bạn nhập điểm và chọn ngành để bắt đầu so sánh cơ sở dữ liệu.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white pt-5 mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4 text-warning">UniGuide 2026</h4>
                <p class="opacity-75">Hệ thống tư vấn tuyển sinh thông minh hàng đầu Việt Nam, giúp học sinh chạm tay tới ước mơ.</p>
            </div>
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4 text-warning">Truy cập nhanh</h4>
                <ul class="list-unstyled opacity-75">
                    <li class="mb-2"><a href="index.php?page=assessment" class="text-white text-decoration-none">Làm trắc nghiệm Holland</a></li>
                    <li class="mb-2"><a href="index.php?page=universities" class="text-white text-decoration-none">Danh sách trường đại học</a></li>
                    <li><a href="index.php?page=advice" class="text-white text-decoration-none">Tư vấn chọn trường</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4 text-warning">Hỗ trợ</h4>
                <p class="opacity-75 mb-1"><i class="fas fa-envelope me-2"></i> info@uniguide.edu.vn</p>
                <p class="opacity-75"><i class="fas fa-phone me-2"></i> 1900 8888</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/scrollreveal"></script>
<script>
    ScrollReveal().reveal('.tool-card-link', { 
        delay: 200, distance: '50px', origin: 'bottom', interval: 100,
        rotate: { x: 15, z: 0 }, opacity: 0, easing: 'cubic-bezier(0.5, 0, 0, 1)'
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?>