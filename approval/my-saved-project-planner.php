<?php include_once("inc/header.app.php"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Saved Project Planner</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Saved Project Planner</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Uploaded Project Planner</h2>
        </header>
        <div class="card-body">
            <table class="table table-bordered table-striped mb-0" id="datatable-saved-planner" style="font-size: 11px">
                <thead class="bg-dark text-white">
                <tr>
                    <th>s/n</th>
                    <th scope="col" class="dept_labels">DESIGNATION</th>
                    <th scope="col" class="from_labels">CURRENT DATE</th>
                    <th scope="col" class="to_labels">PROJECTED DATE</th>
                    <th scope="col" class="to_labels">SUBMITTED ON</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $plan = $user->list_all_user_weekly_project_planner($_SESSION['emp_login']['emp_id']);
                if ($plan->num_rows > 0) { $n=0;
                    while ($planner = $plan->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?=++$n;?></td>
                            <td><?= $planner['user_unit'];?></td>
                            <td><?= date("j - M - Y",strtotime($planner['from_date']));?></td>
                            <td><?= date("j - M - Y",strtotime($planner['to_date']));?></td>
                            <td><?= date("j - M - Y h:i a",strtotime($planner['created_on']));?></td>
                            <td>
                                <a class="btn btn-default btn-xs px-2" href="project-planner-details/<?=$planner['planner_id'];?>">
                                    <i class="fas fa-list-alt">&nbsp;</i>View Details
                                </a>
                            </td>
                        </tr>
                    <?php } } else { echo "<tr><td colspan='12' class='text-center'>No project planner found</td></tr>";}  ?>
                </tbody>
            </table>
        </div>
    </section>
</section>
<?php include_once("inc/footer.app.php"); ?>
<script>
    $(document).ready(function() {
        $('#datatable-saved-planner').DataTable({
            "pageLength": 50,
            "bSort":false,
            language: {
                search:"_INPUT_",
                sSearchPlaceholder: "SEARCH BY FROM DATE, TO DATE"
            }
        });
    });
</script>
