
<?php
$target_dir = "/home/ngo/store_file/";
$target_file = $target_dir.basename($_FILES["file-1"]["name"]);
$command = "echo SCAN ".$target_file." | nc -U /var/run/clamav/clamd.ctl";
$fileTmpLoc = $_FILES["file-1"]["name"];
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
	if(move_uploaded_file($_FILES["file-1"]["tmp_name"],$target_file)){
		$is_uploaded = 1;
		//check for virus
		echo exec("md5 ".$target_file);
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

	// log file
}
?>

<!DOCTYPE html>
<head>
	<title>
		Result
	</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Scan Virus online</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="css/demo.css" />
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<style type="text/css">
		table, th, td {
			border:1px solid black;
			border-collapse: collapse;
		}
	</style>
</head>
<body>
<div id="loader_background">
		<div class="loader"></div>
</div>
<?php if($is_selected==0){ ?>
	<span>Error! File is not selected</span>
	<?php }else{ ?>
	<?php if($is_uploaded==0){ ?>
		 <span>Error! File is not uploaded</span>
		 <?php }else{ ?>
		 	<?php if($virus_detected==0){ ?>
		 		<div class="box">
		 			<h1>No virus found</h1>
		 			<img src="img/ticksign.png">
		 			<a href="up_form.html"><button class="submit-button">Scan again</button></a>
		 		</div>
		 		<?php }else{ ?>
		 		<div class="box">
		 			<h1>Virus found</h1>
		 			<p><strong>File name: </strong><?php echo $file; ?></p>
		 			<p><strong>Virus: </strong><?php echo $virus; ?></p>
		 			<a href="up_form.html"><button class="submit-button">Scan again</button></a>
		 		</div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
</body>
<script type="text/javascript">
	setTimeout(function(){
    	document.getElementById("loader_background").style.display = "none";
	}, 2000);
</script>
</html>
