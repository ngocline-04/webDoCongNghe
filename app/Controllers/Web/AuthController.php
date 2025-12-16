<?php

require_once('app/Controllers/Web/WebController.php');
require_once('app/Requests/Web/AuthRequest.php');
require_once('app/Models/Web/User.php');
require_once('app/Models/Role.php');
require_once('app/Models/Web/Cart.php');
require_once('core/Flash.php');
require_once('core/Auth.php');
require_once('core/Email.php');


class AuthController extends WebController
{
    public function login()
    {
        return $this->view('auth/login.php');
    }

    public function register()
    {
        return $this->view('auth/register.php');
    }

     public function forgot()
    {
        return $this->view('auth/forgot.php');
    }

    public function handleRegister()
    {
        $checkUser = new User;
        $checkUsers = $checkUser->findAll();
        $authRequest = new AuthRequest();
        $errors = $authRequest->validateRegister($_POST,$checkUsers);
        if(count($errors) == 0)
        {
            $user = new User();
            $_POST['role_id'] = Role::USER;
            $_POST['password'] = md5($_POST['password']);
            $isCreated = $user->create($_POST);
            if($isCreated)
            {
            return redirect('auth/login'); 
            }
        }      

        return $this->view('auth/register.php' , ['errors' => $errors, 'data' => $_POST]);
    }

    public function handleLogin()
    {
        // print_r($_POST);die();
        $user = new User(); 
        $user = $user->authenticate($_POST);
        if($user && $user['role_id'] == 2)
        {
            if(isset($_POST['remember_me'])) {
                Auth::setUser('user', $user, true);
            } else {
                Auth::setUser('user', $user);
            }

            return redirect('Auth/updateCart');
        }

        Flash::set('error','Đăng nhập thất bại');
        return redirect('auth/login'); 
    }

    public function updateCart()
    {
        if(Auth::getUser('user')['id']) {
            $cart = new Cart;
            $carts = $cart->cart_client($_SERVER['HTTP_USER_AGENT']);
            foreach ($carts as $cart) {
                if($cart['client_id'] != $_SERVER['HTTP_USER_AGENT']) {
                    exit();
                } else {
                    $data = [
                        'client_id' => NULL,
                        'users_id' => Auth::getUser('user')['id']
                    ];
                    $updateCart = new Cart;
                    $updateCart = $updateCart->update($data,$cart['id']);
                    continue;
                }
            }
            return redirect('');
        }
    }

    public function logout()
    {
        Auth::logout('user');
        return redirect('auth/login');
    }

    public function sendResetCode()
    {
        header('Content-Type: application/json');

        $email = trim($_POST['email'] ?? '');

        if ($email === '') {
            echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'Email không tồn tại']);
            return;
        }

        // tạo mã 6 ký tự
        $code = strtoupper(substr(md5(uniqid()), 0, 6));
        $expire = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // lưu DB
       $userModel->updateResetCode($user['id'], $code, $expire);

        $subject = 'Mã đặt lại mật khẩu';
        $message = "
            <p>Xin chào <b>{$user['fullname']}</b>,</p>
            <p>Bạn đã yêu cầu đặt lại mật khẩu.</p>
            <p><b>Mã xác nhận:</b></p>
            <h2 style='color:red'>{$code}</h2>
            <p>Mã có hiệu lực trong <b>10 phút</b>.</p>
            <p>Nếu không phải bạn, vui lòng bỏ qua email này.</p>
        ";

        // gửi mail (tạm log, sau này gắn Mail class)
        // mail($email, 'Mã đặt lại mật khẩu', "Mã của bạn: $code");
        $mail = new Email($subject, $message);

         $mail->send($email);

    // 🔥 SET STEP
        $_SESSION['forgot_email'] = $email;
        $_SESSION['forgot_step']  = 'reset';

        Flash::set('success', 'Đã gửi mã xác nhận qua email');
        return redirect('auth/forgot');

    }

      public function resetPassword()
    {
        header('Content-Type: application/json');

        $code     = trim($_POST['code'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm'] ?? '');

        if ($code === '' || $password === '' || $confirm === '') {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        if ($password !== $confirm) {
            echo json_encode(['success' => false, 'message' => 'Mật khẩu không khớp']);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByResetCode($code);

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'Mã không hợp lệ hoặc đã hết hạn']);
            return;
        }

        $hashed = md5($password);

        $userModel->resetPasswordById($user['id'], $hashed);

        unset($_SESSION['forgot_step']);
        unset($_SESSION['forgot_email']);

        Flash::set('success', 'Đặt lại mật khẩu thành công');
        return redirect('auth/login');
    }


}