<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khóa Học Cao Cấp - UniGuide Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --admin-red: #a71d2a; --admin-dark: #80131e; --admin-light: #f4f6f9; }
        body { background-color: var(--admin-light); font-family: 'Segoe UI', sans-serif; }
        
        /* Sidebar rộng và sang trọng */
        .sidebar { height: 100vh; width: 280px; position: fixed; top: 0; left: 0; background: linear-gradient(180deg, var(--admin-red) 0%, var(--admin-dark) 100%); color: #fff; z-index: 1000; box-shadow: 5px 0 15px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 30px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-menu ul li a { padding: 16px 28px; display: block; color: rgba(255,255,255,0.8); text-decoration: none; transition: 0.3s; font-size: 1.05rem; }
        .sidebar-menu ul li a:hover, .sidebar-menu ul li a.active { color: #fff; background: rgba(255,255,255,0.15); border-left: 5px solid #ffcc00; }
        
        .main-content { margin-left: 280px; padding-bottom: 50px; }
        .top-navbar { background: #fff; padding: 20px 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        
        /* Form Card to và rõ nét */
        .card-custom { border: none; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; background: #fff; }
        .card-header-main { background: var(--admin-red); color: white; padding: 25px 35px; border: none; }
        
        .form-label { font-weight: 700; color: #444; font-size: 0.95rem; margin-bottom: 10px; display: flex; align-items: center; }
        .form-label i { margin-right: 8px; color: var(--admin-red); }
        
        .form-control-lg { border-radius: 15px; padding: 15px 20px; border: 2px solid #eee; background: #fafafa; font-size: 1rem; transition: 0.3s; }
        .form-control-lg:focus { border-color: var(--admin-red); background: #fff; box-shadow: 0 0 0 0.25rem rgba(167, 29, 42, 0.1); }
        
        .btn-giant { padding: 15px 45px; border-radius: 50px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; transition: 0.4s; border: none; }
        .btn-submit { background: var(--admin-red); color: white; box-shadow: 0 8px 20px rgba(167, 29, 42, 0.3); }
        .btn-submit:hover { background: var(--admin-dark); transform: translateY(-3px); box-shadow: 0 12px 25px rgba(167, 29, 42, 0.4); color: #fff; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header"><img src="public/assets/images/logo-white.png" width="120" class="mb-2" onerror="this.style.display='none'"><h4 class="fw-bold m-0">UniGuide</h4></div>
        <div class="sidebar-menu">
            <ul class="list-unstyled mt-4">
                <li><a href="index.php?page=admin"><i class="fas fa-chart-pie me-3"></i>Thống kê tổng quan</a></li>
                <li><a href="index.php?page=admin&action=majors"><i class="fas fa-graduation-cap me-3"></i>Quản lý Ngành</a></li>
                <li><a href="index.php?page=admin&action=courses" class="active"><i class="fas fa-book me-3"></i>Quản lý Khóa Học</a></li>
                <li class="mt-5"><a href="index.php?page=logout"><i class="fas fa-sign-out-alt me-3"></i>Đăng xuất hệ thống</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h3 class="fw-bold m-0 text-dark">Thêm Khóa Học Mới</h3>
            <a href="index.php?page=admin&action=courses" class="btn btn-outline-secondary rounded-pill px-4"><i class="fas fa-arrow-left me-2"></i>Quay lại danh sách</a>
        </div>

        <div class="container-fluid p-5">
            <div class="card card-custom">
                <div class="card-header-main"><h4 class="m-0 fw-bold"><i class="fas fa-plus-circle me-2"></i>Thông tin khóa học chuyên sâu</h4></div>
                <div class="card-body p-5">
                    <form action="index.php?page=admin&action=add_course" method="POST" enctype="multipart/form-data">
                        <div class="row g-4 mb-5">
                            <div class="col-md-8">
                                <label class="form-label"><i class="fas fa-tag"></i>Tên khóa học đào tạo</label>
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="VD: Lập trình Python từ cơ bản đến nâng cao" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-user-tie"></i>Giảng viên phụ trách</label>
                                <input type="text" name="teacher" class="form-control form-control-lg" placeholder="Tên giảng viên..." required>
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-money-bill-wave"></i>Học phí khóa học</label>
                                <input type="text" name="tuition" class="form-control form-control-lg" placeholder="Ví dụ: 2.500.000đ">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-star"></i>Đánh giá hệ thống (Tối đa 5.0)</label>
                                <input type="number" step="0.1" min="1" max="5" name="rating" class="form-control form-control-lg" value="5.0" required>
                                <small class="text-muted">Nhập từ 1.0 đến 5.0</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-image"></i>Hình ảnh đại diện</label>
                                <input type="file" name="image" class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label"><i class="fas fa-file-alt"></i>Mô tả chi tiết nội dung đào tạo</label>
                            <textarea name="description" class="form-control" rows="6" style="border-radius: 20px; border: 2px solid #eee; padding: 20px;" placeholder="Mô tả lộ trình học, mục tiêu khóa học..."></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-giant btn-submit"><i class="fas fa-save me-2"></i>Hoàn tất và Lưu khóa học</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>