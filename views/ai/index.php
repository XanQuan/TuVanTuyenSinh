<?php require_once 'views/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
    /* 1. RESET TOÀN TRANG */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden; 
        background-color: #0d1117;
    }

    /* 2. LAYOUT CHIA CỘT */
    .ai-page-wrapper {
        display: flex;
        margin-top: 80px; 
        height: calc(100vh - 80px); 
        background-color: #0d1117;
    }

    /* 3. SIDEBAR BÊN TRÁI */
    .chat-sidebar {
        width: 280px;
        background: #010409;
        border-right: 1px solid #30363d;
        display: flex;
        flex-direction: column;
        padding: 20px 15px;
        flex-shrink: 0;
        height: 100%;
    }

    .new-chat-link {
        background: rgba(239, 126, 126, 0.1);
        border: 1px solid rgba(239, 126, 126, 0.3);
        border-radius: 10px;
        padding: 12px 15px;
        color: #ef7e7e;
        text-decoration: none;
        margin-top: 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-weight: 600;
        transition: 0.3s;
    }

    /* 4. ÉP MÀU CHỮ TRẮNG TOÀN DIỆN CHO NỘI DUNG CHAT */
    .msg-content, 
    .ai-rendered-content, 
    .ai-rendered-content p, 
    .ai-rendered-content span,
    .ai-rendered-content li,
    .ai-rendered-content div {
        color: #ffffff !important; /* Trắng tinh khiết 100% */
        opacity: 1 !important;     /* Loại bỏ độ mờ */
        font-weight: 400;
        line-height: 1.8;
        font-size: 16px;
    }

    /* Làm nổi bật các đoạn chat của AI */
    .ai-msg .msg-content {
        color: #ffffff !important;
        text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.8); /* Bóng đổ giúp chữ nổi bật hơn */
    }

    /* Màu đỏ hồng cho các từ khóa quan trọng */
    .ai-rendered-content strong {
        color: #ff4d4d !important; 
        font-weight: 700;
    }

    /* Màu cho tiêu đề trong đoạn chat */
    .ai-rendered-content h1, 
    .ai-rendered-content h2, 
    .ai-rendered-content h3 {
        color: #ef7e7e !important;
        margin-top: 15px;
        margin-bottom: 10px;
    }

    /* Sidebar - Lịch sử trò chuyện */
    .history-list {
        flex: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .history-item {
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 14px;
        color: #ced4da !important; /* Xám sáng cho lịch sử */
        text-decoration: none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: 0.2s;
    }
    .history-item:hover, .history-item.active { 
        background: #21262d; 
        color: #ffffff !important; 
    }

    /* 5. VÙNG CHAT CHÍNH */
    .chat-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    #chat-box {
        flex: 1;
        overflow-y: auto;
        padding: 40px 15% 150px 15%; 
        display: flex;
        flex-direction: column;
        gap: 35px;
    }

    .message-row { display: flex; gap: 20px; width: 100%; animation: fadeIn 0.4s ease; }
    .ai-msg { justify-content: flex-start; }
    .user-msg { justify-content: flex-end; }

    .ai-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, #a71d2a, #ff4d4d);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    .user-msg .msg-content {
        background-color: #21262d;
        border: 1px solid #3d444d;
        padding: 12px 24px;
        border-radius: 20px 20px 0px 20px;
        max-width: 70%;
    }

    /* 6. THANH NHẬP LIỆU */
    .chat-footer {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 30px 15%;
        background: linear-gradient(transparent, #0d1117 50%);
    }

    .input-wrapper {
        max-width: 800px;
        margin: 0 auto;
        background: #1c2128;
        border: 1px solid #444c56;
        border-radius: 15px;
        padding: 8px 18px;
        display: flex;
        align-items: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    #user-input {
        background: transparent !important;
        border: none !important;
        color: #ffffff !important;
        padding: 12px 10px;
        font-size: 16px;
        flex: 1;
        outline: none;
    }

    .btn-send {
        background: #a71d2a;
        color: white;
        border: none;
        width: 40px; height: 40px;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
    }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="ai-page-wrapper">
    <div class="chat-sidebar">
        <a href="index.php?page=ai_consultant" class="new-chat-link">
            <i class="fa-solid fa-plus"></i> + Chat mới
        </a>
        <div class="history-list">
            <?php if (isset($all_sessions) && !empty($all_sessions)): ?>
                <?php foreach($all_sessions as $s): ?>
                    <a href="index.php?page=ai_consultant&session_id=<?= $s['id'] ?>" 
                       class="history-item <?= (isset($_GET['session_id']) && $_GET['session_id'] == $s['id']) ? 'active' : '' ?>">
                        <i class="fa-regular fa-comment me-2"></i> <?= htmlspecialchars($s['title']) ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="chat-container">
        <input type="hidden" id="current-session-id" value="<?= $_GET['session_id'] ?? '' ?>">
        <div id="chat-box">
            <div class="message-row ai-msg">
                <div class="ai-avatar"><i class="fa-solid fa-robot"></i></div>
                <div class="msg-content">
                    Chào bạn! Tôi là <strong>UniGuide AI</strong>. Hãy hỏi tôi bất cứ điều gì nhé!
                </div>
            </div>

            <?php if (!empty($history)): ?>
                <?php foreach ($history as $chat): ?>
                    <div class="message-row user-msg">
                        <div class="msg-content"><?= htmlspecialchars($chat['user_message']) ?></div>
                    </div>
                    <div class="message-row ai-msg">
                        <div class="ai-avatar"><i class="fa-solid fa-robot"></i></div>
                        <div class="msg-content ai-rendered-content"><?= htmlspecialchars($chat['ai_response']) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="chat-footer">
            <div class="input-wrapper">
                <input id="user-input" type="text" placeholder="Hỏi UniGuide về ngành học..." autocomplete="off">
                <button onclick="sendMessage()" class="btn-send">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    const chatBox = document.getElementById("chat-box");
    document.querySelectorAll('.ai-rendered-content').forEach(el => {
        el.innerHTML = marked.parse(el.innerText);
    });
    chatBox.scrollTop = chatBox.scrollHeight;
});

function sendMessage() {
    const input = document.getElementById('user-input');
    const box = document.getElementById('chat-box');
    const sessionIdField = document.getElementById('current-session-id');
    const msg = input.value.trim();
    if(!msg) return;

    box.innerHTML += `<div class="message-row user-msg"><div class="msg-content">${msg}</div></div>`;
    input.value = '';
    box.scrollTop = box.scrollHeight;

    const loadingId = 'loading-' + Date.now();
    box.innerHTML += `<div id="${loadingId}" class="message-row ai-msg"><div class="ai-avatar"><i class="fa-solid fa-robot"></i></div><div class="msg-content">Đang suy nghĩ...</div></div>`;
    box.scrollTop = box.scrollHeight;

    const formData = new FormData();
    formData.append('message', msg);
    formData.append('session_id', sessionIdField.value);

    fetch('index.php?page=ai_consultant&action=send_message', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        document.getElementById(loadingId).remove(); 
        if (data.status === 'success') {
            if(!sessionIdField.value && data.session_id) {
                window.location.href = 'index.php?page=ai_consultant&session_id=' + data.session_id;
                return;
            }
            const formattedReply = marked.parse(data.reply);
            box.innerHTML += `<div class="message-row ai-msg"><div class="ai-avatar"><i class="fa-solid fa-robot"></i></div><div class="msg-content ai-rendered-content">${formattedReply}</div></div>`;
        }
        box.scrollTop = box.scrollHeight;
    });
}
document.getElementById('user-input').addEventListener('keypress', (e) => { if(e.key === 'Enter') sendMessage(); });
</script>

<?php require_once 'views/layouts/footer.php'; ?>