<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-university text-danger me-2"></i>Danh sách Trường Đại Học</h4>
        <p class="text-muted mb-0 small">Quản lý thông tin các trường trong hệ thống.</p>
    </div>
    <a href="index.php?page=admin&action=add_university" class="btn btn-success shadow-sm rounded-pill px-4 fw-bold">
        <i class="fas fa-plus-circle me-2"></i> Thêm Trường
    </a>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold" width="150">Mã Trường</th>
                        <th class="py-3 text-uppercase small fw-bold">Tên Trường Đại Học</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Khu vực</th>
                        <th class="text-end pe-4 py-3 text-uppercase small fw-bold" width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($universities) && count($universities) > 0): ?>
                        <?php foreach ($universities as $uni): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-danger bg-danger bg-opacity-10 px-2 py-1 rounded">
                                    <?= htmlspecialchars($uni['code']) ?>
                                </span>
                            </td>
                            <td class="fw-medium text-dark">
                                <?= htmlspecialchars($uni['name']) ?>
                            </td>
                             <td class="text-center">
                                <span class="badge bg-light text-muted border"><?= htmlspecialchars($uni['region'] ?? 'N/A') ?></span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="index.php?page=admin&action=edit_university&id=<?= $uni['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2 me-1" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?page=admin&action=delete_university&id=<?= $uni['id'] ?>" 
                                   class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2" 
                                   onclick="return confirm('Bạn có chắc muốn xóa trường này? Tất cả điểm chuẩn liên quan sẽ bị xóa theo!');" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="fas fa-school fa-3x mb-3 text-secondary opacity-25"></i>
                                <p class="text-muted mb-0">Chưa có dữ liệu trường học.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>