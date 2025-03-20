<?php include 'api/header.php'; ?>
<style>
.layui-container{max-width:1200px}
@media screen and (max-width:768px){
.layui-container{width:95% !important}
}
.layui-table-view{background-color:transparent}
.layui-table{background-color:transparent}
.layui-table th,.layui-table td,.layui-table tr,.layui-table-cell,.layui-btn.layui-btn-danger.layui-btn-xs{
background-color:transparent;color:black
}
.layui-laypage{color:black}
.layui-laypage a,.layui-laypage span{color:black}
.layui-laypage .layui-laypage-curr{background-color:transparent;color:black}
</style>
<main class="lyear-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs page-tabs">
                        <li class="active"> <a href="api-log.php">接口日志</a> </li>
                        <li class="active"> <a href="user-log.php">用户日志</a> </li>
                    </ul>
                    <div style="text-align: center;margin-top: 10px;margin-bottom: 10px">
                        移动设备显示内容有限，如果没有pc设备可以将浏览器ua改成pc或者平板来查看。表格向右滑动可以删除数据库.
                    </div>
                    <div class="layui-container">
                        <div class="layui-row">
                            <div class="layui-col-xs12">
                                <table id="apiCountTable" lay-filter="apiCountTable"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/html" id="operationBar">
    <button class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</button>
</script>
<script>
layui.use(['table', 'layer'], function() {
    var table = layui.table;
    var layer = layui.layer;
    table.render({
        elem: '#apiCountTable',
        url: 'api/user-log.php',
        method: 'post',
        where: {},
        cols: [
            [
                {field: 'id', title: 'ID'},
                {field: 'username', title: '用户名'},
                {field: 'event', title: '操作事件'},
                {field: 'time', title: '操作时间'},
                {title: '操作', toolbar: '#operationBar', width: 150}
            ]
        ],
        page: true,
        limit: 10,
        limits: [10, 30, 50, 100],
        layout: ['count', 'prev', 'page', 'next', 'limit'],
        prev: '<i class="layui-icon">&#xe603;</i>',
        next: '<i class="layui-icon">&#xe602;</i>'
    });
    table.on('tool(apiCountTable)', function(obj) {
        var data = obj.data;
        if (obj.event === 'del') {
            if (confirm('真的要删除？')) {
                obj.del();
                fetch('api/user-log-delete.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'id=' + encodeURIComponent(data.id)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json()
                })
                .then(data => {
                    if (data.code === 0) {
                        layer.msg('删除成功');
                    } else {
                        layer.msg('删除失败: ' + data.msg);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    layer.msg('请求异常');
                });
            }
        }
    });
});
</script>
<?php include 'api/footer.php'; ?>