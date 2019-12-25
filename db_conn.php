<?php
    $user='root';
    $password="123";
    try{
      $db = new
    PDO('mysql:host=localhost;dbname=databaseclass;charset=utf8',$user,$password);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    }catch(PDOException $e){//若上述程式碼出現錯誤，便會執行以下動作
      Print "ERROR!:". $e->message();
      die();
    }
?>
