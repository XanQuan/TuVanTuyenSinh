<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-calendar-check text-warning me-2"></i>Quản lý Sự kiện</h4>
        <p class="text-muted mb-0 small">Các hội thảo, ngày hội tuyển sinh sắp tới.</p>
    </div>
    <a href="index.php?page=admin&action=add_event" class="btn btn-warning text-white shadow-sm rounded-pill px-4 fw-bold">
        <i class="fas fa-plus-circle me-2"></i> Thêm Sự kiện
    </a>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 fw-bold">Tên Sự kiện</th>
                        <th class="py-3 fw-bold text-center">Thời gian</th>
                        <th class="py-3 fw-bold">Địa điểm</th>
                        <th class="text-end pe-4 py-3 fw-bold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($events)): foreach($events as $ev): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <?php 
                                    $img = !empty($ev['image_url']) ? $ev['image_url'] : 'event_default.jpg'; 
                                    $imgPath = "public/assets/images/" . $img;
                                ?>
                                <img src="<?= $imgPath ?>" class="rounded me-3 shadow-sm border" width="60" height="40" style="object-fit: cover;" onerror="this.src='https://placehold.co/60x40?text=Event'">
                                <div class="fw-bold text-dark"><?= htmlspecialchars($ev['title']) ?></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border shadow-sm">
                                <?= date('d/m/Y H:i', strtotime($ev['event_date'])) ?>
                            </span>
                        </td>
                        <td class="text-secondary small">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i><?= htmlspecialchars($ev['location']) ?>
                        </td>
                        <td class="text-end pe-4">
                            <a href="index.php?page=admin&action=edit_event&id=<?= $ev['id'] ?>" class="btn btn-sm btn-outline-primary border-0 rounded-circle me-1" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?page=admin&action=delete_event&id=<?= $ev['id'] ?>" 
                               class="btn btn-sm btn-outline-danger border-0 rounded-circle" 
                               onclick="return confirm('Xóa sự kiện này?');" title="Xóa">
                               <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">Chưa có sự kiện nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>