<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết hội thoại - UniGuide Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS KHUNG */
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); color: #fff; z-index: 1000; }
        .main-content { margin-left: 260px; }
        .top-navbar { background-color: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        /* CSS BONG BÓNG CHAT */
        .chat-wrapper { max-height: 65vh; overflow-y: auto; padding: 20px; background: #f8f9fa; border-radius: 15px; }
        .msg-user { align-self: flex-end; background: #fff; color: #333; border: 1px solid #eee; border-radius: 18px 18px 2px 18px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .msg-ai { align-self: flex-start; background: linear-gradient(135deg, #a71d2a 0%, #80131e 100%); color: #fff; border-radius: 18px 18px 18px 2px; box-shadow: 0 4px 10px rgba(167, 29, 42, 0.2); }
        .chat-bubble { max-width: 75%; padding: 12px 18px; margin-bottom: 15px; position: relative; display: flex; flex-direction: column; }
        .time-stamp { font-size: 10px; margin-top: 5px; opacity: 0.7; }
    </style>
</head>
<body>

    <div class="sidebar">
        </div>

    <div class="main-content">
        <div class="top-navbar">
             <h4 class="m-0 text-dark">Chi tiết hội thoại AI</h4>
        </div>

        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="index.php?page=admin&action=chat_logs" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="fas fa-arrow-left me-2"></i> Quay lại
                </a>
                <h5 class="fw-bold m-0 text-uppercase text-muted" style="letter-spacing: 1px;">Lịch sử chi tiết</h5>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 py-3 ps-4">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-comments text-danger me-2"></i> Hội thoại của: <?= htmlspecialchars($user_info['fullname'] ?? 'Người dùng #'.$user_id) ?></h6>
                </div>
                <div class="card-body p-4">
                    <div class="chat-wrapper d-flex flex-column">
                        <?php foreach ($details as $msg): ?>
                            <div class="chat-bubble msg-user shadow-sm">
                                <span class="small fw-bold mb-1 text-danger" style="font-size: 10px;">HỌC SINH</span>
                                <div class="content"><?= htmlspecialchars($msg['user_message']) ?></div>
                                <span class="time-stamp"><?= date('H:i - d/m/Y', strtotime($msg['created_at'])) ?></span>
                            </div>

                            <div class="chat-bubble msg-ai shadow-sm">
                                <span class="small fw-bold mb-1" style="font-size: 10px; color: #ffcc00;">UNIBOT</span>
                                <div class="content small"><?= $msg['ai_response'] ?></div>
                                <span class="time-stamp text-end"><?= date('H:i - d/m/Y', strtotime($msg['created_at'])) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var chatWrapper = document.querySelector('.chat-wrapper');
        chatWrapper.scrollTop = chatWrapper.scrollHeight;
    </script>
</body>
</html>