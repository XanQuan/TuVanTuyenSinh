<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-chart-line text-success me-2"></i>Quản lý Điểm Chuẩn</h4>
        <p class="text-muted mb-0 small">Dữ liệu điểm trúng tuyển các năm.</p>
    </div>
    
    <div class="d-flex gap-2">
        <select class="form-select shadow-sm border-0 bg-white" style="width: 130px; border-radius: 20px;">
            <option selected>Năm 2024</option>
            <option>Năm 2023</option>
        </select>
        <a href="index.php?page=admin&action=add_score" class="btn btn-success shadow-sm rounded-pill px-4 fw-bold"><i class="fas fa-plus-circle me-2"></i>Thêm Mới</a>
    </div>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 fw-bold">Trường Đại Học</th>
                        <th class="py-3 fw-bold">Ngành Học</th>
                        <th class="py-3 text-center fw-bold">Năm</th>
                        <th class="py-3 text-center fw-bold">Điểm</th>
                        <th class="text-end pe-4 py-3 fw-bold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($scores) && count($scores) > 0): ?>
                        <?php foreach ($scores as $s): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark"><?= htmlspecialchars($s['uni_name']) ?></div>
                                <small class="text-muted fw-bold"><?= htmlspecialchars($s['uni_code']) ?></small>
                            </td>
                            <td class="fw-medium text-secondary"><?= htmlspecialchars($s['major_name']) ?></td>
                            <td class="text-center"><span class="badge bg-white text-dark border shadow-sm rounded-pill px-3"><?= $s['year'] ?></span></td>
                            <td class="text-center"><span class="fw-bold text-danger bg-danger bg-opacity-10 px-3 py-1 rounded border border-danger border-opacity-10"><?= $s['score'] ?></span></td>
                            <td class="text-end pe-4">
                                <a href="index.php?page=admin&action=edit_score&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-primary border-0 rounded-circle"><i class="fas fa-edit"></i></a>
                                <a href="index.php?page=admin&action=delete_score&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="return confirm('Xóa điểm này?');"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted">Chưa có dữ liệu điểm chuẩn.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>