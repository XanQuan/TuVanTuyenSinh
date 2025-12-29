<?php require_once 'views/layouts/header.php'; ?>

<section class="section" style="padding-top: 120px; min-height: 600px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-danger text-white">
                        <h4 class="fw-bold m-0"><i class="fa fa-plus-circle"></i> Thêm Ngành Mới</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên Ngành:</label>
                                <input type="text" name="name" class="form-control" placeholder="Ví dụ: An toàn thông tin" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nhóm Ngành:</label>
                                <select name="group_code" class="form-select" required>
                                    <option value="">-- Chọn nhóm ngành --</option>
                                    <option value="IT">💻 Công nghệ thông tin (IT)</option>
                                    <option value="KT">💰 Kinh tế & Quản trị (KT)</option>
                                    <option value="YD">💊 Y Dược (YD)</option>
                                    <option value="NN">🌏 Ngôn ngữ (NN)</option>
                                    <option value="CK">⚙️ Kỹ thuật - Cơ khí (CK)</option>
                                    <option value="SP">📚 Sư phạm (SP)</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="index.php?page=admin&action=majors" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-danger">Lưu lại</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>