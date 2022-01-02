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
                                    <h6 class="m-0 font-weight-bold text-white">Technology Round -I Results </h6>
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
                   
                    <th>Promote</th>
                    <th  class='text-center'>Actions</th>                       
                </tr>
            </thead>
            <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        
                        <th>Total Marks</th>
                   
                    <th>Promote</th>
                        <th  class='text-center'>Actions</th> 
                    </tr>
            </tfoot>
                <tbody>";
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                               
                                                if( $row["roundNumber"] !== '1' ){
                                                        $class = "disabled";
                                                }
                                               
                                                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["title"] . "</td>
                 <td>" . $row["marks"] . "</td>
                
                            
                <td> <a href='promote.php?id=" . $row["id"] . "' class=' doPromote btn btn-primary'>Promote</a></td>
                <td class='text-center'> <a href='#' data-toggle='modal' data-target='#roundProjectModel_" . $row["id"] . "'>
                <i class='fa fa-eye'></i></a> </td>
             
   
                </tr>";
 $questiojns_list = "SELECT questions.question,questions.description,projects.pr_url,projects_vs_jedges.id,projects_vs_jedges.jedgeId,projects.projectType,projects.title,results.marks, results.remarks, results.judgeAssignedId  from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
INNER JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
INNER JOIN questions on results.questionId=questions.id 
where 
projects_vs_jedges.roundNumber=1 and projects_vs_jedges.projectId=" . $row['id'] . "   ORDER BY projects_vs_jedges.modifiedOn DESC";
                                                $questiojns_result = $conn->query($questiojns_list);
                                               // print_r($questiojns_result);
                                               // $ques = $questiojns_result->fetch_assoc();
                                              //  print_r($ques);
                                        ?>

                                                <div class="modal fade" data-backdrop="static" data-keyboard="false" id="roundProjectModel_<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                               // $ques = $questiojns_result->fetch_assoc();
                                                               // print_r($ques);
                                                                // output data of each row
                                                                while ($ques = $questiojns_result->fetch_assoc()) {
                                                                    $judgeId=  $ques['jedgeId'];
                                                                    $judgenames_list = "SELECT firstName, lastName From login where id = $judgeId"; 
                                                                    $judge_result = $conn->query($judgenames_list);
                                                                    
                                                                    $judgeName= $judge_result->fetch_assoc();
                                                                    

                                                                
                                                                ?>

<div class=" row">
                                                                
</div>

                                                                    <div class="form-group row">
                                                                        
                                                                        <div class="col-sm-4 add-item">
                                                                            <h6 class="modal-title" id="assignModalLabel">
                                                                            <?php echo $ques["question"]; ?></h6>
                                                                            <p for="exampleFormControlInput1"><?php echo $ques["description"]; ?></p>
                                                                            
                                                                    
                                                                        </div>
                                                                        <div class="col-sm-4 add-item">
                                                                         <input class="form-control" type="text" value="<?php  echo $judgeName["firstName"].$judgeName["lastName"]; ?>"  readonly>
                                                                        
                                                                        </div>
                                                                        <div class="col-sm-4 add-item">
                                                                         <input class="form-control" type="text" value="<?php echo $ques["marks"]; ?>"  readonly>
                                                                        
                                                                        </div>
                                                                        <div class="col-sm-4 add-item">
                                                                         <input class="form-control" type="text" value="<?php echo $ques["remarks"]; ?>"  readonly>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">                                                                   </div>
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


                                        <?php } else{echo "NO Records Found"; } ?>

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
                                    <h6 class="m-0 font-weight-bold text-white">Business Round -I Results </h6>
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
                    
                    <th>Promote</th>
                    <th  class='text-center'>Actions</th>                       
                </tr>
            </thead>
            <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        
                        <th>Total Marks</th>
                   
                    <th>Promote</th>
                        <th  class='text-center'>Actions</th> 
                    </tr>
            </tfoot>
                <tbody>";
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                               
                                                if( $row["roundNumber"] !== '1' ){
                                                        $class = "disabled";
                                                }
                                               
                                                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["title"] . "</td>
                 <td>" . $row["marks"] . "</td>
               
                            
                <td> <a href='promote.php?id=" . $row["id"] . "' class=' doPromote btn btn-primary'>Promote</a></td>
                <td class='text-center'> <a href='#' data-toggle='modal' data-target='#roundProjectModel_" . $row["id"] . "'>
                <i class='fa fa-eye'></i></a> </td>
             
   
                </tr>";
 $questiojns_list = "SELECT questions.question,questions.description,projects.pr_url,projects_vs_jedges.id,projects_vs_jedges.jedgeId,projects.projectType,projects.title,results.marks, results.remarks from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId 
INNER JOIN results on projects_vs_jedges.id=results.judgeAssignedId 
INNER JOIN questions on results.questionId=questions.id 
where 
projects_vs_jedges.roundNumber=1 and projects_vs_jedges.projectId=" . $row['id'] . " ORDER BY projects_vs_jedges.modifiedOn DESC";
                                                $questiojns_result = $conn->query($questiojns_list);
                                               
                                        ?>

                                                <div class="modal fade" data-backdrop="static" data-keyboard="false" id="roundProjectModel_<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3>Round-I Results33</h3>

                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                 $ques = $questiojns_result->fetch_assoc();
                                                                 print_r($ques);
                                                                // output data of each row
                                                                while ($ques = $questiojns_result->fetch_assoc()) {
                                                                ?>
                                                               
                                                                   
                                                                    <div class="form-group row">
                                                                        
                                                                        <div class="col-sm-4 add-item">
                                                                            <h6 class="modal-title" id="assignModalLabel">
                                                                            <?php echo $ques["question"]; ?></h6>
                                                                            <p for="exampleFormControlInput1"><?php echo $ques["description"]; ?></p>
                                                                            
                                                                    
                                                                        </div>
                                                                        <div class="col-sm-4 add-item">
                                                                         <input class="form-control" type="text" value="<?php echo $ques["jedgeId"]; ?>"  readonly>
                                                                        
                                                                        </div>
                                                                        <div class="col-sm-2 add-item">
                                                                         <input class="form-control" type="text" value="<?php echo $ques["marks"]; ?>"  readonly>
                                                                        
                                                                        </div>
                                                                        <div class="col-sm-2 add-item">
                                                                         <input class="form-control" type="text" value="<?php echo $ques["remarks"]; ?>"  readonly>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">                                                                   </div>
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


                                        <?php }else{echo "No Records Found"; } ?>

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
 
$('.doPromote1').click(function() {
    var id = $(this).attr('id');
   alert(id);
    $.ajax({
      url : "promote.php",
      type: "POST",
      data : {
        id: id }
      ,
      success: function(data)
      {
       
        $.get("round1-results.php", function(data)
              {
          
        });
      }
    });
  });

</script>
<?php

//print_r($_POST); ?>
</html>