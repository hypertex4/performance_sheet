<?php include_once("inc/header.app.php"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Profile</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Profile</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-4 col-xl-4 mb-4 mb-xl-0">
            <section class="card">
                <div class="card-body">
                    <div class="thumb-info mb-3">
                        <img src="<?= public_path('img/!logged-user.jpg') ?>" class="rounded img-fluid" alt="John Doe">
                        <div class="thumb-info-title">
                            <span class="thumb-info-inner"><?= $_SESSION['emp_login']['emp_name'] ?></span>
                            <span class="thumb-info-type"><?= $_SESSION['emp_login']['emp_unit'] ?></span>
                        </div>
                    </div>

                    <div class="widget-toggle-expand mb-3">
                        <div class="widget-header">
                            <h5 class="mb-2 font-weight-semibold text-dark">Profile Completion</h5>
                            <div class="widget-toggle">+</div>
                        </div>
                        <div class="widget-content-collapsed">
                            <div class="progress progress-xs light">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    100%
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="dotted short">
                    <h5 class="mb-2 mt-3">Timesheet Approve By</h5>
                    <p class="text-2 font-weight-bold">
                        <?php
                        $res = $user->get_employee_approval($_SESSION['emp_login']['approval_by']);
                        echo $res['user_name'];
                        ?>
                    </p>
                    <div class="clearfix"></div>
                    <hr class="dotted short">
                </div>
            </section>
        </div>
        <div class="col-lg-8 col-xl-8">
            <section class="card">
                <div class="card-body">
                    <form class="p-3" id="profile" name="profile">
                        <h4 class="mb-3 font-weight-semibold text-dark">Company Information</h4>
                        <div id="response-alert"></div>
                        <div class="form-group mb-3">
                            <label for="emp_name">Full Name</label>
                            <input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="Enter full name" value="<?= $_SESSION['emp_login']['emp_name'];?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="emp_email">Email Address</label>
                            <input type="email" class="form-control" id="emp_email" name="emp_email" placeholder="Enter email"
                                   value="<?= $_SESSION['emp_login']['emp_email'];?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="emp_unit">Designation</label>
                            <select name="emp_unit" id="emp_unit" class="form-control">
                                <?php $dept=$user->list_all_dept();
                                if ($dept->num_rows > 0) {
                                    while ($department = $dept->fetch_assoc()) {
                                        ?>
                                        <option value="<?=$department['department_id'];?>" <?php if($department['department_id']==$_SESSION['emp_login']['emp_department']) echo "selected";?>>
                                            <?= $department['department_name'];?>
                                        </option>
                                    <?php } } ?>
                            </select>
                        </div>
                        <div class="form-group my-4" style="border-top: 1px solid #abc4c5;">
                            <label class="text-muted font-weight-bold text-uppercase mt-4 small">
                                <span class="text-danger">*</span> (leave it empty if you are not updating your password)
                            </label>
                        </div>
                        <div class="form-group mb-3">
                            <label for="emp_new_pwd">Enter new password</label>
                            <input type="password" class="form-control" id="emp_new_pwd" name="emp_new_pwd" placeholder="New password">
                        </div>
                        <div class="form-group mb-3">
                            <label for="emp_rep_new_pwd">Repeat new password</label>
                            <input type="password" class="form-control" id="emp_rep_new_pwd" name="emp_rep_new_pwd" placeholder=" Repeat new password">
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <input type="submit" class="btn btn-primary mt-2 px-4" value="Submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.app.php"); ?>
