<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fas fa-history text-danger me-2"></i>Nhật Ký Tư Vấn AI
        </h4>
        <p class="text-muted mb-0 small">Theo dõi lịch sử tương tác giữa học sinh và trợ lý ảo.</p>
    </div>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold" style="min-width: 250px;">Người dùng</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Tổng tin nhắn</th>
                        <th class="py-3 text-uppercase small fw-bold">Lần chat cuối</th>
                        <th class="text-end pe-4 py-3 text-uppercase small fw-bold">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($users_chatted)): ?>
                        <?php foreach ($users_chatted as $user): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['fullname']) ?>&background=random&size=128" 
                                         class="rounded-circle me-3 border shadow-sm" 
                                         width="45" height="45" 
                                         alt="<?= htmlspecialchars($user['fullname']) ?>">
                                    
                                    <div>
                                        <div class="fw-bold text-dark">
                                            <?= htmlspecialchars($user['fullname'] ?? 'Khách ẩn danh') ?>
                                        </div>
                                        <div class="text-muted small" style="font-size: 0.8rem;">
                                            <i class="fas fa-id-card me-1 text-secondary"></i>ID: #<?= $user['user_id'] ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 fw-semibold border border-danger border-opacity-10">
                                    <i class="fas fa-comments me-1"></i><?= $user['total_messages'] ?> tin
                                </span>
                            </td>

                            <td>
                                <div class="text-muted small fw-medium">
                                    <i class="far fa-clock me-1 text-primary"></i> 
                                    <?= date('H:i - d/m/Y', strtotime($user['last_chat'])) ?>
                                </div>
                            </td>

                            <td class="text-end pe-4">
                                <a href="index.php?page=admin&action=chat_detail&user_id=<?= $user['user_id'] ?>" 
                                   class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm fw-bold transition-hover" 
                                   style="font-size: 0.85rem; border-width: 1px;">
                                    Xem chi tiết <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="opacity-50">
                                    <i class="fas fa-comment-slash fa-3x mb-3 text-secondary"></i>
                                    <p class="text-muted mb-0 fw-medium">Chưa có dữ liệu hội thoại nào.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>