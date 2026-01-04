<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhật ký Tư vấn AI - UniGuide Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS ĐỒNG BỘ HỆ THỐNG */
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); color: #fff; transition: all 0.3s; z-index: 1000; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h3 { font-size: 22px; font-weight: 700; margin: 0; letter-spacing: 1px; }
        .sidebar-menu { padding: 20px 0; }
        .sidebar-menu ul { list-style: none; padding: 0; }
        .sidebar-menu ul li a { padding: 15px 25px; display: block; color: rgba(255,255,255,0.8); text-decoration: none; font-weight: 500; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-menu ul li a:hover, .sidebar-menu ul li a.active { color: #fff; background-color: rgba(255,255,255,0.1); border-left: 4px solid #ffcc00; }
        .sidebar-menu ul li a i { width: 25px; text-align: center; margin-right: 10px; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        .top-navbar { background-color: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        
        .card-custom { border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .bg-danger-light { background: #fee2e2; color: #a71d2a; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-graduation-cap"></i> UniGuide</h3>
            <small>Admin Control Panel</small>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="index.php?page=admin"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển</a></li>
                <li><a href="index.php?page=admin&action=universities"><i class="fas fa-university"></i> Quản lý Trường ĐH</a></li>
                <li><a href="index.php?page=admin&action=majors" class="active"><i class="fas fa-book-open"></i> Quản lý Ngành Học</a></li>
                <li><a href="index.php?page=admin&action=scores"><i class="fas fa-chart-line"></i> Quản lý Điểm Chuẩn</a></li>
                <li><a href="index.php?page=admin&action=questions"><i class="fas fa-question-circle"></i> Quản lý Câu hỏi Test</a></li>
                <li><a href="index.php?page=admin&action=chat_logs"><i class="fas fa-history"></i> Nhật ký Tư vấn AI</a></li>
                <li><a href="index.php?page=admin&action=users"><i class="fas fa-users-cog"></i> Quản lý Người dùng</a></li>
                <li style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);"><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h4 class="m-0 text-dark">Lịch sử hội thoại hệ thống</h4>
            <div class="user-info"><strong>Xin chào, Admin!</strong></div>
        </div>

        <div class="container-fluid p-4">
            <h4 class="fw-bold mb-4 text-dark"><i class="fas fa-history text-danger me-2"></i> NHẬT KÝ TƯ VẤN AI</h4>
            
            <div class="card card-custom shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3" style="font-size: 0.85rem; color: #666;">NGƯỜI DÙNG</th>
                                    <th class="py-3" style="font-size: 0.85rem; color: #666;">TỔNG TIN NHẮN</th>
                                    <th class="py-3" style="font-size: 0.85rem; color: #666;">LẦN CHAT CUỐI</th>
                                    <th class="text-end pe-4 py-3" style="font-size: 0.85rem; color: #666;">THAO TÁC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users_chatted)): ?>
                                    <?php foreach ($users_chatted as $user): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['fullname']) ?>&background=random" 
                                                     class="rounded-circle me-3" width="40" height="40">
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($user['fullname'] ?? 'Khách ẩn danh') ?></div>
                                                    <small class="text-muted">ID: #<?= $user['user_id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-light rounded-pill px-3 py-2">
                                                <?= $user['total_messages'] ?> hội thoại
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-muted small">
                                                <i class="far fa-clock me-1"></i> <?= date('H:i d/m/Y', strtotime($user['last_chat'])) ?>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="index.php?page=admin&action=chat_detail&user_id=<?= $user['user_id'] ?>" 
                                               class="btn btn-outline-danger btn-sm rounded-pill px-4" 
                                               style="border-width: 2px; font-weight: 600;">
                                                Xem chi tiết <i class="fas fa-chevron-right ms-1 small"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center py-5 text-muted">Chưa có dữ liệu hội thoại nào.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>