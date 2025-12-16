
<?php 

require_once('app/Models/Model.php');
class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'content'
    ];

    public function store($data)
    {
        $sql = "
            INSERT INTO reviews (product_id, user_id, rating, content)
            VALUES (
                {$data['product_id']},
                {$data['user_id']},
                {$data['rating']},
                '{$data['content']}'
            )
        ";
        return $this->dbConnection->query($sql);
    }

    public function getByProduct($productId)
    {
        $sql = "
            SELECT r.*, u.fullname 
            FROM reviews r
            JOIN users u ON u.id = r.user_id
            WHERE r.product_id = $productId
            ORDER BY r.created_at DESC
        ";
         $result = $this->dbConnection->query($sql);

        if (!$result) {
                return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    
}
