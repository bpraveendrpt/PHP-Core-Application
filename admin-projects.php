<?php include 'admin-header.php';
 include 'database.php';?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    
                <!-- Sidebar -->
            <?php include 'admin-slide-bar.php';?>
     

        <!-- Content Wrapper -->
        <div id="content-wrapper main-content" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <?php include 'admin-nav-toolbar.php';?>

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
    $projectcount = mysqli_num_rows( $result );
    
}

if(!empty($_POST["save"])) {

$title = $_POST['title'];
$program = $_POST['program'];
$names = $_POST['names'];
$sponsor = $_POST['sponsor'];
$description = $_POST['pr_description'];
$pr_url = $_POST['pr_url'];
$projectType = $_POST['projectType'];
$mentor = $_POST['mentor'];
        
    // Store contactor data in database
    
    $sql = $conn->query("INSERT INTO projects(title, program, names, sponsor, pr_description, pr_url, projectType, mentor)
    VALUES ('{$title}', '{$program}', '$names', '$sponsor', '$description', '$pr_url', '$projectType', '$mentor')");

    if(!$sql) {
      die("MySQL query failed.");
    } else {
      $response2 = array(
        "status" => "alert-success",
        "message" => "New Project Added succesfully ."
      );     
               
    }

}  
?>
                      

                            <div class="col-lg-12 ba">
                           <?php if(!empty($response2)) {?>
                            <div id="add_project_alert" class="alert text-center <?php echo $response2['status']; ?>" role="alert">
                                <?php echo $response2['message']; ?>
                            </div>
                            <?php }?>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Add project</h6>
                                </div>
                                <div class="p-5">
                                    
                                    <form class="add_project" Name="add_project" id ="add_project" action=""  enctype="multipart/form-data" method="post">
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="text">Title</label>
                                                <input type="text" class="form-control form-control-add" id="pr_title"
                                                    name="title">
                                            </div>
                                            <div class="col-sm-6 add-item">
                                                <label for="text">Program</label>
                                                <input type="text" class="form-control form-control-add" id="pr_program"
                                                    name="program">
                                            </div>


                                        </div>
                                        <div class="form-group row">

                                            <div class="col-sm-6 add-item">
                                                <label for="text">Names</label>
                                                <input type="text" class="form-control form-control-add" name="names"
                                                    id="pr_names">
                                            </div>
                                            <div class="col-sm-6 add-item">
                                                <label for="text">Sponsor</label>
                                                <input type="text" class="form-control form-control-add" id="pr_sponsor"
                                                    name="sponsor">
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="text">URL</label>
                                                <input type="text" class="form-control form-control-add" id="pr_url" name="pr_url">
                                            </div>
                                            <div class="col-sm-6 add-item">
                                                <label for="text">Project Type</label>
                                                <br> 
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="projectType" id="inlineRadio1" checked value="Technology">
                                                    <label class="form-check-label" for="inlineRadio1">Technology</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="projectType" id="inlineRadio2" value="Business">
                                                    <label class="form-check-label" for="inlineRadio2">Business</label>
                                                </div>
                                                    
                                               
                                           </div>



                                        </div>
                                        <div class="form-group row">

                                            <div class="col-sm-6 add-item">
                                                <label for="text">Mentor</label>
                                                <input type="text" class="form-control form-control-add" name="mentor"
                                                    id="pr_mentor">
                                            </div>


                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Description</label>
                                            <textarea class="form-control form-control-add" name="pr_description"
                                                id="pr_description" rows="3"></textarea>
                                        </div>
                                        <input class="btn btn-primary" type="submit" name="save" value="Add">
                                        <!-- <a href="insert_projects.php" class="btn btn-primary btn-add">
                                            Add
                                        </a> -->
                                        <hr>


                                    </form>


                           </div>
                           <div class="col-lg-6 mb-6">
                                    <div class="p-5">
                                    <h5>Upload Projects</h5>
                                    <form method="POST" action="import-projects.php" enctype="multipart/form-data">
                                        <div class="form-group">
                                            
                                            <input type="file" name="uploadFile" class="form-control" required />
                                            <label> <a href="./projects.xlsx">Download Sample Projects File</a></label>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                      

                        <div class="container ">
                        
                        <!-- Page Heading -->
                        <?php

                        $project_list= "SELECT * FROM projects where projectType= 'Technology'";
                        $result = $conn->query($project_list);

                        ?>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-white">Technology Projects </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <?php  if ($result->num_rows > 0) {

        echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
        
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Program</th>
                <th>Sponsor</th>
                              
                <th>Actions</th>                       
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Program</th>
                <th>Sponsor</th>
              
               
                <th>Actions</th>
            </tr>
        </tfoot>
            <tbody>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>".$row["id"]."</td>
            <td>".$row["title"]."</td>
            <td>".$row["program"]."</td>
            <td>".$row["sponsor"]."</td>
          
            
            <td> <a href='#' data-toggle='modal' data-target='#viewProjectModel_".$row["id"]."'>
            <i class='fas fa-eye'></i></a> </td>


            </tr>"?>
                                    <div class="modal fade" id="viewProjectModel_<?php echo $row['id'] ?>"
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

                                    <?php }
        echo "</tbody></table>"?>


                                    <?php } ?>

                                </div>
                            </div>
            </div>
            </div>
<!-- projects -->
<div class="container-fluid">
                        
                        <!-- Page Heading -->
                        <?php

                        $project_list= "SELECT * FROM projects where projectType= 'Business'";
                        $result = $conn->query($project_list);

                        ?>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-white">Business Projects </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <?php  if ($result->num_rows > 0) {

        echo "<table class='table table-bordered' id='dataTable2' width='100%' cellspacing='0'>
        
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Program</th>
                <th>Sponsor</th>
              
               
                <th>Actions</th>                       
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Program</th>
                <th>Sponsor</th>
               
              
                <th>Actions</th>
            </tr>
        </tfoot>
            <tbody>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>".$row["id"]."</td>
            <td>".$row["title"]."</td>
            <td>".$row["program"]."</td>
            <td>".$row["sponsor"]."</td>
           
           
            <td> <a href='#' data-toggle='modal' data-target='#viewProjectModel_".$row["id"]."'>
            <i class='fas fa-eye'></i></a> </td>


            </tr>"?>
                                    <div class="modal fade" id="viewProjectModel_<?php echo $row['id'] ?>"
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

                                    <?php }
        echo "</tbody></table>"?>


                                    <?php } ?>

                                </div>
                            </div>
                        </div>







                      
                        

                        
                    </div>







                    
                    <!-- End of Main Content -->
                    <!-- Logout Modal-->

                    <?php include 'admin-footer.php';?>

</body>

<script>
   setTimeout(function() {
        // Closing the alert
        $('#add_project_alert').alert('close');
    }, 5000);

    $(function() {
        $("form[name='add_project']").validate({

            rules: {
                title: "required",
                program: "required",
                names: "required",
                sponsor: "required",
                pr_url: "required",
                pr_description: "required",

                title: {
                    required: true
                },
                program: {
                    required: true
                },
                names:{
                    required: true
                },
            
                sponsor:{
                    required: true
                },
                mentor:{
                    required: true
                },
                pr_url:{
                    required: true
                },
                pr_description:{
                    required: true,
                    minlength: 5,
                   /* maxlength: 100,*/
                    lettersonly: true
                }
            },

            messages: {
                title: "Please Enter Title.",
                program: "Enter Program Name.",
                names: "Enter Names",
                sponsor: "Enter Sponsor",
                mentor: "Enter Mentor",
                pr_url: "Enter URL",
                pr_description: "Please Enter Description"
                
            },
            submitHandler: function(form) {
                form.submit();

            }

        });
    });
    </script>
</html>