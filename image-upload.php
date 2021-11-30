<?php

// Credit: https://medium.com/@kentaguilar/simplest-way-to-upload-a-file-to-aws-s3-via-php-e83a9f54ba77
function upload_image($name) {
  $name_parts = explode('.', $name);
  $file_name = $name_parts[0] . '_' . $_SESSION['UserID'] . '.' . $name_parts[1];
  $temp_file_location = $_FILES['image']['tmp_name'];

  $s3 = new Aws\S3\S3Client([
    'region'  => 'us-east-2',
    'version' => 'latest',
    'credentials' => [
      'key'    => "AKIAS5C45FJX6BLWNBOY",
      'secret' => "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",
    ]
  ]);

  $result = $s3->putObject([
    'Bucket' => 'imageupload22',
    'Key'    => $file_name,
    'SourceFile' => $temp_file_location
  ]);

  return $result['ObjectURL'];
}

?>
