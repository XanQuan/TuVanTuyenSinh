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
}
?>