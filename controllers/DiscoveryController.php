<?php
class DiscoveryController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {
        // Lấy danh sách ngành lớn để làm bộ lọc
        $majors_res = $this->conn->query("SELECT DISTINCT major_name FROM knowledge_base ORDER BY major_name ASC");
        $majors = $majors_res->fetch_all(MYSQLI_ASSOC);

        // Xử lý tìm kiếm
        $search = $_GET['q'] ?? '';
        $filter_major = $_GET['major'] ?? '';

        $sql = "SELECT * FROM knowledge_base WHERE 1=1";
        if ($search) {
            $sql .= " AND (specialization LIKE '%$search%' OR subject_list LIKE '%$search%')";
        }
        if ($filter_major) {
            $sql .= " AND major_name = '$filter_major'";
        }
        $sql .= " ORDER BY id DESC";

        $results = $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);

        require 'views/discovery/index.php';
    }
}