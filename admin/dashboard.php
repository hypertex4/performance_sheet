<?php include_once("inc/header.adm.php"); ?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Dashboard: <?=$_SESSION['adm_login']['adm_name'];?></h2>
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
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-success mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Timesheet Uploaded (Approved)</h4>
                                        <div class="info">
                                            <strong class="amount">
                                                <?=$admin->count_total_timesheet();?> (<?=$admin->count_approved_timesheet();?>)
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="javascript:void">total timesheets (Approved)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-dark">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-dark">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Project</h4>
                                        <strong class="amount"><?=$admin->count_total_projects_code();?></strong>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="javascript:void">(Project Name)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-info">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-info">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Staff (Registered)</h4>
                                        <strong class="amount">
                                            <?=$admin->count_total_employee();?> (<?=$admin->count_registered_employee();?>)
                                        </strong>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="javascript:void">(Total Staff)</a>
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
            <section class="card card-featured card-featured-quaternary mb-4">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div><i class="fas fa-chart-line">&nbsp;</i><span style="font-size: 16px">Performance Chart 2022 - <b>y(Hrs) vs x(Month)</b></span></div>
                    </div>

                    <div class="chart-data-selector" id="salesSelectorWrapper">
                        <h2>
                            Employee Name:
                            <strong>
                                <select class="form-control" id="salesSelector" style="display: none">
                                    <?php
                                    $lu = $admin->list_distinct_emp();
                                    if ($lu->num_rows > 0) {$n=0;
                                    while ($emp = $lu->fetch_assoc()) {
                                    ?>
                                    <option value="<?=$emp['user_email']?>" <?=$n==0?'selected':'';?>><?=$emp['user_name']?></option>
                                    <?php $n++; } } ?>
                                </select>
                            </strong>
                        </h2>
                        <div id="salesSelectorItems" class="chart-data-selector-items mt-3">
                            <?php
                            $lu = $admin->list_distinct_emp();
                            if ($lu->num_rows > 0) { $n=1;
                            while ($emp = $lu->fetch_assoc()) {
                            ?>
                            <div class="chart chart-md <?=$n==1?'chart-active':'chart-hidden';?>" data-sales-rel="<?=$emp['user_email']?>" id="flotDashSales<?=$n;?>" style="height: 403px;"></div>
                            <script>
                                var flotDashSales<?=$n;?>Data = [{
                                    data: [
                                        ["Jan 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Jan","2021");?>],
                                        ["Feb 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Feb","2021");?>],
                                        ["Mar 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Mar","2021");?>],
                                        ["Apr 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Apr","2021");?>],
                                        ["May 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"May","2021");?>],
                                        ["Jun 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Jun","2021");?>],
                                        ["Jul 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Jul","2021");?>],
                                        ["Aug 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Aug","2021");?>],
                                        ["Sep 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Sep","2021");?>],
                                        ["Oct 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Oct","2021");?>],
                                        ["Nov 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Nov","2021");?>],
                                        ["Dec 2022", <?= $admin->get_total_emp_worked_hour_monthly($emp['user_id'],"Dec","2021");?>]
                                    ],
                                    color: "#0088cc"
                                }];
                            </script>
                            <?php $n++; } } ?>
                        </div>
                    </div>
                </div>
            </section>
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
                                <th>Department</th>
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Task Avg. Rate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($_SESSION['adm_login']) && $_SESSION['adm_login']['adm_uhead']==100) {
                                $time = $admin->list_all_timesheets_by_super();
                            }
                            if ($time->num_rows > 0) {$n=0;
                                while ($timesheet = $time->fetch_assoc()) {
                                    $td_rating = $user->sum_timesheet_details_rating($timesheet['timesheet_id']);
                                    $td_count = $user->count_total_timesheet_details($timesheet['timesheet_id']);
                                    $avg = $td_rating/$td_count;
                                    ?>
                                    <tr>
                                        <th><?=++$n;?></th>
                                        <td><?= $timesheet['department_name'];?></td>
                                        <td><?= $timesheet['user_name'];?></td>
                                        <td><?= $timesheet['user_unit'];?></td>
                                        <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['from_date']));?></td>
                                        <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['to_date']));?></td>
                                        <td><?=($avg>=60)?'<span class="text-success font-weight-extra-bold">'.number_format($avg,1).'%</span>':
                                                '<span class="text-danger font-weight-extra-bold">'.number_format($avg,1).'%</span>';?></td>
                                        <?php if ($timesheet['u_h_status']=='pending'){?>
                                            <td><span class="badge badge-danger">pending</span></td>
                                        <?php } elseif ($timesheet['u_h_status']=='approved'){ ?>
                                            <td><span class="badge badge-success">approved</span></td>
                                        <?php } elseif ($timesheet['u_h_status']=='declined'){ ?>
                                            <td><span class="badge badge-dark">declined</span></td>
                                        <?php } ?>
                                        <td>
                                            <a class="btn btn-xs btn-default px-2" href="edit-timesheet/<?=$timesheet['timesheet_id'];?>">
                                                <i class="fas fa-edit">&nbsp;</i>view detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No timesheet uploaded</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

<script src="../public/vendor/jquery/jquery.js"></script>
<script src="../public/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="../public/vendor/popper/umd/popper.min.js"></script>
<script src="../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../public/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../public/vendor/common/common.js"></script>
<script src="../public/vendor/nanoscroller/nanoscroller.js"></script>
<script src="../public/vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="../public/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="../public/vendor/jquery-ui/jquery-ui.js"></script>
<script src="../public/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="../public/vendor/jquery-appear/jquery.appear.js"></script>
<script src="../public/vendor/bootstrapv5-multiselect/js/bootstrap-multiselect.js"></script>
<script src="../public/vendor/jquery.easy-pie-chart/jquery.easypiechart.js"></script>
<script src="../public/vendor/flot/jquery.flot.js"></script>
<script src="../public/vendor/flot.tooltip/jquery.flot.tooltip.js"></script>
<script src="../public/vendor/flot/jquery.flot.pie.js"></script>
<script src="../public/vendor/flot/jquery.flot.categories.js"></script>
<script src="../public/vendor/flot/jquery.flot.resize.js"></script>
<script src=<?= public_path("vendor/jquery-validation/jquery.validate.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/media/js/jquery.dataTables.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/media/js/dataTables.bootstrap5.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js"); ?>></script>
<script src=<?= public_path("js/views/admin-reducer.js"); ?>></script>

<script src="../public/js/theme.js"></script>
<script src="../public/js/custom.js"></script>
<script src="../public/js/theme.init.js"></script>
<script src="../public/js/examples/examples.dashboard.js"></script>
<script>
    <?php for ($i=0;$i<=$n;$i++){?>
    if( $('#flotDashSales<?=$i;?>').get(0) ) {
        var flotDashSales<?=$i;?> = $.plot('#flotDashSales<?=$i;?>', flotDashSales<?=$i;?>Data, {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2
                },
                points: {
                    show: true
                },
                shadowSize: 0
            },
            grid: {
                hoverable: true,
                clickable: true,
                borderColor: 'rgba(0,0,0,0.1)',
                borderWidth: 1,
                labelMargin: 15,
                backgroundColor: 'transparent'
            },
            yaxis: {
                min: 0,
                color: 'rgba(0,0,0,0.1)'
            },
            xaxis: {
                mode: 'categories',
                color: 'rgba(0,0,0,0)'
            },
            legend: {
                show: false
            },
            tooltip: true,
            tooltipOpts: {
                content: '%x: %y',
                shifts: {
                    x: -30,
                    y: 25
                },
                defaultTheme: false
            }
        });

    }
    <?php } ?>
</script>
