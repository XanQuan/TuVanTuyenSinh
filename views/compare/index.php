<?php require_once 'views/layouts/header.php'; ?>

<style>
    .compare-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    .compare-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .vs-circle {
        width: 80px;
        height: 80px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 24px;
        color: #333;
        box-shadow: 0 0 20px rgba(0,0,0,0.15);
        z-index: 10;
        margin: 0 auto;
        border: 4px solid #f4f7f6;
    }
    .step-icon {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
</style>

<section class="section" style="padding-top: 140px; min-height: 90vh; background: #f4f7f6;">
    <div class="container">
        
        <div class="text-center mb-5">
            <h6 class="text-secondary text-uppercase ls-2">Công cụ hỗ trợ quyết định</h6>
            <h2 class="fw-bold text-dark display-5">So Sánh Ngành & Trường</h2>
            <p class="text-muted mt-3" style="max-width: 600px; margin: 0 auto;">
                Đặt hai lựa chọn lên bàn cân để phân tích sự khác biệt về 
                <span class="fw-bold text-dark">Điểm chuẩn</span>, 
                <span class="fw-bold text-dark">Học phí</span> và 
                <span class="fw-bold text-dark">Cơ hội việc làm</span>.
            </p>
        </div>

        <form action="index.php?page=compare&action=result" method="POST">
            <div class="row align-items-center position-relative">
                
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="card compare-card shadow-lg h-100">
                        <div class="card-header bg-primary text-white p-4 border-0 text-center">
                            <div class="mb-2">
                                <span class="step-icon"><i class="fas fa-1"></i></span>
                                <span class="fw-bold text-uppercase ls-1">Lựa chọn thứ nhất</span>
                            </div>
                            <h4 class="fw-bold mb-0">Đối Tượng A</h4>
                        </div>
                        <div class="card-body p-5">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-primary"><i class="fas fa-university me-2"></i>Chọn Trường Đại Học:</label>
                                <select name="uni1" class="form-select form-select-lg border-primary shadow-sm bg-light" required>
                                    <option value="" selected disabled>-- Vui lòng chọn trường --</option>
                                    <?php foreach($universities as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-primary"><i class="fas fa-book-reader me-2"></i>Chọn Ngành Học:</label>
                                <select name="major1" class="form-select form-select-lg border-primary shadow-sm bg-light" required>
                                    <option value="" selected disabled>-- Vui lòng chọn ngành --</option>
                                    <?php foreach($majors as $m): ?>
                                        <option value="<?= $m['id'] ?>"><?= $m['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 text-center my-3 position-relative">
                    <div class="vs-circle">VS</div>
                    <div class="d-none d-lg-block position-absolute start-0 end-0 top-50 translate-middle-y" style="height: 2px; background: #e0e0e0; z-index: 1;"></div>
                </div>

                <div class="col-lg-5">
                    <div class="card compare-card shadow-lg h-100">
                        <div class="card-header bg-danger text-white p-4 border-0 text-center">
                            <div class="mb-2">
                                <span class="step-icon"><i class="fas fa-2"></i></span>
                                <span class="fw-bold text-uppercase ls-1">Lựa chọn thứ hai</span>
                            </div>
                            <h4 class="fw-bold mb-0">Đối Tượng B</h4>
                        </div>
                        <div class="card-body p-5">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-danger"><i class="fas fa-university me-2"></i>Chọn Trường Đại Học:</label>
                                <select name="uni2" class="form-select form-select-lg border-danger shadow-sm bg-light" required>
                                    <option value="" selected disabled>-- Vui lòng chọn trường --</option>
                                    <?php foreach($universities as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-danger"><i class="fas fa-book-reader me-2"></i>Chọn Ngành Học:</label>
                                <select name="major2" class="form-select form-select-lg border-danger shadow-sm bg-light" required>
                                    <option value="" selected disabled>-- Vui lòng chọn ngành --</option>
                                    <?php foreach($majors as $m): ?>
                                        <option value="<?= $m['id'] ?>"><?= $m['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-dark btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold text-uppercase" style="letter-spacing: 1px; min-width: 300px;">
                    <i class="fas fa-chart-bar me-2"></i> Phân tích & So sánh ngay
                </button>
                <p class="text-muted small mt-3 fst-italic">Hệ thống sẽ hiển thị biểu đồ so sánh chi tiết giữa hai lựa chọn.</p>
            </div>
        </form>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>