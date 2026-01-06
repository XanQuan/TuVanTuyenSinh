<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-success fw-bold"><i class="fas fa-user-edit me-2"></i>Cập nhật thông tin Mentor</h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_avatar" value="<?= htmlspecialchars($mentor['avatar'] ?? '') ?>">
            
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Ảnh đại diện hiện tại</label>
                        <?php if(!empty($mentor['avatar'])): ?>
                            <img src="public/assets/images/<?= htmlspecialchars($mentor['avatar']) ?>" class="rounded-circle shadow border mb-3" width="150" height="150" style="object-fit: cover;">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($mentor['full_name']) ?>" class="rounded-circle shadow border mb-3" width="150">
                        <?php endif; ?>
                        
                        <input type="file" name="avatar" class="form-control mt-2" accept="image/*">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Họ và Tên hiển thị</label>
                            <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($mentor['full_name']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Chức danh / Công việc</label>
                            <input type="text" name="job_title" class="form-control" required value="<?= htmlspecialchars($mentor['job_title']) ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lĩnh vực chuyên môn</label>
                        <input type="text" name="expertise" class="form-control" required value="<?= htmlspecialchars($mentor['expertise']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiểu sử (Bio)</label>
                        <textarea name="bio" class="form-control" rows="4"><?= htmlspecialchars($mentor['bio']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Link LinkedIn</label>
                        <input type="text" name="linkedin_url" class="form-control" value="<?= htmlspecialchars($mentor['linkedin_url']) ?>">
                    </div>
                    <div class="text-end">
                        <a href="index.php?page=admin&action=mentors" class="btn btn-light rounded-pill px-4 border me-2">Quay lại</a>
                        <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                            <i class="fas fa-save me-2"></i> Lưu thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>