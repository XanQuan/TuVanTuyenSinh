<?php
// models/AdviceModel.php

class AdviceModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Hàm lấy danh sách trường phù hợp
    public function getAdvice($score, $groupCode) {
        $suggestions = [];
        
        // SQL: Lấy Tên trường, Tên ngành, Điểm chuẩn
        // Điều kiện: Cùng nhóm ngành + Điểm chuẩn <= Điểm HS nhập
        $sql = "SELECT u.name as uni_name, u.code as uni_code, m.name as major_name, s.score 
                FROM entry_scores s
                JOIN universities u ON s.uni_id = u.id
                JOIN majors m ON s.major_id = m.id
                WHERE m.group_code = '$groupCode' 
                AND s.score <= $score
                ORDER BY s.score DESC"; // Sắp xếp điểm chuẩn giảm dần (ưu tiên trường điểm cao nhất mà mình đậu)

        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $suggestions[] = $row;
            }
        }
        return $suggestions;
    }
}
?>