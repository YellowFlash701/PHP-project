<?php require_once("../common/_header.php");   ?>

<?php 
    require_once("../includes/database.class.php");     ?>

<?php
if(isset($_POST["export"]))
{

    $table = "exam_details as ED 
    LEFT JOIN master_college as MClg ON MClg.id = ED.college_id
    LEFT JOIN exam_user as EU ON EU.exam_id = ED.id
    LEFT JOIN master_user as MU ON MU.id = EU.user_id ";
    $where = "1 ORDER BY seat_no ASC";
    $select = "ED.*, MClg.name as college_name, EU.*, MU.name as user_name, EU.id as exam_user_id, MU.enroll_no ";

    $data = $dbObj->fetchMultiple($table, $where, $select);
   
    if($data){
        foreach ($data as $key => $row) {
            $table = "exam_marksheet";
            $where = "exam_user_id = " . $row["exam_user_id"];              //tya student che marks ghyayche jyacha exam_user_id ha row variable madhe ahe
            $select = "*";
            $data[$key]["marksheet"] = $dbObj->fetchMultiple($table, $where, $select);
        }
    }
?>
<?php                                                                               //display
    if($data){
?>
        <thead>
        <tr> 
        <?php  
        $count=0;
        $total_noof_students=0;   
        $dist=0;
        $first=0;
        $second=0;
        $atkt=0;
        $fail=0;
            $output .= '
            <table class="table" bordered="10">  
                     
                                
                                <th>Name </th>
                                <th>Enrollment no</th>
                                <th>Seat no</th>
                                ';
            
            foreach ($data as $record_key => $record_value) {  

                $row =  $record_value;                                              //ekach student cha data store kela row madhe  
                $total_noof_students= $total_noof_students+1;
               

                $marksheet = $row["marksheet"]; 
                if($count==0)
                {                                         //marksheet madhe bakicha data store na karat fakta marksheet array store kela   
                    if($marksheet)
                    {      
                        foreach ($marksheet as $key => $value)
                        {
                            
                                $output .= 
                                        '                             
                                        <th>'.$value['short_code'].'<br>'.
                                        $value['type'].'</th>  
                                            
                                        ';
                        }    
                        $count=$count+1;
                    }
                
                        $output .= '   <th>Total </th>
                                    <th>Result</th>
                    ';
                }
                ?>
        </tr>  
        </thead><?php
 ?>            
     
    
    
      <?php
       ?>
       <?php
      
               $output .= '
                            <tr>
                    <td>'.$row['user_name'].'</td>  
                    <td>'.$row['enroll_no'].'</td>
                    <td>'.$row['seat_no'].'</td>
                     
             ';
             foreach ($marksheet as $key => $value)
             {
                 
                     $output .= 
                             '                             
                             <td>'.$value['obtained'].'
                             '.$value['special_char'].'</td>  
                                 
                             ';
             }

             $output .= '
                            
                    <td>'.$row['marks_total'].'</td>  
                    
                    <td>'.$row['result'].'</td>
                        
                ';
                if($row['result']=='FIRST CLASS DIST.')
                {
                    $dist=$dist+1;
                }
                if($row['result']=='FIRST CLASS' || $row['result']=='FIRST CLASS CON')
                {
                    $first=$first+1;
                }
                if($row['result']=='SECOND CLASS' || $row['result']=='SECOND CLASS CON')
                {
                    $second=$second+1;
                }
                if($row['result']=='A.T.K.T.')
                {
                    $atkt=$atkt+1;
                }
                if($row['result']=='FAIL')
                {
                    $fail=$fail+1;
                }
                
                
         ?>
       
<?php
            
        
        }
    }
   
    $output .= '</table>';
    // header('Content-Type: application/xls');
    // header('Content-Disposition: attachment; filename=download.xls');
    echo $output;
    ?>
    <br>
    <br>
    <table  class="table table-bordered"> 
    <th>Appeared</th>
    <th>Distingtion</th>
    <th>1st class</th>
    <th>2nd class</th>
    <th>Total Pass</th>
    <th>A.T.K.T.</th>
    <th>Fail</th>
    <th>%Result</th>
    <th>%Result with ATKT</th>
   
    <?php
            $total_pass=$dist+$first+$second;
            $pass_per=($total_pass/$total_noof_students)*100;

            $pass_per_atkt=(($total_pass+$atkt)/$total_noof_students)*100;
            echo  "<tr>
                <td>".$total_noof_students."</td>
                <td>".$dist."</td>
                <td>".$first."</td>
                <td>".$second."</td>
                <td>".$total_pass."</td>
                <td>".$atkt."</td>
                <td>".$fail."</td>
                <td>".$pass_per."</td>
                <td>".$pass_per_atkt."</td>
                </tr>";
        
  }
  
?>
</table>
<?php require_once("../common/_footer.php");   ?>

