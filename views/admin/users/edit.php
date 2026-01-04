<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Người Dùng - UniGuide Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS ĐỒNG BỘ HỆ THỐNG */
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); color: #fff; z-index: 1000; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-menu ul { list-style: none; padding: 0; margin-top: 20px; }
        .sidebar-menu ul li a { padding: 15px 25px; display: block; color: rgba(255,255,255,0.8); text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-menu ul li a:hover, .sidebar-menu ul li a.active { color: #fff; background-color: rgba(255,255,255,0.1); border-left: 4px solid #ffcc00; }
        .sidebar-menu ul li a i { width: 25px; margin-right: 10px; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        .top-navbar { background-color: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        
        /* Style riêng cho Form */
        .card-custom { border-radius: 15px; border: none; box-shadow: 0 5px 25px rgba(0,0,0,0.08); }
        .form-label { font-weight: 600; color: #444; font-size: 0.9rem; }
        .form-control, .form-select { border-radius: 10px; padding: 10px 15px; border: 1px solid #ddd; }
        .form-control:focus { border-color: #a71d2a; box-shadow: 0 0 0 0.25rem rgba(167, 29, 42, 0.1); }
        .btn-danger { background-color: #a71d2a; border: none; border-radius: 50px; transition: 0.3s; }
        .btn-danger:hover { background-color: #80131e; transform: translateY(-2px); }
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
            <h4 class="m-0 text-dark fw-bold">Sửa thông tin người dùng</h4>
            <div class="user-info">
                <strong>Admin</strong>
                <img src="https://ui-avatars.com/api/?name=Admin&background=random" class="ms-2 rounded-circle" width="35">
            </div>
        </div>

        <div class="container-fluid p-4">
            <div class="mb-4">
                <a href="index.php?page=admin&action=users" class="text-decoration-none text-muted fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
                </a>
            </div>

            <div class="card card-custom bg-white col-md-8 col-lg-6 mx-auto">
                <div class="card-header bg-white border-0 py-4 ps-4">
                    <h5 class="fw-bold mb-0 text-danger"><i class="fas fa-user-edit me-2"></i> Thông tin tài khoản #<?= $user['id'] ?></h5>
                </div>
                <div class="card-body p-4">
                    <form action="index.php?page=admin&action=edit_user&id=<?= $user['id'] ?>" method="POST">
                        <div class="mb-4">
                            <label class="form-label">Họ và tên người dùng</label>
                            <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Tên đăng nhập (Username)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fas fa-at text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 rounded-end-3" value="<?= htmlspecialchars($user['username']) ?>" readonly>
                            </div>
                            <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i> Tên đăng nhập là định danh duy nhất và không thể thay đổi.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Vai trò hệ thống</label>
                            <select name="role" class="form-select shadow-sm">
                                <option value="student" <?= $user['role'] == 'student' ? 'selected' : '' ?>>Học sinh (Student)</option>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Quản trị viên (Administrator)</option>
                            </select>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" onclick="window.history.back();" class="btn btn-link text-muted text-decoration-none fw-bold">Hủy bỏ</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-5 shadow">
                                <i class="fas fa-save me-2"></i> LƯU THAY ĐỔI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>