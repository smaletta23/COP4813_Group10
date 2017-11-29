<html>
<!-- 
The main page

Will contain a list of discussion boards and a link to login (if not loged in; else, logout)

url to each discussion boeard will be board.php?id=[insert board id here]
 -->
<head>
	<title>Main Page</title>
</head>
<body>
	
	
	<?php
		//Code for displaying discussion boards
		$config = parse_ini_file('/home/group10/database.ini');
		$conn = new mysqli('localhost', $config['username'], $config['password']);
		if($conn->connect_error){
			ie("Could not connect to database");
		}
		
		$qry = "SELECT * FROM group10.discussionBoards";
		
		$results = $conn->query($qry); //Since the query is static with no outside input, no need to prepare it
		
		if($results->num_rows > 0){
			echo "<table>";
			while($row = $results->fetch_assoc()){
				echo "<tr><td>";
				
				echo "<a href=\"board.php?id=" . $row['post_id'] . "\">"; 
				
				echo $row['name']; //Since users can't create discussion boards, the name doesn't need to be encoded
				
				echo "</a>";
				
				echo "</td></tr>";
			}
			
			echo "</table>";
		}
		
		$conn->close(); 
	?>
</body>
</html>