<?php  

include('config.php');
include('helpers.php');

if(!login($_POST['email'], $_POST['password']))
{
	session(['error' => 'Invalid login details!']);
	header('Location: index.php');
	exit();
}
else
{
	header('Location: admin/index.php');
	exit();
}
?>