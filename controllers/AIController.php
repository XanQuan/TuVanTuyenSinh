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
    while (ob_get_level()) ob_end_clean(); 
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $user_msg = $_POST['message'] ?? '';
            $user_id = $_SESSION['user']['id'] ?? 0;
            if (!$user_msg) throw new Exception("Tin nhắn trống");

            // 1. LẤY DỮ LIỆU THỰC TẾ TỪ DATABASE CỦA BẠN
            $search_term = "%$user_msg%";
            $local_data = "";
            
            // Truy vấn thông tin ngành, trường và điểm chuẩn từ CSDL local
            $sql = "SELECT m.name as major_name, u.name as uni_name, m.admission_score 
                    FROM majors m 
                    JOIN universities u ON m.university_id = u.id 
                    WHERE m.name LIKE ? OR u.name LIKE ? OR u.address LIKE ? LIMIT 10";
            
            $stmt_db = $this->conn->prepare($sql);
            $stmt_db->bind_param("sss", $search_term, $search_term, $search_term);
            $stmt_db->execute();
            $db_results = $stmt_db->get_result()->fetch_all(MYSQLI_ASSOC);
            
            if (!empty($db_results)) {
                $local_data = "DỮ LIỆU TỪ HỆ THỐNG UNIGUIDE:\n";
                foreach ($db_results as $row) {
                    $local_data .= "- Ngành {$row['major_name']} - {$row['uni_name']}: {$row['admission_score']} điểm\n";
                }
            }

            // 2. LẤY NGỮ CẢNH HỘI THOẠI
            $context_stmt = $this->conn->prepare("SELECT user_message, ai_response FROM ai_chats WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
            $context_stmt->bind_param("i", $user_id);
            $context_stmt->execute();
            $history_chats = $context_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $history_context = "";
            foreach (array_reverse($history_chats) as $chat) {
                $history_context .= "Người dùng: " . $chat['user_message'] . "\nAI: " . $chat['ai_response'] . "\n";
            }

            // 3. GỬI DỮ LIỆU CHO AI TỔNG HỢP (Tắt Google Search để chạy nhanh)
            $apiKey = "AIzaSyBl78vHFl1qDTKJjSeHsGewfYwMQ0nwJ1I"; 
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

            $prompt = "Bạn là Trợ lý Tuyển sinh UniGuide. Hãy dựa vào DỮ LIỆU HỆ THỐNG được cung cấp để tư vấn cho người dùng. "
                    . "Nếu dữ liệu không có thông tin yêu cầu, hãy trả lời dựa trên kiến thức của bạn.\n\n"
                    . "DỮ LIỆU HỆ THỐNG:\n$local_data\n\n"
                    . "LỊCH SỬ:\n$history_context\n"
                    . "CÂU HỎI: $user_msg";

            $data = [
                "contents" => [["role" => "user", "parts" => [["text" => $prompt]]]],
                "generationConfig" => ["temperature" => 0.4, "maxOutputTokens" => 1000]
            ];

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $response = curl_exec($ch);
            $result = json_decode($response, true);
            curl_close($ch);

            $ai_reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? "Xin lỗi, UniBot hiện không tìm thấy dữ liệu phù hợp trong hệ thống.";

            // 4. LƯU LỊCH SỬ
            if ($user_id > 0) {
                $save_stmt = $this->conn->prepare("INSERT INTO ai_chats (user_id, user_message, ai_response) VALUES (?, ?, ?)");
                $save_stmt->bind_param("iss", $user_id, $user_msg, $ai_reply);
                $save_stmt->execute();
            }

            echo json_encode(['status' => 'success', 'reply' => $ai_reply]);
        } catch (Exception $e) { echo json_encode(['status' => 'error', 'message' => $e->getMessage()]); }
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