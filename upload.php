<?php

require('config.php');

if(isset($_COOKIE['raw'])){
    $uploadCheckKey = sanitise($_COOKIE['raw']);
    $uploadCheckSQL = "SELECT * FROM contest_entry WHERE uploadkey = '$uploadCheckKey'";
    if(mysqli_num_rows(mysqli_query($connection, $uploadCheckSQL)) > 0){
        header("Location:result.php");
        die();
    }
}

define('UPLOAD_FOLDER','user-results/');
$message = null;
$uniqueId = str_replace('.','-', uniqid(mt_rand(1000000,9999999).'-',true));
$allow = array('webm','mp4');
if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_FILES['video']) && !empty($_FILES['video']['name'])){
    $name = sanitise($_POST['name']);
    $email = sanitise($_POST['email']);
    if(isset($_POST['phone'])){
        $phone = sanitise($_POST['phone']);
    }else{
        $phone = null;
    }
    $videoExtension = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
    if(in_array($videoExtension, $allow)){
        $videoName = $uniqueId."-".md5($email).'.'.$videoExtension;
        if(move_uploaded_file($_FILES['video']['tmp_name'], UPLOAD_FOLDER.$videoName)){
            $SQL = "INSERT INTO contest_entry(`name`, `email`, `phone`, `uploadkey`, `video`)VALUES('$name','$email','$phone','$uniqueId','$videoName')";
            if(mysqli_query($connection, $SQL)){
                setcookie("raw", $uniqueId, time() + (60*60*24*365), "/");
                header("Location:result.php");
            }else{
                $message = 'Opps!! Something went wrong, we were unable to receive your entry , Please try again in some time';
                unlink(UPLOAD_FOLDER.$videoName);
            }
            print(mysqli_error($connection));
        }else{
            $message = 'Opps!! Something went wrong, we were unable to upload your video, Please try again in some time';
        }
    }else{
        $message = 'Kindly upload the unedited file that you download from challenge page';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
</head>
<body style="font-family:Calibri,Trebuchet,Arial,sans serif;">
    <?php
        if(!is_null($message)){
            print('<div style="padding:10px; font-size:14px;color:#721c24;background-color:#f8d7da;border-color:#f5c6cb; margin-bottom:10px; border-radius:5px;">'.$message.'</div>');
        }
    ?>
    <form method="post" enctype="multipart/form-data">
        Name: <input type="text" name="name" placeholder="Name" required><br><br>
        Email: <input type="email" name="email" placeholder="Your email" required><br><br>
        Phone: <input type="number" name="phone" placeholder="Your Phone"><br><br>
        Video: <input type="file" name="video" placeholder="Your Video" required><br><br>
        <input type="submit" value="Upload Video" name="upload">
    </form>
</body>
</html>