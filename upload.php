<?php
$target_dir = "/home/ubuntu/store_file/";
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$out = "";
$command = "clamdscan ".$target_file;
//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//check if file already exists
/*if(file_exists($target_file))
{
	echo "Sorry, file already exists"."<br>";
	$uploadOk = 0;
}*/
//check file size
if($_FILES["fileToUpload"]["size"]>1048576){
	echo "Sorry, your file is too large"."<br>";
	$uploadOk = 0;
}
//check if $uploadOk is set to 0 by an error
if($uploadOk == 0){
	echo "Your file was not uploaded";
}else{
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_file)){
		echo "The file ".basename($target_file)." has been uploaded";
		//check for virus

		echo "<br>"."Scan result: ";
		echo passthru($command);
		exec("rm ".$target_file);

	}else{ echo "Sorry, there was an error uploading your file";}
}
?>
