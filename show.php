<?php 
$servername="localhost";
$username="root";
$password="";
$dbname="project_db";

$conn= mysqli_connect($servername,$username,$password,$dbname);

    
    $query="SELECT * FROM exam_marksheet";
    $data= mysqli_query($conn, $query);
    $data2= mysqli_query($conn, $query);

    mysqli_query($conn,"SELECT * FROM master_user");
    echo "<h4>Total number of records inserted are =";
    echo  mysqli_affected_rows($conn)."</h4>";

  
?>
  <head>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
 <body>

<div class="container">
<table class="table table-hover">

<div class="container">


    <form action="" method="GET">
  
    <input type="number" name="id"  >
       <br> <br><input type="submit" class="btn btn-info" value="Submit Button">
       </div>

       </form>
   
    
  <?php
     $count=0;
     $id=0;
         if(isset($_GET['id']))
        $id=$_GET['id'];
      
          
 //    
   
     $data1= mysqli_query($conn,"SELECT seat_no from exam_user where exam_id=$id" ) ;
      $seat = mysqli_fetch_assoc($data1);
      echo "<h4>Seat number is:";
      echo  $seat['seat_no']."</h4>";
        $result=array();
        $i=0;
         while( $heading=mysqli_fetch_assoc($data))
         {
          
            if($heading['exam_user_id']==$id)
            {
                echo "
                <th>".$heading['short_code']."</th>";
            }
         }
         echo "<tr>";
           while($re=mysqli_fetch_assoc($data2))
         {
              if($re['exam_user_id']==$id)
            {
                echo "
                <td>".$re['obtained']."</td>";
            }

         }
         ?></table>
         
</div>


