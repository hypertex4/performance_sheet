<?php include_once("inc/header.adm.php"); ?>
<?php
if (!isset($_GET['planner_id']) || $_GET['planner_id'] == NULL ) {
    echo "<script>window.location = 'uploaded-project-planner'; </script>";
} else {
    $planner_id = $_GET['planner_id'];
}
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Weekly Project Planner Details</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Weekly Project Planner</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title"><a href="uploaded-project-planner">
                    <i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Weekly Project Planner Details
            </h2>
        </header>
        <div class="card-body">
            <?php
            $plan=$admin->get_user_weekly_project_planner_current_id($planner_id);
        $dept = $admin->get_user_weekly_project_dept($planner_id);
        if ($plan->num_rows > 0) {
            while ($planner = $plan->fetch_assoc()) {
                ?>
                <div class="form-group row">
                    <div class="col-sm-6 pb-3">
                        <label for="department">Department:</label>
                        <input type="hidden" name="department" id="department" value="<?=$dept['department_id'];?>">
                        <input type="text" class="form-control" value="<?=$dept['department_name'];?>"  readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="employee_name">Name:</label>
                        <select class="form-control employee_name" name="employee_name" id="employee_name" readonly>
                            <option value="<?=$planner['user_id'];?>"><?=$planner['user_name'];?></option>
                        </select>
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="employee_unit">Designation:</label>
                        <input class="form-control" type="text" id="employee_unit" name="employee_unit" value="<?=$planner['user_unit'];?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="from_date">Current Week Ended Date (Sat):</label>
                        <input type="hidden" name="ts_id" id="ts_id" value="<?=$planner_id;?>">
                        <input type="date" class="form-control from_date" id="from_date" name="from_date" value="<?=$planner['from_date'];?>" readonly>
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="to_date">Projected Week Started Date (Sun):</label>
                        <input type="date" class="form-control to_date" id="to_date" name="to_date" value="<?=$planner['to_date'];?>" readonly>
                    </div>
                </div>
            <?php } } else { echo "<script>window.location = 'uploaded-project-planner'; </script>"; } ?>
            <div class="form-group row my-3"></div>
            <section class="list_wrapper">
                <section class="card card-featured card-featured-warning rounded-0 mb-4">
                    <header class="card-header p-2">
                        <h3 class="card-title" style="font-size:15px;">CURRENT PROJECT(s)
                            <small style="font-style: italic">
                                [EST. RATE - Estimated completion rate, EST. DAYS - Estimated Workdays to completion]
                            </small>
                        </h3>
                    </header>
                    <div class="card-body px-0" style="box-shadow:none">
                        <div class="table-responsive my-3">
                            <table class="table table-bordered mb-0" id="myTable_1" style="font-size: 11px;">
                                <thead class="bg-dark text-white">
                                <tr>
                                    <th scope="col" style="width: 12px">sno</th>
                                    <th scope="col" class="task_label2">Project Name</th>
                                    <th scope="col" class="month_label">Code</th>
                                    <th scope="col" class="task_label">Task/Function</th>
                                    <th scope="col" class="estimation_label">Est. Rate</th>
                                    <th scope="col" class="estimation_dlabel">Est. Days</th>
                                    <th scope="col" class="task_label2">Comment</th>
                                </tr>
                                </thead>
                                <tbody class="listing-more">
                                <?php $det=$admin->list_current_weekly_project_planner_details($planner_id);
                                if ($det->num_rows > 0) {$n=0;
                                    while ($detail = $det->fetch_assoc()) {++$n;
                                        ?>
                                        <tr>
                                            <td><?=$n;?></td>
                                            <td>
                                                <input type="hidden" id="t_d_id_<?=$n;?>" name="t_d_id[<?=$n;?>]" value="<?=$detail['planner_id'];?>">
                                                <input type="text" name="code[<?=$n;?>]" id="code_<?=$n;?>" value="<?=$detail['project_name'];?>" data-sno="<?=$n;?>" readonly>
                                            </td>
                                            <td><input type="text" name="pro_code_<?=$n;?>" id="pro_code_<?=$n;?>" value="<?=$detail['project_code'];?>" readonly></td>
                                            <td><input class="task_detail" type="text" name="task[<?=$n;?>]" id="task_<?=$n;?>" value="<?=$detail['project_task'];?>" readonly></td>
                                            <td>
                                                <input class="" type="text" name="com_rate[<?=$n;?>]" id="com_rate_<?=$n;?>" value="<?=$detail['completion_rate'];?>" readonly>
                                            </td>
                                            <td><input class="" type="text" name="com_days[<?=$n;?>]" id="com_days_<?=$n;?>" value="<?=$detail['completion_days']." day(s)";?>" readonly></td>
                                            <td><input class="comment" type="text" name="comment[<?=$n;?>]" id="comment_<?=$n;?>" value="<?=$detail['comment'];?>" readonly></td>
                                        </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </section>

            <section class="list_wrapper_2 mt-5">
                <section class="card card-featured card-featured-warning rounded-0 my-4">
                    <header class="card-header p-2">
                        <h3 class="card-title" style="font-size:15px;">NEXT AND UPCOMING PROJECT</h3>
                    </header>
                    <div class="card-body px-0" style="box-shadow:none">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="myTable_2" style="font-size: 11px;">
                                <thead class="bg-dark text-white">
                                <tr>
                                    <th scope="col" style="width: 12px">sno</th>
                                    <th scope="col" class="task_label2">Project Name</th>
                                    <th scope="col" class="month_label">Code</th>
                                    <th scope="col" class="task_label">Task/Function </th>
                                    <th scope="col" class="estimation_label">Est. Rate</th>
                                    <th scope="col" class="estimation_dlabel">Est. Days</th>
                                    <th scope="col" class="task_label2">Comment</th>
                                </tr>
                                </thead>
                                <tbody class="listing-more-2">
                                <?php $nxt_det=$admin->list_next_weekly_project_planner_details($planner_id);
                                if ($nxt_det->num_rows > 0) {$n=0;
                                while ($nxt_detail = $nxt_det->fetch_assoc()) {++$n;
                                ?>
                                    <tr>
                                        <td><?=$n;?></td>
                                        <td>
                                            <input type="hidden" id="t_d_id_<?=$n;?>" name="t_d_id[<?=$n;?>]" value="<?=$nxt_detail['planner_id'];?>">
                                            <input type="text" name="code[<?=$n;?>]" id="code_<?=$n;?>" value="<?=$nxt_detail['project_name'];?>" data-nxt_sno="<?=$n;?>" readonly>
                                        </td>
                                        <td><input type="text" name="pro_code_<?=$n;?>" id="pro_code_<?=$n;?>" value="<?=$nxt_detail['project_code'];?>" readonly></td>
                                        <td><input class="task_detail" type="text" name="task[<?=$n;?>]" id="task_<?=$n;?>" value="<?=$nxt_detail['project_task'];?>" readonly></td>
                                        <td>
                                            <input class="" type="text" name="com_rate[<?=$n;?>]" id="com_rate_<?=$n;?>" value="<?=$nxt_detail['completion_rate'];?>" readonly>
                                        </td>
                                        <td><input class="" type="text" name="com_days[<?=$n;?>]" id="com_days_<?=$n;?>" value="<?=$nxt_detail['completion_days'];?> day(s)" readonly></td>
                                        <td><input class="comment" type="text" name="comment[<?=$n;?>]" id="comment_<?=$n;?>" value="<?=$nxt_detail['comment'];?>" readonly></td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </section>
        </div>
    </section>
</section>
<?php include_once("inc/footer.adm.php"); ?>
