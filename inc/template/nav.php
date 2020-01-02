
<?php 
//$_SESSION['loggedin'] = false;
 ?>

<div >
	<div style="float: left;">
		<p>
			<a href="/Hasin/Crud_Second/index.php?task=report"><b>All Students 
			<?php if(isAdmin() || isEditor()): ?>
				|</b></a>
				<a href="/Hasin/Crud_Second/index.php?task=add"><b> Add Student 
			<?php endif; ?>

			<?php if(isAdmin()): ?>
				|</b></a>
				<a href="index.php?task=seed"><b>Seed</b></a>
			<?php endif; ?>
		</p>
	</div>
	<div style="float: right;">
		<?php if(!isset($_SESSION['loggedin'])  ): ?>
			<a href="auth.php"><b>Login</b></a>
		<?php else: ?>
			<a href="auth.php?logout=true"><b>Logout (<?php echo $_SESSION['role']; ?>)</b></a>
		<?php endif; ?>
	</div>
</div>