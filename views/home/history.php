<?php 
// Kiểm tra quyền Admin
if (session_status() === PHP_SESSION_NONE) session_start();
$userRole = isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : (isset($_SESSION['role']) ? $_SESSION['role'] : 'user');
if ($userRole == 'admin') {
    header("Location: index.php?page=admin");
    exit();
}

require_once 'views/layouts/header.php'; 
?>

<section class="section upcoming-meetings" id="meetings" style="padding-top: 120px; min-height: 600px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="section-heading text-center">
                    <h2>Lịch Sử Tra Cứu Của Bạn</h2>
                </div>

                <div class="card shadow border-0" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <table class="table table-hover align-middle">
                            <thead class="table-danger text-center text-white">
                                <tr>
                                    <th>Thời gian</th>
                                    <th>Điểm đã nhập</th>
                                    <th>Nhóm ngành</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($history_list) > 0): ?>
                                    <?php foreach ($history_list as $row): ?>
                                    <tr class="text-center">
                                        <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                        <td><span class="badge bg-danger fs-6"><?= $row['score'] ?></span></td>
                                        <td><span class="badge bg-info text-dark"><?= $row['group_code'] ?></span></td>
                                        <td>
                                            <form method="POST" action="index.php?page=advice&action=result#consulting" style="display:inline;">
                                                <input type="hidden" name="score" value="<?= $row['score'] ?>">
                                                <input type="hidden" name="group" value="<?= $row['group_code'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa fa-search"></i> Tra lại
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            Bạn chưa thực hiện tra cứu nào. <br>
                                            <a href="index.php" class="fw-bold text-danger">Tra cứu ngay!</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/layouts/footer.php'; ?>