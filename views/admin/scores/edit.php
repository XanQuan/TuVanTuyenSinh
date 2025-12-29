<?php require_once 'views/layouts/header.php'; ?>

<section class="section" style="padding-top: 120px; min-height: 600px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="fw-bold m-0"><i class="bi bi-pencil-square"></i> Cập Nhật Điểm Chuẩn</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Trường Đại Học:</label>
                                <select name="uni_id" class="form-select" required>
                                    <?php foreach ($universities as $uni): ?>
                                        <option value="<?= $uni['id'] ?>" 
                                            <?= ($uni['id'] == $current_score['uni_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($uni['code']) ?> - <?= htmlspecialchars($uni['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Ngành Đào Tạo:</label>
                                <select name="major_id" class="form-select" required>
                                    <?php foreach ($majors as $major): ?>
                                        <option value="<?= $major['id'] ?>"
                                            <?= ($major['id'] == $current_score['major_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($major['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Năm:</label>
                                    <input type="number" name="year" class="form-control" 
                                           value="<?= $current_score['year'] ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Điểm Chuẩn:</label>
                                    <input type="number" step="0.01" name="score" class="form-control fw-bold text-danger" 
                                           value="<?= $current_score['score'] ?>" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="index.php?page=admin&action=scores" class="btn btn-secondary">
                                    <i class="bi bi-arrow-return-left"></i> Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-warning fw-bold">
                                    <i class="bi bi-check-circle"></i> Lưu thay đổi
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