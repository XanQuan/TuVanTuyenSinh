<?php require_once 'views/layouts/header.php'; ?>

<section class="section" style="padding-top: 120px; min-height: 600px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-danger text-white">
                        <h4 class="fw-bold m-0"><i class="bi bi-plus-circle"></i> Thêm Điểm Chuẩn Mới</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Chọn Trường Đại Học:</label>
                                <select name="uni_id" class="form-select" required>
                                    <option value="">-- Vui lòng chọn trường --</option>
                                    <?php foreach ($universities as $uni): ?>
                                        <option value="<?= $uni['id'] ?>">
                                            <?= htmlspecialchars($uni['code']) ?> - <?= htmlspecialchars($uni['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Chọn Ngành Đào Tạo:</label>
                                <select name="major_id" class="form-select" required>
                                    <option value="">-- Vui lòng chọn ngành --</option>
                                    <?php foreach ($majors as $major): ?>
                                        <option value="<?= $major['id'] ?>">
                                            <?= htmlspecialchars($major['name']) ?> (Nhóm: <?= htmlspecialchars($major['group_code']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> Nếu chưa có ngành, hãy vào <a href="#">Quản lý Ngành</a> để thêm trước.
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Năm Tuyển Sinh:</label>
                                    <input type="number" name="year" class="form-control" 
                                           value="<?= date('Y') ?>" min="2020" max="2030" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Điểm Chuẩn:</label>
                                    <input type="number" step="0.01" name="score" class="form-control" 
                                           placeholder="Ví dụ: 24.5" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="index.php?page=admin&action=scores" class="btn btn-secondary">
                                    <i class="bi bi-arrow-return-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-save"></i> Lưu Dữ Liệu
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>