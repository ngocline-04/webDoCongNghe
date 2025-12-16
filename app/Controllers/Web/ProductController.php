<?php 
require_once('app/Controllers/Web/WebController.php') ;
require_once('app/Models/Web/Product.php');
require_once('app/Models/Web/Review.php');


class ProductController extends WebController
{
    public function index()
    {
        $id = $_GET['id'];
        $product = new Product;
        $review  = new Review;

        $showProduct = $product->show_product_id($id);
        $review_list = $review->getByProduct($id);

        $showProduct['review_list'] = $review_list;

        return $this->view('product/index.php', $showProduct);
    }
}


?>