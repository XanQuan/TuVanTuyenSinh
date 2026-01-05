<?php require_once 'views/layouts/header.php'; ?>

<style>
    :root {
        --primary-red: #be1e2d;
        --glass-bg: rgba(255, 255, 255, 0.05);
        --input-bg: rgba(0, 0, 0, 0.2);
    }

    .profile-page {
        background: radial-gradient(circle at top right, #1a1f2b, #0d1117);
        min-height: 100vh;
        padding: 60px 0;
        color: #e6edf3;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        padding: 40px;
    }

    .section-title {
        font-weight: 800;
        letter-spacing: -0.5px;
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-red);
        border-radius: 2px;
    }

    /* Avatar Styling */
    .avatar-upload-container {
        position: relative;
        display: inline-block;
        margin-bottom: 25px;
    }

    #preview {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-red);
        padding: 5px;
        background: #0d1117;
        transition: transform 0.3s ease;
    }

    .btn-upload-label {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: var(--primary-red);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(190, 30, 45, 0.4);
        transition: 0.3s;
    }

    .btn-upload-label:hover { transform: scale(1.1); background: #d62828; }

    /* Form Elements */
    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #8b949e;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control, .form-select {
        background: var(--input-bg) !important;
        border: 1px solid #30363d !important;
        color: #fff !important;
        border-radius: 12px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-red) !important;
        box-shadow: 0 0 0 3px rgba(190, 30, 45, 0.2) !important;
        background: rgba(0, 0, 0, 0.3) !important;
    }

    .form-control[readonly] { opacity: 0.5; cursor: not-allowed; }

    .btn-save {
        background: var(--primary-red);
        border: none;
        padding: 14px 40px;
        border-radius: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
        margin-top: 20px;
    }

    .btn-save:hover {
        background: #e62235;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(190, 30, 45, 0.3);
    }

    .info-box {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: 0.3s;
    }
    
    .info-box:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary-red);
    }

    .badge {
        font-weight: 500;
        border-radius: 8px;
    }
</style>

<div class="profile-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="glass-card">
                    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" 
                             style="background: rgba(40, 167, 69, 0.2); color: #28a745; border-radius: 12px;">
                            <i class="fa fa-check-circle me-2"></i> <?= $_GET['message'] ?? 'Cập nhật thành công!' ?>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <h2 class="section-title text-white">Thiết lập hồ sơ</h2>
                    
                    <form action="index.php?page=profile&action=update" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 text-center border-end border-secondary mb-4 mb-md-0">
                                <div class="avatar-upload-container">
                                    <img src="public/uploads/avatars/<?= $user['avatar'] ?: 'default-avatar.png' ?>?t=<?= time() ?>" id="preview" alt="Avatar">
                                    <label for="avatar-input" class="btn-upload-label">
                                        <i class="fa fa-camera text-white"></i>
                                    </label>
                                    <input type="file" id="avatar-input" name="avatar" hidden onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                <input type="hidden" name="current_avatar" value="<?= $user['avatar'] ?>">
                                
                                <div class="p-3 mt-3 text-start" style="background: rgba(190, 30, 45, 0.05); border-radius: 16px; border: 1px dashed rgba(190, 30, 45, 0.3);">
                                    <p class="small text-muted mb-0">
                                        <i class="fa fa-info-circle me-1"></i>
                                        Cập nhật ảnh giúp trợ lý AI nhận diện và tư vấn chính xác hơn cho lộ trình của bạn.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-8 ps-md-5">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-4">
                                        <label><i class="fa fa-user"></i> Họ tên</label>
                                        <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>">
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
                                        <label><i class="fa fa-envelope"></i> Email</label>
                                        <input type="text" class="form-control" value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>" readonly>
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
                                        <label><i class="fa fa-calendar"></i> Ngày sinh</label>
                                        <input type="date" name="birthday" class="form-control" value="<?= $user['birthday'] ?>">
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
                                        <label><i class="fa fa-venus-mars"></i> Giới tính</label>
                                        <select name="gender" class="form-select">
                                            <option value="Nam" <?= $user['gender']=='Nam'?'selected':'' ?>>Nam</option>
                                            <option value="Nữ" <?= $user['gender']=='Nữ'?'selected':'' ?>>Nữ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
                                        <label><i class="fa fa-phone"></i> Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>">
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
                                        <label><i class="fa fa-graduation-cap"></i> Học lực</label>
                                        <select name="academic_performance" class="form-select">
                                            <option value="Yếu" <?= ($user['academic_performance'] == 'Yếu') ? 'selected' : '' ?>>Yếu</option>
                                            <option value="Trung bình" <?= ($user['academic_performance'] == 'Trung bình') ? 'selected' : '' ?>>Trung bình</option>
                                            <option value="Khá" <?= ($user['academic_performance'] == 'Khá') ? 'selected' : '' ?>>Khá</option>
                                            <option value="Giỏi" <?= ($user['academic_performance'] == 'Giỏi') ? 'selected' : '' ?>>Giỏi</option>
                                            <option value="Xuất sắc" <?= ($user['academic_performance'] == 'Xuất sắc') ? 'selected' : '' ?>>Xuất sắc</option>
                                        </select>
                                    </div>
                                    <div class="col-12 form-group mb-4">
                                        <label><i class="fa fa-map-marker-alt"></i> Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address']) ?>">
                                    </div>
                                    <div class="col-12 form-group mb-4">
                                        <label><i class="fa fa-heart"></i> Nguyện vọng & Tính cách</label>
                                        <textarea name="aspiration" class="form-control" rows="4" placeholder="Hãy chia sẻ thêm về đam mê của bạn..."><?= htmlspecialchars($user['aspiration']) ?></textarea>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-save text-white">Lưu thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="info-box text-center p-4">
                            <i class="fa fa-tasks mb-2" style="font-size: 2rem; color: var(--primary-red);"></i>
                            <h5 class="mb-0"><?= sprintf("%02d", $quiz_count ?? 0) ?></h5>
                            <small class="text-muted">Bài trắc nghiệm</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="info-box text-center p-4">
                            <i class="fa fa-comments mb-2" style="font-size: 2rem; color: #28a745;"></i>
                            <h5 class="mb-0"><?= sprintf("%02d", $chat_count ?? 0) ?></h5>
                            <small class="text-muted">Cuộc hội thoại AI</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="info-box text-center p-4">
                            <i class="fa fa-check-double mb-2" style="font-size: 2rem; color: #ffc107;"></i>
                            <h5 class="mb-0"><?= $completion_percent ?? 0 ?>%</h5>
                            <small class="text-muted">Độ hoàn thiện hồ sơ</small>
                        </div>
                    </div>
                </div>

                <div class="glass-card mt-2 p-4">
    <h4 class="section-title text-white" style="font-size: 1.2rem; margin-bottom: 20px;">Định hướng mục tiêu</h4>
    <div class="row">
        <div class="col-md-6 mb-3">
    <label class="small text-muted mb-2 d-block"><i class="fa fa-layer-group me-1"></i> Khối thi dự kiến</label>
    <select name="region" class="form-select bg-dark text-white border-secondary">
        <option value="" <?= empty($user['region']) ? 'selected' : '' ?>>-- Chọn khối thi --</option>
        <option value="A00" <?= ($user['region'] == 'A00') ? 'selected' : '' ?>>Khối A00 (Toán, Lý, Hóa)</option>
        <option value="A01" <?= ($user['region'] == 'A01') ? 'selected' : '' ?>>Khối A01 (Toán, Lý, Anh)</option>
        <option value="B00" <?= ($user['region'] == 'B00') ? 'selected' : '' ?>>Khối B00 (Toán, Hóa, Sinh)</option>
        <option value="C00" <?= ($user['region'] == 'C00') ? 'selected' : '' ?>>Khối C00 (Văn, Sử, Địa)</option>
        <option value="D01" <?= ($user['region'] == 'D01') ? 'selected' : '' ?>>Khối D01 (Toán, Văn, Anh)</option>
    </select>
    <small class="text-muted mt-1 d-block" style="font-size: 10px;">Lưu ý: Chúng tôi đang sử dụng trường 'Khu vực' để lưu tạm khối thi của bạn.</small>
</div>
        <div class="col-md-6 mb-3">
            <label class="small text-muted mb-2 d-block">Ngành học quan tâm</label>
            <p class="text-white mb-0" style="font-weight: 500;">
                <i class="fa fa-star text-warning me-2"></i> 
                <?= !empty($user['aspiration']) ? htmlspecialchars($user['aspiration']) : 'Vui lòng cập nhật nguyện vọng' ?>
            </p>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>