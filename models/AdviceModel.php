<?php
// models/AdviceModel.php

class AdviceModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Hàm lấy danh sách trường phù hợp
    public function getAdvice($score, $groupCode, $userId = null) {
        $suggestions = [];
        
        // 1. Lưu lịch sử tra cứu (Nếu có user_id)
        if ($userId) {
            $logSql = "INSERT INTO search_history (user_id, score, group_code) VALUES (?, ?, ?)";
            $stmtLog = $this->conn->prepare($logSql);
            if ($stmtLog) {
                $stmtLog->bind_param("ids", $userId, $score, $groupCode);
                $stmtLog->execute();
            }
        }

        // 2. CÂU LỆNH SQL LẤY KẾT QUẢ (CHỈ LẤY NĂM 2025)
        // Giải thích:
        // - WHERE s.year = 2025: Chỉ lấy điểm năm mới nhất
        // - s.score <= ?: Điểm chuẩn thấp hơn hoặc bằng điểm thi của bạn
        // - s.score >= (? - 3): Không lấy trường điểm quá thấp (chỉ lấy thấp hơn tối đa 3 điểm cho phù hợp năng lực)
        
        $sql = "SELECT u.name as uni_name, u.code as uni_code, m.name as major_name, s.score, s.year 
                FROM entry_scores s
                JOIN universities u ON s.uni_id = u.id
                JOIN majors m ON s.major_id = m.id
                WHERE m.group_code = ? 
                AND s.year = 2025         
                AND s.score <= ?
                AND s.score >= (? - 3) 
                ORDER BY s.score DESC"; 

        // Sử dụng Prepared Statement để chống hack SQL Injection
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            // "sdd": s là string (groupCode), d là double (score), d là double (score - 3)
            $min_score = $score - 3;
            $stmt->bind_param("sdd", $groupCode, $score, $min_score);
            
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                $suggestions[] = $row;
            }
        }
        return $suggestions;
    }
}
?>