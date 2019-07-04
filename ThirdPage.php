<!DOCTYPE html>
<html lang="en">
<title>Easy Analysis | </title>
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

<style type="text/css">
	.Display{
    position: relative;
    display: inline-block;
    margin: 20px 20px;
    padding: 15px;
    width: 145px;
    border: 1px solid #444;
    color: #444;
    border-radius: 4px;
    background: linear-gradient(-45deg,red,pink);
    color: #fff;
  }
  .DownloadResult{
    position: relative;
    display: inline-block;
    margin: 20px 20px;
    padding: 15px;
    width: 145px;
    border: 1px solid #444;
    color: #444;
    border-radius: 4px;
    background: linear-gradient(-45deg,red,pink);
    color: #fff;
  }
  .Download{
    position: relative;
    display: inline-block;
    margin: 20px 20px;
    padding: 15px;
    width: 145px;
    border: 1px solid #444;
    color: #444;
    border-radius: 4px;
    background: linear-gradient(-45deg,red,pink);
    color: #fff;
	}
</style>

<body>


<!-- Header -->

<header class="w3-container w3-red w3-center" style="padding:128px 16px">
 
  <h1 class="w3-margin w3-jumbo">EASY ANALYSIS</h1> 
  <p class="w3-xlarge">Expect nothing less than perfection</p>
   <p class="w3-xlarge"></h3>Thank you for using our Service.</h3></p>
   <center> 
     <form action="view.php"><input type="submit"  class="w3-button w3-black w3-padding-large w3-large w3-margin-top" value="Display"></form>
     <form action="Result_down.php"><input type="submit" name="export" class="w3-button w3-black w3-padding-large w3-large w3-margin-top" value="Download Result "></form>
     <form action="testa.php"><input type="submit" name="export"  class="w3-button w3-black w3-padding-large w3-large w3-margin-top" value="Download Analysis"></form>
     <form action="graph.php"><input type="submit" name="export"  class="w3-button w3-black w3-padding-large w3-large w3-margin-top" value="Graph"></form></center>

  </header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-twothird">
      <form class="box"  method="post">
      <p class="w3-text-grey">                            

      </p>
    </form>
    </div>

   
  </div>
</div>



<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity">  
  
 <h3><p>Powered by Easy Analysis</a></p></h3>
</footer>




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
