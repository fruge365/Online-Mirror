<?php
error_reporting(0);
$base64_img = trim($_POST['img']);
$id = trim($_GET['id']);
$url = trim($_GET['url']);
$up_dir = './img/';//存放在当前目录的img文件夹下

if(empty($id) || empty($url) || empty($base64_img)){
    exit;
}

if(!file_exists($up_dir)){
  mkdir($up_dir,0777);
}

if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
  $type = $result[2];
  if(in_array($type,array('bmp','png'))){
    $new_file = $up_dir.$id.'_'.date('mdHis_').'.'.$type;
    file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)));
    header("Location: ".$url);
  }
}
?>