<?php
class CompareModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách tất cả các trường (Sắp xếp theo tên)
    public function getAllUniversities() {
        $sql = "SELECT id, name FROM universities ORDER BY name ASC";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Lấy danh sách ngành CỦA MỘT TRƯỜNG CỤ THỂ
    // Logic: Join bảng majors với entry_scores để biết trường đó có tuyển sinh ngành nào
    public function getMajorsByUniId($uni_id) {
        $data = [];
        $sql = "SELECT DISTINCT m.id, m.name 
                FROM majors m 
                JOIN entry_scores s ON m.id = s.major_id 
                WHERE s.uni_id = ? 
                ORDER BY m.name ASC";
        
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $uni_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
?>