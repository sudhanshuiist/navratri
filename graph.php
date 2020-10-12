<?php

if(isset($_POST['imageData'])){
    $imageData = $_POST['imageData'];
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageName = time().mt_rand(100000,999999);
    if(file_put_contents("user-results/".$imageName.".png",base64_decode($imageData))){
        $shareUrl = "https://www.facebook.com/sharer/sharer.php?app_id=826539421486313&display=page&u=https://".$_SERVER['HTTP_HOST']."/graph/".$imageName."&hashtag=%23miamarpooja";
        print(json_encode(array("status"=>"200","url"=>$shareUrl)));
    }else{
        print(json_encode(array("status"=>"201")));
    }
}
if(isset($_GET['userid']) && is_numeric($_GET['userid'])){

$userid = $_GET['userid'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="<?php print('https://'.$_SERVER['HTTP_HOST'].'/graph/'.$userid); ?>" />
    <meta property="og:type" content="article" />
    <meta property="fb:app_id" content="826539421486313"/>    
    <meta property="og:title" content="Hide & Seek with Ganesha" />
    <meta property="og:description" content="Play now to win exciting goodies from Xiaomi!!" />
    <meta property="og:image" content="<?php print('https://'.$_SERVER['HTTP_HOST'].'/user-results/'.$userid.".png"); ?>" />
    <meta property="og:image:width" content="600"/>
    <meta property="og:image:height" content="450"/>
    <title>Capture your image</title>
    <script>
        function switchpage(){
            window.location.replace("<?php print('https://'.$_SERVER['HTTP_HOST'].'/win.html')?>");
        }
    </script>
</head>
<body onload="switchpage();">    
</body>
</html>

<?php
}
?>
