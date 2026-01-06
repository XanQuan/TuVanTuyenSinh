<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-file-alt text-primary me-2"></i>Kho Tài Liệu</h4>
        <p class="text-muted mb-0 small">Quản lý tài liệu, ebook, video hướng nghiệp.</p>
    </div>
    <a href="index.php?page=admin&action=add_resource" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold">
        <i class="fas fa-upload me-2"></i> Tải lên
    </a>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 fw-bold" width="45%">Tên Tài liệu</th>
                        <th class="py-3 fw-bold text-center">Danh mục</th>
                        <th class="py-3 fw-bold text-center">Ngày tạo</th>
                        <th class="text-end pe-4 py-3 fw-bold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resources)): foreach($resources as $res): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <?php if(!empty($res['thumbnail'])): 
                                    $thumbPath = "public/assets/images/" . $res['thumbnail'];
                                ?>
                                    <img src="<?= $thumbPath ?>" class="rounded me-3 border" width="50" height="50" style="object-fit: cover;" onerror="this.style.display='none'">
                                <?php else: ?>
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center me-3 border" style="width:50px; height:50px;">
                                        <i class="fas fa-file-alt text-secondary"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div>
                                    <div class="fw-bold text-dark text-wrap" style="max-width: 350px;">
                                        <?= htmlspecialchars($res['title']) ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10 rounded-pill px-3">
                                <?= htmlspecialchars($res['category'] ?? 'Khác') ?>
                            </span>
                        </td>
                        <td class="text-center text-muted small">
                            <?= date('d/m/Y', strtotime($res['created_at'])) ?>
                        </td>
                        <td class="text-end pe-4">
                            <?php if(!empty($res['file_link'])): 
                                // Nếu là file upload thì thêm đường dẫn, nếu là link online thì giữ nguyên
                                $link = (strpos($res['file_link'], 'http') === 0) ? $res['file_link'] : "public/assets/documents/" . $res['file_link'];
                            ?>
                                <a href="<?= htmlspecialchars($link) ?>" target="_blank" class="btn btn-sm btn-outline-secondary border-0 rounded-circle me-1" title="Xem/Tải">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            <?php endif; ?>
                            
                            <a href="index.php?page=admin&action=edit_resource&id=<?= $res['id'] ?>" class="btn btn-sm btn-outline-primary border-0 rounded-circle me-1" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="index.php?page=admin&action=delete_resource&id=<?= $res['id'] ?>" 
                               class="btn btn-sm btn-outline-danger border-0 rounded-circle" 
                               onclick="return confirm('Xóa tài liệu này?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">Chưa có tài liệu nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>