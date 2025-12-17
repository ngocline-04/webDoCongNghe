<?php

require_once('app/Controllers/Admin/BackendController.php');
require_once('app/Models/Model.php');
require_once('app/Models/Admin/Category.php');
require_once('app/Models/Admin/Product.php');
require_once('app/Models/Admin/Discount.php');
require_once('core/Storage.php');
require_once('core/Unit.php');
require_once('core/Auth.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends BackendController
{

    public function index()
    {
        $category = new Category;
        $categories = $category->findAll();
        $product = new Product;
        $product = $product->findAll();
        $count = count($product);

        $pages = $count%5==0?$count/5:floor($count/5)+1;
        // print_r($pages);die();
        $data = [
            'categories' => $categories,
            'pages' => $pages
        ];
        return $this->view('product/index.php',$data);
    }

    public function create()
    {
        return $this->view('product/create.php');
    }

    public function store()
    {

        $product = new Product();
        Storage::upload('thumbnail',$_FILES['thumbnail']);
        $_POST['thumbnail'] = $_FILES['thumbnail']['name'];
        $product = $product->create($_POST);
        return redirect('admin/product');
    }

    
    public function edit()
    {
        $id = $_GET['id'];
        $product = new Product;
        $product = $product->find($id);
        return $this->view('product/edit.php',$product);
    }

    public function update()
    {
        $id = $_GET['id'];
        $create = new Product();
        if(!empty($_FILES['thumbnail']['name'])) {
            Storage::upload('thumbnail',$_FILES['thumbnail']);
            $_POST['thumbnail'] = $_FILES['thumbnail']['name'];
        } 
        $create = $create->update($_POST,$id);
        
        return redirect('admin/product');
        
    }


    public function delete()
    {
        $id = $_POST['id'];
        $product = new Product;
        $product = $product->delete($id);
        if($product == true){
            return true;
        } else {
            return false;
        }
    }

    public function product()
    {
        if(empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];        
        }
        $id = $_GET['id'];
        $pages = ($page-1)*5;
        $product = new Product;
        $products = $product->changeCategory($id,$pages);
        $discount = new Discount;
        $discounts = $discount->findAll();
        $data = [
            'products' => $products,
            'discounts' => $discounts
        ];
        return $this->view('product/product.php' , $data);
    }

    public function upload_ckeditor()
    {
        if(isset($_FILES['upload'])) {
            $fileName = $_FILES['upload']['name'];
            Storage::upload('test',$_FILES['upload']);
            $url = asset('storage/test/'.$fileName);
        }
        return $url;
    }
    public function search()
    {
        $keyword = $_GET['keyword'] ?? '';

        $product = new Product();
        $products = $product->searchByName($keyword);

        $data = [
            'products' => $products
        ];

        return $this->view('product/product.php', $data);
    }



public function importExcel()
{
    if (!isset($_FILES['excel_file'])) {
        return redirect('admin/product');
    }

    $file = $_FILES['excel_file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $rows = $spreadsheet->getActiveSheet()->toArray();

    // Bỏ dòng header
    unset($rows[0]);

    $productModel = new Product();
    $categoryModel = new Category();

    // Lấy tất cả category và map name => id
    $categories = $categoryModel->findAll();
    $categoryMap = [];
    foreach ($categories as $cat) {
        $categoryMap[mb_strtolower(trim($cat['name']))] = $cat['id'];
    }

    foreach ($rows as $row) {

        if (empty($row[0])) continue;

        $categoryName = mb_strtolower(trim($row[3]));

        // Nếu không tìm thấy danh mục → bỏ qua
        if (!isset($categoryMap[$categoryName])) {
            continue;
        }

        $data = [
            'name'        => trim($row[0]),
            'price'       => (int)$row[1],
            'amount'      => (int)$row[2],
            'category_id' => $categoryMap[$categoryName],
            'thumbnail'   => trim($row[4]),
            'description' => trim($row[5]),
        ];

        $productModel->create($data);
    }

    return redirect('admin/product');
}


public function exportExcel()
{
    $productModel = new Product();
    $products = $productModel->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'name');
    $sheet->setCellValue('B1', 'price');
    $sheet->setCellValue('C1', 'amount');
    $sheet->setCellValue('D1', 'category_id');
    $sheet->setCellValue('E1', 'thumbnail');
    $sheet->setCellValue('F1', 'description');

    $row = 2;
    foreach ($products as $product) {
        $sheet->setCellValue('A'.$row, $product['name']);
        $sheet->setCellValue('B'.$row, $product['price']);
        $sheet->setCellValue('C'.$row, $product['amount']);
        $sheet->setCellValue('D'.$row, $product['category_id']);
        $sheet->setCellValue('E'.$row, $product['thumbnail']);
        $sheet->setCellValue('F'.$row, $product['description']);
        $row++;
    }

    // Xuất file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="products.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}



}