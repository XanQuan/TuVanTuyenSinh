<?php
class HistoryController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {
        // Câu truy vấn JOIN để lấy tên từ bảng tri thức dựa trên ID trong lịch sử
        $sql = "SELECT h.created_at, h.spec_a_id, h.spec_b_id, 
                       k1.specialization as spec_a_name, 
                       k2.specialization as spec_b_name
                FROM history h
                JOIN knowledge_base k1 ON h.spec_a_id = k1.id
                JOIN knowledge_base k2 ON h.spec_b_id = k2.id
                ORDER BY h.created_at DESC";

        $res = $this->conn->query($sql);
        $history_list = [];
        
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $history_list[] = $row;
            }
        }

        require 'views/history/index.php';
    }
}