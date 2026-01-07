<?php
class AIController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function index() {
        $user_id = $_SESSION['user']['id'] ?? 0;
        $session_id = $_GET['session_id'] ?? null;
        $history = [];
        $all_sessions = [];

        if ($user_id > 0) {
            // 1. Lấy tất cả danh sách phiên chat để hiện lên Sidebar
            $stmtS = $this->conn->prepare("SELECT id, title FROM chat_sessions WHERE user_id = ? ORDER BY created_at DESC");
            $stmtS->bind_param("i", $user_id);
            $stmtS->execute();
            $all_sessions = $stmtS->get_result()->fetch_all(MYSQLI_ASSOC);

            // 2. Nếu đang xem một session cụ thể, lấy tin nhắn của session đó
            if ($session_id) {
                $stmtM = $this->conn->prepare("SELECT user_message, ai_response FROM chat_messages WHERE session_id = ? ORDER BY created_at ASC");
                $stmtM->bind_param("i", $session_id);
                $stmtM->execute();
                $history = $stmtM->get_result()->fetch_all(MYSQLI_ASSOC);
            }
        }
        require 'views/ai/index.php';
    }

   public function send_message() {
    while (ob_get_level()) ob_end_clean(); 
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $user_msg = $_POST['message'] ?? '';
            $user_id = $_SESSION['user']['id'] ?? 0;
            $session_id = $_POST['session_id'] ?? null;

            if (!$user_msg) throw new Exception("Tin nhắn trống");

            // Cập nhật API Key mới của bạn
            $apiKey = "AIzaSyAn1GOlUEKKqdt9B2gAks5t-yxOSNPHNTU"; 
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

            // THAY ĐỔI PROMPT Ở ĐÂY ĐỂ TRẢ LỜI CHI TIẾT HƠN
            $data = [
                "contents" => [
                    ["role" => "user", "parts" => [["text" => 
                        "Bạn là trợ lý tư vấn tuyển sinh UniGuide AI chuyên sâu. 
                        Nhiệm vụ: Hãy phân tích kỹ câu hỏi của người dùng và đưa ra câu trả lời chi tiết, 
                        đầy đủ dữ liệu về các trường đại học, ngành học và điểm chuẩn. 
                        Định dạng: Sử dụng Markdown (bullet points, bảng, tiêu đề đậm) để trình bày đẹp mắt. 
                        Câu hỏi: " . $user_msg
                    ]]]
                ],
                // Tăng Token để không bị ngắt quãng giữa chừng
                "generationConfig" => [
                    "temperature" => 0.7, 
                    "maxOutputTokens" => 2048 
                ]
            ];

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Tăng timeout vì câu trả lời dài sẽ tốn thời gian hơn

            $response = curl_exec($ch);
            if (curl_errno($ch)) throw new Exception("Lỗi kết nối: " . curl_error($ch));
            
            $result = json_decode($response, true);
            curl_close($ch);

            if (isset($result['error'])) throw new Exception("Google báo lỗi: " . $result['error']['message']);

            $ai_reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? "AI không trả lời, hãy thử lại.";

            if ($user_id > 0) {
                if (empty($session_id)) {
                    $title = mb_substr($user_msg, 0, 30) . "..."; 
                    $stmtS = $this->conn->prepare("INSERT INTO chat_sessions (user_id, title) VALUES (?, ?)");
                    $stmtS->bind_param("is", $user_id, $title);
                    $stmtS->execute();
                    $session_id = $this->conn->insert_id;
                }

                $stmtM = $this->conn->prepare("INSERT INTO chat_messages (session_id, user_message, ai_response) VALUES (?, ?, ?)");
                $stmtM->bind_param("iss", $session_id, $user_msg, $ai_reply);
                $stmtM->execute();
            }

            echo json_encode([
                'status' => 'success', 
                'reply' => $ai_reply,
                'session_id' => $session_id
            ]);

        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }
}

    // Các hàm phụ giữ nguyên nếu bạn cần dùng
    public function history() {
        $user_id = $_SESSION['user']['id'] ?? 0;
        if (!$user_id) { header("Location: index.php?page=login"); exit; }
        $stmt = $this->conn->prepare("SELECT * FROM chat_sessions WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $all_sessions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        require_once 'views/ai/history.php';
    }
}