<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-success fw-bold">
            <i class="fas fa-chart-line me-2"></i>Thêm Dữ Liệu Điểm Chuẩn
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Trường Đại Học</label>
                        <select name="uni_id" class="form-select form-select-lg bg-light border-0" required style="border-radius: 10px;">
                            <option value="" disabled selected>-- Chọn trường --</option>
                            <?php if(!empty($universities)): foreach($universities as $u): ?>
                                <option value="<?= $u['id'] ?>">
                                    [<?= htmlspecialchars($u['code']) ?>] <?= htmlspecialchars($u['name']) ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Ngành Đào Tạo</label>
                        <select name="major_id" class="form-select form-select-lg bg-light border-0" required style="border-radius: 10px;">
                            <option value="" disabled selected>-- Chọn ngành --</option>
                            <?php if(!empty($majors)): foreach($majors as $m): ?>
                                <option value="<?= $m['id'] ?>">
                                    <?= htmlspecialchars($m['name']) ?> (Nhóm <?= $m['group_code'] ?>)
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Năm tuyển sinh</label>
                            <select name="year" class="form-select form-select-lg bg-light border-0" required style="border-radius: 10px;">
                                <option value="2025" selected>2025</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Điểm Chuẩn (Thang 30)</label>
                            <input type="number" step="0.01" name="score" class="form-control form-select-lg bg-light border-0" required placeholder="VD: 24.5..." style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <a href="index.php?page=admin&action=scores" class="btn btn-light w-100 py-3 rounded-pill fw-bold border">Quay lại</a>
                        <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> LƯU DỮ LIỆU
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>