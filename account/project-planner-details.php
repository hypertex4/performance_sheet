<?php include_once("inc/header.acc.php"); ?>
<?php
if (!isset($_GET['planner_id']) || $_GET['planner_id'] == NULL ) {
    echo "<script>window.location = 'account/my-saved-project-planner'; </script>";
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
            <h2 class="card-title"><a href="my-saved-project-planner">
                    <i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Weekly Project Planner Details
            </h2>
        </header>
        <div class="card-body">
            <?php
            $plan=$user->get_weekly_project_planner_by_id($planner_id);
            $dept = $user->get_user_weekly_project_dept($planner_id);
            if ($plan->num_rows > 0) {
            while ($planner = $plan->fetch_assoc()) {
            ?>
            <div class="form-group row">
                <div class="col-sm-6 pb-3">
                    <label for="department">DEPARTMENT:</label>
                    <input type="hidden" name="department" id="department" value="<?=$dept['department_id'];?>">
                    <input type="text" class="form-control" value="<?=$dept['department_name'];?>"  readonly>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 pb-3">
                    <label for="employee_name">NAME:</label>
                    <select class="form-control employee_name" name="employee_name" id="employee_name" readonly>
                        <option value="<?=$_SESSION['emp_login']['emp_id'];?>"><?=$_SESSION['emp_login']['emp_name'];?></option>
                    </select>
                </div>
                <div class="col-md-6 pb-3">
                    <label for="employee_unit">DESIGNATION:</label>
                    <input class="form-control" type="text" id="employee_unit" name="employee_unit" value="<?=$_SESSION['emp_login']['emp_unit']?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 pb-3">
                    <label for="from_date">CURRENT WEEK ENDED DATE (Sat):</label>
                    <input type="hidden" name="ts_id" id="ts_id" value="<?=$planner_id;?>">
                    <input type="date" class="form-control from_date" id="from_date" name="from_date" value="<?=$planner['from_date'];?>" readonly>
                </div>
                <div class="col-md-6 pb-3">
                    <label for="to_date">PROJECTED WEEK STARTED DATE (Sun):</label>
                    <input type="date" class="form-control to_date" id="to_date" name="to_date" value="<?=$planner['to_date'];?>" readonly>
                </div>
            </div>
            <?php } } else { echo "<script>window.location = 'my-saved-project-planner'; </script>"; } ?>
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
                                    <th scope="col" class="task_label2">PROJECT NAME</th>
                                    <th scope="col" class="month_label">CODE</th>
                                    <th scope="col" class="task_label">TASK/FUNCTION </th>
                                    <th scope="col" class="estimation_label">EST. RATE</th>
                                    <th scope="col" class="estimation_dlabel">EST. DAYS</th>
                                    <th scope="col" class="task_label2">COMMENT</th>
                                </tr>
                                </thead>
                                <tbody class="listing-more">
                                <?php $det=$user->list_current_weekly_project_planner_details($planner_id);
                                if ($det->num_rows > 0) {$n=0;
                                while ($detail = $det->fetch_assoc()) {++$n;
                                ?>
                                <tr>
                                    <td><?=$n;?></td>
                                    <td><input type="hidden" id="t_d_id_<?=$n;?>" name="t_d_id[<?=$n;?>]" value="<?=$detail['$planner_id'];?>">
                                        <select class="border-0 py-0 project_code" name="code[<?=$n;?>]" id="code_<?=$n;?>" data-sno="<?=$n;?>" readonly>
                                            <?php $proj=$user->list_all_projects();
                                            if ($proj->num_rows > 0) {
                                                while ($project = $proj->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?=$project['project_code'];?>" <?php if($project['project_code']==$detail['project_id']) echo "selected";?>>
                                                        <?=$project['project_name'];?>
                                                    </option>
                                                <?php } } ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="pro_code_<?=$n;?>" id="pro_code_<?=$n;?>" value="<?=$detail['project_id'];?>" readonly></td>
                                    <td><input class="task_detail" type="text" name="task[<?=$n;?>]" id="task_<?=$n;?>" value="<?=$detail['project_task'];?>" readonly></td>
                                    <td>
                                        <select class="border-0 py-0 completion_rate" name="com_rate[<?=$n;?>]" id="com_rate_<?=$n;?>">
                                            <option value="0-20" <?=($detail['completion_rate']=='0-20')?'selected':'';?>>0 - 20%</option>
                                            <option value="21-40" <?=($detail['completion_rate']=='21-40')?'selected':'';?>>21% - 40%</option>
                                            <option value="41-60" <?=($detail['completion_rate']=='41-60')?'selected':'';?>>41% - 60%</option>
                                            <option value="61-80" <?=($detail['completion_rate']=='61-80')?'selected':'';?>>61% - 80%</option>
                                            <option value="81-100" <?=($detail['completion_rate']=='81-100')?'selected':'';?>>81% - 100%</option>
                                        </select>
                                    </td>
                                    <td><input class="completion_days text-center" type="text" name="com_days[<?=$n;?>]" id="com_days_<?=$n;?>" value="<?=$detail['completion_days']." day(s)";?>" readonly></td>
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
                                    <th scope="col" class="task_label2">PROJECT NAME</th>
                                    <th scope="col" class="month_label">CODE</th>
                                    <th scope="col" class="task_label">TASK/FUNCTION </th>
                                    <th scope="col" class="estimation_label">EST. RATE</th>
                                    <th scope="col" class="estimation_dlabel">EST. DAYS</th>
                                    <th scope="col" class="task_label2">COMMENT</th>
                                </tr>
                                </thead>
                                <tbody class="listing-more-2">
                                <?php $nxt_det=$user->list_next_weekly_project_planner_details($planner_id);
                                if ($nxt_det->num_rows > 0) {$n=0;
                                while ($nxt_detail = $nxt_det->fetch_assoc()) {++$n;
                                ?>
                                    <tr>
                                        <td><?=$n;?></td>
                                        <td><input type="hidden" id="t_d_id_<?=$n;?>" name="t_d_id[<?=$n;?>]" value="<?=$nxt_detail['planner_id'];?>">
                                            <select class="border-0 py-0 project_code" name="code[<?=$n;?>]" id="code_<?=$n;?>" data-sno="<?=$n;?>" readonly>
                                                <?php $proj=$user->list_all_projects();
                                                if ($proj->num_rows > 0) {
                                                while ($project = $proj->fetch_assoc()) {
                                                ?>
                                                <option value="<?=$project['project_code'];?>" <?php if($project['project_code']==$nxt_detail['project_id']) echo "selected";?>>
                                                    <?=$project['project_name'];?>
                                                </option>
                                                <?php } } ?>
                                            </select>
                                        </td>
                                        <td><input type="text" name="pro_code_<?=$n;?>" id="pro_code_<?=$n;?>" value="<?=$nxt_detail['project_id'];?>" readonly></td>
                                        <td><input class="task_detail" type="text" name="task[<?=$n;?>]" id="task_<?=$n;?>" value="<?=$nxt_detail['project_task'];?>" readonly></td>
                                        <td>
                                            <select class="border-0 py-0 completion_rate" name="com_rate[<?=$n;?>]" id="com_rate_<?=$n;?>">
                                                <option value="0-20" <?=($nxt_detail['completion_rate']=='0-20')?'selected':'';?>>0 - 20%</option>
                                                <option value="21-40" <?=($nxt_detail['completion_rate']=='21-40')?'selected':'';?>>21% - 40%</option>
                                                <option value="41-60" <?=($nxt_detail['completion_rate']=='41-60')?'selected':'';?>>41% - 60%</option>
                                                <option value="61-80" <?=($nxt_detail['completion_rate']=='61-80')?'selected':'';?>>61% - 80%</option>
                                                <option value="81-100" <?=($nxt_detail['completion_rate']=='81-100')?'selected':'';?>>81% - 100%</option>
                                            </select>
                                        </td>
                                        <td><input class="completion_days text-center" type="text" name="com_days[<?=$n;?>]" id="com_days_<?=$n;?>" value="<?=$nxt_detail['completion_days'];?> day(s)" readonly></td>
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
<?php include_once("inc/footer.acc.php"); ?>
