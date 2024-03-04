<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    

    <style>
      .pop:hover{
        border-top-color: var(--teal) !important;
        transform: scale(1.03);
        transition: all 0.3s;
      }
    </style>
    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> - Dịch vụ</title> 
</head>

<body class="bg-light">

    <?php require('inc/header.php')?>
    <!-- Tiện ích khách sạn -->
    <div class="my-5 px-4">
      <h2 class="fw-bold h-font text-center">DỊCH VỤ TRẢI NGHIỆM</h2>
      <div class="h-line bg-dark"></div>
      <p class="text-center mt-3">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
        Itaque architecto ipsum quae beatae, laboriosam voluptate maxime recusandae id, <br>doloremque esse soluta molestiae. 
        Incidunt assumenda quas enim iusto. Saepe, velit doloribus.
      </p>
    </div>
    <div class="container">
      <div class="row">
        <?php
          $res = selectAll('facilities_table');
          $path = FACILITIES_IMG_PATH;

          while ($row = mysqli_fetch_assoc($res)) {
            echo <<< data
              <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                  <div class="d-plex align-items-center mb-2">
                    <img src="$path$row[icon]" width="40px">
                    <h5>$row[name]</h5>
                  </div>
                  <p>
                  $row[decription]
                  </p>
                </div>
              </div>
            data;
          }
        ?>
      </div>

    </div>
    <?php require('inc/footer.php')?>
  </body>
</html>