<!-- Footer -->
<?php
    $contact_p = "SELECT * FROM contact_table WHERE id=?";
    $settings_p = "SELECT * FROM settings_table WHERE id=?";

    $values = [1];
    $contact_r = mysqli_fetch_assoc(select($contact_p, $values, 'i'));
    $settings_r = mysqli_fetch_assoc(select($settings_p, $values, 'i'));
?>
<div class="container-fluid bg-white mt-5">
    <div class="row">
    <div class="col-lg-4 p-4">
        <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title']?></h3>
        <p>
        <?php echo $settings_r['site_about']?>
        </p>
    </div>
    <div class="col-lg-4 p-4">
        <h5 class="mb-3">Đường dẫn</h5>
        <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Trang chủ</a> <br>
        <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Phòng</a> <br>
        <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Trải nghiệm</a> <br>
        <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Liên hệ</a> <br>
        <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">Về chúng tôi</a>
    </div>
    <div class="col-lg-4 p-4">
        <h5 class="mb-3">Theo dõi chúng tôi</h5>
        <a href="<?php echo $contact_r['fb']?>" class="d-inline-block text-dark text-decoration-none mb-2" target="_blank"><i class="bi bi-facebook"></i> Facebook</a> <br>
        <?php 
            if($contact_r['tw'] != ''){
            echo <<<data
                <a href="$contact_r[tw]" class="d-inline-block text-dark text-decoration-none mb-2" target="_blank"><i class="bi bi-twitter"></i> Twitter</a> <br>
            data;
            }

            if($contact_r['insta'] != ''){
            echo <<<data
                <a href="$contact_r[insta]" class="d-inline-block text-dark text-decoration-none mb-2" target="_blank"><i class="bi bi-instagram"></i> Instagram</a> <br>
            data;
            }
        ?>
    </div>
    </div>
</div>
<h6 class="text-center bg-dark text-white p-3 m-0">Love you!!!</h6>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>

    function alert(type, message, position='body')
    {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element =document.createElement('div');
        element.innerHTML = `            
            <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
                <strong class="me-3">${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        if (position == 'body')
        {
            document.body.append(element);
            element.classList.add('custom-alert');
        }
        else
        {
            document.getElementById(position).appendChild(element);
        }
        
        setTimeout(remAlert, 3000);
    }

    function remAlert(){
        document.getElementsByClassName('alert')[0].remove();
    }

    function setActive()
    {
        let navbar =document.getElementById('nav-bar');
        let a_tags =navbar.getElementsByTagName('a');

        for (i=0; i<a_tags.length; i++)
        {
            let file = a_tags[i].href.split('/').pop();
            let file_name = file.split('.')[0];

            if(document.location.href.indexOf(file_name)>=0)
            {
                a_tags[i].classList.add('active');
            }
        }
    }

    let register_form =document.getElementById('register-form');
    register_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('username', register_form.elements['username'].value);
        data.append('name', register_form.elements['name'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('phonenum', register_form.elements['phonenum'].value);
        data.append('address', register_form.elements['address'].value);
        data.append('pincode', register_form.elements['pincode'].value);
        data.append('birthdate', register_form.elements['birthdate'].value);
        data.append('pass', register_form.elements['pass'].value);
        data.append('cpass', register_form.elements['cpass'].value);
        data.append('register', '');

    
        var myModal =document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register_crud.php", true);
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function()
        {
            console.log(this.responseText);
            if(this.responseText == 'pass_mismatch')
            {
                alert('error', "Mật khẩu không khớp!")
            }
            else if(this.responseText == 'email_exist') alert('error', "Địa chỉ email đã được đăng ký!");
            else if(this.responseText == 'uname_exist') alert('error', "Tên tài khoản này đã được đăng ký!");
            else if(this.responseText == 'inv_img') alert('error', "Sai định dạng ảnh!");
            else if(this.responseText == 'upd_failed') alert('error', "Không thể tải lên được ảnh hồ sơ!");
            else if(this.responseText == 'mail_failed') alert('error', "Không thể gửi liên kết tới email của bạn!");
            else if(this.responseText == 'insert_failed') alert('error', "Đăng ký không thành công!");
            else 
            {
                alert('success', "Đăng ký thành công. Xác nhận liên kết được gửi đến email của bạn!");
                register_form.reset();
            }
        }
        xhr.send(data);
    });
    
    let login_form =document.getElementById('login-form');
    login_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('user_email', login_form.elements['user_email'].value);
        data.append('password', login_form.elements['password'].value);

        data.append('login', '');

    
        var myModal =document.getElementById('loginModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register_crud.php", true);

        xhr.onload = function()
        {
            if(this.responseText == 'inv_name_email')
            {
                alert('error', "Sai tên tài khoản hoặc địa chỉ email!")
            }
            else if(this.responseText == 'not_verified') alert('error', "Tài khoản này chưa được xác thực");
            else if(this.responseText == 'inactive') alert('error', "Tài khoản này bị cấm khỏi hệ thống do vi phạm chính sách!");
            else if(this.responseText == 'invalid_pass') alert('error', "Sai mật khẩu!");
            else if(this.responseText == 1)
            {
                let file_url = window.location.href.split('/').pop().split('?').shift();
                if (file_url == 'room_details.php') window.location =window.location.pathname;
                else window.location =window.location.pathname;
                login_form.reset();
            }
            else 
            {
                alert('error', "Lỗi không xác định!");
            }
        }
        xhr.send(data);
    });

    let forgot_form =document.getElementById('forgot-form');
    login_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('email', login_form.elements['email'].value);
        data.append('forgot_pass', '');

    
        var myModal =document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register_crud.php", true);

        xhr.onload = function()
        {
            console.log(this.responseText);
            // if(this.responseText == 'inv_name_email')
            // {
            //     alert('error', "Incorrect username or email!")
            // }
            // else if(this.responseText == 'not_verified') alert('error', "Account has been not not verified!");
            // else if(this.responseText == 'inactive') alert('error', "The account has been banned from our system!");
            // else if(this.responseText == 'invalid_pass') alert('error', "Wrong password!");
            // else if(this.responseText == 1)
            // {
            //     window.location =window.location.pathname;
            //     login_form.reset();
            // }
            // else 
            // {
            //     alert('error', "Lỗi không xác định!");
            // }
        }
        xhr.send(data);
    });

    function checkLoginToBook(status, room_id)
    {
        if(status) window.location.href = 'confirm_booking.php?id='+room_id;
        else alert('error', 'Vui lòng đăng nhập để thực hiện đặt phòng!')
    }



    setActive();
</script>