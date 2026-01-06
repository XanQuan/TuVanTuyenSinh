<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-warning fw-bold">
            <i class="fas fa-pencil-alt me-2"></i>Cập Nhật Điểm Chuẩn
        </h5>
    </div>
    <div class="card-body p-4">
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger rounded-pill px-4 border-0 shadow-sm mb-4">
                <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Trường Đại Học</label>
                        <select name="uni_id" class="form-select form-select-lg bg-light border-0" required style="border-radius: 10px;">
                            <?php foreach ($universities as $uni): ?>
                                <option value="<?= $uni['id'] ?>" <?= ($uni['id'] == $current_score['uni_id']) ? 'selected' : '' ?>>
                                    [<?= htmlspecialchars($uni['code']) ?>] <?= htmlspecialchars($uni['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Ngành Đào Tạo</label>
                        <select name="major_id" class="form-select form-select-lg bg-light border-0" required style="border-radius: 10px;">
                            <?php foreach ($majors as $major): ?>
                                <option value="<?= $major['id'] ?>" <?= ($major['id'] == $current_score['major_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($major['name']) ?> (Nhóm <?= $major['group_code'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Năm tuyển sinh</label>
                            <select name="year" class="form-select form-select-lg bg-light border-0" required style="border-radius: 10px;">
                                <option value="2025" <?= ($current_score['year'] == 2025) ? 'selected' : '' ?>>2025</option>
                                <option value="2024" <?= ($current_score['year'] == 2024) ? 'selected' : '' ?>>2024</option>
                                <option value="2023" <?= ($current_score['year'] == 2023) ? 'selected' : '' ?>>2023</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Điểm Chuẩn</label>
                            <input type="number" step="0.01" name="score" class="form-control form-control-lg bg-light border-0 text-danger fw-bold" 
                                   value="<?= $current_score['score'] ?>" required style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="index.php?page=admin&action=scores" class="btn btn-light w-50 py-3 rounded-pill fw-bold border">
                            Quay lại
                        </a>
                        <button type="submit" class="btn btn-warning text-white w-50 py-3 rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-check-circle me-2"></i> LƯU THAY ĐỔI
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>