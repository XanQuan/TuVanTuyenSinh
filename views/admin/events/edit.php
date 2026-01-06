<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-warning fw-bold"><i class="fas fa-edit me-2"></i>Cập nhật Sự Kiện: #<?= $event['id'] ?></h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($event['image_url'] ?? '') ?>">
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên sự kiện</label>
                        <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($event['title']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($event['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Địa điểm tổ chức</label>
                        <input type="text" name="location" class="form-control" required value="<?= htmlspecialchars($event['location']) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Thời gian diễn ra</label>
                        <input type="datetime-local" name="event_date" class="form-control" required value="<?= date('Y-m-d\TH:i', strtotime($event['event_date'])) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh hiện tại</label>
                        <div class="mb-2 text-center border rounded p-2">
                            <?php if(!empty($event['image_url'])): ?>
                                <img src="public/assets/images/<?= htmlspecialchars($event['image_url']) ?>" class="img-fluid rounded" style="max-height: 150px;">
                            <?php else: ?>
                                <span class="text-muted">Chưa có ảnh</span>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-warning text-white w-100 fw-bold rounded-pill py-2">
                        <i class="fas fa-save me-2"></i> Lưu thay đổi
                    </button>
                    <a href="index.php?page=admin&action=events" class="btn btn-light w-100 rounded-pill py-2 mt-2 border">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
</div>