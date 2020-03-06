<?php
include("PDOConnection-kzan.php");

//Define some value
define("ACTION_ADD_USER", "add");
define("ACTION_LOGIN", "login");
define("RESULT_SUCCESS", 0);
define("RESULT_ERROR", 1);
define("RESULT_USER_EXISTS", 2);


$action = $_POST["action"];
$result = RESULT_ERROR;

if(isset($action))
{
	$username = $_POST["username"];
	$pwd = $_POST["password"];
	
	if(ACTION_ADD_USER == $action)
	{
		//Check exists user
		if(isExistUser($cnn, $username))
		{
			$result = RESULT_USER_EXISTS;
		}
		else
		{
			insertUser($cnn, $username, $pwd);
			$result = RESULT_SUCCESS;
		}
	}
	else //Action login
	{
		if(login($cnn, $username, $pwd))
		{
			$result = RESULT_SUCCESS;
			//Login success
		}
		else
		{
			//login fail
			$result = RESULT_ERROR;
		}
	}
}
//Print result as json
echo(json_encode(array('result' => $result)));

function insertUser($cnn, $username, $pwd)
{
	$query = "INSERT INTO kzan(shakwa_t, E_number,date_of_day) VALUES(?, ?,now())";
	$stmt = $cnn->prepare($query);
	$stmt->bindParam(1, $username);
	$stmt->bindParam(2, $pwd);
	$stmt->execute();
}
function isExistUser($cnn, $username)
{
	$query = "SELECT * FROM kzan WHERE shakwa_t = ?";
	$stmt = $cnn->prepare($query);
	$stmt->bindParam(1, $username);
	$stmt->execute();
	$rowcount = $stmt->rowCount();
	//for debug
	//var_dump($rowcount);
	return $rowcount;
}

function login($cnn, $username, $pwd)
{
	$query = "SELECT * FROM kzan WHERE shakwa_t = ? AND E_number = ?";
	$stmt = $cnn->prepare($query);
	$stmt->bindParam(1, $username);
	$stmt->bindParam(2, $pwd);
	$stmt->execute();
	$rowcount = $stmt->rowCount();
	//for debug
	//var_dump($rowcount);
	return $rowcount;
}
