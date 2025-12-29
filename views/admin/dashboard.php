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

        /* SIDEBAR (Cột trái) */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); /* Màu đỏ đậm trường học */
            color: #fff;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu ul li a {
            padding: 15px 25px;
            display: block;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar-menu ul li a:hover, .sidebar-menu ul li a.active {
            color: #fff;
            background-color: rgba(255,255,255,0.1);
            border-left: 4px solid #ffcc00; /* Vệt vàng điểm nhấn */
        }

        .sidebar-menu ul li a i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        /* MAIN CONTENT (Nội dung chính) */
        .main-content {
            margin-left: 260px; /* Bằng width sidebar */
            transition: all 0.3s;
        }

        /* TOP NAVBAR */
        .top-navbar {
            background-color: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
        }

        /* STATS CARDS */
        .card-stat {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            overflow: hidden;
            position: relative;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .card-stat .card-body {
            padding: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .bg-red-light { background: #fee2e2; color: #dc2626; }
        .bg-blue-light { background: #dbeafe; color: #2563eb; }
        .bg-green-light { background: #dcfce7; color: #16a34a; }

        .stat-text h2 { font-size: 32px; font-weight: 800; margin: 0; color: #333; }
        .stat-text p { margin: 0; color: #777; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;}

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
                <li>
                    <a href="index.php?page=admin" class="active">
                        <i class="fas fa-tachometer-alt"></i> Bảng điều khiển
                    </a>
                </li>
                <li>
                    <a href="index.php?page=admin&action=universities">
                        <i class="fas fa-university"></i> Quản lý Trường ĐH
                    </a>
                </li>
                <li>
                    <a href="index.php?page=admin&action=majors">
                        <i class="fas fa-book-open"></i> Quản lý Ngành Học
                    </a>
                </li>
                <li>
                    <a href="index.php?page=admin&action=scores">
                        <i class="fas fa-chart-line"></i> Quản lý Điểm Chuẩn
                    </a>
                </li>
                <li style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="index.php?page=logout">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        
        <div class="top-navbar">
            <div class="toggle-menu">
                <h4 class="m-0 text-dark">Tổng quan hệ thống</h4>
            </div>
            
            <div class="user-info">
                <a href="index.php" class="btn btn-outline-dark btn-sm rounded-pill px-3 me-2">
                    <i class="fas fa-home"></i> Xem Trang Chủ
                </a>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="admin" width="32" height="32" class="rounded-circle me-2">
                        <strong>Xin chào, Admin!</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                        <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="index.php?page=logout">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid p-4">
            
            <div class="alert alert-light border-0 shadow-sm mb-4" role="alert" style="background: #fff; border-left: 5px solid #a71d2a !important;">
                <h4 class="alert-heading text-danger fw-bold"><i class="fas fa-hand-sparkles"></i> Chào mừng quay trở lại!</h4>
                <p class="mb-0 text-muted">Hệ thống đang hoạt động ổn định. Chúc bạn một ngày làm việc hiệu quả.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-stat bg-white">
                        <div class="card-body">
                            <div class="stat-text">
                                <p>Tổng lượt truy cập</p>
                                <h2>150</h2>
                            </div>
                            <div class="stat-icon bg-red-light">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-stat bg-white">
                        <div class="card-body">
                            <div class="stat-text">
                                <p>Tài khoản mới</p>
                                <h2>12</h2>
                            </div>
                            <div class="stat-icon bg-blue-light">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-stat bg-white">
                        <div class="card-body">
                            <div class="stat-text">
                                <p>Yêu cầu tư vấn</p>
                                <h2>5</h2>
                            </div>
                            <div class="stat-icon bg-green-light">
                                <i class="fas fa-comments"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="min-height: 400px; border-radius: 15px;">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="fw-bold mb-0"><i class="fas fa-list"></i> Hoạt động gần đây</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-center text-muted mt-5">Chưa có dữ liệu mới...</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>