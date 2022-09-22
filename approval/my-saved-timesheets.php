<?php include_once("inc/header.app.php"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Dashboard | Saved Timesheet</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Saved Timesheet</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Uploaded Timesheet</h2>
            </header>
            <div class="card-body">
                <table class="table table-bordered table-striped mb-0" id="datatable-timesheet-saved" style="font-size: 11px">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>s/n</th>
                        <th>Designation</th>
                        <th>From (Start)</th>
                        <th>To (End)</th>
                        <th>Status
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $time = $user->list_all_user_timesheets($_SESSION['emp_login']['emp_id']);
                    if ($time->num_rows > 0) {$n=0;
                        while ($timesheet = $time->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?=++$n;?></td>
                                <td><?= $timesheet['user_unit'];?></td>
                                <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['from_date']));?></td>
                                <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['to_date']));?></td>
                                <?php if ($timesheet['u_h_status']=='pending'){ ?>
                                    <td><span class="badge badge-danger">pending</span></td>
                                <?php } elseif ($timesheet['u_h_status']=='approved'){ ?>
                                    <td><span class="badge badge-success">approved</span></td>
                                <?php } elseif ($timesheet['u_h_status']=='declined'){ ?>
                                    <td><span class="badge badge-dark">declined</span></td>
                                <?php } ?>
                                <td>
                                    <a class="btn btn-default btn-xs px-2" href="edit-timesheet/<?=$timesheet['timesheet_id'];?>">
                                        <i class="fas fa-edit">&nbsp;</i>Edit file
                                    </a>
                                </td>
                            </tr>
                        <?php } } else { echo "<tr><td colspan='12' class='text-center'>No timesheet found</td></tr>";} ?>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
<?php include_once("inc/footer.app.php"); ?>
<script>
    $(document).ready(function() {
        $('#datatable-timesheet-saved').DataTable({
            "pageLength": 50,
            "bSort":false,
            language: {
                search:"_INPUT_",
                sSearchPlaceholder: "SEARCH BY FROM DATE, TO DATE"
            }
        });
    });
</script>
