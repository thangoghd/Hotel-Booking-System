<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    
  <!-- Use Swiper from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <?php require('inc/links.php')?>
  <style>
    .box{
      border-top-color: var(--teal) !important;
    }
  </style>
  <title><?php echo $settings_r['site_title']?> - Về chúng tôi</title> 
</head>

<body class="bg-light">

  <?php require('inc/header.php')?>
  <!-- Về chúng tôi -->
  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">VỀ CHÚNG TÔI</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
      Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
      Itaque architecto ipsum quae beatae, laboriosam voluptate maxime recusandae id, <br>doloremque esse soluta molestiae. 
      Incidunt assumenda quas enim iusto. Saepe, velit doloribus.
    </p>
  </div>
  
  <div class="cotainer">
    <div class="row justify-content-between align-items-center p-5">
      <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
        <h3 class="mb-3">Lorem ipsum dolor sit amet.</h3>
        <p>
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
          In eos odit non aperiam voluptates ex, voluptatibus cupiditate vero illo harum.
        </p>
      </div>
      <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
        <img src="images/about/about.jpg" class="w-100">
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/hotel.svg" width="70px">
          <h4 class="mt-3">+100 Phòng</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/customers.svg" width="70px">
          <h4 class="mt-3">+200 Khách</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/rating.svg" width="70px">
          <h4 class="mt-3">+150 Lượt đánh giá</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/staff.svg" width="70px">
          <h4 class="mt-3">+100 Nhân viên khách sạn</h4>
        </div>
      </div>
      </div>
    </div>
  </div>
  <h3 class="my-5 fw-bold h-font text-center">Đội ngũ quản lý</h3>
  <div class="container px-4">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper mb-5">
        <?php
          $about_r = selectAll('management_members_table');
          $path = ABOUT_IMG_PATH;
          while($row = mysqli_fetch_assoc($about_r)){
            echo<<<data
              <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                <img src="$path$row[picture]" class="w-100">
                <h5 class="mt-2">$row[name]</h5>
              </div>
            data;
          }
        ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  
  </div>
  <?php require('inc/footer.php')?>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView:4,
      spaceBetween: 40,
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
            slidesPerView: 1,
        },
        640: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    }
    });
  </script>
</body>
</html>