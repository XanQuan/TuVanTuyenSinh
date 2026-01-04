<?php require_once 'views/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<div class="ai-page-wrapper">
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="chat-main-card shadow-lg rounded-4 overflow-hidden bg-white" style="height: 650px; display: flex; flex-direction: column;">
                    <div class="chat-header bg-danger text-white p-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-robot me-2 fs-4"></i>
                            <h5 class="mb-0 fw-bold">Trợ lý Tuyển sinh AI</h5>
                        </div>
                        <a href="index.php?page=ai_consultant&action=history" class="btn btn-outline-light btn-sm rounded-pill">Lịch sử</a>
                    </div>

                    <div id="chat-box" class="chat-body flex-grow-1 p-4 overflow-auto bg-light d-flex flex-column gap-3">
                        <div class="message-row ai-msg"><div class="msg-content shadow-sm p-3 bg-white rounded-3">Xin chào! Tôi là UniGuide AI. Bạn cần tra cứu thông tin gì không?</div></div>
                        <?php if (!empty($history)): ?>
                            <?php foreach ($history as $chat): ?>
                                <div class="message-row user-msg text-end"><div class="msg-content d-inline-block p-3 bg-danger text-white rounded-3 shadow-sm"><?= htmlspecialchars($chat['user_message']) ?></div></div>
                                <div class="message-row ai-msg"><div class="msg-content shadow-sm p-3 bg-white rounded-3 ai-rendered-content"><?= htmlspecialchars($chat['ai_response']) ?></div></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="chat-footer p-3 border-top bg-white">
                        <div class="input-group">
                            <input id="user-input" type="text" class="form-control rounded-pill px-4" placeholder="Nhập câu hỏi...">
                            <button onclick="sendMessage()" class="btn btn-danger rounded-circle ms-2 shadow-sm"><i class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    const chatBox = document.getElementById("chat-box");
    document.querySelectorAll('.ai-rendered-content').forEach(el => { el.innerHTML = marked.parse(el.innerText); });
    chatBox.scrollTop = chatBox.scrollHeight;
});

function sendMessage() {
    const input = document.getElementById('user-input');
    const box = document.getElementById('chat-box');
    const msg = input.value.trim();
    if(!msg) return;

    box.innerHTML += `<div class="message-row user-msg text-end"><div class="msg-content d-inline-block p-3 bg-danger text-white rounded-3 shadow-sm">${msg}</div></div>`;
    input.value = '';
    box.scrollTop = box.scrollHeight;

    const loadingId = 'loading-' + Date.now();
    box.innerHTML += `<div id="${loadingId}" class="message-row ai-msg"><div class="msg-content shadow-sm p-3 bg-white rounded-3"><i class="fa-solid fa-spinner fa-spin me-2"></i> Đang tra cứu dữ liệu thực tế...</div></div>`;
    box.scrollTop = box.scrollHeight;

    const formData = new FormData();
    formData.append('message', msg);

   fetch('index.php?page=ai_consultant&action=send_message', { method: 'POST', body: formData })
.then(res => res.json())
.then(data => {
    // Luôn xóa vòng xoay khi có phản hồi (kể cả lỗi)
    document.getElementById(loadingId).remove(); 
    
    if (data.status === 'success') {
        const formattedReply = marked.parse(data.reply);
        box.innerHTML += `<div class="message-row ai-msg"><div class="msg-content shadow-sm p-3 bg-white rounded-3">${formattedReply}</div></div>`;
    } else {
        // Hiện lỗi màu đỏ để bạn biết chính xác tại sao không chạy
        box.innerHTML += `<div class="message-row ai-msg"><div class="msg-content shadow-sm p-3 bg-white rounded-3 text-danger">⚠️ ${data.message}</div></div>`;
    }
    box.scrollTop = box.scrollHeight;
})
}
document.getElementById('user-input').addEventListener('keypress', (e) => { if(e.key === 'Enter') sendMessage(); });
</script>
<?php require_once 'views/layouts/footer.php'; ?>