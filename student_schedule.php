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
//insert schedule
if(isset($_POST['list_button'])){
  for($i=0 ;$i<count($_POST['ID']) ;$i++){
    if(isset($_POST['c'.$_POST['ID'][$i]])){
      $insertsql="INSERT INTO student_schedule VALUE(
        '00665625',
        '".$_POST['ils'][$i]."',
        '".$_POST['iin'][$i]."',
        '".$_POST['icn'][$i]."',
        '".$_POST['icc'][$i]."',
        '".$_POST['is'][$i]."');";
     //echo $deletesql."<br />";
     if(mysqli_query($conn,$insertsql)){
       echo "編號".$_POST['ID'][$i]." 課程，課程新增成功!<br />";
     }else{
       echo "編號".$_POST['ID'][$i]." 課程，課程新增失敗!<br />";
    }
  }
}
}
//delete schedule
if(isset($_POST['list_button2'])){
  for($j=0 ;$j<count($_POST['ID']) ;$j++){
    if(isset($_POST['c'.$_POST['ID'][$j]])){
      $deletesql="DELETE FROM student_schedule
                   WHERE
                   student_ID='00665625'AND
                   lecture_section='".$_POST['ils'][$j]."';";
     //echo $deletesql."<br />";
      mysqli_query($conn,$deletesql);
    }
  }
}
//印出所有課表
$sql = "SELECT * FROM semester_course WHERE semester";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table class='style1'><tr><th>lecture_section</th> <th>course_name</th> <th>instructor_name</th> <th>course_credit</th> <th>participant_limit</th> <th>current_participant</th><th>semester</th><th>編號</th></tr>";
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
//印出選取課表
$sql = "SELECT * FROM student_schedule WHERE semester";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table class='style2'><tr><th>student_ID</th> <th>lecture_section</th> <th>instructor_name</th> <th>course_name</th> <th>course_credit</th> <th>semester</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["student_ID"]. "</td><td>" . $row["lecture_section"]. "</td><td> " . $row["instructor_name"]. "</td><td> " . $row["course_name"]. "</td><td> " . $row["course_credit"]. "</td><td> " . $row["semester"]. "</td></tr>";
    }
    echo "</table>";
    echo "</br></br></br></br>";
} else {
    echo "0 results";
}
?>

<form action="student_schedule.php" method="post" name="mylist">
  <table>
    <tr>
      <td>lecture_section</td>
      <td>course_name</td>
      <td>instructor_name</td>
      <td>course_credit</td>
      <td>participant_limit</td>
      <td>current_participant</td>
      <td>semester</td>
      <td>編號</td>
      <td>選項</td>
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
     <input type="text" name="ils[]" value="<?php echo $row['lecture_section']; ?>" >
      </td>
      <td>
     <input type="text" name="icn[]" value="<?php echo $row['course_name']; ?>" >
      </td>
      <td>
     <input type="text" name="iin[]" value="<?php echo $row['instructor_name']; ?>" >
      </td>
      <td>
     <input type="text" name="icc[]" value="<?php echo $row['course_credit']; ?>">
      </td>
      <td>
     <input type="text" name="ipl[]" value="<?php echo $row['participant_limit']; ?>" >
      </td>
      <td>
     <input type="text" name="icp[]" value="<?php echo $row['current_participant']; ?>">
      </td>
      <td>
     <input type="text" name="is[]" value="<?php echo $row['semester']; ?>" >
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
     <input name="list_button" type="submit" value="加入">
      </td>
    </tr>
    <tr>
      <td colspan="9">
        <input name="list_button2" type="submit" value="刪除">
      </td>
    </tr>
  </table>
</form>


<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid gray;
}

</style>
</head>
<body>
</html>
<link rel="stylesheet" href="student_schedulecss.css">
