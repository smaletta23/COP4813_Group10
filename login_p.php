<?php
	/* 
	This file will deal with the process of validating credentials 
	
	IMPORTANT NOTE/TO DO: Have not put in the database's user and pass yet for security.
		Best idea is to probably do that ini file thing shown in Sync Session 7
	
	Resourse on parameter binding/prepared statements to double check: 
	  https://www.w3schools.com/php/php_mysql_prepared_statements.asp
	  Don't remember my resource for actually using paramaterized select statements, but you do this:
		$comm->bind_result($col1, $col2, $col3, ...); //for every column included in the resulting table
		$comm->fetch(); //Once you bind the results, you use fetch to make the result vars display each column. 
		  //The first time will make them display the first column, so it must be used at least once. Params must be bound before using it at all. 
	
	Dependencies:
	  The login screen must name the username text box "username" 
	  and the password text box "password."
	  Login screen's form method must be "post"
	  
	  The database is group10, the table is accounts, and the fields used are username and password.
	  
	Variables in file:
	  $conn - The connection
	  $qry - the query made
	  $comm - the prepared command 
	  $user - Bound username variable
	  $pass - Bound password variable
	*/
	
	session_start(); 
	
	//Connect to database (securly, as shown in sync session 7)
	$conn = new mysqli("localhost", "", ""); //user and pass for database omited for now; Do the whole root ini thing for this later
	
	if($conn->connect_error){
		die("Could not connect to database to validate login");
	}
	
	//Make paramaterized query
	$qry = "SELECT username, COUNT(username) FROM group10.accounts WHERE username = ? AND password = ?;"; 
	$comm = conn->prepare($qry);
	
	//Get Parameters from login screen
	$user = $_POST['username'];
	$pass = $_POST['password'];
	
	//Bind Parameters
	$comm->bind_param("ss", $user, $pass); 
	
	//Execute 
	$comm->execute(); 
	
	//Binding results
	$comm->bind_result($baseUser, $cnt);
	
	//what is the result? 
	if($comm->fetch()){
		//Blank by intent; this means the query had at a result and the user and pass combo existed
	}
	else{
		//Back to login
		header("Location: login.php?error=1");
	}
	
	//what to do next and closing of the connection ?
	$_SESSION['username'] = $baseUser; 
	$comm->close();
	$conn->close(); 
	
	header("Location: index.php");
	
?>