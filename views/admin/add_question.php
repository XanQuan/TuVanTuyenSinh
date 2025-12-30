<div class="admin-container">
    <h2>Thêm câu hỏi Holland Code mới</h2>
    <form action="index.php?page=admin&action=save_question" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nội dung câu hỏi:</label>
            <textarea name="question_text" class="form-control" placeholder="Ví dụ: Thích lắp ráp máy móc..." required></textarea>
        </div>
        
        <div class="form-group">
            <label>Thuộc nhóm Holland:</label>
            <select name="holland_group" class="form-control">
                <option value="R">Realistic (Kỹ thuật)</option>
                <option value="I">Investigative (Nghiên cứu)</option>
                <option value="A">Artistic (Nghệ thuật)</option>
                <option value="S">Social (Xã hội)</option>
                <option value="E">Enterprising (Kinh doanh)</option>
                <option value="C">Conventional (Nghiệp vụ)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Hình ảnh minh họa (nếu có):</label>
            <input type="file" name="question_image" accept="image/*">
        </div>

        <button type="submit" class="btn-submit">Lưu câu hỏi</button>
    </form>
</div>