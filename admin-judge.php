<?php include 'admin-header.php'; ?>
<?php include 'database.php';

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



                    <?php
                    if (!empty($_POST["save"])) {

                        $fname = $_POST["judgefirstName"];
                        $lname = $_POST["judgelastName"];

                        function RandomStringMethod($length = 3)
                        {
                            // $randomCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ=-$&@';
                            $randomCharacters = '0123456789';

                            $stringLength = strlen($randomCharacters);
                            $randomString = '';

                            for ($i = 0; $i < $length; $i++) {
                                $randomString .= $randomCharacters[rand(0, $stringLength - 1)];
                            }

                            return $randomString;
                        }


                        $password = RandomStringMethod(3);

                        $lnLetter = substr($lname, 0, 1);
                        $passSave = $fname . '_' . $lnLetter . $password;

                        // Store contactor data in database
                        $sql = $conn->query("INSERT INTO login(firstName, lastName, loginId, pswd, save_pwd)
		VALUES ('{$fname}', '{$lname}', '$fname$lname', '" . md5($passSave) . "', '{$passSave}')");

                        if (!$sql) {
                            die("MySQL query failed.");
                        } else {
                            $response = array(
                                "status" => "alert-success",
                                "message" => "New Judge Added succesfully ."
                            );
                        }
                    }


                    if (!empty($response)) { ?>
                        <div id="alert" class="alert text-center <?php echo $response['status']; ?>" role="alert">
                            <?php echo $response['message']; ?>
                        </div>
                    <?php } ?>
                    <div class="row">

                        <div class="col-lg-12 mb-6">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Add Judge</h6>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">

                                        <form name="judges_form" id="judges_form" class="user" enctype="multipart/form-data" method="post">
                                            <div class="form-group">
                                                First Name
                                                <input type="text" class="form-control" name="judgefirstName" id="judgefirstName" placeholder="Enter First Name">
                                            </div>
                                            <div class="form-group">
                                                Last Name
                                                <input type="text" class="form-control" name="judgelastName" id="lastName" placeholder="Enter Last Name">
                                            </div>
                                            <input class="btn btn-primary" type="submit" name="save" value="Add">

                                        </form>

                                    </div>
                                    
                                </div>
                                <div class="col-lg-6 mb-6">
                                    <div class="p-5">
                                    <h5>Upload Judges</h5>
                                    <form method="POST" action="read-excel.php" enctype="multipart/form-data">
                                        <div class="form-group">
                                            
                                            <input type="file" name="uploadFile" class="form-control" required />
                                            <label> <a href="./judges.csv">Download Sample File</a></label>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                                
                            </div>


                        </div>

                    </div>
                    <?php $judge_list = "SELECT * FROM login where userType='1' ORDER BY modifiedOn DESC ";
                    $judgeresult = $conn->query($judge_list);
                    ?>
                    <div class="row">
                        <div class="col-lg-12 mb-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Judges</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php if ($judgeresult->num_rows > 0) {

                                            echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>

<thead>
    <tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
                          
    </tr>
</thead>
<tfoot>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        
    </tr>
</tfoot>
    <tbody>";
                                            // output data of each row
                                            while ($row = $judgeresult->fetch_assoc()) {
                                                echo "<tr>
    <td>" . $row["id"] . "</td>
    <td>" . $row["firstName"] . "</td>
    <td>" . $row["lastName"] . "</td>
    
    </tr>"; ?>



                                            <?php }
                                            echo "</tbody></table>"; ?>


                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- Content Column -->
                        <div class="container-fluid">

                        
                            <?php

                            $judge_list = "SELECT * FROM login where userType='1' ORDER BY modifiedOn DESC ";
                            $result = $conn->query($judge_list);
                            ?>


                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Judges Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php if ($result->num_rows > 0) {

                                            echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
            
            <thead>
                <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Login Id</th>
                <th>Password</th>
                <th>Status</th>
                <th>Actions</th>                       
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Login Id</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
                <tbody>";
                                            // output data of each row
                                            //  <td>".$row["firstName"]."_".$row["lastName"]."</td>
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["firstName"] . "</td>
                <td>" . $row["lastName"] . "</td>
                <td>" . $row["loginId"] . "</td>
                <td>" . $row["save_pwd"] . "</td>
                <td>" . $row["status"] . "</td>
                <td> <a href='#' data-toggle='modal' data-target='#viewjudgeModel_" . $row["id"] . "'>
                <i class='fas fa-eye'></i></a> </td>

   
                </tr>"; ?>
                                                <div class="modal fade" id="viewjudgeModel_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header modal-form-header">
                                                                <h5 class="modal-title text-white" id="exampleModalLabel">
                                                                    Judge Details</h5>
                                                                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>

                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <strong>First Name</strong>
                                                                        <p><?php echo $row["firstName"]; ?></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <strong>Last Name</strong>
                                                                        <p><?php echo $row["lastName"]; ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <strong>User ID</strong>
                                                                        <p><?php echo $row["loginId"]; ?></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <strong>Password</strong>
                                                                        <p><?php echo $row["save_pwd"]; ?></p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php }
                                            echo "</tbody></table>"; ?>


                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->




            <?php include 'admin-footer.php'; ?>
            <script>
                setTimeout(function() {
                    // Closing the alert
                    $('#alert').alert('close');
                }, 5000);




                $(function() {


                    $("form[name='judges_form']").validate({

                        rules: {
                            judgefirstName: "required",
                            judgelastName: "required",

                            judgefirstName: {
                                required: true
                            },
                            judgelastName: {
                                required: true
                            }
                        },

                        messages: {
                            judgefirstName: "Please provide a valid name.",
                            judgelastName: "Please provide a valid name."
                        },
                        submitHandler: function(form) {
                            form.submit();

                        }

                    });
                });
            </script>