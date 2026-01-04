<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người dùng - UniGuide Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); color: #fff; z-index: 1000; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-menu ul { list-style: none; padding: 0; margin-top: 20px; }
        .sidebar-menu ul li a { padding: 15px 25px; display: block; color: rgba(255,255,255,0.8); text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-menu ul li a:hover, .sidebar-menu ul li a.active { color: #fff; background-color: rgba(255,255,255,0.1); border-left: 4px solid #ffcc00; }
        .sidebar-menu ul li a i { width: 25px; margin-right: 10px; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        .top-navbar { background-color: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .card-custom { border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="fw-bold"><i class="fas fa-graduation-cap"></i> UniGuide</h3>
            <small>Admin Panel</small>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="index.php?page=admin"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển</a></li>
                <li><a href="index.php?page=admin&action=universities"><i class="fas fa-university"></i> Quản lý Trường ĐH</a></li>
                <li><a href="index.php?page=admin&action=majors"><i class="fas fa-book-open"></i> Quản lý Ngành Học</a></li>
                <li><a href="index.php?page=admin&action=scores"><i class="fas fa-chart-line"></i> Quản lý Điểm Chuẩn</a></li>
                <li><a href="index.php?page=admin&action=questions"><i class="fas fa-question-circle"></i> Quản lý Câu hỏi Test</a></li>
                <li><a href="index.php?page=admin&action=chat_logs"><i class="fas fa-history"></i> Nhật ký Tư vấn AI</a></li>
                <li><a href="index.php?page=admin&action=users" class="active"><i class="fas fa-users-cog"></i> Quản lý Người dùng</a></li>
                <li style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);"><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h4 class="m-0 text-dark fw-bold">👥 Quản lý Tài khoản Người dùng</h4>
            <div class="user-info">
                <strong>Xin chào, Admin!</strong>
                <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="admin" class="ms-2 rounded-circle" width="35">
            </div>
        </div>

        <div class="container-fluid p-4">
            <?php if(isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Cập nhật trạng thái người dùng thành công!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card card-custom bg-white">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">Người dùng</th>
                                    <th class="py-3">Tên đăng nhập</th>
                                    <th class="py-3">Trạng thái hiện tại</th>
                                    <th class="text-end pe-4 py-3">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): 
                                        // KHAI BÁO BIẾN Ở ĐÂY ĐỂ TRÁNH LỖI UNDEFINED
                                        $status = $user['status'] ?? 'active'; 
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['fullname']) ?>&background=random" class="user-avatar me-3 shadow-sm">
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($user['fullname']) ?></div>
                                                    <small class="text-muted">ID: #<?= $user['id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><code class="text-primary fw-bold"><?= htmlspecialchars($user['username']) ?></code></td>
                                        <td>
                                            <?php if($status == 'active'): ?>
                                                <span class="badge bg-success rounded-pill px-3"><i class="fas fa-check-circle me-1"></i> Đang hoạt động</span>
                                            <?php elseif($status == 'temporary_banned'): ?>
                                                <span class="badge bg-warning text-dark rounded-pill px-3"><i class="fas fa-clock me-1"></i> Khóa tạm thời</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger rounded-pill px-3"><i class="fas fa-user-slash me-1"></i> Ngưng hoạt động</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border rounded-pill dropdown-toggle shadow-sm" data-bs-toggle="dropdown">
                                                    Hành động
                                                </button>
                                                <ul class="dropdown-menu shadow-lg border-0 rounded-3">
                                                    <li><a class="dropdown-item" href="index.php?page=admin&action=edit_user&id=<?= $user['id'] ?>"><i class="fas fa-edit me-2 text-primary"></i>Sửa thông tin</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    
                                                    <?php if($status !== 'active'): ?>
                                                        <li><a class="dropdown-item text-success fw-bold" href="index.php?page=admin&action=toggle_user_status&id=<?= $user['id'] ?>&status=active">
                                                            <i class="fas fa-unlock-alt me-2"></i>MỞ KHÓA TÀI KHOẢN
                                                        </a></li>
                                                    <?php endif; ?>

                                                    <?php if($status !== 'temporary_banned'): ?>
                                                        <li><a class="dropdown-item text-warning" href="index.php?page=admin&action=toggle_user_status&id=<?= $user['id'] ?>&status=temporary_banned">
                                                            <i class="fas fa-user-clock me-2"></i>Khóa tạm thời
                                                        </a></li>
                                                    <?php endif; ?>

                                                    <?php if($status !== 'permanently_banned'): ?>
                                                        <li><a class="dropdown-item text-danger" href="index.php?page=admin&action=toggle_user_status&id=<?= $user['id'] ?>&status=permanently_banned">
                                                            <i class="fas fa-user-slash me-2"></i>Khóa vĩnh viễn
                                                        </a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center py-5 text-muted">Hệ thống chưa có dữ liệu người dùng.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>