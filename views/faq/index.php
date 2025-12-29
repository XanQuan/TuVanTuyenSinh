<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Hỗ trợ giải đáp</h6>
                <h2>Câu Hỏi Thường Gặp</h2>
            </div>
        </div>
    </div>
</section>

<section class="apply-now" id="apply">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 align-self-center">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="accordions is-first-expanded">
                            <?php if(isset($faqs) && count($faqs) > 0): ?>
                                <?php foreach($faqs as $index => $faq): ?>
                                <article class="accordion">
                                    <div class="accordion-head">
                                        <span><?= htmlspecialchars($faq['question'] ?? 'Câu hỏi...') ?></span>
                                        <span class="icon">
                                            <i class="icon fa fa-chevron-right"></i>
                                        </span>
                                    </div>
                                    <div class="accordion-body">
                                        <div class="content">
                                            <p><?= htmlspecialchars($faq['answer'] ?? 'Đang cập nhật câu trả lời.') ?></p>
                                        </div>
                                    </div>
                                </article>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="item text-center p-5 bg-light rounded">
                                    <p>Chưa có câu hỏi nào trong hệ thống.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>