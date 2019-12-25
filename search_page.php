<?php

//include "db_conn.php";
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
$a=0;
if($a==1){
$sql2 = "SELECT * FROM semester_course WHERE current_participant<participant_limit";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    echo "<table><tr><th>lecture_section</th> <th>course_name</th> <th>instructor_name</th> <th>course_credit</th> <th>participant_limit</th> <th>current_participant</th><th>semester</th></tr>";
    // output data of each row
    while($row = $result2->fetch_assoc()) {
        echo "<tr><td>" . $row["lecture_section"]. "</td><td>" . $row["course_name"]. "</td><td> " . $row["instructor_name"]. "</td><td> " . $row["course_credit"]. "</td><td> " . $row["participant_limit"]. "</td><td> " . $row["current_participant"]. "</td><td> "
        . $row["semester"]. "</td></tr>";
    }
    echo "</table>";
    echo "</br></br></br></br>";
} else {
    echo "0 results";
}
}
$sql = "SELECT * FROM semester_course WHERE semester";
$result = $conn->query($sql);
echo "</br></br></br>";
if ($result->num_rows > 0) {
    echo "<table><tr><th>lecture_section</th> <th>course_name</th> <th>instructor_name</th> <th>course_credit</th> <th>participant_limit</th> <th>current_participant</th><th>semester</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["lecture_section"]. "</td><td>" . $row["course_name"]. "</td><td> " . $row["instructor_name"]. "</td><td> " . $row["course_credit"]. "</td><td> " . $row["participant_limit"]. "</td><td> " . $row["current_participant"]. "</td><td> "
        . $row["semester"]. "</td></tr>";
    }
    echo "</table>";
    echo "</br></br></br></br>";
} else {
    echo "0 results";
}


if(@$_POST['course_name']!='' ){
 $course=$_POST['course_name'];
 $data="SELECT * from semester_course where course_name like '%$course%' ";
}
else if (@$_POST['lecture_section']!='' ) {
  $lecture=$_POST['lecture_section'];
  $data="SELECT * from semester_course where lecture_section like '%$lecture%' ";
}else if (@$_POST['button3']!='' ) {
  $data="SELECT * from semester_course where current_participant<participant_limit";
}
else{
 $data="SELECT * from semester_course";
}

?>




<html >
<link rel="stylesheet" href="search.css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>搜尋課表頁面</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>查詢課程名稱:
    <input name="course_name" type="text" placeholder="輸入查詢課程名稱" id="course_name"   />

    <input type="submit" name="button" id="button" value="搜尋課名" onclick="coursename($data)" />
    &nbsp;&nbsp;&nbsp;
     查詢課程時間:
        <input name="lecture_section" type="text" placeholder="輸入查詢課程時間" id="lecture_section"   />

        <input type="submit" name="button2" id="button2" value="搜尋課程時間"  />
      </br></br></br>
      <input type="submit" name="button3" id="button3" value="未滿的課程"  onclick="$a=1"/>
  </p>
</form>




<p></p>
<table class="TB_COLLAPSE">
<thead>
   <tr>
    <th>lecture_section</th>
    <th>course_name</th>
    <th>instructor_name</th>
    <th>course_credit</th>
    <th>participant_limit</th>
    <th>current_participant</th>
    <th>semester</th>
  </tr>
</thead>
  <?php
  $res=mysqli_query($conn,$data);
  for($i=1;$i<=mysqli_num_rows($res);$i++){
        $rs=mysqli_fetch_row($res);



  ?>

  <tr>
    <td><?php echo $rs[1]?></td>
    <td><?php echo $rs[2]?></td>
    <td><?php echo $rs[3]?></td>
    <td><?php echo $rs[4]?></td>
    <td><?php echo $rs[5]?></td>
    <td><?php echo $rs[6]?></td>
    <td><?php echo $rs[7]?></td>

  </tr>
  <?php
  }
  ?>


</table>
<p>&nbsp;</p>



</body>

</html>
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
