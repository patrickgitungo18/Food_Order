<?php 
	
	//include constants.php file here
	include ('../config/constants.php');
	
	//Check whether the id and image_name value is set or not
	if(isset($_GET['id']) AND isset($_GET['image_name']))
	{
		//Get the value and delete
		$id = $_GET['id'];
		$image_name = $_GET['image_name'];

		//Remove the physical image file if available
		if($image_name != "")
		{
			//image is available. So remove it
			$path = "../images/category/".$image_name;
			//Remove the image
			$remove = unlink($path);

			//If failed to remove image then add an error message and stop the process
			if($remove==false)
			{
				//Set the session message
				$_SESSION['remove'] = "<div class='error'>Failed to remove category image.</div>";
				//Redirect to Manage Category Page
				header ('location:'.SITEURL.'admin/manage-category.php');
				//Stop the process
				die();
			}

		}
		//Delete Data from Database
		//sql query delete data from database
		$sql = "DELETE FROM tbl_category WHERE id=$id";

		//Execute the query
		$res = mysqli_query($conn, $sql);

		//Check whether the data is delete from database or not
		if($res==TRUE)
		{
			$_SESSION['delete'] = "<div class='success'>Category deleted successfuly.</div>";
			//Redirect to Manage Category
			header ('location:'.SITEURL.'admin/manage-category.php');
		}
		else
		{
			//Set Fail Message and redirect
			$_SESSION['delete'] = "<div class='error'>Failed to delete Category!</div>";
			//Redirect to Manage Category
			header ('location:'.SITEURL.'admin/manage-category.php');
		}

	
	}
	else
	{
		//Redirect to Manage Category Page
		header ('location:'.SITEURL.'admin/manage-category.php');
	}

?>