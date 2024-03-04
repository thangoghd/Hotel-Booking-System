<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      

    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> - Tình trạng đặt phòng </title>

</head>

<body class="bg-light">
    <?php require('inc/header.php')?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">THÔNG BÁO ĐẶT PHÒNG</h2>
            </div>

            <?php
                if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) redirect('index.php');


                date_default_timezone_set("Asia/Ho_Chi_Minh");
                if(isset($_GET['partnerCode']))
                {
                    $partnerCode=$_GET['partnerCode'];
                    $orderId=$_GET['orderId'];
                    $userId = $_SESSION['uId'];
                    $roomId = $_SESSION['room']['id'];
                    $amount=$_GET['amount'];
                    $orderInfo=$_GET['orderInfo'];
                    $orderType=$_GET['orderType'];
                    $transId=$_GET['transId'];
                    $resultCode = $_GET['resultCode'];
                    $payType=$_GET['payType'];
                    $codeCart= rand(0, 9999);

                    if(isset($_POST['pay_atm']))
                    {
                        echo $frm_data['checkin'], $frm_data['checkout'];
                    }

                    if($resultCode == '0')
                    {
                        $frm_data = filteration($_POST);
                        // Ghi dữ liệu vào bảng momo_table
                        $query1 = "INSERT INTO `momo_table`(`partner_code`, `order_id`, `user_id`, `room_id`, `amount`, `check_in`, `check_out`, `order_info`, `order_type`, `trans_id`, `pay_type`, `code_cart`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        insert($query1, [$partnerCode, $orderId, $userId, $roomId, $amount, $_SESSION['checkin'], $_SESSION['checkout'], $orderInfo, $orderType, $transId, $payType, $codeCart], 'siiisssssiss');

                        
                        $booking_id = mysqli_insert_id($con);
                        // Ghi dữ liệu vào bảng booking_details_table
                        $query2 = "INSERT INTO `booking_details_table`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";  
                        
                        insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $amount, $_SESSION['name'], $_SESSION['phonenum'], $_SESSION['address']], 'isiisss');


                        echo<<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-success">
                            <i class="bi bi-check-cỉcle-fill"></i>Đặt phòng thành công!
                            <br>
                            <a href='bookings.php'>Đi đến đặt phòng</a>
                            </p>
                        </div>
                        data;
                    }
                    else if ($resultCode == '1006')   
                    echo<<<data
                    <div class="col-12 px-4">
                        <p class="fw-bold alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>Giao dịch được từ chối bởi bạn!
                        <br>
                        <a href='bookings.php'>Đi đến đặt phòng</a>
                        </p>
                    </div>
                    data;

                    else
                    echo<<<data
                    <div class="col-12 px-4">
                        <p class="fw-bold alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>Lỗi không xác định trong quá trình giao dịch!
                        <br>
                        <a href='bookings.php'>Đi đến đặt phòng</a>
                        </p>
                    </div>
                    data;
                }
            ?>
        </div>
    </div>
    <?php require('inc/footer.php')?>
</body>
</html>