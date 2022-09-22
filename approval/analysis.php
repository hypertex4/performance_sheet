<?php include_once("inc/header.app.php"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Analysis - Performance Sheet</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Performance sheet analysis</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <h4 class="font-weight-bold text-dark">Filter Options:</h4>
        <div class="col-lg-10 col-xl-10">
            <div class="toggle toggle-quaternary toggle-sm" data-plugin-toggle>
                <section class="toggle my_tog">
                    <label class="rounded-0">PROJECT'S CATEGORY</label>
                    <div class="toggle-content bg-white p-3" style="display: none;">
                        <div class="form-group row pb-4" style="font-size: 12px">
                            <?php
                            $pr = $user->list_distinct_project_category();
                            if ($pr->num_rows > 0) {$n=1;
                                while ($pro = $pr->fetch_assoc()) {$n++;
                                    ?>
                                    <div class="col-12 col-md-4 pb-2">
                                        <div class="checkbox-custom checkbox-default text-capitalize">
                                            <input type="checkbox" id="pro_<?=$n;?>" value="<?=$pro['project_category'];?>" class="category_check project_category">
                                            <label for="pro_<?=$n;?>"><?=$pro['project_category'];?></label>
                                        </div>
                                    </div>
                                <?php } } ?>
                            <input type="hidden" class="project_category_input_array">
                        </div>
                        <div class="form-group row py-3" style="font-size: 12px">
                            <div class="col-12 col-md-12">
                                <input type="button" class="btn btn-default shadow-none px-4" value="Clear All" id="clearProCatCheck"/>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-lg-10 col-xl-10">
            <div class="toggle toggle-quaternary toggle-sm" data-plugin-toggle>
                <section class="toggle my_tog">
                    <label class="rounded-0">PROGRAMME'S NAME</label>
                    <div class="toggle-content bg-white p-3" style="display: none;">
                        <div class="form-group row pb-4" style="font-size: 12px">
                            <?php
                            $pr = $user->list_all_projects();
                            if ($pr->num_rows > 0) {
                            while ($pro = $pr->fetch_assoc()) {
                            ?>
                            <div class="col-12 col-md-4 pb-2">
                                <div class="checkbox-custom checkbox-default text-capitalize">
                                    <input type="checkbox" id="pro_<?= $pro['project_id']; ?>" value="<?= $pro['project_code']; ?>" class="category_check project_name">
                                    <label for="pro_<?= $pro['project_id']; ?>"><?= $pro['project_name']; ?></label>
                                </div>
                            </div>
                            <?php } } ?>
                            <input type="hidden" class="project_input_array">
                        </div>
                        <div class="form-group row py-3" style="font-size: 12px">
                            <div class="col-12 col-md-12">
                                <input type="button" class="btn btn-default shadow-none px-4" value="Clear All" id="clearCheck"/>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-lg-10 col-xl-10">
            <div class="toggle toggle-quaternary toggle-sm" data-plugin-toggle>
                <section class="toggle">
                    <label class="rounded-0">EMPLOYEE'S NAME</label>
                    <div class="toggle-content bg-white p-3" style="display: none;">
                        <div class="form-group row pb-4" style="font-size: 12px">
                            <?php
                            $de = $user->list_distinct_emp_for_approval($_SESSION['emp_login']['emp_id']);
                            if ($de->num_rows > 0) {
                            while ($emp = $de->fetch_assoc()) {
                            ?>
                            <div class="col-12 col-md-3 pb-2">
                                <div class="checkbox-custom checkbox-default text-capitalize">
                                    <input type="checkbox" id="name_<?=$emp['user_id'];?>" value="<?=$emp['user_id'];?>" class="category_check emp_name">
                                    <label for="name_<?=$emp['user_id'];?>"><?= $emp['user_name']; ?></label>
                                </div>
                            </div>
                            <?php } } ?>
                            <input type="hidden" class="emp_name_input_array">
                        </div>
                        <div class="form-group row py-3" style="font-size: 12px">
                            <div class="col-12 col-md-12">
                                <input type="button" class="btn btn-default shadow-none px-4" value="Clear All" id="clearCheckName"/>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-lg-10 col-xl-10">
            <div class="toggle toggle-quaternary toggle-sm" data-plugin-toggle>
                <section class="toggle">
                    <label class="rounded-0">DATE RANGE</label>
                    <div class="toggle-content bg-white p-3" style="display: none;">
                        <div class="form-group row pb-4" style="font-size: 12px">
                            <div class="col-lg-8 col-10">
                                <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control" name="from_date" placeholder="From date">
                                    <span class="input-group-text border-start-0 border-end-0 rounded-0">to</span>
                                    <input type="text" class="form-control" name="to_date" placeholder="To date">
                                </div>
                            </div>
                            <div class="col-lg-4 col-2">
                                <input type="button" value="Apply" class="btn btn-success shadow-none px-4" id="dateFilterApply">
                                <input type="button" class="btn btn-default shadow-none px-2 ml-2" value="Clear" id="clearDate"/>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="card card-featured mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0" style="width:100%;font-size: 11px;" id="datatable-tabletools">
                            <thead class="bg-dark text-white">
                            <tr>
                                <th class="staff_name_label">EMPLOYEE NAME</th>
                                <th class="designation_label">DESIGNATION</th>
                                <th class="task_label4">PROJECT CATEGORY</th>
                                <th class="proj_code_label">CODE</th>
                                <th class="task_label3">TASK/FUNCTION </th>
                                <th class="unit_label">UNIT</th>
                                <th class="date_label">FROM</th>
                                <th class="date_label">TO</th>
                                <th class="task_label4">RESULT</th>
                                <th class="date_label">RATING</th>
                                <th class="total_time_label">TOTAL HRS</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.app.php"); ?>
<script>
    $(document).ready(function(){
        var dataTable = $('#datatable-tabletools').dataTable({
            "scrollX": true,
            "lengthMenu": [[50,100,150,200,-1], [50,100,150,200,"All"]],
            "bSort":false,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'inc/analysisInc.php',
                'data': function(data){
                    // Read values
                    var from_date = $('input[name=from_date]').val();
                    var to_date = $('input[name=to_date]').val();

                    var project_category_arr = $(".project_category_input_array").val();
                    var project_arr = $(".project_input_array").val();
                    var emp_name_arr = $(".emp_name_input_array").val();

                    // Append to data
                    data.from_date = from_date;
                    data.to_date = to_date;
                    data.project_arr = project_arr;
                    data.project_category_arr = project_category_arr;
                    data.emp_name_arr = emp_name_arr;
                }
            },
            'columns': [
                { data: 'user_name' },
                { data: 'user_unit' },
                { data: 'project_category' },
                { data: 'project_id' },
                { data: 'project_task' },
                { data: 'department_name' },
                { data: 'from_date' },
                { data: 'to_date' },
                { data: 'result' },
                { data: 'app_rating' },
                { data: 'total' },
            ],
            dom: '<"text-end mb-md mb-3"B><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>rtip',
            buttons: [
                {extend: 'print', text: 'Print'},
                {extend: 'excel', text: 'Export to Excel'},
            ],
        });

        $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');

        $('#dateFilterApply').click(function(){
            dataTable.DataTable().draw();
        });

        $("#clearDate").on("click", function () {
            $("input[name=from_date]").val("");
            $("input[name=to_date]").val("");
            dataTable.DataTable().draw();
        });

        $(".content-body").on('click','.category_check',function (e) {
            var project_name = get_filter_text('project_name');
            let project_category = get_filter_text('project_category');
            var emp_name = get_filter_text('emp_name');

            $(".project_input_array").val(project_name);
            $(".project_category_input_array").val(project_category);
            $(".emp_name_input_array").val(emp_name);
            // alert(project_category); return;
            dataTable.DataTable().draw();
        });

        $("#clearCheck").on("click", function () {
            $(".project_name").each(function(){ $(this).prop("checked",false); });
            $(".project_input_array").val("");
            dataTable.DataTable().draw();
        });

        $("#clearProCatCheck").on("click", function () {
            $(".project_category").each(function(){ $(this).prop("checked",false); });
            $(".project_category_input_array").val("");
            dataTable.DataTable().draw();
        });

        $("#clearCheckName").on("click", function () {
            $(".emp_name").each(function(){ $(this).prop("checked",false); });
            $(".emp_name_input_array").val("");
            dataTable.DataTable().draw();
        });
    });
</script>
<script>
    function get_filter_text(text_id) {
        var filterData = [];
        $('.'+text_id+':checked').each(function() {
            var tex = $(this).val();
            var text = tex.replace(/\s{2,}/g, ' ').trim();
            filterData.push(text);
        });
        return filterData;
    }
</script>