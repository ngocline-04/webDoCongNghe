<?php 

require_once('app/Models/Model.php');

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['id', 'fullname', 'email', 'phone_number', 'address', 'password', 'role_id'];

    public function authenticate($data)
    {
        $email = $data['email'];
        $password = $data['password'];
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = md5('$password')";
        return $this->getFirst($sql);
    }

     public function findById($id)
    {
         $sql = "
            SELECT fullname, email, phone_number, address
            FROM users
            WHERE id = '$id'
            LIMIT 1
        ";
        return $this->getFirst($sql);
    }

    public function findByEmail($email)
    {
        $email = $this->dbConnection->real_escape_string($email);
        $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        return $this->getFirst($sql);
    }


    public function updateInfo($id, $fullname, $email, $phone_number, $address)
    {
    $id = (int)$id;

    $sql = "
        UPDATE users 
        SET 
            fullname = '$fullname',
            email = '$email',
            phone_number = '$phone_number',
            address = '$address'
        WHERE id = $id
    ";

    return $this->dbConnection->query($sql);
    }

    public function updateResetCode($userId, $code, $expire)
{
    $sql = "
        UPDATE users 
        SET reset_code = '$code',
            reset_code_expired = '$expire'
        WHERE id = $userId
    ";
    return $this->dbConnection->query($sql);
}

    public function findByResetCode($code)
    {
        $sql = "
            SELECT * FROM users
            WHERE reset_code = '$code'
            AND reset_code_expired >= NOW()
            LIMIT 1
        ";
        $result = $this->dbConnection->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    public function resetPasswordById($userId, $hashedPassword)
    {
        $sql = "
            UPDATE users
            SET password = '$hashedPassword',
                reset_code = NULL,
                reset_code_expired = NULL
            WHERE id = $userId
        ";
        return $this->dbConnection->query($sql);
    }

}