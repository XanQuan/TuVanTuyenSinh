<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-list text-danger me-2"></i>Ngân hàng Câu hỏi Holland</h4>
        <p class="text-muted mb-0 small">Quản lý các câu hỏi trắc nghiệm định hướng nghề nghiệp.</p>
    </div>
    <button class="btn btn-danger shadow-sm rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
        <i class="fas fa-plus-circle me-2"></i> Thêm câu hỏi
    </button>
</div>

<div class="card table-card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 text-uppercase small fw-bold" width="150">Nhóm</th>
                        <th class="text-uppercase small fw-bold">Nội dung câu hỏi</th>
                        <th class="text-end pe-4 text-uppercase small fw-bold" width="100">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($questions)): ?>
                        <?php foreach ($questions as $q): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 border border-danger border-opacity-10">
                                    NHÓM <?= htmlspecialchars($q['group_code']) ?>
                                </span>
                            </td>
                            <td class="fw-medium text-dark text-wrap" style="min-width: 300px;">
                                <?= htmlspecialchars($q['content']) ?>
                            </td>
                            <td class="text-end pe-4">
                                <a href="index.php?page=admin&action=delete_question&id=<?= $q['id'] ?>" 
                                   class="btn btn-sm btn-outline-secondary border-0 rounded-circle p-2" 
                                   style="width: 32px; height: 32px;"
                                   onclick="return confirm('Bạn có thực sự muốn xóa câu hỏi này không?')"
                                   title="Xóa câu hỏi">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <i class="fas fa-clipboard-list fa-3x mb-3 text-secondary opacity-25"></i>
                                <p class="text-muted mb-0">Chưa có câu hỏi nào trong hệ thống.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="index.php?page=admin&action=save_question" method="POST" class="w-100">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #a71d2a 0%, #80131e 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold text-uppercase"><i class="fas fa-edit me-2"></i> Thêm câu hỏi mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nội dung câu hỏi</label>
                        <textarea name="question_text" class="form-control bg-light border-0" rows="3" placeholder="Nhập nội dung câu hỏi..." required style="border-radius: 10px;"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nhóm tính cách (RIASEC)</label>
                        <select name="holland_group" class="form-select bg-light border-0" required style="border-radius: 10px; height: 45px;">
                            <option value="" disabled selected>-- Chọn nhóm --</option>
                            <option value="R">R - Thực tế (Realistic)</option>
                            <option value="I">I - Nghiên cứu (Investigative)</option>
                            <option value="A">A - Nghệ thuật (Artistic)</option>
                            <option value="S">S - Xã hội (Social)</option>
                            <option value="E">E - Quản lý (Enterprising)</option>
                            <option value="C">C - Nghiệp vụ (Conventional)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-5 fw-bold shadow-sm">Lưu lại</button>
                </div>
            </div>
        </form>
    </div>
</div>