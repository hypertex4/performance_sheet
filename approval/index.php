<?php include_once("inc/header.app.php"); ?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Dashboard: <?=$_SESSION['emp_login']['emp_name'];?></h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Dashboard</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row pt-4">
        <div class="col-lg-12 mb-4 mb-lg-0">
            <div class="row ">
                <div class="col-xl-5 ">
                    <section class="card card-featured-left card-featured-dark mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-dark">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Uploaded Performance Sheet</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $user->count_user_total_timesheets($_SESSION['emp_login']['emp_id']); ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="#">(view timesheets)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-5">
                    <section class="card card-featured-left card-featured-success">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Approved Performance Sheet</h4>
                                        <strong class="amount">
                                            <?= $user->count_user_approved_total_timesheets($_SESSION['emp_login']['emp_id']); ?>
                                        </strong>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="javascript:void">(Approved Sheet)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="card card-featured card-featured-success mb-4">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div><i class="fas fa-book">&nbsp;</i><span style="font-size: 16px">Recently Uploaded Timesheets</span></div>
                        <div><a href="my-saved-timesheets">View All</a></div>
                    </div>
                    <div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-timesheet" style="font-size: 11px">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Designation</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $time = $user->list_all_user_timesheets($_SESSION['emp_login']['emp_id']);
                            if ($time->num_rows > 0) {$n=0;
                                while ($timesheet = $time->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $timesheet['user_unit'];?></td>
                                        <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['from_date']));?></td>
                                        <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['to_date']));?></td>
                                        <?php if ($timesheet['u_h_status']=='pending'){ ?>
                                            <td><span class="badge badge-danger">pending</span></td>
                                        <?php } elseif ($timesheet['u_h_status']=='approved'){ ?>
                                            <td><span class="badge badge-success">approved</span></td>
                                        <?php } elseif ($timesheet['u_h_status']=='declined'){ ?>
                                            <td><span class="badge badge-dark">declined</span></td>
                                        <?php } ?>
                                        <td>
                                            <a class="btn btn-xs btn-default px-2" href="edit-timesheet/<?=$timesheet['timesheet_id'];?>">
                                                <i class="fas fa-edit">&nbsp;</i>Edit file
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No timesheet found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.app.php"); ?>
