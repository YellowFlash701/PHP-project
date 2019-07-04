<?php require_once("../common/_header.php");   ?>
<?php require_once("../includes/database.class.php");     ?>

<?php
// if(isset($_POST["export"]))
{
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
<h2>Result analysis</h2>
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
<br>
<?php
   /* echo "<pre>";
    print_r($summary);
    echo "<pre>";*/
}

{
    // overall_topper


    $table = "exam_details as ED 
        LEFT JOIN master_college as MClg ON MClg.id = ED.college_id
        LEFT JOIN exam_user as EU ON EU.exam_id = ED.id
        LEFT JOIN master_user as MU ON MU.id = EU.user_id ";
    $where = "1 ORDER BY marks_total DESC LIMIT 3";
    $select = " MU.name as user_name, EU.marks_total as total_obtained, 
                ( SELECT SUM(MAX) as total FROM `exam_marksheet` WHERE exam_marksheet.exam_user_id = EU.user_id ) as total_max";
    $overall_topper_list = $dbObj->fetchMultiple($table, $where, $select);
?>
<table class="table table-bordered">
<h2>Semester toppers</h2>
    <thead>
            <th> Name</th>
            <th> Total obtained</th>
                   
    </thead>
    
        <?php
        foreach($overall_topper_list as $key => $value)
        {?>
            <tr>
                <td><?php echo $value["user_name"]?></td>
                <td><?php echo $value["total_obtained"]?></td>
                
            </tr>
        <?php }?>
       
    
</table>
<br>
<br>
<?php
   /* echo "<pre>";
    print_r($overall_topper_list);
    echo "<pre>";*/
}



{
    //subject wise topper

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
    
}
?>


<?php
 header('Content-Type: application/xls');
 header('Content-Disposition: attachment; filename=download_analysis.xls');
?>
<?php require_once("../common/_footer.php");   ?>