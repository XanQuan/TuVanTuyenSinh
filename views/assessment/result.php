<?php require_once 'views/layouts/header.php'; ?>

<?php
// --- XỬ LÝ DỮ LIỆU LOGIC TẠI VIEW ---
if (isset($result) && is_array($result)) {
    $r = $result['r_score']; $i = $result['i_score']; $a = $result['a_score'];
    $s = $result['s_score']; $e = $result['e_score']; $c = $result['c_score'];

    $scores_array = [
        'I' => ['name' => 'Nghiên cứu (Investigative)', 'score' => $i, 'icon' => 'fa-microscope'],
        'A' => ['name' => 'Nghệ thuật (Artistic)', 'score' => $a, 'icon' => 'fa-palette'],
        'R' => ['name' => 'Thực tế (Realistic)', 'score' => $r, 'icon' => 'fa-tools'],
        'S' => ['name' => 'Xã hội (Social)', 'score' => $s, 'icon' => 'fa-hands-helping'],
        'E' => ['name' => 'Quản lý (Enterprising)', 'score' => $e, 'icon' => 'fa-briefcase'],
        'C' => ['name' => 'Nghiệp vụ (Conventional)', 'score' => $c, 'icon' => 'fa-clipboard-check']
    ];

    $max_score = max($r, $i, $a, $s, $e, $c);
    uasort($scores_array, function($a, $b) { return $b['score'] <=> $a['score']; });

    $top_types = [];
    foreach ($scores_array as $type) {
        if ($type['score'] == $max_score && $max_score > 0) {
            $top_types[] = explode(' (', $type['name'])[0];
        }
    }

    $first_top_code = array_keys($scores_array)[0];
    $details = [
        'R' => ['title' => 'Thực tế', 'strengths' => 'Khéo léo, thực tế, kiên trì, kỹ thuật tốt.', 'env' => 'Xưởng kỹ thuật, ngoài trời.'],
        'I' => ['title' => 'Nghiên cứu', 'strengths' => 'Tư duy logic, ham học hỏi, phân tích sâu.', 'env' => 'Phòng thí nghiệm, viện nghiên cứu.'],
        'A' => ['title' => 'Nghệ thuật', 'strengths' => 'Sáng tạo, thẩm mỹ cao, yêu tự do.', 'env' => 'Studio, truyền thông, thiết kế.'],
        'S' => ['title' => 'Xã hội', 'strengths' => 'Giao tiếp tốt, thấu cảm, thích giúp đỡ.', 'env' => 'Trường học, bệnh viện.'],
        'E' => ['title' => 'Quản lý', 'strengths' => 'Quyết đoán, lãnh đạo, đàm phán giỏi.', 'env' => 'Doanh nghiệp, startup.'],
        'C' => ['title' => 'Nghiệp vụ', 'strengths' => 'Tỉ mỉ, ngăn nắp, kỷ luật cao.', 'env' => 'Ngân hàng, văn phòng kế toán.']
    ];
} else { $result = null; }
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root { --primary-red: #be1e2d; }
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; }
    .result-container { max-width: 1200px; margin: 50px auto; padding: 0 15px; }
    
    /* Giữ nguyên style Card và Badge như ảnh mẫu */
    .custom-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none; overflow: hidden; height: 100%; }
    .card-header-custom { background: #be1e2d; color: white; padding: 15px 20px; font-weight: 700; display: flex; align-items: center; gap: 10px; }
    
    .dominant-badge-container { margin: 30px 0; text-align: center; }
    .dominant-badge { display: inline-block; background: #fff; color: var(--primary-red); font-weight: 800; padding: 12px 35px; border-radius: 50px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 2px solid #fcecec; }
    
    /* Bảng điểm chi tiết giống hệt ảnh image_5f90e9.png */
    .score-row { margin-bottom: 20px; padding: 0 25px; }
    .score-info { display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; }
    .progress { height: 8px; background-color: #e9ecef; border-radius: 10px; }
    .progress-bar { border-radius: 10px; }
    
    .text-best { color: #be1e2d !important; } /* Đỏ - Phù hợp nhất */
    .bg-best { background-color: #be1e2d !important; }
    .text-potential { color: #fd7e14 !important; } /* Cam - Tiềm năng */
    .bg-potential { background-color: #fd7e14 !important; }

    .major-item { background: #fff; border: 1px solid #eee; border-left: 5px solid #28a745; transition: 0.3s; margin-bottom: 10px; }
    .major-item:hover { transform: translateX(10px); background: #f8fff9; }

    @media print { .no-print { display: none !important; } }
</style>

<div class="result-container" id="report-area">
    <?php if ($result): ?>
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="custom-card pb-4">
                <div class="card-header-custom no-print"><i class="fas fa-chart-pie"></i> TỔNG QUAN TÍNH CÁCH</div>
                
                <div class="dominant-badge-container">
                    <div class="dominant-badge">NHÓM: <?= implode(" & ", $top_types) ?></div>
                </div>

                <div style="height: 320px; padding: 0 20px;"><canvas id="hollandChart"></canvas></div>

                <div class="mt-4">
                    <h6 class="fw-bold text-muted border-bottom pb-2 mb-3 mx-4"><i class="fas fa-list-ol me-2"></i>Chi tiết mức độ phù hợp</h6>
                    <?php foreach ($scores_array as $item): 
                        $isBest = ($item['score'] == $max_score);
                        $labelClass = $isBest ? 'text-best' : 'text-potential';
                        $barClass = $isBest ? 'bg-best' : 'bg-potential';
                        $statusText = $isBest ? 'Phù hợp nhất' : 'Tiềm năng';
                        $percent = ($item['score'] / 4) * 100; // Thang điểm 4 theo ảnh
                    ?>
                        <div class="score-row">
                            <div class="score-info">
                                <span><i class="fas <?= $item['icon'] ?> me-2 text-muted"></i><?= explode(' (', $item['name'])[0] ?></span>
                                <span class="<?= $labelClass ?>"><?= $item['score'] ?> <small class="fw-normal"><?= $statusText ?></small></span>
                            </div>
                            <div class="progress"><div class="progress-bar <?= $barClass ?>" style="width: <?= $percent ?>%"></div></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="custom-card">
                <div class="card-header-custom" style="background: #34495e;"><i class="fas fa-compass"></i> ĐỊNH HƯỚNG NGHỀ NGHIỆP</div>
                <div class="card-body p-4">
                    <div class="p-4 mb-4 rounded shadow-sm" style="background: #f8f9fa; border-left: 5px solid #be1e2d;">
                        <p class="mb-3">Bạn thuộc nhóm <strong><?= implode(" , ", $top_types) ?></strong>. <?= $details[$first_top_code]['desc'] ?? '' ?></p>
                        <button class="btn btn-sm btn-outline-danger rounded-pill no-print" data-bs-toggle="modal" data-bs-target="#detailModal">
                            <i class="fas fa-info-circle me-1"></i> Xem chi tiết đặc điểm nhóm
                        </button>
                    </div>

                    <h5 class="fw-bold mb-4">2. Ngành học phù hợp nhất</h5>
                    <?php if (isset($suggested_majors_grouped)): foreach ($suggested_majors_grouped as $type => $group): ?>
                        <div class="mb-4">
                            <span class="badge rounded-pill bg-light text-danger border mb-3">Nhóm <?= $type ?> - Dành cho người <?= explode(' (', $group['name'])[0] ?></span>
                            <?php foreach ($group['majors'] as $major): ?>
                                <div class="major-item d-flex justify-content-between align-items-center p-3 rounded shadow-sm">
                                    <h6 class="m-0 fw-bold"><?= htmlspecialchars($major['name']) ?></h6>
                                    <a href="index.php?page=majors&id=<?= $major['id'] ?>" class="btn btn-sm btn-light no-print">Xem <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; endif; ?>

                    <div class="mt-5 pt-4 border-top d-flex justify-content-center gap-3 no-print">
                         <button onclick="exportPDF()" class="btn btn-dark rounded-pill px-4 shadow"><i class="fas fa-file-pdf me-2"></i>Tải PDF</button>
                         <a href="index.php#search-section" class="btn btn-danger rounded-pill px-4 shadow"><i class="fas fa-search me-2"></i>Tra cứu điểm chuẩn</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'alumni'): ?>
        <div class="verify-box shadow-sm no-print">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="text-warning fw-bold mb-2"><i class="fas fa-robot me-2"></i> XÁC MINH DỮ LIỆU AI</h5>
                    <p class="mb-0 text-muted">Kết quả nhóm <strong><?= implode(" & ", $top_types) ?></strong> có khớp với bạn không?</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <form action="index.php?page=assessment&action=verify_data" method="POST">
                        <input type="hidden" name="result_id" value="<?= $_GET['id'] ?? '' ?>">
                        <button type="submit" name="confirm" value="1" class="btn btn-warning fw-bold rounded-pill px-4 me-2">Đúng</button>
                        <button type="submit" name="confirm" value="0" class="btn btn-outline-secondary rounded-pill px-3">Sai</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<div class="modal fade" id="detailModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content" style="border-radius:20px;">
    <div class="modal-header bg-dark text-white border-0"><h5 class="modal-title">Chi tiết nhóm <?= $details[$first_top_code]['title'] ?></h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
    <div class="modal-body p-4">
        <h6><i class="fas fa-star text-danger me-2"></i>Ưu điểm:</h6><p class="small text-muted"><?= $details[$first_top_code]['strengths'] ?></p>
        <h6 class="mt-3"><i class="fas fa-briefcase text-primary me-2"></i>Môi trường lý tưởng:</h6><p class="small text-muted"><?= $details[$first_top_code]['env'] ?></p>
    </div>
</div></div></div>

<script>
    // Biểu đồ Radar giữ đúng tỉ lệ 4.0 như trong ảnh image_5f90e9.png
    const ctx = document.getElementById('hollandChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Thực tế (R)', 'Nghiên cứu (I)', 'Nghệ thuật (A)', 'Xã hội (S)', 'Quản lý (E)', 'Nghiệp vụ (C)'],
            datasets: [{
                data: [<?= $r ?>, <?= $i ?>, <?= $a ?>, <?= $s ?>, <?= $e ?>, <?= $c ?>],
                backgroundColor: 'rgba(190, 30, 45, 0.2)', borderColor: '#be1e2d', borderWidth: 2, pointRadius: 3
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: { r: { beginAtZero: true, suggestedMax: 4, ticks: { stepSize: 0.5 } } },
            plugins: { legend: { display: false } }
        }
    });

    function exportPDF() {
        const element = document.getElementById('report-area');
        const opt = { margin: 10, filename: 'Bao-cao-Holland.pdf', image: { type: 'jpeg', quality: 0.98 }, html2canvas: { scale: 2 }, jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' } };
        html2pdf().set(opt).from(element).save();
    }
</script>

<?php require_once 'views/layouts/footer.php'; ?>