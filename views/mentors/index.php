<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top" style="background-image: url('public/assets/images/meetings-bg.jpg'); background-attachment: fixed;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6 style="letter-spacing: 3px; text-transform: uppercase;">Mạng lưới kết nối</h6>
                <h2 style="font-weight: 900; font-size: 36px;">ĐỘI NGŨ CHUYÊN GIA & CỰU SINH VIÊN</h2>
            </div>
        </div>
    </div>
</section>

<section class="our-courses" id="courses" style="padding: 80px 0; background: #f9fbfd;">
    <div class="container">
        <div class="row">
            <?php if(isset($mentors) && count($mentors) > 0): ?>
                <?php foreach($mentors as $m): ?>
                <div class="col-lg-4 col-md-6 mb-5 fade-in-up">
                    <div class="mentor-card" onclick="window.location.href='index.php?page=mentors&action=detail&id=<?= $m['id'] ?>'">
    <div class="mentor-thumb">
    <?php 
        // 1. Lấy tên file từ cột 'avatar' (Database của bạn dùng avatar chứ không phải image)
        $avatar = !empty($m['avatar']) ? $m['avatar'] : 'default_mentor.jpg';
        
        // 2. Kiểm tra đường dẫn vật lý để ưu tiên ảnh thật
        // Lưu ý: Nếu ảnh bạn để ở public/assets/images thì dùng đường dẫn này
        $avatarPath = "public/assets/images/" . $avatar;
        
        // Nếu không tồn tại ở thư mục ngoài, thử tìm trong thư mục mentors/
        if (!file_exists($avatarPath)) {
            $avatarPath = "public/assets/images/mentors/" . $avatar;
        }
    ?>
    <img src="<?= $avatarPath ?>" 
         alt="<?= htmlspecialchars($m['full_name']) ?>" 
         class="img-fluid"
         onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($m['full_name']) ?>&background=be1e2d&color=fff'">
</div>
    
<div class="mentor-content">
    <span class="mentor-expertise"><?= htmlspecialchars($m['expertise'] ?? 'Cố vấn chuyên môn') ?></span>
    <h4 class="mentor-name"><?= htmlspecialchars($m['full_name'] ?? 'Chuyên gia tư vấn') ?></h4>
    <p class="mentor-bio">
        <?= mb_substr(htmlspecialchars($m['bio'] ?? ''), 0, 100) ?>...
    </p>
    <div class="mentor-footer">
        <span class="contact-link">XEM CHI TIẾT <i class="fa fa-arrow-right"></i></span>
    </div>
</div>
</div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <img src="public/assets/images/no-data.png" style="width: 120px; opacity: 0.5;">
                    <p class="text-muted mt-3">Đang cập nhật danh sách chuyên gia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    /* Hiệu ứng Fade In mượt mà */
    .fade-in-up {
        animation: fadeInUp 0.8s ease backwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Thiết kế Mentor Card mới */
    .mentor-card {
        background: #fff;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        cursor: pointer;
        height: 100%;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .mentor-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(190, 30, 45, 0.1);
    }

    .mentor-thumb {
        position: relative;
        height: 320px;
        overflow: hidden;
    }

    .mentor-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .mentor-card:hover .mentor-thumb img {
        transform: scale(1.1);
    }

    /* Lớp phủ khi hover vào ảnh */
    .mentor-social-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(190, 30, 45, 0.9));
        padding: 20px;
        color: #fff;
        text-align: center;
        opacity: 0;
        transition: 0.3s;
    }

    .mentor-card:hover .mentor-social-overlay {
        opacity: 1;
    }

    .mentor-content {
        padding: 25px;
        text-align: center;
    }

    .mentor-expertise {
        display: inline-block;
        background: #fff5f5;
        color: #be1e2d;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .mentor-name {
        font-size: 22px;
        font-weight: 800;
        color: #1f272b;
        margin-bottom: 15px;
    }

    .mentor-bio {
        font-size: 14px;
        color: #777;
        line-height: 1.6;
        margin-bottom: 20px;
        height: 65px;
        overflow: hidden;
    }

    .mentor-footer {
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .contact-link {
        font-size: 13px;
        font-weight: 800;
        color: #be1e2d;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .mentor-card:hover .contact-link {
        letter-spacing: 2px;
    }
</style>

<?php require_once 'views/layouts/footer.php'; ?>