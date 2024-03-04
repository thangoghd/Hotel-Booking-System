<?php
    require("../admin/inc/db_config.php");
    require("../admin/inc/essentials.php");
    
    date_default_timezone_set("Asia/Ho_Chi_Minh");

    session_start();
    if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)) redirect('index.php');
    

    if(isset($_POST['refund_booking']))
    {
        $frm_data = filteration($_POST);
        $query ="UPDATE `momo_table` SET `refund` = ? WHERE `id` = ? AND `user_id`=?";

        $values = [0, $frm_data['id'], $_SESSION['uId']];
        $result = update($query, $values, 'iii');
        
        echo $result;
    }
?>