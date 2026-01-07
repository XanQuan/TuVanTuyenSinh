<?php require_once 'views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-blue: #0984e3;
        --primary-red: #d63031;
        --bg-color: #f4f7f6;
        --card-bg: #ffffff;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--bg-color);
    }

    .compare-page-wrapper {
        padding-top: 140px; 
        padding-bottom: 100px;
        min-height: 100vh;
    }

    /* HEADER SECTION */
    .compare-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .compare-header h2 {
        font-weight: 800;
        font-size: 2.8rem;
        color: #2d3436;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    .compare-header p {
        color: #636e72;
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
    }

    /* CARD STYLES */
    .compare-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 40px 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    .compare-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .card-a { border-top: 8px solid var(--primary-blue); }
    .card-b { border-top: 8px solid var(--primary-red); }

    .choice-badge {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        margin-bottom: 20px;
    }
    .badge-a { background: #e3f2fd; color: var(--primary-blue); }
    .badge-b { background: #ffebee; color: var(--primary-red); }

    .card-title {
        font-weight: 800;
        font-size: 1.8rem;
        margin-bottom: 30px;
        color: #2d3436;
    }

    /* FORM STYLES */
    .form-group { margin-bottom: 25px; position: relative; }
    .form-label {
        font-weight: 700;
        font-size: 0.9rem;
        color: #636e72;
        margin-bottom: 10px;
        display: block;
    }

    .custom-select-box {
        width: 100%;
        padding: 15px 20px;
        border-radius: 12px;
        border: 2px solid #dfe6e9;
        font-weight: 600;
        color: #2d3436;
        appearance: none;
        background-color: #fff;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23636e72' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 15px;
        transition: border 0.3s;
    }

    .custom-select-box:focus {
        outline: none;
        border-color: var(--primary-blue);
    }

    .custom-select-box:disabled {
        background-color: #f1f2f6;
        cursor: not-allowed;
    }

    /* VS CIRCLE */
    .vs-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
    .vs-circle {
        width: 70px;
        height: 70px;
        background: #2d3436;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.5rem;
        box-shadow: 0 0 0 10px var(--bg-color);
    }

    /* BUTTON */
    .btn-compare-start {
        background: #2d3436;
        color: white;
        padding: 18px 50px;
        border-radius: 50px;
        font-weight: 800;
        border: none;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transition: all 0.3s;
        text-transform: uppercase;
        margin-top: 30px;
    }
    .btn-compare-start:hover {
        background: #000;
        transform: scale(1.05);
    }

    /* LOADER */
    .loader {
        display: none;
        position: absolute;
        right: 45px;
        top: 45px;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid var(--primary-blue);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

<div class="compare-page-wrapper">
    <div class="container">
        
        <div class="compare-header">
            <h2>Phân Tích Chuyên Ngành</h2>
            <p>So sánh lộ trình học tập, kỹ năng và triển vọng nghề nghiệp từ kho dữ liệu 1000 chuyên ngành để có lựa chọn đúng đắn nhất.</p>
        </div>

        <form action="index.php?page=compare&action=result" method="POST" id="compareForm">
            <div class="row g-4 align-items-stretch">
                
                <div class="col-lg-5">
                    <div class="compare-card card-a">
                        <span class="choice-badge badge-a">Hướng đi 1</span>
                        <h3 class="card-title">Chuyên ngành A</h3>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-layer-group me-2"></i>Ngành học tổng quan</label>
                            <select name="major_a" id="major_a" class="custom-select-box" required onchange="loadSpecializations('major_a', 'spec_a', 'loader_a')">
                                <option value="" disabled selected>-- Chọn ngành học chính --</option>
                                <?php 
                                // Kết nối DB và lấy danh sách ngành lớn từ bảng knowledge_base
                                $stmt = $this->conn->query("SELECT DISTINCT major_name FROM knowledge_base ORDER BY major_name ASC");
                                while($row = $stmt->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($row['major_name']) ?>"><?= htmlspecialchars($row['major_name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-microscope me-2"></i>Chuyên ngành hẹp</label>
                            <select name="spec_a" id="spec_a" class="custom-select-box" disabled required>
                                <option value="" disabled selected>-- Chọn ngành lớn trước --</option>
                            </select>
                            <div id="loader_a" class="loader"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 d-none d-lg-block">
                    <div class="vs-container">
                        <div class="vs-circle">VS</div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="compare-card card-b">
                        <span class="choice-badge badge-b">Hướng đi 2</span>
                        <h3 class="card-title">Chuyên ngành B</h3>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-layer-group me-2"></i>Ngành học tổng quan</label>
                            <select name="major_b" id="major_b" class="custom-select-box" required onchange="loadSpecializations('major_b', 'spec_b', 'loader_b')">
                                <option value="" disabled selected>-- Chọn ngành học chính --</option>
                                <?php 
                                // Lặp lại lấy danh sách ngành lớn
                                $stmt = $this->conn->query("SELECT DISTINCT major_name FROM knowledge_base ORDER BY major_name ASC");
                                while($row = $stmt->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($row['major_name']) ?>"><?= htmlspecialchars($row['major_name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-microscope me-2"></i>Chuyên ngành hẹp</label>
                            <select name="spec_b" id="spec_b" class="custom-select-box" disabled required>
                                <option value="" disabled selected>-- Chọn ngành lớn trước --</option>
                            </select>
                            <div id="loader_b" class="loader"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn-compare-start">
                    <i class="fas fa-bolt me-2"></i> Bắt đầu phân tích đối đầu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    /**
     * AJAX tải chuyên ngành hẹp từ bảng knowledge_base
     */
   function loadSpecializations(majorSelectId, specSelectId, loaderId) {
    const majorName = document.getElementById(majorSelectId).value;
    const specSelect = document.getElementById(specSelectId);
    const loader = document.getElementById(loaderId);

    if (!majorName) return;
    specSelect.disabled = true;
    if(loader) loader.style.display = 'block';

    // SỬA TẠI ĐÂY: Gửi tham số major_name và gọi đúng action getSpecsByMajor
    fetch(`index.php?page=compare&action=getSpecsByMajor&major_name=${encodeURIComponent(majorName)}`)
        .then(response => response.json())
        .then(data => {
            if(loader) loader.style.display = 'none';
            specSelect.innerHTML = '<option value="" disabled selected>-- Chọn chuyên ngành hẹp --</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id; // ID để gửi sang trang Result
                option.textContent = item.specialization;
                specSelect.appendChild(option);
            });
            specSelect.disabled = false;
        });
}
</script>

<?php require_once 'views/layouts/footer.php'; ?>