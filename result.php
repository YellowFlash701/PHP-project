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
    $select = "ED.*, MClg.name as college_name, EU.*, MU.name as user_name, EU.id as exam_user_id, MU.enroll_no ";

    $data = $dbObj->fetchMultiple($table, $where, $select);
    if($data){
        foreach ($data as $key => $row) {
            $table = "exam_marksheet";
            $where = "exam_user_id = " . $row["exam_user_id"];  
            $select = "*";
            $data[$key]["marksheet"] = $dbObj->fetchMultiple($table, $where, $select);
        }
    }
}
?>


<?php
if($data){      ?>
    <table class="table table-bordered">
        <tr>
            <th> Name </th>
            <th> Enrollment No </th>
            <th> Seat No </th>
            <?php 
            $data_row = $data[0];
            $marksheet = $data_row["marksheet"];
            if($marksheet){
                foreach ($marksheet as $key => $value) {     ?>
                    <th> <?php echo $value["short_code"] . "<br>" . $value["type"]; ?> </th>
            <?php
                }
            }   ?>
            <th> Total marks </th>
            <th> Result </th>
        </tr>
        <?php foreach ($data as $record_key => $row) {     ?>
            <tr>
                <td><?php echo $row['user_name']; ?></td>  
                <td><?php echo $row['enroll_no']; ?></td>
                <td><?php echo $row['seat_no']; ?></td>
                <?php 
                $marksheet = $row["marksheet"];
                if($marksheet){
                    foreach ($marksheet as $key => $value) {     ?>
                        <td> <?php
                        if($value["special_char"]!="*")
                        { echo $value["obtained"] .$value["special_char"];
                        }
                        else
                        echo $value["obtained"]?> </td>
                <?php
                    }
                }   ?>
                <td><?php echo $row['marks_total']; ?></td>
                <td><?php echo $row['result']; ?></td>
            </tr>
        <?php } ?>
    </table>
<?php 
} ?>
<script>
    window.print();
    </script>

<?php require_once("../common/_footer.php");   ?>

