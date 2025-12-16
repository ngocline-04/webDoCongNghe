<?php require_once('views/web/layouts/index.php') ?>

<?php startblock('title') ?>
Hệ thống showroom
<?php endblock() ?>

<?php startblock('content') ?>
<main class="bg_gray">
    <div class="container margin_30">

        <div class="page_header text-center mb-4">
            <h1 class="mb-1">Hệ thống showroom</h1>
            <p class="text-muted">Hệ thống cửa hàng trên toàn quốc</p>
        </div>

        <div class="row">

            <!-- HÀ NỘI -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">🏬 Showroom Hà Nội</h5>
                        <p class="card-text mb-2">
                            📍 123 Cầu Giấy, Hà Nội
                        </p>
                        <p class="card-text mb-2">
                            ☎ 0123 456 789
                        </p>
                        <p class="card-text text-muted">
                            ⏰ 8:00 – 21:00
                        </p>
                    </div>
                </div>
            </div>

            <!-- HCM -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">🏬 Showroom TP. Hồ Chí Minh</h5>
                        <p class="card-text mb-2">
                            📍 456 Nguyễn Thị Minh Khai, Quận 3
                        </p>
                        <p class="card-text mb-2">
                            ☎ 0987 654 321
                        </p>
                        <p class="card-text text-muted">
                            ⏰ 8:00 – 21:00
                        </p>
                    </div>
                </div>
            </div>

            <!-- ĐÀ NẴNG -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">🏬 Showroom Đà Nẵng</h5>
                        <p class="card-text mb-2">
                            📍 789 Lê Duẩn, Hải Châu
                        </p>
                        <p class="card-text mb-2">
                            ☎ 0909 888 777
                        </p>
                        <p class="card-text text-muted">
                            ⏰ 8:00 – 20:00
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>
<?php endblock() ?>
