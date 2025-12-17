<?php 

require_once('app/Controllers/Admin/BackendController.php');
require_once('app/Models/Model.php');
require_once('core/Auth.php');
require_once('app/Models/Admin/Category.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

class CategoryController extends BackendController
{
    public function index()
    {
        $category = new Category;
        $categories = $category->findAll();
        return $this->view('category/index.php',$categories);
    }

    public function create()
    {
        return $this->view('category/create.php');
    }

    public function store()
    {
        $category = new Category();
        $category = $category->create($_POST);
        return redirect('admin/category');
    }

    public function viewCategory()
    {
        return $this->view('category/view.php');
    }

    public function edit()
    {
        return $this->view('category/edit.php');
    }

    public function update()
    {
        $id = $_GET['id'];
        $category = new Category();
        $category = $category->update($_POST,$id);
        if($category)
        {
            return redirect('admin/category');
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $category = new Category();
        $category = $category->delete($id);
        return redirect('admin/category');
    }
    public function importExcel()
{
    if (!isset($_FILES['excel_file'])) {
        return redirect('admin/category');
    }

    $file = $_FILES['excel_file']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $categoryModel = new Category();

        foreach ($rows as $index => $row) {
            if ($index == 0) continue;

            $name = trim($row[0]);

            if ($name != '') {
                $categoryModel->create([
                    'name' => $name
                ]);
            }
        }

        return redirect('admin/category');

    } catch (Exception $e) {
        echo "Lỗi import: " . $e->getMessage();
        die();
    }
}

}