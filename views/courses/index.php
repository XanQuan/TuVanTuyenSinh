<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top" style="background-image: url('public/assets/images/meetings-bg.jpg'); background-attachment: fixed;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6 class="text-uppercase" style="letter-spacing: 2px;">Đào tạo & Kỹ năng</h6>
                <h2 style="font-weight: 800; text-transform: uppercase;">Các Khóa Học Phổ Biến</h2>
            </div>
        </div>
    </div>
</section>

<section class="meetings-page" id="meetings" style="background: #f8f9fa; padding: 40px 0 80px 0;">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-8">
                <div class="search-container-pro">
                    <form action="index.php" method="GET" class="d-flex align-items-center">
                        <input type="hidden" name="page" value="courses">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 ps-4">
                                <i class="fa fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-0 py-3 ps-2" 
                                   placeholder="Tìm kiếm khóa học bạn quan tâm (ví dụ: Công nghệ thông tin...)"
                                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button class="btn btn-search-pro px-4" type="submit">TÌM KIẾM</button>
                        </div>
                    </form>
                </div>
                <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <div class="text-center mt-3">
                        <p class="text-muted">Kết quả tìm kiếm cho: <strong>"<?= htmlspecialchars($_GET['search']) ?>"</strong> 
                        | <a href="index.php?page=courses" class="text-danger text-decoration-none">Xóa bộ lọc</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
          <?php if(isset($courses) && count($courses) > 0): ?>
    <?php foreach($courses as $c): ?>
    <div class="col-lg-4 mb-5">
        <div class="course-card-pro" 
             onclick="window.location.href='index.php?page=courses&action=detail&id=<?= $c['id'] ?>'" 
             style="cursor: pointer;">
            
            <div class="thumb-container">
                <div class="price-badge">
                    <span><?= htmlspecialchars($c['tuition'] ?? 'Liên hệ') ?></span>
                </div>
                <a href="index.php?page=courses&action=detail&id=<?= $c['id'] ?>">
                    <img src="public/assets/images/<?= htmlspecialchars(!empty($c['image']) ? $c['image'] : 'default.jpg') ?>" 
                         alt="<?= htmlspecialchars($c['name']) ?>" class="course-img">
                </a>
            </div>
            
            <div class="content-body">
                <div class="category-tag">UniGuide Elite</div>
                <h4 class="course-title"><?= htmlspecialchars($c['name']) ?></h4>
                
                <div class="meta-info d-flex justify-content-between">
                    <span class="instructor"><i class="fa fa-user-tie me-2"></i><?= htmlspecialchars($c['teacher']) ?></span>
                    <span class="rating-pro"><i class="fa fa-star me-1"></i><?= $c['rating'] ?></span>
                </div>

                <p class="course-desc">
                    <?= mb_substr(htmlspecialchars($c['description'] ?? ''), 0, 95) ?>...
                </p>
                
                <div class="button-group">
                    <a href="index.php?page=courses&action=register&id=<?= $c['id'] ?>" 
                       class="btn-register-pro" 
                       onclick="event.stopPropagation();"> <span>ĐĂNG KÝ NGAY</span>
                        <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
        </div>
    </div>
</section>

<style>
    /* Thanh tìm kiếm Pro */
    .search-container-pro {
        background: #fff;
        border-radius: 50px;
        padding: 8px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .search-container-pro:focus-within {
        box-shadow: 0 15px 40px rgba(190, 30, 45, 0.2);
        transform: translateY(-2px);
    }
    .search-container-pro input:focus {
        box-shadow: none;
    }
    .btn-search-pro {
        background: #be1e2d;
        color: #fff;
        border-radius: 40px;
        font-weight: 700;
        transition: all 0.3s;
    }
    .btn-search-pro:hover {
        background: #1f272b;
        color: #fff;
    }

    /* Course Card Pro - Giữ nguyên Style cũ của bạn */
    .course-card-pro {
        background: #fff;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .course-card-pro:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 50px rgba(190, 30, 45, 0.15);
    }
    .thumb-container { position: relative; overflow: hidden; height: 230px; }
    .course-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
    .course-card-pro:hover .course-img { transform: scale(1.15); }
    .price-badge {
        position: absolute; top: 20px; right: 0;
        background: linear-gradient(90deg, #be1e2d, #ff4d4d);
        color: #fff; padding: 8px 20px; font-weight: 700; font-size: 14px;
        border-radius: 30px 0 0 30px; z-index: 10;
        box-shadow: -5px 5px 15px rgba(0,0,0,0.2);
    }
    .content-body { padding: 30px; }
    .category-tag { color: #be1e2d; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px; }
    .course-title { font-size: 22px; font-weight: 700; color: #2a2a2a; margin-bottom: 20px; line-height: 1.3; height: 58px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .meta-info { margin-bottom: 20px; font-size: 14px; }
    .rating-pro { color: #ffa800; background: #fff9e6; padding: 2px 10px; border-radius: 10px; }
    .course-desc { color: #777; font-size: 15px; line-height: 1.6; margin-bottom: 25px; height: 72px; overflow: hidden; }
    .btn-register-pro { display: flex; align-items: center; justify-content: center; background: #1f272b; color: #fff !important; padding: 15px; border-radius: 15px; font-weight: 700; text-decoration: none; transition: all 0.3s; width: 100%; }
    .btn-register-pro:hover { background: #be1e2d; letter-spacing: 1px; }
</style>

<?php require_once 'views/layouts/footer.php'; ?>