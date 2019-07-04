<!DOCTYPE html>
<html lang="en">
<title>Home</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
<body>


<!-- Header -->
<form  action="secondPageExtraction.php">
<header class="w3-container w3-red w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo">EASY ANALYSIS</h1>
  <p class="w3-xlarge">Expect nothing less than perfection</p>
  <button class="w3-button w3-black w3-padding-large w3-large w3-margin-top">Get Started</button>
</header>
</form>
<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-twothird">
      <h1></h1>
      <h5 class="w3-padding-32">This work is oriented to help users for analyzing result of student’s and generating different reports on just a single click.To achieve this we have developed a web based solution which will take PDF(Gazette) file as an input. The system will extract record of each student and will store different options and after clicking on a particular option the SQL query will be fired and output will be displayed to the user. The system will allow user to download these reports. These reports will be excel 	files and will be editable.</h5>

      <p class="w3-text-grey">                            


      </p>
    </div>

    <div class="w3-third w3-center">
      <i class="fa fa-anchor w3-padding-64 w3-text-red"></i>
    </div>
  </div>
</div>

<!-- Second Grid -->
<div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-third w3-center">
      <i class="fa fa-coffee w3-padding-64 w3-text-red w3-margin-right"></i>
    </div>

    <div class="w3-twothird">
      <h1>Easy Analysis</h1>
      <h5 class="w3-padding-32">All the result analysing will be done automatically.<br>Efforts and time consumption will be reduced.


</h5>

      <p class="w3-text-grey">Our main aim through this project is to reduce manual work, to provide efficient way of handling the student data. The ‘result analysis ‘module our project reduces the work of staff of making entries for each student manually.</p>
    </div>
  </div>
</div>

<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Quote of the day: live life</h1>
</div>

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity">  
  <div class="w3-xlarge w3-padding-32">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
   <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
 </div>
 <p>Powered by Easy Analysis</a></p>
</footer>
<?php
	$connect=mysqli_connect("localhost","root","","project_db");
	$query= "DELETE FROM master_user";
	$result=mysqli_query($connect,$query);
	$query= "DELETE FROM exam_details";
	$result=mysqli_query($connect,$query);
	$query= "DELETE FROM exam_marksheet";
	$result=mysqli_query($connect,$query);
	$query= "DELETE FROM master_college";
	$result=mysqli_query($connect,$query);
	$query= "DELETE FROM exam_user";
	$result=mysqli_query($connect,$query);
	
	$query= "DELETE FROM master_course";
	$result=mysqli_query($connect,$query);
?>
<script>
// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

</body>
</html>
