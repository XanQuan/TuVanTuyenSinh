<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Trường ĐH - UniGuide Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); color: #fff; z-index: 1000; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-menu ul { list-style: none; padding: 0; margin-top: 20px; }
        .sidebar-menu ul li a { padding: 15px 25px; display: block; color: rgba(255,255,255,0.8); text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-menu ul li a:hover, .sidebar-menu ul li a.active { color: #fff; background-color: rgba(255,255,255,0.1); border-left: 4px solid #ffcc00; }
        .sidebar-menu ul li a i { width: 25px; margin-right: 10px; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        .top-navbar { background-color: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        
        /* CSS riêng cho Table */
        .table-card { border: none; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.05); overflow: hidden; }
        .table thead th { background-color: #a71d2a; color: white; border: none; padding: 15px; font-weight: 600; }
        .table tbody td { padding: 12px 15px; vertical-align: middle; border-bottom: 1px solid #f0f0f0; }
        .btn-action { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.2s; }
        .btn-action:hover { transform: scale(1.1); }
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
                <li><a href="index.php?page=admin&action=universities" class="active"><i class="fas fa-university"></i> Quản lý Trường ĐH</a></li>
                <li><a href="index.php?page=admin&action=majors"><i class="fas fa-book-open"></i> Quản lý Ngành Học</a></li>
                <li><a href="index.php?page=admin&action=scores"><i class="fas fa-chart-line"></i> Quản lý Điểm Chuẩn</a></li>
                <li style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);"><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h4 class="m-0 text-dark fw-bold">Danh sách Trường Đại Học</h4>
            <div class="user-info">
                <a href="index.php" class="btn btn-outline-dark btn-sm rounded-pill px-3"><i class="fas fa-home"></i> Xem Trang Chủ</a>
            </div>
        </div>

        <div class="container-fluid p-4">
            <div class="d-flex justify-content-end mb-3">
                <a href="index.php?page=admin&action=add_university" class="btn btn-success shadow-sm">
                    <i class="fas fa-plus-circle"></i> Thêm Trường Mới
                </a>
            </div>

            <div class="card table-card bg-white">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mã Trường</th>
                                <th>Tên Trường Đại Học</th>
                                <th width="150" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($universities) && count($universities) > 0): ?>
                                <?php foreach ($universities as $uni): ?>
                                <tr>
                                    <td class="fw-bold text-danger"><?= htmlspecialchars($uni['code']) ?></td>
                                    <td><?= htmlspecialchars($uni['name']) ?></td>
                                    <td class="text-center">
                                        <a href="index.php?page=admin&action=edit_university&id=<?= $uni['id'] ?>" class="btn btn-primary btn-action btn-sm text-white" title="Sửa"><i class="fas fa-edit"></i></a>
                                        <a href="index.php?page=admin&action=delete_university&id=<?= $uni['id'] ?>" class="btn btn-danger btn-action btn-sm text-white" onclick="return confirm('Bạn có chắc muốn xóa?');" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="text-center py-4 text-muted">Chưa có dữ liệu trường học.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>