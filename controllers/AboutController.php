<?php
class AboutController {
    public function index() {
        // Trang tĩnh, không cần gọi database
        require 'views/about/index.php';
    }
}
?>