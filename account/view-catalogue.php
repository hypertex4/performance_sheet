<?php include_once("inc/header.acc.php"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard | Project Name/Code</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Project Name</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Project Catalogue</h2>
        </header>
        <div class="card-body">
            <table class="table table-bordered table-striped mb-0" id="datatable-catalogue" style="font-size: 12px">
                <thead class="bg-dark text-white">
                <tr>
                    <th scope="col" class="">PROGRAM NAME</th>
                    <th scope="col" class="">PROGRAM CODE</th>
                </tr>
                </thead>
                <tbody>
                <?php $proj=$user->list_all_projects();
                if ($proj->num_rows > 0) {
                    while ($project = $proj->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?=$project['project_name'];?></th>
                            <td><?=$project['project_code'];?></td>
                        </tr>
                    <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Project Catalogue found</td></tr>";} ?>
                </tbody>
            </table>
        </div>
    </section>
</section>
<?php include_once("inc/footer.acc.php"); ?>
<script>
    $(document).ready(function() {
        $('#datatable-catalogue').DataTable({
            "pageLength": 25,
            "bSort":false,
            language: {
                search:"_INPUT_",
                sSearchPlaceholder: "SEARCH BY FROM DATE, TO DATE"
            }
        });
    });
</script>