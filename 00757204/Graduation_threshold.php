<html>
<link rel="stylesheet" href="Graduation_threshold.css">
<center>
        <body>
         <form action="畢業門檻.php" method="post">
		<br>
		<br>
		學號:<input type="text"name="no">
		</form>
        <form action="畢業門檻.php" method="get">
        <input type="submit" value="查詢">
 		</form>
        </body>
        <center>
  
  <html>
  <head>
<title>畢業門檻</title>
</head><body>
<?
$number=$_REQUEST["student_ID"];
?>

</body></html>
 <?php
    $user = 'root';//資料庫使用者名稱
	$password = '0424';//資料庫的密碼
	try{
		$db = new PDO('mysql:host=localhost;dbname=dbgroup14;charset=utf8',$user,$password);//開啟和MariaDB的連線
		//之後若要結束與資料庫的連線，則使用「$db = null;」
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//透過上述的db連線引出連線錯誤報告以及拋出exceptions異常
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
		}catch(PDOException $e){//若上述程式碼出現錯誤，便會執行以下動作
		Print "ERROR!:". $e->message();
		die();
		}
		
		
echo"當學期學分數"; 	
		echo"<table border='1'>
		<tr>
		<th>student_ID</th>
		<th>lecture_section</th>
		<th>course_name</th>
		<th>instructor_name</th>
		<th>course_credit</th>
		<th>semester</th>
		</tr>";
	   $query ="select * from student_schedule where student_ID=00665625";
	   $stmt =  $db->prepare($query);
	   $error= $stmt->execute();
	   $result = $stmt->fetchAll();
	   //以上寫法是為了防止「sql injection」
	  
	  $sum=0;
	for($i=0;$i<count($result);$i++){
	   echo "<tr>";
	   echo"<td>".$result[$i]['student_ID']."</td>";
	   
	   echo"<td>".$result[$i]['lecture_section']."</td>";
	   echo"<td>".$result[$i]['course_name']."</td>";
	   echo"<td>".$result[$i]['instructor_name']."</td>";
	   echo"<td>".$result[$i]['course_credit']."</td>";
	   $sum+=$result[$i]['course_credit'];
	   echo"<td>".$result[$i]['semester']."</td>";
	  echo"</tr>";
	 }
	 echo"</table>";

echo"歷年學分數"; 
		echo"<table border='1'>
		<tr>
		<th>student_ID</th>
		<th>department</th>
		<th>year</th>
		<th>class</th>
		<th>semester</th>
		<th>total_credits</th>
		<th>average_score</th>
		<th>rank</th>
		</tr>";
   $query2 ="select * from student_total_credits where student_ID=00665625";
   $stmt2 =  $db->prepare($query2);
   $error= $stmt2->execute();
   $result2 = $stmt2->fetchAll();
   
   for($j=0;$j<count($result2);$j++){
	   echo "<tr>";
	   echo"<td>".$result2[$j]['student_ID']."</td>";
	   echo"<td>".$result2[$j]['department']."</td>";
	   echo"<td>".$result2[$j]['year']."</td>";
	   echo"<td>".$result2[$j]['class']."</td>";
	   echo"<td>".$result2[$j]['semester']."</td>";
	   echo"<td>".$result2[$j]['total_credits']."</td>";
	   $sum+=$result2[$j]['total_credits'];
	   echo"<td>".$result2[$j]['average_score']."</td>";
	   echo"<td>".$result2[$j]['rank']."</td>";
	  echo"</tr>";
	 }
	echo"</table>";
	
	echo"總學分數:".$sum.'<br>';
	if($sum<135){
		echo"未達畢業學分數";
	}
	else
	    echo"已達畢業學分數";
	?>
 
  </body>
</html>