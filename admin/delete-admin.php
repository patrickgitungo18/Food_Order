<?php 
	
	//include constants.php file here
	include ('../config/constants.php');
	//1. Get the ID of Admin to be Deteted
	$id = $_GET['id'];

	//2. Create SQL Query to Delete Admin
	$sql = "DELETE FROM tbl_admin WHERE id=$id";

	//Execute the Query
	$res = mysqli_query($conn, $sql);

	//Check whether the query executed successfully or not
	If ($res==TRUE)
	{
		//Query Executed successfully and Admin Deleted
		//Create Session variable to display message
		$_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully!</div>";
		//Redirect to Manage Admin Page
		header ('location:'.SITEURL.'admin/manage-admin.php');

	}else{
		//Failed to Delete Admin
		$_SESSION['delete'] = "<div class='error'>Failed to delete Admin!</div>";
		//Redirect to Manage Admin Page
		header ('location:'.SITEURL.'admin/manage-admin.php');
	}


	//3. Redirect to Manage Admin Page with Message (Success/Error)

?>