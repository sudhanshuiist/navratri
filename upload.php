<?php

$message = null;

if(isset($_POST['submit']) && isset($_FILES['video'])){
    define('UPLOAD_FOLDER','user-results/');

    $filesAllowedToUpload = array('webm','mp4');

    $fileExtention = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);

    $saveOnServerAs = time().'.'.$fileExtention;

    if(in_array($fileExtention ,$filesAllowedToUpload)){

        if(move_uploaded_file($_FILES['video']['tmp_name'], UPLOAD_FOLDER.$saveOnServerAs)){

            $uploadOk = 'Congratulation!!, You entry has been recived. <a href="'.UPLOAD_FOLDER.$saveOnServerAs.'">Click here to view your file</a>';
        }else{
            $message = 'Failed to upload file';
        }
    }else{
        $message = 'Kindly upload the unedited file that you download from our server';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="font-family:Calibri,Trebuchet,Arial,sans serif;">
    <?php
        if(!is_null($message)){
            print('<div style="padding:10px; font-size:14px;color:#721c24;background-color:#f8d7da;border-color:#f5c6cb; margin-bottom:10px; border-radius:5px;">'.$message.'</div>');
        }
        if(isset($uploadOk)){
            print('<div style="padding:10px; font-size:14px;color:#155724;background-color:#d4edda;border-color:#c3e6cb; margin-bottom:10px; border-radius:5px;">'.$uploadOk.'</div>');
        }
    ?>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="video" placeholder="Select Video">
        <input type="submit" value="Upload Video" name="submit">
    </form>
</body>
</html>