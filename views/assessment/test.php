<?php require_once 'views/layouts/header.php'; ?>

<section class="section" style="padding-top: 120px; background-color: #f9f9f9; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-danger text-white text-center py-4">
                        <h3 class="fw-bold mb-0">🧩 Trắc Nghiệm Định Hướng Nghề Nghiệp</h3>
                        <p class="mb-0 opacity-75">Hãy chọn những câu mô tả đúng nhất về bạn</p>
                    </div>
                    <div class="card-body p-5">
                        <form action="index.php?page=assessment&action=submit" method="POST">
                            
                            <div class="row g-4">
                                <?php foreach ($questions as $q): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check p-3 border rounded bg-white h-100 shadow-sm d-flex align-items-center">
                                        <input class="form-check-input fs-4 me-3 border-danger" type="checkbox" name="answers[]" value="<?= $q['group'] ?>" id="q<?= $q['id'] ?>" style="cursor: pointer;">
                                        <label class="form-check-label w-100" for="q<?= $q['id'] ?>" style="cursor: pointer; font-weight: 500;">
                                            <?= $q['text'] ?>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-danger btn-lg px-5 py-3 rounded-pill shadow fw-bold text-uppercase">
                                    <i class="fas fa-paper-plane me-2"></i> Xem Kết Quả Ngay
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