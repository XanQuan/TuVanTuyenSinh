<?php require_once 'views/layouts/header.php'; ?>

<div class="fade-in-page">
    <section class="mentor-hero" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('public/assets/images/meetings-bg.jpg'); padding: 100px 0; color: #fff;">
        <div class="container text-center">
            <div class="mentor-avatar-wrap mb-4">
                <img src="public/assets/images/<?= htmlspecialchars($mentor['avatar'] ?? 'default.jpg') ?>" 
                     style="width: 150px; height: 150px; border-radius: 50%; border: 5px solid #fff; object-fit: cover; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            </div>
            
            <span class="badge bg-danger mb-2 px-3 py-2 text-uppercase"><?= htmlspecialchars($mentor['job_title'] ?? 'Chuyên gia') ?></span>
            <h1 class="fw-bold"><?= htmlspecialchars($mentor['full_name'] ?? 'Đang cập nhật') ?></h1>
            <p class="lead opacity-75"><?= htmlspecialchars($mentor['expertise'] ?? 'Kết nối chuyên gia UniGuide') ?></p>
        </div>
    </section>

    <section style="padding: 80px 0; background: #fdfdfd;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-soft rounded-5 p-5 mb-4">
                        <h4 class="fw-bold mb-4 d-flex align-items-center" style="color: #2d3436;">
                            <span style="width: 5px; height: 25px; background: #be1e2d; display: inline-block; margin-right: 15px; border-radius: 10px;"></span>
                            Tiểu sử & Kinh nghiệm
                        </h4>
                        <div class="mentor-bio-text" style="font-size: 17px; line-height: 1.8; color: #636e72;">
                            <?= nl2br(htmlspecialchars($mentor['bio'] ?? 'Thông tin kinh nghiệm đang được cập nhật.')) ?>
                        </div>
                    </div>

                    <div class="card border-0 shadow-soft rounded-5 p-5" style="background: #f0f7ff;">
                        <h5 class="fw-bold mb-3" style="color: #0056b3;">Lĩnh vực tư vấn chuyên sâu</h5>
                        <ul class="list-unstyled row">
                            <li class="col-md-6 mb-2"><i class="fa fa-check-circle text-primary me-2"></i> Định hướng nghề nghiệp</li>
                            <li class="col-md-6 mb-2"><i class="fa fa-check-circle text-primary me-2"></i> Kỹ năng phỏng vấn</li>
                            <li class="col-md-6 mb-2"><i class="fa fa-check-circle text-primary me-2"></i> Kết nối doanh nghiệp</li>
                            <li class="col-md-6 mb-2"><i class="fa fa-check-circle text-primary me-2"></i> Tư vấn học bổng</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <div class="card p-4 border-0 shadow-soft rounded-5 text-center bg-white">
                            <h5 class="fw-bold mb-4">Đặt lịch tư vấn</h5>
                            <p class="text-muted small mb-4">Kết nối trực tiếp với chuyên gia để nhận được lời khuyên chính xác nhất cho tương lai của bạn.</p>
                            
                            <a href="<?= isset($mentor['linkedin_url']) ? 'https://' . htmlspecialchars($mentor['linkedin_url']) : '#' ?>" 
                               target="_blank"
                               class="btn btn-danger btn-lg w-100 rounded-pill py-3 fw-bold shadow-danger mb-3 pulse-effect">
                                KẾT NỐI NGAY <i class="fa fa-linkedin ms-2"></i>
                            </a>
                            
                            <button onclick="openBookingModal(<?= $mentor['id'] ?>, '<?= htmlspecialchars($mentor['full_name']) ?>')" 
                                    class="btn btn-outline-dark btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm">
                                HẸN LỊCH 1:1
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .shadow-soft { box-shadow: 0 10px 40px rgba(0,0,0,0.04) !important; }
    .rounded-5 { border-radius: 30px !important; }
    .fade-in-page { animation: fadeIn 1s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .pulse-effect:hover { transform: scale(1.03); transition: 0.3s; }
    .swal2-input, .swal2-textarea { border-radius: 10px !important; border: 1px solid #eee !important; box-shadow: none !important; }
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