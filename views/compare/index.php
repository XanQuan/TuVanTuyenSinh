<?php require_once 'views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-blue: #0984e3;
        --primary-red: #d63031;
        --bg-color: #dfe6e9;
        --card-bg: #ffffff;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--bg-color);
        overflow-x: hidden; /* Tránh thanh cuộn ngang */
    }

    /* --- SỬA LỖI GIAO DIỆN TẠI ĐÂY --- */
    .compare-page-wrapper {
        /* Đẩy nội dung xuống 160px để không bị Header che mất */
        padding-top: 160px; 
        padding-bottom: 100px;
        /* Đảm bảo chiều cao tối thiểu bằng màn hình để luôn có nền đẹp */
        min-height: 100vh; 
        background-color: var(--bg-color);
    }

    /* HEADER SECTION */
    .compare-header {
        text-align: center;
        margin-bottom: 50px; /* Tăng khoảng cách với các ô chọn */
    }
    .compare-header h2 {
        font-weight: 800;
        font-size: 3rem; /* Chữ to hơn cho ấn tượng */
        color: #2d3436;
        text-transform: uppercase;
        letter-spacing: -1px;
        margin-bottom: 15px;
        text-shadow: 2px 2px 0px rgba(0,0,0,0.1);
    }
    .compare-header p {
        color: #636e72;
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* CARD STYLES */
    .compare-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 40px 30px;
        /* Đổ bóng mềm mại hơn */
        box-shadow: 0 15px 35px rgba(0,0,0,0.08); 
        border: 1px solid rgba(255,255,255,1);
        position: relative;
        height: 100%;
        transition: transform 0.3s ease;
    }
    
    /* Hiệu ứng nhấc lên khi hover */
    .compare-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.12);
    }

    /* Màu viền trên */
    .card-a { border-top: 8px solid var(--primary-blue); }
    .card-b { border-top: 8px solid var(--primary-red); }

    .choice-badge {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .badge-a { background: #e3f2fd; color: var(--primary-blue); }
    .badge-b { background: #ffebee; color: var(--primary-red); }

    .card-title {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 35px;
        color: #2d3436;
    }

    /* FORM ELEMENTS */
    .form-group { margin-bottom: 30px; }
    
    .form-label {
        font-weight: 700;
        font-size: 0.95rem;
        color: #636e72;
        text-transform: uppercase;
        margin-bottom: 12px;
        display: block;
        letter-spacing: 0.5px;
    }

    .custom-select-box {
        width: 100%;
        padding: 18px 20px;
        border-radius: 12px;
        border: 2px solid #dfe6e9;
        background-color: #fdfdfd;
        font-size: 1rem;
        font-weight: 600;
        color: #2d3436;
        transition: all 0.3s;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23636e72' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 20px center;
        background-size: 18px;
    }

    .custom-select-box:focus {
        background-color: #fff;
        outline: none;
        border-color: #0984e3;
        box-shadow: 0 0 0 5px rgba(9, 132, 227, 0.1);
    }
    
    .card-a .custom-select-box:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 5px rgba(9, 132, 227, 0.1); }
    .card-b .custom-select-box:focus { border-color: var(--primary-red); box-shadow: 0 0 0 5px rgba(214, 48, 49, 0.1); }

    .custom-select-box:disabled {
        background-color: #f1f2f6;
        color: #b2bec3;
        cursor: not-allowed;
        border-color: #f1f2f6;
    }

    /* VS CIRCLE */
    .vs-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        position: relative;
        z-index: 5;
    }
    .vs-circle {
        width: 80px;
        height: 80px;
        background: #2d3436;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 2rem;
        font-style: italic;
        box-shadow: 0 0 0 15px var(--bg-color); /* Tạo khoảng cách giả với nền */
    }

    /* BUTTON */
    .btn-compare-start {
        background: #2d3436;
        color: white;
        padding: 20px 60px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 1.1rem;
        border: none;
        box-shadow: 0 15px 30px rgba(45, 52, 54, 0.3);
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 20px;
    }
    .btn-compare-start:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(45, 52, 54, 0.4);
        background: #000;
    }

    /* LOADING ANIMATION */
    .loader {
        border: 3px solid #f3f3f3;
        border-radius: 50%;
        border-top: 3px solid #3498db;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        position: absolute;
        right: 50px;
        top: 45px;
        display: none;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

</style>

<div class="compare-page-wrapper">
    <div class="container">
        
        <div class="compare-header">
            <h2>Phân Tích Đối Đầu</h2>
            <p>Chọn trường và ngành để hệ thống tự động đồng bộ dữ liệu so sánh chi tiết nhất.</p>
        </div>

        <form action="index.php?page=compare&action=result" method="POST" id="compareForm">
            <div class="row g-4 align-items-stretch">
                
                <div class="col-lg-5">
                    <div class="compare-card card-a">
                        <span class="choice-badge badge-a">Lựa chọn 1</span>
                        <h3 class="card-title">Đối Tượng A</h3>

                        <div class="form-group position-relative">
                            <label class="form-label"><i class="fas fa-university me-2"></i>Trường Đại học</label>
                            <select name="uni_a" id="uni_a" class="custom-select-box" required onchange="loadMajors('uni_a', 'major_a', 'loader_a')">
                                <option value="" disabled selected>-- Chọn trường mong muốn --</option>
                                <?php foreach ($universities as $uni): ?>
                                    <option value="<?= $uni['id'] ?>"><?= htmlspecialchars($uni['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group position-relative">
                            <label class="form-label"><i class="fas fa-graduation-cap me-2"></i>Ngành học đào tạo</label>
                            <select name="major_a" id="major_a" class="custom-select-box" disabled required>
                                <option value="" disabled selected>-- Vui lòng chọn trường trước --</option>
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
                        <span class="choice-badge badge-b">Lựa chọn 2</span>
                        <h3 class="card-title">Đối Tượng B</h3>

                        <div class="form-group position-relative">
                            <label class="form-label"><i class="fas fa-university me-2"></i>Trường Đại học</label>
                            <select name="uni_b" id="uni_b" class="custom-select-box" required onchange="loadMajors('uni_b', 'major_b', 'loader_b')">
                                <option value="" disabled selected>-- Chọn trường mong muốn --</option>
                                <?php foreach ($universities as $uni): ?>
                                    <option value="<?= $uni['id'] ?>"><?= htmlspecialchars($uni['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group position-relative">
                            <label class="form-label"><i class="fas fa-graduation-cap me-2"></i>Ngành học đào tạo</label>
                            <select name="major_b" id="major_b" class="custom-select-box" disabled required>
                                <option value="" disabled selected>-- Vui lòng chọn trường trước --</option>
                            </select>
                            <div id="loader_b" class="loader"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn-compare-start">
                    <i class="fas fa-bolt me-2"></i> Bắt đầu so sánh thực tế
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    /**
     * Hàm tải danh sách ngành động
     * @param {string} uniSelectId - ID của select trường (vd: uni_a)
     * @param {string} majorSelectId - ID của select ngành cần đổ dữ liệu (vd: major_a)
     * @param {string} loaderId - ID của biểu tượng loading (vd: loader_a)
     */
    function loadMajors(uniSelectId, majorSelectId, loaderId) {
        const uniId = document.getElementById(uniSelectId).value;
        const majorSelect = document.getElementById(majorSelectId);
        const loader = document.getElementById(loaderId);

        // 1. Reset trạng thái
        majorSelect.innerHTML = '<option value="" disabled selected>Đang tải dữ liệu...</option>';
        majorSelect.disabled = true;
        
        // Hiện loader
        if(loader) loader.style.display = 'block';

        if (uniId) {
            // 2. Gọi API AJAX từ Controller
            fetch(`index.php?page=compare&action=getMajorsByUni&uni_id=${uniId}`)
                .then(response => response.json())
                .then(data => {
                    // Ẩn loader
                    if(loader) loader.style.display = 'none';

                    // 3. Xử lý dữ liệu trả về
                    if (data.length > 0) {
                        majorSelect.innerHTML = '<option value="" disabled selected>-- Chọn ngành học --</option>';
                        
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.name;
                            majorSelect.appendChild(option);
                        });
                        
                        majorSelect.disabled = false; // Mở khóa cho chọn
                        // Hiệu ứng nháy nhẹ màu viền
                        majorSelect.style.borderColor = '#00b894';
                        setTimeout(() => { majorSelect.style.borderColor = ''; }, 500);
                        
                    } else {
                        majorSelect.innerHTML = '<option value="" disabled selected>Trường này chưa cập nhật ngành</option>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if(loader) loader.style.display = 'none';
                    majorSelect.innerHTML = '<option value="" disabled selected>Lỗi tải dữ liệu!</option>';
                });
        } else {
            if(loader) loader.style.display = 'none';
            majorSelect.innerHTML = '<option value="" disabled selected>-- Vui lòng chọn trường trước --</option>';
        }
    }
</script>

<?php require_once 'views/layouts/footer.php'; ?>