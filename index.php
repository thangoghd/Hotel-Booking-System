<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> - Home</title>  
    
  <!-- Use Swiper from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    

</head>

<body class="bg-light">

  <?php require('inc/header.php')?>
    <!-- Hiệu ứng băng truyền -->
    <div class="container-fluid px-lg-4 mt-4">
      <div class="swiper swiper-container">
        <div class="swiper-wrapper">
          <?php 
            $res = selectAll('carousel_table');
            while($row = mysqli_fetch_assoc($res))
            {
                $path = CAROUSEL_IMG_PATH;
                echo <<<data
                  <div class="swiper-slide">
                    <img src="$path$row[image]" class="w-100 d-block" />
                  </div>
                data;
            }
          ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    <!-- Kiểm tra tình trạng còn phòng -->
    <div class="container availability-form">
      <div class="row">
        <div class="col-lg-12 bg-white shadow p-4 rounded">
          <h5 class="mb-4">Kiểm tra phòng nào phù hợp với bạn.</h5> 
          <form>
            <div class="row align-items-end">
              <div class="col-lg-3 mb-3">
                <label class="form-label" style="font-weight: 500;">Nhận phòng</label>
                <input type="date" class="form-control shadow-none">
              </div>
              <div class="col-lg-3 mb-3">
                <label class="form-label" style="font-weight: 500;">Trả phòng</label>
                <input type="date" class="form-control shadow-none">
              </div>
              <div class="col-lg-3 mb-3">
                <label class="form-label" style="font-weight: 500;">Người lớn</label>
                <select class="form-select" aria-label="Default select example">
                  <option value="1">Một</option>
                  <option value="2">Hai</option>
                  <option value="3">Ba</option>
                </select>
              </div>
              <div class="col-lg-2 mb-3">
                <label class="form-label" style="font-weight: 500;">Trẻ em</label>
                <select class="form-select" aria-label="Default select example">
                  <option value="1">Một</option>
                  <option value="2">Hai</option>
                  <option value="3">Ba</option>
                </select>
              </div>
              <div class="col-lg-1 mb-lg-3 mt-2">
                <button type="submit" class="btn text-white shadow-none custom-bg">
                  Chọn
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Xem phòng -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">VỀ PHÒNG CỦA CHÚNG TÔI</h2>
    <div class="container">
      <div class="row">
          <?php
          $room_res = select("SELECT * FROM `rooms_table` WHERE `status` = ? AND `removed` = ?", [1, 0], 'ii');
          while ($room_data = mysqli_fetch_assoc($room_res)) 
          {
            $formattedPrice = number_format($room_data['price'], 0, ".", ".");       
            //get features
            $fea_q  = mysqli_query($con, "SELECT f.name FROM `features_table` f INNER JOIN `rooms_features_table` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");

            $features_data = "";
            while ($fea_row = mysqli_fetch_assoc($fea_q))
            {
              $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>
                $fea_row[name]
              </span>";
            }


            //get facilities
            $fac_q  = mysqli_query($con, "SELECT f.name FROM `facilities_table` f INNER JOIN `rooms_facilities_table` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
            $facilities_data = "";
            while ($fac_row = mysqli_fetch_assoc($fac_q))
            {
              $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>
                $fac_row[name]
              </span>";
            }

            //get thumbnail of images
            $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
            $thumb_q = mysqli_query($con, "SELECT *FROM `room_images_table` WHERE `room_id` = '$room_data[id]' AND `thumb` = '1'");
            if(mysqli_num_rows($thumb_q) > 0)
            {
              $thumb_res = mysqli_fetch_assoc($thumb_q);
              $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
            }

            $book_btn = "";
            if(!$settings_r['shutdown'])
            {
              $login = 0;
              if(isset($_SESSION['login']) && $_SESSION['login'] == true)
              {
                $login = 1;
              }

              $book_btn = "<button onclick='checkLoginToBook($login, $room_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Đặt ngay</button>";
            }

            //print room card
            echo <<< data
              <div class="col-lg-4 col-md-6 my-3">
              <!-- Cards bootstrap -->
              <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                <img src="$room_thumb" class="card-img-top">
                <div class="card-body">
                  <h5>$room_data[name]</h5>
                  <h6 class="mb-4">$formattedPrice VND / Đêm</h6>
                  <div class="features mb-4">
                    <h6 class="mb-1">Tiện nghi phòng</h6>
                    $features_data
                  </div>
                  <div class="facilities mb-4">
                    <h6 class="mb-1">Tiện ích chính</h6>
                    $facilities_data
                  </div>
                  <div class="guests mb-4">
                    <h6 class="mb-1">Số khách</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                      $room_data[adult] Người lớn
                    </span>
                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                      $room_data[children] Trẻ em
                    </span>
                  </div>
                  <div class="rating mb-4">
                    <h6 class="mb-1">Đánh giá</h6>
                    <span class="badge rounded-pill bg-light">
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning"></i>
                    </span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    $book_btn
                    <a href="" class="btn btn-sm btn-outline-dark shadow-none">Xem thêm</a>
    
                  </div>
                </div>
              </div>
              
            </div>
            data;

          }
          ?> 
        </div>
        <div class="col-lg-12 text-center mt-5">
          <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Xem thêm</a>
        </div>
      </div>
    </div>

    <!-- Tiện ích -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">TRẢI NGHIỆM DỊCH VỤ CỦA CHÚNG TÔI</h2>
    <div class="container">
      <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
        <?php
          $res = mysqli_query($con, "SELECT * FROM `facilities_table` ORDER BY `id` DESC LIMIT 5");
          $path = FACILITIES_IMG_PATH;

          while ($row = mysqli_fetch_assoc($res)) {
            echo <<< data
            <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
              <img src="$path$row[icon]" width="60px">
              <h5 class="mt-3">$row[name]</h5>
            </div>
            data;
          }
        ?>
      </div>
    </div>

    <!-- Xác thực chất lượng khách sạn-->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">TỪ NHỮNG NGƯỜI TỪNG TRẢI NGHIỆM</h2>
    <div class="container mt-5">
      <div class="swiper swiper-testimonials">
        <div class="swiper-wrapper mb-5">
          <div class="swiper-slide bg-white p-4">
            <div class="profile d-flex align-items-center mb-3">
              <img src="images/about/rating.svg" width="30px">
              <h6 class="m-0 ms-2">Người dùng 1</h6>
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
          <div class="swiper-slide bg-white p-4">
            <div class="profile d-flex align-items-center mb-3">
              <img src="images/about/rating.svg" width="30px">
              <h6 class="m-0 ms-2">Người dùng 2</h6>
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
          <div class="swiper-slide bg-white p-4">
            <div class="profile d-flex align-items-center mb-3">
              <img src="images/about/rating.svg" width="30px">
              <h6 class="m-0 ms-2">Người dùng 3</h6>
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
        <div class="swiper-pagination"></div>
      </div>
      
      <div class="col-lg-12 text-center">
        <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Xem thêm</a>
      </div>
    </div>

    <!-- Liên lạc với chúng tôi -->
    <?php 
      $contact_p = "SELECT * FROM contact_table WHERE id=?";
      $values = [1];
      $contact_r = mysqli_fetch_assoc(select($contact_p, $values, 'i'));
    ?>

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">LIÊN HỆ CHÚNG TÔI</h2>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white">
          <iframe class="w-100 rounded" height="320" src="<?php echo $contact_r['iframe']?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="bg-white p-4 rounded mb-4">
            <h5>Gọi cho chúng tôi</h5>
            <a href="Tel: +<?php echo $contact_r['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
              <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1']?>
            </a>
            <br>
            <?php
              if($contact_r['pn2'] != '' ) 
              {
                echo <<<data
                  <a href="Tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
                    <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                  </a>
                data;
              }
            ?>

          </div>
          <div class="bg-white p-4 rounded mb-4">
            <h5>Theo dõi chúng tôi</h5>
            <a href="<?php echo $contact_r['fb']?>" class="d-inline-block mb-3" target="_blank">
              <span class="badge bg-light text-dark fs-6 p-2">
                <i class="bi bi-facebook"></i> Facebook
              </span>
            </a>
            <br>
            <?php 
              if($contact_r['tw'] != ''){
                echo <<<data
                  <a href="$contact_r[tw]" class="d-inline-block mb-3" target="_blank">
                    <span class="badge bg-light text-dark fs-6 p-2">
                      <i class="bi bi-twitter"></i> Twitter
                    </span>
                  </a>
                  <br>
                data;
              }

              if($contact_r['insta'] != ''){
                echo <<<data
                  <a href="$contact_r[insta]" class="d-inline-block mb-3" target="_blank">
                    <span class="badge bg-light text-dark fs-6 p-2">
                      <i class="bi bi-instagram"></i> Instagram
                    </span>
                  </a>
                  <br>
                data;
              }
            ?>
          </div>
        </div>
      </div>
    </div>

    <?php require('inc/footer.php')?>
    <!--Bundle bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script src="js/effect-fade.js"></script>
    <script src="js/cover-flow.js"></script>
  </body>
</html>