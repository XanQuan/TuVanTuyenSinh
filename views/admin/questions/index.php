<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Câu hỏi Holland - UniGuide Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- CSS ĐỒNG BỘ GIAO DIỆN ADMIN DASHBOARD --- */
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: linear-gradient(180deg, #a71d2a 0%, #80131e 100%); color: #fff; transition: all 0.3s; z-index: 1000; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h3 { font-size: 22px; font-weight: 700; margin: 0; letter-spacing: 1px; }
        .sidebar-menu { padding: 20px 0; }
        .sidebar-menu ul { list-style: none; padding: 0; }
        .sidebar-menu ul li a { padding: 15px 25px; display: block; color: rgba(255,255,255,0.8); text-decoration: none; font-weight: 500; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-menu ul li a:hover, .sidebar-menu ul li a.active { color: #fff; background-color: rgba(255,255,255,0.1); border-left: 4px solid #ffcc00; }
        .sidebar-menu ul li a i { width: 25px; text-align: center; margin-right: 10px; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        .top-navbar { background-color: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }

        /* --- CSS CHO PHẦN NỘI DUNG QUẢN LÝ --- */
        .card-custom { border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .badge-holland { padding: 8px 15px; border-radius: 50px; font-weight: 700; font-size: 0.8rem; }
        .modal-content { border-radius: 15px; border: none; }
        .modal-header { background: linear-gradient(135deg, #a71d2a 0%, #80131e 100%); color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; }
        .btn-danger { background-color: #a71d2a; border: none; border-radius: 50px; }
        .btn-danger:hover { background-color: #80131e; transform: translateY(-2px); }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-graduation-cap"></i> UniGuide</h3>
            <small>Admin Control Panel</small>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="index.php?page=admin"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển</a></li>
                <li><a href="index.php?page=admin&action=universities"><i class="fas fa-university"></i> Quản lý Trường ĐH</a></li>
                <li><a href="index.php?page=admin&action=majors"><i class="fas fa-book-open"></i> Quản lý Ngành Học</a></li>
                <li><a href="index.php?page=admin&action=scores"><i class="fas fa-chart-line"></i> Quản lý Điểm Chuẩn</a></li>
                <li><a href="index.php?page=admin&action=questions" class="active"><i class="fas fa-question-circle"></i> Quản lý Câu hỏi Test</a></li>
                <li><a href="index.php?page=admin&action=chat_logs"><i class="fas fa-history"></i> Nhật ký Tư vấn AI</a></li>
                <li><a href="index.php?page=admin&action=users"><i class="fas fa-users-cog"></i> Quản lý Người dùng</a></li>
                <li style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h4 class="m-0 text-dark">Quản lý Ngân hàng Câu hỏi Holland</h4>
            <div class="user-info">
                <a href="index.php" class="btn btn-outline-dark btn-sm rounded-pill px-3 me-2"><i class="fas fa-home"></i> Trang chủ</a>
                <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="admin" class="rounded-circle" width="32">
                <strong>Admin</strong>
            </div>
        </div>

        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0"><i class="fas fa-list text-danger me-2"></i> DANH SÁCH CÂU HỎI</h4>
                <button class="btn btn-danger px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                    <i class="fas fa-plus-circle me-2"></i> Thêm câu hỏi mới
                </button>
            </div>

            <div class="card card-custom">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4" width="180">Nhóm RIASEC</th>
                                    <th>Nội dung câu hỏi hiển thị</th>
                                    <th class="text-end pe-4" width="100">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($questions)): ?>
                                    <?php foreach ($questions as $q): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge badge-holland bg-danger">NHÓM <?= $q['group_code'] ?></span>
                                        </td>
                                        <td class="fw-medium text-dark"><?= htmlspecialchars($q['content']) ?></td>
                                        <td class="text-end pe-4">
                                            <a href="index.php?page=admin&action=delete_question&id=<?= $q['id'] ?>" 
                                               class="btn btn-sm btn-outline-danger border-0" 
                                               onclick="return confirm('Bạn có thực sự muốn xóa câu hỏi này không?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center py-4 text-muted">Chưa có câu hỏi nào trong hệ thống.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="index.php?page=admin&action=save_question" method="POST">
                <div class="modal-content shadow-lg">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-uppercase"><i class="fas fa-edit me-2"></i> Thêm câu hỏi mới</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">NỘI DUNG CÂU HỎI</label>
                            <textarea name="question_text" class="form-control" rows="4" placeholder="Nhập câu hỏi trắc nghiệm..." required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold small text-muted">PHÂN NHÓM HOLLAND</label>
                            <select name="holland_group" class="form-select" required>
                                <option value="" disabled selected>-- Chọn nhóm tính cách --</option>
                                <option value="R">Realistic (R) - Thực tế</option>
                                <option value="I">Investigative (I) - Nghiên cứu</option>
                                <option value="A">Artistic (A) - Nghệ thuật</option>
                                <option value="S">Social (S) - Xã hội</option>
                                <option value="E">Enterprising (E) - Quản lý</option>
                                <option value="C">Conventional (C) - Nghiệp vụ</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-5 fw-bold">LƯU DỮ LIỆU</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>