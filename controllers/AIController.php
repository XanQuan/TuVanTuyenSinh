<?php
class AIController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function index() {
        $user_id = $_SESSION['user']['id'] ?? 0;
        $history = [];
        if ($user_id > 0) {
            // Lấy 20 tin nhắn gần nhất để hiển thị lại trên giao diện
            $stmt = $this->conn->prepare("SELECT user_message, ai_response FROM ai_chats WHERE user_id = ? ORDER BY created_at ASC LIMIT 20");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) { $history[] = $row; }
        }
        require 'views/ai/index.php';
    }

public function send_message() {
    // 1. Dọn dẹp bộ đệm để đảm bảo trả về đúng định dạng JSON
    while (ob_get_level()) ob_end_clean(); 
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $user_msg = $_POST['message'] ?? '';
            $user_id = $_SESSION['user']['id'] ?? 0;
            if (!$user_msg) throw new Exception("Tin nhắn trống");

            // 2. Lấy API Key sạch bạn vừa tạo (Chọn "Default Gemini Project")
            $apiKey = "AIzaSyAiqpNX8Z6ACkcasAgMG_WhlA1k0-N3L4U"; 
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

            // 3. Chuẩn bị dữ liệu gửi đi (Đã tắt tính năng Search để chạy nhanh nhất)
            $data = [
                "contents" => [
                    ["role" => "user", "parts" => [["text" => "Bạn là trợ lý UniGuide. Hãy trả lời câu hỏi sau một cách ngắn gọn: " . $user_msg]]]
                ],
                "generationConfig" => ["temperature" => 0.5, "maxOutputTokens" => 800]
            ];

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            
            // QUAN TRỌNG: 2 dòng này giúp localhost không bị xoay mãi
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 15); 

            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                throw new Exception("Lỗi kết nối: " . curl_error($ch));
            }
            
            $result = json_decode($response, true);
            curl_close($ch);

            // Kiểm tra xem có dữ liệu trả về không
            if (isset($result['error'])) {
                throw new Exception("Google báo lỗi: " . $result['error']['message']);
            }

            $ai_reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? "AI không trả lời, hãy thử lại.";

            // 4. Lưu lịch sử vào CSDL
            if ($user_id > 0) {
                $save = $this->conn->prepare("INSERT INTO ai_chats (user_id, user_message, ai_response) VALUES (?, ?, ?)");
                $save->bind_param("iss", $user_id, $user_msg, $ai_reply);
                $save->execute();
            }

            echo json_encode(['status' => 'success', 'reply' => $ai_reply]);

        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }
}

    public function history() {
        $user_id = $_SESSION['user']['id'] ?? 0;
        if (!$user_id) { header("Location: index.php?page=login"); exit; }
        $stmt = $this->conn->prepare("SELECT * FROM ai_chats WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $chat_history = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        require_once 'views/ai/history.php';
    }
    
}