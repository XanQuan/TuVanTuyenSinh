<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-warning fw-bold">
            <i class="fas fa-laptop-code me-2"></i>Thêm Khóa Học Mới
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Khóa Học</label>
                        <input type="text" name="name" class="form-control" required placeholder="VD: Luyện thi đánh giá năng lực 2025...">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Giảng viên / Tổ chức</label>
                            <input type="text" name="teacher" class="form-control" required placeholder="VD: Thầy Nguyễn Văn A...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Học phí (VND)</label>
                            <input type="text" name="tuition" class="form-control" required placeholder="VD: 1.200.000đ hoặc Miễn phí">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Nội dung khóa học, đối tượng tham gia..."></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Đánh giá ban đầu (Sao)</label>
                        <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="5.0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ảnh bìa khóa học</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="mt-2 p-4 bg-light border rounded text-center">
                            <i class="fas fa-image fa-3x text-muted opacity-50"></i>
                            <p class="small text-muted mt-2 mb-0">Preview ảnh</p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning text-white w-100 fw-bold rounded-pill py-3 mt-2 shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i> TẠO KHÓA HỌC
                    </button>
                    <a href="index.php?page=admin&action=courses" class="btn btn-light w-100 rounded-pill py-3 mt-3 border">Hủy bỏ</a>
                </div>
            </div>
        </form>
    </div>
</div>