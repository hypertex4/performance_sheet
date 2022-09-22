<?php
ob_start(); session_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath."/../../controllers/config/database.php");
include_once($filepath."/helpers.php");
include_once($filepath.'/../../controllers/classes/Admin.class.php');
include_once($filepath.'/../../controllers/classes/User.class.php');
$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);
$user = new User($connection);
if (isset($_SESSION['adm_login']['adm_id'])){
    if ((time() - $_SESSION['adm_last_login_timestamp']) > 1200){
        if (basename($_SERVER['PHP_SELF']) == 'edit-timesheet.php' || basename($_SERVER['PHP_SELF']) == 'uploaded-planner-details.php')
            header("Location:../logout");
        else header("Location:logout");
    } else {
        $_SESSION['adm_last_login_timestamp'] = time();
    }
}
if (!isset($_SESSION['adm_login']) && !isset($_SESSION['adm_login']['adm_id'])) header('Location:index');
?>
<!doctype html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <title>Performance Sheet - Admin Dashboard</title>
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Performance Sheet - Dashboard">
    <meta name="author" content="Performance Sheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <base href="http://localhost/performance_sheet/admin/">
    <link rel="shortcut icon" href="<?= public_path("img/favicon.png"); ?>" type='image/x-icon' />
    <link rel="apple-touch-icon" href="<?= public_path("img/apple-touch-icon.png"); ?>">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap/css/bootstrap.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/animate/animate.compat.css"); ?>'>
    <link rel="stylesheet" href='<?= public_path("vendor/font-awesome/css/all.min.css"); ?>' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href='<?= public_path("vendor/boxicons/css/boxicons.min.css"); ?>' />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href='<?= public_path("vendor/magnific-popup/magnific-popup.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/select2/css/select2.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/select2-bootstrap-theme/select2-bootstrap.min.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap-timepicker/css/bootstrap-timepicker.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap-fileupload/bootstrap-fileupload.min.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/morris/morris.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/pnotify/pnotify.custom.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/jquery-confirm/jquery-confirm.min.css"); ?>'>
    <link rel="stylesheet" href='<?= public_path("vendor/datatables/media/css/dataTables.bootstrap5.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("css/theme.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("css/skins/default.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("css/custom.css"); ?>'>
    <style>
        table td input {width: 100%;}
        table .pro_label {min-width: 220px;}
        table .task_label2 {min-width: 270px;}
        table .task_label3 {min-width: 220px;}
        table .task_label4 {min-width: 180px !important;}
        table .task_label {min-width: 300px;}
        table .proj_label {max-width: 180px !important;}
        table .estimation_label {min-width: 70px;}
        table .com_label {min-width: 200px;}
        table .month_label {min-width: 50px;text-align: center;}
        table .estimation_label {min-width: 100px;}
        table .estimation_dlabel {min-width: 80px;}
        table .date_label {min-width: 70px;}
        table .staff_name_label {min-width: 100px;}
        table .total_time_label {min-width: 70px !important;}
        table td > input,table td > input:focus,table td > input:active {border: none;outline: none;box-shadow: none;}
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {-webkit-appearance: none;margin: 0;}
        input[type=number] {-moz-appearance: textfield;}
        table td select {
            background-image: unset;-webkit-appearance: none;-moz-appearance: none;-ms-appearance: none;
            -o-appearance: none;appearance: none;
        }
        .list_wrapper a.add_time_planner:focus,.list_wrapper_2 a.add_time_planner:focus{
            color: #198754;
        }
    </style>
    <script src='<?= public_path("vendor/modernizr/modernizr.js"); ?>'></script>
</head>
<body>
<section class="body">
    <header class="header">
        <div class="logo-container">
            <a href="./" class="logo">
                <img src="<?= public_path("img/logo.png"); ?>"  height="40" alt="TEP Timesheet Logo" />
            </a>
            <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="header-right">
            <span class="separator"></span>
            <div id="userbox" class="userbox">
                <a href="javascript:void(0)" data-bs-toggle="dropdown">
                    <figure class="profile-picture">
                        <img src="<?= public_path("img/!logged-user.jpg"); ?>" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/!logged-user.jpg" />
                    </figure>
                    <div class="profile-info" data-lock-name="John Doe" data-lock-email="test@test.com">
                        <span class="name"><?=$_SESSION['adm_login']['adm_name'];?> (Admin)</span>
                        <span class="role"><?=$_SESSION['adm_login']['adm_email'];?></span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="list-unstyled mb-2">
                        <li class="divider"></li>
                        <li><a role="menuitem" tabindex="-1" href="admin-profile"><i class="bx bx-user-circle"></i> My Profile</a></li>
                        <li><a role="menuitem" tabindex="-1" href="logout"><i class="bx bx-power-off"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- end: header -->
    <div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left">
            <div class="sidebar-header">
                <div class="sidebar-title">Navigation</div>
                <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                    <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>
            <div class="nano">
                <div class="nano-content">
                    <nav id="menu" class="nav-main" role="navigation">
                        <ul class="nav nav-main">
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo "nav-active";?>">
                                <a class="nav-link" href="./">
                                    <i class="bx bx-home-alt" aria-hidden="true"></i><span>Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-parent <?php if(basename($_SERVER['PHP_SELF']) == 'upload-form-timesheet.php' ||
                                basename($_SERVER['PHP_SELF']) == 'upload-file-timesheet.php') echo 'active'; ?>">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-cloud-upload" aria-hidden="true"></i><span>Timesheets</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="timesheets">View Uploaded Timesheets</a></li>
                                    <li><a class="nav-link" href="analysis">Timesheet Analysis</a></li>
                                </ul>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-book-content" aria-hidden="true"></i><span>Project Planner</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="uploaded-project-planner">View Uploaded Planner</a></li>
                                    <li><a class="nav-link" href="project-planner-analysis">Project Planner Analysis</a></li>
                                </ul>
                            </li>
                            <li class="nav-parent <?php if(basename($_SERVER['PHP_SELF']) == 'projects.php' ||
                                basename($_SERVER['PHP_SELF']) == 'employees.php' ||
                                basename($_SERVER['PHP_SELF']) == 'departments.php') echo 'nav-active'; ?>">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-grid-alt" aria-hidden="true"></i><span>Manage Catalogue</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="projects">Project</a></li>
                                    <li><a class="nav-link" href="employees">Employee</a></li>
                                    <li><a class="nav-link" href="departments">Department</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <hr class="separator" />
                    <div class="sidebar-widget widget-tasks">
                        <div class="widget-header"><h6>AUTHENTICATION</h6></div>
                        <div class="widget-content">
                            <ul class="list-unstyled m-0">
                                <li><a href="logout">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr class="separator" />
                </div>
            </div>
        </aside>
        <!-- end: sidebar -->