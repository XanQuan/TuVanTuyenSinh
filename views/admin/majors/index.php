<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-book-open text-primary me-2"></i>Quản lý Ngành Đào Tạo</h4>
        <p class="text-muted mb-0 small">Danh sách các ngành nghề trong hệ thống tư vấn.</p>
    </div>
    
    <a href="index.php?page=admin&action=add_major" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold">
        <i class="fas fa-plus me-2"></i>Thêm Ngành
    </a>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-white border-bottom">
                    <tr>
                        <th width="8%" class="py-3 text-center text-secondary text-uppercase small">ID</th>
                        <th width="12%" class="py-3 text-center text-secondary text-uppercase small">Hình ảnh</th>
                        <th class="py-3 ps-3 text-secondary text-uppercase small">Tên Ngành</th>
                        <th width="15%" class="py-3 text-center text-secondary text-uppercase small">Mã Nhóm</th>
                        <th width="10%" class="py-3 text-end pe-4 text-secondary text-uppercase small">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($majors) && count($majors) > 0): ?>
                        <?php foreach ($majors as $row): ?>
                        <tr>
                            <td class="text-center text-muted fw-bold">#<?= $row['id'] ?></td>
                            <td class="text-center">
                                <?php 
                                    $imgFile = !empty($row['image']) ? $row['image'] : 'course-01.jpg';
                                    $imgPath = "public/assets/images/" . $imgFile;
                                ?>
                                <img src="<?= $imgPath ?>" class="rounded shadow-sm border" 
                                     style="width: 50px; height: 35px; object-fit: cover;"
                                     onerror="this.src='https://placehold.co/50x35?text=Img'">
                            </td>
                            <td class="fw-bold text-dark px-3">
                                <?= htmlspecialchars($row['name']) ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                    <?= htmlspecialchars($row['group_code']) ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="index.php?page=admin&action=delete_major&id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-outline-danger border-0" 
                                   onclick="return confirm('CẢNH BÁO: Xóa ngành này sẽ xóa luôn các dữ liệu liên quan!\nBạn chắc chắn chứ?');"
                                   title="Xóa ngành">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Chưa có dữ liệu ngành học.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>