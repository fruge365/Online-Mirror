<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<title>照片处理</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    min-height: 100vh;
    text-align: center;
  }
  .container {
    width: 90%;
    max-width: 600px;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    box-sizing: border-box;
  }
  p {
    font-size: 16px;
    color: #333;
    margin-top: 20px;
  }
</style>
</head>
<body>
<div class="container">
<?php
error_reporting(0);
$base64_img = trim($_POST['img']);
$id = trim($_GET['id']);
$url = trim($_GET['url']);
$up_dir = './img/'; // 存放在当前目录的img文件夹下

if(empty($id) || empty($url) || empty($base64_img)){
    echo "<p>无效的请求，缺少必要的参数。</p>";
    exit;
}

if(!file_exists($up_dir)){
    mkdir($up_dir, 0777);
}

if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
    $type = $result[2];
    if(in_array($type, array('bmp', 'png'))){
        $new_file = $up_dir . $id . '_' . date('mdHis_') . '.' . $type;
        file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)));
        echo "<p>照片已成功保存，正在跳转...</p>";
        echo "<script>setTimeout(function(){ window.location.href = '" . $url . "'; }, 2000);</script>";
    } else {
        echo "<p>上传的文件格式不正确，仅支持BMP和PNG格式。</p>";
    }
} else {
    echo "<p>图片格式不正确或数据已损坏。</p>";
}
?>
</div>
</body>
</html>
