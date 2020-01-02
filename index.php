<?php
	require_once "inc/functions.php";
	//session_name('myApp');
	session_start();
	

$task = $_GET['task'] ?? "report";
$error = $_GET['error'] ?? "0";
$info = "";
if('edit' == $task)
{
	if(!hasPrivilege()){
		header("Location: index.php?task=report");
	}
}


if('seed' == $task)
{
	if(!isAdmin()){
		header("Location: index.php?task=report");
		return;
	}
	seed(DB_Name);
	$info = "Seeding is complete";
}

if('delete' == $task)
{
	if(!isAdmin()){
		header("Location: index.php?task=report");
		return;
	}
	$id = filter_input(INPUT_GET, 'id' , FILTER_SANITIZE_STRING);
	if($id){
		deleteStudent($id);
		header("Location: index.php?task=report");
	}
}

$fname = '';
$lname = '';
$roll = '';
if(isset($_POST['save']))
{
	$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING); 
	$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING); 
	$roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_STRING); 
	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING); 

	if($id){
		if($fname!= '' && $lname!='' && $roll!=''){
			$result = updateStudent($id, $fname, $lname, $roll);
			if($result){
			header("Location: index.php?task=report");
			}
			else{
				$error=1;
			}
			}
	}
	else{
		if($fname!= '' && $lname!='' && $roll!=''){
		$result = addStudent($fname,$lname,$roll);
		if($result){
			header("Location: index.php?task=report");
		}
		else{
			$error=1;
		}
	}
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
		<div class="column column-50 column-offset-25">
			<h1 style="text-align: center;">Crud Project</h1>
			<h4 style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</h4>
			<p> 
					<?php  include_once ("inc/template/nav.php"); ?>
					<hr>
					<?php 
						if($info!="")
							echo $info;
					 ?>
			</p>
			
		</div>
	</div>


	<?php if('1' == $error): ?>
	<div class="row">
		<div class="column column-60 column-offset-20">
			<blockquote>
				<div class="row" style="background: red;padding:10px 30px;color: white;">
					<b>Duplicate Roll Number</b>
				</div>
			</blockquote>
		</div>
	</div>
	<?php endif; ?>



	<?php if('report' == $task): ?>
	<div class="row">
		<div class="column column-60 column-offset-20">
			<?php generateReport(); ?>
		</div>
	</div>
	<?php endif; ?>


	

	<?php if('add' == $task): ?>
	<div class="row">
		<div class="column column-60 column-offset-20">
			<form action="index.php?task=add" method="POST">
				<label for="fname">First Name</label>
				<input type="text" name="fname" id="fname" value="<?php echo $fname ?>">
				<label for="lname">Last Name</label>
				<input type="text" name="lname" id="lname" value="<?php echo $lname ?>">
				<label for="roll">Roll</label>
				<input type="number" name="roll" id="roll" value="<?php echo $roll ?>">
				<button type="submit" class="button-primary" name="save">Save</button>
			</form>
		</div>
	</div>
	<?php endif; ?>


	<?php if('edit' == $task): 
		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
		$student = getStudent($id);
		if($student):
	?>
	<div class="row">
		<div class="column column-60 column-offset-20">
			<form method="POST">
				<input type="hidden" name="id" value="<?php echo $id ?>">
				<label for="fname">First Name</label>
				<input type="text" name="fname" id="fname" value="<?php echo  $student['fname']; ?>">
				<label for="lname">Last Name</label>
				<input type="text" name="lname" id="lname" value="<?php echo  $student['lname']; ?>">
				<label for="roll">Roll</label>
				<input type="number" name="roll" id="roll" value="<?php echo $student['roll']; ?>">
				<button type="submit" class="button-primary" name="save">Update</button>
			</form>
		</div>
	</div>
	<?php 
		endif;
		endif;
	 ?>
	


	



</div>

</body>
</html>