<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      

    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> - Chi tiết phòng</title>

</head>

<body class="bg-light">

    <?php require('inc/header.php')?>

    <?php
    if(!isset($_GET['id'])) redirect('rooms.php');
    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms_table` WHERE  `id` = ? AND `status` = ? AND `removed` = ?", [$data['id'], 1, 0], 'iii');

    if(mysqli_num_rows($room_res)==0)
    {
      redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);
    ?>
    <!-- Phòng khách sạn -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
          <h2 class="fw-bold"><?php echo $room_data['name']?></h2>
          <div style="font-size: 14px">
            <a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a>
            <span class="text-secondary"> > </span>
            <a href="rooms.php" class="text-secondary text-decoration-none">Phòng</a>
          </div>
        </div>

        <div class="col-lg-7 col-md-12 px-4">
          <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php
                $room_img = ROOMS_IMG_PATH."thumbnail.jpg";
                $img_q = mysqli_query($con, "SELECT *FROM `room_images_table` WHERE `room_id` = '$room_data[id]'");
                if(mysqli_num_rows($img_q) > 0)
                {
                  $active_class = 'active';
                  while($img_res = mysqli_fetch_assoc($img_q))
                  {
                    echo"
                    <div class='carousel-item $active_class'>
                      <img src='".ROOMS_IMG_PATH.$img_res['image']."' class='d-block w-100 rounded'>
                    </div>";
                    $active_class='';
                  }
                }
                else echo"<div class='carousel-item active'>
                  <img src='$room_img' class='d-block w-100'>
                </div>";
              ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>

        <div class="col-lg-5 col-nd-12 px-4" >
          <div class="card mb-4 border-0 shadow-sm rounded-3">
            <div class="card-body">
              <?php
              echo <<< price
                <h4 class="">$room_data[price] VND một đêm</h6>
              price;
              echo <<< rating
                <div class="rating mb-3">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                </div>
              rating;


              //get features
              $fea_q  = mysqli_query($con, "SELECT f.name FROM `features_table` f INNER JOIN `rooms_features_table` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");

              $features_data = "";
              while ($fea_row = mysqli_fetch_assoc($fea_q))
              {
                $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                  $fea_row[name]
                </span>";
              }
              echo <<< features
              <div class="mb-3">
              <h6 class="mb-2">Tiện nghi phòng</h6>
              $features_data
              </div>
              features;

              //get facilities
              $fac_q  = mysqli_query($con, "SELECT f.name FROM `facilities_table` f INNER JOIN `rooms_facilities_table` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
              $facilities_data = "";
              while ($fac_row = mysqli_fetch_assoc($fac_q))
              {
                $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 '>
                  $fac_row[name]
                </span>";
              }
              echo <<< facilities
              <div class="facilities mb-3">
                <h6 class="mb-1">Tiện ích chính</h6>
                $facilities_data
              </div>
              facilities;

              echo <<< guests
              <div class="guests mb-3">
                <h6 class="mb-1">Số khách</h6>
                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">
                  $room_data[adult] Người lớn
                </span>
                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">
                  $room_data[children] Trẻ em
                </span>
              </div>
              guests;

              echo <<< area
              <div class="guests mb-3">
                <h6 class="mb-1">Tầng</h6>
                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">
                  $room_data[area]
                </span>
              </div>
              area;

              $book_btn = "";
              if(!$settings_r['shutdown'])
              {
              $login = 0;
              if(isset($_SESSION['login']) && $_SESSION['login'] == true)
              {
                $login = 1;
              }

              
                echo <<< book
                <button onclick='checkLoginToBook($login, $room_data[id])' class='btn w-100 btn-sm text-white custom-bg shadow-none'>Đặt ngay</button>
                book;
              }


              ?>
            </div>
          </div>
        </div>

        <div class="col-12 mt-4 px-4">
          <div class="mb-5">
            <h5>Mô tả</h5>
            <?php
            echo $room_data['decription'];
            ?>
          </div>
          <div>
            <h5>Đánh giá</h5>
            <div>
            <div class="profile d-flex align-items-center mb-2">
              <img src="images/about/rating.svg" width="30px">
              <h6 class="m-0 ms-2">Random user1</h6>
            </div>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod iusto nesciunt molestiae sint totam tempora facilis. Laboriosam similique modi repudiandae.
            </p>
            <div class="rating">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
            </div>
            </div>
          </div>
        </div>
        
      </div>

    </div>
    <?php require('inc/footer.php')?>
  </body>
</html>