<?php
    require("../inc/db_config.php");
    require("../inc/essentials.php");
    adminLogin();


    if(isset($_POST['get_bookings']))
    {
        $frm_data = filteration($_POST);

        $query = "SELECT momo.*, bd.* FROM `momo_table` momo INNER JOIN `booking_details_table` bd ON momo.id = bd.booking_id 
        WHERE (momo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) AND momo.refund = ? 
        ORDER BY momo.id ASC";
        $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", 0], 'sssi');
        $i=1;
        $table_data="";

        if(mysqli_num_rows($res)==0) echo "<b>No data found.</b>";
        while($data = mysqli_fetch_assoc($res))
        {
            $formattedPrice = number_format($data['amount'], 0, ".", ".");
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
                    <b>Check in:</b> $checkin
                    <br>
                    <b>Check out:</b> $checkout
                    <br>
                    <br>
                    <b>Date: </b>$date
                </td>
                <td>
                    <b> $formattedPrice  VND</b>
                </td>
                <td>
                    <button type='button' onclick='refund_booking($data[booking_id])' class='btn btn-success btn-sm fw-bold shadow-none' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                    <i class='bi bi-cash-stack'></i> Refund
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

    if(isset($_POST['refund_booking']))
    {
        $frm_data = filteration($_POST);
        $query = "UPDATE `momo_table` momo SET `refund` = ? WHERE momo.id = ?";
        $values = [1, $frm_data['booking_id']];
        $res = update($query, $values, 'ii');

        echo $res;
    }
?>