<?php
    require("admin/inc/essentials.php");
    require("admin/inc/db_config.php");
    require("admin/inc/mpdf/vendor/autoload.php");
    adminLogin();
    
    // session_start();
    if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)) redirect('index.php');
    

    class DocTienBangChu
    {
        private $ChuSo = array(" không ", " một ", " hai ", " ba ", " bốn ", " năm ", " sáu ", " bảy ", " tám ", " chín ");
        private $Tien = array("", " nghìn", " triệu", " tỷ", " nghìn tỷ", " triệu tỷ");
    
        private function docSo3ChuSo($baso)
        {
            $tram = (int)($baso / 100);
            $chuc = (int)(($baso % 100) / 10);
            $donvi = $baso % 10;
    
            $KetQua = "";
    
            if ($tram == 0 && $chuc == 0 && $donvi == 0) return "";
    
            if ($tram != 0) {
                $KetQua .= $this->ChuSo[$tram] . " trăm ";
                if (($chuc == 0) && ($donvi != 0)) $KetQua .= " linh ";
            }
    
            if (($chuc != 0) && ($chuc != 1)) {
                $KetQua .= $this->ChuSo[$chuc] . " mươi";
                if (($chuc == 0) && ($donvi != 0)) $KetQua .= " linh ";
            }
    
            if ($chuc == 1) $KetQua .= " mười ";
    
            switch ($donvi) {
                case 1:
                    if (($chuc != 0) && ($chuc != 1)) {
                        $KetQua .= " mốt ";
                    } else {
                        $KetQua .= $this->ChuSo[$donvi];
                    }
                    break;
                case 5:
                    if ($chuc == 0) {
                        $KetQua .= $this->ChuSo[$donvi];
                    } else {
                        $KetQua .= " lăm ";
                    }
                    break;
                default:
                    if ($donvi != 0) {
                        $KetQua .= $this->ChuSo[$donvi];
                    }
                    break;
            }
    
            return $KetQua;
        }
    
        public function doc($SoTien)
        {
            $lan = 0;
            $i = 0;
            $so = 0;
            $KetQua = "";
            $tmp = "";
            $soAm = false;
            $ViTri = array();
    
            if ($SoTien < 0) $soAm = true;
    
            if ($SoTien == 0) return "Không Việt Nam đồng";
    
            if ($SoTien > 8999999999999999) {
                return "";
            }
    
            $ViTri[5] = floor($SoTien / 1000000000000000);
            if (is_nan($ViTri[5]))
                $ViTri[5] = "0";
            $SoTien = $SoTien - (int)$ViTri[5] * 1000000000000000;
    
            $ViTri[4] = floor($SoTien / 1000000000000);
            if (is_nan($ViTri[4]))
                $ViTri[4] = "0";
            $SoTien = $SoTien - (int)$ViTri[4] * 1000000000000;
    
            $ViTri[3] = floor($SoTien / 1000000000);
            if (is_nan($ViTri[3]))
                $ViTri[3] = "0";
            $SoTien = $SoTien - (int)$ViTri[3] * 1000000000;
    
            $ViTri[2] = (int)($SoTien / 1000000);
            if (is_nan($ViTri[2]))
                $ViTri[2] = "0";
    
            $ViTri[1] = (int)(($SoTien % 1000000) / 1000);
            if (is_nan($ViTri[1]))
                $ViTri[1] = "0";
    
            $ViTri[0] = $SoTien % 1000;
            if (is_nan($ViTri[0]))
                $ViTri[0] = "0";
    
            if ($ViTri[5] > 0) {
                $lan = 5;
            } else if ($ViTri[4] > 0) {
                $lan = 4;
            } else if ($ViTri[3] > 0) {
                $lan = 3;
            } else if ($ViTri[2] > 0) {
                $lan = 2;
            } else if ($ViTri[1] > 0) {
                $lan = 1;
            } else {
                $lan = 0;
            }
    
            for ($i = $lan; $i >= 0; $i--) {
                $tmp = $this->docSo3ChuSo($ViTri[$i]);
        
                // Chỉ chuyển đổi chữ cái đầu tiên của chuỗi chữ số
                $tmp = ucfirst($tmp);
        
                $KetQua .= $tmp;
                if ($ViTri[$i] > 0) $KetQua .= $this->Tien[$i];
                if (($i > 0) && (strlen($tmp) > 0)) $KetQua .= '';
            }
        
            if (substr($KetQua, -1) == ',') {
                $KetQua = substr($KetQua, 0, -1);
            }
        
            // Giữ nguyên chữ cái đầu tiên của chuỗi chữ số
            $KetQua = ucfirst(substr($KetQua, 1, 2)) . substr($KetQua, 2);
        
            if ($soAm) {
                return "Âm " . $KetQua . " Việt Nam Đồng";
            } else {
                $KetQua = substr($KetQua, 0, 1) . substr($KetQua, 2);
                return $KetQua . " Việt Nam Đồng";
            }
        }
    }
    

    

    if(isset($_GET['gen_pdf']) && isset($_GET['id']))
    {
        $frm_data = filteration($_GET);

        $query = "SELECT momo.*, bd.*, uc.email FROM `momo_table` momo 
        INNER JOIN `booking_details_table` bd 
        ON momo.id = bd.booking_id 
        INNER JOIN `user_account_table` uc
        ON momo.user_id = uc.id
        AND momo.id = '$frm_data[id]'";

        $res = mysqli_query($con, $query);
        $total_rows = mysqli_num_rows($res);
        if($total_rows==0)
        {
            header('location: index.php');
            exit;
        }
        $data = mysqli_fetch_assoc($res);


        $date = date("h:i:s a | d-m-Y", strtotime($data['datetime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $formattedPrice1 = number_format($data['price'], 0, ".", ".");

        $table_data ="
        <h2>BOOKING RECIEPT</h2>
        <table border='1'>
            <tr>
                <td>Order ID: $data[order_id]</td>
                <td>Ngày thanh toán: $date</td>
            </tr>
            <tr>
                <td>Tên: $data[user_name]</td>
                <td>Email: $data[email]</td>
            </tr>
            <tr>
                <td>Tên phòng: $data[room_name]</td>
                <td>Giá:  $formattedPrice1 VND / đêm</td>
            </tr>
            <tr>
                <td>Ngày nhận: $checkin</td>
                <td>Ngày trả: $checkout</td>
            </tr>
        ";



        if($data['refund'] == "") $status = 'Đã đặt';
        else if($data['refund'] == "0") $status = 'Đang yêu cầu hoàn tiền';
        else if($data['refund'] == "1") $status = 'Đã hoàn tiền';
        $chuTien = (new DocTienBangChu())->doc($data['amount']);
        $formattedPrice2 = number_format($data['amount'], 0, ".", ".");


        $table_data .= "
            <br>
            <tr>
                <td colspan='2'><b>Tình trạng: $status</b><td>
            </tr>
            <tr>
                <td>Phòng số: $data[room_no]</td>
                <td>Số tiền đã trả: $formattedPrice2 VND</td>
            </tr>
            <tr>
                <td colspan='2'>Tổng số tiền bằng chữ: <b>$chuTien</b><td>
            </tr>
            </table>
        ";

        echo $table_data;

        $mpdf = new \Mpdf\Mpdf();

        // Write some HTML code:
        $mpdf->WriteHTML($table_data);

        // Output a PDF file directly to the browser
        $mpdf->Output($data['order_id'].'.pdf', 'D');

    }
    else header('location: index.php');
?>
