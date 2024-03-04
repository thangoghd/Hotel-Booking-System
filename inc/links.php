<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/style.css">    
<?php 
    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');
    $contact_p = "SELECT * FROM contact_table WHERE id=?";
    $settings_p = "SELECT * FROM settings_table WHERE id=?";

    $values = [1];
    $contact_r = mysqli_fetch_assoc(select($contact_p, $values, 'i'));
    $settings_r = mysqli_fetch_assoc(select($settings_p, $values, 'i'));

    if($settings_r['shutdown'])
    {
        echo <<< alertbar
        <div class='bg-danger text-center text-light p-2 fw-bold'>
        <i class="bi bi-exclamation-triangle-fill"></i> Hệ thống đang bảo trì!
        </div>
        alertbar;
    }
?>