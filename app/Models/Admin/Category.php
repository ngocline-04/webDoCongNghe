<?php 

require_once('app/Models/Model.php');

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = ['id', 'name'];

    public function show_categories()
    {
        return $this->findAll();
    }

    public function show_category($id)
    {
        return $this->find($id);
    }
    public function existsByName($name)
{
    $sql = "SELECT id FROM {$this->table} WHERE name = ?";
    $stmt = $this->dbConnection->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

}
