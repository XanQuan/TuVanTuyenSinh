<?php require_once 'views/layouts/header.php'; ?>

<?php 
    // Logic nhận diện loại hình để đổi màu chủ đạo (Theme)
    $isOnline = (strtolower($event['type']) === 'online'); 
    $accentColor = $isOnline ? '#28a745' : '#be1e2d'; // Xanh cho Online, Đỏ cho Offline
    $bgColor = $isOnline ? '#f0fdf4' : '#fff5f5';    // Nền nhẹ tương ứng
?>

<div class="fade-in-page">
    <section class="event-hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('public/assets/images/<?= htmlspecialchars($event['image'] ?? 'meeting-bg.jpg') ?>'); background-size: cover; background-position: center; padding: 120px 0 80px 0; color: #fff;">
        <div class="container text-center">
            <span class="badge mb-3 px-3 py-2 text-uppercase shadow-sm" style="letter-spacing: 2px; background: <?= $accentColor ?>; border: 1px solid rgba(255,255,255,0.3);">
                <i class="fa <?= $isOnline ? 'fa-video' : 'fa-users' ?> me-1"></i> <?= htmlspecialchars($event['type']) ?>
            </span>
            <h1 class="display-4 fw-bold mb-3" style="text-shadow: 0 4px 15px rgba(0,0,0,0.3);"><?= htmlspecialchars($event['title']) ?></h1>
            <p class="lead"><i class="fa <?= $isOnline ? 'fa-laptop' : 'fa-map-marker-alt' ?> me-2"></i><?= htmlspecialchars($event['location']) ?></p>
        </div>
    </section>

    <section class="event-body-content" style="padding: 60px 0; background: #fdfdfd;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-soft rounded-5 p-4 mb-4">
                        <h4 class="fw-bold mb-4 d-flex align-items-center" style="color: #2d3436;">
                            <span style="width: 5px; height: 25px; background: <?= $accentColor ?>; display: inline-block; margin-right: 15px; border-radius: 10px;"></span>
                            Tổng quan sự kiện
                        </h4>
                        <div class="event-description" style="font-size: 16px; line-height: 1.8; color: #636e72;">
                            <?= nl2br(htmlspecialchars($event['description'])) ?>
                        </div>
                    </div>

                    <div class="card border-0 shadow-soft rounded-5 p-4 mb-4" style="background: <?= $bgColor ?>; border: 1px solid rgba(0,0,0,0.05);">
                        <h5 class="fw-bold mb-3" style="color: <?= $accentColor ?>;">Bạn sẽ nhận được gì?</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2 text-secondary"><i class="fa fa-check-circle me-2" style="color: <?= $accentColor ?>;"></i> Tài liệu hướng dẫn độc quyền.</div>
                            <div class="col-md-6 mb-2 text-secondary"><i class="fa fa-check-circle me-2" style="color: <?= $accentColor ?>;"></i> Chứng nhận từ UniGuide.</div>
                            <div class="col-md-6 mb-2 text-secondary"><i class="fa fa-check-circle me-2" style="color: <?= $accentColor ?>;"></i> Giao lưu trực tiếp với chuyên gia.</div>
                            <div class="col-md-6 mb-2 text-secondary"><i class="fa fa-check-circle me-2" style="color: <?= $accentColor ?>;"></i> Quà tặng lưu niệm ý nghĩa.</div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-soft rounded-5 p-4">
                        <?php if($isOnline): ?>
                            <h5 class="fw-bold mb-3 text-primary"><i class="fa fa-info-circle me-2"></i>Cách thức tham gia Online</h5>
                            <div class="p-3 rounded-4" style="background: #f8f9fa; border: 1px dashed #ced4da; font-size: 15px; color: #666;">
                                <p class="mb-0">Link tham gia trực tuyến sẽ được gửi qua <strong>Email</strong> bạn đăng ký trước giờ bắt đầu 30 phút. Vui lòng kiểm tra kỹ hộp thư.</p>
                            </div>
                        <?php else: ?>
                            <h5 class="fw-bold mb-3" style="color: #2d3436;"><i class="fa fa-map-marked-alt text-danger me-2"></i>Vị trí tổ chức</h5>
                            <div class="ratio ratio-16x9 rounded-5 overflow-hidden border shadow-sm">
                                <iframe src="https://www.google.com/maps?q=<?= urlencode($event['location']) ?>&output=embed" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <div class="card p-4 border-0 shadow-soft rounded-5 mb-4 bg-white text-center">
                            <h5 class="fw-bold mb-4" style="color: #2d3436;">Xác nhận tham gia</h5>
                            <div class="info-list mb-4">
                                <div class="d-flex mb-3 align-items-center p-3 rounded-4 bg-light transition-hover">
                                    <div class="bg-white shadow-sm rounded-circle p-2 me-3 text-danger" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="fa fa-calendar-alt"></i></div>
                                    <div class="text-start">
                                        <small class="text-muted d-block" style="font-size: 11px;">THỜI GIAN</small>
                                        <strong><?= date('d/m/Y H:i', strtotime($event['event_date'])) ?></strong>
                                    </div>
                                </div>
                                <div class="d-flex mb-3 align-items-center p-3 rounded-4 bg-light transition-hover">
                                    <div class="bg-white shadow-sm rounded-circle p-2 me-3 text-primary" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="fa fa-users"></i></div>
                                    <div class="text-start">
                                        <small class="text-muted d-block" style="font-size: 11px;">HÌNH THỨC</small>
                                        <strong><?= $isOnline ? 'Trực tuyến' : 'Trực tiếp' ?></strong>
                                    </div>
                                </div>
                            </div>
                            <button onclick="openRegisterModal('<?= $event['type'] ?>')" 
        class="btn btn-lg w-100 rounded-pill py-3 fw-bold shadow-lg pulse-effect" 
        style="background: <?= $accentColor ?>; color: #fff; border: none;">
    <?= $isOnline ? 'ĐĂNG KÝ ONLINE' : 'ĐĂNG KÝ THAM GIA' ?> <i class="fa <?= $isOnline ? 'fa-video' : 'fa-arrow-right' ?> ms-2"></i>
</button>
                        </div>
                        <div class="alert alert-light border-0 rounded-4 shadow-soft p-3 text-muted" style="font-size: 13px;">
                            <i class="fa fa-bell me-2 text-warning"></i> Cổng đăng ký sẽ tự động đóng khi đủ số lượng tham dự.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .fade-in-page { animation: fadeIn 1s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    .shadow-soft { box-shadow: 0 10px 40px rgba(0,0,0,0.03) !important; }
    .rounded-5 { border-radius: 30px !important; }
    
    .transition-hover:hover { background: #fff !important; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transform: translateX(5px); transition: 0.3s; }
    
    .pulse-effect:hover { transform: scale(1.03); filter: brightness(1.1); transition: 0.3s; }
    
    /* timeline style từ code cũ của bạn */
    .timeline .border-start { border-width: 2px !important; border-color: <?= $accentColor ?> !important; padding-bottom: 20px; }
</style>

<?php require_once 'views/layouts/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/**
 * Hàm mở bảng đăng ký tham gia sự kiện
 * @param {string} type - Loại hình: 'Online' hoặc 'Offline'
 */
function openRegisterModal(type) {
    const isOnline = (type.toLowerCase() === 'online');
    
    Swal.fire({
        title: `<span style="color: ${isOnline ? '#28a745' : '#be1e2d'}">Đăng ký ${type}</span>`,
        html: `
            <div style="text-align: left; padding: 0 10px;">
                <label class="fw-bold mb-1" style="font-size: 14px;">Họ và tên của bạn</label>
                <input id="swal-name" class="swal2-input" placeholder="Nhập họ tên..." value="<?= $_SESSION['user']['fullname'] ?? '' ?>">
                
                <label class="fw-bold mb-1 mt-3" style="font-size: 14px;">Email nhận link/địa chỉ</label>
                <input id="swal-email" class="swal2-input" placeholder="Email của bạn..." value="<?= $_SESSION['user']['email'] ?? '' ?>">
                
                <p class="mt-3 small text-muted">
                    <i class="fa fa-info-circle"></i> 
                    ${isOnline ? 'Hệ thống sẽ gửi Link tham gia vào Gmail này.' : 'Hệ thống sẽ gửi địa chỉ và bản đồ vào Gmail này.'}
                </p>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Xác nhận & Gửi Mail',
        cancelButtonText: 'Để sau',
        confirmButtonColor: isOnline ? '#28a745' : '#be1e2d',
        focusConfirm: false,
        showLoaderOnConfirm: true,
        // Xử lý trước khi gửi
        preConfirm: () => {
            const name = document.getElementById('swal-name').value;
            const email = document.getElementById('swal-email').value;
            
            if (!name || !email) {
                Swal.showValidationMessage('Vui lòng nhập đầy đủ thông tin để nhận Mail!');
                return false;
            }

            // Gửi dữ liệu bằng AJAX (fetch)
            const formData = new FormData();
            formData.append('event_id', '<?= $event['id'] ?>');
            formData.append('type', type);
            formData.append('fullname', name);
            formData.append('email', email);

            return fetch('index.php?page=events&action=register_participation', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error(response.statusText);
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(`Lỗi: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Đăng ký thành công!',
                    text: 'Vui lòng kiểm tra hộp thư Gmail của bạn để nhận thông tin.',
                    confirmButtonColor: '#be1e2d'
                });
            } else {
                Swal.fire('Thông báo', result.value.message, 'info');
            }
        }
    });
}
</script>

<style>
    /* Tùy chỉnh input của SweetAlert cho mượt hơn */
    .swal2-input {
        height: 45px !important;
        margin: 5px 0 0 0 !important;
        border-radius: 10px !important;
        font-size: 15px !important;
        border: 1px solid #eee !important;
        box-shadow: none !important;
    }
    .swal2-html-container { margin: 15px 0 0 0 !important; }
</style>