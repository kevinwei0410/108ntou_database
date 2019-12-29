<?php
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "project";

$script_file = "assets/js/login.js";

$conn = new mysqli($servername, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$ID = $_POST['form-username'];
$password = $_POST['form-password'];
if ($ID && $password)
{
    $sql1 = "SELECT student_ID,password FROM student_information";
    $result1 = $conn->query($sql1);

    $sql2 = "SELECT teacher_ID,password FROM teacher_information";
    $result2 = $conn->query($sql2);

    $find = false;
    while($row = $result1->fetch_assoc())
    {
        if ($row["student_ID"] == $ID)
        {
            if ($row["password"] == $password)
                echo "<script type='text/javascript' src='assets/js/login.js'> SHOW_STUDENT(".$row["student_ID"]."); </script>";
            else
                echo "<script type='text/javascript'src='assets/js/login.js'> SHOW_ERROR(); </script>";
            $find = true;
            break;
        }
    }
    if ($find == false)
    {
        while($row = $result2->fetch_assoc())
        {
            if ($row["teacher_ID"] == $ID)
            {
                if ($row["password"] == $password)
                    echo "<script type='text/javascript' src='assets/js/login.js'> SHOW_TEACHER(".$row["teacher_ID"]."); </script>";
                else
                    echo "<script type='text/javascript' src='assets/js/login.js'> SHOW_ERROR(); </script>";
                $find = true;
                break;
            }
        }
    }
    if ($find == false)
         echo "<script type='text/javascript' src='assets/js/login.js'> SHOW_ERROR(); </script>";
}
?>