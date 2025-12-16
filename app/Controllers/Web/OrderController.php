<?php 
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once('app/Controllers/Web/WebController.php');
require_once('app/Models/Web/Product.php');
require_once('app/Models/Model.php');
require_once('app/Models/CheckOrder.php');
require_once('app/Models/Web/Cart.php');
require_once('app/Models/Web/Order.php');
require_once('app/Models/Web/Checkout.php');
require_once('core/Unit.php');
require_once('core/Auth.php');
require_once('core/Email.php');
require_once('config/config.php');
require_once ('vendor/autoload.php');


class OrderController extends WebController
{
    public function index()
    {
        if(Auth::getUser('user')) {
            $cart = new Cart;
            $carts = $cart->cart_user(Auth::getUser('user')['id']);
            return $this->view('order/index.php',$carts);

        } else {
            // return redirect('');   
        }
    }

    public function detail()
    {
        $order = new Order;
        $orders = $order->show_order(Auth::getUser('user')['id']);
        $checkout = new Checkout;
        $checkouts = $checkout->showCheckout();
        $data = [
            'orders' => $orders,
            'checkouts' => $checkouts
        ];
        return $this->view('order/detail.php',$data);
    }

    public function handleCheckout()
    {
        // nguoi dung dang nhap
        $order = new Order;
        $cart = new Cart;
        $checkout = new Checkout;
        $product = new Product;

        if(Auth::getUser('user')) {

        //vnpay

        if($_POST['payment'] == '1') {

        $addOrder = $order->create($_POST);
        $showCarts = $cart->cart_user(Auth::getUser('user')['id']);

        $lineItems = []; // Stripe line_items

        foreach($showCarts as $cart) {
            echo '<script>console.log(' . json_encode($cart, JSON_UNESCAPED_UNICODE) . ');</script>';

            $order_id = $_POST['id'];
            $product_id = $cart['product_id'];
            $quantity = $cart['quantity'];
            $price = $cart['price'];
            $createCheckout = $checkout->createCheckout($product_id, $quantity, $price, $order_id);

            $lineItems[] = [
                    'price_data' => [
                        'currency' => 'vnd',
                        'product_data' => [
                            'name' => $cart['name']
                        ],
                        'unit_amount' => $cart['price'], // Stripe tính theo VND nhỏ nhất
                    ],
                    'quantity' => $cart['quantity']
                ];

        }
        
           \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']); 

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',

                // Khi thanh toán thành công → Stripe redirect về success
                'success_url' => url('order/orderSuccess') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order_id,

                // Khi hủy thanh toán → Redirect về trang giỏ
                'cancel_url' => url('order/cancel'),
            ]);

            // 3. Chuyển hướng sang trang thanh toán Stripe
            header("Location: " . $session->url);
            exit();
        
        // $vnp_TmnCode = "VW4CHF8Y"; //Website ID in VNPAY System
        // $vnp_HashSecret = "FEWXXWKLFFOTOINDLREISFEZVKOFHXBU"; //Secret key
        // $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        // $vnp_Returnurl = url('order/orderSuccess');
        // $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        // //Config input format
        // //Expire
        // $startTime = date("YmdHis");
        // $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));


        // $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        // $vnp_OrderInfo = $_POST['order_desc'];
        // $vnp_OrderType = $_POST['order_type'];
        // $vnp_Amount = $_POST['amount'] * 100;
        // $vnp_Locale = $_POST['language'];
        // $vnp_BankCode = $_POST['bank_code'];
        // $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        // //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        // // Billing
        // $fullName = trim($_POST['full_name']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }
        // $vnp_Bill_Mobile = $_POST['phone_number'];
        // $vnp_Bill_Address=$_POST['address'];
        
        // $inputData = array(
        //     "vnp_Version" => "2.1.0",
        //     "vnp_TmnCode" => $vnp_TmnCode,
        //     "vnp_Amount" => $vnp_Amount,
        //     "vnp_Command" => "pay",
        //     "vnp_CreateDate" => date('YmdHis'),
        //     "vnp_CurrCode" => "VND",
        //     "vnp_IpAddr" => $vnp_IpAddr,
        //     "vnp_Locale" => $vnp_Locale,
        //     "vnp_OrderInfo" => $vnp_OrderInfo,
        //     "vnp_OrderType" => $vnp_OrderType,
        //     "vnp_ReturnUrl" => $vnp_Returnurl,
        //     "vnp_TxnRef" => $vnp_TxnRef,
        //     //billing
        //     "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
        //     "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
        //     "vnp_Bill_LastName"=>$vnp_Bill_LastName,
        //     "vnp_Bill_Address"=>$vnp_Bill_Address,

        // );
        
        // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        //     $inputData['vnp_BankCode'] = $vnp_BankCode;
        // }
        // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        // }
        
        // //var_dump($inputData);
        // ksort($inputData);
        // $query = "";
        // $i = 0;
        // $hashdata = "";
        // foreach ($inputData as $key => $value) {
        //     if ($i == 1) {
        //         $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        //     } else {
        //         $hashdata .= urlencode($key) . "=" . urlencode($value);
        //         $i = 1;
        //     }
        //     $query .= urlencode($key) . "=" . urlencode($value) . '&';
        // }
        
        // $vnp_Url = $vnp_Url . "?" . $query;
        // if (isset($vnp_HashSecret)) {
        //     $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        //     $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        // }
        // $returnData = array('code' => '00'
        //     , 'message' => 'success'
        //     , 'data' => $vnp_Url);
        //     if (isset($_POST['redirect'])) {
        //         header('Location: ' . $vnp_Url);
        //         die();
        //     } else {
        //         echo json_encode($returnData);
        // }
        // // end vnpay
        
        // mua hang binh thuong    
        } else {

            $_POST['status_payment'] = CheckOrder::UNPAID;
            $order = $order->create($_POST);
            $showCarts = $cart->cart_user(Auth::getUser('user')['id']);

            foreach($showCarts as $cart) {
                $order_id = $_POST['id'];
                $product_id = $cart['product_id'];
                $quantity = $cart['quantity'];
                $price = $cart['price'];

                $addCheckout = $checkout->createCheckout($product_id,$quantity,$price,$order_id);
                $handleQuantity = $product->update_quantity($cart['quantity'],$cart['product_id']);
            }
            $deleteCart = new Cart;
            $deleteCart = $deleteCart->deleteCartUserId(Auth::getUser('user')['id']);
            return redirect('order/detail');
        }

        // nguoi dung k dang nhap
    } else {
        return false;

    }
        

    }

    public function orderSuccess()
    {
        $order = new Order;
        $cart = new Cart;
        $user = Auth::getUser('user');


        if (!isset($_GET['session_id'])) {
            return redirect('order'); 
        }

        $sessionId = $_GET['session_id'];

        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            
            // echo "<pre>";
            // var_dump($session);
            // echo "</pre>";
            // die();

            if ($session->payment_status === 'paid') {
                
                // $orderId = $session->metadata->order_id;
                $orderId = $_GET['order_id'] ?? null;

                $order = new Order;
                $cart  = new Cart;

                $order->updateStatus($orderId, 1);

                $order->updateStatusOrder($orderId, 2);


                $cart->deleteCartUserId(Auth::getUser('user')['id']);

                // Có thể gửi email ở đây nếu muốn (hoặc trong webhook)
                $message = "
                    <h2>🎉 Thanh toán thành công</h2>
                    <p>Xin chào <b>{$user['fullname']}</b>,</p>

                    <p>Đơn hàng <b>#{$orderId}</b> của bạn đã được thanh toán thành công.</p>

                    <p>
                        Thời gian: ".date('d/m/Y H:i')."
                    </p>

                    <p>Chúng tôi sẽ xử lý và giao hàng trong thời gian sớm nhất.</p>

                    <hr>
                    <p><b>Web Đồ Công Nghệ</b></p>
                ";

                $mail = new Email($subject, $message);
                $mail->send($user['email']);
                
                return redirect('');
            }

            return redirect('order');
        } catch (Exception $e) {
            return redirect('order');
    }
}
}
    //     $vnp_TmnCode = "VW4CHF8Y"; //Website ID in VNPAY System
    //     $vnp_HashSecret = "FEWXXWKLFFOTOINDLREISFEZVKOFHXBU"; //Secret key
    //     $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    //     $vnp_Returnurl = '';
    //     $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
    //     //Config input format
    //     //Expire
    //     $startTime = date("YmdHis");
    //     $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));


    //     $inputData = array();
    //     $returnData = array();
    //     foreach ($_GET as $key => $value) {
    //                 if (substr($key, 0, 4) == "vnp_") {
    //                     $inputData[$key] = $value;
    //                 }
    //             }

    //     $vnp_SecureHash = $inputData['vnp_SecureHash'];
    //     unset($inputData['vnp_SecureHash']);
    //     ksort($inputData);
    //     $i = 0;
    //     $hashData = "";
    //     foreach ($inputData as $key => $value) {
    //         if ($i == 1) {
    //             $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
    //         } else {
    //             $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
    //             $i = 1;
    //         }
    //     }

    //     $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    //     $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
    //     $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
    //     $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi

    //     $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
    //     $orderId = $inputData['vnp_TxnRef'];

    //     try {
    //         //Check Orderid    
    //         //Kiểm tra checksum của dữ liệu
    //         if ($secureHash == $vnp_SecureHash) {
    //             //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
    //             //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
    //             //Giả sử: $order = mysqli_fetch_assoc($result);   

    //             $getOrder = $order->find($orderId);

    //             // print_r($inputData['vnp_TxnRef']);die();
    //             if ($getOrder != NULL) {
    //                 if($getOrder["price"] == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
    //                 {
    //                     if ($getOrder["status_payment"] == NULL) {
    //                         // print_r($getOrder);die();
    //                         if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
    //                             $Status = 1; // Trạng thái thanh toán thành công
    //                         } else {
    //                             $Status = 2; // Trạng thái thanh toán thất bại / lỗi
    //                         }
    //                         if($Status == 1 ) {
    //                             $status = CheckOrder::PAID;
    //                             $updateStatus = $order->updateStatus($getOrder['id'],$status);
    //                             $deleteCart = $cart->deleteCartUserId(Auth::getUser('user')['id']);
                                
    //                             return redirect('order/detail');

    //                         } else if($Status == 2) {
    //                             return redirect('order');
    //                         }
    //                         //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
    //                         //
    //                         //
    //                         //
    //                         //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
    //                         $returnData['RspCode'] = '00';
    //                         $returnData['Message'] = 'Confirm Success';
    //                     } else {
    //                         $returnData['RspCode'] = '02';
    //                         $returnData['Message'] = 'Order already confirmed';
    //                     }
    //                 }
    //                 else {
    //                     $returnData['RspCode'] = '04';
    //                     $returnData['Message'] = 'invalid amount';
    //                 }
    //             } else {
    //                 $returnData['RspCode'] = '01';
    //                 $returnData['Message'] = 'Order not found';
    //             }
    //         } else {
    //             $returnData['RspCode'] = '97';
    //             $returnData['Message'] = 'Invalid signature';
    //         }
    //     } catch (Exception $e) {
    //         $returnData['RspCode'] = '99';
    //         $returnData['Message'] = 'Unknow error';
    //     }
    //     //Trả lại VNPAY theo định dạng JSON
    //     echo json_encode($returnData);
    // }





 