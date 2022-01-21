<?php include 'admin-header.php';
include 'database.php';

?>

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


                        <!-- Technology -->
                        <div class="container-fluid">

                            <!-- Page Heading -->
                            <?php

                            $project_list = "SELECT projects.pr_url,projects.id,projects.projectType,projects.title, projects.roundNumber,SUM(results.marks) marks from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
  INNER JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
  INNER JOIN questions on results.questionId=questions.id 
  where projects.projectType = 'Technology' and
  projects_vs_jedges.roundNumber=1 group by projects_vs_jedges.projectId";
                            $result = $conn->query($project_list);

                            ?>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Technology Round -I Results
                                        <?php if ($result->num_rows > 0) { ?>
                                            <a href="exportRoundTechData.php" class="btn btn-primary float-right"> Export</a>
                                        <?php } ?>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php if ($result->num_rows > 0) {


                                            echo "<table class='table table-bordered' id='dataTable2' width='100%' cellspacing='0'>
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Total Marks</th>
                    <th>J1</th>
                    <th>J2</th>
                    <th>J3</th>
                    <th>J4</th>
                    
                   
                    <th>Promote</th>
                    <th  class='text-center'>Actions</th>                       
                </tr>
            </thead>
            <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Total Marks</th>
                        <th>J1</th>
                        <th>J2</th>
                        <th>J3</th>
                        <th>J4</th>
                       
                   
                    <th>Promote</th>
                        <th  class='text-center'>Actions</th> 
                    </tr>
            </tfoot>
                <tbody>";
                                            // output data of each row
                                            $tectprojectId = "";
                                            while ($row = $result->fetch_assoc()) {
                                                $tectprojectId = $row["id"];
                                                $getthejudgeId = " SELECT jedgeId FROM `projects_vs_jedges` WHERE projectId= $tectprojectId";
                                                $judgeList = $conn->query($getthejudgeId);

                                                $judgemarksIdnumber = "";
                                                $classdisable = "";
                                                if ($row["roundNumber"] !== '1') {
                                                    $classdisable = "disabled";
                                                }

                                                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["title"] . "</td>
                <td>" . $row["marks"] . "</td>";

                                                /*indivitaul Technology Judge total Marakes list*/
                                                if ($judgeList->num_rows > 0) {
                                                    while ($row = $judgeList->fetch_assoc()) {

                                                        $judgemarksIdnumber = $row["jedgeId"];
                                                        //echo  $judgemarksIdnumber."<br/>";
                                                        $judgetotlaMrakesList = "SELECT projects.id,projects.projectType,projects.title, projects_vs_jedges.roundNumber, SUM(results.marks) marks,projects_vs_jedges.jedgeId from projects 
                        LEFT JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
                        LEFT JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
                        LEFT JOIN questions on results.questionId=questions.id where projects.projectType = 'Technology' and projects_vs_jedges.roundNumber=1 and projects_vs_jedges.jedgeId = $judgemarksIdnumber
                        and projects_vs_jedges.projectId  = $tectprojectId
                        group by projects_vs_jedges.projectId;";

                                                        $judgemarkResult = $conn->query($judgetotlaMrakesList);
                                                        $rowcount = mysqli_num_rows($judgemarkResult);

                                                        // $counter = 0;
                                                        while ($row = mysqli_fetch_row($judgemarkResult)) {

                                                            echo "<td>{$row[4]}</td>";
                                                        }
                                                    }
                                                }

                                                echo " <td> <a href='promote.php?id=" . $tectprojectId . "' class=' doPromote-tech btn btn-primary $classdisable' id=" . $tectprojectId . ">Promote</a></td>
                <td class='text-center'> <a href='#' data-toggle='modal' data-target='#roundProjectModel_Technology_" . $tectprojectId . "'>
                <i class='fa fa-eye'></i></a> </td>
             
   
                </tr>";
                                                $questiojns_list = "SELECT questions.question,questions.description,projects.pr_url,projects_vs_jedges.id,projects_vs_jedges.jedgeId,projects.projectType,projects.title,results.marks, results.remarks, results.judgeAssignedId  from projects 
                                                inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
INNER JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
INNER JOIN questions on results.questionId=questions.id 
where 
projects_vs_jedges.roundNumber=1 and 
projects_vs_jedges.projectId=$tectprojectId  
 ORDER BY projects_vs_jedges.modifiedOn DESC";
                                                $questiojns_result = $conn->query($questiojns_list);

                                        ?>


                                            <?php
                                            }
                                            echo "</tbody></table>" ?>


                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">

                            <!-- Page Heading Business -->
                            <?php

                            $project_list = "SELECT projects.pr_url,projects.id,projects.projectType,projects.title, projects.roundNumber,SUM(results.marks) marks from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
  INNER JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
  INNER JOIN questions on results.questionId=questions.id 
  where projects.projectType = 'Business' and
  projects_vs_jedges.roundNumber=1 group by projects_vs_jedges.projectId";
                            $result = $conn->query($project_list);



                            ?>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Business Round -I Results
                                        <?php if ($result->num_rows > 0) { ?>
                                            <a href="exportRoundBusinessData.php" class="btn btn-primary float-right"> Export</a>
                                        <?php } ?>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php if ($result->num_rows > 0) {


                                            echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Total Marks</th>
                    <th>J1</th>
                    <th>J2</th>
                    <th>J3</th>
                    <th>J4</th>
                  
                    
                    <th>Promote</th>
                    <th  class='text-center'>Actions</th>                       
                </tr>
            </thead>
            <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Total Marks</th>
                        <th>J1</th>
                        <th>J2</th>
                        <th>J3</th>
                        <th>J4</th>
                        
                   
                    <th>Promote</th>
                        <th  class='text-center'>Actions</th> 
                    </tr>
            </tfoot>
                <tbody>";
                                            // output data of each row
                                            $projectId = "";
                                            while ($row = $result->fetch_assoc()) {
                                                $projectId = $row["id"];
                                                $getthejudgeId = " SELECT jedgeId FROM `projects_vs_jedges` WHERE projectId= $projectId";
                                                $judgeList = $conn->query($getthejudgeId);
                                                $judgemarksID = "";

                                                $classdisable = "";

                                                if ($row["roundNumber"] !== '1') {
                                                    $classdisable = "disabled";
                                                }

                                                echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["title"] . "</td>
                    <td>" . $row["marks"] . "</td>";
                                                /*indivitaul Business Judge total Marakes list*/
                                                if ($judgeList->num_rows > 0) {
                                                    $judgemarksIdMarkes = "";
                                                    while ($row = $judgeList->fetch_assoc()) {

                                                        $judgemarksIdMarkes = $row["jedgeId"];
                                                        // echo  $judgemarksID;
                                                        $judgetotlaMrakes = "SELECT projects.pr_url,projects.id,projects.projectType,projects.title, projects.roundNumber,SUM(results.marks) marks,projects_vs_jedges.jedgeId from projects 
                            LEFT JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
                            LEFT JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
                            LEFT JOIN questions on results.questionId=questions.id 
                            where projects.projectType = 'Business' and projects_vs_jedges.roundNumber=1 
                            and projects_vs_jedges.jedgeId =$judgemarksIdMarkes and projects_vs_jedges.projectId  = $projectId
                            group by projects_vs_jedges.projectId";
                                                        $result = $conn->query($judgetotlaMrakes);
                                                        while ($row = $result->fetch_assoc()) {
                                                            // print_r($row);
                                                            echo "<td>" . $row["marks"] . "</td>";
                                                        }
                                                    }
                                                }

                                                echo "  <td> <a href='promote.php?id=" . $projectId . "' class='doPromote-business btn btn-primary $classdisable' id=" . $projectId . ">Promote</a></td>
                    <td class='text-center'> <a href='#' data-toggle='modal' data-target='#roundProjectModel_" . $projectId . "'>
                    <i class='fa fa-eye'></i></a> </td>
                
    
                    </tr>";
                                                $questiojns_list = "SELECT questions.question,questions.description,projects.pr_url,projects_vs_jedges.id,projects_vs_jedges.jedgeId,projects.projectType,projects.title,results.marks, results.remarks from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
    INNER JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
    INNER JOIN questions on results.questionId=questions.id 
    where 
    projects_vs_jedges.roundNumber=1 and projects_vs_jedges.projectId=" . $projectId . " ORDER BY projects_vs_jedges.modifiedOn DESC";
                                                $questiojns_result = $conn->query($questiojns_list);
                                        ?>


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
<script type="text/javascript">
    $('.doPromote-business').click(function() {
        var id = $(this).attr('id');
        //alert(id);
        $.ajax({
            url: "promote.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {

                $.get("round1-results.php", function(data) {

                });
            }
        });
    });
    $('.doPromote-tech').click(function() {
        var id = $(this).attr('id');
        // alert(id);
        $.ajax({
            url: "promote.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {

                $.get("round1-results.php", function(data) {

                });
            }
        });
    });
</script>


<?php



$roundMarkesList = "SELECT projects_vs_jedges.projectId,projects_vs_jedges.jedgeId,results.questionId,results.marks,results.remarks FROM `projects_vs_jedges` inner join results on results.judgeAssignedId=projects_vs_jedges.id where projects_vs_jedges.projectId=1";
$result2 = $conn->query($roundMarkesList);
//print_r($roundMarkesList); 
?>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="roundProjectModel_Technology_<?php echo $tectprojectId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Round-I Results </h3>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $jdCnt = 0;
                $cmnt = 0;
                while ($ques = $questiojns_result->fetch_assoc()) {
                    $cmnt = $cmnt+1;

                    $judgeId =  $ques['jedgeId'];
                    $judgenames_list = "SELECT firstName, lastName From login where id = $judgeId";
                    $judge_result = $conn->query($judgenames_list);

                    $judgeName = $judge_result->fetch_assoc();


                ?>
                    <?php if ($jdCnt != $ques['jedgeId']) { $jdCnt = $ques['jedgeId']; ?> <h3> <?php echo $judgeName["firstName"] . $judgeName["lastName"]; ?> : </h3> <?php } ?>
                    <table class="table table-bordered">


                        <tr>
                            <td rowspan="2"><?php echo $ques["description"]; ?></td>
                            <td><?php echo $ques["marks"]; ?></td>
                        </tr>

                    </table>
                    <?php if ($cmnt%5 == 0) {
                         ?>
                        <p> <b>Remarks: </b><?php echo $ques["remarks"]; ?></p>
                <?php
                    }
                } ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="roundProjectModel_<?php echo $projectId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Round-I Results </h3>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php while ($ques = $questiojns_result->fetch_assoc()) {


                    $judgeId =  $ques['jedgeId'];
                    $judgenames_list = "SELECT firstName, lastName From login where id = $judgeId";
                    $judge_result = $conn->query($judgenames_list);

                    $judgeName = $judge_result->fetch_assoc();


                ?>

                    <table class="table table-bordered">


                        <tr>
                            <td rowspan="2"><?php echo $ques["description"]; ?></td>

                            <td><?php echo $judgeName["firstName"] . $judgeName["lastName"]; ?></td>
                            <td><?php echo $ques["marks"]; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo substr($ques["remarks"], 0, 25); ?></td>


                        </tr>
                    </table>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

</html>