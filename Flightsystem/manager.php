<?php
    $db=mysqli_connect('localhost', 'root', '', 'flightsys');
    if (!$db) {
        die('Could not connect: ' . mysqli_error());
    }
?>
<?php
    
    $name = $_POST['name'];//获得用户名
    $passowrd = $_POST['password'];//获得用户密码

    if ($name && $passowrd){//如果用户名和密码都不为空
        $query = "select * from manager where admin_id = '$name' and admin_pass='$passowrd'";//查询管理员列表
  
        $result=mysqli_query($db,$query);    //执行语句
        $rows=mysqli_fetch_assoc($result);   //返回一个数值
        if($rows){                           
           header("refresh:0;url=manage.php");//如果成功跳转至success.php页面
           exit;
        }else{
         echo "用户名或密码错误";
         echo "<script>
                    setTimeout(function(){window.location.href='manager.html';},1000);
               </script>";     //如果错误 1秒后跳转到登录页面重试;
        }
    }else{                      //如果用户名或密码有空
         echo "表单填写不完整";
         echo "<script>
                setTimeout(function(){window.location.href='manager.html';},1000);
               </script>";       //如果错误 1秒后跳转到登录页面重试;
   }
    mysqli_close($db);
?>