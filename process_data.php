<?php	
	require_once("../includes/database.class.php");
	 
		$dataString = $_POST["data"];                                          //data goes in json format
		$filter_department= $_POST["dept"];
		$filter_year=$_POST["year"];
		$data_list = json_decode($dataString, true);

		$reqNo = $_POST["count"]; 

if($data_list){
	foreach ($data_list as $record) {

		// $record = $data[0];
		$subject_list = $record["subject_list"];
		$row = $record["row_data"];

		$student_data = $record["common_data"];

		$pointer = 0;
		$student_data["seat_no"] = $row[$pointer++];
		$student_data["enroll_no"] = $row[$pointer++];
		$student_data["name"] = $row[$pointer++]; 		
		$student_data["status"] = $row[$pointer++]; 
		$student_data["app_code"] = $row[$pointer++];
		$student_data["cf"] = ($student_data["status"] == "R") ? [] : [ $row[$pointer++], $row[$pointer++] ];
		$student_data["marks"] = [];

		//	echo "<pre>";
		//	print_r($row);
		//	print_r($student_data);
		//	exit;

		for ($i = 0; $i < count($subject_list); $i++) {
			foreach ($subject_list[$i] as $j => $sub) {
				$obtained = (string)$row[$pointer++];

				if( strlen($obtained) == 4 ){
					$sub["obtained"] = substr($obtained, 0, 3);
					$sub["special_char"] = $obtained[3];

				} else {
					$sub["obtained"] = $obtained;
					$sub["special_char"] = "";
				}			

				array_push($student_data["marks"], $sub);
				$student_data["marks_total"] = $row[array_search("Total :", $row) + 1];
				$student_data["result"] = array_slice($row, array_search("Result :", $row) + 1);
			}
		}

		$data = array($student_data);
	

		$marksheet_id_list = [];
		$error_data = [];

		if($data){
			foreach ($data as $record_key => $record) {

				$error_data_row = [];

				
				list($college_code, $college_name) = explode(" - ", $record["college"]);
				list($course_code, $course_name) = explode(" - ", $record["course"]);
				list($semester, $pattern) = explode(" ", $record["semester"]);
				list($exam_type, $exam_year) = explode(" ", $record["exam"]);
				$semester_data = explode(" ", $record["semester"]);
				
				
						$semester = $semester_data[0];
						$pattern = $semester_data[2];
						$start = strpos($pattern, "(");
						$end = strpos($pattern, ")", $start);
						$pattern = substr($pattern, $start + 1, 1);
					



						$college_id = "";
						if($reqNo == 1 ){
							$college_id = $dbObj->insert("master_college", ["code" => $college_code, "name" => $college_name]);
						}
						do {
							$college_data = $dbObj->fetchSingle("master_college", "code = '{$college_code}'");
							if($college_data)
								$college_id = $college_data["id"];
						} while (!$college_id);

						if(!$college_id){
							$error_data_row["record"] = $record;
							$error_data_row["error"] = "College not found..";
							continue;
						}

						$course_id = "";
						if($reqNo == 1 ){
							$course_id = $dbObj->insert("master_course", 
								["college_id" => $college_id, "code" => $course_code, "name" => $course_name]);
						}
						do {
							$course_data = $dbObj->fetchSingle("master_course", "college_id = {$college_id} AND code = '{$course_code}'");
							if($course_data)
								$course_id = $course_data["id"];
						} while (!$course_id);

						if(!$course_id){
							$error_data_row["record"] = $record;
							$error_data_row["error"] = "Course not found..";
							continue;
						}


						$enroll_no = $record["enroll_no"];
						$user_name = $record["name"];

						$user_id = $dbObj->insert("master_user", 
							["course_id" => $course_id, "enroll_no" => $enroll_no, "name" => $user_name]);
						if(!$user_id){
							$error_data_row["record"] = $record;
							$error_data_row["error"] = "User not found..";
							continue;
						}
						
						$exam_details = [];
						$exam_details["college_id"] = $college_id;
						$exam_details["exam_type"] = $exam_type;
						$exam_details["exam_year"] = $exam_year;
						$exam_details["semester"] = $semester;
						$exam_details["pattern"] = $pattern;

						if($reqNo == 1 ){
							$exam_id = $dbObj->insert("exam_details", $exam_details);
						}
						do {
							$where = [];
							foreach ($exam_details as $key => $value) {
								$where[] = "{$key} = '{$value}' ";
							}
							$exam_id = "";
							$strWhere = implode(" AND ", $where);
							$exam_data = $dbObj->fetchSingle("exam_details", $strWhere);
							if($exam_data)
								$exam_id = $exam_data["id"];
						} while (!$exam_id);							
						
						$exam_user = [];
						$exam_user["exam_id"] = $exam_id;
						$exam_user["user_id"] = $user_id;
						$exam_user["seat_no"] = $record["seat_no"];
						$exam_user["status"] = $record["status"];
						$exam_user["app_code"] = $record["app_code"];
						$exam_user["cf"] = implode("___", $record["cf"]);
						$exam_user["marks_total"] = $record["marks_total"];
						$exam_user["result"] = $record["result"][0];
						$exam_user["other"] = implode("___", $record["result"]);
						$exam_user_id = $dbObj->insert("exam_user", $exam_user);
						if(!$exam_user_id){
							$error_data_row["record"] = $record;
							$error_data_row["error"] = "Exam User not found..";				
							continue;
						}

						$dbObj->delete("exam_marksheet", "exam_user_id = " . $exam_user_id);

						$marks = $record["marks"];
						if($marks){
							foreach ($marks as $key => $value) {
								$value["exam_user_id"] = $exam_user_id;
								$marksheet_id = $dbObj->insert("exam_marksheet", $value);					
								if(!$marksheet_id)
									continue;
								$marksheet_id_list[$record_key][] = $marksheet_id;
							}
						}

						if($error_data_row){
							array_push($error_data, $error_data_row);
						}
					
				
			}
		}

	
		echo json_encode([
			"status" => ($marksheet_id_list) ? true : false,
			"result" => json_encode($marksheet_id_list),
			"error_data" => json_encode($error_data),
			"record_data" => $student_data,
		]);

	}
}
?>