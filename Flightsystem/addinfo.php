<?php
    $db=mysqli_connect('localhost', 'root', '', 'flightsys');
    if (!$db) {
        die('Could not connect: ' . mysqli_error());
    }
?> 
<?php

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
    
    if ($f_id&&$src&&$des&&$year&&$month&&
        $day&&$start_time&&$end_time&&$remain_seats&&
        $fares&&$discount_nums&&$discount&&$company) {
        $date=$year.'-'.$month.'-'.$day;

        $query="SELECT * FROM flight WHERE f_id='$f_id';";
        $result=mysqli_query($db, $query);
        if($row=mysqli_fetch_assoc($result)){
            $updata="UPDATE flight SET f_src='$src',f_des='$des',
                f_date='$date',f_start_time='$start_time',
                f_end_time='$end_time',f_remain_seats='$remain_seats',
                f_fares='$fares',f_discount_nums='$discount_nums',
                f_discount='$discount',f_subordinate_company='$company' 
                WHERE f_id='$f_id';";
            $result=mysqli_query($db, $updata);
            echo "修改成功！";
            echo "<script>
                    setTimeout(function(){window.location.href='manage.php';},1000);
                </script>";
        }else{
           $insert="INSERT INTO flight VALUES('$f_id','$src','$des',
            '$date','$start_time','$end_time','$remain_seats',
            '$fares','$discount_nums','$discount','$company');";
            $result=mysqli_query($db, $insert);
            echo "添加成功！";
            echo "<script>
                    setTimeout(function(){window.location.href='manage.php';},1000);
                </script>";
        }
    } else {
        echo "信息填写不完整！";
        echo "<script>
                    setTimeout(function(){window.location.href='manage.php';},1000);
               </script>";
    }
?>