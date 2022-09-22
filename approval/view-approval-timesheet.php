<?php include_once("inc/header.app.php"); ?>
<?php
if (!isset($_GET['timesheet_id']) || $_GET['timesheet_id'] == NULL ) {
    echo "<script>window.location = 'create-timesheet'; </script>";
} else {
    $timesheet_id = $_GET['timesheet_id'];
}
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Performance Sheet Details</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Performance Sheet Details</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title"><a href="approval-page"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>
                Approval: Performance Sheet Details
                <small class="text-color-danger">(N.B: Time per day is measured in hrs)</small>
            </h2>
        </header>
        <div class="card-body">
            <form>
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
                            <option value="<?=$timesheet['user_id'];?>"><?=$timesheet['user_name'];?></option>
                        </select>
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="employee_unit">DESIGNATION:</label>
                        <input class="form-control" type="text" id="employee_unit" name="employee_unit" value="<?=$timesheet['user_unit']?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="from_date">FROM (START) - SUNDAY:</label>
                        <input type="hidden" name="ts_id" id="ts_id" value="<?=$timesheet_id;?>">
                        <input type="date" class="form-control from_date" id="from_date" name="from_date" value="<?=$timesheet['from_date'];?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="to_date">TO (END) - SATURDAY:</label>
                        <input type="date" class="form-control to_date" id="to_date" name="to_date" value="<?=$timesheet['to_date'];?>" readonly>
                    </div>
                </div>
                <div class="form-group row my-3"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="myTable" style="font-size: 11px;">
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
                                <th scope="col" class="pro_label">RESULT</th>
                                <th scope="col" class="month_label">RATING</th>
                                <th scope="col" class="month_label">SCORE</th>
                            </tr>
                            </thead>
                            <tbody class="listing-more">
                            <?php $det=$user->list_timesheet_details_approval($timesheet_id);
                            if ($det->num_rows > 0) {$n=0;
                                while ($detail = $det->fetch_assoc()) {++$n;
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td><input type="hidden" id="t_d_id_<?=$n;?>" name="t_d_id[<?=$n;?>]" value="<?=$detail['timesheet_detail_id'];?>">
                                            <input type="text" class="project_code" name="code[<?=$n;?>]" id="code_<?=$n;?>"
                                                   data-sno="<?=$n;?>" value="<?=$detail['project_name'];?>" readonly>
                                        </td>
                                        <td><input type="text" name="pro_code_<?=$n;?>" id="pro_code_<?=$n;?>" value="<?=$detail['project_code'];?>" readonly></td>
                                        <td><input class="task_detail" type="text" name="task[<?=$n;?>]" id="task_<?=$n;?>" value="<?=$detail['project_task'];?>" readonly></td>
                                        <td><input readonly class="monthly_inputs sunday" type="number" name="sun[<?=$n;?>]" id="sun_<?=$n;?>" value="<?=($detail['pro_sun']==0)?'':$detail['pro_sun'];?>"></td>
                                        <td><input readonly class="monthly_inputs monday" type="number" name="mon[<?=$n;?>]" id="mon_<?=$n;?>" value="<?=($detail['pro_mon']==0)?'':$detail['pro_mon'];?>"></td>
                                        <td><input readonly class="monthly_inputs tuesday" type="number" name="tue[<?=$n;?>]" id="tue_<?=$n;?>" value="<?=($detail['pro_tue']==0)?'':$detail['pro_tue'];?>"></td>
                                        <td><input readonly class="monthly_inputs wesday" type="number" name="wed[<?=$n;?>]" id="wed_<?=$n;?>" value="<?=($detail['pro_wed']==0)?'':$detail['pro_wed'];?>"></td>
                                        <td><input readonly class="monthly_inputs thursday" type="number" name="thur[<?=$n;?>]" id="thur_<?=$n;?>" value="<?=($detail['pro_thur']==0)?'':$detail['pro_thur'];?>"></td>
                                        <td><input readonly class="monthly_inputs friday" type="number" name="fri[<?=$n;?>]" id="fri_<?=$n;?>" value="<?=($detail['pro_fri']==0)?'':$detail['pro_fri'];?>"></td>
                                        <td><input readonly class="monthly_inputs saturday" type="number" name="sat[<?=$n;?>]" id="sat_<?=$n;?>" value="<?=($detail['pro_sat']==0)?'':$detail['pro_sat'];?>"></td>
                                        <td>
                                            <select class="border-0 py-0 percentage_comp" name="p_comp[<?=$n;?>]" id="p_comp_<?=$n;?>" readonly>
                                                <option value="20" <?=($detail['percent_complete']=='20')?"selected":'';?>>0 - 20%</option>
                                                <option value="40" <?=($detail['percent_complete']=='40')?"selected":'';?>>21% - 40%</option>
                                                <option value="60" <?=($detail['percent_complete']=='60')?"selected":'';?>>41% - 60%</option>
                                                <option value="80" <?=($detail['percent_complete']=='80')?"selected":'';?>>61% - 80%</option>
                                                <option value="100" <?=($detail['percent_complete']=='100')?"selected":'';?>>81% - 100%</option>
                                            </select>
                                        </td>
                                        <td><input class="monthly_inputs text-center completion_days" type="number" name="com_days[<?=$n;?>]" id="com_days_<?=$n;?>" value="<?=$detail['completion_days'];?>" readonly></td>
                                        <td><input class="result" type="text" name="result[<?=$n;?>]" id="result_<?=$n;?>" value="<?=$detail['result'];?>" readonly></td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <button type="button" class="mb-1 mt-1 btn btn-default btn-xs dropdown-toggle rateBtn" data-bs-toggle="dropdown">
                                                    Rate <span class="caret"></span>
                                                </button>
                                                <div class="dropdown-menu" role="menu" style="min-width: 5rem;">
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="10" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">10%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="20" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">20%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="30" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">30%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="40" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">40%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="50" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">50%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="60" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">60%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="70" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">70%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="80" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">80%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="90" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">90%</a>
                                                    <a class="dropdown-item text-1 rate_task" data-score_rating="100" data-td_id="<?=$detail['timesheet_detail_id'];?>" href="javascript:void(0)">100%</a>
                                                    <a class="dropdown-item text-1" href="javascript:void(0)">&nbsp;</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?=($detail['app_rating']>=60)?'<span class="text-success font-weight-extra-bold">'.$detail['app_rating'].'%</span>':
                                                '<span class="text-danger font-weight-extra-bold">'.$detail['app_rating'].'%</span>';?></td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                    $rate_count = $user->count_approval_timesheet_rating($timesheet['timesheet_id']);
                    $ts_count = $user->count_approval_timesheet($timesheet['timesheet_id']);
                if($timesheet['u_h_status'] !='approved'){ ?>
                <div class="mb-4 mt-4 text-center">
                    <input type="button"
                           data-id="<?=$timesheet['timesheet_id'];?>" data-status="approved"
                           class="btn btn-lg <?=($rate_count==$ts_count)?'btn-success':'btn-dark';?> px-5" id="unitHeadAppBtn" value="Approve Performance Sheet"
                        <?=($ts_count != $rate_count)?'disabled':'';?>
                    />
                </div>
                <?php } ?>
            <?php } } else { echo "<script>window.location = 'approval-page'; </script>"; } ?>
            </form>
        </div>
    </section>
</section>
<?php include_once("inc/footer.app.php"); ?>
<script>
    $(document).ready(function () {
        $(".content-body").on("click",'#unitHeadAppBtn',function (e) {
            e.preventDefault();
            var time_id = $(this).data('id');
            var status = $(this).data('status');
            var submitButton = $(this);
            var submitButtonText = $(this).val();
            submitButton.val('Please Wait..' ).attr('disabled', true);
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to approve this performance sheet?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "del-action.php", type: "POST", data: {time_id,status,action_code:103},
                            success:(data)=>{
                                $.alert({
                                    icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                                    buttons: {ok: ()=> { window.location.replace('approval-page');}}
                                });
                            },
                            error:(err)=>{
                                $.dialog({icon:'fa fa-exclamation-triangle',title:'Error',typeAnimated:true,content:err.responseJSON.message,type:'red'});
                            },
                            complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                        });
                    },
                    cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);},
                }
            });
        });

        $(".content-body").on("click",'#unitHeadDecBtn',function (e) {
            e.preventDefault();
            var r = confirm("Are you sure you want to decline timesheet?");
            if (r === true) {
                var time_id = $(this).data('id');
                var status = $(this).data('status');

                $.confirm({
                    title: 'Comment',
                    columnClass: 'col-md-4 col-md-offset-4 col-10 col-offset-1',
                    content: '' +
                        '<form action="" class="formName"><div class="form-group"><label>Enter Reason For Decline</label>' +
                        '<textarea type="text" placeholder="Enter Comment" class="comment form-control" rows="5" required></textarea></div>' +
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Send',
                            btnClass: 'btn-green',
                            action: function () {
                                var comment = this.$content.find('.comment').val();
                                if(!comment){ $.alert('Enter comment');return false; }

                                $(this).attr("disabled",true);$(this).css("cursor",'not-allowed');$(this).html('<i class="fa fa-spinner fa-pulse px-3"></i>');
                                $.ajax({
                                    url: "del-action.php", type: "POST", data: {time_id,status,comment,action_code:102},
                                    success:(data)=>{
                                        $.alert({
                                            icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                                            buttons: {ok: ()=> { window.location.replace('approval-page');}}
                                        });
                                    },
                                    error:(err)=>{
                                        $.dialog({icon:'fa fa-exclamation-triangle',title:'Error',typeAnimated:true,content:err.responseJSON.message,type:'red'});
                                    },
                                    complete:()=>{ $('#unitHeadDecBtn').attr("disabled",false);$('#unitHeadDecBtn').css("cursor",'pointer');$('#unitHeadDecBtn').html('Done'); }
                                });
                            }
                        },
                        cancel: function () {},
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });
            } else {
                return false;
            }
        });

        $(".content-body").on("click",'.rate_task',function (e) {
            e.preventDefault();
            var rating = $(this).data('score_rating');
            var td_id = $(this).data('td_id');

            var submitButton = $("#rateBtn");
            var submitButtonText = submitButton.val();
            submitButton.val('Wait..' ).attr('disabled', true);
            $.ajax({
                url: "del-action.php", type: "POST", data: {rating,td_id,action_code:403},
                success:(data)=>{
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                        buttons: {ok: ()=> { window.location.reload();}}
                    });
                },
                error:(err)=>{
                    $.dialog({icon:'fa fa-exclamation-triangle',title:'Error',typeAnimated:true,content:err.responseJSON.message,type:'red'});
                },
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        });
    });
</script>
