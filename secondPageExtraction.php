<?php require_once("../common/_header.php");   ?>

<?php require_once("../includes/database.class.php");   ?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<style>
    html, body {
    margin:0;
    padding:0;
}
body { background:lightgrey; }
body:after {
    content:"";
    background:#DB4437;
    position:fixed;
    top:0;
    bottom:20%;
    right:0;
    left:0;
    content:" ";
    z-index:-1;
	
}
button
{
    position: relative;
    left: 500px;
}
table {
  border-collapse: collapse;
  width: 100%;
}

td {
  height: 50px;
}

</style>
<body>
     
    <div class="col-xs-12 col-sm-6 col-md-4 center">

      <font color="white">  
      <form action="" method="post" class="form-horizonal" id="frmUpload">

                <div class="form-group">
                    <label for="file" class="control-label">Select File : </label>
                    <input type="file" name="file" class="form-control" required>
                </div>
            
                <h1>Choose Department</h1>
                
                <input type="radio" name="dept"  value="CM">Computer Technology<br>
                <input type="radio" name="dept"  value="ME">Mechanical<br>
                <input type="radio" name="dept"  value="EJ">Electronics<br>
                <input type="radio" name="dept"  value="EE">Electrical<br>
                <input type="radio" name="dept"  value="CE">Civil<br>
                
            <br>
           

                <h1>Choose Semester</h1>
                <table id="table 1">
                    <tr>
                        <td><input type="radio" name="year"  value="FIRST">First Sem</td>
                        <td><input type="radio" name="year"  value="SECOND">Second Sem<td>
                    </tr>
                    
                    <tr>
                        <td><input type="radio" name="year"  value="THIRD">Third Sem</td>
                        <td><input type="radio" name="year"  value="FOURTH">Fourth Sem</td>
                    </tr>

                    <tr>
                        <td><input type="radio" name="year"  value="FIFTH">Fifth Sem<br></td>
                        <td><input type="radio" name="year"  value="FINAL">Final Sem<br></td>
                    </tr>
                </table>
                        
            <br>
            <br>

                <div class="form-group">
                    <input type="submit" value="Submit" name="btnProcess" class="btn btn-primary inline-block" >
                    <img src="spinners.gif" alt="Loading.." class="inline-block spinner">
                </div>
            
            
        </form>

        
    </div>
    
    
    <div class="clearfix"></div><br>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <p>Save Data :</p>
        <br>
        <div class="progress">
            <div class="progress-bar" id="progress-save"
                role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" 
                style="min-width: 2em;">
                0%
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12" id = "result-1">
        <!-- <a id="view_result" class="btn btn-success" href="#"> Verify Data </a> -->
        <div id="result"></div>
    </div>

    <form  action="ThirdPage.php" >
        <button type="submit"  class="w3-button w3-black w3-padding-large w3-large w3-margin-top" value="Next" >Next</button>
    </form>
	<br>
	<br>
	<br>
 <center><h3><p>Powered by Easy Analysis</p></h3></center>

</body>
<?php require_once("../common/_footer.php");   ?>