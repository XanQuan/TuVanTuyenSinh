<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Hệ thống tư vấn tuyển sinh UniGuide">
    <meta name="author" content="Minh Quan">
    
    <title>UniGuide - Hệ thống tư vấn tuyển sinh</title>

    <link href="/TuVanTuyenSinh/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/TuVanTuyenSinh/public/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/TuVanTuyenSinh/public/assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="/TuVanTuyenSinh/public/assets/css/owl.css">
    <link rel="stylesheet" href="/TuVanTuyenSinh/public/assets/css/lightbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* SỬA LỖI: Đảm bảo Header luôn nằm trên cùng */
        .header-area {
            z-index: 99999 !important;
        }

        .background-header {
            background-color: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #eee;
        }
        
        .header-area .main-nav .logo {
            color: #a71d2a !important;
            font-weight: 800;
            font-size: 24px;
        }

        .header-area .main-nav .nav li a {
            color: #333 !important;
            font-weight: 600;
            font-size: 15px;
        }
        
        .header-area .main-nav .nav li a:hover, 
        .header-area .main-nav .nav li a.active {
            color: #a71d2a !important;
        }

        .btn-login-custom {
            background-color: #a71d2a !important;
            color: #fff !important;
            padding: 10px 25px !important;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(167, 29, 42, 0.2);
        }
        /* views/layouts/header.php */
.user-dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%; 
    background-color: #fff;
    min-width: 220px;
    box-shadow: 0px 10px 30px rgba(0,0,0,0.15);
    /* Sửa tại đây: Đảm bảo menu luôn nổi lên trên cùng */
    z-index: 999999 !important; 
    border-radius: 10px;
    overflow: hidden;
}

/* Hiển thị menu khi di chuột vào tên người dùng */
.user-dropdown:hover .user-dropdown-content {
    display: block !important;
}

/* Nút đăng xuất rõ ràng */
.logout-btn {
    color: #dc3545 !important;
    font-weight: bold;
    background-color: #fff5f5;
}

        /* SỬA LỖI DROPDOWN: Hiển thị mượt mà và không bị mất khi cuộn */
.user-dropdown {
    position: relative;
    display: inline-block;
}

 .user-dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%; /* Sát lề dưới của nút chào */
    background-color: #fff;
    min-width: 200px;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    z-index: 999999 !important; 
    border-radius: 8px;
    overflow: hidden;
    
    /* TẠO VÙNG ĐỆM ĐỂ CHUỘT KHÔNG BỊ RỜI KHỎI MENU */
    margin-top: 0; 
    padding: 5px 0;
}

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
  .user-dropdown:hover .user-dropdown-content {
    display: block !important;
}

        .user-dropdown-content a {
            color: #333 !important;
            padding: 12px 20px !important;
            display: block;
            font-size: 14px !important;
            border-bottom: 1px solid #f9f9f9;
            height: auto !important;
            line-height: normal !important;
        }

        .user-dropdown-content a:hover {
            background-color: #f8f9fa;
            color: #a71d2a !important;
            padding-left: 25px !important;
        }

        .user-avatar-small {
            width: 35px; height: 35px; border-radius: 50%; 
            margin-right: 8px; border: 2px solid #a71d2a;
            object-fit: cover;
        }
        .user-dropdown::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    height: 20px; /* Độ dày vùng đệm */
    display: block;
}
    </style>
</head>

<body>
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-8">
          <div class="left-content">
            <p>Hệ thống tư vấn tuyển sinh trực tuyến <strong>UniGuide</strong>.</p>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="right-icons">
            <ul>
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <a href="index.php" class="logo">UniGuide</a>
                      
                      <ul class="nav">
                          <li><a href="index.php">Trang chủ</a></li>
                          <li><a href="index.php?page=about">Về Chúng tôi</a></li>
                          <li><a href="index.php?page=assessment">Trắc nghiệm</a></li>
                          <li><a href="index.php?page=compare"> So sánh</a></li>

                          <li class="has-sub">
                            <a href="javascript:void(0)">Khám phá</a>
                            <ul class="sub-menu">
                                <li><a href="index.php?page=majors"> Ngành đào tạo</a></li>
                                <li><a href="index.php?page=courses"> Các Khóa học</a></li> 
                                <li><a href="index.php?page=events"> Sự kiện & Hội thảo</a></li>
                                <li><a href="index.php?page=mentors"> Kết nối Chuyên gia</a></li>
                                <li><a href="index.php?page=resources"> Tài nguyên học tập</a></li>
                                <li><a href="index.php?page=faq"> Câu hỏi thường gặp</a></li>
                               <li><a href="index.php?page=ai_consultant"></i> Trợ lý ảo AI </a></li>
                            </ul>
                          </li>

                          <?php if(isset($_SESSION['user'])): ?>
                             <li><a href="index.php?page=advice&action=history">Lịch sử</a></li>
                             <li class="user-dropdown">
    <a href="javascript:void(0)" style="display: flex; align-items: center;">
        <?php 
            $user_avatar = !empty($_SESSION['user']['avatar']) 
                           ? "public/uploads/avatars/" . $_SESSION['user']['avatar'] 
                           : "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['user']['fullname']) . "&background=a71d2a&color=fff";
        ?>
        <img src="<?= $user_avatar ?>?t=<?= time() ?>" class="user-avatar-small" alt="Avatar">
        Chào, <?= htmlspecialchars($_SESSION['user']['fullname']) ?> <i class="fa fa-angle-down ms-1"></i>
    </a>
    <div class="user-dropdown-content">
        <a href="index.php?page=profile"><i class="fa fa-user me-2"></i> Hồ sơ cá nhân</a>
        <div style="border-top: 1px solid #eee; margin: 5px 0;"></div>
        <a href="index.php?page=logout" class="logout-btn">
            <i class="fa fa-sign-out me-2"></i> ĐĂNG XUẤT
        </a>
    </div>
</li>
                             </li>
                          <?php else: ?>
                             <li><a href="index.php?page=auth&action=login" class="btn-login-custom">Đăng nhập</a></li>
                          <?php endif; ?> 
                      </ul>        
                      <a class='menu-trigger'><span>Menu</span></a>
                  </nav>
              </div>
          </div>
      </div>
      
  </header>