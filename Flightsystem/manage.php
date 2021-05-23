<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        $db=mysqli_connect('localhost', 'root', '', 'flightsys');
        if (!$db) {
            die('Could not connect: ' . mysqli_error());
        }
    ?>
    
    <button onclick="showmanage()">查询航班</button>  
    <button onclick="showadd()">添加/修改航班</button>
    
    <script>
        function showadd(){
		    var add= document.getElementById("add");
            var manage= document.getElementById("manage");
 		    add.style.display="block";
            manage.style.display="none";
        }
        function showmanage(){
		    var add= document.getElementById("add");
            var manage= document.getElementById("manage");
 		    add.style.display="none";
            manage.style.display="block";
        }
    </script>
    <!--添加/修改页面-->
    <div id="add" style="display:none">           
        <form action="addinfo.php" method="POST">
            航班号：
            <input type="text" name="f_id" id="" value=>
            起点：
            <input type="text" name="src" id="" value=>
            终点：
            <input type="text" name="des" id="" value=><br>
            日期：
            <input type="text" name="year" id="">年
            <input type="text" name="month" id="">月
            <input type="text" name="day" id="">日
            起飞时刻：
            <input type="text" name="start_time" id="" value=>
            到达时刻：
            <input type="text" name="end_time" id="" value=><br>
            剩余座位：
            <input type="text" name="remain_seats" id="" value=><br>
            票价：
            <input type="text" name="fares" id="" value=>
            折扣票数：
            <input type="text" name="discount_nums" id="" value=>
            折扣率：
            <input type="text" name="discount" id="" value=><br>
            航班所属航空公司：
            <input type="text" name="company" id="" value=><br>
            <input type="submit" value="添加/修改">

        </form>
        <?php
            showdb($db);
        ?>
    </div>
    <!--查询页面-->
    <div id="manage" style="">
        <form action="manage.php" method="POST"> 
            航班号：
            <input type="text" name="f_id" id="" value=><br>
            
            日期：
            <input type="text" name="year" id="">年
            <input type="text" name="month" id="">月
            <input type="text" name="day" id="">日
            
            <br><input type="submit" value="查询" name="query">
            <input type="submit" value="删除" name="delete">

        </form>

        <?php
            error_reporting(0);
            $f_id=$_POST["f_id"];
            $year=$_POST["year"];
            $month=$_POST["month"];
            $day=$_POST["day"];
            if(!empty($_POST['query'])){
                if ($f_id&&$year&&$month&&$day) {
                    $date=$year.'-'.$month.'-'.$day;
                    querydb($db,$date,$f_id);
                } else {
                    echo "<script>
                            alert('信息填写不完整');
                        </script>";
                    showdb($db);
                }  
            }elseif(!empty($_POST['delete'])){
                deletdata($db,$f_id);
                showdb($db);
            }else{
                showdb($db);
                
            }
            mysqli_close($db);
        ?>
    <?php
        function showdb($db){       //显示数据
            $query='select * from flight';
            $result=mysqli_query($db, $query);
            if (!$result) {
                print 'error';
            }
            echo '<table align="center" border="2" width="800">';
            echo '<caption><h3>航班信息</h3></caption>';
            echo '<tr>';
            echo '<th>航班号</th><th>起点</th><th>终点</th><th>日期</th>
                <th>起飞时刻</th><th>到达时刻</th><th>剩余座位数</th><th>票价</th>
                <th>折扣票数</th><th>折扣率</th><th>航班所属航空公司</th>';
            echo '</tr>';

            while ($row=mysqli_fetch_assoc($result)) {
                echo '<tr align="center">';
                $values=array_values($row);
                foreach ($row as $data) {
                    echo "<td>{$data}</td>";
                }
                echo '</tr>';
            
            }   
            echo '</table>';
        }

        function querydb($db,$date,$f_id){       //查询数据并显示
            $query="select * from flight where f_id='$f_id' && f_date='$date'";
            $result=mysqli_query($db, $query);
            if (!$result) {
                print 'error';
            }
            echo '<table align="center" border="2" width="800">';
            echo '<caption><h3>航班信息</h3></caption>';
            echo '<tr>';
            echo '<th>航班号</th><th>起点</th><th>终点</th><th>日期</th>
                <th>起飞时刻</th><th>到达时刻</th><th>剩余座位数</th><th>票价</th>
                <th>折扣票数</th><th>折扣率</th><th>航班所属航空公司</th>';
            echo '</tr>';

            if($row=mysqli_fetch_assoc($result)) {
                echo '<tr align="center">';
                foreach ($row as $data) {
                    echo "<td>{$data}</td>";    
                }
                echo '</tr>';
                
            }   
            echo '</table>';
            echo '</form>';
        }

        function deletdata($db,$f_id){   //删除数据
            $query="select * from flight where f_id='$f_id'";
            $result=mysqli_query($db, $query);
            if (!$row=mysqli_fetch_assoc($result)) {
                echo "<script>
                        alert('删除失败：输入信息有误或航班不存在。');
                    </script>";
            }else{
                $delete="delete from flight where f_id='$f_id'";
                mysqli_query($db, $delete);
                echo "<script>
                        alert('删除成功！');
                    </script>";
            }
        }
    ?>
    </div>
     
</body>
</html>