<?php include ('partials/menu.php');?>
<div class="main-content">
	<div class="wrapper">

		<h1>Add Food</h1><br><br>
		<?php
		if (isset($_SESSION['upload']))
				{

					echo $_SESSION['upload']; 
					unset($_SESSION['upload']); 
				}
		?>

		<form action="" method="POST" enctype="multipart/form-data">

		<table class="tbl-30">
			<tr>
				<td>Title: </td>
				<td><input type="text" name="title" placeholder="Title of the Food"></td>
			</tr>
			<tr>
				<td>Description: </td>
				<td><textarea name="description" col="30" rows="5" placeholder="Description of the Food"></textarea></td>
			</tr>
			<tr>
				<td>Price: </td>
				<td><input type="number" name="price"></td>
			</tr>
			<tr>
				<td>Select Image: </td>
				<td><input type="file" name="image"></td>
			</tr>
			<tr>
				<td>Category: </td>
				<td><select name="category">
					<?php
						//Create PHP Code to display categories from database
					//1. Create SQL to get all active categories from database
					$sql ="SELECT * FROM tbl_category WHERE active='Yes'";
					//executing query
					$res = mysqli_query($conn, $sql);
					//Count Rows to check whther we have categories or not
					$count = mysqli_num_rows($res);
					
					//If count is greater than zero, we have categories else we do not have categories
					if($count>0)
					{
						//We have categories
						While($row=mysqli_fetch_assoc($res))
						{
							//get the details of categories
							$id = $row['id'];
							$title = $row['title'];

							?>
							<option value="<?php echo $id; ?>"><?php echo $title; ?></option>
							<?php
						}
					}
					else
					{
							//We do not have category
							?>
							<option value="0">No Category Found</option>
							<?php
					}
					//2. Display on Dropdown
					?>
					
				</select></td>
			</tr>
			<tr>
				<td>Featured: </td>
				<td>
				<input type="radio" name="featured" value="Yes">Yes
				<input type="radio" name="featured" value="No">No
				</td>
			</tr>

			<tr>
				<td>Active: </td>
				<td>
				<input type="radio" name="active" value="Yes">Yes
				<input type="radio" name="active"value="No">No
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="submit" value="Add Food" class="btn-success">
				</td>
			</tr>
		
		</table>
			
		</form>

		<?php

			//Check whether the button is clicked or not
		if(isset($_POST['submit']))
		{
			//Add the Food in Database
			//1. Get the data from Form
			$title = $_POST['title'];
			$description = $_POST['description'];
			$price = $_POST['price'];
			$category = $_POST['category'];

			//Check whether radio button for featured and active are checked or not
			if(isset($_POST['featured']))
			{
				$featured = $_POST['featured'];
			}
			else
			{
				$featured = "No";	//Setting the default value
			}

			if (isset($_POST['active']))
			{
				$active = $_POST['active'];
			}
			else
			{
				$active = "No"; //Default value
			}

			//2. Upload the image is selected
			//check whether the select image is clicked or not and upload the image only if the image is selected
			if(isset($_FILES['image']['name']))
			{
				//Get the details of the selected image
				$image_name = $_FILES['image']['name'];

				//check whether the image is selected or not and upload image only if selected
				if($image_name != "")
				{
					$title = $_POST['title'];
					//Image is selected
					//A. Rename the image
					//Get the extension of selected image (jpg,png,gif,etc.)
					$ext = end(explode('.', $image_name));

					//Create new name for image

					$image_name = $title."_".rand(000, 999).'.'.$ext; //e.g. Food_Category 834.jpg
					
					//B. Upload the image
					$src = $_FILES['image']['tmp_name'];
					$dst = "../images/Food/".$image_name;

					//Finally upload the image
					$upload = move_uploaded_file($src, $dst);
					
					//check whether the image is uploaded or not
					//and if the image is not uploaded then we will stop the process and redirect with error message
					
					if ($upload==false)
					{
						//Set message
						$_SESSION['upload'] = "<div class='error'>Failed to Upload Food Image.</div>";
						//Redirect to add Food page
						header ('location:'.SITEURL.'admin/add-food.php');
						//stop the process
						die ();
					}
				}

			}
			else
			{
				$image_name = ""; //Setting default value as blank
			}
			//3. Insert into database

			//Create a aql query to save or add food
			//For numerical value we do not need to pass value inside quotes '' but for string value it is compulsory
			$sql2 = "INSERT INTO tbl_food SET
				title = '$title',
				description = '$description',
				price = $price,
				image_name ='$image_name',
				category_id = $category,
				featured ='$featured',
				active ='$active'
				";
				//Execute the query
			$res2 = mysqli_query($conn, $sql2);
			//Check whether the data iserted or not
			//4. Redirect the message to manage food page
			if($res2 == true)
			{
				//Data inserted successfuly
				$_SESSION['add'] = "<div class='success'>Food Added Successfully!</div>";
				header ('location:'.SITEURL.'admin/manage-food.php');
			}
			else
			{
				//Failed to insert data
				$_SESSION['add'] = "<div class='error'>Failed to add food!</div>";
				header ('location:'.SITEURL.'admin/manage-food.php');
			}

			
		}
		?>


	</div>
</div>


<?php include ('partials/footer.php');?>
