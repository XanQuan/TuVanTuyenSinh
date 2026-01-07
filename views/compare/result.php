<?php require_once 'views/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<section class="section" style="padding-top: 140px; padding-bottom: 80px; background-color: #f4f7f6; min-height: 100vh;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark"><i class="fas fa-balance-scale text-primary me-2"></i>Kết Quả Phân Tích Đối Đầu</h2>
            <p class="text-muted">So sánh chi tiết lộ trình và kỹ năng thực tế</p>
        </div>

        <div class="row g-4">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; border-left: 8px solid #d63031;">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold text-danger mb-4"><i class="fas fa-robot me-2"></i>UniGuide AI Nhận Định</h4>
                        <div id="ai-content" class="lh-lg" style="font-size: 1.1rem; color: #2d3436;">
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm p-4" style="border-radius: 20px; border-top: 6px solid #0984e3;">
                    <span class="badge bg-primary mb-3 align-self-start">LỰA CHỌN A</span>
                    <h3 class="fw-bold text-dark"><?= htmlspecialchars($info1['specialization']) ?></h3>
                    <p class="text-muted mb-4"><i class="fas fa-folder-open me-2"></i>Thuộc ngành: <?= htmlspecialchars($info1['major_name']) ?></p>
                    
                    <h6 class="fw-bold text-uppercase small text-secondary">Kỹ năng cốt lõi:</h6>
                    <p class="mb-4 text-dark"><?= htmlspecialchars($info1['skills_required']) ?></p>

                    <h6 class="fw-bold text-uppercase small text-secondary">Cơ hội nghề nghiệp:</h6>
                    <p class="mb-4 text-success fw-bold"><?= htmlspecialchars($info1['career_prospects']) ?></p>

                    <h6 class="fw-bold text-uppercase small text-secondary">Môn học tiêu biểu:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php 
                        $subs1 = explode(',', $info1['subject_list']);
                        foreach($subs1 as $s): if(trim($s) != ""): ?>
                            <span class="badge bg-light text-primary border"><?= htmlspecialchars(trim($s)) ?></span>
                        <?php endif; endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm p-4" style="border-radius: 20px; border-top: 6px solid #d63031;">
                    <span class="badge bg-danger mb-3 align-self-start">LỰA CHỌN B</span>
                    <h3 class="fw-bold text-dark"><?= htmlspecialchars($info2['specialization']) ?></h3>
                    <p class="text-muted mb-4"><i class="fas fa-folder-open me-2"></i>Thuộc ngành: <?= htmlspecialchars($info2['major_name']) ?></p>
                    
                    <h6 class="fw-bold text-uppercase small text-secondary">Kỹ năng cốt lõi:</h6>
                    <p class="mb-4 text-dark"><?= htmlspecialchars($info2['skills_required']) ?></p>

                    <h6 class="fw-bold text-uppercase small text-secondary">Cơ hội nghề nghiệp:</h6>
                    <p class="mb-4 text-danger fw-bold"><?= htmlspecialchars($info2['career_prospects']) ?></p>

                    <h6 class="fw-bold text-uppercase small text-secondary">Môn học tiêu biểu:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php 
                        $subs2 = explode(',', $info2['subject_list']);
                        foreach($subs2 as $s): if(trim($s) != ""): ?>
                            <span class="badge bg-light text-danger border"><?= htmlspecialchars(trim($s)) ?></span>
                        <?php endif; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="index.php?page=compare" class="btn btn-dark rounded-pill px-5 py-3 shadow">
                <i class="fas fa-sync me-2"></i> So sánh cặp khác
            </a>
        </div>
    </div>
</section>

<script>
    // Xử lý hiển thị nội dung AI mượt mà
    const aiRawData = <?php echo json_encode($ai_analysis); ?>;
    document.getElementById('ai-content').innerHTML = marked.parse(aiRawData);
</script>

<?php require_once 'views/layouts/footer.php'; ?>