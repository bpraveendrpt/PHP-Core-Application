<?php include 'admin-header.php';
include 'database.php'; 
if (isset($_SESSION['id'])) {
    $judgeId = $_SESSION['id'];
}
if (isset($_POST["judgeAssignedId"])) {
?>
    <!-- <pre><?php
                // print_r($_POST);
                // exit;
                ?> </pre>  -->
<?php

    for ($x = 0; $x < count($_POST["judgeAssignedId"]); $x++) {
        $str[] = "({$_POST["judgeAssignedId"][$x]},{$_POST["questionId"][$x]},{$_POST["marks"][$x]},'{$_POST["remarks"]}')";
    }
    $s = implode(',', $str);
    $sql = $conn->query("INSERT INTO results (judgeAssignedId,questionId, marks,remarks) VALUES $s");
    $sql2 = $conn->query("INSERT INTO round_one_results (project_id,judge_id,questionId, roundNumber,marks,remarks) VALUES $s");
    $conn->query("UPDATE projects_vs_jedges SET status = '0' WHERE id = " . $_POST['judgeAssignedId'][0] . "");

    if (!$sql) {
        die("MySQL query failed.");
    } else {
        $response = array(
            "status" => "alert-success",
            "message" => "New Judge Added succesfully ."
        );
    }
}  ?>

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
                            $project_list = "SELECT *,projects.id as id, projects.projectType as projectType, projects_vs_jedges.id as pjid from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId where projects_vs_jedges.jedgeId= $judgeId and projects_vs_jedges.roundNumber=1 and projects_vs_jedges.status='1' and projectType='Business' ORDER BY modifiedOn DESC";
                            $result = $conn->query($project_list);

                            ?>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Business Projects </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php if ($result->num_rows > 0) {

                                            echo "<table class='table table-bordered' width='100%' cellspacing='0'>
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Program</th>
                    <th>Sponsor</th>
                    <th>Link</th>
                   
                    <th  class='text-center'>Actions</th>                       
                </tr>
            </thead>
           
                <tbody>";
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                $questiojns_list = "SELECT * FROM questions where status='1'";
                                                $questiojns_result = $conn->query($questiojns_list);
                                                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["title"] . "</td>
                <td>".$row["program"]."</td>
                <td>".$row["sponsor"]."</td>
                
                <td><a href='".$row["pr_url"]."'  target='_blank'>
                ".$row["pr_url"]."</a></td>
              

                <td class='text-center'> <a href='#' data-toggle='modal' data-target='#viewProjectjedge_round_Business_".$row["id"]."'>
                <i class='fas fa-eye'></i></a> |  <a href='#' data-toggle='modal' data-target='#roundProjectModel_" . $row["id"] . "'>
                <i class='fa fa-external-link-alt'></i></a> </td>
             
   
                </tr>" ?>
                <div class="modal fade" id="viewProjectjedge_round_Business_<?php echo $row['id'] ?>"
                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-form-header">
                                <h5 class="modal-title text-white" id="exampleModalLabel">
                                Project Details</h5>
                                <button class="close text-white" type="button" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                
                            </div>
                            
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Title</strong>
                                                <label> <?php echo $row["title"]; ?></label>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Program</strong>
                                            <p><?php echo $row["program"]; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Names</strong>
                                            <p><?php echo $row["names"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Sponsor</strong>
                                            <p><?php echo $row["sponsor"]; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>URL</strong>
                                            <p><?php echo $row["pr_url"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Project Type</strong>
                                            <p> <span class="badge badge-info"><?php echo $row["projectType"]; ?></span></p>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Mentor</strong>
                                            <p><?php echo $row["mentor"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <strong>Description</strong>
                                        <p><?php echo $row["pr_description"]; ?></p>
                                        
                                    </div>
                                </div>
                                    
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="button"
                                        data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                                <div class="modal fade" data-backdrop="static" data-keyboard="false" id="roundProjectModel_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header modal-form-header">
                                                                <h5 class="modal-title text-white" id="exampleModalLabel">
                                                               Round 1</h5>
                                                                <button class="close text-white" type="button" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            
                                                            
                                                                
                                                                
                                                                 
                                                               
                                                            <div class="modal-body">
                                                            <div class="header my-0">
                                                                    <h5>Project Title: <?php echo $row["title"]; ?></h5>
                                                                </div> 
                                                                <form name="judges_round1_form" id="judges_round1_form" class="user" enctype="multipart/form-data" method="post" onsubmit="validateSaveData();">
                                                                    <?php
                                                                    // output data of each row
                                                                    while ($ques = $questiojns_result->fetch_assoc()) {


                                                                    ?>
                                                                        <?php // print_r($ques); 
                                                                        ?>
                                                                        <div class="form-group row">
                                                                            <input type="hidden" name="judgeAssignedId[]" value="<?php echo $row["pjid"]; ?>">
                                                                            <div class="col-sm-9 add-item">
                                                                                <h6 class="modal-title">
                                                                                    <?php echo $ques["question"]; ?></h6>
                                                                                <input type="hidden" name="questionId[]" value="<?php echo $ques["id"]; ?>"> 

                                                                                <p> <?php echo $ques["description"]; ?></p>
                                                                            </div>
                                                                            <div class="col-sm-3 add-item">
                                                                                <div class="form-group">
                                                                                    <label for="exampleFormControlSelect1">Add Markes</label>
                                                                                    <select class="form-control" name="marks[]" id="exampleFormControlSelect1">
                                                                                        <option value="0">0</option>
                                                                                        <option value="1">1</option>
                                                                                        <option value="2">2</option>
                                                                                        <option value="3">3</option>
                                                                                        <option value="4">4</option>
                                                                                        <option value="5">5</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>


                                                                    <?php } ?>

                                                                    <div class="form-group">
                                                                        <label for="exampleFormControlTextarea1">Remarks</label>
                                                                        <textarea name="remarks" class="form-control" id="remarksTextarea1" rows="3"></textarea>
                                                                    </div>
                                                                    <input class="btn btn-primary" type="submit" value="Submit">
                                                                    <button class="btn btn-primary float-right" type="button" data-dismiss="modal">Cancel</button>

                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php }
                                            echo "</tbody></table>" ?>


                            <?php }else{echo "No Records Found"; } ?>

                                    </div>
                                </div>
                            
                            </div>

                        </div>
                        <div class="container-fluid">
                            <!-- Page Heading -->
                            <?php
                            $project_list = "SELECT *,projects.id as id, projects.projectType as projectType, projects_vs_jedges.id as pjid from projects inner JOIN projects_vs_jedges on projects.id=projects_vs_jedges.projectId where projects_vs_jedges.jedgeId= $judgeId and projects_vs_jedges.roundNumber=1 and projects_vs_jedges.status='1' and projectType='Technology' ORDER BY modifiedOn DESC";
                            $result = $conn->query($project_list);

                            ?>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Technology Projects </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php if ($result->num_rows > 0) {

                                            echo "<table class='table table-bordered'  width='100%' cellspacing='0'>
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Program</th>
                    <th>Sponsor</th>
                    <th>Link</th>
                    
                    <th  class='text-center'>Actions</th>                       
                </tr>
            </thead>
            
                <tbody>";
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                $questiojns_list = "SELECT * FROM questions where status='1'";
                                                $questiojns_result = $conn->query($questiojns_list);
                                                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["title"] . "</td>
                <td>".$row["program"]."</td>
                <td>".$row["sponsor"]."</td>
                
                <td><a href='".$row["pr_url"]."' target='_blank'>
                ".$row["pr_url"]."</a></td>
                
                <td class='text-center'><a href='#' data-toggle='modal' data-target='#viewProjectModel_Technology_".$row["id"]."'>
                <i class='fas fa-eye'></i></a> |  <a href='#' data-toggle='modal' data-target='#roundProjectModel_" . $row["id"] . "'>
                <i class='fa fa-external-link-alt'></i></a> </td>
             
   
                </tr>" ?>
                <div class="modal fade" id="viewProjectModel_Technology_<?php echo $row['id'] ?>"
                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-form-header">
                                <h5 class="modal-title text-white" id="exampleModalLabel">
                                Project Details</h5>
                                <button class="close text-white" type="button" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                
                            </div>
                            
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Title</strong>
                                                <label> <?php echo $row["title"]; ?></label>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Program</strong>
                                            <p><?php echo $row["program"]; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Names</strong>
                                            <p><?php echo $row["names"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Sponsor</strong>
                                            <p><?php echo $row["sponsor"]; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>URL</strong>
                                            <p><?php echo $row["pr_url"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Project Type</strong>
                                            <p> <span class="badge badge-info"><?php echo $row["projectType"]; ?></span></p>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Mentor</strong>
                                            <p><?php echo $row["mentor"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <strong>Description</strong>
                                        <p><?php echo $row["pr_description"]; ?></p>
                                        
                                    </div>
                                </div>
                                    
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="button"
                                        data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                                <div class="modal fade" data-backdrop="static" data-keyboard="false" id="roundProjectModel_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header modal-form-header">
                                                                <h5 class="modal-title text-white" id="exampleModalLabel">
                                                                Round 1</h5>
                                                                <button class="close text-white" type="button" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            
                                                            
                                                                
                                                                
                                                                 
                                                               
                                                            <div class="modal-body">
                                                            <div class="header my-0">
                                                                    <h5>Project Title: <?php echo $row["title"]; ?></h5>
                                                                </div> 
                                                                <form name="judges_round1_form" id="judges_round1_form" class="user" enctype="multipart/form-data" method="post" onsubmit="validateSaveData();" >
                                                                    <?php
                                                                    // output data of each row
                                                                    while ($ques = $questiojns_result->fetch_assoc()) {


                                                                    ?>
                                                                        <?php // print_r($ques); 
                                                                        ?>
                                                                        <div class="form-group row">
                                                                            <input type="hidden" name="judgeAssignedId[]" value="<?php echo $row["pjid"]; ?>">
                                                                            <input type="hidden" name="roundNumber[]" value="1">
                                                                            <div class="col-sm-9 add-item">
                                                                                <h6 class="modal-title">
                                                                                    <?php echo $ques["question"]; ?></h6>
                                                                                <input type="hidden" name="questionId[]" value="<?php echo $ques["id"]; ?>"> 

                                                                                <p> <?php echo $ques["description"]; ?></p>
                                                                            </div>
                                                                            <div class="col-sm-3 add-item">
                                                                                <div class="form-group">
                                                                                    <label for="exampleFormControlSelect1">Add Markes</label>
                                                                                    <select class="form-control" name="marks[]" id="exampleFormControlSelect1">
                                                                                        <option value="0">0</option>
                                                                                        <option value="1">1</option>
                                                                                        <option value="2">2</option>
                                                                                        <option value="3">3</option>
                                                                                        <option value="4">4</option>
                                                                                        <option value="5">5</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>


                                                                    <?php } ?>

                                                                    <div class="form-group">
                                                                        <label for="exampleFormControlTextarea1">Remarks</label>
                                                                        <textarea name="remarks" class="form-control" id="remarksTextarea1" rows="3"></textarea>
                                                                    </div>

                                                                    <input class="btn btn-primary" type="submit" value="Submit">
                                                                    <button class="btn btn-primary float-right" type="button" data-dismiss="modal">Cancel</button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php }
                                            echo "</tbody></table>" ?>


<?php }else{echo "No Records Found"; } ?>

                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- End of Main Content -->
                    <!-- Logout Modal-->

                    <?php include 'admin-footer.php'; ?>


<script>
   
    function validateSaveData() {
        
        confirm("Sure are you want Submit");

    }
    //return true;
    
</script>
</body>


</html>