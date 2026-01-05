<?php require_once 'views/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
    /* Nền trang và Layout tổng thể */
    .ai-page-wrapper {
        background-color: #0d1117;
        min-height: calc(100vh - 80px);
        display: flex;
        flex-direction: column;
        color: #e6edf3; /* Màu chữ mặc định sáng */
    }

    .chat-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        max-width: 1000px; 
        margin: 0 auto;
        width: 100%;
    }

    #chat-box {
        flex: 1;
        overflow-y: auto;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        gap: 35px;
    }

    /* FIX LỖI CHỮ KHÓ NHÌN: Tin nhắn từ AI */
    .ai-msg {
        display: flex;
        gap: 20px;
        max-width: 95%;
        animation: fadeIn 0.4s ease;
    }

    .ai-avatar {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #a71d2a, #ff4d4d);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(167, 29, 42, 0.3);
    }

    /* Nội dung trả lời của AI - Quan trọng nhất */
    .ai-msg .msg-content {
        line-height: 1.8;
        font-size: 16px;
        color: #f0f3f5 !important; /* Màu trắng xám rất sáng để cực kỳ dễ đọc */
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    /* Làm nổi bật các đoạn in đậm trong câu trả lời */
    .ai-msg .msg-content strong, 
    .ai-msg .msg-content b {
        color: #ffffff !important;
        font-weight: 700;
        background-color: rgba(167, 29, 42, 0.1); /* Nhấn nhá nhẹ nền đỏ dưới chữ đậm */
        padding: 0 4px;
        border-radius: 4px;
    }

    /* Tin nhắn từ Người dùng */
    .user-msg {
        display: flex;
        justify-content: flex-end;
    }

    .user-msg .msg-content {
        background-color: #21262d; /* Màu xám đậm của bong bóng chat */
        border: 1px solid #3d444d;
        padding: 12px 24px;
        border-radius: 22px;
        max-width: 75%;
        color: #ffffff !important; /* Chữ người dùng trắng tinh */
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    /* Thanh Input nổi */
    .chat-footer {
        padding: 20px;
        background: linear-gradient(to top, #0d1117 80%, transparent);
        position: sticky;
        bottom: 0;
    }

    .input-wrapper {
        max-width: 800px;
        margin: 0 auto;
        background: #1c2128;
        border: 1px solid #444c56;
        border-radius: 30px;
        padding: 8px 18px;
        display: flex;
        align-items: center;
    }

    #user-input {
        background: transparent !important;
        border: none !important;
        color: #ffffff !important;
        padding: 12px 10px;
        font-size: 16px;
    }

    .btn-send {
        background: #a71d2a;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        transition: 0.3s ease;
    }

    .btn-send:hover { background: #d62828; transform: scale(1.1); }

    /* Hiệu ứng mượt */
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="ai-page-wrapper">
    <div class="chat-container">
        <div id="chat-box">
            <div class="message-row ai-msg">
                <div class="ai-avatar"><i class="fa-solid fa-robot"></i></div>
                <div class="msg-content">
                    Chào bạn! Tôi là <strong>UniGuide AI</strong>. Hãy hỏi tôi bất cứ điều gì về ngành học, trường đại học hoặc lộ trình nghề nghiệp mà bạn đang quan tâm nhé!
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
                <input id="user-input" type="text" class="form-control" placeholder="Hỏi UniGuide về ngành Công nghệ, Kinh tế..." autocomplete="off">
                <button onclick="sendMessage()" class="btn-send">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
            <div class="text-center mt-2">
                <small style="color: #6e7681; font-size: 12px;">UniGuide AI có thể mắc sai sót. Hãy kiểm tra lại các thông tin quan trọng.</small>
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
    const msg = input.value.trim();
    if(!msg) return;

    // Append User Message
    box.innerHTML += `<div class="message-row user-msg"><div class="msg-content">${msg}</div></div>`;
    input.value = '';
    box.scrollTop = box.scrollHeight;

    // Append Loading
    const loadingId = 'loading-' + Date.now();
    box.innerHTML += `
        <div id="${loadingId}" class="message-row ai-msg">
            <div class="ai-avatar"><i class="fa-solid fa-robot"></i></div>
            <div class="msg-content"><div class="typing"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
        </div>`;
    box.scrollTop = box.scrollHeight;

    const formData = new FormData();
    formData.append('message', msg);

    fetch('index.php?page=ai_consultant&action=send_message', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        document.getElementById(loadingId).remove(); 
        if (data.status === 'success') {
            const formattedReply = marked.parse(data.reply);
            box.innerHTML += `
                <div class="message-row ai-msg">
                    <div class="ai-avatar"><i class="fa-solid fa-robot"></i></div>
                    <div class="msg-content ai-rendered-content">${formattedReply}</div>
                </div>`;
        } else {
            box.innerHTML += `
                <div class="message-row ai-msg">
                    <div class="ai-avatar" style="background: #444;"><i class="fa-solid fa-exclamation"></i></div>
                    <div class="msg-content text-danger">⚠️ ${data.message}</div>
                </div>`;
        }
        box.scrollTop = box.scrollHeight;
    });
}

document.getElementById('user-input').addEventListener('keypress', (e) => { if(e.key === 'Enter') sendMessage(); });
</script>

<?php require_once 'views/layouts/footer.php'; ?>