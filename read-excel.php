<?php
include 'database.php';
require_once "./Classes/PHPExcel.php";
require_once './Classes/PHPExcel/IOFactory.php';
?>
<?php
if (isset($_POST['submit'])) {
	if (isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {
		$allowedExtensions = array("xls", "xlsx", "csv");
		$ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);

		if (in_array($ext, $allowedExtensions)) {
			$file_directory = "./uploads/";
			$file_info = $_FILES["uploadFile"]["name"];
			$new_file_name = date("dmY") . "." . pathinfo($file_info, PATHINFO_EXTENSION);
			move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $file_directory . $new_file_name);

			// 	$file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
			// $objReader	= PHPExcel_IOFactory::createReader($file_type);
			// $objPHPExcel = $objReader->load($file_directory . $new_file_name);
			// $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

			//////////////////// Excel Code ///////////////////

			$path = "./uploads/" . $new_file_name;
			$reader = PHPExcel_IOFactory::createReaderForFile($path);
			$excel_Obj = $reader->load($path);

			//Get the first sheet in excel
			$worksheet = $excel_Obj->getSheet('0');
			$lastRow = $worksheet->getHighestRow();
			$colomncount = $worksheet->getHighestDataColumn();
			$colomncount_number = PHPExcel_Cell::columnIndexFromString($colomncount);

			//  Get worksheet dimensions
			$sheet = $excel_Obj->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$query = 'INSERT INTO login (firstName,lastName,loginId,pswd,save_pwd) VALUES ';
			$query_parts = array();

			function RandomStringMethod($length = 3)
			{
				// $randomCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ=-$&@';
				$randomCharacters = '0123456789';

				$stringLength = strlen($randomCharacters);
				$randomString = '';

				for ($i = 0; $i < $length; $i++) {
					$randomString .= $randomCharacters[rand(0, $stringLength - 1)];
				}

				return $randomString;
			}


			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++) {
				//  Read a row of data into an array
				$rowData = $sheet->rangeToArray(
					'A' . $row . ':' . $highestColumn . $row,
					NULL,
					TRUE,
					FALSE
				);
				// Preparing query data
				$password = RandomStringMethod(3);

				$lnLetter = substr($rowData[0][1], 0, 1);
				$passSave = $rowData[0][0] . '_' . $lnLetter . $password;

				$query_parts[] = "('" . $rowData[0][0] . "', '" . $rowData[0][1] . "','" . $rowData[0][0] . $rowData[0][1] . "','" . md5($passSave) . "','" . $passSave . "')";
			}
			$query .= implode(',', $query_parts);
			if ($conn->multi_query($query) === TRUE) {
				$response = array(
					"status" => "alert-success",
					"message" => "New Judge Added succesfully ."
				);
				header("location: admin-judge.php");
			} else {
				echo "Error: " . $query . "<br>" . $conn->error;
			}

			/////////////////////// Excelcode end //////////////////////

		} else {
			echo '<span class="msg">Please upload excel sheet.</span>';
		}
	} else {
		echo '<span class="msg">Please upload excel file.</span>';
	}
}
?>