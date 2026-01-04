<?php require_once 'views/layouts/header.php'; ?>

<section class="heading-page header-text" id="top" style="background-image: url('public/assets/images/meetings-bg.jpg'); background-attachment: fixed; position: relative;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6 style="letter-spacing: 3px; text-transform: uppercase; font-weight: 300;">Cập nhật mới nhất</h6>
                <h2 style="font-size: 42px; font-weight: 900; text-shadow: 2px 2px 10px rgba(0,0,0,0.3);">LỊCH SỰ KIỆN & HỘI THẢO</h2>
            </div>
        </div>
    </div>
</section>

<section class="meetings-page" id="meetings" style="background: #f4f7f6; padding: 80px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php if(isset($events) && count($events) > 0): ?>
                        <?php foreach($events as $ev): ?>
<div class="col-lg-4 templatemo-item-col mb-5">
    <div class="event-card-modern" onclick="window.location.href='index.php?page=events&action=detail&id=<?= $ev['id'] ?>'" style="cursor: pointer;">
        <div class="thumb-wrapper">
            <div class="event-status <?= strtolower($ev['type']) === 'online' ? 'status-online' : 'status-offline' ?>">
                <?= strtoupper(htmlspecialchars($ev['type'] ?? 'EVENT')) ?>
            </div>
            
            <img src="public/assets/images/<?= htmlspecialchars($ev['image'] ?? 'meeting-01.jpg') ?>" 
                 alt="<?= htmlspecialchars($ev['title'] ?? '') ?>" class="img-fluid">

            <div class="date-overlay">
                <span class="day"><?= date('d', strtotime($ev['event_date'])) ?></span>
                <span class="month">Tháng <?= date('m', strtotime($ev['event_date'])) ?></span>
            </div>
        </div>

        <div class="event-info">
            <h4 class="event-title"><?= htmlspecialchars($ev['title']) ?></h4>
            
            <div class="event-meta">
                <p><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($ev['location']) ?></p>
                <p class="event-time"><i class="fa fa-clock"></i> <?= date('H:i', strtotime($ev['event_date'])) ?></p>
            </div>

            <p class="event-short-desc">
                <?= mb_substr(htmlspecialchars($ev['description']), 0, 90) ?>...
            </p>

            <div class="event-footer">
                <span class="view-detail-btn">CHI TIẾT <i class="fa fa-long-arrow-right"></i></span>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <div class="no-event-box" style="background: rgba(255,255,255,0.8); padding: 40px; border-radius: 20px;">
                                <i class="fa fa-calendar-times fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Hiện tại không có sự kiện nào sắp diễn ra.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .event-card-modern {
        background: #fff;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        position: relative;
    }

    .event-card-modern:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px rgba(190, 30, 45, 0.12);
    }

    .thumb-wrapper {
        position: relative;
        overflow: hidden;
        height: 240px;
    }
    .event-card-modern * {
        pointer-events: none; /* Giúp sự kiện click xuyên qua các thẻ con và rơi vào card chính */
    }
    .event-card-modern {
        pointer-events: auto; /* Bật lại click cho card chính */
    }

    .thumb-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .event-card-modern:hover .thumb-wrapper img {
        transform: scale(1.1);
    }

    /* Hiệu ứng trạng thái Online/Offline */
    .event-status {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 5;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
        color: #fff;
        letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .status-online { background: #28a745; }
    .status-offline { background: #be1e2d; }

    /* Overlay ngày tháng */
    .date-overlay {
        position: absolute;
        bottom: 0;
        left: 20px;
        background: #fff;
        padding: 10px 15px;
        border-radius: 15px 15px 0 0;
        text-align: center;
        box-shadow: 0 -5px 15px rgba(0,0,0,0.1);
    }
    .date-overlay .day { display: block; font-size: 24px; font-weight: 800; color: #be1e2d; line-height: 1; }
    .date-overlay .month { font-size: 11px; text-transform: uppercase; color: #777; font-weight: 600; }

    .event-info { padding: 30px 25px; }
    
    .event-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f272b;
        margin-bottom: 15px;
        transition: color 0.3s;
        height: 50px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .event-card-modern:hover .event-title { color: #be1e2d; }

    .event-meta { margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
    .event-meta p { font-size: 13px; color: #777; margin: 0; }
    .event-meta i { color: #be1e2d; margin-right: 8px; }

    .event-short-desc { font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 20px; }

    .view-detail-btn {
        font-size: 13px;
        font-weight: 800;
        color: #be1e2d;
        text-decoration: none;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .view-detail-btn:hover { letter-spacing: 2px; }

    /* Animation vào trang */
    .templatemo-item-col {
        animation: fadeInUp 0.8s ease backwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?php require_once 'views/layouts/header.php'; ?>