<?php ob_start(); session_start();
if (isset($_SESSION['emp_login']) && isset($_SESSION['emp_login']['emp_id'])) {
    if ($_SESSION['emp_login']['user_type']=="approval"){ header('Location:approval/index'); }
    else { header('Location:account/index'); }
}

include_once('controllers/config/database.php');
include_once('controllers/classes/User.class.php');
$db = new Database();
$connection = $db->connect();
$user = new User($connection);
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TEP: Performance Sheet</title>
    <meta name="keywords" content="Performance Sheet" />
    <meta name="description" content="TEP - Performance Sheet">
    <meta name="author" content="Performance Sheet">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/images/apple-touch-icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/animate/animate.compat.css">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <link rel="stylesheet" href="assets/css/theme-elements.css">
    <link rel="stylesheet" href="assets/css/theme-blog.css">
    <link rel="stylesheet" href="assets/css/theme-shop.css">
    <link id="skinCSS" rel="stylesheet" href="assets/css/skin-corporate-21.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/jquery-confirm.min.css">
    <style>
        #login-page {
            height: 100vh;
            background-image: url('assets/images/main-background-img.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .header-text{
            font-size: 25px;
            font-weight: bolder;
            display: flex;
            align-items: center;
        }
    </style>
    <script src="vendor/modernizr/modernizr.min.js"></script>
</head>
<body data-plugin-page-transition>
<div class="body" id="login-page">
    <header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
        <div class="header-body border-color-primary header-body-bottom-border">
            <div class="header-top header-top-default border-bottom-0">
                <div class="container">
                    <div class="header-row py-2">
                        <div class="header-column justify-content-start">
                            <div class="header-row">
                                <div class="header-logo">
                                    <a href="./">
                                        <img alt="Timesheet Logo" height="48" src="assets/images/logo.png">
                                    </a>
                                </div>
                                <div>
                                    <span class="text-success header-text">&nbsp;PERFORMANCE SHEET</span>
                                </div>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    <ul class="nav nav-pills text-uppercase text-2">
                                        <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                            <a class="nav-link" href=""><i class="fas fa-angle-right"></i> Contact MainlandTech</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div role="main" class="main">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-sm-11 col-lg-7">
                    <div class="row">
                        <div class="col-md-12 align-self-center p-static order-2 text-center">
                            <h1 class="font-weight-bold text-dark">Sign Up</h1>
                        </div>
                    </div>
                    <div class="tabs">
                        <div class="tab-content p-lg-5 p-3">
                            <div id="owner_login" class="tab-pane active">
                                <form id="register_form" name="register_form">
                                    <div id="response-alert"></div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="text-color-dark text-3">Full Name <span class="text-color-danger">*</span></label>
                                            <input type="text" class="form-control shadow-none text-4" name="emp_name"  required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="text-color-dark text-3">Email Address <span class="text-color-danger">*</span></label>
                                            <input type="email" class="form-control shadow-none text-4" name="emp_email"  required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="text-color-dark text-3">Employee Department <span class="text-color-danger">*</span></label>
                                            <select name="emp_department" id="emp_department" class="form-control" required>
                                                <option value=""></option>
                                                <?php $dept=$user->list_all_dept();
                                                if ($dept->num_rows > 0) {
                                                    while ($department = $dept->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?=$department['department_id'];?>"><?= $department['department_name'];?></option>
                                                    <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="text-color-dark text-3">Employee Designation/Unit <span class="text-color-danger">*</span></label>
                                            <select class="form-control employee_unit" id="emp_unit" name="emp_unit">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="text-color-dark text-3" for="emp_approval">Timesheet Approved By: <span class="text-color-danger">*</span></label>
                                            <select class="form-control employee_approval" id="emp_approval" name="emp_approval">
                                                <option value=""></option>
                                                <?php $usr=$user->list_all_aprroval_user();
                                                if ($usr->num_rows > 0) {
                                                    while ($user = $usr->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?=$user['user_id'];?>"><?= $user['user_name'];?></option>
                                                    <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
                                            <input type="password" class="form-control shadow-none text-4" name="emp_password"  required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="text-color-dark text-3" for="emp_rep_password">Repeat Password <span class="text-color-danger">*</span></label>
                                            <input type="password" class="form-control" id="emp_rep_password" name="emp_rep_password" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="text-color-dark text-3" for="captcha_answer">Captcha. What is the answer to 8 X 6 = ?</label>
                                            <input type="number" class="form-control" name="captcha_answer" id="captcha_answer" placeholder="Enter your answer" required>
                                            <input name="captcha_answer_raw" type="hidden" value="48">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col mt-3">
                                            <input id="reg_btn" type="submit" value="Login"
                                                   class="btn btn-success btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3"
                                                   data-loading-text="Please wait..."
                                            />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <span>Already have an account? <a href="./" class="text-color-success">Login</a></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <div class="footer-copyright">
            <div class="container py-1">
                <div class="row py-0">
                    <div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                        <a href="./" class="logo pe-0 pe-lg-3">
                            <img alt="Timesheet Logo" src="assets/images/logo-footer.png"
                                 class="opacity-5" width="30" height="40" data-plugin-options="{'appearEffect': 'fadeIn'}">
                        </a>
                    </div>
                    <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                        <p>© Copyright 2021. All Rights Reserved.</p>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end">
                        <nav id="sub-menu">
                            <ul>
                                <li><i class="fas fa-angle-right"></i><a href="" class="ms-1 text-decoration-none"> Contact MainlandTech</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- Vendor -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/jquery.appear/jquery.appear.min.js"></script>
<script src="vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="vendor/jquery.cookie/jquery.cookie.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery.validation/jquery.validate.min.js"></script>
<script src="vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
<script src="vendor/lazysizes/lazysizes.min.js"></script>
<script src="vendor/isotope/jquery.isotope.min.js"></script>
<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="vendor/vide/jquery.vide.min.js"></script>
<script src="vendor/vivus/vivus.min.js"></script>
<!-- Theme Base, Components and Settings -->
<script src="assets/js/theme.js"></script>
<!-- Theme Custom -->
<script src="assets/js/custom.js"></script>
<!-- Theme Initialization Files -->
<script src="assets/js/theme.init.js"></script>
<script src="assets/js/jquery-confirm.min.js"></script>
<script src="assets/js/views/view.auth.js"></script>
<script>
    $("#emp_department").on('change', function () {
        $("#emp_unit").load("inc/empUnitGetter.php?dep_id="+ $("#emp_department").val());
    });
</script>

</body>
</html>
