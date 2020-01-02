<?php 

define("DB_Name", "C://xampp//htdocs//Hasin//Crud_Second//data//db.txt");
//session_name('myApp');
//session_start();

function seed($fileName)
{
	$students = array(
		array(
			'id' => 1,
			'fname' => 'Sakib',
			'lname' => 'Mohammed',
			'roll' => 42
		),
		array(
			'id' => 2,
			'fname' => 'Rakib',
			'lname' => 'Ali',
			'roll' => 70
		),
		array(
			'id' => 3,
			'fname' => 'Akash',
			'lname' => 'Kormokar',
			'roll' => 43
		),
		array(
			'id' => 4,
			'fname' => 'Salman',
			'lname' => 'Chy',
			'roll' => 44
		),
		array(
			'id' => 5,
			'fname' => 'Partho',
			'lname' => 'Borua',
			'roll' => 45
		)
	);

	$serislizedData = serialize($students);
	file_put_contents(DB_Name, $serislizedData);

}

function generateReport()
{
	$serislizedData = file_get_contents(DB_Name);
	$students = unserialize($serislizedData);
    ?>
    <table class="">
    	<tr>
    		<th>Name</th>
    		<th>Roll</th>
    		<?php if(isAdmin() || isEditor()): ?>
    			<th>Action</th>
    		<?php endif; ?>
    	</tr>
    	<?php foreach($students as $student){ ?>
    		<tr>
    			<td><?php  printf("%s %s", $student['fname'], $student['lname']);?></td>
    			<td><?php  printf("%s", $student['roll']);?></td>
    			<?php if(isAdmin()): ?>
    			<td width="25%"><?php  printf('<a href="index.php?task=edit&id=%s">Edit</a> | <a href="?task=delete&id=%s">Delete</a>', $student['id'], $student['id']);?></td>
    			<?php elseif(isEditor()): ?>
    				<td width="25%"><?php  printf('<a href="index.php?task=edit&id=%s">Edit</a>', $student['id']);?></td>
    			<?php endif; ?>
    		</tr>
    	<?php } ?>
    </table>



    <?php 

     

}	

function addStudent($fname, $lname, $roll)
{
	$found = false;
	$data = file_get_contents(DB_Name);
	$students=unserialize($data);
	foreach ($students as $_student) {
		if($_student['roll'] == $roll ){
			$found = true;
			break;
		}
	}
	if(!$found){
		$newId = generateNewIdforNewStudents($students);
		$student = array(
			'id' => $newId,
			'fname' => $fname,
			'lname' => $lname,
			'roll' => $roll
		);
		array_push($students, $student);
		$data = serialize($students);
		file_put_contents(DB_Name, $data);
		return true;
	}
	return false;
}

function getStudent($id){
	$data = file_get_contents(DB_Name);
	$students = unserialize($data);

	foreach ($students as $student) {
		if($student['id'] == $id ){
			return $student;
		}
	}
	return false;

	$serislizedData = serialize($students);
	file_put_contents(DB_Name, $serislizedData);
}


function updateStudent($id, $fname, $lname, $roll){
	$found = false;
	$data = file_get_contents(DB_Name);
	$students = unserialize($data);	
	foreach ($students as $student) {
		if($student['roll'] == $roll  && $student['id'] != $id ){
			$found = true;
			break;
		}
	}
	if(!$found){
		$students[$id-1]['fname'] = $fname;
		$students[$id-1]['lname'] = $lname;
		$students[$id-1]['roll'] = $roll;

		$serislizedData = serialize($students);
		file_put_contents(DB_Name, $serislizedData);
		return true;
	}
	return false;

}


function deleteStudent($id){
	$serializedData = file_get_contents(DB_Name);
	$students = unserialize($serializedData);

	
	foreach ($students as $offset => $student) {
		 if($student['id'] == $id){
		 	unset($students[$offset]);
		 }
	}

	$serializedData = serialize($students);
	file_put_contents(DB_Name, $serializedData);
}

function generateNewIdforNewStudents($students){
	$maxN = max(array_column($students, 'id'));
	return $maxN+1;
}

function isAdmin(){
	
	if('admin'== isset($_SESSION['role']))
	{
		return ('admin' == $_SESSION['role']);
	}
}
function isEditor(){
	if('editor'== isset($_SESSION['role']))
	{
		return ('editor' == $_SESSION['role']);
	}
}


function hasPrivilege(){
	return (isAdmin() || isEditor());
}






?>