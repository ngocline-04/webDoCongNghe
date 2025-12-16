<?php require_once('views/web/layouts/index.php') ?>

<?php startblock('title') ?>
Quên mật khẩu
<?php endblock() ?>

<?php
$step = $_SESSION['forgot_step'] ?? 'email';
?>


<?php startblock('content') ?>
<main class="bg_gray">
    <div class="container margin_30">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8">
                <div class="box_account">

                    <h3 class="client">Quên mật khẩu</h3>

                    <?php if ($step === 'email'): ?>
                    <form action="<?= url('auth/sendResetCode') ?>" method="POST">
                        <div class="form-group">
                            <input type="email"
                                class="form-control"
                                name="email"
                                placeholder="Nhập email"
                                required>
                        </div>

                        <div class="text-center">
                            <button class="btn_1 full-width">Gửi mã xác nhận</button>
                        </div>
                    </form>
                    <?php endif; ?>

                    <?php if ($step === 'reset'): ?>
                    <form action="<?= url('auth/resetPassword') ?>" method="POST">

                        <div class="form-group">
                            <input type="text"
                                class="form-control"
                                name="code"
                                placeholder="Mã xác nhận (6 ký tự)"
                                required>
                        </div>

                        <div class="form-group">
                            <input type="password"
                                class="form-control"
                                name="password"
                                placeholder="Mật khẩu mới"
                                required>
                        </div>

                        <div class="form-group">
                            <input type="password"
                                class="form-control"
                                name="confirm"
                                placeholder="Nhập lại mật khẩu"
                                required>
                        </div>

                        <div class="text-center">
                            <button class="btn_1 full-width">Đặt lại mật khẩu</button>
                        </div>
                    </form>
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="<?= url('auth/login') ?>">← Quay lại đăng nhập</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
<?php endblock() ?>