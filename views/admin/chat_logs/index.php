<div class="container-fluid p-4">
    <h4 class="fw-bold mb-4"><i class="fas fa-history text-danger"></i> Nhật ký Tư vấn AI</h4>
    
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Người dùng</th>
                            <th>Câu hỏi của học sinh</th>
                            <th>Phản hồi của AI</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="ps-4"><strong><?= htmlspecialchars($log['full_name']) ?></strong></td>
                            <td><div class="text-muted small" style="max-width: 300px;"><?= htmlspecialchars($log['user_message']) ?></div></td>
                            <td><div class="small" style="max-width: 400px;"><?= mb_substr(strip_tags($log['ai_response']), 0, 100) ?>...</div></td>
                            <td><small><?= date('H:i d/m/Y', strtotime($log['created_at'])) ?></small></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>