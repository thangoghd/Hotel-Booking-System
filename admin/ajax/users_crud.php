<?php
    require("../inc/db_config.php");
    require("../inc/essentials.php");
    adminLogin();


    if(isset($_POST['get_users']))
    {
        $res = selectAll("user_account_table");
        $i = 1;
        $path = USERS_IMG_PATH;
        $data = "";

        while($row = mysqli_fetch_assoc($res))
        {
            $del_btn = "<button type='button' onclick='delete_user($row[id])' title='Delete users' class='btn btn-danger shadow-none btn-sm'><i class='bi bi-trash'></i> </button>";

            $verified = "<span class='badge bg-warning text-dark'><i class='bi bi-x-lg'></i></span>";
            if($row['is_verified']) {
                $verified = "<span class='badge bg-success text-light'><i class='bi bi-check-lg'></i></span>";
                $del_btn ="";
            } 

            $status = "<button onclick='toggle_status($row[id], 0)' class='btn btn-success btn-sm shadow-none'>Active</button>";
            if(!$row['status']) $status = "<button onclick='toggle_status($row[id], 1)' class='btn btn-danger btn-sm shadow-none'>Banned</button>";

            $date = date("d-m-Y", strtotime($row['datetime']));

            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td class='d-flex align-items-center '>
                    <img style='margin-right: 10px;' src='$path$row[picture]' width='50px' height='50px'>
                    $row[name]
                    </td>
                    <td>$row[email]</td>
                    <td>$row[phonenum]</td>
                    <td>$row[address]</td>
                    <td>$row[birthdate]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST["toggle_status"]))
    {
        $frm_data = filteration($_POST);
        $q = "UPDATE `user_account_table` SET `status` = ? WHERE `id` = ?";
        $v = [$frm_data['value'], $frm_data['toggle_status']];

        if(update($q, $v, 'ii')) echo 1;
        else echo 0;
    }


    if(isset($_POST['delete_user']))
    {
        $frm_data = filteration($_POST);

        $res = delete("DELETE FROM `user_account_table` WHERE `id` = ? AND `is_verified` = ?", [$frm_data['user_id'], 0], 'ii');

        if($res) echo 1;
        else echo 0;

    }

    if(isset($_POST['search_user']))
    {
        $frm_data = filteration($_POST);

        $query = "SELECT * FROM `user_account_table` WHERE `name` LIKE ?";

        $res = select($query, ["%$frm_data[name]%"], 's');
        $i = 1;
        $path = USERS_IMG_PATH;
        $data = "";

        while($row = mysqli_fetch_assoc($res))
        {
            $del_btn = "<button type='button' onclick='delete_user($row[id])' title='Delete users' class='btn btn-danger shadow-none btn-sm'><i class='bi bi-trash'></i> </button>";

            $verified = "<span class='badge bg-warning text-dark'><i class='bi bi-x-lg'></i></span>";
            if($row['is_verified']) {
                $verified = "<span class='badge bg-success text-light'><i class='bi bi-check-lg'></i></span>";
                $del_btn ="";
            } 

            $status = "<button onclick='toggle_status($row[id], 0)' class='btn btn-success btn-sm shadow-none'>Active</button>";
            if(!$row['status']) $status = "<button onclick='toggle_status($row[id], 1)' class='btn btn-danger btn-sm shadow-none'>Banned</button>";

            $date = date("d-m-Y", strtotime($row['datetime']));

            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td class='d-flex align-items-center '>
                    <img style='margin-right: 10px;' src='$path$row[picture]' width='50px' height='50px'>
                    $row[name]
                    </td>
                    <td>$row[email]</td>
                    <td>$row[phonenum]</td>
                    <td>$row[address]</td>
                    <td>$row[birthdate]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }
?>