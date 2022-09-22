<?php
if (!isset($_GET['timesheet_id']) || $_GET['timesheet_id'] == NULL ) {
    echo "<script>window.location = 'my-saved-timesheets'; </script>";
} else { $timesheet_id = $_GET['timesheet_id']; }
?>
<?php include_once("inc/header.app.php"); ?>
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
            <h2 class="card-title"><a href="my-saved-timesheets"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Edit Timesheet
                <small class="text-color-danger">(N.B: Time per day is measured in hrs)</small>
            </h2>
        </header>
        <div class="card-body">
            <form name="updateTimesheet" id="updateTimesheet">
                <?php
                $tim=$user->get_timesheet_by_id($timesheet_id);
                $dept = $user->get_user_timesheet_dept($timesheet_id);
                if ($tim->num_rows > 0) {
                while ($timesheet = $tim->fetch_assoc()) {
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
                        <label for="from_date">FROM (START) - SUNDAY:</label>
                        <input type="hidden" name="ts_id" id="ts_id" value="<?=$timesheet_id;?>">
                        <input type="date" class="form-control from_date" id="from_date" name="from_date" value="<?=$timesheet['from_date'];?>" readonly>
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="to_date">TO (END) - SATURDAY:</label>
                        <input type="date" class="form-control to_date" id="to_date" name="to_date" value="<?=$timesheet['to_date'];?>" readonly>
                    </div>
                </div>
                <?php } } else { echo "<script>window.location = 'my-saved-timesheets'; </script>"; } ?>
                <div class="form-group row my-3"></div>
                <section class="list_wrapper">
                    <div class="container-fluid">
                        <div class="mb-3">
                            <a href="javascript:void " class="btn btn-outline-success shadow-none rounded-0 add_timesheet"
                               data-total="<?=$user->count_total_timesheet_details($timesheet_id)?>"><i class="fas fa-plus">&nbsp;&nbsp;</i>ADD
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="myTable" style="font-size: 11px;">
                                <thead class="thead-dark">
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
                                    <th scope="col" class="task_label">RESULT</th>
                                </tr>
                                </thead>
                                <tbody class="listing-more">
                                <?php $det=$user->list_timesheet_details($timesheet_id);
                                if ($det->num_rows > 0) {$n=0;
                                    while ($detail = $det->fetch_assoc()) {++$n;
                                        ?>
                                <tr>
                                    <td><a href="javascript:void " class="px-1"><i class="fa fa-trash" style="opacity:0;outline: none"></i></a></td>
                                    <td><input type="hidden" id="t_d_id_<?=$n;?>" name="t_d_id[<?=$n;?>]" value="<?=$detail['timesheet_id'];?>">
                                        <select class="border-0 py-0 project_code" name="code[<?=$n;?>]" id="code_<?=$n;?>" data-sno="<?=$n;?>">
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
                                    <td><input class="task_detail" type="text" name="task[<?=$n;?>]" id="task_<?=$n;?>" value="<?=$detail['project_task'];?>"></td>
                                    <td><input class="monthly_inputs sunday" type="number" name="sun[<?=$n;?>]" id="sun_<?=$n;?>" value="<?=($detail['pro_sun']==0)?'':$detail['pro_sun'];?>"></td>
                                    <td><input class="monthly_inputs monday" type="number" name="mon[<?=$n;?>]" id="mon_<?=$n;?>" value="<?=($detail['pro_mon']==0)?'':$detail['pro_mon'];?>"></td>
                                    <td><input class="monthly_inputs tuesday" type="number" name="tue[<?=$n;?>]" id="tue_<?=$n;?>" value="<?=($detail['pro_tue']==0)?'':$detail['pro_tue'];?>"></td>
                                    <td><input class="monthly_inputs wesday" type="number" name="wed[<?=$n;?>]" id="wed_<?=$n;?>" value="<?=($detail['pro_wed']==0)?'':$detail['pro_wed'];?>"></td>
                                    <td><input class="monthly_inputs thursday" type="number" name="thur[<?=$n;?>]" id="thur_<?=$n;?>" value="<?=($detail['pro_thur']==0)?'':$detail['pro_thur'];?>"></td>
                                    <td><input class="monthly_inputs friday" type="number" name="fri[<?=$n;?>]" id="fri_<?=$n;?>" value="<?=($detail['pro_fri']==0)?'':$detail['pro_fri'];?>"></td>
                                    <td><input class="monthly_inputs saturday" type="number" name="sat[<?=$n;?>]" id="sat_<?=$n;?>" value="<?=($detail['pro_sat']==0)?'':$detail['pro_sat'];?>"></td>
                                    <td>
                                        <select class="border-0 py-0 percentage_comp" name="p_comp[<?=$n;?>]" id="p_comp_<?=$n;?>">
                                            <option value="20" <?=($detail['percent_complete']=='20')?"selected":'';?>>0 - 20%</option>
                                            <option value="40" <?=($detail['percent_complete']=='40')?"selected":'';?>>21% - 40%</option>
                                            <option value="60" <?=($detail['percent_complete']=='60')?"selected":'';?>>41% - 60%</option>
                                            <option value="80" <?=($detail['percent_complete']=='80')?"selected":'';?>>61% - 80%</option>
                                            <option value="100" <?=($detail['percent_complete']=='100')?"selected":'';?>>81% - 100%</option>
                                        </select>
                                    </td>
                                    <td><input class="monthly_inputs text-center completion_days" type="number" name="com_days[<?=$n;?>]" id="com_days_<?=$n;?>" value="<?=$detail['completion_days'];?>"></td>
                                    <td><input class="result" type="text" name="result[<?=$n;?>]" id="result_<?=$n;?>" value="<?=$detail['result'];?>"></td>
                                </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-sm-12 py-4">
                        <?php if ($user->get_timesheet_approval_status($timesheet_id)>0){ ?>
                            <input class="btn btn-success shadow-none px-5" type="submit" value="Update" id="timeSheetUpdateBtn" />
                            <button type="button" class="btn btn-danger shadow-none px-4 float-end" style="border-radius:0" id="delTimeSheet" data-t_id="<?=$timesheet_id;?>">
                                DELETE
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </section>
</section>
<?php include_once("inc/footer.app.php"); ?>
<script>
    $("#myTable").on('change', '.project_code', function () {
        var value = $(this).find('option:selected').val();
        var sno = $(this).data("sno");
        $("#pro_code_"+sno).val(value);
    });
    $("#emp_department").on('change', function () {
        $("#employee_name").load("inc/subNameGetter.php?dept_id=" + $("#emp_department").val());
    });
    $("#employee_name").on('change', function () {
        $("#employee_unit").load("inc/subUnitGetter.php?emp_id="+ $("#employee_name").val());
    });
</script>
<script>
    $(document).ready(function () {
        var n = 1;

        $(".list_wrapper").on('click', '.add_timesheet', function (e) {
            var total = $(this).data("total");
            var count = n + total;
            n++;
            var selectClone = $('.project_code').clone();
            $('.listing-more').append('<tr id="dynamic_field'+count+'">' +
                '<td><a href="javascript:void" class="px-1 text-danger btn_remove" id="'+count+'"><i class="fa fa-trash"></i></a></td>' +
                '<td><select class="border-0 py-0 project_code" name="code['+count+']" id="code_'+count+'" data-sno="'+count+'">'+selectClone.html()+'</select></td>' +
                '<td><input class="pro_code" type="text"  name="pro_code['+count+']" id="pro_code_'+count+'" readonly></td>' +
                '<td><input class="task_detail" type="text"  name="task['+count+']" id="task_'+count+'"></td>' +
                '<td><input class="monthly_inputs sunday" type="number" name="sun['+count+']" id="sun_'+count+'"></td>' +
                '<td><input class="monthly_inputs monday" type="number" name="mon['+count+']" id="mon_'+count+'"></td>' +
                '<td><input class="monthly_inputs tuesday" type="number" name="tue['+count+']" id="tue_'+count+'"></td>' +
                '<td><input class="monthly_inputs wesday" type="number" name="wed['+count+']" id="wed_'+count+'"></td>' +
                '<td><input class="monthly_inputs thursday" type="number" name="thur['+count+']" id="thur_'+count+'"></td>' +
                '<td><input class="monthly_inputs friday" type="number" name="fri['+count+']" id="fri_'+count+'"></td>' +
                '<td><input class="monthly_inputs saturday" type="number" name="sat['+count+']" id="sat_'+count+'"></td>' +
                '<td><select class="border-0 py-0 percentage_comp" name="p_comp['+count+']" id="p_comp_'+count+'"><option value="20">0 - 20%</option>' +
                '<option value="40">21% - 40%</option><option value="60">41% - 60%</option><option value="80">61% - 80%</option>' +
                '<option value="100">81% - 100%</option> </select></td>' +
                '<td><input class="completion_days text-center" type="number" name="com_days['+count+']" id="com_days_'+count+'"></td>' +
                '<td><input class="result" type="text" name="result['+count+']" id="result_'+count+'"></td>' +
                '</tr>');
        });

        $(".list_wrapper").on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");$('#dynamic_field'+button_id+'').remove();
            --n;
        });

        $('form#updateTimesheet').on('submit', function () {
            $('.project_code').each(function () {
                $(this).rules("add", {required: true, messages: {required: "Code name is required",}});
            });
            $('.task_detail').each(function () {
                $(this).rules("add", {required: true, messages: {required: "Task is required",}});
            });
            $(".completion_days").each(function () {
                $(this).rules("add", {required: true, messages: {required: "required",}});
            });
            $(".department").rules("add", {required: true, messages: {required: "DEPARTMENT IS REQUIRED",}});
            $(".employee_name").rules("add", {required: true, messages: {required: "EMPLOYEE NAME IS REQUIRED",}});
            $(".employee_unit").rules("add", {required: true, messages: {required: "EMPLOYEE UNIT IS REQUIRED",}});
            $(".from_date").rules("add", {required: true, messages: {required: "DATE IS REQUIRED",}});
            $(".to_date").rules("add", {required: true, messages: {required: "DATE IS REQUIRED",}});
        });

        $("#updateTimesheet").validate({
            ignore: "",
            submitHandler: function (form, e) {
                e.preventDefault();
                var $form = $('#updateTimesheet'), $submitButton = $(this.submitButton), submitButtonText = $submitButton.val();
                $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);

                $.ajax({
                    url: "../controllers/update-timesheet-func.php", type: "POST", data: $form.serialize(),
                    success: function (data) {
                        $.alert({
                            icon: 'fa fa-check-circle',
                            title: 'Successful',
                            typeAnimated: true,
                            content: data.message,
                            type: 'green',
                            columnClass: 'col-md-4 col-md-offset-4 col-10 offset-1',
                            buttons: {
                                ok: () => {
                                    window.location.reload();
                                }
                            }
                        });
                    },
                    error: function (err) {
                        $.dialog({
                            icon: 'fa fa-exclamation-triangle',
                            title: 'Error!',
                            typeAnimated: true,
                            content: err.responseJSON.message,
                            type: 'red'
                        });
                    },
                    complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
                });
            }
        });

        $(".content-body").on("click",'#delTimeSheet',function (e) {
            e.preventDefault();
            var t_id = $(this).data('t_id');

            var submitButton = $(this);
            var submitButtonText = $(this).val();
            submitButton.val('wait..' ).attr('disabled', true);
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete timesheet?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "del-action.php", type: "POST", data: {t_id,action_code:101},
                            success:(data)=>{
                                $.alert({
                                    icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                                    buttons: {ok: ()=> { window.location.replace('my-saved-timesheets');}}
                                });
                            },
                            error:(err)=>{
                                $.dialog({icon:'fa fa-exclamation-triangle',title:'Error',typeAnimated:true,content:err.responseJSON.message,type:'red'});
                            },
                            complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                        });
                    }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);},
                }
            });
        });
    });
</script>