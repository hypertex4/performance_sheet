<?php include_once("inc/header.app.php"); ?>
<?php $dept = $user->get_user_dept($_SESSION['emp_login']['emp_department']); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Upload Timesheet</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Upload Timesheet</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Upload New Timesheet <small class="text-color-danger">(N.B: Time per day is measured in hrs)</small></h2>
        </header>
        <div class="card-body">
            <form name="createTimesheet" id="createTimesheet">
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
                        <input class="form-control" type="text" id="employee_unit" name="employee_unit" value="<?=$_SESSION['emp_login']['emp_unit']?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="from_date">FROM (START) - SUNDAY:</label>
                        <input type="date" class="form-control from_date" id="from_date" name="from_date">
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="to_date">TO (END) - SATURDAY:</label>
                        <input type="date" class="form-control to_date" id="to_date" name="to_date">
                    </div>
                </div>
                <div class="form-group row my-3"></div>
                <section class="list_wrapper">
                    <div class="container-fluid">
                        <div class="mb-3">
                            <a href="javascript:void " class="btn btn-outline-success shadow-none rounded-0 add_timesheet">
                                <i class="fas fa-plus">&nbsp;&nbsp;</i>ADD
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
                                <tr>
                                    <td><a href="javascript:void " class="px-1"><i class="fa fa-trash" style="opacity:0;outline: none"></i></a></td>
                                    <td><select class="border-0 py-0 project_code" name="code[1]" id="code_1" data-sno="1"></select></td>
                                    <td><input class="pro_code" type="text" name="pro_code[1]" id="pro_code_1" readonly></td>
                                    <td><input class="task_detail" type="text" name="task[1]" id="task_1"></td>
                                    <td><input class="monthly_inputs sunday" type="number" name="sun[1]" id="sun_1"></td>
                                    <td><input class="monthly_inputs monday" type="number" name="mon[1]" id="mon_1"></td>
                                    <td><input class="monthly_inputs tuesday" type="number" name="tue[1]" id="tue_1"></td>
                                    <td><input class="monthly_inputs wesday" type="number" name="wed[1]" id="wed_1"></td>
                                    <td><input class="monthly_inputs thursday" type="number" name="thur[1]" id="thur_1"></td>
                                    <td><input class="monthly_inputs friday" type="number" name="fri[1]" id="fri_1"></td>
                                    <td><input class="monthly_inputs saturday" type="number" name="sat[1]" id="sat_1"></td>
                                    <td>
                                        <select class="border-0 py-0 percentage_comp" name="p_comp[1]" id="p_comp_1">
                                            <option value="20">0 - 20%</option><option value="40">21% - 40%</option>
                                            <option value="60">41% - 60%</option><option value="80">61% - 80%</option>
                                            <option value="100">81% - 100%</option>
                                        </select>
                                    </td>
                                    <td><input class="monthly_inputs text-center completion_days" type="number" name="com_days[1]" id="com_days_1"></td>
                                    <td><input class="result" type="text" name="result[1]" id="result_1"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-sm-12 py-4">
                        <input class="btn btn-success px-5" type="submit" value="Upload" id="timeSheetBtn" />
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
    $(".project_code").load("inc/getProjectCode.php");
</script>
<script>
    $(document).ready(function () {
        var count = 1;
        $(".list_wrapper").on('click', '.add_timesheet', function (e) {
            ++count;
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
            --count;
        });

        $('form#createTimesheet').on('submit', function () {
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

        $("#createTimesheet").validate({
            ignore:"",
            submitHandler: function(form, e) {
                e.preventDefault();
                var $form = $('#createTimesheet'), $submitButton = $(this.submitButton), submitButtonText = $submitButton.val();
                $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);

                $.ajax({
                    url: "../controllers/create-timesheet-func.php", type: "POST", data: $form.serialize(),
                    success: function (data) {
                        $.alert({
                            icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                            buttons: {ok: ()=> { window.location.reload();}}
                        });
                    },
                    error: function (err) {
                        $.dialog({icon:'fa fa-exclamation-triangle',title:'Error!',typeAnimated:true,content:err.responseJSON.message,type:'red'});
                    },
                    complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
                });
            }
        });

    });
</script>
