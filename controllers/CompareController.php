<?php
class CompareController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function index() {
        // Lấy danh sách ngành lớn duy nhất từ bảng tri thức
        $majors = [];
        $res = $this->conn->query("SELECT DISTINCT major_name FROM knowledge_base ORDER BY major_name ASC");
        if ($res) {
            while($row = $res->fetch_assoc()) $majors[] = $row;
        }
        require 'views/compare/index.php';
    }

    // API phục vụ AJAX lấy chuyên ngành hẹp
   // Đổi tên hàm này để khớp với file view
public function getSpecsByMajor() { 
    header('Content-Type: application/json');
    // JavaScript gửi major_name, nên ta dùng major_name
    $major_name = $_GET['major_name'] ?? ''; 
    
    $stmt = $this->conn->prepare("SELECT id, specialization FROM knowledge_base WHERE major_name = ?");
    $stmt->bind_param("s", $major_name);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode($data);
    exit;
}

    public function result() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Đổi major_a thành spec_a để khớp với name của select
        $spec1_id = (int)($_POST['spec_a'] ?? 0); 
        $spec2_id = (int)($_POST['spec_b'] ?? 0);

        if ($spec1_id > 0 && $spec2_id > 0) {
            $info1 = $this->conn->query("SELECT * FROM knowledge_base WHERE id = $spec1_id")->fetch_assoc();
            $info2 = $this->conn->query("SELECT * FROM knowledge_base WHERE id = $spec2_id")->fetch_assoc();

            $ai_analysis = $this->getAIComparison($info1, $info2);
            require 'views/compare/result.php';
        } else {
            // Lỗi này hiện ra nếu spec_a/spec_b bị rỗng
            echo "<script>alert('Vui lòng chọn đầy đủ chuyên ngành!'); window.history.back();</script>";
        }
    }
}

    private function getAIComparison($d1, $d2) {
        $apiKey = "AIzaSyAHNizToEMn41q4WFD1A-y1WkcxqYt_CBY"; // Sử dụng Key của bạn
       $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;
        
        $prompt = "Bạn là chuyên gia định hướng nghề nghiệp. Hãy so sánh 2 hướng đi:
        1. {$d1['major_name']} - Chuyên ngành: {$d1['specialization']}. Kỹ năng: {$d1['skills_required']}.
        2. {$d2['major_name']} - Chuyên ngành: {$d2['specialization']}. Kỹ năng: {$d2['skills_required']}.
        
        Yêu cầu: 
        - Phân tích sự khác biệt cốt lõi.
        - Dự báo xu hướng việc làm năm 2026.
        - Đưa ra lời khuyên sinh viên nào nên chọn hướng nào.
        Trả lời bằng Markdown, trình bày đẹp, có các icon.";

        $data = ["contents" => [["parts" => [["text" => $prompt]]]]];
        
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $res = json_decode($response, true);
        curl_close($ch);

        return $res['candidates'][0]['content']['parts'][0]['text'] ?? "Hệ thống AI đang bận phân tích, vui lòng thử lại sau.";
    }
}