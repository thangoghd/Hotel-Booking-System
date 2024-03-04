<?php
    require("../admin/inc/db_config.php");
    require("../admin/inc/essentials.php");
    require("../inc/sendgrid/sendgrid-php.php");

    function send_mail($email, $name, $token)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("thang86082@st.vimaru.edu.vn","HB WEBSITE");
        $email->setSubject("Account verification link");
        $email->addTo($email, $name);
        $email->addContent(
            "",
            "Click to confirm your email:<br>
            <a href='".SITE_URL."email_confirm.php?email=$email&token=$token"."'>Click me.</a>
            "
        );
        $sendgird = new \SendGrid(SENDGRIP_API_KEY);
        if($sendgird->send($email))
        {
            return 1;
        }
        else return 0;
    }

    if(isset($_POST['register']))
    {
        $data = filteration($_POST);

        if($data['pass'] != $data['cpass'])
        {
            echo 'pass_mismatch';
            exit;
        }
        //Kiểm tra tên tài khoản và email đã tồn tại trước đó hay chưa
        $u_exist = select("SELECT * FROM `user_account_table` WHERE `email` = ? OR `user_name` = ? LIMIT 1", [$data['email'], $data['username']], "ss");
        if(mysqli_num_rows($u_exist) != 0)
        {
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);

            echo ($u_exist_fetch['email'] == $data['email']) ? 'email_exist' : 'uname_exist';
            exit;
        }
        
        //Tải lên ảnh đại diện của tài khoản
        // $img = uploadUserImage($_FILES['picture']);
        // if($img == 'inv_img')
        // {
        //     echo 'inv_img';
        //     exit;
        // }
        // else if($img == 'upd_failed')
        // {
        //     echo 'update failed';
        //     exit;
        // }

        //Gửi đường dẫn xác thực tới email
        // $token = bin2hex(random_bytes(16));
        // if(!send_mail($data['email'], $data['name'], $token))
        // {
        //     echo 'mail_failed';
        //     exit;
        // }

        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);
        $token = 0;

        $query = "INSERT INTO `user_account_table`( `user_name`, `name`, `email`, `address`, `phonenum`, `pincode`, `birthdate`, `password`, `token`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $values = [$data['username'], $data['name'], $data['email'], $data['address'], $data['phonenum'], $data['pincode'], $data['birthdate'], $enc_pass, $token];

        if(insert($query, $values, 'sssssssss')) echo 1;
        else echo 'insert_failed!';
        

    }

    if(isset($_POST['login']))
    {
        $data = filteration($_POST);

        $u_exist = select("SELECT * FROM `user_account_table` WHERE `user_name` = ? OR `email` = ? LIMIT 1", [$data['user_email'], $data['user_email']], "ss");
        if(mysqli_num_rows($u_exist) == 0)
        {
            echo 'inv_name_email';
            exit;
        }
        

        else
        {
            $u_fectch = mysqli_fetch_assoc($u_exist);
            if($u_fectch['is_verified'] == 0) echo 'not_verified';
            else if($u_fectch['status'] == 0) echo 'inactive';
            else
            {
                if(!password_verify($data['password'], $u_fectch['password'])) echo 'invalid_pass';
                else
                {
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uId'] = $u_fectch['id'];
                    $_SESSION['uName'] = $u_fectch['name'];
                    $_SESSION['uPic'] = $u_fectch['picture'];
                    $_SESSION['uPhone'] = $u_fectch['phonenum'];
                    echo 1;
                }
            }
        }
    }

    if(isset($_POST['forgot_pass']))
    {
        $data = filteration($_POST);

        $u_exist = select("SELECT * FROM `user_account_table` WHERE `email` = ? LIMIT 1", [$data['email']], "s");
        if(mysqli_num_rows($u_exist) == 0)
        {
            echo 'inv_email';
        }
        

        else
        {
            $u_fectch = mysqli_fetch_assoc($u_exist);
            if($u_fectch['is_verified'] == 0) echo 'not_verified';
            else if($u_fectch['status'] == 0) echo 'inactive';
            else
            {

            }
        }
    }
?>