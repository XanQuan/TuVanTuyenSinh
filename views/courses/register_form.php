<?php require_once 'views/layouts/header.php'; ?>

<style>
    .register-container { background: #f4f7f6; padding: 60px 0; min-height: 80vh; }
    .register-card { 
        background: #fff; border-radius: 20px; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: none; overflow: hidden;
    }
    .register-header { background: #be1e2d; color: #fff; padding: 30px; text-align: center; }
    .form-control-custom { border-radius: 12px; border: 1px solid #ddd; padding: 12px 20px; margin-bottom: 15px; }
    .btn-submit { 
        background: #be1e2d; color: #fff; border-radius: 50px; 
        padding: 12px 40px; font-weight: 700; width: 100%; border: none; transition: 0.3s;
    }
    .btn-submit:hover { background: #3a0a0e; transform: translateY(-2px); }
</style>

<div class="register-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="register-card">
                    <div class="register-header">
                        <h3 class="fw-bold m-0 text-uppercase">Đăng Ký Tư Vấn</h3>
                        <p class="small m-0 mt-2 opacity-75">Khóa học: <?= htmlspecialchars($course['name']) ?></p>
                    </div>
                    <div class="p-4 p-md-5">
                        <form action="index.php?page=courses&action=submit_consultation" method="POST">
                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                            
                            <label class="small fw-bold text-muted">HỌ VÀ TÊN *</label>
                            <input type="text" name="fullname" class="form-control form-control-custom" placeholder="Nguyễn Văn A" required>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted">SỐ ĐIỆN THOẠI *</label>
                                    <input type="tel" name="phone" class="form-control form-control-custom" placeholder="09xx xxx xxx" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted">EMAIL *</label>
                                    <input type="email" name="email" class="form-control form-control-custom" placeholder="example@gmail.com" required>
                                </div>
                            </div>

                            <label class="small fw-bold text-muted">ĐỊA CHỈ (NẾU CẦN PHỤC VỤ TẠI CHỖ)</label>
                            <input type="text" name="address" class="form-control form-control-custom" placeholder="Số nhà, tên đường, quận/huyện...">

                            <label class="small fw-bold text-muted">THÔNG TIN NHU CẦU</label>
                            <textarea name="requirement" class="form-control form-control-custom" rows="3" placeholder="Bạn cần tư vấn thêm về điều gì?"></textarea>

                            <button type="submit" class="btn-submit mt-3">GỬI YÊU CẦU NGAY</button>
                            <div class="text-center mt-3">
                                <a href="index.php?page=courses" class="text-muted small">Quay lại danh sách</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>