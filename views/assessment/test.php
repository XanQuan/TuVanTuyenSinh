<?php 
// views/assessment/test.php
// Đường dẫn vào layouts/header.php
include __DIR__ . '/../layouts/header.php'; 
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary-red: #be1e2d;
        --white: #ffffff;
    }

    body {
        background-color: #f1f5f9;
        font-family: 'Inter', sans-serif;
    }

    /* BANNER ĐỎ NỔI BẬT */
    .test-banner {
        background: linear-gradient(180deg, #d32f2f 0%, var(--primary-red) 100%);
        color: var(--white);
        padding: 120px 0 160px;
        text-align: center;
        position: relative;
    }

    .test-banner h1 {
        font-size: 3rem;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 15px;
        color: var(--white);
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .test-banner p {
        font-size: 1.25rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        max-width: 700px;
        margin: 0 auto;
    }

    /* KHUNG TRẮNG CÂU HỎI */
    .assessment-card {
        background: var(--white);
        border-radius: 30px;
        padding: 45px;
        margin: -100px auto 80px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 20;
        max-width: 1200px;
    }

    /* GRID 4 CỘT - 3 DÒNG */
    .questions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        max-height: 650px; 
        overflow-y: auto;
        padding: 10px;
    }

    /* THẺ CÂU HỎI */
    .q-item {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px 20px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 190px;
        display: flex;
        flex-direction: column;
    }

    .q-item:hover {
        border-color: var(--primary-red);
        background: var(--white);
        transform: translateY(-5px);
    }

    .q-text {
        font-size: 1.15rem;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.6;
    }

    /* NÚT BẤM */
    .btn-submit {
        background: var(--primary-red);
        color: var(--white);
        padding: 20px 60px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 1.2rem;
        border: none;
        margin-top: 50px;
        transition: 0.4s;
        box-shadow: 0 10px 25px rgba(190, 30, 45, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 15px 35px rgba(190, 30, 45, 0.4);
    }
</style>

<section class="test-banner">
    <div class="container">
        <h1>TRẮC NGHIỆM HOLLAND</h1>
        <p>Khám phá bản thân ngay hôm nay - Đi đến Tương Lai sau này.</p>
    </div>
</section>

<div class="container">
    <div class="assessment-card">
        <form action="index.php?page=assessment&action=submit" method="POST">
            <div class="questions-grid">
                <?php if (isset($questions) && is_array($questions) && count($questions) > 0): ?>
                    
                    <?php foreach ($questions as $q): ?>
                    <label class="q-item">
                        <input type="checkbox" name="answers[]" value="<?= $q['group_code'] ?>" 
                               style="width: 24px; height: 24px; accent-color: var(--primary-red); margin-bottom: 15px;">
                        
                        <p class="q-text"><?= $q['content'] ?></p>
                    </label>
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="col-12 text-center text-danger">
                        <h4>⚠️ Lỗi: Không tìm thấy câu hỏi trong Database!</h4>
                        <p>Hãy kiểm tra lại bảng 'questions' trong phpMyAdmin.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-submit">
                    KHÁM PHÁ KẾT QUẢ NGAY <i class="fas fa-bolt ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>