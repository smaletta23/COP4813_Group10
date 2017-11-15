<html>
<!-- 
This is the login Screen

TO DO:
Link css file

Important Notes:
the username and password boxes are named as such
error being set in parameters will mean login failed
-->
<head>
	<title>Login</title>
</head>
<body>
	<?php session_start(); ?>
	<div>
		<h1>Login</h1>
		<form action="login_p.php" method="post">
			<!-- Note: the "placeholder" attribute will make the given term appear in the textbox itself until clicked on -->
			<p><input type="text" name="username" placeholder="username"></input></p>
			<p><input type="password" name="password" placeholder="password"></input></p>
			<input type = "submit">
		</form>

		<?php
			if(isset($_GET['error'])){
				echo "Login Failed";
			}
		?>
	</div>
</body>
</html>