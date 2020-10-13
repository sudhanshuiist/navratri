<?php

require('config.php');

$alreadyUploaded = false;

if(isset($_COOKIE['raw'])){
    $uploadCheckKey = sanitise($_COOKIE['raw']);
    $uploadCheckSQL = "SELECT * FROM contest_entry WHERE uploadkey = '$uploadCheckKey'";
    if(mysqli_num_rows(mysqli_query($connection, $uploadCheckSQL)) > 0){
        $alreadyUploaded = true;
    }
}
if($alreadyUploaded == true){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload Video</title>
    </head>
    <body style="font-family:Calibri,Trebuchet,Arial,sans serif;">
        <div style="padding:10px; font-size:14px; color:#0c5460; background-color:#d1ecf1; border-color:#bee5eb; margin-bottom:10px; border-radius:5px;">
            You have already submitted your entry.
        </div>
    </body>
    </html>

<?php
}else{
    
    define('UPLOAD_FOLDER','user-results/');
    $message = null;
    $uploadStatus = false;
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
                    $uploadStatus = true;
                    setcookie("raw", $uniqueId, time() + (60*60*24*365), "/");
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
    
    foreach($_POST as $postkey=>$postvalue){
        unset($_POST[$postkey]);
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
        if($uploadStatus == true){
            print('<div style="padding:10px; font-size:14px;color:#155724;background-color:#d4edda;border-color:#c3e6cb; margin-bottom:10px; border-radius:5px;">');
            print('Congratulations your entry has been received, Please Come back in few hours to check your result. Thank You &#10084;&#65039;');
            print('</div>');
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
    <?php
}
?>