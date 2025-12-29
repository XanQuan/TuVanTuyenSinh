<?php require_once 'views/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="section" style="padding-top: 140px; padding-bottom: 80px; background-color: #f9f9f9; min-height: 100vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1"><i class="fas fa-chart-line me-2 text-danger"></i>Kết Quả So Sánh</h2>
                <p class="text-muted mb-0">Phân tích chi tiết giữa hai lựa chọn của bạn</p>
            </div>
            <a href="index.php?page=compare" class="btn btn-outline-dark rounded-pill px-4">
                <i class="fas fa-redo me-2"></i> So sánh cặp khác
            </a>
        </div>

        <div class="card shadow-lg border-0 overflow-hidden" style="border-radius: 20px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table text-center align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr class="text-white">
                                <th width="20%" class="py-4 bg-dark text-uppercase small ls-1">Tiêu chí so sánh</th>
                                <th width="40%" class="py-4 position-relative" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                                    <div class="badge bg-white text-primary mb-2 shadow-sm px-3 py-2 rounded-pill"><?= htmlspecialchars($info1['uni_code']) ?></div>
                                    <h5 class="mb-0 fw-bold text-white"><?= htmlspecialchars($info1['major_name']) ?></h5>
                                </th>
                                <th width="40%" class="py-4 position-relative" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);">
                                    <div class="badge bg-white text-danger mb-2 shadow-sm px-3 py-2 rounded-pill"><?= htmlspecialchars($info2['uni_code']) ?></div>
                                    <h5 class="mb-0 fw-bold text-white"><?= htmlspecialchars($info2['major_name']) ?></h5>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold bg-light text-start ps-5 text-secondary">TRƯỜNG ĐẠI HỌC</td>
                                <td class="fw-bold text-primary py-4 fs-5"><?= htmlspecialchars($info1['uni_name']) ?></td>
                                <td class="fw-bold text-danger py-4 fs-5"><?= htmlspecialchars($info2['uni_name']) ?></td>
                            </tr>
                            
                            <tr>
                                <td class="fw-bold bg-light text-start ps-5 text-secondary">HỌC PHÍ (DỰ KIẾN)</td>
                                <td class="py-3 text-dark"><?= htmlspecialchars($info1['tuition']) ?></td>
                                <td class="py-3 text-dark"><?= htmlspecialchars($info2['tuition']) ?></td>
                            </tr>

                            <tr>
                                <td class="fw-bold bg-light text-start ps-5 text-secondary">CƠ HỘI VIỆC LÀM</td>
                                <td class="py-3">
                                    <div class="d-inline-block bg-light px-3 py-1 rounded-pill">
                                        <?php for($i=1; $i<=5; $i++) echo ($i <= $info1['job_rating']) ? '<i class="fas fa-star text-warning"></i>' : '<i class="far fa-star text-muted opacity-25"></i>'; ?>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="d-inline-block bg-light px-3 py-1 rounded-pill">
                                        <?php for($i=1; $i<=5; $i++) echo ($i <= $info2['job_rating']) ? '<i class="fas fa-star text-warning"></i>' : '<i class="far fa-star text-muted opacity-25"></i>'; ?>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold bg-light text-start ps-5 text-secondary">ĐẶC ĐIỂM NGÀNH</td>
                                <td class="text-muted fst-italic px-5 py-3 small line-height-lg"><?= htmlspecialchars($info1['description']) ?></td>
                                <td class="text-muted fst-italic px-5 py-3 small line-height-lg"><?= htmlspecialchars($info2['description']) ?></td>
                            </tr>

                            <tr style="border-top: 2px solid #eee;">
                                <td class="fw-bold bg-light text-start ps-5 text-secondary align-top pt-4">BIẾN ĐỘNG ĐIỂM CHUẨN</td>
                                <td colspan="2" class="p-4 bg-white">
                                    <div style="height: 400px; width: 100%;">
                                        <canvas id="scoreChart"></canvas>
                                    </div>
                                    <p class="text-center text-muted small mt-2 fst-italic">* Biểu đồ thể hiện xu hướng điểm chuẩn qua 3 năm gần nhất</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // 1. Chuẩn bị dữ liệu từ PHP
    const labels = [2023, 2024, 2025]; 

    // Hàm lấy điểm an toàn
    function getScore(data, year) {
        const found = data.find(item => item.year == year);
        return found ? found.score : null; // Nếu không có điểm trả về null để biểu đồ ngắt quãng
    }

    const data1 = <?php echo json_encode($scores1); ?>;
    const data2 = <?php echo json_encode($scores2); ?>;

    // 2. Cấu hình Chart.js
    const ctx = document.getElementById('scoreChart').getContext('2d');
    
    // Tạo màu Gradient
    let gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
    gradient1.addColorStop(0, 'rgba(13, 110, 253, 0.5)');   
    gradient1.addColorStop(1, 'rgba(13, 110, 253, 0.0)');

    let gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
    gradient2.addColorStop(0, 'rgba(220, 53, 69, 0.5)');   
    gradient2.addColorStop(1, 'rgba(220, 53, 69, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: '<?= $info1['uni_code'] ?>',
                    data: labels.map(y => getScore(data1, y)),
                    borderColor: '#0d6efd', // Màu xanh
                    backgroundColor: gradient1,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#0d6efd',
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: '<?= $info2['uni_code'] ?>',
                    data: labels.map(y => getScore(data2, y)),
                    borderColor: '#dc3545', // Màu đỏ
                    backgroundColor: gradient2,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#dc3545',
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, padding: 20, font: { size: 14 } } },
                tooltip: { 
                    mode: 'index', 
                    intersect: false,
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                y: { 
                    beginAtZero: false, 
                    min: 15, // QUAN TRỌNG: Giúp biểu đồ không bị bẹt xuống đáy
                    max: 32, // Giới hạn trên khoảng 32 điểm cho đẹp
                    title: { display: true, text: 'Điểm chuẩn (Thang 30)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?>