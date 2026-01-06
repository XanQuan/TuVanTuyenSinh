<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-success fw-bold">
            <i class="fas fa-user-plus me-2"></i>Thêm Chuyên Gia (Mentor)
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Họ và Tên hiển thị <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" required placeholder="VD: ThS. Nguyễn Văn A">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Chức danh / Công việc <span class="text-danger">*</span></label>
                            <input type="text" name="job_title" class="form-control" required placeholder="VD: Senior Developer tại VNG">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lĩnh vực chuyên môn</label>
                        <input type="text" name="expertise" class="form-control" required placeholder="VD: IT, Marketing, Y khoa...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiểu sử ngắn (Bio)</label>
                        <textarea name="bio" class="form-control" rows="4" placeholder="Giới thiệu kinh nghiệm làm việc..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary"><i class="fab fa-linkedin me-1"></i> LinkedIn Profile</label>
                        <input type="text" name="linkedin_url" class="form-control" placeholder="linkedin.com/in/...">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Liên kết tài khoản User <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select bg-light" required>
                            <option value="">-- Chọn User --</option>
                            <?php if(!empty($users)) foreach($users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['fullname']) ?> (ID: <?= $u['id'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Mentor cần có tài khoản đăng nhập trước.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ảnh đại diện (Avatar)</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                        <div class="mt-2 text-center p-3 border rounded bg-light">
                            <i class="fas fa-user-circle fa-3x text-secondary opacity-25"></i>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2 shadow-sm">
                        <i class="fas fa-save me-2"></i> LƯU MENTOR
                    </button>
                    <a href="index.php?page=admin&action=mentors" class="btn btn-light w-100 rounded-pill py-2 mt-2 border">Hủy bỏ</a>
                </div>
            </div>
        </form>
    </div>
</div>