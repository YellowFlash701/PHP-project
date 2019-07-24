<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php require_once("../common/_header.php");   ?>

<?php 
    require_once("../includes/database.class.php");     ?>

    <style>
     body{
		 background:#DB4437;
		 color:white;
	 }
	 table table-bordered{
		 width:800px;
		 margin:auto;
		 text-align:center;
		 table-layout:fixed;
	 }
	 table table-bordered tr , td , th {
		 padding:20px;
		 color:white;
		 border:1px solid #080808;
		 border-collapse:collapse;
		 font-size:18px;
		 font-family:Arial;
		 background:linear-graadient(top,#3c3c3c 0%,#222222 100%);
		 background:-webkit-linear-graadient(top,#3c3c3c 0%,#222222 100%);
		}
		
</style>

<?php
    //  --- Single --- 

    /*
        $table = "exam_details as ED 
            LEFT JOIN master_college as MClg ON MClg.id = ED.college_id
            LEFT JOIN exam_user as EU ON EU.exam_id = ED.id
            LEFT JOIN master_user as MU ON MU.id = EU.user_id
            ";
        $where = "EU.seat_no = '518799' ";
        $select = "ED.*, MClg.name as college_name, EU.*, MU.name as user_name, EU.id as exam_user_id"; //hychyane student cha data yeto

        $data = $dbObj->fetchSingle($table, $where, $select);

        $table = "exam_marksheet";
        $where = "exam_user_id = " . $data["exam_user_id"];
        $select = "*";
        $data["marksheet"] = $dbObj->fetchMultiple($table, $where, $select);        //hyachya ne tya student che marks yetat
    */  
?>

<?php
    $table = "exam_details as ED 
    LEFT JOIN master_college as MClg ON MClg.id = ED.college_id
    LEFT JOIN exam_user as EU ON EU.exam_id = ED.id
    LEFT JOIN master_user as MU ON MU.id = EU.user_id ";
    $where = "1 ORDER BY EU.seat_no";
    $select = "ED.*, MClg.name as college_name, EU.*, MU.name as user_name, EU.id as exam_user_id";

    $data = $dbObj->fetchMultiple($table, $where, $select);
   
    if($data){
        foreach ($data as $key => $row) {
            $table = "exam_marksheet";
            $where = "exam_user_id = " . $row["exam_user_id"];              //tya student che marks ghyayche jyacha exam_user_id ha row variable madhe ahe
            $select = "*";
            $data[$key]["marksheet"] = $dbObj->fetchMultiple($table, $where, $select);
        }
    }/*
    $table = "exam_details as ED";
    $where = "1";
    $select = "exam_type,exam_year";
    $data = $dbObj->fetchSingle($table,$where,$select);*/
   
    /*echo "<pre>";
    print_r($data);
    echo "</pre>";*/

?>

<form class="box"  method="post">
<input type="submit" name="export" formaction="Result_down.php" value="Download Result " class="w3-button w3-black w3-padding-large w3-large w3-margin-top">
<input type="submit" name="export" formaction="Analysis_down.php" value="Download Analysis " class="w3-button w3-black w3-padding-large w3-large w3-margin-top">
<input type="submit" name="export" formaction="graph.php" value="Show Graph" class="w3-button w3-black w3-padding-large w3-large w3-margin-top">
        
  </form>
  <form action="result.php">
  <input class="btn btn-primary inline-block" type="submit" value="Print">
</form>
<?php

/* echo "<pre>";
 print_r($data);
 echo "</pre>";*/
?>

<?php                                                                               //display
    if($data){
        foreach ($data as $record_key => $record_value) {   ?>
            <?php
                $row =  $record_value;                                              //ekach student cha data store kela row madhe  
            ?>

            <h1> <?php echo $record_key+1; ?> </h1>
            <h4> <?php echo $row["user_name"]; ?> <small> <?php echo $row["seat_no"]; ?> </small> </h4>

            <?php
            $marksheet = $row["marksheet"];                                          //marksheet madhe bakicha data store na karat fakta marksheet array store kela   
            if($marksheet){      ?>

            <table class="table table-bordered">
                <thead>       
                    <tr>
                    <?php
                        foreach ($marksheet as $key => $value) {     ?>
                            <th> <?php echo $value["short_code"] . "<br>" . $value["type"]; ?> </th>
                    <?php
                        }   ?>
                            <th> Total marks </th>
                            <th> Result </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                        foreach ($marksheet as $key => $value) {     ?>
                            <td> <?php echo $value["obtained"] . "" . $value["special_char"]; ?> </td>
                    <?php
                        }   ?>
                        <td> <?php echo $row["marks_total"]; ?> </td>
                        <td> <?php echo $row["result"]; ?> </td>
                    </tr>
                </tbody>

            </table>

                <?php
                }
                ?>

<?php
        }
    }
?>
<?php require_once("../common/_footer.php");   ?>