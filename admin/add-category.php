<?php include ('partials/menu.php'); ?>
	
<div class="main-content">
		<div class="wrapper">
			<h1>Add Category</h1> <br><br>
			<?php
			if (isset($_SESSION['add']))
				{

					echo $_SESSION['add']; 
					unset($_SESSION['add']); 
				}

			if (isset($_SESSION['upload']))
				{

					echo $_SESSION['upload']; 
					unset($_SESSION['upload']); 
				}
			?>
			<br><br>
			<!--Add Category form Starts -->
			<form action="" method="POST" enctype="multipart/form-data">
			
			<table class="table-30">
				<tr>
					<td>Title:</td>
					<td><input type="text" name="title" placeholder="Category Title"></td>
				</tr>
				<tr>
					<td>Select Image:</td>
					<td>
						<input type="file" name="image">
					</td>
				</tr>
				<tr>
					<td>Featured:</td>
					<td>
						<input type="radio" name="featured" value="Yes"> Yes
						<input type="radio" name="featured" value="No">	No
					</td>
				</tr>
				<tr>
					<td>Active:</td>
					<td>
						<input type="radio" name="active" value="Yes"> Yes
						<input type="radio" name="active" value="No"> No
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="Add Category" class="btn-success">
					</td>
					
				</tr>
			</table>


		</form>
			<!--Add Category form Ends-->
		<?php

		//check whether the submit button is clicked or not

	if(isset($_POST['submit']))
	{
		//1. Get the value from category form
		$title = $_POST['title'];

		//for radio input, we need to check whether the button is selected or not
		if (isset($_POST['featured']))
		{
			//Get the value from form
			$featured = $_POST['featured'];
		}
		else
		{
			//set the deffault value
			$featured = "No";
		}

		if (isset($_POST['active']))
		{
			//Get the value from form
			$active = $_POST['active'];
		}
		else
		{
			//set the deffault value
			$active = "No";
		}

		//check whether the image is selected or not and inser the value for image name accordingly
		
		if (isset($_FILES['image']['name'])) 
		{
			$title = $_POST['title'];
			//upload the image
			//To upload image, we need image name, source path and destination path
			$image_name = $_FILES['image']['name'];

			//Upload image only if image is selected
			if($image_name != "")
			{
				//auto rename our image
				//Get the exension of our image (jpg, png, gif, etc) e.g. "food1.jpg"
				$ext = end(explode('.', $image_name));

				//Rename the image
				$image_name = $title."_".rand(000, 999).'.'.$ext; //e.g. Food_Category 834.jpg
				

				$source_path = $_FILES['image']['tmp_name'];
				$destination_path = "../images/category/".$image_name;

				//Finally upload the image
				$upload = move_uploaded_file($source_path, $destination_path);
				
				//check whether the image is uploaded or not
				//and if the image is not uploaded then we will stop the process and redirect with error message
				
				if ($upload==false)
				{
					//Set message
					$_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
					//Redirect to add category page
					header ('location:'.SITEURL.'admin/add-category.php');
					//stop the process
					die ();
				}
			}
		}
		else
		{
			//dont upload image and set the image_name value as blank
			$image_name="";
		}

		//2. Include SQL Query to insert category into database
		$sql = "INSERT INTO tbl_category SET
				title = '$title',
				image_name ='$image_name',
				featured = '$featured',
				active = '$active'
				";

		//3. Execute the Query and save in database
				$res = mysqli_query($conn, $sql);

		//4. Check whether the query excecuted or not and data added or not
				if ($res==TRUE)
				{
					//Query executed and Category added
					$_SESSION['add'] = "<div class='success'>Category Added Successfuly!</div>";

					//Redirect to Manage Category page
					header ('location:'.SITEURL.'admin/manage-category.php');

				}
				else
				{
					//Fail to add category
					$_SESSION['add'] = "<div class='error'>Failed to add Category!</div>";

					//Redirect to Manage Category page
					header ('location:'.SITEURL.'admin/add-category.php');



				}

	}

	?>
	</div>
</div>


<?php include ('partials/footer.php'); ?>