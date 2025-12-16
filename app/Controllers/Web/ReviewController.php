<?php 
require_once('app/Controllers/Web/WebController.php') ;
require_once('app/Models/Web/Product.php');
require_once('app/Models/Web/Review.php');
require_once('core/Auth.php');


class ReviewController
{
    public function store()
    {
        header('Content-Type: application/json');


        if (!Auth::getUser('user')) {
            echo json_encode(['success' => false]);
            return;
        }

        $review = new Review;
        $product = new Product;

        $data = [
            'product_id' => $_POST['product_id'],
            'user_id'    => Auth::getUser('user')['id'],
            'rating'     => $_POST['rating'],
            'content'    => $_POST['content']
        ];
    
        $review->store($data);
        

        $result = $product->updateRating($data['product_id']);

    
        echo json_encode([
            'success' => true,
            'review' => [
                'fullname' => Auth::getUser('user')['fullname'],
                'rating' => (int)$data['rating'],
                'content' => $data['content'],
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

}
