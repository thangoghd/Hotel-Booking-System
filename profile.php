<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      

    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> - Hồ sơ</title>

</head>

<body class="bg-light">

    <?php 
      require('inc/header.php');
      if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)) redirect('index.php');
      $u_exist = select("SELECT * FROM `user_account_table` WHERE `id` = ? LIMIT 1", [$_SESSION['uId']], 'i');

      if(mysqli_num_rows($u_exist) == 0) redirect('index.php');
      $u_fectch = mysqli_fetch_assoc($u_exist);
    ?>

    <!-- Phòng khách sạn -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
          <h2 class="fw-bold"> HỒ SƠ</h2>
          <div style="font-size: 14px">
            <a href="index.php" class="text-secondary text-decoration-none">TRANG CHỦ</a>
            <span class="text-secondary"> > </span>
            <a href="rooms.php" class="text-secondary text-decoration-none">HỒ SƠ</a>
          </div>
        </div>
        <div class="col-12 mb-5 px-4">
          <div class="bg-white p-3 p-md-4 rounded shadow-sm">
            <form id="info-form">
              <h5 class="mb-3 fw-bold ">Thông tin cá nhân</h5>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Tên</label>
                  <input name="name" type="text" value="<?php echo $u_fectch['name']?>" class="form-control shadow-none " required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Số điện thoại</label>
                  <input name="phonenum" type="number" value="<?php echo $u_fectch['phonenum']?>" class="form-control shadow-none" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Ngày sinh</label>
                  <input name="birthdate" type="date" value="<?php echo $u_fectch['birthdate']?>" class="form-control shadow-none" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Mã bưu chính</label>
                    <input name="pincode" type="number" value="<?php echo $u_fectch['pincode']?>" class="form-control shadow-none" required>
                </div>
                <div class="col-md-8 mb-3">
                    <label for="form-label" class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $u_fectch['address']?></textarea>
                </div>
                <button type="submit" class="btn text-white custom-bg shadow-none">Lưu thay đổi</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-4 mb-5 px-4">
          <div class="bg-white p-3 p-md-4 rounded shadow-sm">
            <form id="picture-form">
              <h5 class="mb-3 fw-bold ">Ảnh đại diện</h5>
              <img src="<?php echo USERS_IMG_PATH.$u_fectch['picture']?>" class="img-fluid mb-3">
              <br>
              <label class="form-label">Ảnh đại diện mới</label>
              <input name="picture" type="file" accept=".jpg, jpeg, .png, .webp" class="mb-4 form-control shadow-none">
              <button type="submit" class="btn text-white custom-bg shadow-none">Lưu thay đổi</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php require('inc/footer.php')?>
    <script>
        let info_form = document.getElementById('info-form');
        info_form.addEventListener('submit', function(e)
        {
          e.preventDefault();
          let data = new FormData();
          data.append('info_form', '');
          data.append('name', info_form.elements['name'].value);
          data.append('phonenum', info_form.elements['phonenum'].value);
          data.append('birthdate', info_form.elements['birthdate'].value);
          data.append('address', info_form.elements['address'].value);
          data.append('pincode', info_form.elements['pincode'].value);

          let xhr = new XMLHttpRequest();
          xhr.open("POST", "ajax/profile_crud.php", true)
          xhr.onload = function()
          {
            if(this.responseText == 1) alert('success', 'Thay đổi thành công!');
            else if(this.responseText == 0) alert('error', 'Không thể thay đổi!');

          }
          xhr.send(data);
        });

        let picture_form = document.getElementById('picture-form');
        
        picture_form.addEventListener('submit', function(e)
        {
          e.preventDefault();
          let data = new FormData();
          data.append('picture_form', '');
          data.append('picture', picture_form.elements['picture'].files[0]);


          let xhr = new XMLHttpRequest();
          xhr.open("POST", "ajax/profile_crud.php", true)

          
          xhr.onload = function()
          {
            console.log(this.responseText);
            if(this.responseText == 'inv_img') alert('error', "Sai định dạng ảnh!");
            else if(this.responseText == 'upd_failed') alert('error', "Không thể tải lên được ảnh hồ sơ!");
            else if(this.responseText == 1) window.location.href = window.location.pathname;
            else if(this.responseText == 0) alert('error', 'Không thể thay đổi!');
            else alert('error', 'Lỗi không xác định!');
          }
          xhr.send(data);
        });
    </script>
  </body>
</html>