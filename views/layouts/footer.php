<script src="/TuVanTuyenSinh/public/vendor/jquery/jquery.min.js"></script>
<script src="/TuVanTuyenSinh/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/TuVanTuyenSinh/public/assets/js/isotope.min.js"></script>
<script src="/TuVanTuyenSinh/public/assets/js/owl-carousel.js"></script>
<script src="/TuVanTuyenSinh/public/assets/js/lightbox.js"></script>
<script src="/TuVanTuyenSinh/public/assets/js/tabs.js"></script>
<script src="/TuVanTuyenSinh/public/assets/js/video.js"></script>
<script src="/TuVanTuyenSinh/public/assets/js/slick-slider.js"></script>
<script src="/TuVanTuyenSinh/public/assets/js/custom.js"></script>

<?php if (isset($top_suggestion) && $top_suggestion != "Hệ thống đang phân tích..."): ?>
<section class="py-5" style="background: #fff;">
    <div class="container">
        <div class="ai-learning-card shadow-lg p-5" style="border-radius: 40px; background: #1a1f2b; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.1);">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(190, 30, 45, 0.2); filter: blur(80px); border-radius: 50%;"></div>
            
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-7">
                    <h6 class="text-danger text-uppercase fw-800 letter-spacing-2 mb-3"><i class="fas fa-microchip me-2"></i> Hệ thống AI dự đoán</h6>
                    <h2 class="text-white fw-bold mb-4" style="font-size: 2.5rem;">Lộ trình dành riêng cho bạn</h2>
                    <div class="suggestion-result p-4 rounded-4 mb-4" style="background: rgba(255,255,255,0.05); border-left: 5px solid #be1e2d;">
                        <p class="text-white-50 small mb-2">Dựa trên dữ liệu từ <?= $others->num_rows ?? 0 ?> tiền bối tương đồng:</p>
                        <h3 class="text-warning fw-800 mb-3"><?= htmlspecialchars($top_suggestion) ?></h3>
                        <div class="d-flex gap-3">
                            <span class="badge bg-success py-2 px-3 rounded-pill"><i class="fa fa-check-circle me-1"></i> <?= $top_match_rate ?? 0 ?>% Khớp tính cách</span>
                            <span class="badge bg-primary py-2 px-3 rounded-pill"><i class="fa fa-briefcase me-1"></i> <?= (isset($top_employment_status) && $top_employment_status == 'working') ? 'Đã có việc làm' : 'Đang tìm việc' ?></span>
                        </div>
                    </div>
                    <p class="text-white-50 small"><i class="fa fa-info-circle me-1"></i> Lộ trình được đề xuất dựa trên hồ sơ của tiền bối <strong><?= htmlspecialchars($best_mentor_name ?? 'ẩn danh') ?></strong>.</p>
                </div>
                <div class="col-lg-5 text-center d-none d-lg-block">
                    <div class="ai-icon-animation">
                        <i class="fas fa-robot text-white" style="font-size: 8rem; filter: drop-shadow(0 0 20px rgba(190,30,45,0.5));"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<div id="ai-chat-wrapper" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999;">
    <button id="chat-toggle-btn" class="shadow-lg" style="width: 65px; height: 65px; border-radius: 50%; background: linear-gradient(135deg, #be1e2d 0%, #3a0a0e 100%); border: none; color: #fff; font-size: 28px; cursor: pointer; transition: 0.3s;">
        <i class="fa-solid fa-robot"></i>
    </button>

    <div id="chat-container" class="shadow-xl" style="display: none; position: absolute; bottom: 80px; right: 0; width: 350px; background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid #eee; flex-direction: column;">
        <div style="background: #be1e2d; padding: 15px 20px; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-weight: 700;"><i class="fa-solid fa-brain me-2"></i> Trợ lý ảo UniGuide AI</span>
            <button id="close-chat" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <div id="chat-content" style="height: 350px; overflow-y: auto; padding: 15px; background: #f8faff; display: flex; flex-direction: column; gap: 10px;">
            <div class="ai-msg shadow-sm" style="background: #fff; padding: 10px 15px; border-radius: 15px 15px 15px 0; max-width: 85%; font-size: 14px; align-self: flex-start; color: #333; border: 1px solid #eee;">
                Xin chào! Tôi là AI của UniGuide. Bạn cần tôi tư vấn về ngành học hay điểm chuẩn không?
            </div>
        </div>
        <div style="padding: 15px; background: #fff; border-top: 1px solid #eee;">
            <div class="input-group">
                <input id="chat-input" type="text" class="form-control" placeholder="Nhập câu hỏi..." style="border-radius: 20px 0 0 20px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;">
                <button id="send-btn" class="btn btn-danger" style="border-radius: 0 20px 20px 0; padding: 0 15px;">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }
    .ai-icon-animation { animation: float 4s ease-in-out infinite; }
    .letter-spacing-2 { letter-spacing: 2px; }
    .fw-800 { font-weight: 800; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // A. Xử lý cuộn trang tự động khi có kết quả tra cứu
    <?php if (isset($results)): ?>
        const searchSection = document.getElementById('search-section');
        if (searchSection) {
            setTimeout(() => {
                searchSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 500);
        }
    <?php endif; ?>

    // B. Xử lý Chatbot AI
    const toggleBtn = document.getElementById('chat-toggle-btn');
    const container = document.getElementById('chat-container');
    const closeBtn = document.getElementById('close-chat');
    const sendBtn = document.getElementById('send-btn');
    const input = document.getElementById('chat-input');
    const content = document.getElementById('chat-content');

    toggleBtn.onclick = () => {
        const isOpening = (container.style.display === 'none' || container.style.display === '');
        container.style.display = isOpening ? 'flex' : 'none';
        if (isOpening) loadChatHistory();
    };

    closeBtn.onclick = () => container.style.display = 'none';

    function appendMessage(text, isUser = false) {
        const msgDiv = document.createElement('div');
        msgDiv.style = isUser 
            ? "background: #be1e2d; color: #fff; padding: 10px 15px; border-radius: 15px 15px 0 15px; max-width: 85%; font-size: 14px; align-self: flex-end;"
            : "background: #fff; color: #333; padding: 10px 15px; border-radius: 15px 15px 15px 0; max-width: 85%; font-size: 14px; align-self: flex-start; border: 1px solid #eee;";
        msgDiv.innerText = text;
        content.appendChild(msgDiv);
        content.scrollTop = content.scrollHeight;
    }

    async function loadChatHistory() {
        const res = await fetch('index.php?page=ai_consultant&action=get_history');
        const data = await res.json();
        if (data.status === 'success' && data.history.length > 0) {
            content.innerHTML = '';
            data.history.forEach(msg => {
                appendMessage(msg.user_message, true);
                appendMessage(msg.ai_response, false);
            });
        }
    }

    async function handleSend() {
        const message = input.value.trim();
        if (!message) return;
        appendMessage(message, true);
        input.value = '';
        
        const typing = document.createElement('div');
        typing.innerText = "UniGuide AI đang phân tích...";
        typing.style = "font-size: 12px; color: #888; align-self: flex-start; margin-left: 5px;";
        content.appendChild(typing);

        const formData = new FormData();
        formData.append('message', message);
        try {
            const res = await fetch('index.php?page=ai_consultant&action=send_message', { method: 'POST', body: formData });
            const data = await res.json();
            content.removeChild(typing);
            appendMessage(data.reply); 
        } catch (e) {
            if(content.contains(typing)) content.removeChild(typing);
            appendMessage("Hệ thống AI đang bận. Vui lòng thử lại sau!");
        }
    }

    sendBtn.onclick = handleSend;
    input.onkeypress = (e) => { if(e.key === 'Enter') handleSend(); };
});
</script>