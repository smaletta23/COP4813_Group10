<html>
<!-- 
This page will be for all of the discussion boards on the site. 
The parameter 'id' will distinguish which board is witch. 

When logged in, will give the user the option to post a comment (which will take the id of the ). 
When logged out, will provide a link to login instead. 

TO DO:
link to css sheet
make posting comment functionality 
link username and password of the database using method in sync session 7

Resourse on parameter binding/prepared statements to double check: 
  https://www.w3schools.com/php/php_mysql_prepared_statements.asp
  Don't remember my resource for actually using paramaterized select statements, but you do this:
	$comm->bind_result($col1, $col2, $col3, ...); //for every column included in the resulting table
	$comm->fetch(); //Once you bind the results, you use fetch to make the result vars display each column. 
	  //The first time will make them display the first column, so it must be used at least once. Params must be bound before using it at all.

Variables in the php code: 
	$qry - The query to execute
	$conn - The connection
	$id - The id of the discussion board to display
	$boardname - The name of the discussion board
	
	Bound Variables:
	$postid - The id of the post currently seen (to be put in id and name attributed)
	$user - The user who made the post
	$date - The datetime the post was made 
	$contents - The contents of the post 
-->
<head>
	<!-- CSS link here; title made inside php code -->
	<?php
		//Get url param 'id'
		$id = $_GET['id']; 
		
		//connect to database 
		$conn = new mysqli("localhost", "", ""); //user and pass for database omited for now; Do the whole root ini thing for this later
	
		if($conn->connect_error){
			die("Could not connect to database to validate login");
		}
		
		
		//Prepare and execute query for discussion board title
		$qry = "SELECT name FROM group10.discussionBoards WHERE board_id = ?;"; 
		$comm = conn->prepare($qry);
		
		$comm->bind_param("i", $id); 
	
		$comm->execute(); 
		$comm->bind_result($boardname);
		if($comm->fetch()){
			//do nothing
		}
		else{
			$boardname = "[nonexistent discussion board]";
		}
		
		
		//Set discussion board title and close header
		echo "<title>$boardname</title>"; //No need to encode here as users wil not be able to make their own discussion boards
		echo "</head>";
		
		
		//close prepared command and make/execute new one
		$comm->close(); 
		
		$qry = "SELECT post_id, made_by, made_on, contents FROM group10.posts WHERE board_id = ? ORDER BY made_on ASC;"; 
		  //How should we go about limiting the number of posts seen? No limit, can only see so many, or divided into pages? 
		  //If pages, how will we go about this?
		
		$comm = conn->prepare($qry);
		
		$comm->bind_param("i", $id); 
	
		$comm->execute(); 
		$comm->bind_result($postid, $user, $date, $contents);
		
		
		//Open body tag
		echo "<body>";
		
		//Display discussion board posts 
		while($comm->fetch()){
			echo "<div style=\"boarder:1px; padding:5px; margin:5px;\" name=\"$postid\" id=\"$postid\">";
			echo htmlentities($user) . " at " . $date . "<br/>";
			echo htmlentities($contents); 
			echo "</div><br/>"; 
		}
		
		
		//close everything
		$comm->close();
		$conn->close();
	?>
<!-- head tag closed and body tag opened in php code -->
</body>
</html>