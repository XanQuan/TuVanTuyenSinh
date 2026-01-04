<?php
class MentorController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    
    public function index() {
        $sql = "SELECT * FROM mentors";
        $result = $this->conn->query($sql);
        $mentors = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) $mentors[] = $row;
        }
        require 'views/mentors/index.php';
    }
   public function detail() {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Lấy ID từ URL
    $stmt = $this->conn->prepare("SELECT * FROM mentors WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $mentor = $stmt->get_result()->fetch_assoc();

    if (!$mentor) {
        header("Location: index.php?page=mentors");
        exit;
    }
    require 'views/mentors/detail.php';
}
public function register_participation() {
    // Làm sạch buffer để trả về JSON chuẩn
    if (ob_get_length()) ob_clean(); 
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $mentor_id = intval($_POST['mentor_id']);
            $fullname  = $_POST['fullname'];
            $email     = $_POST['email'];
            $note      = $_POST['note'] ?? 'Cần tư vấn định hướng';

            // Lấy thông tin chuyên gia từ Database
            $stmt = $this->conn->prepare("SELECT * FROM mentors WHERE id = ?");
            $stmt->bind_param("i", $mentor_id);
            $stmt->execute();
            $mentor = $stmt->get_result()->fetch_assoc();

            if (!$mentor) {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy chuyên gia.']);
                exit;
            }

            // Logic gửi Mail (Bạn có thể dùng PHPMailer đã tích hợp trước đó)
            $subject = "[UniGuide] YÊU CẦU ĐẶT LỊCH TƯ VẤN: " . $mentor['full_name'];
            $content = "Chào {$mentor['full_name']},\n\nBạn có một yêu cầu tư vấn mới từ sinh viên:\n";
            $content .= "- Họ tên: $fullname\n- Email: $email\n- Nội dung: $note";

            // Tạm thời dùng hàm mail mặc định hoặc trả về thành công để test giao diện
            // @mail($email, $subject, $content); 

            echo json_encode([
                'status' => 'success',
                'message' => 'Yêu cầu đặt lịch tư vấn đã được gửi thành công!'
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
        exit;
    }
}
}
?>