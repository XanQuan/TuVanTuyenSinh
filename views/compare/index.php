<?php require_once 'views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    :root {
        --primary-blue: #0061ff;
        --primary-red: #ff4b2b;
        --dark-surface: #0f172a;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
    .compare-section { padding: 150px 0 100px; }

    /* PHÂN VÙNG KHỐI RÕ RỆT */
    .compare-grid {
        display: flex;
        align-items: stretch;
        background: white;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.08);
    }

    .choice-zone {
        flex: 1;
        padding: 60px 50px;
        position: relative;
        transition: 0.4s;
    }

    /* Khối A - Xanh dương */
    .zone-a { border-right: 1px solid #f1f5f9; }
    .zone-a::before { content: ''; position: absolute; top: 0; left: 0; width: 10px; height: 100%; background: var(--primary-blue); }
    
    /* Khối B - Đỏ */
    .zone-b::before { content: ''; position: absolute; top: 0; right: 0; width: 10px; height: 100%; background: var(--primary-red); }

    .vs-separator {
        width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        position: relative;
    }

    .vs-badge {
        width: 60px; height: 60px;
        background: var(--dark-surface);
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 900;
        border: 6px solid white;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        z-index: 10;
    }

    /* NỔI BẬT Ô CHỌN */
    .modern-label {
        font-weight: 800;
        color: #64748b;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 12px;
        display: block;
    }

    .pro-select {
        border-radius: 16px !important;
        padding: 16px 20px !important;
        font-weight: 600;
        color: #1e293b;
        border: 2px solid #eef2f6 !important;
        background-color: #f8fafc !important;
        width: 100%;
        margin-bottom: 30px;
        transition: 0.3s;
    }

    .zone-a .pro-select:focus { border-color: var(--primary-blue) !important; box-shadow: 0 0 0 4px rgba(0, 97, 255, 0.1) !important; background: white !important; }
    .zone-b .pro-select:focus { border-color: var(--primary-red) !important; box-shadow: 0 0 0 4px rgba(255, 75, 43, 0.1) !important; background: white !important; }

    /* NÚT BẤM CÔNG NGHỆ */
    .btn-analyze-battle {
        background: var(--dark-surface);
        color: white;
        padding: 22px 60px;
        border-radius: 20px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        transition: 0.4s;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);
    }
    .btn-analyze-battle:hover { transform: translateY(-5px) scale(1.02); background: #000; color: #fff; }

    /* Đánh dấu ngành trùng khớp */
    .sync-success { color: #059669 !important; font-weight: 800 !important; }
</style>

<section class="compare-section">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-800 text-dark mb-2" style="letter-spacing: -2px;">Phân Tích Đối Đầu</h1>
            <p class="text-muted fs-5">Lựa chọn trường và ngành để hệ thống tự động đồng bộ dữ liệu.</p>
        </div>

        <form action="index.php?page=compare&action=result" method="POST">
            <div class="compare-grid">
                <div class="choice-zone zone-a">
                    <div class="mb-5">
                        <span class="badge bg-primary px-3 py-2 rounded-pill mb-2">LỰA CHỌN 1</span>
                        <h2 class="fw-800 text-dark">Đối Tượng A</h2>
                    </div>

                    <label class="modern-label"><i class="fas fa-university me-2"></i>Trường Đại học</label>
                    <select name="uni1" id="uni1" class="pro-select" required onchange="loadMajorsRealtime(1)">
                        <option value="" selected disabled>-- Chọn trường mong muốn --</option>
                        <?php foreach($universities as $u): ?>
                            <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label class="modern-label"><i class="fas fa-graduation-cap me-2"></i>Ngành học đào tạo</label>
                    <select name="major1" id="major1" class="pro-select" required onchange="syncOtherSide(1)">
                        <option value="" selected disabled>-- Chọn trường trước --</option>
                    </select>
                </div>

                <div class="vs-separator">
                    <div class="vs-badge">VS</div>
                </div>

                <div class="choice-zone zone-b">
                    <div class="mb-5">
                        <span class="badge bg-danger px-3 py-2 rounded-pill mb-2">LỰA CHỌN 2</span>
                        <h2 class="fw-800 text-dark">Đối Tượng B</h2>
                    </div>

                    <label class="modern-label"><i class="fas fa-university me-2 text-danger"></i>Trường Đại học</label>
                    <select name="uni2" id="uni2" class="pro-select" required onchange="loadMajorsRealtime(2)">
                        <option value="" selected disabled>-- Chọn trường mong muốn --</option>
                        <?php foreach($universities as $u): ?>
                            <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label class="modern-label"><i class="fas fa-graduation-cap me-2 text-danger"></i>Ngành học đào tạo</label>
                    <select name="major2" id="major2" class="pro-select" required onchange="syncOtherSide(2)">
                        <option value="" selected disabled>-- Chọn trường trước --</option>
                    </select>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn-analyze-battle">
                    <i class="fas fa-bolt me-2"></i> Bắt đầu so sánh thực tế
                </button>
            </div>
        </form>
    </div>
</section>

<script>
// Giữ nguyên các hàm JS của bạn vì chúng đã viết đúng logic
async function loadMajorsRealtime(side) {
    const uniId = document.getElementById(`uni${side}`).value;
    const majorSelect = document.getElementById(`major${side}`);
    majorSelect.innerHTML = '<option disabled selected>Đang lấy dữ liệu...</option>';

    try {
        const response = await fetch(`index.php?page=compare&action=getMajorsByUni&uni_id=${uniId}`);
        const data = await response.json();

        majorSelect.innerHTML = '<option value="" disabled selected>-- Chọn ngành học --</option>';
        data.forEach(m => {
            let opt = document.createElement('option');
            opt.value = m.id;
            opt.text = m.name;
            opt.setAttribute('data-name', m.name);
            majorSelect.appendChild(opt);
        });

        const other = side === 1 ? 2 : 1;
        if(document.getElementById(`major${other}`).value) syncOtherSide(other);
    } catch (e) {
        majorSelect.innerHTML = '<option disabled>Không thể tải ngành học</option>';
    }
}

function syncOtherSide(sourceSide) {
    const targetSide = sourceSide === 1 ? 2 : 1;
    const sourceSelect = document.getElementById(`major${sourceSide}`);
    const targetSelect = document.getElementById(`major${targetSide}`);
    
    if (!sourceSelect.value) return;

    // Lấy tên ngành đang chọn ở bên A
    const selectedName = sourceSelect.options[sourceSelect.selectedIndex].getAttribute('data-name');
    const options = Array.from(targetSelect.options).filter(opt => opt.value !== "");

    options.forEach(opt => {
        // So sánh: Nếu cùng tên ngành thì cho phép chọn và đẩy lên đầu
        const isMatch = opt.getAttribute('data-name') === selectedName;
        
        if (isMatch) {
            opt.disabled = false;
            opt.classList.add('sync-success');
            opt.text = "✓ " + opt.getAttribute('data-name');
            opt.setAttribute('data-sort', 1);
        } else {
            opt.disabled = true;
            opt.classList.remove('sync-success');
            opt.text = opt.getAttribute('data-name') + " (Trường kia không có)";
            opt.setAttribute('data-sort', 2);
        }
    });

    // Sắp xếp lại danh sách
    const sorted = options.sort((a, b) => a.getAttribute('data-sort') - b.getAttribute('data-sort'));
    const def = targetSelect.options[0];
    targetSelect.innerHTML = "";
    targetSelect.add(def);
    sorted.forEach(o => targetSelect.add(o));
}
</script>

<?php require_once 'views/layouts/footer.php'; ?>