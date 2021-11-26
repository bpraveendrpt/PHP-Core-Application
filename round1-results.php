<?php include 'admin-header.php';
include 'database.php'; ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'admin-slide-bar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <?php include 'admin-nav-toolbar.php'; ?>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!--  <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Projects</h1>

                    </div> -->

                    <!-- Content Row -->
                    <div class="row">
                        <?php

                        $totalPro = "SELECT * from projects ORDER BY modifiedOn DESC";

                        if ($result = mysqli_query($conn, $totalPro)) {
                            // Return the number of rows in result set
                            $projectcount = mysqli_num_rows($result);
                        }
                        ?>




                        <div class="container-fluid">

                            <!-- Page Heading -->
                            <?php

                            $project_list = "SELECT projects.pr_url,projects.id,projects.projectType,projects.title,SUM(results.marks) marks, results.remarks from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
  INNER JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
  INNER JOIN questions on results.questionId=questions.id 
  where 
  projects_vs_jedges.roundNumber=1 group by  projects_vs_jedges.projectId ORDER BY projects_vs_jedges.modifiedOn DESC";
                            $result = $conn->query($project_list);

                            ?>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Round -I Results </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php if ($result->num_rows > 0) {

                                            echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Total Marks</th>
                    <th>Remarks</th>
                    <th>Promote</th>
                    <th  class='text-center'>Actions</th>                       
                </tr>
            </thead>
            <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Total Marks</th>
                    <th>Remarks</th>
                    <th>Promote</th>
                        <th  class='text-center'>Actions</th> 
                    </tr>
            </tfoot>
                <tbody>";
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["title"] . "</td>
                <td><a href='" . $row["pr_url"] . "'target='_blank''>" . $row["pr_url"] . "</a></td>
                <td>" . $row["marks"] . "</td>
                <td>" . $row["remarks"] . "</td>
                <td > <a href='#' >Promote</a> </td>
                <td class='text-center'> <a href='#' data-toggle='modal' data-target='#roundProjectModel_" . $row["id"] . "'>
                <i class='fa fa-eye'></i></a> </td>
             
   
                </tr>";

                                                $questiojns_list = "SELECT questions.question,questions.description,projects.pr_url,projects_vs_jedges.id,projects.projectType,projects.title,results.marks, results.remarks from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
INNER JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
INNER JOIN questions on results.questionId=questions.id 
where 
projects_vs_jedges.roundNumber=1 and projects_vs_jedges.projectId=" . $row['id'] . " ORDER BY projects_vs_jedges.modifiedOn DESC";
                                                $questiojns_result = $conn->query($questiojns_list);
                                        ?>

                                                <div class="modal fade" id="roundProjectModel_<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3>Round-I Results</h3>

                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                // output data of each row
                                                                while ($ques = $questiojns_result->fetch_assoc()) {
                                                                ?>
                                                                    <h5 class="modal-title" id="assignModalLabel">
                                                                        <?php echo $ques["question"]; ?></h5>
                                                                    <div class="form-group">
                                                                        <label for="exampleFormControlInput1"><?php echo $ques["description"]; ?></label>
                                                                        <label for="exampleFormControlInput1"><?php echo $ques["marks"]; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            echo "</tbody></table>" ?>


                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- End of Main Content -->
                    <!-- Logout Modal-->

                    <?php include 'admin-footer.php'; ?>

</body>

</html>