<?php 
require_once('app/Controllers/Web/WebController.php') ;
require_once('app/Models/Web/Product.php');
require_once('app/Models/Web/User.php');


require_once('core/Auth.php');


class ProfileController extends WebController
{
    public function index()
    {
        $authUser = Auth::getUser('user');

        $userId = $authUser['id'] ?? Auth::getUser('id');

        $userModel = new User();
        $user = $userModel->findById($userId);

        // truyền data sang view
        $data = [
            'user' => $user
        ];

        return $this->view('profile/index.php', $data);

    }


    public function update()
    {
    $authUser = Auth::getUser('user');

    if (empty($authUser)) {
        header('Location: ' . url('login'));
        exit;
    }

    $userId = $authUser['id'];

    // Lấy dữ liệu POST
    $fullname     = trim($_POST['fullname'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');
    $address      = trim($_POST['address'] ?? '');

    // Validate tối thiểu
    if ($fullname === '' || $email === '') {
        header('Location: ' . url('profile'));
        exit;
    }

    // Update DB
    $userModel = new User();

    $userModel->updateInfo(
        $userId,
        $fullname,
        $email,
        $phone_number,
        $address
    );

    // Cập nhật lại session Auth (rất quan trọng)
    $_SESSION['user']['fullname']     = $fullname;
    $_SESSION['user']['email']        = $email;
    $_SESSION['user']['phone_number'] = $phone_number;
    $_SESSION['user']['address']      = $address;

    // Quay lại trang profile
    header('Location: ' . url('profile'));
    exit;
    }
}