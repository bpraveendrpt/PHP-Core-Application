<?php include 'admin-header.php';?>
<?php include 'database.php';
 $loginId = $_SESSION['id'];
$totalPro = "SELECT * from projects ";
    $projectcount="";
    if ($result = mysqli_query($conn, $totalPro)) {
    // Return the number of rows in result set
    $projectcount = mysqli_num_rows($result );
    
}
$totalBusinPro = "SELECT * from projects where projectType= 'Technology'";
$projectBusincount= "";
    if ($result = mysqli_query($conn, $totalBusinPro)) {
        $projectBusincount = mysqli_num_rows($result );
    }
$totalTechPro = "SELECT * from projects where projectType= 'Business'";
    $projectTechcount= "";

    if ($result = mysqli_query($conn, $totalTechPro)) {
        
        $projectTechcount = mysqli_num_rows($result );        
    }
$totalJudges = "SELECT * from login where userType= '1'";
    $judgescount ="";
    if ($result2 = mysqli_query($conn, $totalJudges)) {
        $judgescount = mysqli_num_rows($result2 ); 
    }
    $totalRound1Projects = "SELECT * from projects_vs_jedges where roundNumber= '1'";
  
    if ($result = mysqli_query($conn, $totalRound1Projects)) {
        $Round1Projects = mysqli_num_rows($result ); 
    }
    $totalsemifinalProjects = "SELECT * from projects_vs_jedges where roundNumber= '2'";
  
    if ($result = mysqli_query($conn, $totalsemifinalProjects)) {
        $RoundsemifinalProjects = mysqli_num_rows($result ); 
    }
    $totalfinalProjects = "SELECT * from projects_vs_jedges where roundNumber= '3'";
  
    if ($result = mysqli_query($conn, $totalfinalProjects)) {
        $RoundfinalProjects = mysqli_num_rows($result ); 
    }


?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <div class="side-menu">
                <!-- Sidebar -->
            <?php include 'admin-slide-bar.php';?>
        </div>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        
                    </div>

                    <!-- Content Row -->
                    <!-- Content Row -->
                    <div class="row">
                    <!-- No Of Jadges Card  -->
                    <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                No Of Jadges</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $judgescount?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-gavel fa-2x text-gray-300"></i> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Total Projects  -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Projects</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $projectcount;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
						<!-- Earnings (Monthly) Card Example -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Technical Project
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $projectTechcount?></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Pending Requests Card Example -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Business Projects</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $projectBusincount ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-business-time fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div> 
                    
                                    
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">Projects</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">Round-I <span
                                            class="float-right"><?php echo $Round1Projects; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $Round1Projects; ?>%"
                                            aria-valuenow="<?php echo $Round1Projects;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Semi Final<span
                                            class="float-right"><?php echo $RoundsemifinalProjects; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $RoundsemifinalProjects; ?>%"
                                            aria-valuenow="<?php echo $RoundsemifinalProjects;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Final <span
                                            class="float-right"><?php echo $RoundfinalProjects;?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $RoundfinalProjects;?>%"
                                            aria-valuenow="<?php echo $RoundfinalProjects;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>                         

                        </div>

                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-white">About Us</h6>
                                </div>
                                <div class="card-body">
                                   
                                    <p>Welcome to Fleming School of business and technology. Fleming College known for its excellence in Business, Environmental and Science Studies <a
                                            target="_blank" rel="nofollow" href="https://flemingcollege.ca/">Fleming School</a>, a
                                        constantly updated collection of beautiful svg images that you can use
                                        completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="https://flemingcollege.ca/">Browse Fleming School on
                                        About &rarr;</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<?php include 'admin-footer.php';?>

</body>

</html>