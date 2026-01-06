<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-edit me-2"></i>Cập nhật Tài liệu: #<?= $resource['id'] ?></h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_thumbnail" value="<?= htmlspecialchars($resource['thumbnail'] ?? '') ?>">
            <input type="hidden" name="current_file_link" value="<?= htmlspecialchars($resource['file_link'] ?? '') ?>">

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề tài liệu</label>
                        <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($resource['title']) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả ngắn / Nội dung</label>
                        <textarea name="content" class="form-control" rows="5"><?= htmlspecialchars($resource['content']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">File đính kèm hiện tại</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-light" readonly value="<?= htmlspecialchars($resource['file_link'] ?? 'Chưa có file') ?>">
                            <?php if(!empty($resource['file_link'])): ?>
                                <a href="<?= htmlspecialchars($resource['file_link']) ?>" target="_blank" class="btn btn-outline-secondary">Xem</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-success">Upload File mới (Nếu muốn thay)</label>
                            <input type="file" name="file_upload" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-success">Hoặc Link Online mới</label>
                            <input type="text" name="file_link_url" class="form-control" placeholder="https://...">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Danh mục</label>
                        <select name="category" class="form-select">
                            <?php 
                                $cats = ['Tài liệu', 'Ebook', 'Video', 'Bài viết', 'Review', 'Tin tức'];
                                foreach($cats as $c): 
                            ?>
                                <option value="<?= $c ?>" <?= ($resource['category'] == $c) ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ảnh đại diện</label>
                        <div class="mb-2 text-center border rounded p-2">
                            <?php if(!empty($resource['thumbnail'])): ?>
                                <img src="public/assets/images/<?= htmlspecialchars($resource['thumbnail']) ?>" class="img-fluid rounded" style="max-height: 150px;">
                            <?php else: ?>
                                <span class="text-muted">Chưa có ảnh</span>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill py-2">
                        <i class="fas fa-save me-2"></i> Lưu thay đổi
                    </button>
                    <a href="index.php?page=admin&action=resources" class="btn btn-light w-100 rounded-pill py-2 mt-2 border">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
</div>