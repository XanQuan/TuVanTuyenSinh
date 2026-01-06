<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UniGuide</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* --- 1. SIDEBAR STYLE (Cột trái cố định) --- */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); /* Màu đỏ thương hiệu */
            color: #fff;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto; /* Cho phép cuộn nếu menu dài */
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-menu {
            padding: 10px 0;
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu ul li a {
            padding: 15px 25px;
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-weight: 500;
        }

        .sidebar-menu ul li a:hover, 
        .sidebar-menu ul li a.active {
            color: #fff;
            background-color: rgba(255,255,255,0.15);
            border-left: 4px solid #ffcc00; /* Vệt sáng màu vàng */
        }

        .sidebar-menu ul li a i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* --- 2. MAIN CONTENT STYLE (Khung phải) --- */
        .main-content {
            margin-left: 260px; /* Chừa chỗ cho sidebar */
            transition: all 0.3s;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* Content Body Wrapper */
        .content-body {
            flex: 1;
            padding: 25px;
        }

        /* --- 3. DASHBOARD WIDGETS (Chỉ dùng cho trang chủ Dashboard) --- */
        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            background: #fff;
        }
        .card-stat:hover { transform: translateY(-5px); }
        .card-stat .card-body {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .bg-red-light { background: #fee2e2; color: #dc2626; }
        .bg-blue-light { background: #dbeafe; color: #2563eb; }
        .bg-green-light { background: #dcfce7; color: #16a34a; }
        
        .table-card { border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        /* Ẩn thanh cuộn xấu xí trên Chrome */
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
    </style>
</head>
<body>

    <?php 
        // 1. Xác định trang đang xem để Active menu
        // Mặc định là 'index' (Dashboard)
        $act = isset($_GET['action']) ? $_GET['action'] : 'index'; 
    ?>

    <div class="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0 fw-bold"><i class="fas fa-graduation-cap"></i> UniGuide</h4>
            <small class="opacity-75">Admin Control Panel</small>
        </div>
        
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="index.php?page=admin" class="<?= ($act == 'index') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Bảng điều khiển
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=admin&action=universities" 
                       class="<?= in_array($act, ['universities', 'add_university', 'edit_university']) ? 'active' : '' ?>">
                        <i class="fas fa-university"></i> Quản lý Trường ĐH
                    </a>
                </li>

                <li>
                    <a href="index.php?page=admin&action=majors" 
                       class="<?= in_array($act, ['majors', 'add_major']) ? 'active' : '' ?>">
                        <i class="fas fa-book-open"></i> Quản lý Ngành Học
                    </a>
                </li>

                <li>
                    <a href="index.php?page=admin&action=scores" 
                       class="<?= in_array($act, ['scores', 'add_score', 'edit_score']) ? 'active' : '' ?>">
                        <i class="fas fa-chart-line"></i> Quản lý Điểm Chuẩn
                    </a>
                </li>

                <li>
                    <a href="index.php?page=admin&action=courses" 
                       class="<?= in_array($act, ['courses', 'add_course', 'edit_course']) ? 'active' : '' ?>">
                        <i class="fas fa-laptop-code"></i> Quản lý Khóa Học
                    </a>
                </li>

                <li>
                    <a href="index.php?page=admin&action=questions" 
                       class="<?= in_array($act, ['questions', 'add_question']) ? 'active' : '' ?>">
                        <i class="fas fa-question-circle"></i> Câu hỏi Trắc nghiệm
                    </a>
                </li>

                <li>
                    <a href="index.php?page=admin&action=chat_logs" 
                       class="<?= in_array($act, ['chat_logs', 'chat_detail']) ? 'active' : '' ?>">
                        <i class="fas fa-history"></i> Nhật ký Tư vấn AI
                    </a>
                </li>

                <li>
                    <a href="index.php?page=admin&action=users" 
                       class="<?= in_array($act, ['users', 'edit_user']) ? 'active' : '' ?>">
                        <i class="fas fa-users-cog"></i> Quản lý Người dùng
                    </a>
                </li>
                <li>
    <a href="index.php?page=admin&action=events" 
       class="<?= in_array($act, ['events', 'add_event']) ? 'active' : '' ?>">
        <i class="fas fa-calendar-check"></i> Quản lý Sự kiện
    </a>
</li>

<li>
    <a href="index.php?page=admin&action=mentors" 
       class="<?= in_array($act, ['mentors', 'add_mentor']) ? 'active' : '' ?>">
        <i class="fas fa-chalkboard-teacher"></i> Chuyên gia (Mentors)
    </a>
</li>

<li>
    <a href="index.php?page=admin&action=resources" 
       class="<?= in_array($act, ['resources', 'add_resource']) ? 'active' : '' ?>">
        <i class="fas fa-file-alt"></i> Quản lý Tài liệu
    </a>
</li>
                
                <li style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                    <a href="index.php?page=logout" class="text-warning">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-md-none me-3"><i class="fas fa-bars"></i></button>
                <h5 class="m-0 text-dark fw-bold">Hệ thống quản trị</h5>
            </div>
            
            <div class="user-info d-flex align-items-center gap-3">
                <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-home"></i> Xem trang chủ
                </a>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="admin" width="35" height="35" class="rounded-circle me-2 border">
                        <span class="d-none d-md-inline fw-semibold">Quản trị viên</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="index.php?page=profile"><i class="fas fa-user me-2"></i>Hồ sơ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="index.php?page=logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-body container-fluid">
            
            <?php 
            // ================= LOGIC HIỂN THỊ NỘI DUNG =================
            // Kiểm tra biến $content_view được truyền từ Controller
            // Nếu có -> Load file con (VD: courses/index.php)
            // Nếu không -> Load Dashboard mặc định
            
            if (isset($content_view) && file_exists($content_view)) {
                require_once $content_view;
            } else {
            ?>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card card-stat">
                            <div class="card-body">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase small fw-bold">Tổng lượt truy cập</p>
                                    <h2 class="fw-bold text-dark mb-0"><?= number_format($count_visits ?? 0) ?></h2>
                                </div>
                                <div class="stat-icon bg-red-light"><i class="fas fa-eye"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat">
                            <div class="card-body">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase small fw-bold">Học sinh đăng ký</p>
                                    <h2 class="fw-bold text-dark mb-0"><?= number_format($count_users ?? 0) ?></h2>
                                </div>
                                <div class="stat-icon bg-blue-light"><i class="fas fa-user-plus"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat">
                            <div class="card-body">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase small fw-bold">Trường Đại học</p>
                                    <h2 class="fw-bold text-dark mb-0"><?= number_format($count_unis ?? 0) ?></h2>
                                </div>
                                <div class="stat-icon bg-green-light"><i class="fas fa-university"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-4">
                        <div class="card table-card h-100 p-3">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">Cơ cấu trắc nghiệm Holland</h6>
                            <div style="height: 250px; position: relative;">
                                <canvas id="hollandPieChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card table-card h-100 p-3">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">Top 5 Ngành được quan tâm</h6>
                            <div style="height: 250px; position: relative;">
                                <canvas id="majorBarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card table-card h-100 p-3 text-center text-white" 
                             style="background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);">
                            <h6 class="fw-bold mb-4 opacity-75">Độ Chính Xác AI</h6>
                            <div class="py-3">
                                <h1 class="display-3 fw-bold text-warning"><?= $accuracy_rate ?? 0 ?>%</h1>
                                <p class="small opacity-75">Dựa trên phản hồi từ Alumni</p>
                            </div>
                            <div class="progress bg-white bg-opacity-25" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: <?= $accuracy_rate ?? 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card table-card">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0"><i class="fas fa-history me-2"></i>Hoạt động Tư vấn AI gần đây</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary small text-uppercase">
                                    <tr>
                                        <th class="ps-4">Người dùng</th>
                                        <th>Câu hỏi</th>
                                        <th>Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_activities)): ?>
                                        <?php foreach ($recent_activities as $act): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($act['fullname'] ?? 'Ẩn danh') ?></td>
                                            <td class="text-muted text-truncate" style="max-width: 300px;">
                                                <?= htmlspecialchars(mb_substr($act['user_message'] ?? '', 0, 60)) ?>...
                                            </td>
                                            <td><small class="text-muted"><?= date('H:i d/m', strtotime($act['created_at'])) ?></small></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center py-4 text-muted">Chưa có dữ liệu mới</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php } // Kết thúc Else (Dashboard Mặc định) ?>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <?php if (!isset($content_view)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Holland Chart
            const hollandCtx = document.getElementById('hollandPieChart');
            if (hollandCtx) {
                new Chart(hollandCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['R (Kỹ thuật)', 'I (Nghiên cứu)', 'A (Nghệ thuật)', 'S (Xã hội)', 'E (Quản lý)', 'C (Nghiệp vụ)'],
                        datasets: [{
                            data: [
                                <?= (int)($holland_stats['R']??0) ?>, <?= (int)($holland_stats['I']??0) ?>, 
                                <?= (int)($holland_stats['A']??0) ?>, <?= (int)($holland_stats['S']??0) ?>, 
                                <?= (int)($holland_stats['E']??0) ?>, <?= (int)($holland_stats['C']??0) ?>
                            ],
                            backgroundColor: ['#ef4444', '#3b82f6', '#f97316', '#10b981', '#8b5cf6', '#64748b'],
                            borderWidth: 0
                        }]
                    },
                    options: { maintainAspectRatio: false, cutout: '65%', plugins: { legend: { position: 'right', labels: { boxWidth: 10, font: { size: 10 } } } } }
                });
            }

            // 2. Major Chart
            const majorCtx = document.getElementById('majorBarChart');
            if (majorCtx) {
                new Chart(majorCtx, {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode($major_labels ?? []) ?>,
                        datasets: [{
                            label: 'Số lượng quan tâm',
                            data: <?= json_encode($major_counts ?? []) ?>,
                            backgroundColor: '#a71d2a',
                            borderRadius: 4
                        }]
                    },
                    options: { 
                        indexAxis: 'y', 
                        maintainAspectRatio: false, 
                        plugins: { legend: { display: false } },
                        scales: { x: { beginAtZero: true, grid: { display: false } }, y: { grid: { display: false } } }
                    }
                });
            }
        });
    </script>
    <?php endif; ?>

</body>
</html>