<?php
    require("../inc/db_config.php");
    require("../inc/essentials.php");
    adminLogin();


    if(isset($_POST['get_bookings']))
    {
        $frm_data = filteration($_POST);

        $limit = 32;
        $page = $frm_data['page'];
        $start = ($page-1) * $limit;

        $query = "SELECT momo.*, bd.* FROM `momo_table` momo INNER JOIN `booking_details_table` bd ON momo.id = bd.booking_id 
        WHERE (momo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
        ORDER BY momo.id ASC";
        $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%"], 'sss');

        $limit_query = $query." LIMIT $start, $limit";
        $limit_res = select($limit_query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%"], 'sss');

        $i = $start + 1;
        $table_data="";

        $total_rows = mysqli_num_rows($res);
        if($total_rows == 0)
        {
            $output = json_encode(["table_data"=>"<b>No data found!</b>", "pagination"=>'']);
            echo $output;
            exit;
        }
        while($data = mysqli_fetch_assoc($limit_res))
        {
            $date = date("d-m-Y", strtotime($data['datetime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

            if($data['refund'] == "")
            {
                $status_bg = 'bg-success';
                $status_txt = 'booked';
            }
             
            else if ($data['refund'] == '0')
            {
                $status_bg = 'bg-danger';
                $status_txt = 'set to refund';
                
            } 
            else if ($data['refund'] == '1')
            {
                $status_bg = 'bg-warning text-dark';
                $status_txt = 'refunded';
            } 

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
                    <b>Amount: </b> $data[amount] VND
                    <br>
                    <b>Date: </b>$date
                </td>
                <td>
                    <span class='badge $status_bg'> $status_txt</span>
                </td>
                <td>
                    <button type='button' onclick='download($data[booking_id])' class='mt-2 btn btn-outline-dark btn-sm fw-bold shadow-none' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                    <i class='bi bi-file-earmark-arrow-down-fill'></i></i>
                    </button>
                </td>
            </tr>
            ";
            $i++;
        }
        $pagination ="";
        if($total_rows>$limit)
        {
            $total_pages = ceil($total_rows / $limit);

            if($page!=1)
            {
                $pagination .= $pagination .= "<li class='page-item'><button onclick='change_page(1)' class='page-link'>Frist</button></li>";
            }

            $disable = ($page==1) ? "disable" : "";
            $prev = $page - 1;
            $pagination .="<li class='page-item $disable'><button onclick='change_page($prev)' class='page-link'>Prev</button></li>";

            $disable = ($page==$total_pages) ? "disable" : "";
            $next = $page + 1;
            $pagination .="<li class='page-item $disable'><button onclick='change_page($next)' class='page-link'>Next</button></li>";

            if($page != $total_pages)
            {
                $pagination .= "<li class='page-item'><button onclick='change_page($total_pages)' class='page-link'>Last</button></li>";
            }
        }

        $output = json_encode(["table_data" => $table_data, "pagination" => $pagination]);
        echo $output;
    }

