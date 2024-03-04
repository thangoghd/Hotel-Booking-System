<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      

    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> - Danh sách đặt phòng</title>

</head>

<body class="bg-light">

    <?php 
      require('inc/header.php');
      if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)) redirect('index.php');
    ?>

    <!-- Phòng khách sạn -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
          <h2 class="fw-bold"> ĐƠN ĐẶT PHÒNG</h2>
          <div style="font-size: 14px">
            <a href="index.php" class="text-secondary text-decoration-none">TRANG CHỦ</a>
            <span class="text-secondary"> > </span>
            <a href="rooms.php" class="text-secondary text-decoration-none">ĐƠN ĐẶT PHÒNG</a>
          </div>
        </div>
        <?php
          $query = "SELECT momo.*, bd.* FROM `momo_table` momo INNER JOIN `booking_details_table` bd ON momo.id = bd.booking_id 
          WHERE (momo.user_id=?)
          ORDER BY momo.id ASC";

          $result = select($query, [$_SESSION['uId']], 'i');
          while($data = mysqli_fetch_assoc($result))
          {
            $date = date("d-m-Y", strtotime($data['datetime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

            $status_bg = "";
            $btn = "";
            $receive ="";
            $receive_bg ="";
            if($data['refund'] == "") $status = 'Đã đặt';
            else if($data['refund'] == "0") $status = 'Đang yêu cầu hoàn tiền';
            else if($data['refund'] == "1") $status = 'Đã hoàn tiền';

            $price = number_format($data['price'], 0, ".", ".");

            $amount = number_format($data['amount'], 0, ".", ".");

            if($data['refund'] == "")
            {
              $status_bg = "bg-success";
              if($data['arrival'] == 1)
              {
                $receive = "Đã nhận phòng";
                $receive_bg = "bg-success";
                $btn = " <a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>
                Tải biên lai xuống
                </a>
                <button type='button' class='btn btn-dark btn-sm shadow-none'>
                Đánh giá
                </button>
                ";
              }
              else{
                $receive = "Chưa nhận phòng";
                $receive_bg = "bg-dark";
                $btn = "<button onclick='refund_booking($data[booking_id])' type='button'class='btn btn-danger btn-sm shadow-none' >
                Huỷ
                </button>";
              }
            }

            else if($data['refund'] == "0")
            {
              $status_bg = "bg-danger";
              $btn = "<span class='badge bg-primary'>Đang trong quá trình hoàn tiền</span>";
            }
            else if($data['refund'] == "1")
            {
              $status_bg = "bg-warning";
              $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>
              Tải xuống
              </a>";
            }
            echo <<< bookings
            <div class='col-md-4 px-4 mb-4'>
              <div class='bg-white p-3 rounded shadow-sm'>
                <h5 class='fw-bold'>$data[room_name]</h5>
                <p>$price VND / đêm</p>
                <p>
                  <b>Ngày nhận: </b> $checkin <br>
                  <b>Ngày trả: </b> $checkout
                </p>
                <p>
                  <b>Tổng: </b> $amount VND<br>
                  <b>ID đơn đặt: </b> $data[order_id]<br>
                  <b>Ngày đặt: </b> $date
                </p>
                <p>
                  <span class='badge $status_bg'>
                    $status
                  </span>
                  <span class='badge $receive_bg'>
                    $receive
                  </span>
                </p>
                $btn
              </div>
            </div>
            bookings;
          }
        ?>
      </div>
    </div>
    <?php
      if(isset($_GET['cancel_status'])) alert('success', 'Yêu cầu hoàn tiền đã được gửi!');
    ?>
    <?php require('inc/footer.php')?>
    <script>
        function refund_booking(id)
        {
          if (confirm('Bạn có muốn hoàn tiền lại đơn đặt?'))
          {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/refund_booking_crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function()
            {
              console.log(this.responseText);
              if(this.responseText == 1) window.location.href = "bookings.php?cancel_status=true";
              else alert('error', 'Lỗi không xác định');
            }

            xhr.send('refund_booking&id='+id);
          }
        }
    </script>
  </body>
</html>