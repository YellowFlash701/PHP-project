<?php    

$dataString = $_POST["data"];

$data = json_decode($dataString, true);
$record = $data[0];
list($college_code, $college_name) = explode(" - ", $record["college"]);
list($exam_type, $exam_year) = explode(" ", $record["exam"]);

$file_path = "../data/";
$file_name = strtolower($college_code . '__' . $exam_type . '__' . $exam_year . ".json");
$file = $file_path . $file_name;

$existing = file_get_contents($file); 
$existing = json_decode($existing, true);
if($existing && $data){
    $dataString = '';
    foreach ($data as $key => $value) {
        array_push($existing, $value);
    }
    $dataString = json_encode($existing);
}

$result = file_put_contents($file, $dataString);   

echo json_encode([
    "status" => ($result) ? true : false,
    "result" => ($result),
    "file" => $file,
]);

?>