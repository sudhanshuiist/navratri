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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Page</title>
</head>
<body>
    <?php
        if($alreadyUploaded == true){
            print('<div style="padding:10px; font-size:14px; color:#155724; background-color:#d4edda; border-color:#c3e6cb; margin-bottom:10px; border-radius:5px;">');
            print('Congratulations your entry has been received, Please Come back in few hours to check your result. Thank You &#10084;&#65039;');
            print('</div>');
        }else{
            print('<div style="padding:10px; font-size:14px; color:#856404; background-color:#fff3cd; border-color:#ffeeba; margin-bottom:10px; border-radius:5px;">');
            print('Looks like you have not submitted a video yet, <a href="upload.php">Click here</a> to submit your entry');
            print('</div>');
        }
    ?>
</body>
</html>

