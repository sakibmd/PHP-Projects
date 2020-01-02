<?php
//session_name('myApp');
session_start();
$error = false;
//session_destroy();
$_SESSION['loggedin']=false;

$fp = fopen("data/users.txt", 'r');
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
if($username && $password ){
	$_SESSION['loggedin'] = false;
	$_SESSION['user'] = false;
	$_SESSION['role'] = false;
	while($data = fgetcsv($fp)){
		if( $data[0]==$username &&  $data[1]== md5($password) ){
			$_SESSION['loggedin'] = true;
			$_SESSION['user'] = $username;
			$_SESSION['role'] = $data[2];
			header('Location:index.php');
		}
	}
	if(!$_SESSION['loggedin']){
		$error = true;
	}
}

if(isset($_GET['logout'])){
	$_SESSION['loggedin'] = false;
	$_SESSION['user'] = false;
	$_SESSION['role'] = false;
	session_destroy();
	header('Location:index.php');
}

if(isset($_POST['save'])){
	if($username == "" && $password == ""){
		$error = true;
	}
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>My Template</title>
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.css">
	
</head>
<body>

<div class="container">
	<div class="row">
		<div class="column column-60 column-offset-20">
			<h1 style="text-align: center;">This is a simple Session Example</h1>
		</div>
	</div>


	<div class="row">
		<div class="column column-60 column-offset-20">
			<?php 
				if(true == $_SESSION['loggedin']){
					echo "Welcome Admin, How r you?";
				}
				else{
					echo "Welcome Stranger, Who r you?";
				}
			 ?>
		</div>
	</div>
	
	
	<div class="row">
		<div class="column column-60 column-offset-20">

			

			<?php if($_SESSION['loggedin'] == false): ?>
				<?php 
					if($error){
						echo "<blockquote>Invalid</blockquote>";
					}
				 ?>
			<form method="POST">
				<label for="username">Username</label>
				<input type="text" name="username" id="username"">
				<label for="password">Pass</label>
				<input type="password" name="password" id="password">
				<button type="submit" name="save">Login</button>
			</form>
			<?php else: ?>

			<form method="POST" action="index.php">
				<input type="hidden" name="logout" value="1">
				<button type="submit" name="logout">Logout</button>
			</form>

			<?php endif; ?>
		</div>
	</div>
	
	

</div>


</body>
</html>