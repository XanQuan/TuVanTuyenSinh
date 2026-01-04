<?php require_once 'views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary-red: #be1e2d;
        --secondary-yellow: #f5a425;
        --dark-bg: #1f272b;
    }

    body { font-family: 'Inter', sans-serif; background-color: #f8faff; }

    /* BANNER VIDEO HIỆN ĐẠI */
    .main-banner { position: relative; overflow: hidden; height: 100vh; }
    #bg-video { width: 100%; height: 100%; object-fit: cover; }
    .video-overlay { 
        background: rgba(0, 0, 0, 0.6); 
        position: absolute; width: 100%; height: 100%; top: 0; 
        display: flex; align-items: center; 
    }
    .caption h2 { font-size: 3.5rem; font-weight: 800; color: #fff; text-transform: uppercase; }
    .caption h2 span { color: var(--secondary-yellow); }

    /* NÚT BẤM STYLE MỚI */
    .btn-custom {
        padding: 15px 35px; border-radius: 50px; font-weight: 700;
        transition: 0.3s; display: inline-block; text-decoration: none; border: none;
    }
    .btn-red { background: var(--primary-red); color: #fff; }
    .btn-yellow { background: var(--secondary-yellow); color: #fff; }
    .btn-outline { background: rgba(255,255,255,0.2); color: #fff; border: 1px solid #fff; backdrop-filter: blur(5px); }
    .btn-custom:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); color: #fff; }

    /* CÔNG CỤ HỖ TRỢ (Grid Layout) */
    .tool-card {
        background: #fff; border-radius: 24px; padding: 40px 30px;
        transition: 0.3s; border: 1px solid #eee; text-align: center;
    }
    .tool-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
    .icon-box { 
        width: 70px; height: 70px; background: #fff1f2; color: var(--primary-red);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 24px;
    }

    /* KHU VỰC TRA CỨU THÔNG MINH */
    .consulting-wrapper {
        background: linear-gradient(135deg, #a71d2a 0%, #3a0a0e 100%);
        border-radius: 40px; padding: 60px; color: #fff;
    }
    .glass-input {
        background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
        border-radius: 15px; padding: 12px 20px; color: #fff; width: 100%;
    }
    .glass-input::placeholder { color: rgba(255,255,255,0.5); }
    
    /* KẾT QUẢ DẠNG LIST CÓ CUỘN */
    .result-box {
        background: #fff; border-radius: 24px; color: #333; padding: 30px;
        height: 100%; min-height: 450px;
    }
    .scroll-results { max-height: 400px; overflow-y: auto; padding-right: 10px; }
    .uni-item {
        background: #f8fafc; border-radius: 15px; padding: 20px;
        margin-bottom: 15px; border-left: 5px solid var(--primary-red);
    }
    .form-label-highlight {
        color: #ffeb3b !important; 
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        margin-bottom: 10px;
        display: block;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    /* Ô nhập liệu với độ tương phản cao */
    .glass-input-premium {
        background: rgba(255, 255, 255, 0.15) !important;
        border: 2px solid rgba(255, 255, 255, 0.4) !important;
        border-radius: 15px;
        padding: 14px 20px;
        color: #ffffff !important; /* Chữ khi gõ vào là màu trắng tinh */
        width: 100%;
        font-weight: 600;
        transition: 0.3s;
        outline: none;
    }

    .glass-input-premium:focus {
        border-color: #ffeb3b !important;
        background: rgba(255, 255, 255, 0.25) !important;
    }

    /* Sửa lỗi chữ bị che trong danh sách chọn (Select) */
    .glass-input-premium option {
        color: #333333 !important; /* Chữ trong list màu đen */
        background-color: #ffffff !important; /* Nền trong list màu trắng */
    }
    /* Nhãn tiêu đề nghệ thuật màu vàng chanh */
    .form-label-premium {
        color: #ffeb3b !important;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1.2px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .form-label-premium i { margin-right: 10px; font-size: 1.1rem; }

    /* Ô nhập liệu & Select bo góc 25px */
    .input-premium {
        background: rgba(255, 255, 255, 0.12) !important;
        border: 2px solid rgba(255, 255, 255, 0.3) !important;
        border-radius: 25px !important; 
        padding: 16px 25px !important;
        color: #ffffff !important;
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        transition: all 0.4s ease !important;
        backdrop-filter: blur(12px);
        width: 100%;
        appearance: none; /* Xóa style mặc định của trình duyệt */
    }

    .input-premium:focus {
        background: rgba(255, 255, 255, 0.25) !important;
        border-color: #ffeb3b !important;
        box-shadow: 0 0 25px rgba(255, 235, 59, 0.3) !important;
        outline: none;
    }

    /* Sửa lỗi chữ bị che trong danh sách chọn */
    .input-premium option {
        color: #1a202c !important;
        background: #ffffff !important;
        padding: 15px !important;
    }

    /* Nút bấm Phân tích tỏa sáng */
    .btn-analyze-premium {
        background: linear-gradient(90deg, #ffeb3b 0%, #f5a425 100%) !important;
        color: #8b0000 !important;
        border: none !important;
        border-radius: 25px !important;
        padding: 18px !important;
        font-weight: 900 !important;
        font-size: 1.2rem !important;
        text-transform: uppercase;
        transition: 0.4s !important;
        box-shadow: 0 12px 30px rgba(245, 164, 37, 0.4) !important;
    }

    .btn-analyze-premium:hover {
        transform: scale(1.03) translateY(-3px);
        box-shadow: 0 15px 40px rgba(245, 164, 37, 0.6) !important;
    }
    .btn-outline-danger {
    border: 1.5px solid var(--primary-red);
    color: var(--primary-red);
    font-weight: 600;
    transition: 0.3s;
}

.btn-outline-danger:hover {
    background-color: var(--primary-red);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(190, 30, 45, 0.2);
}
</style>

<section class="main-banner" id="top">
    <video autoplay muted loop id="bg-video">
        <source src="public/assets/images/course-video.mp4" type="video/mp4" />
    </video>
    <div class="video-overlay">
        <div class="container text-center">
            <div class="caption">
                <h6>Chào mừng bạn đến với UniGuide</h6>
                <h2>Hệ Thống <span>Tư Vấn Tuyển Sinh</span></h2>
                <p class="text-white opacity-75 fs-5 mb-5">Khám phá ngôi trường đại học mơ ước dựa trên năng lực và sở thích của riêng bạn.</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="#consulting" class="btn-custom btn-red">🔍 Tra cứu ngay</a>
                    <a href="index.php?page=assessment" class="btn-custom btn-yellow">🧩 Test Năng lực</a>
                    <a href="index.php?page=compare" class="btn-custom btn-outline">⚖️ So sánh</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="tools">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Công cụ hỗ trợ thí sinh</h2>
            <p class="text-muted">Lựa chọn công cụ phù hợp để định hướng tương lai</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="tool-card">
                    <div class="icon-box"><i class="fas fa-user-astronaut"></i></div>
                    <h4>Trắc Nghiệm </h4>
                    <p>Khám phá bản thân qua 6 nhóm tính cách Holland để chọn nghề chuẩn xác nhất.</p>
                    <a href="index.php?page=assessment" class="btn btn-link text-danger fw-bold">Bắt đầu ngay →</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="tool-card">
                    <div class="icon-box"><i class="fas fa-university"></i></div>
                    <h4>Tra Cứu Điểm Chuẩn</h4>
                    <p>Phân tích điểm số của bạn để gợi ý danh sách các trường có tỷ lệ đậu cao nhất.</p>
                    <a href="#consulting" class="btn btn-link text-danger fw-bold">Khám phá ngay →</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="tool-card">
                    <div class="icon-box"><i class="fas fa-balance-scale"></i></div>
                    <h4>So Sánh Trường</h4>
                    <p>Đặt các ngôi trường lên bàn cân về học phí, cơ sở vật chất và cơ hội việc làm.</p>
                    <a href="index.php?page=compare" class="btn btn-link text-danger fw-bold">So sánh ngay →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container pb-5" id="consulting">
    <div class="consulting-wrapper">
        <div class="row g-5">
            <div class="col-lg-5">
                <h3 class="fw-bold mb-4 text-white">Trợ lý ảo UniGuide</h3>
                <p class="mb-5 opacity-75">Hãy nhập thông tin để chúng tôi bắt đầu phân tích dữ liệu cho bạn.</p>
               <form method="POST" action="index.php?page=advice&action=result#consulting">
    <div class="mb-4">
        <label class="form-label-highlight">TỔNG ĐIỂM THI (3 MÔN)</label>
        <input type="number" step="0.01" name="score" class="glass-input-premium" 
               placeholder="Ví dụ: 25.75" required>
    </div>

    <div class="mb-4">
    <label class="form-label-premium">
        <i class="fa-solid fa-layer-group"></i> NHÓM NGÀNH QUAN TÂM
    </label>
    <div style="position: relative;">
       <select name="group" class="input-premium">
    <option value="" disabled selected>-- Chọn lĩnh vực bạn yêu thích --</option>
    <?php if (isset($major_groups) && count($major_groups) > 0): ?>
        <?php foreach ($major_groups as $g): ?>
            <option value="<?= $g['group_code'] ?>">
                <?= htmlspecialchars($g['group_name']) ?>
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>
        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); color: #fff; pointer-events: none;"></i>
    </div>
</div>

    <button type="submit" name="submit_advice" class="btn-custom btn-yellow w-100" 
            style="color: #000 !important; font-weight: 800;">
        PHÂN TÍCH DỮ LIỆU NGAY
    </button>
</form>
            </div>

            <div class="col-lg-7">
                <div class="result-box">
                    <?php if (isset($results)): ?>
                        <h5 class="fw-bold mb-4">Kết quả phù hợp cho mức điểm <?= htmlspecialchars($searchScore) ?>:</h5>
                        <div class="scroll-results">
                            <?php if (count($results) > 0): ?>
                                <?php foreach ($results as $row): ?>
                                    <div class="uni-item shadow-sm">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold text-danger m-0"><?= $row['uni_name'] ?></h6>
                                            <span class="badge bg-success rounded-pill">Tỷ lệ đậu cao</span>
                                        </div>
                                        <p class="small text-muted mb-1 mt-2">Ngành: <strong><?= $row['major_name'] ?></strong></p>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="small">Điểm chuẩn: <b><?= $row['score'] ?></b></span>
                                            <span class="small text-primary">Chênh lệch: +<?= round($searchScore - $row['score'], 2) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                                    <p>Không tìm thấy trường phù hợp. Hãy thử thay đổi ngành học!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <img src="public/assets/images/search-illustration.png" style="max-width: 200px;" class="mb-4">
                            <h5>UniBot đang chờ thông tin...</h5>
                            <p class="text-muted">Nhập điểm ở khung bên trái để nhận gợi ý.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white pt-5">
    <div class="container">
        <div class="row g-4 pb-5">
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4">UniGuide</h4>
                <p class="opacity-75">Hệ thống hỗ trợ thí sinh chọn trường đại học dựa trên năng lực thực tế. Luôn đồng hành cùng bạn trên con đường chinh phục tri thức.</p>
            </div>
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4">Liên hệ</h4>
                <ul class="list-unstyled opacity-75">
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> 090.123.4567</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@uniguide.edu.vn</li>
                    <li><i class="fas fa-map-marker-alt me-2"></i> TP. Hồ Chí Minh</li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4">Bản tin</h4>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Email của bạn">
                    <button class="btn btn-danger">Đăng ký</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-center py-4">
            <p class="m-0 small">Copyright © 2025 UniGuide System. Designed by <strong>Minh Quan</strong></p>
        </div>
    </div>
</footer>

<?php require_once 'views/layouts/footer.php'; ?>