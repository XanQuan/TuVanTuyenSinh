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
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #be1e2d;
        --primary-gradient: linear-gradient(135deg, #be1e2d 0%, #ff5b5b 100%);
        --text-dark: #1f2937;
        --text-muted: #6b7280;
        --bg-body: #f3f4f6;
    }

    body {
        background-color: var(--bg-body);
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
    }

    /* CONTAINER */
    .result-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* CARDS */
    .custom-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.02);
        overflow: hidden;
        height: 100%;
        transition: transform 0.3s ease;
    }

    .custom-card:hover {
        transform: translateY(-5px);
    }

    .card-header-gradient {
        background: var(--primary-gradient);
        color: white;
        padding: 20px 30px;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: 0.5px;
    }

    /* BADGE KẾT QUẢ - ĐIỂM NHẤN */
    .dominant-wrapper {
        position: relative;
        margin-top: -40px;
        text-align: center;
        z-index: 10;
    }

    .dominant-badge {
        background: #fff;
        color: var(--primary-color);
        font-weight: 800;
        padding: 15px 40px;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(190, 30, 45, 0.15);
        display: inline-block;
        border: 4px solid #fff5f5;
        font-size: 1.8rem;
    }

    .dominant-label {
        display: block;
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 600;
        margin-top: 5px;
        text-transform: uppercase;
    }

    /* LIST NGÀNH HỌC */
    .major-list-item {
        background: #fff;
        border: 1px solid #f1f1f1;
        border-radius: 16px;
        padding: 20px 25px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .major-list-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: var(--primary-color);
        border-radius: 6px 0 0 6px;
    }

    .major-list-item:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #ffdce0;
    }

    .btn-detail {
        background: #fff0f1;
        color: var(--primary-color);
        font-weight: 600;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        transition: 0.3s;
        font-size: 0.9rem;
    }

    .btn-detail:hover {
        background: var(--primary-color);
        color: #fff;
        box-shadow: 0 4px 12px rgba(190, 30, 45, 0.3);
    }

    /* EMPTY STATE (KHI CHƯA CÓ KẾT QUẢ) */
    .empty-state-card {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .empty-icon {
        font-size: 5rem;
        color: #e5e7eb;
        margin-bottom: 20px;
    }

    /* TEXT BOX */
    .desc-box {
        background: #fff9fa;
        padding: 25px;
        border-radius: 16px;
        border: 1px dashed #fcc;
        color: #4b5563;
        line-height: 1.7;
    }
</style>

<div class="result-container">
    
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #111; letter-spacing: -1px;">Hồ Sơ Năng Lực</h1>
        <p class="text-muted fs-5">Kết quả phân tích định hướng nghề nghiệp Holland Code (RIASEC)</p>
    </div>

    <?php if ($has_valid_result): ?>
    <div class="row g-4">
        
        <div class="col-lg-5">
            <div class="custom-card">
                <div class="card-header-gradient">
                    <i class="fas fa-chart-pie"></i> BIỂU ĐỒ NĂNG LỰC
                </div>
                <div class="card-body p-0 pb-4">
                    <div class="dominant-wrapper">
                        <div class="dominant-badge">
                            <?= htmlspecialchars($result['dominant_type']) ?>
                            <span class="dominant-label">Nhóm nổi bật</span>
                        </div>
                    </div>

                    <div class="px-3 mt-2" style="position: relative; height: 350px; width: 100%;">
                        <canvas id="hollandChart"></canvas>
                    </div>

                    <div class="text-center px-4 mt-3">
                        <small class="text-muted fst-italic">
                            Biểu đồ thể hiện mức độ phù hợp của bạn với 6 nhóm tính cách đặc trưng.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="custom-card">
                <div class="card-header-gradient" style="background: #2d3748;">
                    <i class="fas fa-compass"></i> ĐỊNH HƯỚNG CHI TIẾT
                </div>
                <div class="card-body p-4 p-md-5">
                    
                    <div class="mb-5">
                        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-user-check me-2 text-danger"></i>Bạn là người thế nào?</h5>
                        <div class="desc-box">
                            <?php 
                            $descriptions = [
                                'R' => '<strong>(R) Realistic - Người Thực tế:</strong> Bạn thực tế, thích hành động hơn suy ngẫm. Bạn yêu thích làm việc với máy móc, công cụ, cây cối hoặc con vật. Phong cách của bạn là trực quan và cụ thể.',
                                'I' => '<strong>(I) Investigative - Người Nghiên cứu:</strong> Bạn là nhà tư duy, thích quan sát, phân tích và giải quyết các vấn đề phức tạp. Bạn coi trọng tri thức, khoa học và sự chính xác.',
                                'A' => '<strong>(A) Artistic - Người Nghệ thuật:</strong> Bạn sáng tạo, giàu trí tưởng tượng và cảm xúc. Bạn không thích sự gò bó, rập khuôn và luôn tìm kiếm sự độc đáo trong công việc.',
                                'S' => '<strong>(S) Social - Người Xã hội:</strong> Bạn nhân hậu và thích kết nối. Niềm vui của bạn là giúp đỡ, giảng dạy, chữa trị hoặc phục vụ cộng đồng. Bạn có khả năng giao tiếp tuyệt vời.',
                                'E' => '<strong>(E) Enterprising - Người Quản lý:</strong> Bạn năng động, tự tin và có tham vọng. Bạn thích lãnh đạo, thuyết phục người khác để đạt được mục tiêu kinh tế hoặc tổ chức.',
                                'C' => '<strong>(C) Conventional - Người Nghiệp vụ:</strong> Bạn ngăn nắp, tỉ mỉ và đáng tin cậy. Bạn thích làm việc với số liệu, hồ sơ theo quy trình rõ ràng và có tổ chức.'
                            ];
                            echo $descriptions[$result['dominant_type']] ?? 'Bạn có tính cách đa dạng và cân bằng giữa các nhóm.';
                            ?>
                        </div>
                    </div>

                    <div>
                        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-graduation-cap me-2 text-danger"></i>Ngành học đề xuất</h5>
                        <div class="majors-list">
                            <?php if (!empty($suggested_majors)): ?>
                                <?php foreach ($suggested_majors as $major): ?>
                                    <div class="major-list-item">
                                        <div>
                                            <h6 class="fw-bold m-0 text-dark mb-1"><?= htmlspecialchars($major['name']) ?></h6>
                                            <span class="badge bg-light text-secondary border">Mã: <?= htmlspecialchars($major['group_code']) ?></span>
                                        </div>
                                        <a href="index.php?page=majors&id=<?= $major['id'] ?>" class="btn-detail">
                                            Xem <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-light border text-center text-muted">
                                    Hệ thống đang cập nhật dữ liệu ngành phù hợp.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5 border-top pt-4">
                        <a href="index.php?page=assessment" class="btn btn-light rounded-pill px-4 fw-bold">
                            <i class="fas fa-redo me-2"></i>Làm lại
                        </a>
                        <a href="index.php?page=advice" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">
                            Tra cứu điểm chuẩn <i class="fas fa-search ms-2"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <div class="empty-state-card">
        <div class="empty-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <h3 class="fw-bold text-dark">Bạn chưa thực hiện bài trắc nghiệm</h3>
        <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
            Để có được hồ sơ năng lực và gợi ý ngành nghề chính xác, vui lòng dành ít phút để hoàn thành bài trắc nghiệm Holland Code.
        </p>
        <a href="index.php?page=assessment" class="btn btn-danger btn-lg rounded-pill px-5 shadow">
            Bắt đầu làm bài ngay <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
    <?php endif; ?>

</div>

<?php if ($has_valid_result): ?>
<script>
    const ctx = document.getElementById('hollandChart').getContext('2d');
    
    // Data PHP -> JS
    const dataPoints = [<?= $r ?>, <?= $i ?>, <?= $a ?>, <?= $s ?>, <?= $e ?>, <?= $c ?>];
    
    // Cấu hình Chart
    const hollandChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Thực tế (R)', 'Nghiên cứu (I)', 'Nghệ thuật (A)', 'Xã hội (S)', 'Quản lý (E)', 'Nghiệp vụ (C)'],
            datasets: [{
                label: 'Điểm số',
                data: dataPoints,
                backgroundColor: 'rgba(190, 30, 45, 0.15)',
                borderColor: '#be1e2d',
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#be1e2d',
                pointHoverBackgroundColor: '#be1e2d',
                pointHoverBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: { display: true, color: '#f0f0f0' },
                    grid: { color: '#f0f0f0', circular: true },
                    pointLabels: {
                        font: { size: 11, family: 'Inter', weight: '600' },
                        color: '#4b5563'
                    },
                    ticks: { display: false, stepSize: 2 }, // Ẩn số trên trục cho gọn
                    suggestedMin: 0,
                    // Tự động scale max theo điểm cao nhất + 2 để biểu đồ thoáng hơn
                    suggestedMax: Math.max(...dataPoints) + 2 
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