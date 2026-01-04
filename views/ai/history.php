<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-5 pt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark"><i class="fa fa-history me-2 text-danger"></i> Lịch sử tư vấn AI</h3>
                <a href="index.php" class="btn btn-outline-danger rounded-pill px-4">Quay lại trang chủ</a>
            </div>

            <?php if (empty($chat_history)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                    <img src="public/assets/images/search-illustration.png" style="max-width: 200px;" class="mx-auto mb-3">
                    <h5>Bạn chưa có lịch sử tư vấn nào.</h5>
                    <p class="text-muted">Hãy bắt đầu trò chuyện với UniBot ngay nhé!</p>
                </div>
            <?php else: ?>
                <div class="timeline-wrapper">
                    <?php foreach ($chat_history as $chat): ?>
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-light border-0 py-3 d-flex justify-content-between align-items-center">
                                <span class="badge bg-danger rounded-pill px-3">
                                    <i class="fa fa-calendar-alt me-1"></i> <?= date('d/m/Y H:i', strtotime($chat['created_at'])) ?>
                                </span>
                                <small class="text-muted italic">ID cuộc hội thoại: #<?= $chat['id'] ?></small>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <h6 class="fw-bold text-primary"><i class="fa fa-user me-2"></i> Câu hỏi của bạn:</h6>
                                    <p class="bg-primary bg-opacity-10 p-3 rounded-3 text-dark mb-0">
                                        <?= htmlspecialchars($chat['user_message']) ?>
                                    </p>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-success"><i class="fa fa-robot me-2"></i> Trợ lý UniBot trả lời:</h6>
                                    <div class="bg-success bg-opacity-10 p-3 rounded-3 text-dark ai-response-content">
                                        <?= nl2br(htmlspecialchars($chat['ai_response'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .timeline-wrapper { position: relative; padding-left: 20px; border-left: 3px solid #f1f1f1; }
    .card { transition: 0.3s; }
    .card:hover { transform: translateX(5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }
    .ai-response-content { line-height: 1.6; font-size: 15px; }
</style>

<?php require_once 'views/layouts/footer.php'; ?>