<?php include_once("inc/header.adm.php"); ?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Dashboard: Projects</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>All Projects</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">All Projects</h2>
        </header>
        <div class="card-body">
            <div class="text-end mb-3">
                <a class="btn btn-success px-4 rounded-0 shadow-none add-project" href="#addProjectModal">Add new project</a>
            </div>
            <table class="table table-bordered table-striped mb-0" id="" style="font-size: 12px">
                <thead class="bg-dark text-white">
                <tr>
                    <th>s/n</th>
                    <th>Program Name</th>
                    <th>Program Code</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $proj = $admin->list_all_projects();
                if ($proj->num_rows > 0) { $n = 0;
                    while ($project = $proj->fetch_assoc()) {
                        ?>
                        <tr>
                            <th><?=++$n;?></th>
                            <th><?= $project['project_name'];?></th>
                            <td><?= $project['project_code'];?></td>
                            <td>
                                <a class="btn btn-xs btn-default text-success edit-project" href="#editProjectModal" id="edit_project"
                                    data-pid="<?=$project['project_id'];?>" data-pname="<?=$project['project_name'];?>"
                                    data-pcode="<?=$project['project_code'];?>" >
                                    <i class="fas fa-edit">&nbsp;</i>edit file
                                </a>
                                <button class="btn btn-xs btn-danger shadow-none" id="delete_project" data-pid="<?= $project['project_id']; ?>">
                                    <i class="fas fa-trash-alt">&nbsp;</i>delete
                                </button>
                            </td>
                        </tr>
                    <?php } } else { echo "<tr><td colspan='12' class='text-center'>No project found</td></tr>";} ?>
                </tbody>
            </table>
        </div>
    </section>

    <div id="editProjectModal" class="modal-block modal-block-primary mfp-hide">
        <form name="updateProject" id="updateProject" class="card">
            <header class="card-header">
                <h2 class="card-title">Edit Project</h2>
            </header>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="edit_proj_name">PROJECT NAME</label>
                        <input type="text" class="form-control" id="edit_proj_name" name="edit_proj_name">
                        <input type="hidden" name="edit_proj_id" id="edit_proj_id">
                        <input type="hidden" name="action_code" value="302">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="edit_proj_code">PROJECT CODE</label>
                        <input type="text" class="form-control" id="edit_proj_code" name="edit_proj_code">
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

    <div id="addProjectModal" class="modal-block modal-block-primary mfp-hide">
        <form name="add_project_form" id="add_project_form" class="card">
            <header class="card-header">
                <h2 class="card-title">Add Project</h2>
            </header>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                        <label for="proj_name">PROJECT NAME</label>
                        <input type="text" class="form-control" id="proj_name" name="proj_name">
                        <input type="hidden" name="action_code" value="301">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 mb-4">
                         <label for="proj_code">PROJECT CODE</label>
                        <input type="text" class="form-control" id="proj_code" name="proj_code">
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
        $('.edit-project').magnificPopup({
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

        $('.add-project').magnificPopup({
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