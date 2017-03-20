
<?php
$target_dir = "/home/ngo/store_file/";
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$command = "echo SCAN ".$target_file." | nc -U /var/run/clamav/clamd.ctl";
$fileTmpLoc=$_FILES["fileToUpload"]["tmp_name"];
$file = basename($target_file);
$flength = strlen($file);
$out = "";
$virus ="";
$virus_detected = 0;
$is_uploaded = 0;
$is_selected = 0;
$uploadOk = 1;
//check if file is selected
if(!$fileTmpLoc){
	 //echo "Error! File is not selected or too large";
	 $is_selected = 0;
	//$uploadOk=0;
}else{
	$is_selected = 1;
	//if file uploaded successfully
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_file)){
		$is_uploaded = 1;
		//check for virus
		exec($command,$out);
		$FOUNDpos = strpos($out[0],"FOUND");
		if( $FOUNDpos != FALSE){
			$virus_detected = 1;
			$name_pos = strpos($out[0],$file);//
			//get virus name
			$virus = substr($out[0],$name_pos+$flength,$FOUNDpos);
			$virus = substr($virus,1,strlen($virus)-6);
		}
		//remmove uploaded file
		exec("rm ".$target_file);
	}
}
?>
<!DOCTYPE html>
<head>
	<title>
		Result
	</title>
	<style type="text/css">
		table, th, td {
			border:1px solid black;
			border-collapse: collapse;
		}
	</style>
</head>
<body>
<?php if($is_selected==0){ ?>
	<span>Error! File is not selected</span>
	<?php }else{ ?>
	<?php if($is_uploaded==0){ ?>
		 <span>Error! File is not uploaded</span>
		 <?php }else{ ?>
		 	<?php if($virus_detected==0){ ?>
		 		<p>No virus found</p><br>
		 		<table style="width: 100%">
					<tr>
						<td>
						File: <?php echo $file; ?>
						</td>
						<td>
						Virus: <?php echo $virus; ?>
						</td>
					</tr>
				</table>
		 		<?php }else{ ?>
				<p>Virus found</p><br>
				<table style="width: 100%">
					<tr>
						<td>
						File: <?php echo $file; ?>
						</td>
						<td>
						Virus: <?php echo $virus; ?>
						</td>
					</tr>
				</table>
				<?php } ?>
			<?php } ?>
		<?php } ?>
</body>
</html>