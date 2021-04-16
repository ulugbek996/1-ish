<?php 
header('Access-Control-Allow-Origin: *');
$conn = mysqli_connect('localhost', 'admin_smart', 'admin_smart', 'admin_smart');
if(isset($_POST['IMEI'])){
    $daily=json_encode($_POST);
  $save = mysqli_query($conn,"INSERT INTO daynasos(data) VALUES ('$daily')");
  if(!$save){
        die(mysqli_error($conn));
  }else{
    echo 'OK##2';
  }
}

 ?>