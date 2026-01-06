<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Khóa Học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar { height: 100vh; width: 260px; position: fixed; background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); color: #fff; z-index: 1000; }
        .main-content { margin-left: 260px; padding: 30px; }
        .form-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header-edit { background: #0d6efd; color: #fff; border-radius: 20px 20px 0 0; padding: 25px; }
    </style>
</head>
<body>
    <div class="sidebar">...</div> 

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card form-card">
                    <div class="header-edit d-flex align-items-center">
                        <h4 class="m-0 fw-bold"><i class="fas fa-edit me-3"></i> Cập Nhật Thông Tin Khóa Học</h4>
                    </div>
                    <div class="card-body p-5">
                        <form action="index.php?page=admin&action=edit_course&id=<?= $course['id'] ?>" method="POST" enctype="multipart/form-data">
                            <div class="row g-4 mb-4">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold">TÊN KHÓA HỌC <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-lg rounded-pill px-4" value="<?= htmlspecialchars($course['name']) ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">GIẢNG VIÊN <span class="text-danger">*</span></label>
                                    <input type="text" name="teacher" class="form-control form-control-lg rounded-pill px-4" value="<?= htmlspecialchars($course['teacher']) ?>" required>
                                </div>
                            </div>

                            <div class="row g-4 mb-4 align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-success">HỌC PHÍ (VNĐ)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light rounded-start-pill"><i class="fas fa-money-bill-wave"></i></span>
                                        <input type="text" name="tuition" class="form-control form-control-lg rounded-end-pill" value="<?= $course['tuition'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-warning">ĐÁNH GIÁ (MAX 5.0)</label>
                                    <input type="number" step="0.1" min="1" max="5" name="rating" class="form-control form-control-lg rounded-pill px-4" value="<?= $course['rating'] ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">ẢNH ĐANG DÙNG</label>
                                    <div class="d-flex align-items-center bg-light p-2 rounded-4">
                                        <img src="uploads/courses/<?= $course['image'] ?>" width="100" class="rounded shadow-sm" onerror="this.src='https://placehold.co/100x60?text=No+Img'">
                                        <input type="file" name="image" class="form-control form-control-sm ms-2">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label fw-bold">MÔ TẢ CHI TIẾT NỘI DUNG</label>
                                <textarea name="description" class="form-control border-0 bg-light p-4" rows="6" style="border-radius: 20px;"><?= htmlspecialchars($course['description']) ?></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg">LƯU THAY ĐỔI NGAY</button>
                                <a href="index.php?page=admin&action=courses" class="btn btn-link text-muted mt-2 d-block">Hủy bỏ và quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>