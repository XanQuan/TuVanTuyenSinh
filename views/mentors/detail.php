<?php require_once 'views/layouts/header.php'; ?>

<div class="fade-in-page">
    <section class="mentor-hero-new" style="background: linear-gradient(135deg, #a71d2a 0%, #2b2d42 100%); padding: 80px 0; color: #fff; position: relative; overflow: hidden;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-md-3 mb-4 mb-md-0 text-center">
                    <div class="mentor-avatar-wrap">
                        <?php 
                            $avatar = !empty($mentor['avatar']) ? $mentor['avatar'] : 'default_mentor.jpg';
                            $avatarPath = "public/assets/images/" . $avatar;
                        ?>
                        <img src="<?= $avatarPath ?>" 
                             style="width: 200px; height: 200px; border-radius: 30px; border: 8px solid rgba(255,255,255,0.1); object-fit: cover; shadow: 0 15px 35px rgba(0,0,0,0.3);"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($mentor['full_name']) ?>&size=200&background=fff&color=a71d2a'">
                    </div>
                </div>
                <div class="col-md-9 ps-md-5">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 fw-bold shadow-sm" style="border-radius: 10px;"><?= htmlspecialchars($mentor['job_title'] ?? 'Chuyên gia') ?></span>
                    <h1 class="display-4 fw-bold mb-2 text-white"><?= htmlspecialchars($mentor['full_name'] ?? 'Đang cập nhật') ?></h1>
                    <p class="lead mb-0" style="color: rgba(255,255,255,0.8);"><i class="fas fa-graduation-cap me-2"></i><?= htmlspecialchars($mentor['expertise'] ?? 'Kết nối chuyên gia UniGuide') ?></p>
                </div>
            </div>
        </div>
        <div style="position: absolute; right: -5%; bottom: -10%; opacity: 0.1; font-size: 200px; color: #fff;">
            <i class="fas fa-quote-right"></i>
        </div>
    </section>

    <section style="padding: 60px 0; background: #f4f7f6;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
                        <h4 class="fw-bold mb-4 d-flex align-items-center" style="color: #2d3436;">
                            <span style="width: 6px; height: 25px; background: #a71d2a; display: inline-block; margin-right: 15px; border-radius: 10px;"></span>
                            Tiểu sử & Kinh nghiệm
                        </h4>
                        <div class="mentor-bio-text text-secondary" style="font-size: 17px; line-height: 1.8; text-align: justify;">
                            <?= nl2br(htmlspecialchars($mentor['bio'] ?? 'Thông tin kinh nghiệm đang được cập nhật.')) ?>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                        <h4 class="fw-bold mb-4 d-flex align-items-center" style="color: #2d3436;">
                            <span style="width: 6px; height: 25px; background: #3498db; display: inline-block; margin-right: 15px; border-radius: 10px;"></span>
                            Kỹ năng tư vấn chuyên sâu
                        </h4>
                        <div class="row g-3">
                            <?php 
                            if (!empty($mentor['expertise'])): 
                                $skills = explode(',', $mentor['expertise']); 
                                foreach ($skills as $s): 
                                    $skill = trim($s);
                                    if($skill != ''):
                            ?>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 d-flex align-items-center" style="background: #f0f7ff; border-left: 4px solid #3498db;">
                                        <i class="fa fa-check-circle text-primary me-3 fs-5"></i>
                                        <span class="fw-medium text-dark"><?= htmlspecialchars($skill) ?></span>
                                    </div>
                                </div>
                            <?php 
                                    endif;
                                endforeach; 
                            else: 
                                echo '<p class="text-muted italic">Đang cập nhật kỹ năng chuyên sâu...</p>';
                            endif; 
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px; z-index: 10;">
                        <div class="card p-4 border-0 shadow-lg rounded-4 text-center bg-white border-top border-5 border-danger">
                            <h5 class="fw-bold mb-3 text-dark">Đặt lịch tư vấn</h5>
                            <p class="text-muted small mb-4 px-2">Nhận lời khuyên trực tiếp 1:1 từ chuyên gia để định hướng tương lai chính xác nhất.</p>
                            
                            <a href="<?= !empty($mentor['linkedin_url']) ? (str_contains($mentor['linkedin_url'], 'http') ? $mentor['linkedin_url'] : 'https://' . $mentor['linkedin_url']) : '#' ?>" 
                               target="_blank"
                               class="btn btn-primary btn-lg w-100 rounded-pill py-3 fw-bold mb-3 shadow pulse-effect"
                               style="background-color: #0077b5; border: none;">
                                <i class="fab fa-linkedin me-2"></i> KẾT NỐI LINKEDIN
                            </a>
                            
                            <button onclick="openBookingModal(<?= $mentor['id'] ?>, '<?= htmlspecialchars($mentor['full_name']) ?>')" 
                                    class="btn btn-danger btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm"
                                    style="background-color: #a71d2a; border: none;">
                                <i class="fas fa-calendar-alt me-2 text-warning"></i> HẸN LỊCH 1:1
                            </button>
                            
                            <div class="mt-4 pt-3 border-top">
                                <p class="small text-muted mb-0"><i class="fas fa-shield-alt me-1"></i> Thông tin của bạn luôn được bảo mật</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .mentor-avatar-wrap img {
        transition: all 0.5s ease;
    }
    .mentor-avatar-wrap img:hover {
        transform: rotate(3deg) scale(1.05);
    }
    .shadow-soft { box-shadow: 0 10px 40px rgba(0,0,0,0.04) !important; }
    .fade-in-page { animation: fadeIn 0.8s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .pulse-effect:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,119,181,0.2) !important; }
</style>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function openBookingModal(mentorId, mentorName) {
    Swal.fire({
        title: `<h3 style="color: #be1e2d; margin-bottom: 20px; font-weight: 700;">Hẹn lịch tư vấn với<br><span style="color: #333;">${mentorName}</span></h3>`,
        html: `
            <div class="swal-custom-form" style="text-align: left;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #555;">Họ tên của bạn</label>
                    <input id="swal-name" class="form-control-custom" value="<?= $_SESSION['user']['fullname'] ?? '' ?>" placeholder="Nhập họ tên...">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #555;">Email liên hệ</label>
                    <input id="swal-email" class="form-control-custom" value="<?= $_SESSION['user']['email'] ?? '' ?>" placeholder="example@gmail.com">
                </div>
                
                <div style="margin-bottom: 10px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #555;">Vấn đề cần hỗ trợ</label>
                    <textarea id="swal-note" class="form-control-custom" style="height: 120px; resize: none;" placeholder="Mô tả ngắn gọn vấn đề bạn cần chuyên gia giải đáp..."></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Gửi yêu cầu ngay',
        cancelButtonText: 'Để sau',
        confirmButtonColor: '#be1e2d',
        cancelButtonColor: '#6c757d',
        buttonsStyling: true,
        customClass: {
            confirmButton: 'btn-swal-confirm',
            cancelButton: 'btn-swal-cancel'
        },
        preConfirm: () => {
            const name = document.getElementById('swal-name').value.trim();
            const email = document.getElementById('swal-email').value.trim();
            const note = document.getElementById('swal-note').value.trim();

            if (!name || !email || !note) {
                Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin!');
                return false;
            }

            const formData = new FormData();
            formData.append('mentor_id', mentorId);
            formData.append('fullname', name);
            formData.append('email', email);
            formData.append('note', note);

            return fetch('index.php?page=mentors&action=register_participation', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .catch(error => Swal.showValidationMessage(`Lỗi: ${error}`));
        }
    }).then((result) => {
        if (result.isConfirmed && result.value.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: result.value.message,
                confirmButtonColor: '#be1e2d'
            });
        }
    });
}
</script>
<style>
    /* CSS tùy chỉnh cho Form trong SweetAlert */
    .form-control-custom {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        box-sizing: border-box; /* Đảm bảo padding không làm tràn khung */
        transition: border-color 0.3s;
        display: block;
    }

    .form-control-custom:focus {
        border-color: #be1e2d;
        outline: none;
        box-shadow: 0 0 5px rgba(190, 30, 45, 0.1);
    }

    .swal2-html-container {
        overflow: hidden !important; /* Tránh hiện thanh cuộn không cần thiết */
    }

    .swal-custom-form label {
        font-family: 'Poppins', sans-serif;
    }

    /* Tùy chỉnh khoảng cách nút */
    .btn-swal-confirm, .btn-swal-cancel {
        padding: 12px 30px !important;
        font-weight: 600 !important;
        border-radius: 30px !important;
    }
</style>

<?php require_once 'views/layouts/footer.php'; ?>