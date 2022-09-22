<?php include_once("inc/header.adm.php"); ?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Dashboard: Departments</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>All Departments</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">All Departments</h2>
        </header>
        <div class="card-body">
            <div class="text-end mb-3">
                <a class="btn btn-success px-4 rounded-0 shadow-none add-department" href="#addDepartmentModal">Add new department</a>
            </div>
            <table class="table table-bordered table-striped mb-0" id="" style="font-size: 12px">
                <thead class="bg-dark text-white">
                <tr>
                    <th>s/n</th>
                    <th width="50%">Department name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $dep = $admin->list_all_dept();
                if ($dep->num_rows > 0) { $n=0;
                while ($dept = $dep->fetch_assoc()) {
                ?>
                        <tr>
                            <th><?=++$n;?></th>
                            <th><?= $dept['department_name'];?></th>
                            <td>
                                <a class="btn btn-xs btn-default text-success edit-department" href="#editDepartmentModal" id="edit_department"
                                        data-did="<?=$dept['department_id'];?>" data-dname="<?=$dept['department_name'];?>">
                                    <i class="fas fa-edit">&nbsp;</i>edit file
                                </a>
                                <button class="btn btn-xs btn-danger shadow-none" id="delete_department" data-did="<?= $dept['department_id']; ?>">
                                    <i class="fas fa-trash-alt">&nbsp;</i>delete
                                </button>
                            </td>
                        </tr>
                    <?php } } else { echo "<tr><td colspan='12' class='text-center'>No department found</td></tr>";} ?>
                </tbody>
            </table>
        </div>
    </section>

    <div id="editDepartmentModal" class="modal-block modal-block-primary mfp-hide">
        <form name="updateDepartment" id="updateDepartment" class="card">
            <header class="card-header">
                <h2 class="card-title">Edit Department</h2>
            </header>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="edit_dept_name">Department Name</label>
                        <input type="text" class="form-control" id="edit_dept_name" name="edit_dept_name">
                        <input type="hidden" name="edit_dept_id" id="edit_dept_id">
                        <input type="hidden" name="action_code" value="202">
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

    <div id="addDepartmentModal" class="modal-block modal-block-primary mfp-hide">
        <form name="add_dept_form" id="add_dept_form" class="card">
            <header class="card-header">
                <h2 class="card-title">Add Department</h2>
            </header>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="dept_name">Department Name</label>
                        <input type="text" class="form-control" id="dept_name" name="dept_name">
                        <input type="hidden" name="action_code" value="201">
                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <input type="submit" class="btn btn-primary modal-confirm" value="Save" />
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
        $('.edit-department').magnificPopup({
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

        $('.add-department').magnificPopup({
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