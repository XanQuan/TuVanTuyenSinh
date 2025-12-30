<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'views/layouts/header.php'; 
?>

<style>
    /* Nền tối họa tiết chuyên nghiệp */
    body { 
        background-color: #1a1d21; 
        background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png'); 
        color: #fff;
        font-family: 'Inter', sans-serif;
    }

    .history-page { padding-top: 120px; padding-bottom: 80px; min-height: 100vh; }

    /* THANH TÌM KIẾM DẠNG KÉN TRẮNG */
    .search-pill-container { display: flex; justify-content: center; margin-bottom: 50px; }

    .pill-search-bar {
        background: #ffffff;
        border-radius: 50px;
        display: flex;
        align-items: center;
        padding: 5px 10px 5px 25px;
        width: 100%;
        max-width: 800px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    }

    /* Icon kính lúp ở đầu ô nhập */
    .search-pill-bar i.fa-magnifying-glass {
        color: #adb5bd;
        font-size: 1.1rem;
        margin-right: 15px;
    }

    .live-search-input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 12px 0;
        font-size: 1rem;
        font-weight: 600;
        color: #333 !important;
        outline: none;
    }

    /* NÚT TÌM KIẾM TRÒN MÀU ĐỎ CÓ KÍNH LÚP */
    .btn-pill-search {
        background: #be1e2d;
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s ease;
        cursor: pointer;
    }

    .btn-pill-search:hover {
        background: #333;
        transform: rotate(15deg);
    }

    /* DANH SÁCH LỊCH SỬ */
    .history-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 25px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .history-row:hover { background: rgba(255,255,255,0.03); border-radius: 15px; }

    .label-small { display: block; font-size: 10px; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700; margin-bottom: 5px; }
    .score-yellow { color: #ffeb3b !important; font-size: 1.4rem; font-weight: 800; }
    .btn-tra-lai { background: #be1e2d; color: #fff; border: none; padding: 10px 30px; border-radius: 8px; font-weight: 700; text-transform: uppercase; font-size: 12px; }
    
    .d-none { display: none !important; }
</style>

<div class="history-page">
    <div class="container">
        <h4 class="text-center text-uppercase fw-bold mb-5" style="letter-spacing: 2px;">Nhật ký tư vấn của bạn</h4>

        <div class="search-pill-container">
            <div class="pill-search-bar">
                <i class="fa-solid fa-magnifying-glass" style="color: #adb5bd; margin-right: 15px;"></i>
                
                <input type="text" id="live-search-input" class="live-search-input" 
                       placeholder="Gõ tên ngành hoặc số điểm để lọc nhanh..." autocomplete="off">
                
                <button class="btn-pill-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if (!empty($history_list)): ?>
                    <?php foreach ($history_list as $row): ?>
                        <div class="history-row search-item">
                            <div class="d-flex gap-5 align-items-center">
                                <div>
                                    <span class="label-small"><i class="fa-regular fa-calendar-days me-1"></i> Thời gian</span>
                                    <span><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></span>
                                </div>
                                <div class="text-center">
                                    <span class="label-small">Điểm số</span>
                                    <span class="score-yellow search-score"><?= $row['score'] ?></span>
                                </div>
                                <div>
                                    <span class="label-small">Ngành học</span>
                                    <span class="text-uppercase search-major"><?= htmlspecialchars($row['group_code']) ?></span>
                                </div>
                            </div>
                            
                            <form method="POST" action="index.php?page=advice&action=result#consulting">
                                <input type="hidden" name="score" value="<?= $row['score'] ?>">
                                <input type="hidden" name="group" value="<?= $row['group_code'] ?>">
                                <button type="submit" class="btn-tra-lai">Tra lại</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5 opacity-25">
                        <i class="fa-solid fa-box-open fa-4x mb-3"></i>
                        <p>Chưa có dữ liệu tra cứu.</p>
                    </div>
                <?php endif; ?>
                <div id="no-results" class="text-center py-5 d-none">
                    <p class="text-muted">Không tìm thấy kết quả phù hợp.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('live-search-input').addEventListener('input', function() {
        let filter = this.value.toUpperCase();
        let items = document.querySelectorAll('.search-item');
        let hasData = false;

        items.forEach(item => {
            let major = item.querySelector('.search-major').innerText.toUpperCase();
            let score = item.querySelector('.search-score').innerText.toUpperCase();
            if (major.includes(filter) || score.includes(filter)) {
                item.classList.remove('d-none');
                hasData = true;
            } else {
                item.classList.add('d-none');
            }
        });

        document.getElementById('no-results').classList.toggle('d-none', hasData || filter === "");
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?>