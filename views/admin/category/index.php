<?php require_once('views/admin/layouts/index.php') ?>
<?php startblock('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header border-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                             <a href="<?=url('admin/category/create')?>" class="btn btn-primary">
                                  + Thêm danh mục</a>
                            </div>
                        <div class="col-md-6 text-right">
                        <button class="btn btn-success" data-toggle="modal" data-target="#importCategoryModal">
                        Import Excel
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
                <div >
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>Name:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $key => $category) : ?>
                                <tr>
                                    <td><?= $category['name'] ?></td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                    href="<?=url('admin/category/edit/'.$category['id'])?>">Sửa</a>
                                                <a class="dropdown-item" onclick="return confirm('are you sure ?')"
                                                    href="<?=url('admin/category/delete/'.$category['id'])?>">Xóa</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach ; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endblock() ?>

<?php startblock('js') ?>
<!-- MODAL IMPORT CATEGORY -->
<div class="modal fade" id="importCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <form 
        action="<?=url('admin/category/importExcel')?>"
        method="POST"
        enctype="multipart/form-data"
        class="modal-content"
    >

      <div class="modal-header">
        <h5 class="modal-title">Import danh mục từ Excel</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
            <label>Chọn file Excel (.xlsx)</label>
            <input 
                type="file"
                name="excel_file"
                class="form-control"
                accept=".xlsx,.xls"
                required
            >
        </div>

        <small class="text-muted">
            File Excel chỉ cần 1 cột: <b>name</b>
        </small>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">
            Import
        </button>
      </div>

    </form>
  </div>
</div>

<?php endblock() ?>