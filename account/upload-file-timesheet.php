<?php include_once("inc/header.acc.php"); ?>
<?php $dept = $user->get_user_dept($_SESSION['emp_login']['emp_department']); ?>
<style>
    .fileupload .uneditable-input {width: 50%;}
</style>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Upload Timesheet - CSV</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Upload Timesheet CSV</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Upload New Timesheet - CSV <small class="text-color-danger">(N.B: Time per day is measured in hrs)</small></h2>
        </header>
        <div class="card-body">
            <form name="createCsvTimesheet" id="createCsvTimesheet">
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
                <div class="form-group row my-3">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-form-label" for="">UPLOAD TIMESHEET <span class="required">*</span></label>
                            <small class="text-info">(upload a csv excel format)</small>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="input-append">
                                    <div class="uneditable-input">
                                        <i class="fas fa-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                    </div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileupload-exists">Change</span><span class="fileupload-new">Select file</span>
                                        <input type="file" class="" id="docFile" name="file" accept=".csv" />
                                    </span>
                                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Clear</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 py-4">
                        <input class="btn btn-success px-5" type="submit" value="Import & Upload" id="timeSheetCsvBtn" />
                    </div>
                </div>
            </form>
        </div>
    </section>
</section>
<?php include_once("inc/footer.acc.php"); ?>
<script>
    $(document).ready(function () {
        $("form#createCsvTimesheet").on('submit', function () {
            $(".department").rules("add", {required: true, messages: {required: "DEPARTMENT IS REQUIRED",}});
            $(".employee_name").rules("add", {required: true, messages: {required: "EMPLOYEE NAME IS REQUIRED",}});
            $(".employee_unit").rules("add", {required: true, messages: {required: "EMPLOYEE UNIT IS REQUIRED",}});
            $(".from_date").rules("add", {required: true, messages: {required: "DATE IS REQUIRED",}});
            $(".to_date").rules("add", {required: true, messages: {required: "DATE IS REQUIRED",}});
            $(".csv_file").rules("add", {required: true, messages: {required: "CSV FILE IS REQUIRED",}});
        });

        $("#createCsvTimesheet").validate({
            submitHandler: function(form, e) {
                e.preventDefault();
                var dept = $("#department").val();
                var name = $("#employee_name").val();
                var unit = $("#employee_unit").val();
                var from = $("#from_date").val();
                var to = $("#to_date").val();

                var $form = form, $submitButton = $(this.submitButton), submitButtonText = $submitButton.val();
                $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
                $.ajax({
                    url: "upload.php", method: "POST", data: new FormData($form), dataType: "json",
                    contentType: false, cache: false, processData: false,
                    success: function (data) {
                        if (data.success) {
                            start_import(dept,name,unit,from,to);
                        }
                        if (data.error) {
                            $.dialog({icon: 'fa fa-exclamation-triangle', title: 'Error!', typeAnimated: true, content: data.error, type: 'red'});
                        }
                    },
                    complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
                });
            }
        });

        function start_import(dept,name,unit,from,to) {
            $.ajax({
                url:"import.php",method:"POST",data:{dept,name,unit,from,to},
                success:function () {
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:"Data successfully imported and saved",
                        type:'green', buttons: {ok: ()=> {window.location.reload(); }}
                    });
                }
            });
        }
    });
</script>
