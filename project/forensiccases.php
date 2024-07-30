<?php
    require("includes/common.php");

    // Check if session is set
    if (!isset($_SESSION['email'])) {
        header('location: index.php');
    }

    $value = $_SESSION['value'];

    if(isset($_POST["submit"])) {  
        $rcaseid = $_POST['rcaseid'];

        $eviquery = "SELECT FINGERPRINT FROM EVIDENCE WHERE CASE_ID = '". $rcaseid ."' ";
        $susquery = "SELECT FINGERPRINT FROM SUSPECTS WHERE CASE_ID = '". $rcaseid ."' ";

        $run_eviquery = mysqli_query($con, $eviquery);
        $run_susquery = mysqli_query($con, $susquery);

        $evi_r = mysqli_fetch_array($run_eviquery);
        $sus_r = mysqli_fetch_array($run_susquery);

        if($evi_r==$sus_r) {
            echo "<script>if(confirm('Match Found!')){document.location.href='forensiccases.php'};</script>";
        } else {
            echo "<script>if(confirm('Match Not Found!')){document.location.href='forensiccases.php'};</script>";
        } 
    }

    require 'image.compare.class.php';

    if(isset($_POST["submit2"])) {  
        $path1 = $_FILES["image1"]["tmp_name"];
        $path2 = $_FILES["image2"]["tmp_name"];

        // Ensure paths are not empty
        if(empty($path1) || empty($path2)) {
            die("Both image files must be uploaded.");
        }

        // Delete previous images from the database
        $del = "DELETE FROM IMAGES";
        $run_del = mysqli_query($con, $del) or die(mysqli_error($con));

        // Add new images to the database
        $file1 = addslashes(file_get_contents($path1));  
        $file2 = addslashes(file_get_contents($path2));
        $query = "INSERT INTO IMAGES(IMAGE1, IMAGE2) VALUES ('$file1','$file2')";
        $run_query = mysqli_query($con, $query) or die(mysqli_error($con));

        // Compare the images
        $class = new compareImages;
        $thresh_val = $class->compare($path1, $path2);

        if($thresh_val < 7) {
            echo "<script>if(confirm('Match Found!')){document.location.href='forensiccases.php'};</script>";
        } else {
            echo "<script>if(confirm('Match Not Found!')){document.location.href='forensiccases.php'};</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="codepixer">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Case Analysis</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/caseanalysis.css">
</head>
<body>

    <!-- Header -->
    <?php require 'includes/header.php'; ?>

    <!-- Banner Area -->
    <section class="banner-area relative" id="home">
        <div class="overlay"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">Cases Analysis</h1>
                    <p class="text-white link-nav">
                        <?php if ($_SESSION['email'] == 'admin@fds.com') { ?>
                            <a href="adminhome.php">Home</a>
                        <?php } elseif ($_SESSION['email'] == 'officer@fds.com') { ?>
                            <a href="officerhome.php">Home</a>
                        <?php } else { ?>
                            <a href="home.php">Home</a>
                        <?php } ?>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="forensiccases.php">Case Analysis</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!-- Start Simple Services Area -->
    <section class="simple-services-area section-gap">
        <div class="container">
            <br/>
            <div class="content-header">
                <h3>Database Fingerprint Matching</h3>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6 text-center">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Case Id</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="rcaseid" required="true">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <button type="submit" name="submit" class="btn btn-primary btn-md">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container">
            <br/><br/>
            <div class="content-header">
                <h3>Evidence Matching</h3>
            </div>
            <hr/>
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Evidence</label>
                            <div class="col-sm-3">
                                <input type="file" name="image1" id="image1" required/>
                                <br/><br/>
                            </div>
                        </div>
                        <table class="table table-center table-bordered">
                            <tr><th>Image</th></tr>
                            <?php
                            $query = "SELECT * FROM IMAGES WHERE ID = (SELECT MAX(ID) FROM IMAGES)";
                            $result = mysqli_query($con, $query);
                            while($row = mysqli_fetch_array($result)) {
                                echo '<tr><td><img src="data:image/jpeg;base64,'.base64_encode($row['IMAGE1']).'" height="200" width="200" class="img-thumbnail"/></td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Evidence</label>
                            <div class="col-sm-3">
                                <input type="file" name="image2" id="image2" required/>
                                <br/><br/>
                            </div>
                        </div>
                        <table class="table table-center table-bordered">
                            <tr><th>Image</th></tr>
                            <?php
                            $query = "SELECT * FROM IMAGES WHERE ID = (SELECT MAX(ID) FROM IMAGES)";
                            $result = mysqli_query($con, $query);
                            while($row = mysqli_fetch_array($result)) {
                                echo '<tr><td><img src="data:image/jpeg;base64,'.base64_encode($row['IMAGE2']).'" height="200" width="200" class="img-thumbnail"/></td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="container">
                    <br/><br/>
                    <div class="row col-md-12 offset-md-11 text-center">
                        <div class="form-group row">
                            <div class="col">
                                <button type="submit" name="submit2" class="btn btn-primary btn-md">Match</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- End Simple Services Area -->

    <!-- Start Footer Area -->
    <?php require 'includes/footer.php'; ?>
	<!-- End footer Area -->      

<script src="js/vendor/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7W3mgPxhUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="js/vendor/bootstrap.min.js"></script>            
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
<script src="js/easing.min.js"></script>           
<script src="js/hoverIntent.js"></script>
<script src="js/superfish.min.js"></script> 
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>  
<script src="js/owl.carousel.min.js"></script>           
<script src="js/jquery.sticky.js"></script>
<script src="js/jquery.nice-select.min.js"></script>    
<script src="js/waypoints.min.js"></script>
<script src="js/jquery.counterup.min.js"></script>                  
<script src="js/parallax.min.js"></script>      
<script src="js/mail-script.js"></script>   
<script src="js/main.js"></script>   

<script>  
$(document).ready(function(){  
    $('form').on('submit', function(e) {
        var image1 = $('#image1').val();
        var image2 = $('#image2').val();
        
        if(!image1 || !image2) {
            alert("Both image files must be selected.");
            e.preventDefault(); // Prevent form from submitting
            return false;
        }
        
        var ext1 = image1.split('.').pop().toLowerCase();
        var ext2 = image2.split('.').pop().toLowerCase();
        
        if($.inArray(ext1, ['gif','png','jpg','jpeg']) == -1 || $.inArray(ext2, ['gif','png','jpg','jpeg']) == -1) {
            alert("Invalid image file type. Please select a valid image file.");
            $('#image1').val('');
            $('#image2').val('');
            e.preventDefault(); // Prevent form from submitting
            return false;
        }
    });
});
</script>  

</body>
</html>


