<?php
	//Enviroment:
	//php 7.19
	//mysql 5.7.17
	//IIS 10.0
	
	/**
	*$content: IMEI=8630100303921xx&SIMN=&DID=00000000&TIME=00/00/00 10:20:01&auth=00001197&group=&PID=41&PTYPE=DUMP&CHAN=0,3&MDR0=1.00&MDS0=0&MDT0=1&MDR1=0.00&MDS1=0&MDT1=1&MDR2=0.00&MDS2=0&MDT2=1&MDR3=0.00&MDS3=0&MDT3=1
	*$flag: IMEI=
	*return: 8630100303921xx
	**/
	
	echo "hello<br>";
	function getValue($content,$flag){
		if(($pos = strpos($content,$flag))!==false){
			echo "hello 2";
			$pos += strlen($flag."=");
			$pos2 = strpos($content,"&",$pos);
			$pos2 = $pos2==false ? strlen($content) : $pos2;
			$value = substr($content,$pos,$pos2-$pos);
		}
		return $value;
	}
	
	//Delete all http data
	function delAllData($conn,$tName){
		$sql = "delete from ".$tName;
		mysqli_query($conn,$sql);
	}
	
	//insert one data
	function insertData($conn,$tName,$content){
		$sql = "insert into ".$tName." (temp) values (\"".$content."\")";
		mysqli_query($conn,$sql);
	}
	
	//database...
	$servername = "localhost";
	$username = "monitori_water";
	$password = "monitor70717071";
	$dbname = "monitori_water";
	$table_name = "test";
	
	//connect database
	$conn = mysqli_connect($servername, $username,$password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		echo "db connnect success <br>";
	}
	
	
	//character
	mysqli_query($conn,"set names 'utf8'"); 
	echo "line 54 pass <br>";
	//open database
	mysqli_select_db($conn,$mysql_database);
	echo "line 57 pass <br>";
	//create table if not exist
	$sql = "create table If Not Exists ".$table_name."(content text)";
	$result = mysqli_query($conn,$sql);
	echo "line 61 pass <br>";
	//delAllData($conn,$table_name);
	
	//query data
	$sql ="select * from ".$table_name;
	$result = mysqli_query($conn,$sql);
	echo "line 67 pass <br>";
	
	//show
	while($row = mysqli_fetch_array($result)){
		echo $row['content'] . "<br><br>";
	}
	
	
	//save new data to table
	if(!empty($_POST)){
		//get all post parameters
		echo "hello 1";
		$content = file_get_contents("php://input");
		$flag = "MDR0";
		$value = getValue($content,$flag);
		
		//save
		insertData($conn,$table_name,$content);
		if($value){
			insertData($conn,$table_name,$flag." is ".$value);
		}
	}else{
		echo "_post not work";
	}
	
	//close connect
	mysqli_close($conn);

?>
