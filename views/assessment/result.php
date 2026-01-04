<?php require_once 'views/layouts/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-red: #be1e2d;
        --secondary-bg: #f8f9fa;
        --card-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    body {
        background-color: #f4f7f6;
        font-family: 'Inter', sans-serif;
    }

    /* CARD CONTAINER */
    .result-container {
        max-width: 1200px;
        margin: 100px auto 50px; /* Cách top để không bị header che */
        padding: 0 20px;
    }

    .custom-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        border: none;
        height: 100%;
    }

    /* HEADER CARD */
    .card-header-gradient {
        background: linear-gradient(135deg, #be1e2d 0%, #ff5b5b 100%);
        color: white;
        padding: 20px 30px;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* BADGE KẾT QUẢ */
    .dominant-badge {
        background: #fff;
        color: var(--primary-red);
        font-weight: 800;
        padding: 10px 25px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: inline-block;
        margin-top: -25px; /* Nổi lên trên */
        position: relative;
        z-index: 10;
        border: 2px solid #f1f1f1;
        font-size: 1.5rem;
    }

    /* DANH SÁCH NGÀNH GỢI Ý */
    .major-list-item {
        background: #fff;
        border: 1px solid #eee;
        border-left: 5px solid var(--primary-red);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        transition: 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .major-list-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: var(--primary-red);
    }

    .btn-detail {
        background: rgba(190, 30, 45, 0.1);
        color: var(--primary-red);
        font-weight: 600;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        transition: 0.3s;
    }

    .btn-detail:hover {
        background: var(--primary-red);
        color: #fff;
    }

    /* TEXT MÔ TẢ */
    .desc-box {
        background: #fdf2f3;
        padding: 20px;
        border-radius: 15px;
        border-left: 4px solid #be1e2d;
        color: #555;
        line-height: 1.6;
    }
</style>

<div class="result-container">
    
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase" style="color: #333;">Hồ Sơ Năng Lực Của Bạn</h2>
        <p class="text-muted">Kết quả phân tích trắc nghiệm Holland Code (RIASEC)</p>
    </div>

    <?php if (isset($result) && $result): ?>
    <div class="row g-4">
        
        <div class="col-lg-5">
            <div class="custom-card">
                <div class="card-header-gradient">
                    <i class="fas fa-chart-pie"></i> BIỂU ĐỒ TÍNH CÁCH
                </div>
                <div class="card-body text-center p-4">
                    <div class="dominant-badge">
                        Nhóm: <?= htmlspecialchars($result['dominant_type']) ?>
                    </div>

                    <div class="mt-4" style="position: relative; height: 320px; width: 100%;">
                        <canvas id="hollandChart"></canvas>
                    </div>

                    <div class="mt-4 text-start">
                        <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Biểu đồ thể hiện mức độ phù hợp của bạn với 6 nhóm tính cách nghề nghiệp.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="custom-card">
                <div class="card-header-gradient bg-dark text-white">
                    <i class="fas fa-lightbulb"></i> ĐỊNH HƯỚNG NGHỀ NGHIỆP
                </div>
                <div class="card-body p-4">
                    
                    <h5 class="fw-bold text-danger mb-3">1. Bạn là người thế nào?</h5>
                    <div class="desc-box mb-4">
                        <?php 
                        // Mảng mô tả cho từng nhóm tính cách
                        $descriptions = [
                            'R' => '<strong>(R) Realistic - Người Thực tế:</strong> Bạn thích làm việc với các đồ vật, máy móc, dụng cụ, cây cối, con thú hoặc các hoạt động ngoài trời. Bạn ưa thích sự cụ thể, thực hành hơn là lý thuyết suông.',
                            'I' => '<strong>(I) Investigative - Người Nghiên cứu:</strong> Bạn thích quan sát, tìm tòi, học hỏi, đánh giá, phân tích để giải quyết các vấn đề. Bạn coi trọng khoa học và sự chính xác.',
                            'A' => '<strong>(A) Artistic - Người Nghệ thuật:</strong> Bạn có khả năng nghệ thuật, sáng tạo, trực giác mạnh. Bạn thích làm việc trong các tình huống không có cấu trúc rập khuôn, thích dùng trí tưởng tượng.',
                            'S' => '<strong>(S) Social - Người Xã hội:</strong> Bạn thích làm việc với con người. Bạn thích soi sáng, giải thích, giúp đỡ, chăm sóc hoặc chữa trị cho người khác. Bạn có khả năng ngôn ngữ tốt.',
                            'E' => '<strong>(E) Enterprising - Người Quản lý:</strong> Bạn thích làm việc với con người nhưng theo hướng quản lý, lãnh đạo, thuyết phục để đạt được mục tiêu kinh tế hoặc tổ chức.',
                            'C' => '<strong>(C) Conventional - Người Nghiệp vụ:</strong> Bạn thích làm việc với dữ liệu, con số, văn bản theo một quy trình, trật tự rõ ràng. Bạn cẩn trọng, tỉ mỉ và có trách nhiệm.'
                        ];
                        echo $descriptions[$result['dominant_type']] ?? 'Bạn có tính cách đa dạng và cân bằng giữa các nhóm.';
                        ?>
                    </div>

                    <h5 class="fw-bold text-danger mb-3">2. Ngành học phù hợp nhất</h5>
                    <div class="majors-list">
                        <?php if (!empty($suggested_majors)): ?>
                            <?php foreach ($suggested_majors as $major): ?>
                                <div class="major-list-item">
                                    <div>
                                        <h6 class="fw-bold m-0 text-dark"><?= htmlspecialchars($major['name']) ?></h6>
                                        <small class="text-muted">Mã ngành: <?= htmlspecialchars($major['group_code']) ?></small>
                                    </div>
                                    <a href="index.php?page=majors&id=<?= $major['id'] ?>" class="btn-detail">
                                        Chi tiết <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                Chưa tìm thấy dữ liệu ngành phù hợp trong hệ thống.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="text-center mt-5">
                        <a href="index.php?page=assessment" class="btn btn-secondary rounded-pill px-4 py-2 me-2">
                            <i class="fas fa-redo me-2"></i> Làm lại
                        </a>
                        <a href="index.php?page=advice" class="btn btn-danger rounded-pill px-4 py-2">
                            <i class="fas fa-search me-2"></i> Tra cứu điểm chuẩn
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger text-center py-5">
            <h4><i class="fas fa-exclamation-triangle"></i> Không tìm thấy kết quả!</h4>
            <p>Có thể bạn chưa làm bài trắc nghiệm hoặc ID kết quả không hợp lệ.</p>
            <a href="index.php?page=assessment" class="btn btn-primary mt-3">Làm bài test ngay</a>
        </div>
    <?php endif; ?>

</div>

<?php if (isset($result)): ?>
<script>
    const ctx = document.getElementById('hollandChart').getContext('2d');
    
    // Dữ liệu từ PHP đổ vào JS
    const r_score = <?= $result['r_score'] ?>;
    const i_score = <?= $result['i_score'] ?>;
    const a_score = <?= $result['a_score'] ?>;
    const s_score = <?= $result['s_score'] ?>;
    const e_score = <?= $result['e_score'] ?>;
    const c_score = <?= $result['c_score'] ?>;

    const hollandChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [
                'Thực tế (R)', 
                'Nghiên cứu (I)', 
                'Nghệ thuật (A)', 
                'Xã hội (S)', 
                'Quản lý (E)', 
                'Nghiệp vụ (C)'
            ],
            datasets: [{
                label: 'Điểm số của bạn',
                data: [r_score, i_score, a_score, s_score, e_score, c_score],
                backgroundColor: 'rgba(190, 30, 45, 0.2)', // Màu nền đỏ nhạt
                borderColor: '#be1e2d',                    // Viền đỏ đậm
                borderWidth: 2,
                pointBackgroundColor: '#be1e2d',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#be1e2d',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: { display: true, color: '#eee' },
                    grid: { color: '#eee' },
                    pointLabels: {
                        font: { size: 12, weight: 'bold' },
                        color: '#333'
                    },
                    suggestedMin: 0,
                    suggestedMax: 10 // Giả sử max điểm là 10, bạn có thể chỉnh lại
                }
            },
            plugins: {
                legend: { display: false } // Ẩn chú thích cho gọn
            }
        }
    });
</script>
<?php endif; ?>

<?php require_once 'views/layouts/footer.php'; ?>