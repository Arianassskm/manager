<script>function convertTime(){var timeUnit=document.getElementById('timeUnit').value;var duration=document.getElementById('duration').value;var returnUnit=document.getElementById('returnUnit').value;var url='api/time.php?timeUnit='+encodeURIComponent(timeUnit)+'&duration='+encodeURIComponent(duration)+'&returnUnit='+encodeURIComponent(returnUnit);var xhr=new XMLHttpRequest();xhr.open('GET',url,true);xhr.onreadystatechange=function(){if(xhr.readyState==4&&xhr.status==200){var response=JSON.parse(xhr.responseText);if(response.error){document.getElementById('result').textContent='错误: '+response.error}else{document.getElementById('result').textContent='转换结果：'+response.result}}};xhr.send()}</script>



<script type="text/javascript" src="https://api.lovestory.wiki/hanzi/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="httpss://api.lovestory.wiki/hanzi/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://api.lovestory.wiki/hanzi/assets/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="https://api.lovestory.wiki/hanzi/assets/js/main.min.js"></script>
<script type="text/javascript" src="https://api.lovestory.wiki/hanzi/assets/js/Chart.js"></script>
</body>
</html>