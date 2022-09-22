<?php include_once("inc/header.app.php"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Performance Sheet Approval</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Approval List</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>

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
                                    $lu = $user->list_distinct_emp_for_approval($_SESSION['emp_login']['emp_id']);
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
                        $lu = $user->list_distinct_emp_for_approval($_SESSION['emp_login']['emp_id']);
                        if ($lu->num_rows > 0) { $n=1;
                            while ($emp = $lu->fetch_assoc()) {
                                ?>
                                <div class="chart chart-md <?=$n==1?'chart-active':'chart-hidden';?>" data-sales-rel="<?=$emp['user_email']?>" id="flotDashSales<?=$n;?>" style="height: 403px;"></div>
                                <script>
                                    var flotDashSales<?=$n;?>Data = [{
                                        data: [
                                            ["Jan <?=date('Y');?>", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Jan",date('Y'));?>],
                                            ["Feb 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Feb","2021");?>],
                                            ["Mar 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Mar","2021");?>],
                                            ["Apr 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Apr","2021");?>],
                                            ["May 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"May","2021");?>],
                                            ["Jun 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Jun","2021");?>],
                                            ["Jul 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Jul","2021");?>],
                                            ["Aug 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Aug","2021");?>],
                                            ["Sep 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Sep","2021");?>],
                                            ["Oct 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Oct","2021");?>],
                                            ["Nov 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Nov","2021");?>],
                                            ["Dec 2022", <?= $user->get_total_emp_worked_hour_monthly($emp['user_id'],"Dec","2021");?>]
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

    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Performance Sheet Approval List</h2>
        </header>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="Approval" style="font-size: 11px">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" class="dept_labels">DEPARTMENT</th>
                        <th scope="col" class="name_labels">NAME</th>
                        <th scope="col" class="dept_labels">DESIGNATION</th>
                        <th scope="col" class="from_labels">FROM</th>
                        <th scope="col" class="to_labels">TO</th>
                        <th scope="col" class="to_labels">APPROVAL STATUS</th>
                        <th scope="col" class="to_labels">TASK AVG. RATE</th>
                        <th scope="col" class="action_labels">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $time = $user->list_all_approval_timesheet($_SESSION['emp_login']['emp_id']);
                    if ($time->num_rows > 0) {$n=0;
                        while ($timesheet = $time->fetch_assoc()) {
                            $td_rating = $user->sum_timesheet_details_rating($timesheet['timesheet_id']);
                            $td_count = $user->count_total_timesheet_details($timesheet['timesheet_id']);
                            $avg = $td_rating/$td_count;
                            ?>
                            <tr>
                                <td><?= $timesheet['department_name'];?></td>
                                <td><?= $timesheet['user_name'];?></td>
                                <td><?= $timesheet['user_unit'];?></td>
                                <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['from_date']));?></td>
                                <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['to_date']));?></td>
                                <?php if ($timesheet['u_h_status']=='pending'){ ?>
                                    <td><span class="badge badge-danger px-3">pending</span></td>
                                <?php } elseif ($timesheet['u_h_status']=='approved'){ ?>
                                    <td><span class="badge badge-success px-3">approved</span></td>
                                <?php } elseif ($timesheet['u_h_status']=='declined'){ ?>
                                    <td><span class="badge badge-dark px-3">declined</span></td>
                                <?php } ?>
                                <td><?=($avg>=60)?'<span class="text-success font-weight-extra-bold">'.number_format($avg,1).'%</span>':
                                        '<span class="text-danger font-weight-extra-bold">'.number_format($avg,1).'%</span>';?></td>
                                <td class="bg_primary text-center bg_primary_hover">
                                    <a class="btn btn-xs btn-default px-2" href="view-approval-timesheet/<?=$timesheet['timesheet_id'];?>">
                                        <i class="fas fa-edit">&nbsp;</i>Edit file
                                    </a>
                                </td>
                            </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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
<script src=<?= public_path("js/views/view.timesheets.js"); ?>></script>

<script src="../public/js/theme.js"></script>
<script src="../public/js/custom.js"></script>
<script src="../public/js/theme.init.js"></script>
<script src="../public/js/examples/examples.dashboard.js"></script>

<script>
    $(document).ready(function() {
        $('#Approval').DataTable({
            "pageLength":50,
            "bSort":false,
        });
    });
</script>
<script>
    <?php for ($i=0;$i<=$user->count_approval_total_user($_SESSION['emp_login']['emp_id']);$i++){?>
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
