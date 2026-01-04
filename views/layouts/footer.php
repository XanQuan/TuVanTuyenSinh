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
  
  <script>
      // Xử lý hiệu ứng Menu Active và Cuộn trang mượt mà
      $('.nav li:first').addClass('active');

      var showSection = function showSection(section, isAnimate) {
        var direction = section.replace(/#/, ''),
        reqSection = $('.section').filter('[data-section="' + direction + '"]'),
        reqSectionPos = reqSection.offset().top - 0;

        if (isAnimate) {
          $('body, html').animate({ scrollTop: reqSectionPos }, 800);
        } else {
          $('body, html').scrollTop(reqSectionPos);
        }
      };

      var checkSection = function checkSection() {
        $('.section').each(function () {
          var $this = $(this),
          topEdge = $this.offset().top - 80,
          bottomEdge = topEdge + $this.height(),
          wScroll = $(window).scrollTop();
          if (topEdge < wScroll && bottomEdge > wScroll) {
            var currentId = $this.data('section'),
            reqLink = $('a').filter('[href*=\\#' + currentId + ']');
            reqLink.closest('li').addClass('active').
            siblings().removeClass('active');
          }
        });
      };

      $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
        if($(this).attr('href').indexOf('#') !== -1) {
            e.preventDefault();
            showSection($(this).attr('href'), true);
        }
      });

      $(window).scroll(function () {
        checkSection();
      });

      // HÀM QUAN TRỌNG: Để Menu ở Header có thể gọi được
      function toggleAiChat() {
    const container = document.getElementById('chat-container');
    if (container) {
        const isOpening = (container.style.display === 'none' || container.style.display === '');
        container.style.display = isOpening ? 'flex' : 'none';
        
        // Nếu đang mở, hãy tải lịch sử tin nhắn cũ
        if (isOpening) {
            loadChatHistory();
        }
    }
    async function loadChatHistory() {
    const res = await fetch('index.php?page=ai_consultant&action=get_history');
    const data = await res.json();
    if (data.status === 'success' && data.history.length > 0) {
        const content = document.getElementById('chat-content');
        content.innerHTML = ''; // Xóa tin nhắn chào để hiện lịch sử thật
        data.history.forEach(msg => {
            appendMessage(msg.user_message, true); // Tin nhắn bạn gửi
            appendMessage(msg.ai_response, false); // AI trả lời
        });
    }
}
}
  </script>

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

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('chat-toggle-btn');
    const container = document.getElementById('chat-container');
    const closeBtn = document.getElementById('close-chat');
    const sendBtn = document.getElementById('send-btn');
    const input = document.getElementById('chat-input');
    const content = document.getElementById('chat-content');

    // Đồng bộ nút bấm robot với hàm toggle
    toggleBtn.onclick = toggleAiChat;
    closeBtn.onclick = () => container.style.display = 'none';

    function appendMessage(text, isUser = false) {
        const msgDiv = document.createElement('div');
        msgDiv.className = isUser ? 'user-msg shadow-sm' : 'ai-msg shadow-sm';
        msgDiv.style = isUser 
            ? "background: #be1e2d; color: #fff; padding: 10px 15px; border-radius: 15px 15px 0 15px; max-width: 85%; font-size: 14px; align-self: flex-end;"
            : "background: #fff; color: #333; padding: 10px 15px; border-radius: 15px 15px 15px 0; max-width: 85%; font-size: 14px; align-self: flex-start; border: 1px solid #eee;";
        msgDiv.innerText = text;
        content.appendChild(msgDiv);
        content.scrollTop = content.scrollHeight;
    }

    async function handleSend() {
        const message = input.value.trim();
        if (!message) return;

        appendMessage(message, true);
        input.value = '';

        const typingDiv = document.createElement('div');
        typingDiv.innerText = "UniGuide AI đang phân tích...";
        typingDiv.style = "font-size: 12px; color: #888; align-self: flex-start; margin-left: 5px;";
        content.appendChild(typingDiv);

        const formData = new FormData();
        formData.append('message', message);

        try {
            // Gửi tới AIController xử lý thông tin
            const res = await fetch('index.php?page=ai_consultant&action=send_message', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            content.removeChild(typingDiv);
            appendMessage(data.reply); 
        } catch (error) {
            if(content.contains(typingDiv)) content.removeChild(typingDiv);
            appendMessage("Xin lỗi, hệ thống AI đang bận. Vui lòng thử lại sau!");
        }
    }

    sendBtn.onclick = handleSend;
    input.onkeypress = (e) => { if(e.key === 'Enter') handleSend(); };
  });
  </script>
</body>
</html>