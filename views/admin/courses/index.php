<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-laptop-code text-warning me-2"></i>Quản lý Khóa Học</h4>
        <p class="text-muted mb-0 small">Danh sách các khóa học bổ trợ kỹ năng.</p>
    </div>
    
    <div class="d-flex gap-2">
        <form action="index.php" method="GET" class="d-flex" style="max-width: 300px;">
            <input type="hidden" name="page" value="admin">
            <input type="hidden" name="action" value="courses">
            <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border">
                <input type="text" name="search" class="form-control border-0 ps-3" placeholder="Tìm khóa học..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button class="btn btn-white border-0 text-secondary pe-3"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <a href="index.php?page=admin&action=add_course" class="btn btn-warning text-white shadow-sm rounded-pill px-4 fw-bold">
            <i class="fas fa-plus-circle me-2"></i> Thêm Mới
        </a>
    </div>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th width="40%" class="ps-4 py-3 fw-bold">Khóa học</th>
                        <th width="20%" class="py-3 fw-bold">Giảng viên</th>
                        <th width="15%" class="py-3 text-center fw-bold">Học phí</th>
                        <th width="10%" class="py-3 text-center fw-bold">Đánh giá</th>
                        <th width="15%" class="text-end pe-4 py-3 fw-bold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courses)): foreach($courses as $c): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center py-2">
                                <?php 
                                    $imgName = !empty($c['image']) ? trim($c['image']) : 'default.jpg';
                                    $imgPath = "uploads/courses/" . $imgName; 
                                ?>
                                <img src="<?= $imgPath ?>" class="rounded me-3 shadow-sm border" 
                                     style="width: 70px; height: 45px; object-fit: cover;"
                                     onerror="this.src='https://placehold.co/70x45?text=No+Img'">
                                <div>
                                    <div class="fw-bold text-dark text-wrap" style="max-width: 250px;"><?= htmlspecialchars($c['name']) ?></div>
                                    <div class="text-muted small">ID: #<?= $c['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-secondary">
                                <i class="fas fa-user-tie me-2"></i> <?= htmlspecialchars($c['teacher']) ?>
                            </div>
                        </td>
                        <td class="text-center fw-bold text-danger">
                            <?= htmlspecialchars($c['tuition']) ?>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning text-dark border border-warning">
                                <?= $c['rating'] ?> <i class="fas fa-star small"></i>
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="index.php?page=admin&action=edit_course&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary border-0 rounded-circle me-1"><i class="fas fa-edit"></i></a>
                            <a href="index.php?page=admin&action=delete_course&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="return confirm('Xóa khóa học này?');"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted">Chưa có khóa học nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>