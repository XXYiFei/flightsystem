<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="manage.css">
    <title>Document</title>
</head>
<body>
    <!--连接数据库-->
    <?php
        $db=mysqli_connect('localhost', 'root', '', 'flightsys');
        if (!$db) {
            die('Could not connect: ' . mysqli_error());
        }
    ?>
    <div class="nav">
        <button class="nav-button1" onclick="showmanage()">查询航班</button>  
        <button class="nav-button2" onclick="showadd()">添加/修改航班</button>
        <button class="nav-button3" onclick="window.location.href = 'main.html'">主页</button>
    </div>
    
    
    <!--切换页面-->
    <script>
        function showadd(){
		    var add= document.getElementById("add");
            var manage= document.getElementById("manage");
            var tb= document.getElementById("flighttb");
            var ftb= document.getElementById("flighttable");
 		    add.style.display="block";
            manage.style.display="none";
            tb.style.display="none";
            ftb.style.display="none";
        }
        function showmanage(){
		    var add= document.getElementById("add");
            var manage= document.getElementById("manage");
            var tb= document.getElementById("flighttb");
            var ftb= document.getElementById("flighttable");
 		    add.style.display="none";
            manage.style.display="block";
            tb.style.display="block";
            ftb.style.display="block";
        }
    </script>

    <!--添加/修改页面-->
    <div class="addpage" id="add" style="display:none">           
        <form action="manage.php" method="POST">
            <label>航班号：</label>
            <input type="text" name="f_id" id="" value=><br>
            <label>起点：</label>
            <input type="text" name="src" id="" value=><br>
            <label>终点：</label>
            <input type="text" name="des" id="" value=><br>
            <label> 日期：</label>
            <input class="dateinput" type="text" name="year" id="">年
            <input class="dateinput" type="text" name="month" id="">月
            <input class="dateinput" type="text" name="day" id="">日<br>
            <label>起飞时刻：</label>
            <input type="text" name="start_time" id="" value=><br>
            <label>到达时刻：</label>
            <input type="text" name="end_time" id="" value=><br>
            <label>剩余座位：</label>
            <input type="text" name="remain_seats" id="" value=><br>
            <label>票价：</label>
            <input type="text" name="fares" id="" value=><br>
            <label>折扣票数：</label>
            <input type="text" name="discount_nums" id="" value=><br>
            <label>折扣率：</label>
            <input type="text" name="discount" id="" value=><br>
            <label>航班所属航空公司：</label>
            <input type="text" name="company" id="" value=><br>
            <input class="subbutton" type="submit" value="添加" name="add">
            <input class="subbutton" type="submit" value="修改" name="updata">

        </form>
    </div>

    <!--查询页面-->
    <div id="manage" style="">
        <form class="queryform" action="manage.php" method="POST"> 
            <div class="fid">
                航班号：
                <input type="text" name="f_id" id="" value=>
                起点：
                <input type="text" name="f_src" id="" value=>
                终点:
                <input type="text" name="f_des" id="" value=>
                <input class="querybutton" type="submit" value="查询" name="query">
            </div>
            
            日期：
            <input type="text" name="year" id="">年
            <input type="text" name="month" id="">月
            <input type="text" name="day" id="">日
            
            <input class="deletebutton" type="submit" value="删除" name="delete">
            

        </form>
        <div class="flighttb" id="flighttb">
        <table align="center">
            <colgroup>
                <col width="70">
                <col width="80">
                <col width="80">
                <col width="140">
                <col width="75">
                <col width="75">
                <col width="100">
                <col width="80">
                <col width="80">
                <col width="80">
                <col width="200">
                <col width="17">
            </colgroup>
            <tr>
                <th>航班号</th>
                <th>起点</th>
                <th>终点</th>
                <th>日期</th>
                <th>起飞时刻</th>
                <th>到达时刻</th>
                <th>剩余座位数</th>
                <th>票价</th>
                <th>折扣票数</th>
                <th>折扣率</th>
                <th>航班所属航空公司</th>
                <th></th>
            </tr>
        </table>
        </div>
    </div>    
</body>
</html>
<?php
    error_reporting(0);

    //获取参数
    $f_id=$_POST["f_id"];
    $src=$_POST["src"];
    $des=$_POST["des"];
    $year=$_POST["year"];
    $month=$_POST["month"];
    $day=$_POST["day"];
    $start_time=$_POST["start_time"];
    $end_time=$_POST["end_time"];
    $remain_seats=$_POST["remain_seats"];
    $fares=$_POST["fares"];
    $discount_nums=$_POST["discount_nums"];
    $discount=$_POST["discount"];
    $company=$_POST["company"];
    $f_src=$_POST["f_src"];
    $f_des=$_POST["f_des"];

    //处理请求
    if (!empty($_POST['query'])) {                //查询
        querydb($db,$f_id,$year,$month,$day,$f_src,$f_des);
    } elseif (!empty($_POST['delete'])) {          //删除
        deletdata($db, $f_id);
        showdb($db);
    } elseif (!empty($_POST['add'])) {             //添加
        add(
            $db,
            $f_id,
            $src,
            $des,
            $year,
            $month,
            $day,
            $start_time,
            $end_time,
            $remain_seats,
            $fares,
            $discount_nums,
            $discount,
            $company
        );
        showdb($db);
    } elseif (!empty($_POST['updata'])) {           //修改
        updata(
            $db,
            $f_id,
            $src,
            $des,
            $year,
            $month,
            $day,
            $start_time,
            $end_time,
            $remain_seats,
            $fares,
            $discount_nums,
            $discount,
            $company
        );
        showdb($db);
    } else {
        showdb($db);
    }

    mysqli_close($db);            //关闭数据库
?>
<?php
function showdb($db)
{                                //显示数据
    $query='select * from flight';
    $result=mysqli_query($db, $query);
    if (!$result) {
        print 'error';
    }
    echo '<div class="flighttable" id="flighttable">';
    echo '<table align="center" style="border-top: 0;">';
    echo '<colgroup>
        <col width="70">
        <col width="80">
        <col width="80">
        <col width="140">
        <col width="75">
        <col width="75">
        <col width="100">
        <col width="80">
        <col width="80">
        <col width="80">
        <col width="200">
        <col width="17">
        </colgroup>';
    while ($row=mysqli_fetch_assoc($result)) {
        echo '<tr align="center">';
        foreach ($row as $data) {
            echo "<td>{$data}</td>";
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
}

function querydb($db,$f_id,$year,$month,$day,$src,$des){       //查询数据并显示
    if(!$f_id){
        $f_id='%';
    }
    if(!$year){
        $year='%';
    }
    if(!$month){
        $month='%';
    }
    if(!$day){
        $day='%';
    }
    if(!$f_src){
        $f_src='%';
    }
    if(!$f_des){
        $f_des='%';
    }
    $date=$year.'-'.$month.'-'.$day;
    $query="SELECT * from flight where f_id LIKE '$f_id' AND f_date LIKE '$date' AND f_src LIKE '$f_src' AND f_des LIKE '$f_des'";
    $result=mysqli_query($db, $query);
    if (!$result) {
        print 'error';
    }
    echo '<div class="flighttable" id="flighttable">';
    echo '<table align="center" style="border-top: 0;">';
    echo '<colgroup>
        <col width="70">
        <col width="80">
        <col width="80">
        <col width="140">
        <col width="75">
        <col width="75">
        <col width="100">
        <col width="80">
        <col width="80">
        <col width="80">
        <col width="200">
        <col width="17">
        </colgroup>';
    while ($row=mysqli_fetch_assoc($result)) {
        echo '<tr align="center">';
        foreach ($row as $data) {
            echo "<td>{$data}</td>";
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
}

function deletdata($db, $f_id){                       //删除数据
    $query="select * from flight where f_id='$f_id'";
    $result=mysqli_query($db, $query);
    if (!$row=mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('删除失败：输入信息有误或航班不存在。');
            </script>";
    } else {
        $delete="delete from flight where f_id='$f_id'";
        mysqli_query($db, $delete);
        echo "<script>
                alert('删除成功！');
            </script>";
    }
}

function add(//添加数据
    $db,
    $f_id,
    $src,
    $des,
    $year,
    $month,       
    $day,
    $start_time,
    $end_time,
    $remain_seats,
    $fares,
    $discount_nums,
    $discount,
    $company
)
{
    if ($f_id&&$src&&$des&&$year&&$month&&
        $day&&$start_time&&$end_time&&$remain_seats&&
        $fares&&$discount_nums&&$discount&&$company) {    //若信息填写完整
        
        $date=$year.'-'.$month.'-'.$day;
        $query="SELECT * FROM flight WHERE f_id='$f_id';"; //查询航班f_id是否存在
        $result=mysqli_query($db, $query);
        if ($row=mysqli_fetch_assoc($result)) {         //若已存在则提示“已存在”
            echo "<script>
                        alert('航班已存在！');
                    </script>";
        } else {                                      //若不存在则添加
            $insert="INSERT INTO flight VALUES('$f_id','$src','$des',
                        '$date','$start_time','$end_time','$remain_seats',
                        '$fares','$discount_nums','$discount','$company');";
            mysqli_query($db, $insert);
            echo "<script>
                        alert('添加成功');
                    </script>";
        }
    } else {                                         //信息填写不完整
        echo $f_id,$src,$des,$year,$month,$day,$start_time,$end_time,$remain_seats,$fares,$discount_nums,$discount,$company;
        echo "<script>
                alert('信息填写不完整');
            </script>";
    }
}

function updata(
    $db,
    $f_id,
    $src,
    $des,
    $year,
    $month,    //修改数据
                $day,
    $start_time,
    $end_time,
    $remain_seats,
    $fares,
    $discount_nums,
    $discount,
    $company
)
{
    if ($f_id&&$src&&$des&&$year&&$month&&
        $day&&$start_time&&$end_time&&$remain_seats&&
        $fares&&$discount_nums&&$discount&&$company) {    //若信息填写完整
        
        $date=$year.'-'.$month.'-'.$day;
        $query="SELECT * FROM flight WHERE f_id='$f_id';"; //查询航班f_id是否存在
        $result=mysqli_query($db, $query);
        if (!$row=mysqli_fetch_assoc($result)) {         //若不存在则提示“不存在”
            echo "<script>
                        alert('航班不存在！');
                    </script>";
        } else {                                      //若存在则修改
            $updata="UPDATE flight SET f_src='$src',f_des='$des',
                        f_date='$date',f_start_time='$start_time',
                        f_end_time='$end_time',f_remain_seats='$remain_seats',
                        f_fares='$fares',f_discount_nums='$discount_nums',
                        f_discount='$discount',f_subordinate_company='$company' 
                        WHERE f_id='$f_id';";
            echo $updata;
            mysqli_query($db, $updata);
            echo "<script>
                        alert('修改成功');
                    </script>";
        }
    } else {                                         //信息填写不完整
        echo "<script>
                alert('信息填写不完整');
            </script>";
    }
}
?>