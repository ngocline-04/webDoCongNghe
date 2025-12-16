<?php require_once ('views/web/layouts/index.php') ?>
<?php require_once ('core/Unit.php') ?>

<?php startblock('title') ?>
Thông tin cá nhân
<?php endblock() ?>

<?php startblock('css') ?>
<link href="<?=asset('assets/web/css/product_page.css') ?>" rel="stylesheet">

<?php endblock() ?>

<?php startblock('content') ?>
<main>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card  border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Thông tin cá nhân</h4>

                        <form id="profileForm" action="<?=url('profile/update')?>" method="POST">

                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text"
                                    name="fullname"
                                    class="form-control"
                                    value="<?= $user['fullname'] ?? '' ?>"
                                    disabled>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                    name="email"
                                    class="form-control"
                                    value="<?= $user['email'] ?? '' ?>"
                                    disabled>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text"
                                    name="phone_number"
                                    class="form-control"
                                    value="<?= $user['phone_number'] ?? '' ?>"
                                    disabled>
                            </div>

                            <!-- Địa chỉ -->
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text"
                                    name="address"
                                    class="form-control"
                                    value="<?= $user['address'] ?? '' ?>"
                                    disabled>
                            </div>

                            <!-- Nút -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="button" id="btnEdit" class="btn_1">
                                    Chỉnh sửa
                                </button>

                                <button type="submit" id="btnSave" class="btn btn-success d-none">
                                    Lưu thay đổi
                                </button>

                                <button type="button" id="btnCancel" class="btn btn-secondary d-none">
                                    Hủy
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</main>

<script>
    const form = document.getElementById('profileForm');
    const btnEdit = document.getElementById('btnEdit');
    const btnSave = document.getElementById('btnSave');
    const btnCancel = document.getElementById('btnCancel');

    let backup = {};

    function toggleEdit(edit) {
        form.querySelectorAll('input, textarea').forEach(el => {
            el.disabled = !edit;
        });

        btnEdit.classList.toggle('d-none', edit);
        btnSave.classList.toggle('d-none', !edit);
        btnCancel.classList.toggle('d-none', !edit);
    }

    btnEdit.onclick = () => {
        // lưu dữ liệu cũ
        form.querySelectorAll('input, textarea').forEach(el => {
            backup[el.name] = el.value;
        });
        toggleEdit(true);
    };

    btnCancel.onclick = () => {
        // khôi phục dữ liệu
        form.querySelectorAll('input, textarea').forEach(el => {
            el.value = backup[el.name] ?? '';
        });
        toggleEdit(false);
    };
</script>


<?php endblock() ?>