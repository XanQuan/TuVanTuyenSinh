<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-chalkboard-teacher text-success me-2"></i>Đội ngũ Mentor</h4>
        <p class="text-muted mb-0 small">Danh sách chuyên gia tư vấn hướng nghiệp.</p>
    </div>
    <a href="index.php?page=admin&action=add_mentor" class="btn btn-success shadow-sm rounded-pill px-4 fw-bold">
        <i class="fas fa-user-plus me-2"></i> Thêm Mentor
    </a>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 fw-bold">Chuyên gia</th>
                        <th class="py-3 fw-bold">Chức danh</th>
                        <th class="py-3 fw-bold">Lĩnh vực</th>
                        <th class="text-end pe-4 py-3 fw-bold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mentors)): foreach($mentors as $m): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <?php 
                                    $avatar = !empty($m['avatar']) ? $m['avatar'] : 'default_mentor.jpg';
                                    $avatarPath = "public/assets/images/" . $avatar;
                                ?>
                                <img src="<?= $avatarPath ?>" class="rounded-circle me-3 border shadow-sm" width="45" height="45" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($m['full_name']) ?>'">
                                <div>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($m['full_name']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($m['username'] ?? '') ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-dark small fw-medium">
                            <?= htmlspecialchars($m['job_title'] ?? 'N/A') ?>
                        </td>
                        <td>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-2">
                                <?= htmlspecialchars($m['expertise'] ?? '') ?>
                            </span>
                        </td>
                        <td class="text-end pe-4">
                             <a href="index.php?page=admin&action=edit_mentor&id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-primary border-0 rounded-circle me-1" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                             <a href="index.php?page=admin&action=delete_mentor&id=<?= $m['id'] ?>" 
                                class="btn btn-sm btn-outline-danger border-0 rounded-circle" 
                                onclick="return confirm('Xóa mentor này?');" title="Xóa">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">Chưa có chuyên gia nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>