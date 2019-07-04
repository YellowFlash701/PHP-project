<?php require_once("../common/_header.php");   ?>

<?php 
    require_once("../includes/database.class.php");     ?>

<?php


    $table = "exam_details as ED 
    LEFT JOIN master_college as MClg ON MClg.id = ED.college_id
    LEFT JOIN exam_user as EU ON EU.exam_id = ED.id
    LEFT JOIN master_user as MU ON MU.id = EU.user_id ";
    $where = "1";
    $select = "ED.*, MClg.name as college_name, EU.*, MU.name as user_name, EU.id as exam_user_id ";

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
            $output .= '
            <table class="table" table-bordered>  
                      
                                <th>Name </th>
                                
                                <th>Seatno</th>          
                                ';
            
            foreach ($data as $record_key => $record_value) {  

                $row =  $record_value;                                              //ekach student cha data store kela row madhe  
            
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
               $output .= '
                            <tr>
                    <td>'.$row['user_name'].'</td>  
                    
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
                
         ?>
       
<?php
            
        
        }
    }
   
    $output .= '</table>';
  //  header('Content-Type: application/xls');
   // header('Content-Disposition: attachment; filename=download.xls');
    echo $output;
   

  
?>
<?php require_once("../common/_footer.php");   ?>

