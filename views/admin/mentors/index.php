<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-chalkboard-teacher text-danger me-2"></i>Đội ngũ Mentor</h4>
        <p class="text-muted mb-0 small">Quản lý đội ngũ chuyên gia tư vấn hướng nghiệp trên hệ thống.</p>
    </div>
    <a href="index.php?page=admin&action=add_mentor" class="btn btn-danger shadow-sm rounded-pill px-4 fw-bold" style="background-color: #a71d2a;">
        <i class="fas fa-user-plus me-2 text-warning"></i> Thêm Mentor Mới
    </a>
</div>

<div class="card table-card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="text-white" style="background-color: #a71d2a;">
                    <tr>
                        <th class="ps-4 py-3 fw-bold">Chuyên gia</th>
                        <th class="py-3 fw-bold text-center">Chức danh / Công việc</th>
                        <th class="py-3 fw-bold text-center">Lĩnh vực chuyên môn</th>
                        <th class="text-end pe-4 py-3 fw-bold">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mentors)): foreach($mentors as $m): ?>
                    <tr class="hover-row">
                        <td class="ps-4">
                            <div class="d-flex align-items-center py-2">
                                <?php 
                                    // Kiểm tra ảnh trong cả 2 thư mục để đảm bảo không bị lỗi
                                    $avatar = !empty($m['avatar']) ? $m['avatar'] : 'default_mentor.jpg';
                                    
                                    // Thử tìm trong thư mục mentors trước, nếu không có thì tìm ở images
                                    $avatarPath = "public/assets/images/" . $avatar;
                                    if (!file_exists($avatarPath)) {
                                        $avatarPath = "public/assets/images/mentors/" . $avatar;
                                    }
                                ?>
                               <img src="<?= $avatarPath ?>" 
     class="rounded-circle me-3 border border-2 border-white shadow-sm mentor-img-list" 
     width="55" height="55" 
     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($m['full_name']) ?>&background=a71d2a&color=fff'">
                                <div>
                                    <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($m['full_name']) ?></div>
                                    <div class="text-muted small">ID: #<?= $m['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-medium">
                                <?= htmlspecialchars($m['job_title'] ?? 'Chuyên gia') ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 px-3 py-2 rounded-pill">
                                <i class="fas fa-star me-1 small"></i> <?= htmlspecialchars($m['expertise'] ?? 'Tư vấn') ?>
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="index.php?page=admin&action=edit_mentor&id=<?= $m['id'] ?>" 
                                   class="btn btn-outline-primary btn-sm rounded-circle me-2 shadow-sm" 
                                   title="Chỉnh sửa thông tin" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?page=admin&action=delete_mentor&id=<?= $m['id'] ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                   onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa chuyên gia này khỏi hệ thống?');" 
                                   title="Xóa chuyên gia" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fas fa-user-slash fa-3x mb-3 opacity-25"></i><br>
                            Chưa có dữ liệu chuyên gia nào được cập nhật.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .hover-row:hover { background-color: #fff9f9; transition: 0.3s; }
    .table-card { border-radius: 20px; transition: 0.3s; }
    .btn-group .btn:hover { transform: translateY(-2px); transition: 0.2s; }
</style>