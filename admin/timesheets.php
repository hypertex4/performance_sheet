<?php include_once("inc/header.adm.php"); ?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Dashboard: All Timesheets</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>All Timesheets</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Uploaded Timesheet</h2>
        </header>
        <div class="card-body">
            <table class="table table-bordered table-striped mb-0" id="datatable-timesheet" style="font-size: 11px">
                <thead class="bg-dark text-white">
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
    </section>
</section>
<?php include_once("inc/footer.adm.php"); ?>
