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
        height: 100%; /* Để các thẻ bằng nhau */
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
        box-shadow: 0 20px 50px rgba(167, 29, 42, 0.3);
    }
    
    /* KẾT QUẢ DẠNG LIST CÓ CUỘN */
    .result-box {
        background: #fff; border-radius: 24px; color: #333; padding: 30px;
        height: 100%; min-height: 450px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .scroll-results { 
        max-height: 400px; 
        overflow-y: auto; 
        padding-right: 10px; 
    }
    /* Tùy chỉnh thanh cuộn cho đẹp */
    .scroll-results::-webkit-scrollbar { width: 6px; }
    .scroll-results::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .scroll-results::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    .scroll-results::-webkit-scrollbar-thumb:hover { background: var(--primary-red); }

    .uni-item {
        background: #f8fafc; border-radius: 15px; padding: 20px;
        margin-bottom: 15px; border-left: 5px solid var(--primary-red);
        transition: transform 0.2s;
    }
    .uni-item:hover { transform: translateX(5px); }

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
        color: #ffffff !important; 
        width: 100%;
        font-weight: 600;
        transition: 0.3s;
        outline: none;
    }

    .glass-input-premium:focus {
        border-color: #ffeb3b !important;
        background: rgba(255, 255, 255, 0.25) !important;
    }
    /* Placeholder màu trắng mờ */
    .glass-input-premium::placeholder { color: rgba(255, 255, 255, 0.7) !important; }

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
        cursor: pointer;
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
        font-weight: 500;
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
                    <h4>Trắc Nghiệm</h4>
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
                               placeholder="Ví dụ: 25.75" required 
                               value="<?= isset($_POST['score']) ? htmlspecialchars($_POST['score']) : '' ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label-premium">
                            <i class="fa-solid fa-layer-group"></i> NHÓM NGÀNH QUAN TÂM
                        </label>
                        <div style="position: relative;">
                            <select name="group" class="input-premium" required>
                                <option value="" disabled selected>-- Chọn lĩnh vực bạn yêu thích --</option>
                                
                                <?php if (isset($major_groups) && is_array($major_groups) && count($major_groups) > 0): ?>
                                    <?php foreach ($major_groups as $g): ?>
                                        <?php 
                                            // Tự động tìm ID (thử các trường hợp phổ biến: group_code, code, id...)
                                            $val = $g['group_code'] ?? $g['code'] ?? $g['id'] ?? '';

                                            // Tự động tìm Tên hiển thị (group_name, name, ten_nhom...)
                                            $name = $g['group_name'] ?? $g['name'] ?? $g['ten_nhom'] ?? 'Chưa đặt tên';
                                        ?>
                                        <option value="<?= htmlspecialchars($val) ?>" 
                                            <?= (isset($_POST['group']) && $_POST['group'] == $val) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>Đang cập nhật dữ liệu...</option>
                                <?php endif; ?>
                            </select>
                            <i class="fa-solid fa-chevron-down" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); color: #fff; pointer-events: none;"></i>
                        </div>
                    </div>

                    <button type="submit" name="submit_advice" class="btn-custom btn-yellow w-100" 
                            style="color: #000 !important; font-weight: 800; box-shadow: 0 10px 25px rgba(245, 164, 37, 0.4);">
                        PHÂN TÍCH DỮ LIỆU NGAY
                    </button>
                </form>
            </div>

            <div class="col-lg-7">
                <div class="result-box">
                    <?php if (isset($results)): ?>
                        <h5 class="fw-bold mb-4">
                            Kết quả phù hợp cho mức điểm <span class="text-danger"><?= htmlspecialchars($searchScore) ?></span>:
                        </h5>
                        
                        <div class="scroll-results">
                            <?php if (count($results) > 0): ?>
                                <?php foreach ($results as $row): ?>
                                    <div class="uni-item shadow-sm">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold text-danger m-0 mb-1"><?= htmlspecialchars($row['uni_name']) ?></h6>
                                                <p class="small text-muted mb-0"><i class="fas fa-graduation-cap me-1"></i> Ngành: <strong><?= htmlspecialchars($row['major_name']) ?></strong></p>
                                            </div>
                                            <span class="badge bg-success rounded-pill px-3 py-2">Tỷ lệ đậu cao</span>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-secondary-subtle">
                                            <span class="small fw-bold">Điểm chuẩn: <b class="text-dark fs-6"><?= $row['score'] ?></b></span>
                                            <?php $diff = round($searchScore - $row['score'], 2); ?>
                                            <span class="small fw-bold text-primary">
                                                Dư điểm: +<?= $diff ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Không tìm thấy trường phù hợp!</h5>
                                    <p class="text-secondary">Điểm số của bạn có thể hơi thấp so với ngành này, hoặc chưa có dữ liệu. Hãy thử chọn nhóm ngành khác.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 h-100 d-flex flex-column justify-content-center align-items-center">
                            <img src="public/assets/images/search-illustration.png" 
                                 style="max-width: 200px; opacity: 0.8;" 
                                 class="mb-4"
                                 onerror="this.src='https://cdn-icons-png.flaticon.com/512/6104/6104865.png'"> 
                            <h5 class="fw-bold text-dark">UniBot đang chờ thông tin...</h5>
                            <p class="text-muted">Nhập điểm thi và chọn ngành bên trái để nhận gợi ý chính xác nhất.</p>
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
                <h4 class="fw-bold mb-4 text-warning">UniGuide</h4>
                <p class="opacity-75">Hệ thống hỗ trợ thí sinh chọn trường đại học dựa trên năng lực thực tế. Luôn đồng hành cùng bạn trên con đường chinh phục tri thức.</p>
            </div>
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4 text-warning">Liên hệ</h4>
                <ul class="list-unstyled opacity-75">
                    <li class="mb-3"><i class="fas fa-phone me-2 text-danger"></i> 090.123.4567</li>
                    <li class="mb-3"><i class="fas fa-envelope me-2 text-danger"></i> info@uniguide.edu.vn</li>
                    <li><i class="fas fa-map-marker-alt me-2 text-danger"></i> TP. Hồ Chí Minh</li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4 text-warning">Bản tin</h4>
                <p class="small opacity-75">Đăng ký để nhận thông tin tuyển sinh mới nhất.</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Email của bạn">
                    <button class="btn btn-danger">Đăng ký</button>
                </div>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center py-4">
            <p class="m-0 small opacity-50">Copyright © 2025 UniGuide System. Designed by <strong>Minh Quan</strong></p>
        </div>
    </div>
</footer>

<?php require_once 'views/layouts/footer.php'; ?>