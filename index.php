<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:./login.php");
    exit;
}
require_once('DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
if($_SESSION['type'] != 1 && in_array($page,array('maintenance','products','stocks'))){
    header("Location:./");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucwords(str_replace('_','',$page)) ?> |  Shop Management System</title>
    <link rel="stylesheet" href="./Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./select2/css/select2.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./DataTables/datatables.min.css">
    <script src="./DataTables/datatables.min.js"></script>
    <script src="./select2/js/select2.full.min.js"></script>
    <script src="./Font-Awesome-master/js/all.min.js"></script>
    <script src="./js/script.js"></script>
    <style>
    :root {
        --bs-success-rgb: 255, 192, 203; /* Light pink */
    }

    html,
    body {
        height: 100%;
        width: 100%;
        background-color: #fce4ec; /* Light pink background */
    }

    @media screen {
        body {
            background-image: url('./images/imp1.jpg'); /* Background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            backdrop-filter: brightness(0.7);
        }
    }

    main {
        height: 100%;
        display: flex;
        flex-flow: column;
    }

    #page-container {
        flex: 1 1 auto;
        overflow: auto;
    }

    #topNavBar {
        flex: 0 1 auto;
        background-color: #ff69b4; /* Hot pink navbar */
    }

    .navbar-brand,
    .navbar-nav .nav-link {
        color: #000 !important; /* Black color for navbar items */
    }

    .navbar-nav .nav-link.active {
        font-weight: bold; /* Bold font for active link */
    }

    .dropdown-menu {
        background-color: #ff69b4; /* Hot pink dropdown background */
    }

    .dropdown-item {
        color: #fff !important; /* White color for dropdown items */
    }

    .dropdown-item:hover {
        background-color: #d81b60 !important; /* Dark pink hover color */
    }

    .container {
        background-color: #fff; /* White background for page content */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
        padding: 20px; /* Padding */
        margin-top: 20px; /* Top margin */
    }

    .thumbnail-img {
        width: 50px;
        height: 50px;
        margin: 2px;
    }

    .truncate-1 {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    .truncate-3 {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .modal-dialog.large {
        width: 80% !important;
        max-width: unset;
    }

    .modal-dialog.mid-large {
        width: 50% !important;
        max-width: unset;
    }

    @media (max-width: 720px) {
        .modal-dialog.large {
            width: 100% !important;
            max-width: unset;
        }

        .modal-dialog.mid-large {
            width: 100% !important;
            max-width: unset;
        }
    }

    .display-select-image {
        width: 60px;
        height: 60px;
        margin: 2px;
    }

    img.display-image {
        width: 100%;
        height: 45vh;
        object-fit: cover;
        background: black;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .img-del-btn {
        right: 2px;
        top: -3px;
    }

    .img-del-btn>.btn {
        font-size: 10px;
        padding: 0px 2px !important;
    }

    .custom-dropdown-toggle {
        color: #000 !important; /* Black color for the button text */
    }
</style>

</head>
<body>
    <main>
    <nav class="navbar navbar-expand-lg navbar-dark bg-magenta-pink bg-gradient" id="topNavBar">

        <div class="container">
        <a class="navbar-brand" href="./" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 22px; color: #E11584; text-decoration: none; border-bottom: 2px solid #E11584; font-weight: bold;">Ice Cream Shop Management System</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" >
            <ul class="navbar-nav">
                <li class="nav-item" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); margin-bottom: 10px;">
                    <a class="nav-link <?php echo ($page == 'home')? 'active' : '' ?>" aria-current="page" href="./" style="display: block; padding: 10px; text-decoration: underline; font-weight: bold; color: #E11584;">Home</a>
                </li>
                <?php if($_SESSION['type'] == 1): ?>
                <li class="nav-item" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); margin-bottom: 10px;">
                    <a class="nav-link <?php echo ($page == 'products')? 'active' : '' ?>" href="./?page=products" style="display: block; padding: 10px; text-decoration: underline; font-weight: bold; color: #FF69B4;">Products</a>
                </li>
                <li class="nav-item" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); margin-bottom: 10px;">
                    <a class="nav-link <?php echo ($page == 'stocks')? 'active' : '' ?>" href="./?page=stocks" style="display: block; padding: 10px; text-decoration: underline; font-weight: bold; color: #FFC0CB;">Stocks</a>
                </li>
                <?php endif; ?>
                <li class="nav-item" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); margin-bottom: 10px;">
                    <a class="nav-link <?php echo ($page == 'sales')? 'active' : '' ?>" href="./?page=sales" style="display: block; padding: 10px; text-decoration: underline; font-weight: bold; color: #FF1493;">POS</a>
                </li>
                <li class="nav-item" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); margin-bottom: 10px;">
                    <a class="nav-link <?php echo ($page == 'sales_report')? 'active' : '' ?>" href="./?page=sales_report" style="display: block; padding: 10px; text-decoration: underline; font-weight: bold; color: #FFC0CB;">Sales</a>
                </li>
                <?php if($_SESSION['type'] == 1): ?>
                <li class="nav-item" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); margin-bottom: 10px;">
                    <a class="nav-link <?php echo ($page == 'users')? 'active' : '' ?>" href="./?page=users" style="display: block; padding: 10px; text-decoration: underline; font-weight: bold; color: #FF69B4;">Users</a>
                </li>
                <li class="nav-item" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); margin-bottom: 10px;">
                    <a class="nav-link" href="./?page=maintenance" style="display: block; padding: 10px; text-decoration: underline; font-weight: bold; color: #FF1493;">Maintenance</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>


            <div>
            <div class="dropdown">
            <button class="btn btn-secondary custom-dropdown-toggle bg-transparent text-dark border-0" 
                type="button" 
                id="dropdownMenuButton1" 
                data-bs-toggle="dropdown" 
                aria-expanded="false"
                style="box-shadow: 0 0 5px rgba(255, 0, 255, 0.5);">
            Hello <?php echo $_SESSION['fullname'] ?>
        </button>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="./?page=manage_account">Manage Account</a></li>
                    <li><a class="dropdown-item" href="./Actions.php?a=logout">Logout</a></li>
                </ul>
            </div>
            </div>
        </div>
    </nav>
    <div class="container py-3" id="page-container">
        <?php 
            if(isset($_SESSION['flashdata'])):
        ?>
        <div class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?> rounded-0 shadow">
        <div class="float-end"><a href="javascript:void(0)" class="text-dark text-decoration-none" onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a></div>
            <?php echo $_SESSION['flashdata']['msg'] ?>
        </div>
        <?php unset($_SESSION['flashdata']) ?>
        <?php endif; ?>
        <?php
            include $page.'.php';
        ?>
    </div>
    </main>
    <div class="modal fade" id="uni_modal" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered rounded-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header py-2">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-sm rounded-0 btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="uni_modal_secondary" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered  rounded-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header py-2">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit' onclick="$('#uni_modal_secondary form').submit()">Save</button>
            <button type="button" class="btn btn-sm rounded-0 btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered  rounded-0" role="document">
        <div class="modal-content rounded-0 rounded-0">
            <div class="modal-header py-2">
            <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
            <div id="delete_content"></div>
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-primary btn-sm rounded-0" id='confirm' onclick="">Continue</button>
            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
</body>
</html>