<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>票务查询</title>
</head>

<body>
    <form action="query.php" method="POST">
        航班号：
        <input type="text" name="f_id" id="" value=><br>
        日期：
        <input type="text" name="year" id="">年
        <input type="text" name="month" id="">月
        <input type="text" name="day" id="">日<br>
        <input type="submit" value="查询">
    </form>
    <button onclick="window.location.href = 'login.html'">返回</button>
    <?php
        $db=mysqli_connect('localhost', 'root', '', 'flightsys');
        if (!$db) {
            die('Could not connect: ' . mysqli_error());
        }
    ?>
    <?php
        error_reporting(0);

        $f_id=$_POST["f_id"];
        $year=$_POST["year"];
        $month=$_POST["month"];
        $day=$_POST["day"];
        if($f_id&&$year&&$month&&$day){
            $date=$year.'-'.$month.'-'.$day;
            $query="select * from flight where f_id='$f_id' && f_date='$date'";
        }else{
            $query='select * from flight';
            //if(isset($_POST["submit"])){
            //    echo "<script>alert('信息填写不完整！');</script>";
            //}   
        }
        
        $result=mysqli_query($db,$query); 
        if(!$result) print 'error'; 

        echo '<table align="center" border="2" width="800">';
        echo '<caption><h3>航班信息</h3></caption>';
        echo '<tr>';
        echo '<th>航班号</th><th>起点</th><th>终点</th><th>日期</th>
              <th>起飞时刻</th><th>到达时刻</th><th>剩余座位数</th><th>票价</th>
              <th>折扣票数</th><th>折扣率</th><th>航班所属航空公司</th>';
        echo '</tr>';

        while($row=mysqli_fetch_assoc($result)){
            echo '<tr align="center">';
            foreach($row as $data){
                echo "<td>{$data}</td>";
            }
            echo '</tr>';
        }
        echo '</table>';

        mysqli_close($db); 

         
    ?>
</body>

</html>