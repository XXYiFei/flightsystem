<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>管理员登录</title>
</head>

<body>
    <div class="box">
        <h2>管理员登录</h2>
        <form action="login.php" method="POST">
            <div class="inputBox">
                <input type="text" name="name">
                <label for="">账号：</label>
            </div>
            <div class="inputBox">
                <input type="password" name="password">
                <label for="">密码：</label>
            </div>
            <input type="submit" value="登录" name="login">
            
        </form>
        <button onclick="window.location.href = 'main.html'">返回</button>
    </div>


</body>

</html>


<?php
    $db=mysqli_connect('localhost', 'root', '', 'flightsys');
    if (!$db) {
        die('Could not connect: ' . mysqli_error());
    }
?>
<?php
    error_reporting(0);
    $name = $_POST['name'];//获得用户名
    $passowrd = $_POST['password'];//获得用户密码
    if(!empty($_POST['login'])){                //
       if ($name && $passowrd){//如果用户名和密码都不为空
        $query = "select * from manager where admin_id = '$name' and admin_pass='$passowrd'";//查询管理员列表
  
        $result=mysqli_query($db,$query);    //执行语句
        $rows=mysqli_fetch_assoc($result);   //返回一个数值
        if($rows){                           
           header("refresh:0;url=manage.php");//如果成功跳转至manage.php页面
           exit;
        }else{
            echo "<script>
                    alert('用户名或密码错误！');
                </script>";
        }
        }else{                      //如果用户名或密码有空
            echo "<script>
                    alert('用户名或密码为空！');
                </script>";
        } 
    }
    
    mysqli_close($db);
?>