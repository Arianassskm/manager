<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>表情包生成器</title>
<link href="//unpkg.com/layui@2.9.18/dist/css/layui.css" rel="stylesheet">
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
  }
  .container {
    width: 70%;
    max-width: 500px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .image-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
  }

  .image-wrapper {
    position: relative;
  }

  .image-container img {
    width: 50px;
    height: auto;
    border: 1px solid #ddd;
    padding: 5px;
  }

  .image-prefix {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.7);
    padding: 5px;
    font-size: 12px;
    color: #333;
    border-radius: 5px;
    text-align: center;
    pointer-events: none;
  }
</style>
</head>
<body>
<div class="container" style="margin-top: 60px">
 <div class="layui-collapse" style="margin-bottom: 10px">
  <div class="layui-colla-item">
   <div class="layui-colla-title">点我会出现一堆表情包</div>
    <div class="layui-colla-content">
     <div class="image-container">
      <?php
       $images = glob('images/*');
         natsort($images);
        foreach ($images as $image) {
       $filename = basename($image, pathinfo($image, PATHINFO_EXTENSION));
         echo '<div class="image-wrapper">
         <img src="' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($filename) . '">
         <div class="image-prefix">' . htmlspecialchars($filename) . '</div>
         </div>';
       } ?>
      </div>
    </div>
  </div>
</div>
  <form id="imageForm">
    <label for="qq">QQ:</label>
    <input class="layui-input" type="text" id="qq" name="qq" placeholder="请输入你的QQ" required><br><br>
    <label for="numble">图片ID</label>
    <input class="layui-input" type="text" id="numble" name="numble" placeholder="ID可以在上面的图片中查看"><br><br>
    <input class="layui-btn layui-btn-primary layui-border-blue" style="width: 100%" type="button" value="Submit" onclick="submitImageForm()">
  </form>
  <div style="color: #aaaaff;text-align:center">本站api接口:<br><a style="color: #ffaaff;text-align: center" href="http://api.lovestory.wiki/api/moe/?qq=&numble=">http://api.lovestory.wiki/api/moe/?qq=&numble=</a></div>
 <div>
  <div id="resultImageContainer"></div>
 </div>
</div>
<script src="//unpkg.com/layui@2.9.18/dist/layui.js"></script> 






<script>
function submitImageForm() {
  var qq = document.getElementById('qq').value;
  var numble = document.getElementById('numble').value;
  layui.use('layer', function(){
    var index = layui.layer.load(0, {shade: [0.5, '#f5f5f5']});
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?username=2036513862&qq=' + qq + '&numble=' + numble, true);
    xhr.responseType = 'blob';
    xhr.onload = function() {
      if (this.status === 200) {
        var blob = new Blob([this.response], {type: 'image/png'});
        var url = window.URL.createObjectURL(blob);
        layui.layer.close(index);
        layui.use('layer', function(){
          var layer = layui.layer;
          layer.open({
            type: 1,
            title: false,
            closeBtn: 2,
            shade: 0.8,
            area: ['300px', '300px'],
            content: '<img style="width: 300px;height: 300px" src="' + url + '" alt="合成后的图片" />'
          });
        });
        url = null;
      }
    };
    xhr.send();
  });
}
</script>

</body>
</html>