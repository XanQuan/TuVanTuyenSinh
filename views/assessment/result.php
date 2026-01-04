<?php require_once 'views/layouts/header.php'; ?>

<?php
// Kiểm tra xem có dữ liệu kết quả không
if (isset($result) && is_array($result)) {
    $r = $result['r_score'];
    $i = $result['i_score'];
    $a = $result['a_score'];
    $s = $result['s_score'];
    $e = $result['e_score'];
    $c = $result['c_score'];

    // Tạo mảng dữ liệu để dễ xử lý vòng lặp
    $scores_array = [
        'R' => ['code' => 'R', 'name' => 'Thực tế (Realistic)', 'score' => $r, 'icon' => 'fa-tools'],
        'I' => ['code' => 'I', 'name' => 'Nghiên cứu (Investigative)', 'score' => $i, 'icon' => 'fa-microscope'],
        'A' => ['code' => 'A', 'name' => 'Nghệ thuật (Artistic)', 'score' => $a, 'icon' => 'fa-palette'],
        'S' => ['code' => 'S', 'name' => 'Xã hội (Social)', 'score' => $s, 'icon' => 'fa-hands-helping'],
        'E' => ['code' => 'E', 'name' => 'Quản lý (Enterprising)', 'score' => $e, 'icon' => 'fa-briefcase'],
        'C' => ['code' => 'C', 'name' => 'Nghiệp vụ (Conventional)', 'score' => $c, 'icon' => 'fa-clipboard-check']
    ];

    // Tìm điểm cao nhất
    $max_score = max($r, $i, $a, $s, $e, $c);

    // Sắp xếp mảng giảm dần theo điểm
    uasort($scores_array, function($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    // Tìm tất cả các nhóm có điểm bằng max_score (Xử lý đa tiềm năng)
    $top_types = [];
    foreach ($scores_array as $type) {
        if ($type['score'] == $max_score && $max_score > 0) {
            $top_types[] = $type['name'];
        }
    }
} else {
    $result = null; // Đảm bảo biến result null nếu không có data
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-red: #be1e2d;
        --secondary-bg: #f8f9fa;
        --text-color: #333;
    }
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; }
    
    .result-container { max-width: 1140px; margin: 50px auto; padding: 0 15px; }

    /* CARD STYLES */
    .custom-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: none;
        overflow: hidden;
        height: 100%;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #be1e2d, #ff6b6b);
        color: white;
        padding: 15px 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* BADGE & CHART */
    .dominant-badge {
        display: inline-block;
        background: #fff;
        color: var(--primary-red);
        font-weight: 800;
        padding: 10px 30px;
        border-radius: 50px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border: 2px solid #fcecec;
        position: relative;
        top: -25px; /* Nổi lên trên card */
    }

    .chart-container {
        position: relative;
        height: 320px;
        width: 100%;
        margin-top: 10px; /* Đẩy xuống để ko bị badge che */
        padding: 0 15px;
    }

    /* PROGRESS BARS (THANH ĐIỂM SỐ) */
    .score-row { margin-bottom: 12px; }
    .score-info { display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: 600; margin-bottom: 5px; }
    
    .progress { height: 8px; background-color: #e9ecef; border-radius: 10px; overflow: hidden; }
    .progress-bar { border-radius: 10px; transition: width 1s ease; }

    /* MÀU SẮC LOGIC */
    .bg-best { background-color: #be1e2d !important; } /* Đỏ - Cao nhất */
    .bg-good { background-color: #fd7e14 !important; } /* Cam - Tiềm năng */
    .bg-normal { background-color: #adb5bd !important; } /* Xám - Thấp */

    /* LIST NGÀNH */
    .major-item {
        background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 15px; margin-bottom: 10px;
        display: flex; justify-content: space-between; align-items: center; transition: 0.2s;
    }
    .major-item:hover { border-color: var(--primary-red); transform: translateX(5px); }
    .btn-view { color: var(--primary-red); background: #fff0f0; border: none; padding: 5px 15px; border-radius: 20px; font-weight: 600; font-size: 0.85rem; }
    .btn-view:hover { background: var(--primary-red); color: #fff; }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 20px; }
</style>

<div class="result-container">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase" style="color: #2c3e50;">Hồ Sơ Năng Lực</h2>
        <p class="text-muted">Kết quả phân tích trắc nghiệm định hướng nghề nghiệp Holland Code</p>
    </div>

    <?php if ($result && $max_score > 0): ?>
    <div class="row g-4">
        
        <div class="col-lg-5">
            <div class="custom-card pb-4">
                <div class="card-header-custom">
                    <i class="fas fa-chart-pie"></i> TỔNG QUAN TÍNH CÁCH
                </div>
                
                <div class="text-center">
                    <div class="dominant-badge">
                        NHÓM: <?= implode(" & ", array_map(function($t){ return substr($t, 0, strpos($t, '(')); }, $top_types)) ?>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="hollandChart"></canvas>
                </div>

                <div class="px-4 mt-3">
                    <h6 class="fw-bold text-muted border-bottom pb-2 mb-3"><i class="fas fa-list-ol me-2"></i>Chi tiết mức độ phù hợp</h6>
                    
                    <?php foreach ($scores_array as $item): 
                        // LOGIC MÀU SẮC
                        if ($item['score'] == $max_score) {
                            $color = 'bg-best'; $text = 'Phù hợp nhất'; $text_color = 'text-danger';
                        } elseif ($item['score'] >= ($max_score - 2) && $item['score'] > 0) {
                            $color = 'bg-good'; $text = 'Tiềm năng'; $text_color = 'text-warning';
                        } else {
                            $color = 'bg-normal'; $text = ''; $text_color = 'text-muted';
                        }
                        
                        // Tính % thanh bar (lấy mốc max là 10 điểm hoặc max_score)
                        $percent = ($max_score > 0) ? ($item['score'] / $max_score) * 100 : 0;
                    ?>
                        <div class="score-row">
                            <div class="score-info">
                                <span><i class="fas <?= $item['icon'] ?> me-2 text-muted" style="width:20px"></i><?= $item['name'] ?></span>
                                <span class="<?= $text_color ?>"><?= $item['score'] ?> <small class="fw-normal"><?= $text ?></small></span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar <?= $color ?>" style="width: <?= $percent ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="custom-card">
                <div class="card-header-custom" style="background: #34495e;">
                    <i class="fas fa-compass"></i> ĐỊNH HƯỚNG NGHỀ NGHIỆP
                </div>
                <div class="card-body p-4">
                    
                    <h5 class="fw-bold text-danger mb-3">1. Bạn là người thế nào?</h5>
                    <div class="p-3 mb-4 rounded" style="background: #fff5f5; border-left: 4px solid #be1e2d;">
                        <?php if (count($top_types) > 1): ?>
                            <p><strong>Bạn là người Đa tiềm năng!</strong> Bạn sở hữu sự kết hợp mạnh mẽ giữa các nhóm tính cách: 
                            <strong><?= implode(", ", $top_types) ?></strong>. Điều này cho thấy bạn có khả năng thích nghi tốt và thành công trong nhiều môi trường khác nhau.</p>
                        <?php else: ?>
                            <p>Nhóm tính cách nổi bật nhất của bạn là: <strong><?= $top_types[0] ?></strong>.</p>
                        <?php endif; ?>
                        
                        <hr style="opacity: 0.1">
                        <?php 
                            $descriptions = [
                                'R' => 'Bạn thực tế, thích hành động hơn suy ngẫm. Bạn yêu thích làm việc với máy móc, công cụ, thế giới tự nhiên.',
                                'I' => 'Bạn thích quan sát, tìm tòi, phân tích và giải quyết các vấn đề phức tạp. Bạn coi trọng khoa học.',
                                'A' => 'Bạn có khả năng nghệ thuật, sáng tạo, trực giác mạnh và thích làm việc trong môi trường tự do.',
                                'S' => 'Bạn thích làm việc với con người: giúp đỡ, chăm sóc, giảng dạy hoặc chia sẻ thông tin.',
                                'E' => 'Bạn thích lãnh đạo, thuyết phục người khác để đạt được mục tiêu kinh tế hoặc tổ chức.',
                                'C' => 'Bạn thích làm việc với dữ liệu, con số theo quy trình rõ ràng, ngăn nắp và cẩn trọng.'
                            ];
                            // Lấy mã của nhóm cao nhất đầu tiên để hiện mô tả
                            $first_top_code = array_keys($scores_array)[0]; 
                            echo $descriptions[$first_top_code] ?? '';
                        ?>
                    </div>

                    <h5 class="fw-bold text-danger mb-3">2. Ngành học đề xuất</h5>
                    <div class="majors-list">
                        <?php if (!empty($suggested_majors)): ?>
                            <?php foreach ($suggested_majors as $major): ?>
                                <div class="major-item">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark"><?= $major['name'] ?></h6>
                                        <span class="badge bg-light text-secondary border">Mã: <?= $major['group_code'] ?></span>
                                    </div>
                                    <a href="index.php?page=majors&id=<?= $major['id'] ?>" class="btn-view">Chi tiết <i class="fas fa-arrow-right"></i></a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">Hệ thống đang cập nhật dữ liệu ngành phù hợp với nhóm tính cách của bạn.</div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4 text-end">
                         <a href="index.php?page=assessment" class="btn btn-secondary rounded-pill px-4 me-2"><i class="fas fa-redo"></i> Làm lại</a>
                         <a href="index.php?page=advice" class="btn btn-danger rounded-pill px-4"><i class="fas fa-search"></i> Tra cứu điểm chuẩn</a>
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
                    label: 'Điểm số',
                    data: [<?= $r ?>, <?= $i ?>, <?= $a ?>, <?= $s ?>, <?= $e ?>, <?= $c ?>],
                    backgroundColor: 'rgba(190, 30, 45, 0.15)',
                    borderColor: '#be1e2d',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#be1e2d',
                    pointHoverBackgroundColor: '#be1e2d',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: '#eee' },
                        grid: { color: '#eee' },
                        pointLabels: { font: { size: 11, weight: 'bold' }, color: '#555' },
                        suggestedMin: 0,
                        suggestedMax: <?= $max_score + 2 ?> // Tự động nới rộng biểu đồ
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    </script>

    <?php else: ?>
    <div class="empty-state shadow">
        <div class="mb-3 text-secondary" style="font-size: 4rem;"><i class="fas fa-clipboard-list"></i></div>
        <h3>Bạn chưa thực hiện bài trắc nghiệm</h3>
        <p class="text-muted">Vui lòng dành chút thời gian hoàn thành bài test để nhận kết quả phân tích.</p>
        <a href="index.php?page=assessment" class="btn btn-danger btn-lg rounded-pill px-5 mt-3">Bắt đầu ngay</a>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'views/layouts/footer.php'; ?>