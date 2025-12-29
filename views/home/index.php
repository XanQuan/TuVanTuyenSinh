<?php require_once 'views/layouts/header.php'; ?>

<section class="section main-banner" id="top" data-section="section1">
    <video autoplay muted loop id="bg-video">
        <source src="public/assets/images/course-video.mp4" type="video/mp4" />
    </video>

    <div class="video-overlay header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="caption">
                        <h6>Xin chào bạn</h6>
                        <h2>Hệ Thống Tư Vấn Tuyển Sinh</h2>
                        <p>Chúng tôi giúp bạn tìm kiếm trường đại học phù hợp nhất dựa trên điểm số và sở thích của bạn. Hãy bắt đầu ngay bên dưới!</p>
                        
                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                            <div class="main-button-red">
                                <div class="scroll-to-section"><a href="#consulting">🔍 Tra cứu ngay</a></div>
                            </div>
                            
                            <div class="main-button-yellow"> 
                                <a href="index.php?page=assessment">🧩 Test Năng lực</a>
                            </div>

                             <div class="main-button-red"> 
                                <a href="index.php?page=compare" style="background-color: #fff !important; color: #a71d2a !important;">⚖️ So sánh</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="upcoming-meetings" id="tools" style="background-color: #fff !important; padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 style="color: #1f272b !important;">Công cụ hỗ trợ thí sinh</h2>
                    <p style="color: #666 !important;">Chọn công cụ phù hợp để định hướng tương lai của bạn</p>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="meeting-item shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="thumb">
                        <a href="index.php?page=assessment"><img src="public/assets/images/meeting-01.jpg" alt="Test Năng lực" style="height: 200px; object-fit: cover;"></a>
                    </div>
                    <div class="down-content" style="background: #f7f7f7; padding: 30px; height: 100%;">
                        <a href="index.php?page=assessment"><h4 style="color: #1f272b; margin-top: 0;">Trắc Nghiệm Tính Cách</h4></a>
                        <p style="color: #666;">Khám phá bản thân qua bài test Holland Code (RIASEC) để chọn nghề đúng.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="meeting-item shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="thumb">
                        <div class="scroll-to-section"><a href="#consulting"><img src="public/assets/images/meeting-02.jpg" alt="Tra cứu" style="height: 200px; object-fit: cover;"></a></div>
                    </div>
                    <div class="down-content" style="background: #f7f7f7; padding: 30px; height: 100%;">
                        <div class="scroll-to-section"><a href="#consulting"><h4 style="color: #1f272b; margin-top: 0;">Tra Cứu Điểm Chuẩn</h4></a></div>
                        <p style="color: #666;">Gợi ý trường và ngành có khả năng đậu cao nhất dựa trên điểm thi của bạn.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="meeting-item shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="thumb">
                        <a href="index.php?page=compare"><img src="public/assets/images/meeting-03.jpg" alt="So sánh" style="height: 200px; object-fit: cover;"></a>
                    </div>
                    <div class="down-content" style="background: #f7f7f7; padding: 30px; height: 100%;">
                        <a href="index.php?page=compare"><h4 style="color: #1f272b; margin-top: 0;">So Sánh Ngành/Trường</h4></a>
                        <p style="color: #666;">Đặt 2 lựa chọn lên bàn cân: Học phí, Việc làm, Điểm chuẩn...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="apply-now" id="consulting" style="padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 style="color: #fff !important;">Tra Cứu & Tư Vấn</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            
            <div class="col-lg-6 align-self-center mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="item" style="background: rgba(255,255,255,0.1); padding: 40px; border-radius: 20px;">
                            <h3 style="color: #fff; margin-bottom: 20px;">NHẬP THÔNG TIN</h3>
                            <form method="POST" action="index.php?page=advice&action=result#consulting">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-white">Tổng điểm thi (3 môn):</label>
                                    <input type="number" step="0.01" name="score" class="form-control" 
                                           value="<?= isset($searchScore) ? htmlspecialchars($searchScore) : '' ?>" 
                                           placeholder="Ví dụ: 24.5" required style="border-radius: 20px; padding: 10px 20px;">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-white">Nhóm ngành quan tâm:</label>
                                    <select name="group" class="form-select" style="border-radius: 20px; padding: 10px 20px;">
                                        <option value="IT" <?= (isset($searchGroup) && $searchGroup == 'IT') ? 'selected' : '' ?>>💻 Công nghệ thông tin</option>
                                        <option value="KT" <?= (isset($searchGroup) && $searchGroup == 'KT') ? 'selected' : '' ?>>💰 Kinh tế & Quản trị</option>
                                        <option value="YD" <?= (isset($searchGroup) && $searchGroup == 'YD') ? 'selected' : '' ?>>💊 Y Dược</option>
                                        <option value="NN" <?= (isset($searchGroup) && $searchGroup == 'NN') ? 'selected' : '' ?>>🌏 Ngôn ngữ</option>
                                        <option value="CK" <?= (isset($searchGroup) && $searchGroup == 'CK') ? 'selected' : '' ?>>⚙️ Kỹ thuật - Cơ khí</option>
                                    </select>
                                </div>
                                
                                <div class="main-button-red">
                                    <button type="submit" name="submit_advice" style="border:none; background:transparent; color:fff; width:100%; font-weight:bold; cursor:pointer;">
                                        TƯ VẤN NGAY
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 align-self-center">
                <div class="accordions is-first-expanded">
                    <?php if (isset($results)): ?>
                        <div class="item" style="background: #fff; padding: 30px; border-radius: 20px; min-height: 400px;">
                            <h4 class="mb-3 fw-bold text-dark" style="color: #1f272b;"><i class="fas fa-search"></i> Kết quả tìm kiếm:</h4>
                            
                            <?php if (count($results) > 0): ?>
                                <div class="list-group shadow-sm" style="max-height: 400px; overflow-y: auto;">
                                    <?php foreach ($results as $row): ?>
                                        <?php 
                                            $diff = $searchScore - $row['score'];
                                            if ($diff >= 2) {
                                                $badgeClass = "bg-success"; $statusText = "Khả năng đậu RẤT CAO";
                                            } elseif ($diff >= 0.5) {
                                                $badgeClass = "bg-primary"; $statusText = "Khả năng đậu CAO";
                                            } else {
                                                $badgeClass = "bg-warning text-dark"; $statusText = "Cơ hội (Cân nhắc)";
                                            }
                                        ?>
                                        <div class="list-group-item list-group-item-action p-3 mb-2 border rounded">
                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                <h5 class="mb-1 text-danger fw-bold" style="font-size:16px;"><?= htmlspecialchars($row['uni_name']) ?> (<?= htmlspecialchars($row['uni_code']) ?>)</h5>
                                            </div>
                                            <span class="badge <?= $badgeClass ?> rounded-pill mb-2"><?= $statusText ?></span>
                                            <p class="mb-1 fw-bold text-dark" style="font-size:14px;">Ngành: <?= htmlspecialchars($row['major_name']) ?></p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">Điểm chuẩn: <b class="text-danger fs-6"><?= $row['score'] ?></b></small>
                                                <small class="text-muted fst-italic">Chênh lệch: +<?= round($diff, 2) ?></small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger shadow-sm text-center py-4" role="alert">
                                    <h5 class="alert-heading fw-bold">😞 Rất tiếc!</h5>
                                    <p class="text-dark">Với mức điểm <b><?= htmlspecialchars($searchScore) ?></b>, chưa tìm thấy trường phù hợp trong cơ sở dữ liệu.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    
                    <?php else: ?>
                        <div class="item" style="background: rgba(255,255,255,0.1); padding: 40px; border-radius: 20px; text-align: center;">
                            <h3 style="color: #fff;">Trợ lý UniGuide sẵn sàng!</h3>
                            <p style="color: #fff;">Hãy nhập điểm thi ở khung bên trái để tôi bắt đầu phân tích dữ liệu cho bạn.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="contact-us" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 align-self-center">
          <div class="row">
            <div class="col-lg-12">
              <form id="contact" action="" method="post">
                <div class="row">
                  <div class="col-lg-12">
                    <h2>Liên hệ với chúng tôi</h2>
                  </div>
                  <div class="col-lg-12">
                      <p class="text-white">Nếu bạn cần hỗ trợ thêm, vui lòng gửi email về admin@uniguide.edu.vn</p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="right-info">
            <ul>
              <li><h6>Điện thoại</h6><span>090.123.4567</span></li>
              <li><h6>Email</h6><span>info@uniguide.edu</span></li>
              <li><h6>Địa chỉ</h6><span>TP. Hồ Chí Minh</span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <div class="footer">
      <p>Copyright © 2024 UniGuide System. 
          <br>Design: <a href="#" target="_parent" title="free css templates">Minh Quan</a>
      </p>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>