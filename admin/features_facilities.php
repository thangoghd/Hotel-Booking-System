<?php
    require("inc/essentials.php");
    require("inc/db_config.php");
    adminLogin();

    if (isset($_GET['seen'])) {
        $frm_data = filteration($_GET);
        if ($frm_data['seen'] == 'all')
        {
            $q = "UPDATE `user_queries` SET `seen` = ? ";
            $values = [1];
            if(update($q, $values, 'i')) alert('success', 'Mark all as read!');
            else alert('error', 'Unknow error!');
        }
        else
        {
            $q = "UPDATE `user_queries` SET `seen` = ? WHERE `id` = ?";
            $values = [1, $frm_data["seen"]];
            if(update($q, $values, 'ii')) alert('success', 'Mark as read!');
            else alert('error', 'Unknow error!');
        }
    }

    if (isset($_GET['del'])) {
        $frm_data = filteration($_GET);
        if ($frm_data['del'] == 'all')
        {
            $q = "DELETE FROM `user_queries`";
            if(mysqli_query($con, $q)) alert('success', 'All message deleted!');
            else alert('error', 'Unknow error!');
        }
        else
        {
            $q = "DELETE FROM `user_queries` WHERE `id` = ?";
            $values = [$frm_data['del']];
            if(delete($q, $values, 'i')) alert('success', 'Message deleted!');
            else alert('error', 'Unknow error!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Features & Facilities</title>
    <?php require('inc/links.php')?>
</head>
<body class="bg-light">
    <?php require('inc/header.php')?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <h3 class="mb-4">Features & Facilities</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Features</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#featuresSetting">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="features-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Facilities</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facilitiesSetting">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col">Decription</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="facilities-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Modal thiết lập đặc điểm -->
    <div class="modal fade" id="featuresSetting" data-bs-backdrop="static"  data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="feature_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add features</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" id="feature_name" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    <!-- Modal thiết lập cơ sở vật chất -->
    <div class="modal fade" id="facilitiesSetting" data-bs-backdrop="static"  data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="facility_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add facilities</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <input type="text" name="facility_name"  class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Icon</label>
                                        <input type="file" name="facility_icon" accept=".svg" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="form-label" class="form-label">Decription</label>
                                        <textarea name="facility_decription" class="form-control shadow-none" rows="3"></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    <?php require('inc/scripts.php')?>
    <script src="scripts/features_facilities.js"></script>
</body>
</html>