<?php require_once 'views/layouts/header.php'; ?>

<section class="section" style="padding-top: 120px; min-height: 600px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-danger text-white">
                        <h4 class="fw-bold m-0"><i class="bi bi-plus-circle"></i> Thêm Trường Đại Học Mới</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mã Trường (Viết tắt):</label>
                                <input type="text" name="code" class="form-control" placeholder="Ví dụ: BKA, SGU, FPT..." required style="text-transform: uppercase;">
                                <div class="form-text">Mã trường là duy nhất, không được trùng.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên đầy đủ của trường:</label>
                                <input type="text" name="name" class="form-control" placeholder="Ví dụ: Đại học Bách Khoa TP.HCM" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="index.php?page=admin&action=universities" class="btn btn-secondary">
                                    <i class="bi bi-arrow-return-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-save"></i> Lưu lại
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>