
<?php
if (isset($_SESSION['errors']))
{
    session_destroy();
}else{
	session_start();
	
	if (isset($_SESSION['login_user']) && isset($_SESSION['role'])) {
        // echo  $_SESSION['role'];exit;
		//echo $_SESSION['login_user'];exit;
	header("Location: admin.php");
	}
}
?>
<?php
	
	include("config.php");
   
  // $error = '';
   if (isset($_POST['username']) && isset($_POST['password'])) {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT * FROM login WHERE loginId = '$myusername' and pswd = '".md5($mypassword)."' ";
      $result = mysqli_query($db,$sql);
     // $row = mysqli_fetch_assoc($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
        
         while ($rows = $result->fetch_assoc()) {
            $_SESSION['role'] = $rows['userType'];
            $_SESSION['id'] = $rows['id'];
           
            
        }
       // echo  $_SESSION['role'];exit;
        
         /* Redirect browser */
		header("Location: admin.php"); 
      }else {
         //$error = "Your Login User ID or Password is invalid";
		 echo '<script>alert("Your Login User ID or Password is invalid")</script>';
      }
   }
?>
<?php include 'header.php';?>

<?php include 'login.php';?>
<header class="masthead">
        <section class="text-center about" id="aboutus">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                <div class="col-md-6 mb-5">
                
                        <h2 class="display-4 lh-1 mb-4">Welcome to Fleming College</h2>
                        <p class="lead fw-normal  mb-5 mb-lg-0">Welcome to Fleming School of business and technology. Fleming College known for its excellence in Business, Environmental and Science Studies.</p>
                        <hr>
                        <button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0">
                        <span class="d-flex align-items-center">
                          <a href="https://flemingcollege.ca/"> <span class="small text-white">Learn More</span></a>
                        </span>
                    </button>
                    </div>
              
                <div class="col-md-6 col-lg-6">
                    <!-- Masthead device mockup feature-->
                        <iframe width="100%" height="380" src="https://www.youtube.com/embed/4A5jm6sn1BA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            
                </div>
                </div>
            </div>
        </section>
        </header>
        <section class="text-center bg-gradient-primary-to-secondary contactus" id="contactus">
             <div class="col-lg-12 order-lg-1 mb-5 mb-lg-0">
             <div class="h2 fs-1 text-white mb-4">Contact us</div>
                        <div class="container-fluid px-5 contactus">
                            <div class="row gx-5">
                                <div class="col-md-4 mb-5">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                        <i class="fas fa-phone-square fa-2x  text-white d-block mb-3"></i>
                                        <h3 class="font-alt text-white">Call at</h3>
                                        <p class=" text-white mb-0">705-749-5530 X 1392</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-5">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                     <i class="fas fa-envelope-open-text  fa-2x  text-white d-block mb-3"></i>
                                        <h3 class="font-alt text-white">Write at</h3>
                                        <p class="text-white mb-0">Alwyn.appiah@flemingcollege.ca</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-5 mb-md-0">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                  
                                        <i class="fas fa-map-marked-alt  fa-2x  text-white d-block mb-3"></i>
                                        <h3 class="font-alt text-white">Fleming College</h3>
                                        <p class="text-white mb-0">Peterborough,Canada</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
        </section>

        
      
      
        


<?php include 'footer.php';?>

