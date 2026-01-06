<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-warning fw-bold">
            <i class="fas fa-calendar-plus me-2"></i>Thêm Sự Kiện Mới
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên sự kiện <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="Ví dụ: Ngày hội Tư vấn Tuyển sinh 2026...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Địa điểm tổ chức <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control" required placeholder="Ví dụ: Hội trường A, ĐH Bách Khoa...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Nội dung chương trình, khách mời..."></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Thời gian diễn ra <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="event_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh (Banner)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text text-muted">Kích thước gợi ý: 800x450px</div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-warning w-100 fw-bold text-white rounded-pill py-2 shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> LƯU SỰ KIỆN
                    </button>
                    <a href="index.php?page=admin&action=events" class="btn btn-light w-100 rounded-pill py-2 mt-2 border">Hủy bỏ</a>
                </div>
            </div>
        </form>
    </div>
</div>