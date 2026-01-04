<?php
class ResourceController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function index() {
        // Lấy danh sách từ bảng resources
        $sql = "SELECT * FROM resources ORDER BY id DESC";
        $result = $this->conn->query($sql);
        
        $resources = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resources[] = $row;
            }
        }
        
        // Truyền biến $resources sang file view bạn vừa gửi
        require_once 'views/resources/index.php';
    }
    public function view_pdf() {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $sql = "SELECT link FROM resources WHERE id = $id";
    $res = $this->conn->query($sql)->fetch_assoc();

    if ($res && file_exists($res['link'])) {
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($res['link']) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile($res['link']);
    } else {
        echo "Tài liệu không tồn tại.";
    }
}
}