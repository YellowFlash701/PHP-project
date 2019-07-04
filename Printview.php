<?php require_once("../common/_header.php");   ?>

<?php 
    require_once("../includes/database.class.php");     ?>

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
    }
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
<script>
    window.print();
    </script>

<?php require_once("../common/_footer.php");   ?>