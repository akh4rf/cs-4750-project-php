<?php
	if(isset($_FILES['image'])){
		$file_name = $_FILES['image']['name'];   
		$temp_file_location = $_FILES['image']['tmp_name']; 

		require 'vendor/autoload.php';

		$s3 = new Aws\S3\S3Client([
			'region'  => '-- your region --',
			'version' => 'latest',
			'credentials' => [
				'key'    => "AKIAS5C45FJX6BLWNBOY",
				'secret' => "MYS98SvBWRJ1E5aqjm115ixM/hRy6r33omWj+yP5",
			]
		]);		

		$result = $s3->putObject([
			'Bucket' => 'imageupload22',
			'Key'    => $file_name,
			'SourceFile' => $temp_file_location			
		]);
        echo $result['ObjectURL'] . PHP_EOL;

		var_dump($result);
	}
?>

<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">         
	<input type="file" name="image" />
	<input type="submit"/>
</form>      