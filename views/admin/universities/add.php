<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-danger fw-bold">
            <i class="fas fa-university me-2"></i>Thêm Trường Đại Học Mới
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="" method="POST">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-secondary">Mã Trường (VD: QSC, BKA...)</label>
                        <input type="text" name="code" class="form-control form-control-lg bg-light" required placeholder="Nhập mã trường..." style="border-radius: 10px;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-secondary">Tên đầy đủ của trường</label>
                        <input type="text" name="name" class="form-control form-control-lg bg-light" required placeholder="VD: Đại học Quốc gia TP.HCM..." style="border-radius: 10px;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-secondary">Khu vực</label>
                        <select name="region" class="form-select form-select-lg bg-light" style="border-radius: 10px;">
                            <option value="Bac">Miền Bắc</option>
                            <option value="Trung">Miền Trung</option>
                            <option value="Nam">Miền Nam</option>
                        </select>
                    </div>

                    <div class="d-flex gap-3 mt-5">
                        <a href="index.php?page=admin&action=universities" class="btn btn-light border w-50 py-3 fw-bold rounded-pill">Quay lại</a>
                        <button type="submit" class="btn btn-danger w-50 py-3 fw-bold rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> LƯU DỮ LIỆU
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>