<?php
if (!isset($_GET['timesheet_id']) || $_GET['timesheet_id'] == NULL ) {
    echo "<script>window.location = 'my-saved-timesheets'; </script>";
} else { $timesheet_id = $_GET['timesheet_id']; }
?>
<?php include_once("inc/header.adm.php"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Edit Timesheet</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Edit Timesheet</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title"><a href="timesheets"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Edit Timesheet
                <small class="text-color-danger">(N.B: Time per day is measured in hrs)</small>
            </h2>
        </header>
        <div class="card-body">
            <form name="updateTimesheet" id="updateTimesheet">
                <?php
                $tim=$admin->get_timesheet_by_id($timesheet_id);
                    if ($tim->num_rows > 0) {
                    while ($timesheet = $tim->fetch_assoc()) {
                ?>
                <div class="form-group row">
                    <div class="col-sm-6 pb-3">
                        <label for="department">DEPARTMENT:</label>
                        <input type="hidden" name="department" id="department" value="<?=$timesheet['department_id'];?>">
                        <input type="text" class="form-control" value="<?=$timesheet['department_name'];?>"  readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="employee_name">NAME:</label>
                        <input type="text" class="form-control" value="<?=$timesheet['user_name'];?>"  readonly>
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="employee_unit">DESIGNATION:</label>
                        <input class="form-control" type="text" id="employee_unit" name="employee_unit" value="<?=$timesheet['user_unit'];?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="from_date">FROM (START) - SUNDAY:</label>
                        <input type="hidden" name="ts_id" id="ts_id" value="<?=$timesheet_id;?>">
                        <input type="date" class="form-control from_date" id="from_date" name="from_date" value="<?=$timesheet['from_date'];?>" readonly>
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="to_date">TO (END) - SATURDAY:</label>
                        <input type="date" class="form-control to_date" id="to_date" name="to_date" value="<?=$timesheet['to_date'];?>" readonly>
                    </div>
                </div>
                <?php } } else { echo "<script>window.location = 'timesheets'; </script>"; } ?>
                <div class="form-group row my-3"></div>
                <section class="list_wrapper">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="myTable" style="font-size: 11px;">
                                <thead class="bg-dark text-white">
                                <tr>
                                    <th scope="col" style="width: 12px">#</th>
                                    <th scope="col" class="pro_label">PROJECT NAME</th>
                                    <th scope="col" class="month_label">CODE</th>
                                    <th scope="col" class="task_label">TASK/FUNCTION </th>
                                    <th scope="col" class="month_label">SUN</th>
                                    <th scope="col" class="month_label">MON</th>
                                    <th scope="col" class="month_label">TUE</th>
                                    <th scope="col" class="month_label">WED</th>
                                    <th scope="col" class="month_label">THR</th>
                                    <th scope="col" class="month_label">FRI</th>
                                    <th scope="col" class="month_label">SAT</th>
                                    <th scope="col" class="month_label">PERCENTAGE(%) COMPLETION</th>
                                    <th scope="col" class="month_label">COMPLETION EST. DAYS</th>
                                    <th scope="col" class="month_label">RATING</th>
                                    <th scope="col" class="pro_label">RESULT</th>
                                </tr>
                                </thead>
                                <tbody class="listing-more">
                                <?php $det=$admin->list_timesheet_details_full($timesheet_id);
                                if ($det->num_rows > 0) {$n=0;
                                    while ($detail = $det->fetch_assoc()) {++$n;
                                        ?>
                                <tr>
                                    <td><a href="javascript:void " class="px-1"><i class="fa fa-trash" style="opacity:0;outline: none"></i></a></td>
                                    <td>
                                        <input type="hidden" id="t_d_id_<?=$n;?>" name="t_d_id[<?=$n;?>]" value="<?=$detail['timesheet_id'];?>">
                                        <input type="text" name="code[<?=$n;?>]" id="code_<?=$n;?>" data-sno="<?=$n;?>" value="<?=$detail['project_name'];?>">
                                    </td>
                                    <td><input type="text" value="<?=$detail['project_code'];?>" readonly></td>
                                    <td><input class="task_detail" type="text" value="<?=$detail['project_task'];?>"></td>
                                    <td><input class="monthly_inputs sunday" type="number"  value="<?=($detail['pro_sun']==0)?'':$detail['pro_sun'];?>"></td>
                                    <td><input class="monthly_inputs monday" type="number"  value="<?=($detail['pro_mon']==0)?'':$detail['pro_mon'];?>"></td>
                                    <td><input class="monthly_inputs tuesday" type="number"  value="<?=($detail['pro_tue']==0)?'':$detail['pro_tue'];?>"></td>
                                    <td><input class="monthly_inputs wesday" type="number"  value="<?=($detail['pro_wed']==0)?'':$detail['pro_wed'];?>"></td>
                                    <td><input class="monthly_inputs thursday" type="number" value="<?=($detail['pro_thur']==0)?'':$detail['pro_thur'];?>"></td>
                                    <td><input class="monthly_inputs friday" type="number"  value="<?=($detail['pro_fri']==0)?'':$detail['pro_fri'];?>"></td>
                                    <td><input class="monthly_inputs saturday" type="number"  value="<?=($detail['pro_sat']==0)?'':$detail['pro_sat'];?>"></td>
                                    <td>
                                        <select class="border-0 py-0 percentage_comp" name="p_comp[<?=$n;?>]" id="p_comp_<?=$n;?>">
                                            <option value="20" <?=($detail['percent_complete']=='20')?"selected":'';?>>0 - 20%</option>
                                            <option value="40" <?=($detail['percent_complete']=='40')?"selected":'';?>>21% - 40%</option>
                                            <option value="60" <?=($detail['percent_complete']=='60')?"selected":'';?>>41% - 60%</option>
                                            <option value="80" <?=($detail['percent_complete']=='80')?"selected":'';?>>61% - 80%</option>
                                            <option value="100" <?=($detail['percent_complete']=='100')?"selected":'';?>>81% - 100%</option>
                                        </select>
                                    </td>
                                    <td><span class="font-weight-extra-bold"><?=$detail['completion_days'];?></span></td>
                                    <td><?=($detail['app_rating']>=60)?'<span class="text-success font-weight-extra-bold">'.$detail['app_rating'].'%</span>':
                                            '<span class="text-danger font-weight-extra-bold">'.$detail['app_rating'].'%</span>';?></td>
                                    <td><input class="result" type="text" name="result[<?=$n;?>]" id="result_<?=$n;?>" value="<?=$detail['result'];?>"></td>
                                </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </section>
</section>
<?php include_once("inc/footer.adm.php"); ?>