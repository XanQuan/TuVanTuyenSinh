<?php
class EventController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    
    public function index() {
        // Lấy sự kiện mới nhất xếp trước
        $sql = "SELECT * FROM events ORDER BY event_date ASC";
        $result = $this->conn->query($sql);
        $events = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) $events[] = $row;
        }
        require 'views/events/index.php';
    }
    public function detail() {
    // 1. Lấy ID từ URL
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // 2. Truy vấn lấy thông tin chi tiết sự kiện
    $stmt = $this->conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();

    // 3. Nếu không tìm thấy sự kiện, quay về trang danh sách
    if (!$event) {
        header("Location: index.php?page=events");
        exit;
    }

    // 4. Gọi file giao diện chi tiết (Bạn cần tạo file này)
    require 'views/events/detail.php';
}
public function register_participation() {
    // Xóa sạch bộ đệm để đảm bảo không dính mã HTML từ các file khác
    if (ob_get_length()) ob_clean(); 
    header('Content-Type: application/json');

    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Yêu cầu không hợp lệ.");
        }

        $event_id = intval($_POST['event_id']);
        $type     = strtolower($_POST['type']); 
        $email    = $_POST['email'];
        $fullname = $_POST['fullname'];

        // Lấy thông tin từ database để soạn nội dung mail
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $ev = $stmt->get_result()->fetch_assoc();

        if (!$ev) throw new Exception("Sự kiện không tồn tại.");

        // LOGIC GỬI MAIL THỰC TẾ (Sử dụng link từ database)
        $subject = "[UniGuide] XÁC NHẬN ĐĂNG KÝ: " . $ev['title'];
        $info = ($type === 'online') ? "Link tham gia: " . $ev['location'] : "Địa điểm: " . $ev['location'];
        $content = "Chào $fullname, bạn đã đăng ký thành công.\n$info\nThời gian: " . date('H:i d/m/Y', strtotime($ev['event_date']));

        // Chú ý: Hàm mail() này chỉ chạy trên server đã cấu hình SMTP
        $headers = "From: uniguide.support@gmail.com\r\nContent-Type: text/plain; charset=UTF-8";
        @mail($email, $subject, $content, $headers); 

        echo json_encode([
            'status' => 'success',
            'message' => 'Đã gửi thông tin ' . ($type === 'online' ? 'Link tham gia' : 'địa chỉ') . ' tới Gmail của bạn!'
        ]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit; // Đảm bảo kết thúc luồng xử lý AJAX
}
}
?>