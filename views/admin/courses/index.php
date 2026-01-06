<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Khóa Học - UniGuide Admin</title>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        
        /* Sidebar (Đồng bộ với Quản lý Ngành) */
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); color: #fff; z-index: 1000; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-menu ul { list-style: none; padding: 0; margin-top: 20px; }
        .sidebar-menu ul li a { padding: 15px 25px; display: block; color: rgba(255,255,255,0.8); text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-menu ul li a:hover, .sidebar-menu ul li a.active { color: #fff; background-color: rgba(255,255,255,0.1); border-left: 4px solid #ffcc00; }
        .sidebar-menu ul li a i { width: 25px; margin-right: 10px; }
        
        /* Main Content */
        .main-content { margin-left: 260px; transition: all 0.3s; }
        .top-navbar { background-color: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        
        /* Table Style (Đồng bộ với Quản lý Ngành) */
        .table-card { border: none; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.05); overflow: hidden; }
        .table thead th { background-color: #a71d2a; color: white !important; border: none; padding: 15px; font-weight: 600; text-align: center; vertical-align: middle; }
        .table tbody td { padding: 12px 15px; vertical-align: middle; border-bottom: 1px solid #f0f0f0; }
        
        /* Thumbnail Pro Style (Đồng bộ hiệu ứng hover xoay nhẹ) */
        .major-img { 
            width: 70px; 
            height: 45px; 
            object-fit: cover; 
            border-radius: 8px; 
            border: 1px solid #eee; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .major-img:hover { 
            transform: scale(1.15) rotate(2deg); 
            box-shadow: 0 5px 15px rgba(167, 29, 42, 0.2);
            z-index: 10;
        }

        /* Buttons & Badges */
        .btn-action { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.2s; }
        .btn-action:hover { transform: scale(1.1); }
        .hover-up { transition: transform 0.2s ease; }
        .hover-up:hover { transform: translateY(-3px); }
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
                <li><a href="index.php?page=admin&action=courses" class="active"><i class="fas fa-laptop-code"></i> Quản lý Khóa Học</a></li>
                <li><a href="index.php?page=admin&action=questions"><i class="fas fa-question-circle"></i> Quản lý Câu hỏi Test</a></li>
                <li><a href="index.php?page=admin&action=chat_logs"><i class="fas fa-history"></i> Nhật ký Tư vấn AI</a></li>
                <li><a href="index.php?page=admin&action=users"><i class="fas fa-users-cog"></i> Quản lý Người dùng</a></li>
                <li style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);"><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h4 class="m-0 text-dark fw-bold">🎓 Quản lý Khóa Học Đào Tạo</h4>
            <div class="user-info">
                <a href="index.php" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="fas fa-home"></i> Xem Trang Chủ
                </a>
            </div>
        </div>

        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-muted mb-0">Hệ thống khóa học bổ trợ kỹ năng cho học sinh theo nhóm ngành.</p>
                </div>
                
                <div class="d-flex gap-3 align-items-center">
                    <form action="index.php" method="GET" class="d-flex" style="max-width: 350px;">
                        <input type="hidden" name="page" value="admin">
                        <input type="hidden" name="action" value="courses">
                        <div class="input-group overflow-hidden shadow-sm" style="border-radius: 20px;">
                            <input type="text" name="search" class="form-control border-0 px-3" 
                                   placeholder="Tìm tên, giảng viên..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <button class="btn btn-dark border-0 px-3" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <a href="index.php?page=admin&action=add_course" class="btn btn-success rounded-pill px-4 shadow-sm hover-up">
                        <i class="fas fa-plus-circle me-2"></i>Thêm Khóa Học
                    </a>
                </div>
            </div>

            <div class="card table-card bg-white border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="40%" class="ps-4 text-start">Khóa học</th>
                                    <th width="20%">Giảng viên</th>
                                    <th width="15%">Học phí</th>
                                    <th width="15%">Đánh giá</th>
                                    <th width="10%" class="text-end pe-4">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($courses)): foreach($courses as $c): ?>
                                <tr>
                                   <td class="ps-4">
    <div class="d-flex align-items-center py-2">
        <?php 
            // 1. Lấy tên file từ cơ sở dữ liệu
            $imgName = !empty($c['image']) ? trim($c['image']) : 'default.jpg';
            
            // 2. Thiết lập đường dẫn tuyệt đối từ gốc thư mục dự án
            $imgPath = "uploads/courses/" . $imgName; 
        ?>
        <img src="<?= $imgPath ?>" 
             class="major-img me-3 shadow-sm" 
             style="width: 70px; height: 45px; object-fit: cover; border-radius: 8px;"
             onerror="this.src='https://placehold.co/70x45?text=No+Img'">
        <div>
            <div class="fw-bold text-dark"><?= htmlspecialchars($c['name']) ?></div>
            <div class="text-muted small italic">ID: #<?= $c['id'] ?></div>
        </div>
    </div>
</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border rounded-pill px-3 fw-bold">
                                            <i class="fas fa-user-tie me-1 small"></i><?= htmlspecialchars($c['teacher']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold text-danger">
                                        <?= htmlspecialchars($c['tuition']) ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-warning small mb-1">
                                            <?php 
                                                $rating = (float)$c['rating'];
                                                for($i=1; $i<=5; $i++) echo $i <= $rating ? '★' : '☆'; 
                                            ?>
                                        </div>
                                        <span class="badge bg-warning text-dark rounded-pill" style="font-size: 0.75rem;">Score: <?= $c['rating'] ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="index.php?page=admin&action=edit_course&id=<?= $c['id'] ?>" 
                                               class="btn btn-outline-primary btn-action shadow-sm" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="index.php?page=admin&action=delete_course&id=<?= $c['id'] ?>" 
                                               class="btn btn-danger btn-action text-white shadow-sm" 
                                               onclick="return confirm('⚠️ CẢNH BÁO: Bạn chắc chắn muốn xóa khóa học này?');" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i><br>
                                        Chưa có dữ liệu khóa học nào được tìm thấy.
                                    </td>
                                </tr>
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