<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> - Liên hệ</title>  

</head>

<body class="bg-light">

    <?php require('inc/header.php')?>
    <!-- Tiện ích khách sạn -->
    <div class="my-5 px-4">
      <h2 class="fw-bold h-font text-center">LIÊN HỆ VỚI CHÚNG TÔI</h2>
      <div class="h-line bg-dark"></div>
      <p class="text-center mt-3">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
        Itaque architecto ipsum quae beatae, laboriosam voluptate maxime recusandae id, <br>doloremque esse soluta molestiae. 
        Incidunt assumenda quas enim iusto. Saepe, velit doloribus.
      </p>
    </div>

    <?php
      $contact_p = "SELECT * FROM contact_table WHERE id=?";
      $values = [1];
      $contact_r = mysqli_fetch_assoc(select($contact_p, $values, 'i'));
    ?>
    

    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 mb-5 px-4">
          <div class="bg-white rounded shadow p-4">
            <iframe class="w-100 rounded" height="320" 
            src="<?php echo $contact_r['iframe']?>" 
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <h5 class="mt-4">Địa chỉ</h5>

            <a href="<?php echo $contact_r['gmap']?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                <i class="bi bi-geo-alt-fill"></i><?php echo $contact_r['address']?>
            </a>

            <h5 class="mt-4">Gọi cho chúng tôi</h5>

            <a href="Tel: +<?php echo $contact_r['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
            <i class="bi bi-telephone-fill"></i>+<?php echo $contact_r['pn1']?>
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

            <h5 class="mt-4">Email</h5>

            <a href="mailto: <?php echo $contact_r['email']?>" class="d-inline-block text-decoration-none text-dark mb-2">
                <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email']?>
            </a>

            <h5 class="mt-4">Theo dõi chúng tôi</h5>
            <a href="<?php echo $contact_r['fb']?>" class="d-inline-block mb-3 text-dark fs-5 me-2" target="_blank" title="Theo dõi trên Facebook">
                <i class="bi bi-facebook"></i>
            </a>
            <?php 
              if($contact_r['tw'] != ''){
                echo <<<data
                  <a href="$contact_r[tw]" class="d-inline-block mb-3 text-dark fs-5 me-2" target="_blank" title="Theo dõi trên Twitter">
                      <i class="bi bi-twitter"></i>
                  </a>
                data;
              }

              if($contact_r['insta'] != ''){
                echo <<<data
                  <a href="$contact_r[insta]" class="d-inline-block mb-3 text-dark" target="_blank"  title="Theo dõi trên Instagram">
                      <i class="bi bi-instagram"></i>
                  </a>
                data;
              }
              
            ?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 px-4">
          <div class="bg-white rounded shadow p-4">
            <form method="POST">
                <h5>Gửi tin nhắn</h5>               
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 500;">Tên</label>
                    <input name="name" required type="text" class="form-control shadow-none">
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 500;">Email</label>
                    <input name="email" requiredtype="email" class="form-control shadow-none">
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 500;">Chủ đề</label>
                    <input name="subject" requiredtype="text" class="form-control shadow-none">
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 500;">Lời nhắn</label>
                    <textarea name="message" required class="form-control shadow-none" rows="10" style="resize: none;"></textarea>
                </div>
                <div style="text-align: right;">
                    <button type="submit" name="send" class="btn text-white custom-bg mt-3">
                        Gửi
                    </button>
                </div>

            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
      if(isset($_POST['send']))
      {
        $frm_data = filteration($_POST);

        $q ="INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?, ?, ?, ?)";
        $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'],$frm_data['message']];
        $res = insert($q, $values, 'ssss');

        if($res == 1)
        {
          alert('success', 'Message sent!');
        }
        else alert('error','Unknown error!');
      }
    ?>
    <?php require('inc/footer.php')?>
  </body>
</html>