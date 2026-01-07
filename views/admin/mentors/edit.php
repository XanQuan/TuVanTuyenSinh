<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="card-header border-0 p-4" style="background: linear-gradient(90deg, #a71d2a 0%, #80131e 100%);">
                    <h4 class="mb-0 text-white fw-bold"><i class="fas fa-user-edit me-2 text-warning"></i>CẬP NHẬT THÔNG TIN MENTOR</h4>
                </div>

                <div class="card-body p-5 bg-white">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="current_avatar" value="<?= htmlspecialchars($mentor['avatar'] ?? '') ?>">

                        <div class="row g-5">
                            <div class="col-md-4 text-center border-end">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted small text-uppercase d-block mb-3">Ảnh đại diện chuyên gia</label>
                                    <div class="position-relative d-inline-block">
                                        <?php 
                                            $avatar = !empty($mentor['avatar']) ? $mentor['avatar'] : 'default_mentor.jpg';
                                            $avatarPath = "public/assets/images/" . $avatar;
                                        ?>
                                        <img src="<?= $avatarPath ?>" 
                                             class="rounded-circle shadow-lg border border-4 border-white mb-3" 
                                             width="200" height="200" 
                                             style="object-fit: cover; transition: 0.3s;"
                                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($mentor['full_name']) ?>&size=200'">
                                    </div>
                                    
                                    <div class="mt-3 px-3">
                                        <div class="upload-box p-3 border-dashed rounded-4 bg-light" style="border: 2px dashed #dee2e6;">
                                            <input type="file" name="avatar" class="form-control form-control-sm border-0 bg-transparent" accept="image/*">
                                            <p class="small text-muted mb-0 mt-2 italic">Tải ảnh mới để thay thế</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark"><i class="fas fa-id-card me-2 text-danger"></i>Họ và Tên</label>
                                        <input type="text" name="full_name" class="form-control form-control-lg rounded-pill bg-light border-0 px-4" 
                                               required value="<?= htmlspecialchars($mentor['full_name']) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark"><i class="fas fa-briefcase me-2 text-danger"></i>Chức danh hiện tại</label>
                                        <input type="text" name="job_title" class="form-control form-control-lg rounded-pill bg-light border-0 px-4" 
                                               placeholder="VD: Senior Developer" required value="<?= htmlspecialchars($mentor['job_title']) ?>">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark"><i class="fas fa-star me-2 text-danger"></i>Lĩnh vực chuyên môn</label>
                                        <input type="text" name="expertise" class="form-control form-control-lg rounded-pill bg-light border-0 px-4" 
                                               placeholder="VD: Lập trình Backend, System Design" required value="<?= htmlspecialchars($mentor['expertise']) ?>">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark"><i class="fas fa-quote-left me-2 text-danger"></i>Tiểu sử & Kinh nghiệm (Bio)</label>
                                        <textarea name="bio" class="form-control border-0 bg-light p-4" rows="5" 
                                                  style="border-radius: 20px; resize: none;"><?= htmlspecialchars($mentor['bio']) ?></textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark"><i class="fab fa-linkedin me-2 text-primary"></i>Đường dẫn LinkedIn</label>
                                        <input type="url" name="linkedin_url" class="form-control form-control-lg rounded-pill bg-light border-0 px-4" 
                                               placeholder="https://linkedin.com/in/..." value="<?= htmlspecialchars($mentor['linkedin_url']) ?>">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                                    <a href="index.php?page=admin&action=mentors" class="btn btn-light rounded-pill px-5 py-2 fw-bold border shadow-sm">
                                        <i class="fas fa-times me-2"></i>HỦY BỎ
                                    </a>
                                    <button type="submit" class="btn btn-danger rounded-pill px-5 py-2 fw-bold shadow-lg hover-up" 
                                            style="background-color: #a71d2a;">
                                        <i class="fas fa-save me-2 text-warning"></i>LƯU THAY ĐỔI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-up:hover { transform: translateY(-3px); }
    .form-control-lg:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(167, 29, 42, 0.1) !important; border: 1px solid #a71d2a !important; }
    .border-dashed:hover { border-color: #a71d2a !important; background: #fff !important; }
</style>