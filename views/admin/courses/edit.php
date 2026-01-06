<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-edit me-2"></i>Cập Nhật Khóa Học: #<?= $course['id'] ?>
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="index.php?page=admin&action=edit_course&id=<?= $course['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">TÊN KHÓA HỌC <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-lg bg-light border-0" value="<?= htmlspecialchars($course['name']) ?>" required style="border-radius: 10px;">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">GIẢNG VIÊN</label>
                            <input type="text" name="teacher" class="form-control bg-light border-0" value="<?= htmlspecialchars($course['teacher']) ?>" required style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">HỌC PHÍ</label>
                            <input type="text" name="tuition" class="form-control bg-light border-0" value="<?= htmlspecialchars($course['tuition']) ?>" required style="border-radius: 8px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">MÔ TẢ CHI TIẾT</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="6" style="border-radius: 10px;"><?= htmlspecialchars($course['description']) ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">ĐÁNH GIÁ (SAO)</label>
                        <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control bg-light border-0 fw-bold text-warning text-center" value="<?= $course['rating'] ?>" style="border-radius: 8px;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">ẢNH HIỆN TẠI</label>
                        <div class="text-center p-3 border rounded bg-white mb-2">
                            <?php 
                                $img = !empty($course['image']) ? $course['image'] : 'default.jpg';
                                $imgPath = "uploads/courses/" . $img;
                            ?>
                            <img src="<?= $imgPath ?>" class="img-fluid rounded shadow-sm" style="max-height: 180px;" onerror="this.src='https://placehold.co/300x200?text=No+Image'">
                        </div>
                        <label class="btn btn-outline-primary w-100 btn-sm" for="uploadImage">
                            <i class="fas fa-upload me-2"></i>Chọn ảnh mới
                        </label>
                        <input type="file" name="image" id="uploadImage" class="d-none" accept="image/*">
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm mb-3">
                        <i class="fas fa-save me-2"></i> LƯU THAY ĐỔI
                    </button>
                    <a href="index.php?page=admin&action=courses" class="btn btn-light w-100 rounded-pill border fw-bold text-muted">Hủy bỏ</a>
                </div>
            </div>
        </form>
    </div>
</div>