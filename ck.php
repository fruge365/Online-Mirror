<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<title>照片查看页面</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    min-height: 100vh;
    justify-content: center;
  }
  .container {
    width: 90%;
    max-width: 600px;
    margin: 15px;
    background-color: #ffffff;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    box-sizing: border-box;
    text-align: center;
  }
  .container img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
    border-radius: 5px;
  }
  a {
    display: inline-block;
    margin: 10px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }
  a:hover {
    background-color: #45a049;
  }
  p {
    line-height: 1.6;
    color: #333;
    margin: 10px 0;
    text-align: left;
  }
  @media (max-width: 480px) {
    .container {
      padding: 15px;
    }
    a {
      font-size: 14px;
      padding: 8px 16px;
    }
  }
</style>
</head>
<body>
<div class="container">
    <?php
    error_reporting(0);
    $type = trim($_GET['type']);
    $page = isset($_GET['page']) ? $_GET['page'] : 0; //从零开始
    $id = trim($_GET['id']);
    $imgnums = 2; //每页显示的图片数
    $path = "img"; //图片保存的目录

    if ($type == "del") {
        echo '<p>确定清空所有照片？</p>';
        echo "<a href='?type=dell&id=$id'>确定</a> <a href='javascript:history.back(-1)'>返回上一页</a>";
        exit;
    } elseif ($type == "dell") {
        //清空照片函数
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            list($filesname, $ext) = explode(".", $file);
            if ($ext == "png" and explode('_', $filesname)[0] == $id) {
                if (!is_dir('./' . $file)) {
                    unlink('./img/' . $file);
                }
            }
        }
        echo '<p>该ID下的所有照片已经清除！</p>';
    }

    $handle = opendir($path);
    $i = 0;
    while (false !== ($file = readdir($handle))) {
        list($filesname, $ext) = explode(".", $file);
        if ($ext == "png" and explode('_', $filesname)[0] == $id) {
            if (!is_dir('./' . $file)) {
                $array[] = $file; //保存图片名称
                ++$i;
            }
        }
    }
    if ($array) {
        rsort($array); //修改日期倒序排序
        echo "<a href='?page=$page&id=$id&type=del'>清空所有照片</a>";
    } else {
        echo "<p>该ID下没有任何照片</p>";
    }
    for ($j = $imgnums * $page; $j < ($imgnums * $page + $imgnums) && $j < $i; ++$j) {
        echo '<div>';
        echo "<img src='" . $path . "/" . $array[$j] . "' alt='照片'><br />";
        echo '</div>';
    }
    $realpage = @ceil($i / $imgnums) - 1;
    $Prepage = $page - 1;
    $Nextpage = $page + 1;
    echo '<div>';
    if ($Prepage < 0) {
        echo "上一页 ";
        echo "<a href='?page=$Nextpage&id=$id'>下一页</a> ";
        echo "<a href='?page=$realpage&id=$id'>末页</a> ";
    } elseif ($Nextpage >= $realpage) {
        echo "<a href='?page=0&id=$id'>首页</a> ";
        echo " <a href='?page=$Prepage&id=$id'>上一页</a> ";
        echo " 下一页";
    } else {
        echo "<a href='?page=0&id=$id'>首页</a> ";
        echo "<a href='?page=$Prepage&id=$id'>上一页</a> ";
        echo "<a href='?page=$Nextpage&id=$id'>下一页</a> ";
        echo "<a href='?page=$realpage&id=$id'>末页</a> ";
    }
    echo '</div>';
    ?>
</div>
</body>
</html>
