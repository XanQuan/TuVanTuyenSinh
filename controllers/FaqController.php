<?php
class FaqController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    
    public function index() {
        $sql = "SELECT * FROM faqs";
        $result = $this->conn->query($sql);
        $faqs = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) $faqs[] = $row;
        }
        require 'views/faq/index.php';
    }
}
?>