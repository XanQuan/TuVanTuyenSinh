<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid p-4">
    <h4 class="fw-bold mb-4"><i class="fas fa-chart-pie text-danger"></i> Thống kê Kết quả Trắc nghiệm</h4>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Tỷ lệ các nhóm tính cách</h5>
                <div style="height: 400px;">
                    <canvas id="statsChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Chi tiết số lượng</h5>
                <ul class="list-group list-group-flush">
                    <?php foreach ($stats as $s): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Nhóm <?= $s['dominant_type'] ?>
                        <span class="badge bg-danger rounded-pill"><?= $s['count'] ?> lượt</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('statsChart').getContext('2d');
    const statsChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [<?php foreach($stats as $s) echo "'Nhóm ".$s['dominant_type']."',"; ?>],
            datasets: [{
                data: [<?php foreach($stats as $s) echo $s['count'].","; ?>],
                backgroundColor: ['#dc2626', '#2563eb', '#16a34a', '#fbbf24', '#8b5cf6', '#64748b']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>