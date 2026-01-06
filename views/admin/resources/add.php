<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-cloud-upload-alt me-2"></i>Thêm Tài Liệu / Bài Viết
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề tài liệu <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" required placeholder="Nhập tiêu đề...">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nội dung / Mô tả ngắn</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="Mô tả nội dung tài liệu..."></textarea>
                    </div>

                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3"><i class="fas fa-paperclip me-2"></i>Đính kèm Tài liệu (Chọn 1 trong 2)</h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">CÁCH 1: UPLOAD FILE (PDF/ZIP)</label>
                                    <input type="file" name="file_upload" class="form-control">
                                </div>
                                <div class="col-md-6 border-start">
                                    <label class="form-label small fw-bold text-muted">CÁCH 2: LINK ONLINE (DRIVER/YOUTUBE)</label>
                                    <input type="text" name="file_link_url" class="form-control" placeholder="https://...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Danh mục</label>
                        <select name="category" class="form-select form-select-lg bg-light border-0">
                            <option value="Tài liệu">Tài liệu học tập</option>
                            <option value="Ebook">Ebook / Sách</option>
                            <option value="Video">Video hướng nghiệp</option>
                            <option value="Bài viết">Bài viết / Blog</option>
                            <option value="Review">Review Ngành/Trường</option>
                            <option value="Tin tức">Tin tức</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ảnh Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill py-3 shadow-sm">
                        <i class="fas fa-upload me-2"></i> ĐĂNG TÀI LIỆU
                    </button>
                    <a href="index.php?page=admin&action=resources" class="btn btn-light w-100 rounded-pill py-2 mt-2 border">Hủy bỏ</a>
                </div>
            </div>
        </form>
    </div>
</div>