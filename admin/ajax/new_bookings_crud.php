<?php
    require("../inc/db_config.php");
    require("../inc/essentials.php");
    adminLogin();


    if(isset($_POST['get_bookings']))
    {
        $frm_data = filteration($_POST);

        $query = "SELECT momo.*, bd.* FROM `momo_table` momo INNER JOIN `booking_details_table` bd ON momo.id = bd.booking_id 
        WHERE (momo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) AND momo.refund IS NULL 
        ORDER BY momo.id ASC";
        $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%"], 'sss');
        $i=1;
        $table_data="";

        if(mysqli_num_rows($res)==0) echo "<b>No data found.</b>";
        while($data = mysqli_fetch_assoc($res))
        {
            $date = date("d-m-Y", strtotime($data['datetime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));
            $table_data.="
            <tr>
                <td>$i</td>
                <td>
                    <span class='badge bg-primary'>
                        Order ID: $data[order_id]
                    </span>
                    <br>
                    <b>Name:</b> $data[user_name]
                    <br>
                    <b>Phone number:</b> $data[phonenum]                    
                </td>
                <td>
                    <b>Room:</b> $data[room_name]
                    <br>
                    <b>Price:</b> $data[price] VND
                </td>
                <td>
                    <b>Check in:</b> $checkin
                    <br>
                    <b>Check out:</b> $checkout
                    <br>
                    <b>Paid: </b> $data[amount] VND
                    <br>
                    <b>Date: </b>$date
                </td>
                <td>
                    <button type='button' onclick='assign_room($data[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assignRoom'>
                        <i class='bi bi-check2-square'></i> Assign room
                    </button>
                    <br>
                    <button type='button' onclick='cancel_booking($data[booking_id])' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                    <i class='bi bi-trash'></i> Set to refund
                    </button>
                </td>
            </tr>
            ";
            $i++;
        }
        echo $table_data;
    }

    if(isset($_POST['assign_room']))
    {
        $frm_data = filteration($_POST);

        $query = "UPDATE `momo_table` momo INNER JOIN  `booking_details_table` bd ON momo.id = bd.booking_id SET momo.arrival = ?, bd.room_no = ? WHERE momo.id = ?";

        $values = [1, $frm_data['room_no'], $frm_data['booking_id']];
        $res = update($query, $values, 'isi');

        echo ($res == 2) ? 1 : 0;
    }

    if(isset($_POST["toggle_status"]))
    {
        $frm_data = filteration($_POST);
        $q = "UPDATE `user_account_table` SET `status` = ? WHERE `id` = ?";
        $v = [$frm_data['value'], $frm_data['toggle_status']];

        if(update($q, $v, 'ii')) echo 1;
        else echo 0;
    }


    if(isset($_POST['cancel_booking']))
    {
        $frm_data = filteration($_POST);
        $query = "UPDATE `momo_table` momo SET `refund` = ? WHERE momo.id = ?";
        $values = [0, $frm_data['booking_id']];
        $res = update($query, $values, 'ii');

        echo $res;
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