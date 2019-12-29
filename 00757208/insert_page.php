<?php
$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "databaseclass";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['list_button'])){
  $sql="INSERT INTO semester_course VALUE('".
    $_POST['ID']."','".
    $_POST['lecture_section']."','".
    $_POST['course_name']."','".
    $_POST['instructor_name']."','".
    $_POST['course_credit']."','".
    $_POST['participant_limit']."','".
    $_POST['current_participant']."','".
    $_POST['semester']."');";

    $query_run=mysqli_query($conn,$sql);

    if($query_run){
      echo '<script language="javascript">';
      echo 'alert("Data Saved")';
      echo '</script>';
    }
    else{
      echo '<script language="javascript">';
      echo 'alert("Data Not Saved")';
      echo '</script>';
    }
}
//delete按鈕判斷
if(isset($_POST['list_button2'])){
  for($i=0 ;$i<count($_POST['ID']) ;$i++){
    if(isset($_POST['c'.$_POST['ID'][$i]])){
      $deletesql="DELETE FROM semester_course
                   WHERE
                   ID=".$_POST['c'.$_POST['ID'][$i]].";";
     //echo $deletesql."<br />";
      mysqli_query($conn,$deletesql);
    }
  }
}
//update按鈕判斷
if(isset($_POST['list_button3'])){
  for($j=0 ;$j<count($_POST['ID']) ;$j++){
    $updatesql="UPDATE semester_course
                SET
                  lecture_section='".$_POST['dls'][$j]."',
                  course_name='".$_POST['dcn'][$j]."',
                  instructor_name='".$_POST['din'][$j]."',
                  course_credit='".$_POST['dcc'][$j]."',
                  participant_limit='".$_POST['dpl'][$j]."',
                  current_participant='".$_POST['dcp'][$j]."',
                  semester='".$_POST['ds'][$j]."',
                  ID='".$_POST['ID'][$j]."'
                WHERE
                  ID='".$_POST['ID'][$j]."';";
         //echo $updatesql."<br />";
    if(mysqli_query($conn,$updatesql)){
      echo "編號".$_POST['ID'][$j]." 資料更新成功!<br />";
    }else{
      echo "編號".$_POST['ID'][$j]." 資料更新失敗!<br />";
    }
   }
}
//印出所有資料的表

$sql = "SELECT * FROM semester_course WHERE semester";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table><tr><th>lecture_section</th> <th>course_name</th> <th>instructor_name</th> <th>course_credit</th> <th>participant_limit</th> <th>current_participant</th><th>semester</th><th>編號</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["lecture_section"]. "</td><td>" . $row["course_name"]. "</td><td> " . $row["instructor_name"]. "</td><td> " . $row["course_credit"]. "</td><td> " . $row["participant_limit"]. "</td><td> " . $row["current_participant"]. "</td><td> "
        . $row["semester"]."</td><td> ". $row["ID"]. "</td></tr>";
    }
    echo "</table>";
    echo "</br></br></br></br>";
} else {
    echo "0 results";
}

?>


<form action="insert_page.php" method="post" name="mylist">
  <table cellspacing=1px>
    <tr>
      <td>lecture_section</td>
      <td>course_name</td>
      <td>instructor_name</td>
      <td>course_credit</td>
      <td>participant_limit</td>
      <td>current_participant</td>
      <td>semester</td>
      <td>編號</td>
    </tr>
    <tr>
      <td><input type="text" name="lecture_section" value=""></td>
      <td><input type="text" name="course_name" value=""></td>
      <td><input type="text" name="instructor_name" value=""></td>
      <td><input type="text" name="course_credit" value=""></td>
      <td><input type="text" name="participant_limit" value=""></td>
      <td><input type="text" name="current_participant" value=""></td>
      <td><input type="text" name="semester" value=""></td>
        <td><input type="text" name="ID" value=""></td>
    </tr>
    <tr>
      <td colspan="8">
        <input name="list_button" type="submit" value="新增">
      </td>
    </tr>
  </table>
</form>

<form action="insert_page.php" method="post" name="mylist">
  <table class="TB_COLLAPSE">
    <tr>
      <td>lecture_section</td>
      <td>course_name</td>
      <td>instructor_name</td>
      <td>course_credit</td>
      <td>participant_limit</td>
      <td>current_participant</td>
      <td>semester</td>
      <td>編號</td>
      <td>刪除</td>
    </tr>
<?php
$sql = "SELECT * FROM semester_course WHERE semester";
$ro=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($ro);
$total=mysqli_num_rows($ro);
  do{
?>
    <tr>
      <td>
     <input type="text" name="dls[]" value="<?php echo $row['lecture_section']; ?>" >
      </td>
      <td>
     <input type="text" name="dcn[]" value="<?php echo $row['course_name']; ?>" >
      </td>
      <td>
     <input type="text" name="din[]" value="<?php echo $row['instructor_name']; ?>" >
      </td>
      <td>
     <input type="text" name="dcc[]" value="<?php echo $row['course_credit']; ?>">
      </td>
      <td>
     <input type="text" name="dpl[]" value="<?php echo $row['participant_limit']; ?>" >
      </td>
      <td>
     <input type="text" name="dcp[]" value="<?php echo $row['current_participant']; ?>">
      </td>
      <td>
     <input type="text" name="ds[]" value="<?php echo $row['semester']; ?>" >
      </td>
      <td>
     <input type="hidden" name="ID[]" value="<?php echo $row['ID']; ?>" >
   </td>

    <td><!--選單按鈕-->
      <input  type="radio" name="c<?php echo $row['ID']; ?>" ID="<?php echo $row['ID']; ?>" value="<?php echo $row['ID']; ?>"/>
    </td>

    </tr>
<?php

    }while($row=mysqli_fetch_assoc($ro));
?>
<tr>
   <td colspan="9">
     <input name="list_button2" type="submit" value="刪除">
      </td>

    </tr>
    <tr>
      <td colspan="9">
        <input name="list_button3" type="submit" value="修改">
      </td>
    </tr>
  </table>
</form>

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}

</style>
</head>
<body>
</html>
<link rel="stylesheet" href="insert_pagecss.css">
