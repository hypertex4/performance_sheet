<?php include_once("inc/header.adm.php"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Uploaded Project Planner</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Uploaded Project Planner</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Uploaded Project Planner</h2>
        </header>
        <div class="card-body">
            <table class="table table-bordered table-striped mb-0" id="datatable-timesheet" style="font-size: 11px">
                <thead class="bg-dark text-white">
                <tr>
                    <th>s/n</th>
                    <th scope="col" class="dept_labels">Designation</th>
                    <th scope="col" class="dept_labels">Employee Name</th>
                    <th scope="col" class="from_labels">Current Date(Sat)</th>
                    <th scope="col" class="to_labels">Projected Date(Sun)</th>
                    <th scope="col" class="to_labels">Submitted On</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $plan = $admin->list_all_user_weekly_project_planner();
                if ($plan->num_rows > 0) { $n =0;
                while ($planner = $plan->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?=++$n;?></td>
                        <td><?= $planner['user_unit'];?></td>
                        <td><?= $planner['user_name'];?></td>
                        <td><?= date("j - M - Y",strtotime($planner['from_date']));?></td>
                        <td><?= date("j - M - Y",strtotime($planner['to_date']));?></td>
                        <td><?= date("j - M - Y",strtotime($planner['created_on']));?></td>
                        <td>
                            <a class="btn btn-xs btn-default px-2" href="uploaded-planner-details/<?=$planner['planner_id'];?>">
                                <i class="fas fa-edit">&nbsp;</i>view detail
                            </a>
                        </td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>
    </section>
</section>
<?php include_once("inc/footer.adm.php"); ?>
<script>
    // $(document).ready(function() {
    //     $('#datatable-saved-planner').DataTable({
    //         "pageLength": 50,
    //         "bSort":false,
    //     });
    // });
</script>
