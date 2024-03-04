<?php
    require("../admin/inc/db_config.php");
    require("../admin/inc/essentials.php");
    
    date_default_timezone_set("Asia/Ho_Chi_Minh");

    if(isset($_POST['info_form']))
    {
        $frm_data = filteration($_POST);
        session_start();
        
        $query ="UPDATE `user_account_table` SET `name`= ?,`address`= ?,`phonenum`= ?,`pincode`= ?,`birthdate`= ? WHERE `id` = ?";
        $values = [$frm_data['name'], $frm_data['address'], $frm_data['phonenum'], $frm_data['pincode'], $frm_data['birthdate'], $_SESSION['uId']];

        if(update($query, $values, 'sssssi'))
        {
            $_SESSION['uName'] = $frm_data['name'];
            echo 1;
        }
        else echo 0;

    }

    
    if(isset($_POST['picture_form']))
    {
        session_start();
        $img = uploadUserImage($_FILES['picture']);
        if($img == 'inv_img')
        {
            echo 'inv_img';
            exit;
        }
        else if($img == 'upd_failed')
        {
            echo 'update failed';
            exit;
        }
        $u_exist = select("SELECT * FROM `user_account_table` WHERE `id` = ? LIMIT 1", [$_SESSION['uId']], "i");
        $u_fectch = mysqli_fetch_assoc($u_exist);

        
        $query ="UPDATE `user_account_table` SET `picture`= ? WHERE `id` = ?";
        $values = [$img, $_SESSION['uId']];

        if(update($query, $values, 'ss'))
        {
            $_SESSION['uPic'] = $img;
            echo 1;
        }
        else echo 0;

    }
?>