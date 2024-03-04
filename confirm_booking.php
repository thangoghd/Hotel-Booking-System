<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      

    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> - Xác nhân đặt phòng</title>

</head>

<body class="bg-light">

    <?php require('inc/header.php')?>

    <?php
     //kiểm tra id phòng và hệ thống có đang bao trì hay không?
    if(!isset($_GET['id']) || $settings_r['shutdown'] == true) redirect('rooms.php');
     //Kiểm tra trước đó đã đăng nhập chưa
    else if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) redirect('rooms.php');



    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms_table` WHERE  `id` = ? AND `status` = ? AND `removed` = ?", [$data['id'], 1, 0], 'iii');

    if(mysqli_num_rows($room_res)==0)
    {
      redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

    $_SESSION['room'] = [
      "id" => $room_data['id'],
      "name" => $room_data['name'],
      "price" => $room_data['price'],
      "payment" => null,
      "available" => false,
    ];

    $user_res =  select("SELECT * FROM `user_account_table` WHERE `id` = ? LIMIT 1", [$_SESSION['uId']], "i");

    $user_data = mysqli_fetch_assoc($user_res);

    ?>
    <!-- Phòng khách sạn -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
          <h2 class="fw-bold"><?php echo $room_data['name']?> XÁC NHẬN ĐẶT PHÒNG</h2>
          <div style="font-size: 14px">
            <a href="index.php" class="text-secondary text-decoration-none">TRANG CHỦ</a>
            <span class="text-secondary"> > </span>
            <a href="rooms.php" class="text-secondary text-decoration-none">PHÒNG</a>
            <span class="text-secondary"> > </span>
            <a href="#" class="text-secondary text-decoration-none">XÁC NHẬN</a>
          </div>
        </div>

        <div class="col-lg-7 col-md-12 px-4">
          <?php
            //Lấy ảnh tiêu đề
            $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
            $thumb_q = mysqli_query($con, "SELECT *FROM `room_images_table` WHERE `room_id` = '$room_data[id]' AND `thumb` = '1'");
            if(mysqli_num_rows($thumb_q) > 0)
            {
              $thumb_res = mysqli_fetch_assoc($thumb_q);
              $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
            }

            echo<<<data
            <div class="card p-3 shadow-sm rounded">
              <img src="$room_thumb" class="img-fluid rounded">
              <h5>$room_data[name]</h5>
              <h5>$room_data[price]</h5>
            </div>
            data;
          ?>

        </div>
        <div class="col-lg-5 col-nd-12 px-4" >
          <div class="card mb-4 border-0 shadow-sm rounded-3">
            <div class="card-body">
              <form action="" method="POST"  id="booking-form">
                <h6 class="mb-3">BOOKING DETAILS</h6>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Tên</label>
                    <input name="name" type="text" value="<?php echo $user_data['name']?>" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input name="phonenum" type="text" value="<?php echo $user_data['phonenum']?>" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $user_data['address']?></textarea>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Nhận phòng</label>
                    <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Trả phòng</label>
                    <input name="checkout" onchange="check_availability()"  type="date" class="form-control shadow-none" required>
                  </div>
                  <?php

                  ?>
                  <div class="col-12">
                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                    <h6 class="text-danger mb-3" id="pay_info"> Vui lòng cung cấp ngày nhận phòng và ngày rời phòng.</h6>
                    <button name="pay_qr" class="btn w-100 text-white custom-bg shadow-none mb-1" onclick="updateAction('momoqrcodepayment.php')"  disabled>Thanh toán qua MOMO mã QR</button>
                    <button name="pay_atm" class="btn w-100 text-white custom-bg shadow-none mb-1" onclick="updateAction('momoatmpayment.php')"  disabled>Thanh toán qua MOMO ATM</button>
                    <input type="hidden" value="" name="amount" id="amount_input">
                  </div>                  
                </div>
              </form>
            </div>
          </div>
        </div> 
      </div>

    </div>
    <?php require('inc/footer.php')?>
    <script>
    let booking_form = document.getElementById('booking-form');
    let info_loader =document.getElementById('info_loader');
    let pay_info =document.getElementById('pay_info');

    let pay_form =document.getElementById('pay-form');
    let amount_input = document.getElementById('amount_input');



    function check_availability()
    {
      let checkin_val =booking_form.elements['checkin'].value;
      let checkout_val =booking_form.elements['checkout'].value;

      booking_form.elements['pay_qr'].setAttribute('disable', true);
      booking_form.elements['pay_atm'].setAttribute('disable', true);

      if(checkin_val != '' && checkout_val != '')
      {
        pay_info.classList.add('d-none');
        pay_info.classList.replace('text-dark', 'text-danger');
        info_loader.classList.remove('d-none');

        let data = new FormData();
        data.append('check_availability', '');
        data.append('check_in', checkin_val);
        data.append('check_out', checkout_val);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/confirm_booking_crud.php", true);

        xhr.onload =function()
        {
          let data = JSON.parse(this.responseText);
          if(data.status == 'check_in_out_equal')pay_info.innerText = "Không thể đặt ngày nhận phòng và ngày rời đi trùng nhau!";
          else if(data.status == 'check_out_earlier')pay_info.innerText = "Không thể đặt ngày rời đi trước ngày nhận phòng!";
          else if(data.status == 'check_in_earlier')pay_info.innerText = "Không thể đặt ngày nhận phòng trước thời điểm hiện tại!";
          else{
            pay_info.innerHTML = "Số đêm: "+data.days+"<br>Tổng phí phòng: "+data.payment.toLocaleString("vi-VN")+" VND";
            pay_info.classList.replace('text-danger', 'text-dark');
            booking_form.elements['pay_qr'].removeAttribute('disabled');
            booking_form.elements['pay_atm'].removeAttribute('disabled');
          }
          pay_info.classList.remove('d-none');
          info_loader.classList.add('d-none');

          amount_input.value = data.payment.toString();
          var encodedAmount = btoa(amount_input.value);
  
          // Gán giá trị đã mã hóa vào input
          document.getElementById('amount_input').value = encodedAmount;
        }
        xhr.send(data);
      }
    }    
    function updateAction(newAction) {
      document.getElementById('booking-form').action = newAction;
    }

    </script>
  </body>
</html>