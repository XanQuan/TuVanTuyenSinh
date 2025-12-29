 <?php require_once 'views/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="section" style="padding-top: 120px; background-color: #fff; min-height: 80vh;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-danger">Kết Quả Phân Tích Của Bạn</h2>
            <p class="text-muted">Dựa trên mô hình Holland Code (RIASEC)</p>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm p-3">
                    <canvas id="radarChart"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-danger border-2 shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="card-title text-danger fw-bold">
                            <i class="fas fa-crown me-2"></i> Nhóm nổi trội: <?= $result['dominant_type'] ?>
                        </h4>
                        <p class="card-text mt-3">
                            Bạn có xu hướng phù hợp với các lĩnh vực hoạt động liên quan đến nhóm này. 
                            Hãy cân nhắc các ngành nghề bên dưới.
                        </p>
                    </div>
                </div>

                <h5 class="fw-bold mb-3"><i class="fas fa-book-reader me-2"></i> Ngành học gợi ý cho bạn:</h5>
                <?php if (count($suggested_majors) > 0): ?>
                    <div class="list-group">
                        <?php foreach ($suggested_majors as $major): ?>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-check-circle text-success me-2"></i> <?= htmlspecialchars($major['name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Chưa tìm thấy ngành phù hợp chính xác trong cơ sở dữ liệu.</div>
                <?php endif; ?>
                
                <div class="mt-4">
                    <a href="index.php?page=assessment" class="btn btn-outline-secondary"><i class="fas fa-redo"></i> Làm lại bài test</a>
                    <a href="index.php" class="btn btn-danger"><i class="fas fa-search"></i> Tra cứu điểm chuẩn các ngành này</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Dữ liệu từ PHP
    const scores = [
        <?= $result['r_score'] ?>, // Realistic
        <?= $result['i_score'] ?>, // Investigative
        <?= $result['a_score'] ?>, // Artistic
        <?= $result['s_score'] ?>, // Social
        <?= $result['e_score'] ?>, // Enterprising
        <?= $result['c_score'] ?>  // Conventional
    ];

    const ctx = document.getElementById('radarChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'radar', // Biểu đồ mạng nhện
        data: {
            labels: ['Kỹ thuật (R)', 'Nghiên cứu (I)', 'Nghệ thuật (A)', 'Xã hội (S)', 'Quản lý (E)', 'Nghiệp vụ (C)'],
            datasets: [{
                label: 'Điểm năng lực của bạn',
                data: scores,
                backgroundColor: 'rgba(220, 53, 69, 0.2)', // Màu đỏ nhạt
                borderColor: 'rgba(220, 53, 69, 1)',       // Viền đỏ đậm
                borderWidth: 2,
                pointBackgroundColor: '#a71d2a'
            }]
        },
        options: {
            scales: {
                r: {
                    angleLines: { display: false },
                    suggestedMin: 0,
                    suggestedMax: 5 // Giả sử max là 5 câu hỏi mỗi nhóm (ở đây mình demo 3)
                }
            }
        }
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?>