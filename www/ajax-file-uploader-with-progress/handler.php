<?php
require_once(__DIR__.'\lib\\UploadException.php');
$uploaddir = __DIR__.'\files\\';
$nameFile = 'my_file';

if(isset($_FILES[$nameFile]) && isset($_GET['processed'])) {
	$uploadfile = $uploaddir . basename($_FILES[$nameFile]['name']);
	if(move_uploaded_file($_FILES[$nameFile]['tmp_name'], $uploadfile) && $_FILES[$nameFile]['error'] === UPLOAD_ERR_OK) {
		$status = 'успешно';
	} else {
		$exception = new UploadException($_FILES[$nameFile]['error']); 
		$status = $exception->getMessage();
	}	
} else {
	$status = 'превышен максимально допустимый размер файла';
}

echo $status;