<?php require_once 'views/layouts/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    }

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
        color: white;
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
</style>

<div class="profile-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="glass-card mb-4">
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
                                        Cập nhật đầy đủ thông tin giúp AI phân tích lộ trình chính xác hơn.
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
                                        <label><i class="fa fa-id-badge"></i> Bạn là:</label>
                                        <select name="user_type" class="form-select">
                                            <option value="student" <?= ($user['user_type'] == 'student') ? 'selected' : '' ?>>Sinh viên / Học sinh</option>
                                            <option value="alumni" <?= ($user['user_type'] == 'alumni') ? 'selected' : '' ?>>Cựu sinh viên (Đã tốt nghiệp)</option>
                                        </select>
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
                                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
                                        <label><i class="fa fa-graduation-cap"></i> Học lực</label>
                                        <select name="academic_performance" class="form-select">
                                            <option value="Trung bình" <?= ($user['academic_performance'] == 'Trung bình') ? 'selected' : '' ?>>Trung bình</option>
                                            <option value="Khá" <?= ($user['academic_performance'] == 'Khá') ? 'selected' : '' ?>>Khá</option>
                                            <option value="Giỏi" <?= ($user['academic_performance'] == 'Giỏi') ? 'selected' : '' ?>>Giỏi</option>
                                            <option value="Xuất sắc" <?= ($user['academic_performance'] == 'Xuất sắc') ? 'selected' : '' ?>>Xuất sắc</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
                                        <label><i class="fa fa-map-marker-alt"></i> Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
    <label><i class="fa fa-layer-group"></i> Khối thi dự kiến (2025)</label>
    <select name="region" class="form-select">
        <option value="" disabled <?= empty($user['region']) ? 'selected' : '' ?>>-- Chọn khối thi --</option>
        <?php foreach ($all_exam_groups as $group): ?>
            <option value="<?= $group['code'] ?>" <?= ($user['region'] == $group['code']) ? 'selected' : '' ?>>
                Khối <?= $group['code'] ?> (<?= $group['subjects'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
</div>
                                    <div class="col-12 form-group mb-4">
                                        <label><i class="fa fa-briefcase"></i> <?= $user['user_type'] == 'alumni' ? 'Ngành học đã tốt nghiệp' : 'Nguyện vọng nghề nghiệp' ?></label>
                                        <textarea name="aspiration" class="form-control" rows="3" placeholder="Chia sẻ mục tiêu hoặc công việc hiện tại của bạn..."><?= htmlspecialchars($user['aspiration'] ?? '') ?></textarea>
                                    </div>
                                    <input type="hidden" name="personality" value="<?= htmlspecialchars($user['personality'] ?? '') ?>">
    <input type="hidden" name="employment_status" value="<?= htmlspecialchars($user['employment_status'] ?? 'working') ?>">
                                </div>

                                <div class="text-end">
        <button type="submit" class="btn btn-save shadow">Lưu thay đổi</button>
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

                <div class="glass-card mt-3 p-4 border-info">
    <h5 class="text-info section-title" style="font-size: 1.1rem;"><i class="fa fa-robot me-2"></i> Phân tích lộ trình thành công</h5>
    <div class="row align-items-center">
        <div class="col-md-8">
            <p class="text-white mb-2">
                Dựa trên dữ liệu từ <strong><?= $others->num_rows ?> tiền bối</strong> đã ra trường:
            </p>
            <h4 class="text-warning mb-3">
                <?= htmlspecialchars($top_suggestion) ?>
            </h4>
            
            <?php if ($others->num_rows > 0): ?>
            <div class="d-flex gap-3">
    <span class="badge bg-success" style="padding: 8px 12px;">
        <i class="fa fa-check-circle me-1"></i> 
        <?= $top_match_rate ?>% Khớp tính cách
    </span>
    <span class="badge bg-primary" style="padding: 8px 12px;">
        <i class="fa fa-briefcase me-1"></i> 
        <?= ($top_employment_status == 'working') ? 'Đã có việc làm' : 'Đang tìm việc' ?>
    </span>
</div>
                <p class="small text-muted mt-3 mb-0">* Lộ trình được đề xuất dựa trên dữ liệu thực tế của các cựu sinh viên có cùng nhóm tính cách với bạn.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-4 text-center">
            <i class="fa fa-lightbulb text-info" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(0, 255, 255, 0.4); }
    70% { box-shadow: 0 0 0 20px rgba(0, 255, 255, 0); }
    100% { box-shadow: 0 0 0 0 rgba(0, 255, 255, 0); }
}
</style>

<?php if (isset($_GET['status'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const status = "<?= $_GET['status'] ?>";
        const message = "<?= $_GET['message'] ?? '' ?>";
        
        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: message || 'Thông tin hồ sơ đã được cập nhật.',
                confirmButtonColor: '#be1e2d',
                background: '#1a1f2b',
                color: '#fff'
            });
        } else if (status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: message || 'Có lỗi xảy ra trong quá trình lưu dữ liệu.',
                confirmButtonColor: '#be1e2d',
                background: '#1a1f2b',
                color: '#fff'
            });
        }
    });
</script>
<?php endif; ?>

<?php require_once 'views/layouts/footer.php'; ?>