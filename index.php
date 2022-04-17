<?php
    session_start();
    ini_set('display_errors',1);
    define('MAX_FILE_SIZE',1*1024*1024); //1MB
    define('THUMBNAIL_WIDTH',400);
    define('IMAGES_DIR',__DIR__ .'/images');
    define('THUMBNAIL_DIR', __DIR__ . '/thumbs');

    if(!function_exists('imagecreatetruecolor')){
        echo 'GD not installed';
        exit;
    }
    function h($s){
        return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
    }
    require 'imageUploader.php';

    $uploader =new \MyApp\ImageUploader();

    if($_SERVER['REQUEST_METHOD']==='POST'){
     $uploader->upload();
    }

    list($success, $error)=$uploader->getResults();

    $images = $uploader->getImages();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Uploader</title>
    <style>
        body{
            text-align:center;
            font-family: Arial, sans-serif;
        }
        ul{
            list-style: none;
            margin: 0;
            padding:0;
        }
        li{
            margin-bottom:5px;
        }
        input[type=file]{
            position: absolute;
            top: 0;
            left: 0;
            width:100%;
            height:100%;
            cursor:pointer;
            opacity:0;
        }
        .btn{
            position:relative;
            display:inline-block;
            width:300px;
            padding: 7px;
            border-radius:5px;
            margin:10px auto 20px;
            color:#fff;
            box-shadow:0 4px #0088cc;
            background:#00aaff;
        }
        .btn:hover{
            opacity: 0.8;
        }
    </style>

</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
        <input type="file" name="image">
        <input type="submit" value="upload">
    </form>
    <?php if (isset($success)) : ?>
        <div class ="msg success"><?php echo h($success); ?></div>
        <?php endif; ?>

    <?php if (isset($error)) : ?>
        <div class ="msg error"><?php echo h($success); ?></div>
        <?php endif; ?>

        <ul>
            <?php foreach ($images as $image) : ?>
               <li>
                   <a href="<?php echo h(basename(IMAGES_DIR)) . '/' . basename($image); ?>">
                   <img src="<?php echo h($image); ?>">
               </a>
               </li> 
            <?php endforeach; ?>
        </ul>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(function(){
                $('.msg').fadeOut(3000);
            });
        </script>
</body>
</html>