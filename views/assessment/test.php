<?php 
// views/assessment/test.php
// Kết nối Header
include __DIR__ . '/../layouts/header.php'; 
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --primary-red: #be1e2d;
        --primary-hover: #a01825;
        --bg-light: #f8f9fa;
        --card-bg: #ffffff;
        --text-main: #2d3436;
        --shadow-soft: 0 10px 30px rgba(0,0,0,0.08);
        --shadow-hover: 0 15px 35px rgba(190, 30, 45, 0.15);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', sans-serif;
    }

    /* BANNER HIỆN ĐẠI */
    .test-banner {
        background: linear-gradient(135deg, #be1e2d 0%, #ff5b5b 100%);
        padding: 140px 0 100px;
        text-align: center;
        color: white;
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        margin-bottom: -60px;
    }

    .test-banner h1 {
        font-weight: 800;
        font-size: 2.8rem;
        text-shadow: 0 4px 10px rgba(0,0,0,0.2);
        margin-bottom: 15px;
    }

    .test-banner p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    /* CONTAINER CHÍNH */
    .test-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 80px;
        position: relative;
        z-index: 10;
    }

    /* LƯỚI CÂU HỎI */
    .questions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    /* THẺ CÂU HỎI */
    .q-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 25px;
        box-shadow: var(--shadow-soft);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 15px;
        user-select: none;
        height: 100%;
    }

    .q-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(190, 30, 45, 0.3);
    }

    .q-card.selected {
        background-color: #fff5f5;
        border-color: var(--primary-red);
        box-shadow: 0 5px 15px rgba(190, 30, 45, 0.2);
    }

    .q-card.selected .check-circle {
        background: var(--primary-red);
        border-color: var(--primary-red);
        color: white;
    }

    .check-circle {
        width: 28px;
        height: 28px;
        min-width: 28px;
        border: 2px solid #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
        color: transparent;
        font-size: 14px;
    }

    .q-content {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-main);
        line-height: 1.5;
    }

    .q-card input[type="checkbox"] {
        display: none;
    }

    /* ACTION BAR */
    .action-bar {
        position: sticky;
        bottom: 20px;
        text-align: center;
        margin-top: 40px;
        z-index: 100;
        pointer-events: none;
    }

    .btn-submit {
        background: var(--primary-red);
        color: white;
        padding: 16px 50px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.2rem;
        border: none;
        box-shadow: 0 10px 20px rgba(190, 30, 45, 0.4);
        transition: 0.3s;
        pointer-events: auto;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-submit:hover {
        background: var(--primary-hover);
        transform: scale(1.05);
        box-shadow: 0 15px 30px rgba(190, 30, 45, 0.5);
    }

    .progress-info {
        background: rgba(255,255,255,0.9);
        padding: 8px 20px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 15px;
        font-weight: 600;
        color: var(--primary-red);
        backdrop-filter: blur(5px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        pointer-events: auto;
    }
</style>

<div class="test-banner">
    <div class="container">
        <h1>KHÁM PHÁ BẢN THÂN</h1>
        <p>Chọn những mô tả bên dưới mà bạn thấy <strong>đúng</strong> hoặc <strong>yêu thích</strong> nhất.</p>
    </div>
</div>

<div class="test-container">
    
    <form action="index.php?page=assessment&action=submit" method="POST" id="testForm">
        
        <div class="questions-grid">
            <?php if (!empty($questions)): ?>
                <?php foreach ($questions as $index => $q): ?>
                
                <label class="q-card" id="card-<?= $index ?>">
                    <input type="checkbox" name="answers[]" 
                           value="<?= htmlspecialchars($q['group_code']) ?>" 
                           onchange="toggleCard(this, 'card-<?= $index ?>')">
                    
                    <div class="check-circle">
                        <i class="fas fa-check"></i>
                    </div>

                    <div class="q-content">
                        <?= htmlspecialchars($q['content']) ?>
                    </div>
                </label>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" alt="Empty" class="mb-3 opacity-50">
                    <h3 class="text-muted">⚠️ Chưa có dữ liệu câu hỏi!</h3>
                    <p>Vui lòng liên hệ Admin để cập nhật ngân hàng câu hỏi.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="action-bar">
            <div class="mb-3">
                <span class="progress-info">
                    <i class="fas fa-tasks me-2"></i> Đã chọn: <span id="countDisplay">0</span> mục
                </span>
            </div>
            <button type="submit" class="btn-submit">
                XEM KẾT QUẢ PHÂN TÍCH <i class="fas fa-arrow-right"></i>
            </button>
        </div>

    </form>
</div>

<script>
    // 1. Hàm đổi màu thẻ khi được chọn
    function toggleCard(checkbox, cardId) {
        const card = document.getElementById(cardId);
        if (checkbox.checked) {
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
        }
        updateCount();
    }

    // 2. Hàm đếm số lượng đã chọn
    function updateCount() {
        const checkboxes = document.querySelectorAll('input[name="answers[]"]:checked');
        document.getElementById('countDisplay').innerText = checkboxes.length;
    }

    // 3. XỬ LÝ SỰ KIỆN NỘP BÀI (DÙNG SWEETALERT2 THAY ALERT CŨ)
    document.getElementById('testForm').addEventListener('submit', function(e) {
        const checked = document.querySelectorAll('input[name="answers[]"]:checked');
        
        // Nếu chưa chọn mục nào
        if (checked.length === 0) {
            e.preventDefault(); // Chặn load lại trang
            
            // HIỆN POPUP ĐẸP
            Swal.fire({
                icon: 'warning',
                title: 'Chưa chọn mục nào!',
                text: 'Bạn cần chọn những mô tả phù hợp với bản thân trước khi xem kết quả.',
                confirmButtonText: 'Đã hiểu',
                confirmButtonColor: '#be1e2d', // Màu đỏ giống web của bạn
                background: '#fff',
                backdrop: `
                    rgba(0,0,123,0.4)
                    left top
                    no-repeat
                `
            });
            
            // Cuộn lên đầu
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    // 4. KIỂM TRA LỖI PHP TỪ SERVER (NẾU CÓ) -> HIỆN POPUP LUÔN
    <?php if (isset($error) && $error): ?>
        Swal.fire({
            icon: 'error',
            title: 'Có lỗi xảy ra',
            text: '<?= htmlspecialchars($error) ?>',
            confirmButtonText: 'Thử lại',
            confirmButtonColor: '#be1e2d'
        });
    <?php endif; ?>
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>