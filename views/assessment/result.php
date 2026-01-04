<?php 
require_once 'views/layouts/header.php'; 

// --- XỬ LÝ LOGIC NGAY TẠI VIEW (Để đảm bảo không hiện sai) ---
// Tính tổng điểm để kiểm tra xem người dùng đã làm bài chưa
$r = $result['r_score'] ?? 0;
$i = $result['i_score'] ?? 0;
$a = $result['a_score'] ?? 0;
$s = $result['s_score'] ?? 0;
$e = $result['e_score'] ?? 0;
$c = $result['c_score'] ?? 0;

$total_points = $r + $i + $a + $s + $e + $c;

// Chỉ hiển thị kết quả nếu biến $result tồn tại VÀ tổng điểm > 0
$has_valid_result = (isset($result) && $total_points > 0);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Card kết quả */
    .result-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 30px;
        border: none;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #be1e2d 0%, #ff5b5b 100%);
        color: white;
        padding: 20px 30px;
    }

    /* Badge điểm nổi bật */
    .dominant-badge {
        font-size: 1.2rem;
        font-weight: 800;
        background: #fff;
        color: #be1e2d;
        padding: 10px 25px;
        border-radius: 50px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        display: inline-block;
        margin-top: -30px;
        position: relative;
        z-index: 10;
    }

    /* Danh sách ngành */
    .major-item {
        border-left: 4px solid #be1e2d;
        background: #f8f9fa;
        transition: 0.3s;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 0 10px 10px 0;
    }
    .major-item:hover {
        background: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transform: translateX(5px);
    }
</style>

<div class="result-container">
    
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase">Hồ sơ năng lực của bạn</h2>
        <p class="text-muted">Dưới đây là kết quả phân tích dựa trên trắc nghiệm Holland Code</p>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="result-card h-100 pb-4">
                <div class="card-header-custom text-center">
                    <h5 class="m-0"><i class="fas fa-chart-pie me-2"></i> BIỂU ĐỒ TÍNH CÁCH</h5>
                </div>
                <div class="card-body text-center">
                    <div class="dominant-badge">
                        Nhóm nổi bật: <?= htmlspecialchars($result['dominant_type']) ?>
                    </div>
                    
                    <div class="mt-4" style="position: relative; height:300px;">
                        <canvas id="hollandChart"></canvas>
                    </div>

                    <div class="mt-4 px-3 text-start">
                        <p class="small text-muted"><i class="fas fa-info-circle"></i> <strong>Giải thích:</strong> Biểu đồ càng mở rộng về phía nào thì bạn càng có xu hướng phù hợp với nhóm tính cách đó.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="result-card h-100">
                <div class="card-header-custom bg-dark text-white">
                    <h5 class="m-0"><i class="fas fa-lightbulb me-2"></i> ĐỊNH HƯỚNG NGHỀ NGHIỆP</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    
                    <h5 class="fw-bold text-danger mb-3">1. Đặc điểm của bạn (Nhóm <?= htmlspecialchars($result['dominant_type']) ?>)</h5>
                    <p class="text-muted">
                        <?php 
                        $descriptions = [
                            'R' => 'Bạn là người thực tế, thích làm việc với công cụ, máy móc và các vật thể cụ thể. Bạn ưa thích các hoạt động ngoài trời và vận động.',
                            'I' => 'Bạn là người thích nghiên cứu, tìm tòi, phân tích và giải quyết các vấn đề khoa học. Bạn có tư duy logic và độc lập.',
                            'A' => 'Bạn là người sáng tạo, giàu trí tưởng tượng và yêu thích nghệ thuật. Bạn thích sự tự do và không gò bó.',
                            'S' => 'Bạn là người hướng về cộng đồng, thích giúp đỡ, chữa trị hoặc giảng dạy cho người khác. Bạn có khả năng giao tiếp tốt.',
                            'E' => 'Bạn là người dám nghĩ dám làm, thích lãnh đạo và thuyết phục người khác. Bạn quan tâm đến kinh tế và quản trị.',
                            'C' => 'Bạn là người tỉ mỉ, cẩn thận, thích làm việc với số liệu và tuân thủ quy trình. Bạn phù hợp với môi trường văn phòng.'
                        ];
                        echo $descriptions[$result['dominant_type']] ?? 'Bạn có tính cách đa dạng và linh hoạt.';
                        ?>
                    </p>

                    <hr class="my-4">

                    <h5 class="fw-bold text-danger mb-3">2. Ngành học phù hợp nhất</h5>
                    <?php if (!empty($suggested_majors)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($suggested_majors as $major): ?>
                                <div class="major-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold m-0"><?= htmlspecialchars($major['name']) ?></h6>
                                        <small class="text-muted"><?= htmlspecialchars($major['code']) ?></small>
                                    </div>
                                    <a href="index.php?page=majors&id=<?= $major['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill">
                                        Chi tiết <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            Chưa tìm thấy dữ liệu ngành phù hợp trong hệ thống.
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-4 text-center">
                        <a href="index.php?page=assessment" class="btn btn-secondary rounded-pill me-2">
                            <i class="fas fa-redo"></i> Làm lại
                        </a>
                        <a href="index.php?page=advice" class="btn btn-danger rounded-pill">
                            <i class="fas fa-search"></i> Tra cứu điểm chuẩn ngay
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('hollandChart').getContext('2d');
    const hollandChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Thực tế (R)', 'Nghiên cứu (I)', 'Nghệ thuật (A)', 'Xã hội (S)', 'Quản lý (E)', 'Nghiệp vụ (C)'],
            datasets: [{
                label: 'Điểm số của bạn',
                data: [
                    <?= $result['r_score'] ?>, 
                    <?= $result['i_score'] ?>, 
                    <?= $result['a_score'] ?>, 
                    <?= $result['s_score'] ?>, 
                    <?= $result['e_score'] ?>, 
                    <?= $result['c_score'] ?>
                ],
                backgroundColor: 'rgba(190, 30, 45, 0.2)', // Màu đỏ nhạt
                borderColor: 'rgba(190, 30, 45, 1)',      // Viền đỏ đậm
                borderWidth: 2,
                pointBackgroundColor: 'rgba(190, 30, 45, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(190, 30, 45, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: { display: true },
                    suggestedMin: 0,
                    suggestedMax: 5 // Thang điểm tối đa (tùy số câu hỏi)
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
</script>
<?php endif; ?>

<?php require_once 'views/layouts/footer.php'; ?>