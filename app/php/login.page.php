<?php
class php_login
{
    public function LoginCheck()
    {
        $usr = $_POST['usr_raw'];
        $pwd = $_POST['pwd_raw'];
        $db = php_mysql::SQLConnect();
//        print_r($db->selectOne('user',array("username"=>$usr),'password'));
        if (sha1($pwd) == $db->selectOne('user', array("username" => $usr), 'password')['password']) {
            return 1;
        } else {
            return 0;
        }
    }
    public function PageEntry($inPath)
    {
        if (!session_id()) {
            session_start();
        }

        if (isset($_SESSION["islogin"]) && $_SESSION["islogin"]) {
            header("Location: /index");
            exit();
        } else {
            if (isset($_POST['usr_raw']) && isset($_POST['pwd_raw'])) {
                if (self::LoginCheck()) {
                    $_SESSION["islogin"] = true;
                    $_SESSION['username'] = $_POST['usr_raw'];
                    header("Location: /index");
                    exit();
                } else {
                    echo "<script>alert('账号或密码错误！')</script>";
                }
            }
        }
    }

}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>欢迎使用jackson简易销售管理系统</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <style>
    body,
    html {
        width: 100%;
        height: 100%
    }
    </style>
</head>

<body>
    <br>
    <h1 style="text-align:center">Jackson简易销售管理系统</h1>
    <br>
    <br><br><br>
    <div style="width: 300px; align-items: center; margin:0px auto;">
        <form action="#" method="post" name="loginform">
            <div class="form-group">
                <label for="username"><strong>账号：</strong></label>
                <input type="text" class="form-control" id="username_input" name="usr_raw" placeholder="请输入账号">
            </div>
            <div class="form-group">
                <label for="passwd"><strong>密码：</strong></label>
                <input type="password" class="form-control" id="passwd_input" name="pwd_raw" placeholder="请输入密码">
            </div>
            <br>
            <div style="text-align: center"><button type="submit" class="btn btn-primary">登录</button></div>

        </form>
    </div>
    <br><br><br><br><br><br><br>
    <?php include "html/bottom.html";?>
</body>

</html>