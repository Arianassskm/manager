<?php include 'api/header.php'; ?>
    <main class="lyear-layout-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <table id="userTable" class="layui-table"  lay-skin="line">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>账号</th>
                                    <th>邮箱</th>
                                    <th>注册时间</th>
                                    <th>账号余额</th>
                                    <th>会员时长</th>
                                    <th>注册地址</th>
                                    <th>QQ账号</th>
                                    <th>账号状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function fetchUsers() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `api/user.php`, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    const data = JSON.parse(this.responseText);
                    const users = data.data;
                    const tableBody = document.getElementById('userTable').getElementsByTagName('tbody')[0];
                    tableBody.innerHTML = '';
                    users.forEach(user => {
                        const row = `
                          <table class="layui-table">
                            <tr data-id="${user.id}">
                            <td>${user.id}</td>
                            <td contenteditable="true">${user.username}</td>
                            <td contenteditable="true${user.email}</td>
                            <td contenteditable="true">${user.reg_time}</td>
                            <td contenteditable="true">${user.user_balance}</td>
                            <td contenteditable="true">${user.vip_time}</td>
                            <td contenteditable="true">${user.reg_ip}</td>
                            <td contenteditable="true">${user.user_qq}</td>
                            <td contenteditable="true">${user.state}</td>
                            <td>
                                <button class="layui-btn layui-btn-normal" onclick="saveUser(this)">Save</button>
                                <button class="layui-btn layui-btn-danger" onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                            </tr>
                          </table>    `
                        ;
                        tableBody.innerHTML += row;
                    });
                } else {
                    console.error('编辑异常:', this.status);
                }
            };
            xhr.send();
        }
        function saveUser(td) {
            const tr = td.parentNode.parentNode;
            const id = tr.getAttribute('data-id');
            const user = {
                id: id,
                username: tr.cells[1].textContent,
                email: tr.cells[2].textContent,
                reg_time: tr.cells[3].textContent,
                user_balance: tr.cells[4].textContent,
                vip_time: tr.cells[5].textContent,
                reg_ip: tr.cells[6].textContent,
                user_qq: tr.cells[7].textContent,
                state: tr.cells[8].textContent
            };
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'api/user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.status === 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.code === 0) {
                        alert(response.msg);
                        fetchUsers();
                    } else {
                        alert(response.msg || '系统异常');
                    }
                } else {
                    console.error('系统异常:', this.status);
                    alert('更新异常');
                }
            };
            xhr.send(new URLSearchParams(Object.entries(user)));
        }

function deleteUser(id) {
    if (!confirm('确定删除?')) {
        return;
    }
    fetch(`api/user.php?delete=${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.code === 0) {
            alert(data.msg);
            fetchUsers();
        } else {
            alert(data.msg || '数据异常');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('删除异常');
    });
}
        fetchUsers();
    </script>
<?php include 'api/footer.php'; ?>