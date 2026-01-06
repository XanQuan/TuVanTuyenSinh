<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-users-cog text-primary me-2"></i>Quản lý Tài khoản</h4>
        <p class="text-muted mb-0 small">Danh sách học sinh, sinh viên và quản trị viên.</p>
    </div>
</div>

<?php if(isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> Cập nhật trạng thái người dùng thành công!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold">Người dùng</th>
                        <th class="py-3 text-uppercase small fw-bold">Tên đăng nhập</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Trạng thái</th>
                        <th class="text-end pe-4 py-3 text-uppercase small fw-bold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): 
                            $status = $user['status'] ?? 'active'; 
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['fullname']) ?>&background=random" 
                                         class="rounded-circle me-3 border shadow-sm" width="40" height="40">
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($user['fullname']) ?></div>
                                        <div class="text-muted small">ID: #<?= $user['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-primary fw-bold bg-light px-2 py-1 rounded"><?= htmlspecialchars($user['username']) ?></code></td>
                            <td class="text-center">
                                <?php if($status == 'active'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-10">
                                        <i class="fas fa-check-circle me-1"></i> Hoạt động
                                    </span>
                                <?php elseif($status == 'temporary_banned'): ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 border border-warning border-opacity-10">
                                        <i class="fas fa-clock me-1"></i> Khóa tạm
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 border border-danger border-opacity-10">
                                        <i class="fas fa-ban me-1"></i> Đã khóa
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="dropdown">
                                        Thao tác <i class="fas fa-caret-down ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow-lg border-0 rounded-3 p-2">
                                        <li><a class="dropdown-item rounded" href="index.php?page=admin&action=edit_user&id=<?= $user['id'] ?>"><i class="fas fa-edit me-2 text-primary"></i>Sửa thông tin</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <?php if($status !== 'active'): ?>
                                            <li><a class="dropdown-item rounded text-success fw-bold" href="index.php?page=admin&action=toggle_user_status&id=<?= $user['id'] ?>&status=active"><i class="fas fa-unlock me-2"></i>Mở khóa</a></li>
                                        <?php endif; ?>
                                        <?php if($status !== 'temporary_banned'): ?>
                                            <li><a class="dropdown-item rounded text-warning" href="index.php?page=admin&action=toggle_user_status&id=<?= $user['id'] ?>&status=temporary_banned"><i class="fas fa-user-clock me-2"></i>Khóa tạm thời</a></li>
                                        <?php endif; ?>
                                        <?php if($status !== 'permanently_banned'): ?>
                                            <li><a class="dropdown-item rounded text-danger" href="index.php?page=admin&action=toggle_user_status&id=<?= $user['id'] ?>&status=permanently_banned"><i class="fas fa-ban me-2"></i>Khóa vĩnh viễn</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">Chưa có người dùng nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>