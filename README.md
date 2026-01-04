# HỆ THỐNG TƯ VẤN TUYỂN SINH - UNIGUIDE 🎓

## 1. Mô tả bài toán
Hệ thống hỗ trợ học sinh THPT lựa chọn chuyên ngành đại học phù hợp dựa trên 3 yếu tố cốt lõi:
1. **Năng lực học tập:** Dựa trên điểm thi và khối xét tuyển.
2. **Tính cách nghề nghiệp:** Dựa trên mô hình trắc nghiệm Holland (RIASEC).
3. **Dữ liệu thực tế:** Đối chiếu với điểm chuẩn các năm của các trường Đại học.

## 2. Các chức năng chính (Use Cases)
### 👤 Người dùng (Học sinh)
- **Tra cứu điểm chuẩn:** Xem khả năng đậu dựa trên điểm thi.
- **Trắc nghiệm hướng nghiệp:** Làm bài test 30 câu hỏi để tìm ra nhóm tính cách.
- **Xem chi tiết ngành:** Tìm hiểu thông tin đào tạo, cơ hội việc làm.
- **Quản lý lịch sử:** Xem lại các lần tư vấn trước đó.

### 👨‍💼 Quản trị viên (Admin)
- **Quản lý dữ liệu:** CRUD (Thêm/Sửa/Xóa) ngành học, trường học, điểm chuẩn.
- **Thống kê:** Xem báo cáo số lượng người truy cập và ngành hot.

## 3. Công nghệ sử dụng
- **Mô hình:** MVC (Model - View - Controller) tự xây dựng.
- **Backend:** PHP 8.0, MySQL.
- **Frontend:** HTML5, CSS3, Bootstrap 5, Chart.js (Vẽ biểu đồ).
- **Security:** Password Hashing, Session Management, Input Validation.

## 4. Cài đặt
1. Clone dự án vào thư mục `htdocs`.
2. Import file `tuvan_db.sql` vào MySQL (Database name: `tuvan_db`).
3. Cấu hình kết nối trong `config/db.php`.
4. Truy cập: `http://localhost/TuVanTuyenSinh`

## 5. Hướng phát triển
- Tích hợp AI (Machine Learning) để dự đoán điểm chuẩn năm tới.
- Xây dựng Chatbot tư vấn tự động 24/7.
- Phát triển ứng dụng Mobile (React Native/Flutter).