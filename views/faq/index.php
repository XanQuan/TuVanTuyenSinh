<?php require_once 'views/layouts/header.php'; ?>

<style>
    :root {
        --primary-red: #be1e2d;
        --dark-blue: #1f272b;
        --card-white: rgba(255, 255, 255, 0.92);
    }

    /* Nền tổng thể với hình ảnh phủ mờ */
    .faq-master-wrapper {
    /* Giảm thông số 0.8 xuống 0.3 để ảnh hiện rõ hơn, tăng màu tối để chữ trắng nổi bật */
    background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5)), 
                      url('public/assets/images/cauhoi.jpg'); 
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
    padding: 100px 0;
    min-height: 100vh;
    /* Thêm hiệu ứng làm ảnh nét hơn */
    transition: background 0.5s ease-in-out;
}

    .section-title-box {
        margin-bottom: 60px;
    }

    .section-title-box h2 {
        font-size: 2.8rem;
        font-weight: 900;
        color: var(--dark-blue);
        text-transform: uppercase;
        letter-spacing: -1px;
    }

    /* Masonry Layout */
    .faq-grid {
        column-count: 3;
        column-gap: 30px;
    }

    @media (max-width: 1200px) { .faq-grid { column-count: 2; } }
    @media (max-width: 768px) { .faq-grid { column-count: 1; } }

    .faq-block {
        break-inside: avoid;
        margin-bottom: 30px;
    }

    /* Hiệu ứng thẻ nổi trên nền ảnh */
    .glass-faq-card {
        background: var(--card-white);
        backdrop-filter: blur(15px);
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        cursor: pointer;
    }

    .glass-faq-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 30px 60px rgba(190, 30, 45, 0.15);
        background: #fff;
    }

    .card-header-content {
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .q-text {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dark-blue);
        line-height: 1.4;
        padding-right: 20px;
    }

    /* Vòng tròn chứa icon */
    .icon-circle {
        min-width: 40px;
        height: 40px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-red);
        transition: 0.4s;
    }

    .glass-faq-card.active {
        border-bottom: 5px solid var(--primary-red);
    }

    .glass-faq-card.active .icon-circle {
        background: var(--primary-red);
        color: #fff;
        transform: rotate(135deg);
    }

    /* Phần trả lời xổ xuống */
    .card-body-content {
        max-height: 0;
        overflow: hidden;
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 0;
    }

    .glass-faq-card.active .card-body-content {
        max-height: 800px;
        opacity: 1;
        padding: 0 30px 30px 30px;
    }

    .a-inner {
        padding-top: 20px;
        border-top: 2px solid #f1f1f1;
        font-size: 1rem;
        color: #4a4a4a;
        line-height: 1.8;
    }
</style>

<div class="faq-master-wrapper">
    <div class="container">
        <div class="section-title-box text-center">
            <span class="badge bg-danger px-3 py-2 rounded-pill mb-3" style="font-weight: 600;">Tư vấn và hỗ trợ sinh viên </span>
            <h2>Câu hỏi thường gặp</h2>
            <div class="mx-auto" style="width: 80px; height: 4px; background: var(--primary-red); border-radius: 2px;"></div>
        </div>

        <div class="faq-grid">
            <?php if(!empty($faqs)): ?>
                <?php foreach($faqs as $index => $faq): ?>
                <div class="faq-block">
                    <div class="glass-faq-card" onclick="this.classList.toggle('active')">
                        <div class="card-header-content">
                            <div class="q-text">
                                <span style="color: var(--primary-red); font-family: serif; font-style: italic; margin-right: 8px;">Q.</span>
                                <?= htmlspecialchars($faq['question']) ?>
                            </div>
                            <div class="icon-circle shadow-sm">
                                <i class="fa fa-plus"></i>
                            </div>
                        </div>
                        <div class="card-body-content">
                            <div class="a-inner">
                                <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted h5">Dữ liệu đang được đồng bộ...</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>