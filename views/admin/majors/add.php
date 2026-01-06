<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-book-open me-2"></i>Thêm Ngành Đào Tạo Mới
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Ngành học</label>
                        <input type="text" name="name" class="form-control" required placeholder="VD: Công nghệ thông tin...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="6" placeholder="Giới thiệu về ngành, cơ hội việc làm..."></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nhóm Ngành (Holland)</label>
                        <select name="group_code" class="form-select" required>
                            <option value="" disabled selected>-- Chọn nhóm --</option>
                            <option value="R">R - Kỹ thuật</option>
                            <option value="I">I - Nghiên cứu</option>
                            <option value="A">A - Nghệ thuật</option>
                            <option value="S">S - Xã hội</option>
                            <option value="E">E - Quản lý</option>
                            <option value="C">C - Nghiệp vụ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh minh họa</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="mt-2 p-3 bg-light border rounded text-center text-muted small">
                            <i class="fas fa-image fa-2x mb-2"></i><br>
                            Kích thước gợi ý: 800x600px
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill py-3 mt-2 shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i> THÊM NGÀNH
                    </button>
                    <a href="index.php?page=admin&action=majors" class="btn btn-light border w-100 rounded-pill py-2 mt-3">Hủy bỏ</a>
                </div>
            </div>
        </form>
    </div>
</div>