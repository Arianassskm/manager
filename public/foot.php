
<div class="custom-footer">
  <div class="footer-content">
      <a href="index.php">站点首页</a>
      <a data-modal-trigger data-modal-content="#modalContent1" data-modal-title="关于我们">关于我们</a>
      <a data-modal-trigger data-modal-content="#modalContent2" data-modal-title="更新日志">更新日志</a>
      <a data-modal-trigger data-modal-content="#modalContent3" data-modal-title="联系我们">联系我们</a>
  </div>
</div>
<div id="modalContent1" style="display: none;">
  -->实习前的最后一个项目 原本是准备把之前的Api系统翻新一下 但是石山代码实在无从下手<br>
  -->于是就有了这个系统的诞生<br>
  <br>
  ->彻底抛弃layui 改用elementui (主要用来调用element的图标库)<br>
  ->技术栈: php8.2 原生js＋css 部分UI用到element
</div>

<div id="modalContent2" style="display: none;">
  <li>重置第一版: 2025-03-03 23:30:00<br>
    --动态背景图及动态效果 (壁纸本地化) (移动设备横版图片自适应) (壁纸过滤效果)<br>
    --顶部菜单栏 参考B站UP主 莜莱Ceale<br>
    <br>
    <li>2025-03-04 18:30:00</li>
    --新增各种页面的遮盖层 加载窗 可以通过api定义遮盖层效果<br>
    --新增可定义弹窗及弹窗动画 弹窗自适应<br>
    <br>
    <li>2025-03-05 19:00:00</li>
    --新增API分类页面<br>
    --新增友情链接页面<br>
    --优化php代码 优化调试模式错误返回<br>
    --新增优化Api详情页<br>
    --新增Api详情页 简介Ai总结后输出<br>
    <br>
    <li>2025-03-06 23:00:00</li>
    --移植原版后台<br>
    --新增系统安装页面<br>
  </li>
</div>

<div id="modalContent3" style="display: none;">
 <a style="color:rgb(127, 172, 255)" href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=d8jnHF5wFPYkquWol9l-jSmczPRKWXvn&authKey=NjBSkc0bxMU9HsA5MTDLSLFyY4GGo8I7asx%2BJGjaoJKLFw8CNVdiCCAebcPsvFXK&noverify=0&group_code=750957985">
 站长企鹅</a>
 <a style="color:rgb(127, 172, 255)" href="https://qm.qq.com/q/3M1q9licaQ">讨论群组</a>
</div>

<div id="modalContent4" style="display: none;">
    <?php foreach ($classes as $class): ?> 
        <a class="" style="font-size: 15px; color: black; display: block;" href="classify.php?id=<?php echo $class['id']; ?>"><?php echo htmlspecialchars($class['name']); ?></a><br> 
    <?php endforeach; ?>
</div>

<div id="modalContent5" style="display: none;"> 
今日调用数：<?php echo $todayCount; ?><br> 
昨日调用数：<?php echo $yesterdayCount; ?><br> 
接口总调用数：<?php echo $apiCounterSum; ?><br>
<br>
分类总数: <?php echo $fenleishuliang; ?><br>
接口总数: <?php echo $apizongshu; ?><br>
站点总用户: <?php echo $用户总数; ?><br>
系统访问量: <?php echo $visits;; ?><br>
<br>
<?php
$php_version = phpversion();
echo "PHP版本: " . $php_version . "<br>";
$nginx_version = shell_exec('nginx -v 2>&1');
if ($nginx_version) {
    echo "Nginx版本: " . $nginx_version . "<br>";
}
$current_time = date('Y-m-d H:i:s');
echo "当前时间: " . $current_time . "<br>";
?>
<br>
<a style="color: black" href="https://gitee.com/ban-qu/hanzi-api/tree/master/">戳我前往获取新模板的开源地址</a>
</div>


<div id="modalContent6" style="display: none;"> 
<a style="color: black" href="http://box.lovestory.wiki/%E6%89%AB%E5%9C%B0%E9%9B%B7/">扫地雷--经典的Windows扫雷游戏</a><br>
<br>
<a style="color: black" href="http://box.lovestory.wiki/%E4%BA%95%E5%AD%97%E6%A3%8B/">井字棋--九宫格井字棋游戏</a><br>
<br>
<a style="color: black" href="http://box.lovestory.wiki/%E7%9B%B8%E5%86%8C/">相册--Api网站背景图片 (15张)</a><br>
<br>
<div>以上网站都可以通过调试平台获取源码 如果可以请说明源码出处...<div>
</div>


<div id="modalContent7" style="display: none;"> 
友情链接页面重置中... 请过段时间再来访问 原本的友链都会保留 所以请勿将本站的友链删除!
</div>