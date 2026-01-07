<?php
class AIController {
    private $conn;

    public function __construct($db) { 
        $this->conn = $db; 
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
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
        if (session_status() === PHP_SESSION_NONE) session_start();
        while (ob_get_level()) ob_end_clean(); 
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user_msg = $_POST['message'] ?? '';
                $user_id = $_SESSION['user']['id'] ?? 0;
                $session_id = $_POST['session_id'] ?? null;

                if (!$user_msg) throw new Exception("Tin nhắn trống");

                $contents = [];
                
                // 1. System Instruction
                $contents[] = ["role" => "user", "parts" => [["text" => 
                    "Bạn là chuyên gia UniGuide AI. Nhiệm vụ của bạn là tư vấn CHUYÊN NGÀNH HẸP và ĐỊNH HƯỚNG NGHỀ NGHIỆP cho SINH VIÊN ĐẠI HỌC. Trả lời chi tiết bằng Markdown, thân thiện và chuyên nghiệp."
                ]]];
                $contents[] = ["role" => "model", "parts" => [["text" => "Tôi là UniGuide AI, chuyên gia tư vấn lộ trình học tập và nghề nghiệp cho sinh viên. Tôi đã sẵn sàng!"]]];

                // 2. Lấy 6 tin nhắn gần nhất
                if ($session_id) {
                    $stmtH = $this->conn->prepare("SELECT user_message, ai_response FROM chat_messages WHERE session_id = ? ORDER BY created_at ASC LIMIT 6");
                    $stmtH->bind_param("i", $session_id);
                    $stmtH->execute();
                    $old_chats = $stmtH->get_result()->fetch_all(MYSQLI_ASSOC);
                    foreach ($old_chats as $chat) {
                        $contents[] = ["role" => "user", "parts" => [["text" => $chat['user_message']]]];
                        $contents[] = ["role" => "model", "parts" => [["text" => $chat['ai_response']]]];
                    }
                }

                $contents[] = ["role" => "user", "parts" => [["text" => $user_msg]]];

                // --- GỌI API GEMINI 1.5 FLASH (ĐÃ SỬA URL CHUẨN V1) ---
                $apiKey = "AIzaSyAHNizToEMn41q4WFD1A-y1WkcxqYt_CBY"; 
                // Sử dụng v1 và tên model cơ bản để tránh lỗi "Not Found"
                // SỬA LẠI URL CHUẨN (Thêm -001 vào sau tên model)
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

                $data = [
                    "contents" => $contents,
                    "generationConfig" => [
                        "temperature" => 0.7, 
                        "maxOutputTokens" => 1500 
                    ]
                ];

                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                curl_setopt($ch, CURLOPT_TIMEOUT, 20); 

                $response = curl_exec($ch);
                $result = json_decode($response, true);
                curl_close($ch);

                if (isset($result['error'])) {
                    $error_msg = $result['error']['message'];
                    throw new Exception("Lỗi AI: " . $error_msg);
                }

                $ai_reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? "AI không phản hồi.";

                // --- LƯU DATABASE ---
                if ($user_id > 0) {
                    if (empty($session_id)) {
                        $title = mb_substr($user_msg, 0, 40) . "..."; 
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

    public function history() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user_id = $_SESSION['user']['id'] ?? 0;
        if (!$user_id) { header("Location: index.php?page=login"); exit; }
        $stmt = $this->conn->prepare("SELECT * FROM chat_sessions WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $all_sessions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        require_once 'views/ai/history.php';
    }
}