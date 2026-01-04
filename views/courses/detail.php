<?php require_once 'views/layouts/header.php'; ?>

<style>
    /* Tổng thể */
    .meetings-page { background: #f4f7f6; padding-top: 60px; }
    
    /* Card chung */
    .custom-card { 
        background: #fff; 
        border-radius: 15px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        margin-bottom: 30px; 
        border: none;
    }

    /* Sidebar Sticky */
    .sticky-sidebar { position: sticky; top: 100px; }

    /* Star Rating mini */
    .star-rating { display: flex; flex-direction: row-reverse; justify-content: center; }
    .star-rating input { display: none; }
    .star-rating label { font-size: 1.8rem; color: #ddd; cursor: pointer; }
    .star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color: #f5a425; }

    /* Button */
    .btn-main { 
        background: #be1e2d; 
        color: #fff; 
        border-radius: 50px; 
        font-weight: 700; 
        padding: 12px; 
        transition: 0.3s; 
        width: 100%;
        border: none;
    }
    .btn-main:hover { background: #3a0a0e; transform: translateY(-2px); color: #fff; }

    /* Review Box */
    .review-item-mini { 
        border-bottom: 1px solid #eee; 
        padding: 15px 0; 
    }
    .review-item-mini:last-child { border-bottom: none; }
    
    .course-img { width: 100%; border-radius: 15px; height: 400px; object-fit: cover; }
</style>

<section class="meetings-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="custom-card p-4">
                    <?php $img = !empty($course['image']) ? $course['image'] : 'course-01.jpg'; ?>
                    <img src="public/assets/images/<?= $img ?>" class="course-img mb-4">
                    <h2 class="fw-bold mb-3"><?= htmlspecialchars($course['name']) ?></h2>
                    <div class="text-muted" style="line-height: 1.8; font-size: 1.1rem;">
                        <?= nl2br(htmlspecialchars($course['description'])) ?>
                    </div>
                </div>

                <div class="custom-card p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-2">ĐÁNH GIÁ TỪ HỌC VIÊN</h5>
                    <div class="scroll-reviews">
                        <?php if ($reviews && $reviews->num_rows > 0): 
                            while($rev = $reviews->fetch_assoc()): ?>
                            <div class="review-item-mini">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold text-danger"><?= htmlspecialchars($rev['user_name']) ?></span>
                                    <span class="text-warning"><?= str_repeat('★', $rev['rating']) ?></span>
                                </div>
                                <p class="mb-1 mt-1">"<?= htmlspecialchars($rev['comment']) ?>"</p>
                                <small class="text-muted" style="font-size: 0.75rem;"><?= date('d/m/Y', strtotime($rev['created_at'])) ?></small>
                            </div>
                        <?php endwhile; else: ?>
                            <p class="text-center text-muted">Chưa có đánh ay nào.</p>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold text-center mb-3">Gửi đánh giá của bạn</h6>
                        <form action="index.php?page=courses&action=rate" method="POST">
                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                            <div class="star-rating mb-2">
                                <input type="radio" id="5-stars" name="rating" value="5" required /><label for="5-stars">★</label>
                                <input type="radio" id="4-stars" name="rating" value="4" /><label for="4-stars">★</label>
                                <input type="radio" id="3-stars" name="rating" value="3" /><label for="3-stars">★</label>
                                <input type="radio" id="2-stars" name="rating" value="2" /><label for="2-stars">★</label>
                                <input type="radio" id="1-star" name="rating" value="1" /><label for="1-star">★</label>
                            </div>
                            <textarea name="comment" class="form-control mb-3" rows="2" placeholder="Cảm nhận của bạn..."></textarea>
                            <button type="submit" class="btn btn-outline-danger w-100 btn-sm rounded-pill">Gửi nhận xét</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="sticky-sidebar">
                    <div class="custom-card p-4 text-center" style="background: #be1e2d; color: #fff;">
                        <span class="text-uppercase small fw-bold">Học phí trọn gói</span>
                        <h2 class="fw-bold mt-1"><?= htmlspecialchars($course['tuition']) ?></h2>
                    </div>

                    <div class="custom-card p-4">
                        <h5 class="fw-bold mb-3 text-center text-danger">NHẬN TƯ VẤN MIỄN PHÍ</h5>
                        <p class="small text-center text-muted mb-4">Để lại thông tin, chúng tôi sẽ gọi lại ngay!</p>
                        <form action="index.php?page=courses&action=submit_consultation" method="POST">
                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                            <div class="mb-3">
                                <input type="text" name="fullname" class="form-control form-input-custom" placeholder="Họ và tên *" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control form-input-custom" placeholder="Số điện thoại *" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control form-input-custom" placeholder="Email *" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="requirement" class="form-control form-input-custom" rows="2" placeholder="Bạn cần tư vấn gì?"></textarea>
                            </div>
                            <button type="submit" class="btn-main mt-2">GỬI YÊU CẦU NGAY</button>
                        </form>
                        <div class="text-center mt-3">
                            <small class="text-muted"><i class="fa fa-shield-alt"></i> Bảo mật thông tin 100%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>