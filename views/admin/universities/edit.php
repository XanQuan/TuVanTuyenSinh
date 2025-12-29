<?php require_once 'views/layouts/header.php'; ?>

<section class="section" style="padding-top: 120px; min-height: 600px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="fw-bold m-0"><i class="bi bi-pencil-square"></i> Cập Nhật Thông Tin Trường</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mã Trường:</label>
                                <input type="text" name="code" class="form-control" 
                                       value="<?= htmlspecialchars($university['code']) ?>" required style="text-transform: uppercase;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên đầy đủ:</label>
                                <input type="text" name="name" class="form-control" 
                                       value="<?= htmlspecialchars($university['name']) ?>" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="index.php?page=admin&action=universities" class="btn btn-secondary">
                                    <i class="bi bi-arrow-return-left"></i> Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-warning fw-bold">
                                    <i class="bi bi-check-circle"></i> Lưu thay đổi
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