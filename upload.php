<?php
$target_dir = "/home/ngo/store_file/";
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$file = basename($target_file);
$uploadOk = 1;
$out = "";
$command = "clamdscan ".$target_file;
$fileTmpLoc=$_FILES["fileToUpload"]["tmp_name"];
//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//check if file already exists
/*if(file_exists($target_file))
{
	echo "Sorry, file already exists"."<br>";
	$uploadOk = 0;
}*/
//echo "File size: ".filesize($target_dir.$file)."<br>";

//check file size
//if(isset($_FILES['fileToUpload']))
//{
//check if file is selected
if(!$fileTmpLoc){
	 echo "Error! File is not selected or too large";
	//$uploadOk=0;
}else{
//check file size
/*if($_FILES["fileToUpload"]["size"]>1048576){
	echo "Sorry, your file is too large"."<br>";
	$uploadOk = 0;
}*/
//check if $uploadOk is set to 0 by an error
if($uploadOk == 0){
	echo "Your file was not uploaded";
	
}else{
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_file)){
		echo "The file ".basename($target_file)." has been uploaded";
		//check for virus

		echo "<br>"."Scan result: ";
		exec($command,$out);
		//print_r($out);
		$FOUNDpos = strpos($out[0],"FOUND");
		//echo "Virus: ".$FOUNDpos;
		if( $FOUNDpos !=FALSE){
			echo "Virus FOUND"."<br>";
			$flength = strlen($file);
			$name_pos = strpos($out[0],$file);//
			echo "====================================="."<br>";
			echo "File name: ".$file." || ";
			//get virus name
			$virus = substr($out[0],$name_pos+$flength,$FOUNDpos);
			$virus = substr($virus,1,strlen($virus)-6);
			echo "Virus: ".$virus;
		}
		else echo "No virus detected";
		exec("rm ".$target_file);

	}else{ 
		echo "Sorry, there was an error uploading your file";
	}
}
}
//}else echo "No file choosed or your file is too large!";
?>
