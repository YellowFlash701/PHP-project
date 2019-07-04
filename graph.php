
<html>
<title> Graphcal representation</title>
<?php require_once("../common/_header.php");   ?>
<?php require_once("../includes/database.class.php");     ?>


<style>
div.fixed {
  position: fixed;
  bottom: 700;
  right: 0;
  width: 60px;
}
</style>
<div class="fixed">

<div id="myDIV">
<button  class="btn btn-primary inline-block" onclick="myFunction()">Print</button></div>
</div>

<br><br>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div id="chartContainer1" style="width: 100%; height: 300px;display: inline-block;"></div> 

<br><br>
<div id="chartContainer2" style="width: 100%; height: 300px;display: inline-block;"></div> 

<br><br>
<div id="chartContainer3" style="width: 100%; height: 300px;display: inline-block;"></div> 



<?php
// if(isset($_POST["export"]))

    $table = "exam_details as ED 
        LEFT JOIN master_college as MClg ON MClg.id = ED.college_id
        LEFT JOIN exam_user as EU ON EU.exam_id = ED.id
        LEFT JOIN master_user as MU ON MU.id = EU.user_id ";
    $where = "1 ORDER BY seat_no ASC";
    $select = "
        (SELECT COUNT(id) FROM `exam_user`) as total_appeared,
        (SELECT COUNT(id) FROM `exam_user` WHERE (result LIKE 'FIRST CLASS DIST.')) as total_dist,
        (SELECT COUNT(id) FROM `exam_user` WHERE (result LIKE 'FIRST CLASS' OR  result LIKE 'FIRST CLASS CON')) as total_first,
        (SELECT COUNT(id) FROM `exam_user` WHERE (result LIKE 'SECOND CLASS' OR  result LIKE 'SECOND CLASS CON')) as total_second,
        (SELECT COUNT(id) FROM `exam_user` WHERE (result LIKE 'A.T.K.T.')) as total_atkt,
        (SELECT COUNT(id) FROM `exam_user` WHERE (result LIKE 'FAIL')) as total_fail
    ";
    $summary = $dbObj->fetchSingle($table, $where, $select);
    
    $total_pass=intval($summary["total_dist"])+intval($summary["total_first"])+intval($summary["total_second"]);
    $result = round(($total_pass/(intval($summary["total_appeared"])))*100);
    

    $total_atkt= intval($summary["total_atkt"]);
    $total_appeared= intval($summary["total_appeared"]);
    $result_with_atkt= round((($total_pass+$total_atkt)/$total_appeared)*100);
    

?>

<table class="table table-bordered">
<h2>Appread Students analysis</h2>
    <thead>
            <th> Total Appeared</th>
            <th> Distinction</th>
            <th> First Class</th>
            <th> Second Class</th>
            <th> Total Pass </th>
            <th>A.T.K.T.</th>
            <th>%Result</th>
            <th>%Result with ATKT</th>
            <th>Fail</th>
           
    </thead>
    <tr>   
        <td><?php echo $summary["total_appeared"]?></td>
        <td><?php echo $summary["total_dist"]?></td>
        <td><?php echo $summary["total_first"]?></td>
        <td><?php echo $summary["total_second"]?></td>
        <td><?php echo $total_pass?></td>
        <td><?php echo $summary["total_atkt"]?></td>
        <td><?php echo $result?></td>
        <td><?php echo $result_with_atkt?></td>
        <td><?php echo $summary["total_fail"]?></td>
    </tr>
</table>
<br>

<?php
 
$dataPoints = array(
	array("label"=> "Total Appeared", "y"=> $summary["total_appeared"]),
	array("label"=> "Distinction", "y"=> $summary["total_dist"]),
	array("label"=> "First Class", "y"=> $summary["total_first"]),
	array("label"=> "Second Class", "y"=> $summary["total_second"]),
	array("label"=> "Total Pass", "y"=> $total_pass),
	array("label"=> "A.T.K.T.", "y"=> $summary["total_atkt"]),
	array("label"=> "%Result", "y"=> $result),
	array("label"=> "%Result with ATKT", "y"=> $result_with_atkt),
	array("label"=> "Fail", "y"=> $summary["total_fail"]),
	
);
	
?>
<script>
 
var chart = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "Appeared Student Analysis"
	},
	axisY: {
		title: " ",
		includeZero: false
	},
	data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 

</script>



<?php
            //overall toppers

$table = "exam_details as ED 
        LEFT JOIN master_college as MClg ON MClg.id = ED.college_id
        LEFT JOIN exam_user as EU ON EU.exam_id = ED.id
        LEFT JOIN master_user as MU ON MU.id = EU.user_id ";
    $where = "1 ORDER BY marks_total DESC LIMIT 3";
    $select = " MU.name as user_name, EU.marks_total as total_obtained, 
                ( SELECT SUM(MAX) as total FROM `exam_marksheet` WHERE exam_marksheet.exam_user_id = EU.user_id ) as total_max";
    $overall_topper_list = $dbObj->fetchMultiple($table, $where, $select);
    foreach($overall_topper_list as $key => $value)
    {
        $per[$key] = round((intval($overall_topper_list[$key]["total_obtained"])/intval(($overall_topper_list[$key]["total_max"])))*100,2);
    }

?>


<table class="table table-bordered">
<h2>Semester toppers</h2>
    <thead>
            <th> Name</th>
            <th> Total obtained</th>
            <th> Percentage</th>
            
                      
    </thead>
    
        <?php
        foreach($overall_topper_list as $key => $value)
        {?>
            <tr>
                <td><?php echo $value["user_name"]?></td>
                <td><?php echo $value["total_obtained"]?> / <?php echo $value["total_max"]?> </td>
                <td><?php echo $per[$key]?></td>
              
            </tr>
        <?php }?>
       
    
</table>
<?php
$cnt=0;
 foreach($overall_topper_list as $key => $value)
 {    
        $cnt++;
        if($cnt==1)
        {
           $fr["user_name"]=$value["user_name"];
           $fr["per"]=$per[$key];
        }
        if($cnt==2)
        {
           $se["user_name"]=$value["user_name"];
           $se["per"]=$per[$key];
        }
        if($cnt==3)
        {
           $th["user_name"]=$value["user_name"];
           $th["per"]=$per[$key];
        }
     
     
 }

$dataPoints = array(
    array("label"=> $fr["user_name"], "y"=> $fr["per"]),
    array("label"=> $se["user_name"], "y"=> $se["per"]),
    array("label"=> $th["user_name"], "y"=> $th["per"]),
);
	
?>
<script>

var chart = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "Overall Toppers"
	},
	axisY: {
		title: " ",
		includeZero: false
	},
	data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

</script>

<?php 

            //subject wise toppers
$table = "exam_marksheet as EM1
        LEFT JOIN exam_user as EU ON EU.id = EM1.exam_user_id
        LEFT JOIN exam_details as ED ON ED.id = EU.exam_id
        LEFT JOIN master_user as MU ON MU.id = EU.user_id
        ";
    $where = "obtained = (
                    SELECT 
                        MAX(obtained)
                    FROM
                        exam_marksheet as EM2
                    WHERE
                        EM1.short_code = EM2.short_code AND
                        EM1.type = EM2.type
                        
                    GROUP BY
                        short_code
                )
                AND type = 'TH'
            GROUP BY
                short_code";

    $select = "EM1.*, MU.name as user_name, MAX(obtained) as top_marks";

    $sub_topper_list = $dbObj->fetchMultiple($table, $where, $select);


   ?>
<table class="table table-bordered">
    <h2>Subject toppers</h2>
    <thead>
            <th>Subject </th>
            <th>Name of Student</th>
            <th>Marks</th>
                      
    </thead>
    
        <?php
        foreach($sub_topper_list as $key => $value)
        {?>
            <tr>
                <td><?php echo $value["short_code"]?></td>
                <td><?php echo $value["user_name"]?></td>
                <td><?php echo $value["top_marks"]?></td>
            </tr>
        <?php }?>


<?php
$cnt=0;
 foreach($sub_topper_list as $key => $value)
 {    
        $cnt++;
        if($cnt==1)
        {
           $f["short_code"]=$value["short_code"];
           $f["top_marks"]=$value["top_marks"];
        }
        if($cnt==2)
        {
           $s["short_code"]=$value["short_code"];
           $s["top_marks"]=$value["top_marks"];
        }
        if($cnt==3)
        {
           $t["short_code"]=$value["short_code"];
           $t["top_marks"]=$value["top_marks"];
        }
        if($cnt==4)
        {
           $fo["short_code"]=$value["short_code"];
           $fo["top_marks"]=$value["top_marks"];
        }
        if($cnt==5)
        {
           $fi["short_code"]=$value["short_code"];
           $fi["top_marks"]=$value["top_marks"];
        }
     
     
 }

$dataPoints = array(
    array("label"=> $f["short_code"], "y"=> $f["top_marks"]),
    array("label"=> $s["short_code"], "y"=> $s["top_marks"]),
    array("label"=> $t["short_code"], "y"=> $t["top_marks"]),
    array("label"=> $fo["short_code"], "y"=> $fo["top_marks"]),
	array("label"=> $fi["short_code"], "y"=> $fi["top_marks"]),
);
	
?>
<script>
var chart = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: " Subjectwise Analysis"
	},
	axisY: {
		title: " ",
		includeZero: false
	},
	data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 

</script>

<script>
function myFunction() {
    var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  
  window.print();
}
</script>

</html>
<?php require_once("../common/_footer.php");   ?>