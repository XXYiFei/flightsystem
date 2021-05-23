<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="query.css">
    <title>票务查询</title>
</head>

<body>
    <div class="querybox">
        <form action="query.php" method="POST">
            <div class="hangbanhao">
                航班号：
                <input type="text" name="f_id" id="" value=>
                <input class="querybutton" type="submit" value="查询" name="query"><br>
            </div>
            日期：
            <input type="text" name="year" id="">年
            <input type="text" name="month" id="">月
            <input type="text" name="day" id="">日<br>
            
        </form>
        
    </div>
    <button class="returnbutton" onclick="window.location.href = 'main.html'">返回</button>

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

    $f_id=$_POST["f_id"];
    $year=$_POST["year"];
    $month=$_POST["month"];
    $day=$_POST["day"];
    if(!empty($_POST['query'])){                //查询
        querydb($db,$f_id,$year,$month,$day);
    }else{
        showdb($db);
    }
    mysqli_close($db);

        
?>
<?php
function querydb($db,$f_id,$year,$month,$day){       //查询数据并显示
    if ($f_id&&$year&&$month&&$day) {
        $date=$year.'-'.$month.'-'.$day;
        $query="select * from flight where f_id='$f_id' && f_date='$date'";
        $result=mysqli_query($db, $query);
        if (!$result) {
            print 'error';
        }
        echo '<div class="flighttable" >';
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
            echo '<td></td>';
            echo '</tr>';
        }
    echo '</table>';
    echo '</div>';
    } else {
        echo "<script>
                alert('信息填写不完整');
            </script>";
        showdb($db);
    }
}

function showdb($db){                                //显示数据
    $query='select * from flight';
    $result=mysqli_query($db, $query);
    if (!$result) {
        print 'error';
    }
    echo '<div class="flighttable">';
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
?>