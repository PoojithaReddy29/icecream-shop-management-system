<?php session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){ header("Location:./");
exit;
}
require_once('DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | Ice Cream Shop Management System</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
    <style>
    .login-body {
        position: relative;
        background-image: url('./images/giffy1.gif');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        height: 100vh;
    }
    #sys_title {
        font-size: 3rem;
        text-shadow: 3px 3px 10px #000000;
    }
    .card {
        margin-top: 1.5rem;
    }
    .form-label {
        font-weight: bold;
    }
    .btn-primary {
        background-color: #ff69b4; 
        border-color: #ff69b4;
        color: white;
    }
    .btn-primary:hover {
        background-color: #d946a6; 
        border-color: #d946a6;
    }
    .btn-primary:focus {
        box-shadow: 0 0 0 0.25rem rgba(255, 105, 180, 0.5); 
    }
    .pop_msg {
        margin-top: 1rem;
    }
    #login-form-container {
        display: none;
    }
    #sys_title {
        font-size: 3rem;
        text-shadow: 3px 3px 10px #000000;
        margin-top: 3rem; 
        font-family: 'cursive'; 
    }
    .cream-text {
    position: absolute;
    top: 5%;
    left: 50%;
    transform: translateX(-50%);
    font-size: 3rem;
    font-family: 'Dancing Script', cursive;
    font-style: italic;
    font-weight: bold; /* Add font-weight to make it bold */
    color: #fff;
    text-shadow: 3px 3px 10px #000000;
}

    </style>
</head>
<body class="login-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col text-end mt-3">
                <a href="gallery.html" class="btn btn-primary me-2">Gallery</a>
                <button id="login-btn" class="btn btn-primary">Login</button>
            </div>
        </div>
        <div id="login-form-container" class="row h-100 justify-content-center align-items-center">
            <div class="col-md-6">
                <h1 class="text-center text-light" id="sys_title"><b>Ice Cream Shop Management System</b></h1>
                <div class="card mt-5">
                    <div class="card-body">
                        <form action="" id="login-form">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" autofocus name="username" class="form-control rounded-0" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control rounded-0" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary rounded-0" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="cream-text">Creamy Dreams</div>
    </div>
    <script>
    $(function(){
        $('#login-btn').click(function() {
            $('#login-form-container').addClass('d-flex align-items-center justify-content-center').show();
        });
        $('#login-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            _this.find('button').attr('disabled',true)
            _this.find('button[type="submit"]').text('Logging in...')
            $.ajax({
                url:'./Actions.php?a=login',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                    _this.find('button').attr('disabled',false)
                    _this.find('button[type="submit"]').text('Login')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                        setTimeout(() => {
                            location.replace('./');
                        }, 2000);
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                    _this.find('button').attr('disabled',false)
                    _this.find('button[type="submit"]').text('Login')
                }
            })
        })
    })
</script>
</body>
</html>
