<?php include_once("inc/header.adm.php"); ?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Dashboard: Employees</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>All Employee</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">All Employees</h2>
        </header>
        <div class="card-body">
            <table class="table table-bordered table-striped mb-0" id="" style="font-size: 12px">
                <thead class="bg-dark text-white">
                <tr>
                    <th>s/n</th>
                    <th>Employee Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $usr = $admin->list_all_registered_user();
                if ($usr->num_rows > 0) { $n =0;
                while ($user = $usr->fetch_assoc()) {
                ?>
                    <tr>
                        <th><?=++$n;?></th>
                        <th><?= $user['user_name'];?></th>
                        <td><?= $user['user_email'];?></td>
                        <td><?= $user['department_name'];?></td>
                        <td><?= $user['user_unit'];?></td>
                        <td class="bg_primary text-center bg_primary_hover">
                            <a class="btn btn-xs btn-default text-success edit-employee" href="#editEmployeeModal" id="edit_employee"
                                    data-uid="<?=$user['user_id'];?>" data-uname="<?=$user['user_name'];?>" data-uemail="<?=$user['user_email'];?>"
                                    data-udept="<?=$user['user_department'];?>" data-udesign="<?=$user['user_unit'];?>">
                                <i class="fas fa-edit">&nbsp;</i>edit file
                            </a>
                            <button class="btn btn-xs btn-danger shadow-none" id="delete_employee" data-uid="<?= $user['user_id']; ?>">
                                <i class="fas fa-trash-alt">&nbsp;</i>delete
                            </button>
                        </td>
                    </tr>
                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No employee found</td></tr>";} ?>
                </tbody>
            </table>
        </div>
    </section>

    <div id="editEmployeeModal" class="modal-block modal-block-primary mfp-hide">
        <form name="updateEmployee" id="updateEmployee" class="card">
            <header class="card-header">
                <h2 class="card-title">Edit Project</h2>
            </header>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="edit_emp_name">Employee Name</label>
                        <input type="text" class="form-control" id="edit_emp_name" name="edit_emp_name">
                        <input type="hidden" name="edit_user_id" id="edit_user_id">
                        <input type="hidden" name="action_code" value="402">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="edit_emp_email">Employee Email</label>
                        <input type="text" class="form-control" id="edit_emp_email" name="edit_emp_email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="edit_emp_dept">Employee Department</label>
                        <select class="form-control" name="edit_emp_dept" id="edit_emp_dept">
                            <option value="">Select department</option>
                            <?php $dept=$admin->list_all_dept();
                            if ($dept->num_rows > 0) {
                                while ($department = $dept->fetch_assoc()) {
                                    ?>
                                    <option value="<?=$department['department_id'];?>"><?= $department['department_name'];?></option>
                                <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="edit_emp_design">Employee Designation</label>
                        <select class="form-control" name="edit_emp_design" id="edit_emp_design">
                            <option value="">Select Employee Designation</option>
                            <?php $dept=$admin->list_all_distinct_designation();
                            if ($dept->num_rows > 0) {
                                while ($department = $dept->fetch_assoc()) {
                                    ?>
                                    <option value="<?=$department['employee_designation'];?>"><?= $department['employee_designation'];?></option>
                                <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <input type="submit" class="btn btn-primary modal-confirm" value="Update" />
                        <button class="btn btn-default modal-dismiss">Close</button>
                    </div>
                </div>
            </footer>
        </form>
    </div>
</section>
<?php include_once("inc/footer.adm.php"); ?>
<script>
    (function($) {
        'use strict';
        $('.edit-employee').magnificPopup({
            type: 'inline',
            preloader: false,
            modal: true,
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });
    }).apply(this, [jQuery]);
</script>