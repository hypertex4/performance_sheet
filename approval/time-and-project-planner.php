<?php include_once("inc/header.app.php"); ?>
<?php $dept = $user->get_user_dept($_SESSION['emp_login']['emp_department']);  ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Project Planner</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Project Planner</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Upload Weekly Time/Project Planner </small></h2>
        </header>
        <div class="card-body">
            <form name="createTimePlanner" id="createTimePlanner">
                <div class="form-group row">
                    <div class="col-sm-6 pb-3">
                        <label for="department">DEPARTMENT:</label>
                        <input type="hidden" name="department" id="department" value="<?=$dept['department_id'];?>">
                        <input type="text" class="form-control" value="<?=$dept['department_name'];?>"  readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="employee_name">EMPLOYEE NAME:</label>
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
                        <label for="from_date">CURRENT WEEK ENDED DATE (Sat):</label>
                        <input type="date" class="form-control from_date" id="from_date" name="from_date">
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="to_date">PROJECTED WEEK STARTED DATE (Sun):</label>
                        <input type="date" class="form-control to_date" id="to_date" name="to_date">
                    </div>
                </div>
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
                            <div class="mb-3">
                                <a href="javascript:void " class="btn btn-outline-success shadow-none rounded-0 add_time_planner">
                                    <i class="fas fa-plus">&nbsp;&nbsp;</i>Add
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" id="myTable_1" style="font-size: 11px;">
                                    <thead class="bg-dark text-white">
                                    <tr>
                                        <th scope="col" style="width: 12px">#</th>
                                        <th scope="col" class="task_label2">PROJECT NAME</th>
                                        <th scope="col" class="month_label">CODE</th>
                                        <th scope="col" class="task_label">TASK/FUNCTION </th>
                                        <th scope="col" class="estimation_label">EST. RATE</th>
                                        <th scope="col" class="estimation_dlabel">EST. DAYS</th>
                                        <th scope="col" class="task_label2">COMMENT</th>
                                    </tr>
                                    </thead>
                                    <tbody class="listing-more">
                                    <tr>
                                        <td></td>
                                        <td>
                                            <select style="width:100%" name="pro_name[]" id="pro_name_1" class="border-0 p-1 project_name" data-sno="1"></select>
                                        </td>
                                        <td><input type="text" name="pro_code[]" id="pro_code_1" class="project_code" readonly></td>
                                        <td><input type="text" class="task_detail" name="task[]" id="task_1"></td>
                                        <td>
                                            <select class="border-0 completion_rate p-1" name="com_rate[]" id="com_rate_1" style="width:100%">
                                                <option value="0-20">0 - 20%</option>
                                                <option value="21-40">21% - 40%</option>
                                                <option value="41-60">41% - 60%</option>
                                                <option value="61-80">61% - 80%</option>
                                                <option value="81-100">81% - 100%</option>
                                            </select>
                                        </td>
                                        <td><input class="completion_days text-center" type="number" name="com_days[]" id="com_days_1"></td>
                                        <td>
                                            <input type="text" name="comment[]" id="comment_1" class="comment">
                                            <input type="hidden" name="type" id="type" class="type" value="CURRENT">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </section>

                <section class="list_wrapper_2 mt-5">
                    <section class="card card-featured card-featured-warning rounded-0 my-4">
                        <header class="card-header p-2">
                            <h3 class="card-title" style="font-size:15px;">NEXT AND UPCOMING PROJECT
                                <small style="font-style: italic">(Do not repeat continuing projects listed above)</small>
                            </h3>
                        </header>
                        <div class="card-body px-0" style="box-shadow:none">
                            <div class="mb-3">
                                <a href="javascript:void " class="btn btn-outline-success shadow-none rounded-0 add_time_planner">
                                    <i class="fas fa-plus">&nbsp;&nbsp;</i>Add
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" id="myTable_2" style="font-size: 11px;">
                                    <thead class="bg-dark text-white">
                                    <tr>
                                        <th scope="col" style="width: 12px">#</th>
                                        <th scope="col" class="task_label2">PROJECT NAME</th>
                                        <th scope="col" class="month_label">CODE</th>
                                        <th scope="col" class="task_label">TASK/FUNCTION </th>
                                        <th scope="col" class="estimation_label">EST. RATE</th>
                                        <th scope="col" class="estimation_dlabel">EST. DAYS</th>
                                        <th scope="col" class="task_label2">COMMENT</th>
                                    </tr>
                                    </thead>
                                    <tbody class="listing-more-2">
                                    <tr>
                                        <td></td>
                                        <td>
                                            <select style="width:100%" name="nxt_pro_name[]" id="nxt_pro_name_1" class="border-0 p-1 nxt_project_name" data-nxt_sno="1"></select>
                                        </td>
                                        <td><input type="text" name="nxt_pro_code[]" id="nxt_pro_code_1" class="nxt_project_code" readonly></td>
                                        <td><input type="text" class="nxt_task_detail" name="nxt_task[]" id="nxt_task_1"></td>
                                        <td>
                                            <select class="border-0 nxt_completion_rate p-1" name="nxt_com_rate[]" id="nxt_com_rate_1" style="width:100%">
                                                <option value="0-20">0 - 20%</option>
                                                <option value="21-40">21% - 40%</option>
                                                <option value="41-60">41% - 60%</option>
                                                <option value="61-80">61% - 80%</option>
                                                <option value="81-100">81% - 100%</option>
                                            </select>
                                        </td>
                                        <td><input class="nxt_completion_days text-center" type="number" name="nxt_com_days[]" id="nxt_com_days_1"></td>
                                        <td>
                                            <input type="text" name="nxt_comment[]" id="nxt_comment_1" class="nxt_comment">
                                            <input type="hidden" name="nxt_type" id="nxt_type" class="nxt_type" value="PROJECTED">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </section>
                <div class="row">
                    <div class="col-sm-12 pt-1">
                        <input class="btn btn-success px-5" type="submit" value="Upload" id="projectPlanerBtn" />
                    </div>
                </div>
            </form>
        </div>
    </section>
</section>
<?php include_once("inc/footer.app.php"); ?>
<script>
    $("#myTable_1").on('change', '.project_name', function () {
        var value = $(this).find('option:selected').val();
        var sno = $(this).data("sno");
        $("#pro_code_"+sno).val(value);
    });
    $(".project_name").load("inc/getProjectCode.php");
    $("#myTable_2").on('change', '.nxt_project_name', function () {
        var value = $(this).find('option:selected').val();
        var nxt_sno = $(this).data("nxt_sno");
        $("#nxt_pro_code_"+nxt_sno).val(value);
    });
    $(".nxt_project_name").load("inc/getProjectCode.php");
</script>
<script>
    var initTitle = document.title;
    var newTitle = `${initTitle} | User guide in form format`;
    document.title = newTitle;
</script>
<script>
    $(document).ready(function () {
        var count = 1;
        var nxt_count = 1;

        $(".list_wrapper").on('click', '.add_time_planner', function (e) {
            ++count;
            var selectClone = $('.project_name').clone();
            $('.listing-more').append('<tr id="dynamic_field'+count+'">' +
                '<td><a href="javascript:void" class="px-1 text-danger btn_remove" id="'+count+'"><i class="fas fa-trash"></i></a></td>'+
                '<td><select style="width:100%" name="pro_name[]" id="pro_name_'+count+'" class="border-0 project_name" data-sno="'+count+'">'+selectClone.html()+'</select>'+
                '</td><td><input type="text" name="pro_code[]" id="pro_code_'+count+'" class="project_code" readonly></td>'+
                '<td><input type="text" class="task_detail" name="task[]" id="task_'+count+'"></td>'+
                '<td><div class="select_drop_wrapper"><select class="custom-select border-0 completion_rate" name="com_rate[]" id="com_rate_'+count+'">'+
                '<option value="0-20">0 - 20%</option><option value="21-40">21% - 40%</option><option value="41-60">41% - 60%</option>'+
                '<option value="61-80">61% - 80%</option><option value="81-100">81% - 100%</option></select></div></td>'+
                '<td><input class="completion_days text-center" type="number" name="com_days[]" id="com_days_'+count+'"></td>'+
                '<td><input type="text" name="comment[]" id="comment_'+count+'" class="comment"></td>'+
                '</tr>');
        });

        $(".list_wrapper").on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#dynamic_field'+button_id+'').remove();
            --count;
        });

        $(".list_wrapper_2").on('click', '.add_time_planner', function (e) {
            ++nxt_count;
            var selectClone = $('.nxt_project_name').clone();
            $('.listing-more-2').append('<tr id="nxt_dynamic_field'+nxt_count+'">' +
                '<td><a href="javascript:void" class="px-1 text-danger btn_remove" id="'+nxt_count+'"><i class="fas fa-trash"></i></a></td>'+
                '<td><select style="width:100%" name="nxt_pro_name[]" id="nxt_pro_name_'+nxt_count+'" class="border-0 nxt_project_name" data-nxt_sno="'+nxt_count+'">'+selectClone.html()+'</select>'+
                '</td><td><input type="text" name="nxt_pro_code[]" id="nxt_pro_code_'+nxt_count+'" class="nxt_project_code" readonly></td>'+
                '<td><input type="text" class="nxt_task_detail" name="nxt_task[]" id="nxt_task_'+nxt_count+'"></td>'+
                '<td><div class="select_drop_wrapper"><select class="custom-select border-0 nxt_completion_rate" name="nxt_com_rate[]" id="nxt_com_rate_'+nxt_count+'">'+
                '<option value="0-20">0 - 20%</option><option value="21-40">21% - 40%</option><option value="41-60">41% - 60%</option>'+
                '<option value="61-80">61% - 80%</option><option value="81-100">81% - 100%</option></select></div></td>'+
                '<td><input class="nxt_completion_days text-center" type="number" name="nxt_com_days[]" id="nxt_com_days_'+nxt_count+'"></td>'+
                '<td><input type="text" name="nxt_comment[]" id="nxt_comment_'+nxt_count+'" class="nxt_comment"></td>'+
                '</tr>');
        });

        $(".list_wrapper_2").on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#nxt_dynamic_field'+button_id+'').remove();
            --nxt_count;
        });

        $('form#createTimePlanner').on('submit', function () {
            $('.project_name').each(function () {
                $(this).rules("add", {required: true, messages: {required: "",}});
            });
            $('.nxt_project_name').each(function () {
                $(this).rules("add", {required: true, messages: {required: "",}});
            });
            $('.task_detail').each(function () {
                $(this).rules("add", {required: true, messages: {required: "required",}});
            });
            $('.nxt_task_detail').each(function () {
                $(this).rules("add", {required: true, messages: {required: "required",}});
            });
            $('.completion_days').each(function () {
                $(this).rules("add", {required: true, messages: {required: "required",}});
            });
            $('.nxt_completion_days').each(function () {
                $(this).rules("add", {required: true, messages: {required: "required",}});
            });
            $(".department").rules("add", {required: true, messages: {required: "DEPARTMENT IS REQUIRED",}});
            $(".employee_name").rules("add", {required: true, messages: {required: "EMPLOYEE NAME IS REQUIRED",}});
            $(".employee_unit").rules("add", {required: true, messages: {required: "EMPLOYEE UNIT IS REQUIRED",}});
            $(".from_date").rules("add", {required: true, messages: {required: "DATE IS REQUIRED",}});
            $(".to_date").rules("add", {required: true, messages: {required: "DATE IS REQUIRED",}});
        });

        $("#createTimePlanner").validate({
            ignore:"",
            submitHandler: function(form, e) {
                e.preventDefault();

                var $form = $('#createTimePlanner'), $submitButton = $(this.submitButton), submitButtonText = $submitButton.val();
                $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
                $.ajax({
                    url: "../controllers/create-time-planner-func.php", type: "POST", data: $form.serialize(),
                    success: function (data) {
                        $.alert({
                            icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                            columnClass: 'col-md-6 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.reload();}}
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